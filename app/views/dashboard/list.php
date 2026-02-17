<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/dashboard.css">
<?php
/**
 * TABLEAU DE BORD DES SINISTRÉS
 * Vue pour FlightPHP - Tableau par ville
 */

$totalSinistres = 156;
$totalVilles = count($ressource_lib);
$totalMontant = 0;
$totalDons = 0;

foreach ($ressource_lib as $villeData) {
    $totalMontant += $villeData['total_montant'] ?? 0;
    $totalDons += count($villeData['besoins'] ?? []);
}
?>

<header class="header">
    <div class="header-content">
        <h1>Tableau de Bord des Sinistrés</h1>
        <p>Suivi des besoins et distribution des dons</p>
    </div>
    <div class="stats-grid">
        <div class="stat">
            <div class="stat-value"><?= $totalSinistres ?></div>
            <div class="stat-label">Sinistrés</div>
        </div>
        <div class="stat">
            <div class="stat-value"><?= $totalVilles ?></div>
            <div class="stat-label">Villes</div>
        </div>
        <div class="stat">
            <div class="stat-value"><?= $totalDons ?></div>
            <div class="stat-label">Dons</div>
        </div>
        <div class="stat">
            <div class="stat-value">€<?= number_format($totalMontant, 0) ?></div>
            <div class="stat-label">Montant Total</div>
        </div>
    </div>
</header>

<div class="dashboard-container">
    <div class="dashboard-toolbar">
        <input 
            type="text" 
            id="searchInput"
            placeholder="Rechercher..." 
            onkeyup="filterTable(this.value)"
        >
        <button onclick="printTable()" class="btn-print">
            Imprimer
        </button>
    </div>

    <?php foreach ($ressource_lib as $ville => $villeData): ?>
        <?php if (!empty($villeData['besoins'])): ?>
            <div class="ville-section">
                <div class="ville-header">
                    <h2><?= htmlspecialchars($ville) ?></h2>
                    <div class="ville-summary">
                        <div class="summary-item">
                            <span class="summary-label">Total reçu</span>
                            <span class="summary-value"><?= $villeData['total_quantite'] ?? 0 ?> unités</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Montant</span>
                            <span class="summary-value">€<?= number_format($villeData['total_montant'] ?? 0, 0) ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Dernier don</span>
                            <span class="summary-value"><?= $villeData['derniere_date'] ? date('d/m/y', strtotime($villeData['derniere_date'])) : '–' ?></span>
                        </div>
                    </div>
                </div>

                <table class="data-table ville-table">
                    <thead>
                        <tr>
                            <th>Ressource</th>
                            <th>Type</th>
                            <th>Prix Unit.</th>
                            <th>Quantité</th>
                            <th>Montant</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($villeData['besoins'] as $don): ?>
                            <tr>
                                <td><?= htmlspecialchars($don['nom_ressource']) ?></td>
                                <td><span class="badge badge-<?= strtolower(str_replace(' ','-',$don['type_ressource'])) ?>"><?= htmlspecialchars($don['type_ressource']) ?></span></td>
                                <td class="align-right">€<?= number_format($don['prixUnitaire'], 2, ',', ' ') ?></td>
                                <td class="align-center"><?= $don['quantite_don'] ?? 0 ?></td>
                                <td class="amount">€<?= number_format(($don['quantite_don'] ?? 0) * ($don['prixUnitaire'] ?? 0), 0) ?></td>
                                <td class="date"><?= date('d/m/y', strtotime($don['date_don'] ?? 'now')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>