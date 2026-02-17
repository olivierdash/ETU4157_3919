<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire un Don</title>
      <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style_collect.css">
</head>

<body>
    <!-- Decorative leaves -->
    <svg class="deco-leaf leaf-1" width="80" height="80" viewBox="0 0 24 24" fill="#22c55e">
        <path
            d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z" />
    </svg>
    <svg class="deco-leaf leaf-2" width="60" height="60" viewBox="0 0 24 24" fill="#facc15">
        <path
            d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z" />
    </svg>
    <svg class="deco-leaf leaf-3" width="70" height="70" viewBox="0 0 24 24" fill="#22c55e">
        <path
            d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z" />
    </svg>
    <svg class="deco-leaf leaf-4" width="55" height="55" viewBox="0 0 24 24" fill="#facc15">
        <path
            d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z" />
    </svg>

    <div class="container">
        <!-- Hero -->
        <header class="hero">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
                </svg>
            </div>
            <h1>Faire un <span>Don</span></h1>
            <p>Chaque geste compte</p>
        </div>

        <form class="form" id="form">
            <div class="form-inner">
                <div class="group">
                    <label>Ville</label>
                    <select id="ville">
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
                            <svg viewBox="0 0 24 24" fill="#22c55e"><path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z"/></svg>
                            <span>Nature</span>
                        </div>
                        <div class="type" data-type="materiaux">
                            <svg viewBox="0 0 24 24" fill="#f97316"><path d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z"/></svg>
                            <span>Matériaux</span>
                        </div>
                        <div class="type" data-type="argent">
                            <svg viewBox="0 0 24 24" fill="#eab308"><path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,17V16H9V14H13V13H10A1,1 0 0,1 9,12V10A1,1 0 0,1 10,9H11V8H13V9H15V11H11V12H14A1,1 0 0,1 15,13V15A1,1 0 0,1 14,16H13V17H11Z"/></svg>
                            <span>Argent</span>
                        </div>
                        <div class="type" data-type="autres">
                            <svg viewBox="0 0 24 24" fill="#ef4444"><path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/></svg>
                            <span>Autres</span>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label>Ressource</label>
                    <div class="resources" id="res-nature">
                        <div class="res" data-id="1" data-price="2.50">
                            <div class="res-icon"><svg viewBox="0 0 24 24"><path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2Z"/></svg></div>
                            <div class="res-name">Conserves</div>
                            <div class="res-price">Paris • <span>2.50 €</span></div>
                        </div>
                        <div class="res" data-id="5" data-price="1.20">
                            <div class="res-icon"><svg viewBox="0 0 24 24"><path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2Z"/></svg></div>
                            <div class="res-name">Farine (vrac)</div>
                            <div class="res-price">Paris • <span>1.20 €</span></div>
                        </div>
                    </div>
                    <div class="resources" id="res-materiaux">
                        <div class="res" data-id="2" data-price="8.50">
                            <div class="res-icon"><svg viewBox="0 0 24 24"><path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2Z"/></svg></div>
                            <div class="res-name">Ciment 25kg</div>
                            <div class="res-price">Lyon • <span>8.50 €</span></div>
                        </div>
                        <div class="res" data-id="4" data-price="120">
                            <div class="res-icon"><svg viewBox="0 0 24 24"><path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2Z"/></svg></div>
                            <div class="res-name">Briques</div>
                            <div class="res-price">Lyon • <span>120 €</span></div>
                    <div class="resource-panel" id="materiauxPanel">
                        <div class="resource-grid">
                            <div class="resource-item" data-id="2" data-price="8.50">
                                <div class="resource-icon"><svg viewBox="0 0 24 24">
                                        <path
                                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                    </svg></div>
                                <div class="resource-info">
                                    <div class="resource-name">Sac de Ciment 25kg</div>
                                    <div class="resource-meta">
                                        <span>📍 Lyon</span>
                                        <span class="resource-price">8.50 €/sac</span>
                                    </div>
                                </div>
                                <div class="resource-check"><svg viewBox="0 0 24 24">
                                        <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                    </svg></div>
                            </div>
                            <div class="resource-item" data-id="4" data-price="120">
                                <div class="resource-icon"><svg viewBox="0 0 24 24">
                                        <path
                                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                    </svg></div>
                                <div class="resource-info">
                                    <div class="resource-name">Briques (palette)</div>
                                    <div class="resource-meta">
                                        <span>📍 Lyon</span>
                                        <span class="resource-price">120 €/p</span>
                                    </div>
                                </div>
                                <div class="resource-check"><svg viewBox="0 0 24 24">
                                        <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                    </svg></div>
                            </div>
                        </div>
                    </div>

                    <div class="resource-panel" id="argentPanel">
                        <div class="resource-grid">
                            <div class="resource-item" data-id="3" data-price="1">
                                <div class="resource-icon"><svg viewBox="0 0 24 24">
                                        <path
                                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                    </svg></div>
                                <div class="resource-info">
                                    <div class="resource-name">Don numéraire</div>
                                    <div class="resource-meta">
                                        <span>📍 Nantes</span>
                                        <span class="resource-price">Montant libre</span>
                                    </div>
                                </div>
                                <div class="resource-check"><svg viewBox="0 0 24 24">
                                        <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                    </svg></div>
                            </div>
                        </div>
                    </div>
                    <div class="resources" id="res-argent">
                        <div class="res" data-id="3" data-price="1">
                            <div class="res-icon"><svg viewBox="0 0 24 24"><path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2Z"/></svg></div>
                            <div class="res-name">Don numéraire</div>
                            <div class="res-price">Nantes • <span>Libre</span></div>
                        </div>
                    </div>
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
                            <input type="number" id="qty" value="1" min="1">
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

    
            <div class="submit-section">
                <button type="submit" class="submit-btn">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
                    </svg>
                    Faire mon don
                </button>
            </div>
        </form>
    </div>

    <!-- Success Modal -->
    <div class="success-modal" id="successModal">
        <div class="success-box">
            <div class="success-icon">
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

    <script>
        const S = { ville: null, type: null, res: null, qty: 1, price: 0, autres: false };
        const $ = id => document.getElementById(id);
        
        $('ville').onchange = e => {
            S.ville = e.target.value;
            if (S.type && S.type !== 'autres') filterRes();
        };
        
        document.querySelectorAll('.type').forEach(t => t.onclick = () => {
            document.querySelectorAll('.type').forEach(x => x.classList.remove('active'));
            t.classList.add('active');
            S.type = t.dataset.type;
            S.autres = S.type === 'autres';
            
            document.querySelectorAll('.resources').forEach(r => r.classList.remove('show'));
            $('autres-input').classList.toggle('show', S.autres);
            
            if (!S.autres) {
                $('res-' + S.type).classList.add('show');
                filterRes();
            }
            
            document.querySelectorAll('.res').forEach(r => r.classList.remove('active'));
            S.res = null; S.price = 0; calc();
        });
        
        function filterRes() {
            const villes = { '1': 'paris', '2': 'lyon', '3': 'nantes' };
            document.querySelectorAll('.res').forEach(r => {
                const txt = r.querySelector('.res-price').textContent.toLowerCase();
                r.style.display = !S.ville || txt.includes(villes[S.ville]) ? 'block' : 'none';
            });
        }
        
        document.querySelectorAll('.res').forEach(r => r.onclick = () => {
            r.closest('.resources').querySelectorAll('.res').forEach(x => x.classList.remove('active'));
            r.classList.add('active');
            S.res = r.dataset.id;
            S.price = parseFloat(r.dataset.price);
            calc();
        });
        
        const calc = () => $('val').textContent = (S.qty * S.price).toLocaleString('fr-FR', { style: 'currency', currency: 'EUR' });
        $('q-').onclick = () => { S.qty = Math.max(1, S.qty - 1); $('qty').value = S.qty; calc(); };
        $('q+').onclick = () => { S.qty++; $('qty').value = S.qty; calc(); };
        $('qty').onchange = () => { S.qty = Math.max(1, +$('qty').value || 1); $('qty').value = S.qty; calc(); };
        
        $('form').onsubmit = e => {
            e.preventDefault();
            if (!S.ville) return alert('Sélectionnez une ville');
            if (!S.type) return alert('Sélectionnez un type');
            if (!S.autres && !S.res) return alert('Sélectionnez une ressource');
            if (S.autres && !$('cName').value) return alert('Entrez le nom de la ressource');
            
            const villes = { '1': 'Paris', '2': 'Lyon', '3': 'Nantes' };
            let d = [];
            d.push(`<div><strong>Ville:</strong> ${villes[S.ville]}</div>`);
            if (S.autres) d.push(`<div><strong>Ressource:</strong> ${$('cName').value}</div>`);
            else d.push(`<div><strong>Ressource:</strong> ${document.querySelector('.res.active .res-name').textContent}</div>`);
            d.push(`<div><strong>Quantité:</strong> ${S.qty}</div>`);
            if (S.price) d.push(`<div><strong>Valeur:</strong> ${$('val').textContent}</div>`);
            if ($('dName').value) d.push(`<div><strong>De:</strong> ${$('dName').value}</div>`);
            
            $('det').innerHTML = d.join('');
            $('modal').classList.add('on');
        };
        
        $('newBtn').onclick = () => {
            $('modal').classList.remove('on');
            document.querySelectorAll('.type, .res').forEach(x => x.classList.remove('active'));
            document.querySelectorAll('.resources').forEach(r => r.classList.remove('show'));
            $('autres-input').classList.remove('show');
            S.ville = S.type = S.res = null; S.qty = 1; S.price = 0; S.autres = false;
            $('ville').value = '';
            $('qty').value = 1; calc();
            $('form').reset();
        };
    </script>
</body>

</html>