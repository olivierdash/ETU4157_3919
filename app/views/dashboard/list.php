<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/dashboard.css">
<header class="main-header">
    <h1>Tableau de Bord des Sinistrés</h1>
    <p>Suivi des besoins et distribution des dons - Février 2026</p>
    <!-- Stats rapides -->
    <div class="header-stats">
        <div class="stat-item">
            <span class="stat-value"><?= $count_ville ?></span>
            <span class="stat-label">Villes</span>
        </div>
        <div class="stat-item">
            <span class="stat-value"><?= $countDons ?></span>
            <span class="stat-label">Dons</span>
        </div>
    </div>
</header>
<div class="dashboard-container">
    <?php foreach ($ressource_lib as $villeNom => $villeData): ?>
        <div class="ville-section">
            <div class="ville-header">
                <h2><?= htmlspecialchars($villeNom) ?></h2>
            </div>

            <h3>Besoins Identifiés</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Ressource</th>
                        <th>Quantité Demandée</th>
                        <th>Prix Unitaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($villeData['besoins_sinistres'] as $besoin): ?>
                        <tr>
                            <td><?= htmlspecialchars($besoin['nom_ressource']) ?></td>
                            <td><?= $besoin['quantite_restante'] ?></td>
                            <td>€<?= number_format($besoin['prixUnitaire'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Dons Attribués</h3>
            <table class="data-table ville-table">
                <thead>
                    <tr>
                        <th>Ressource</th>
                        <th>Quantité Donnée</th>
                        <th>Montant</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($villeData['dons_recus'] as $don): ?>
                        <tr>
                            <td><?= htmlspecialchars($don['nom_ressource']) ?></td>
                            <td><?= $don['quantite_don'] ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/dons/annuler/<?= $don['id_don'] ?>"
                                    onclick="return confirm('Voulez-vous vraiment annuler ce don ?')" class="btn-annuler">
                                    Annuler
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>