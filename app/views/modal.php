<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles2.css">
</head>

<body>
    <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
        <span></span>
    </button>

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
                            <span>Saisie de dons</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/recap" class="nav-link">
                            <span class="nav-icon"></span>
                            <span>Resulats</span>
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
                        <div class="btn"
                            style="background-color: greenyellow; color: black; border-radius: 5px; padding: 5px 10px;">
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
    <main class="container" style="margin-left: 280px;">
        <?= $content ?>
    </main>
    <script nonce="<?= Flight::get('csp_nonce') ?>" src="<?= BASE_URL ?>/assets/js/dashboard.js">

    </script>
</body>

</html>