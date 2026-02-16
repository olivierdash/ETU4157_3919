<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Varotra - Boutique en ligne</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <a href="/" class="logo">E-Varotra</a>
            <nav class="menu">
                <a href="/">Accueil</a>
                <a href="/form">+ Ajouter</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="page-header">
                <h1>E-Varotra</h1>
                <p class="page-subtitle">Découvrez nos produits de qualité</p>
            </div>

            <!-- Section produits (exemple avec données statiques) -->
            <section class="product-list">
                <!-- Carte 4 -->
                <?php foreach($products as $pro): ?>
                    
                    <article class="product-card">
                    <a href="#" class="product-image-wrapper">
                        <img src="/assets/css/images/<?= $pro->getImage()?>" alt="<?= $pro->getAlt() ?>">
                    </a>
                    <div class="product-info">
                        <h2 class="product-title">
                            <a href="#"><?= $pro->getName() ?></a>
                        </h2>
                        <p class="product-description">...</p>
                        <div class="product-price"><?= $pro->getPrice() ?></div>
                        <div class="product-actions">
                            <a href="/form/<?= $pro->getId() ?>" class="btn-edit">Modifier</a>
                            <button class="btn-delete" onclick="alert('Suppression confirmée')">Supprimer</button>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </section>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 E-Varotra - Tous droits réservés</p>
    </footer>
</body>
</html>