<?php

namespace app\controllers;

use app\models\ResourceDispatcher;
use Flight;

class DispatchController
{
    /**
     * Affiche le formulaire de sélection du mode de dispatch
     */
    public function showDispatchForm()
    {
        Flight::render('dispatch/form', [], 'content');
        Flight::render('modal');
    }

    /**
     * Récupère les résultats du dispatch pour un mode spécifique
     */
    public function getDispatch()
    {
        $mode = Flight::request()->query['mode'] ?? 'fifo';
        
        // Validation du mode
        $valid_modes = ['fifo', 'date', 'quantity', 'proportionality'];
        if (!in_array($mode, $valid_modes)) {
            Flight::json(['error' => 'Mode de dispatch invalide'], 400);
            return;
        }

        $dispatcher = new ResourceDispatcher();
        $results = $dispatcher->getDispatchByMode($mode);

        Flight::json($results, 200);
    }

    /**
     * Affiche les résultats du dispatch
     */
    public function showDispatch()
    {
        $mode = Flight::request()->query['mode'] ?? 'fifo';
        
        // Validation du mode
        $valid_modes = ['fifo', 'date', 'quantity', 'proportionality'];
        if (!in_array($mode, $valid_modes)) {
            Flight::halt(400, 'Mode de dispatch invalide');
            return;
        }

        $dispatcher = new ResourceDispatcher();
        $results = $dispatcher->getDispatchByMode($mode);

        // Préparer les données pour la vue
        $modeLabels = [
            'fifo' => 'Dispatch par Date (FIFO)',
            'date' => 'Dispatch par Date (FIFO)',
            'quantity' => 'Dispatch par Quantité',
            'proportionality' => 'Dispatch par Proportionnalité'
        ];

        $data = [
            'mode' => $mode,
            'mode_label' => $modeLabels[$mode],
            'results' => $results
        ];

        Flight::render('dispatch/results', $data, 'content');
        Flight::render('modal');
    }

    /**
     * Affiche un comparatif des 3 modes
     */
    public function showComparative()
    {
        $dispatcher = new ResourceDispatcher();
        $results = $dispatcher->getComparativeDispatch();

        $data = [
            'comparatif' => $results
        ];

        Flight::render('dispatch/comparative', $data, 'content');
        Flight::render('modal');
    }

    /**
     * Retourne un comparatif en JSON
     */
    public function getComparative()
    {
        $dispatcher = new ResourceDispatcher();
        $results = $dispatcher->getComparativeDispatch();

        Flight::json($results, 200);
    }
}
?>
