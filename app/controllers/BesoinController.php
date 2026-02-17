<?php
namespace app\controllers;

use app\models\Besoin;
use Flight;

class BesoinController
{
    private $besoinModel;

    public function __construct()
    {
        $this->besoinModel = new Besoin();
    }

    /**
     * Affiche la page de gestion des besoins et achats
     */
    public function showAchatPage()
    {
        $besoins = $this->besoinModel->getBesoinsAvecProgression();
        $argent_disponible = $this->besoinModel->getArgentDisponible();
        
        Flight::render('collect/achats', compact('besoins', 'argent_disponible'), 'content');
        Flight::render('modal');
    }

    /**
     * API : Effectuer un achat de ressource
     * POST /acheter-ressource
     * JSON: { besoin_id, quantite_achat }
     */
    public function acheterRessource()
    {
        header('Content-Type: application/json');

        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $besoin_id = $data['besoin_id'] ?? null;
            $quantite_achat = $data['quantite_achat'] ?? null;

            if (!$besoin_id || !$quantite_achat || $quantite_achat <= 0) {
                throw new \Exception("Paramètres invalides");
            }

            // ========== ÉTAPE 1 : Récupérer le besoin ==========
            $besoin = $this->besoinModel->getBesoinById($besoin_id);
            if (!$besoin) {
                throw new \Exception("Besoin non trouvé");
            }

            // ========== ÉTAPE 2 : Vérifier la quantité restante ==========
            $quantite_distribuee = $this->besoinModel->getQuantiteDistribueeForBesoin(
                $besoin['id_ressource'],
                $besoin['ville_id']
            );
            $quantite_restante = $besoin['quantite'] - $quantite_distribuee;

            if ($quantite_achat > $quantite_restante) {
                throw new \Exception("Quantité insuffisante. Restant: " . $quantite_restante);
            }

            // ========== ÉTAPE 3 : Vérifier l'argent disponible ==========
            $argent = $this->besoinModel->getArgentDisponible();
            $cout_achat = $quantite_achat * $besoin['prixUnitaire'];

            if ($cout_achat > $argent['disponible']) {
                throw new \Exception("Argent insuffisant. Disponible: €" . number_format($argent['disponible'], 2));
            }

            // ========== ÉTAPE 4 : Créer/Récupérer la distribution du jour ==========
            $distribution_id = $this->besoinModel->getOrCreateDistributionDuJour($besoin['ville_id']);

            // ========== ÉTAPE 5 : Ajouter/Mettre à jour la distribution ==========
            $this->besoinModel->addOrUpdateDistributionDetail(
                $distribution_id,
                $besoin['id_ressource'],
                $quantite_achat
            );

            // ========== ÉTAPE 6 : Calculer les nouvelles valeurs ==========
            $nouvelle_quantite_distribuee = $quantite_distribuee + $quantite_achat;
            $nouvelle_quantite_restante = $besoin['quantite'] - $nouvelle_quantite_distribuee;
            $nouveau_pourcentage = round(($nouvelle_quantite_distribuee * 100.0 / $besoin['quantite']), 1);

            // ========== ÉTAPE 7 : Retourner la réponse ==========
            echo json_encode([
                'success' => true,
                'message' => 'Achat réussi !',
                'data' => [
                    'quantite_distribuee' => $nouvelle_quantite_distribuee,
                    'quantite_restante' => $nouvelle_quantite_restante,
                    'pourcentage_comble' => $nouveau_pourcentage,
                    'cout_achat' => number_format($cout_achat, 2),
                    'argent_restant' => number_format($argent['disponible'] - $cout_achat, 2)
                ]
            ]);

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}