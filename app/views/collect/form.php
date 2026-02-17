<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire un Don</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style_collect.css">

    <script nonce="<?= Flight::get('csp_nonce') ?>" src="<?= BASE_URL ?>/assets/js/collec.js" defer>
    </script>
</head>

<body>
    <div class="wrap">
        <div class="hero">
            <div class="heart">
                <svg viewBox="0 0 24 24">
                    <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
                </svg>
            </div>
            <h1>Faire un <span>Don</span></h1>
            <p>Chaque geste compte</p>
        </div>

        <form class="form" id="form" method="POST" action="collectes/insert">
            <div class="form-inner">
                <div class="group">
                    <label for="villeSelect">Ville</label>
                    <select id="villeSelect" name="ville_id">
                        <option value="">Sélectionner une ville</option>
                        <?php foreach($ville as $v): ?>
                            <option value="<?= $v['id'] ?>"><?= $v['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="group">
                    <label for="typeRessource">Type de ressource</label>
                    <select id="typeRessource" name="type_ressource">
                        <option value="">Choisir un type...</option>
                        <?php foreach($types as $t): ?>
                            <option value="<?= $t['id'] ?>"><?= $t['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="group" id="ressources-group">
                    <label for="ressource">Ressource</label>
                    <select id="ressource" name="ressource_id">
                        <option value="">Sélectionner une ressource</option>
                    </select>
                    <div class="autres-input" id="autres-input" style="display: none;">
                        <input type="text" id="cName" name="custom_resource_name" placeholder="Nom de la ressource">
                        <textarea id="cDesc" name="custom_resource_desc" rows="2" placeholder="Description (optionnel)"></textarea>
                    </div>
                </div>

                <div class="group">
                    <label>Quantité</label>
                    <div class="qty-wrap">
                        <div class="qty">
                            <button type="button" id="q-">−</button>
                            <input type="number" id="qty" value="1" min="1" name="quantite">
                            <button type="button" id="q+">+</button>
                        </div>
                        <div class="est">
                            <div class="est-label">Estimation</div>
                            <div class="est-val" id="val">0,00 €</div>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label>Infos (optionnel)</label>
                    <div class="donor">
                        <input type="text" id="dName" name="donor_name" placeholder="Nom">
                        <input type="email" id="dEmail" name="donor_email" placeholder="Email">
                    </div>
                    <input type="text" class="full" id="dMsg" name="donor_message" placeholder="Message">
                </div>
            </div>

            <div class="submit-wrap">
                <button type="submit" class="submit">
                    <svg viewBox="0 0 24 24">
                        <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
                    </svg>
                    Faire mon don
                </button>
            </div>
        </form>
    </div>

    <div class="modal" id="modal">
        <div class="modal-box">
            <div class="modal-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                </svg>
            </div>
            <h2>Merci !</h2>
            <p>Votre don va aider.</p>
            <div class="modal-details" id="det"></div>
            <button class="new-btn" id="newBtn">Nouveau don</button>
        </div>
    </div>
</body>
</html>