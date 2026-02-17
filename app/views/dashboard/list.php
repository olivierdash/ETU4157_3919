<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BNGRC - Suivi des Collectes</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles2.css">
</head>

<body>
    <!-- Menu Toggle Mobile -->
    <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
        <span></span>
    </button>

    <!-- Overlay Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <a href="<?= BASE_URL ?>" class="brand-logo">
                <div class="logo-icon">BN</div>
                <div class="brand-text">
                    <span class="brand-name">BNGRC</span>
                    <span class="brand-subtitle">Gestion Humanitaire</span>
                </div>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <!-- Section Principale -->
            <div class="nav-section">
                <h4 class="nav-section-title">Menu Principal</h4>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/dashboard" class="nav-link active">
                            <span class="nav-icon">📊</span>
                            <span>Tableau de Bord</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/collectes" class="nav-link">
                            <span class="nav-icon">🎁</span>
                            <span>Dons</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/collectes" class="nav-link">
                            <span class="nav-icon">🎁</span>
                            <span>Saisie de collectes</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Section Gestion -->
            <div class="nav-section">
                <h4 class="nav-section-title">Gestion</h4>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/villes" class="nav-link">
                            <span class="nav-icon">🏙️</span>
                            <span>Villes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/ressources" class="nav-link">
                            <span class="nav-icon">📋</span>
                            <span>Ressources</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <div class="btn" style="background-color: greenyellow; color: black; border-radius: 5px; padding: 5px 10px;">
                            <a href="<?= BASE_URL ?>/simulation" class="nav-link">
                                <span class="nav-icon">⚙️</span>
                                <span>Simulation</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Header Principal -->
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

        <!-- Contenu Principal -->
        <main class="container">
            <div class="dashboard-grid">
                <?php foreach ($ressource_lib as $row): ?>
                    <article class="city-card">
                        <div class="card-header">
                            <h2><?= $row['nom_ville']; ?></h2>
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
                                        <?php foreach ($row['besoins'] as $ligne): ?>
                                            <tr>
                                                <td><?= $ligne['nom'] ?></td>
                                                <td>
                                                    <span
                                                        class="badge <?= strtolower($ligne['type_ressource']) === 'materiel' ? 'mat' : 'fin' ?>">
                                                        <?= $ligne['type_ressource']; ?>
                                                    </span>
                                                </td>
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
                                            <span class="qty"><?= $row['dons']; ?>     <?= $row['besoins'][0]['nom']; ?></span>
                                            <span class="date">Reçu le: <?= $row['besoins'][0]['date_don'] ?></span>
                                        </div>
                                    </li>
                                </ul>
                            </section>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <!-- Script pour le menu mobile -->
    <script nonce="<?= Flight::get('csp_nonce') ?>">
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            menuToggle.classList.remove('active');
        });
    </script>
</body>

</html>