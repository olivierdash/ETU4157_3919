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
                <div class="group" >
                    <label>Ville</label>
                    <select  id="villeSelect">
                        <option value="">Sélectionner une ville</option>
                        <?php foreach($ville as $v): ?>
                            <option value="<?= $v['id'] ?>"><?= $v['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="group">
                    <label>Type de ressource</label>
                    <div class="types">
                        <div class="type" data-type="nature">
                            <svg viewBox="0 0 24 24" fill="#22c55e">
                                <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z" />
                            </svg>
                            <span>Nature</span>
                        </div>
                        <div class="type" data-type="materiaux">
                            <svg viewBox="0 0 24 24" fill="#f97316">
                                <path d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z" />
                            </svg>
                            <span>Matériaux</span>
                        </div>
                        <div class="type" data-type="argent">
                            <svg viewBox="0 0 24 24" fill="#eab308">
                                <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,17V16H9V14H13V13H10A1,1 0 0,1 9,12V10A1,1 0 0,1 10,9H11V8H13V9H15V11H11V12H14A1,1 0 0,1 15,13V15A1,1 0 0,1 14,16H13V17H11Z" />
                            </svg>
                            <span>Argent</span>
                        </div>
                        <div class="type" data-type="autres">
                            <svg viewBox="0 0 24 24" fill="#ef4444">
                                <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
                            </svg>
                            <span>Autres</span>
                        </div>
                    </div>
                </div>

                <div class="group" id="ressources-group">
                    <label>Ressource</label>
                    <select id="ressource" name="ressource_id">
                        <option value="">Sélectionner une ressource</option>
                    </select>
                    <div class="autres-input" id="autres-input">
                        <input type="text" id="cName" placeholder="Nom de la ressource">
                        <textarea id="cDesc" rows="2" placeholder="Description (optionnel)"></textarea>
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
                        <input type="text" id="dName" placeholder="Nom">
                        <input type="email" id="dEmail" placeholder="Email">
                    </div>
                    <input type="text" class="full" id="dMsg" placeholder="Message">
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