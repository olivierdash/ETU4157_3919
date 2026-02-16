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
            <?php foreach($ressource_lib as $row): ?>
                <article class="city-card">
                <div class="card-header">
                    <h2><?= $row['nom_ville']; ?></h2>
                    <span class="city-id">ID: 2</span>
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
                                <?php foreach($row['besoins'] as $ligne): ?>
                                    <tr>
                                        <td><?= $ligne['nom'] ?></td>
                                        <td><span class="badge mat"><?= $ligne['type_ressource']; ?></span></td>
                                        <td><?= $ligne['prixUnitaire'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
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