<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BNGRC - Suivi des Collectes</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css">
</head>

<body>
    <header class="main-header">
        <h1>Tableau de Bord des Sinistrés</h1>
        <p>Suivi des besoins et distribution des dons - Février 2026</p>
    </header>

    <main class="container">
        <div class="dashboard-grid">
            <?php foreach ($villes as $ville): ?>
                <article class="city-card">
                    <div class="card-header">
                        <h2><?= $ville['nom'] ?></h2>
                        <span class="city-id">ID: <?= $ville['id'] ?></span>
                    </div>

                    <div class="card-body">
                        <section class="section-besoins">
                            <h3>Besoins (Ressources)</h3>
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Type</th>
                                        <th>P.U.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sac de Ciment 25kg</td>
                                        <td><span class="badge mat">Matériaux</span></td>
                                        <td>8.50 Ar</td>
                                    </tr>
                                    <tr>
                                        <td>Briques (palette)</td>
                                        <td><span class="badge mat">Matériaux</span></td>
                                        <td>120.00 Ar</td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>

                        <section class="section-dons">
                            <h3>Dons Attribués</h3>
                            <ul class="donation-list">
                                <li>
                                    <div class="donation-info">
                                        <span class="qty">50 unités</span>
                                        <span class="date">Reçu le: 05/03/2024</span>
                                    </div>
                                </li>
                            </ul>
                        </section>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>