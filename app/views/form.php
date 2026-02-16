<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Produit</title>
  <link rel="stylesheet" href="/assets/css/product.css">
    
</head>
<body>
    <!-- NAVBAR -->
    <nav>
        <div class="container">
            <div class="logo">🛍️ ShopHub</div>
            <div>
                <a href="/">Accueil</a>
                <a href="/form">Ajouter Produit</a>
            </div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <div class="page-container">
        <div class="form-wrapper">
            <div class="form-header">
                <h1><?= isset($product) ? '✏️ Modifier' : '➕ Ajouter' ?> un Produit</h1>
                <p><?= isset($product) ? 'Mettez à jour les informations du produit' : 'Créez un nouveau produit' ?></p>
            </div>

            <form method="POST" action="<?= isset($product) ? '/product/edit' : '/product/insert' ?>" enctype="multipart/form-data">
                <?php if(isset($product)): ?>
                    <input type="hidden" name="id" value="<?= $product->getId() ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="name">Nom du produit</label>
                    <input type="text" id="name" name="name" value="<?= isset($product) ? $product->getName() : '' ?>" placeholder="Ex: Laptop Pro 2024" required>
                </div>

                <div class="form-group">
                    <label for="alt">Texte alternatif</label>
                    <input type="text" id="alt" name="alt" value="<?= isset($product) ? $product->getAlt() : '' ?>" placeholder="Description pour l'accessibilité" required>
                </div>

                <div class="form-group">
                    <label for="price">Prix (€)</label>
                    <input type="number" id="price" step="0.01" name="price" value="<?= isset($product) ? $product->getPrice() : '' ?>" placeholder="Ex: 999.99" required>
                </div>

                <div class="form-group">
                    <label for="image">URL de l'image</label>
                    <input type="text" id="image" name="image" value="<?= isset($product) ? $product->getImage() : '' ?>" placeholder="Ex: https://example.com/image.jpg" required>
                </div>

                <div class="form-group">
                    <label for="file_image">Ou télécharger une image</label>
                    <input type="file" id="file_image" name="file_image" accept="image/*">
                </div>

                <div class="button-group">
                    <button type="submit"><?= isset($product) ? '✓ Modifier' : '➕ Ajouter' ?></button>
                    <a href="/" class="btn-cancel">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>