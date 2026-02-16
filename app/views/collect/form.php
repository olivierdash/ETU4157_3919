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
            <h1>Faire un Don</h1>
            <p>Chaque geste compte. Merci pour votre solidarité.</p>
        </header>

        <!-- Form -->
        <form class="form-card" id="donForm">
            <div class="form-body">
                <!-- Type -->
                <section class="section">
                    <div class="section-title">Type de ressource</div>
                    <div class="type-grid" id="typeGrid">
                        <div class="type-card" data-type="nature">
                            <div class="type-icon">
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z" />
                                </svg>
                            </div>
                            <div class="type-label">Nature</div>
                            <div class="check-badge">
                                <svg viewBox="0 0 24 24">
                                    <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                </svg>
                            </div>
                        </div>
                        <div class="type-card" data-type="materiaux">
                            <div class="type-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z" />
                                </svg>
                            </div>
                            <div class="type-label">Matériaux</div>
                            <div class="check-badge">
                                <svg viewBox="0 0 24 24">
                                    <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                </svg>
                            </div>
                        </div>
                        <div class="type-card" data-type="argent">
                            <div class="type-icon">
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M5,6H23V18H5V6M14,9A3,3 0 0,1 17,12A3,3 0 0,1 14,15A3,3 0 0,1 11,12A3,3 0 0,1 14,9M9,8A2,2 0 0,1 7,10V14A2,2 0 0,1 9,16H19A2,2 0 0,1 21,14V10A2,2 0 0,1 19,8H9M1,10H3V20H19V22H1V10Z" />
                                </svg>
                            </div>
                            <div class="type-label">Argent</div>
                            <div class="check-badge">
                                <svg viewBox="0 0 24 24">
                                    <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Resources -->
                <section class="section">
                    <div class="section-title">Ressources demandées</div>

                    <div class="resource-panel" id="naturePanel">
                        <div class="resource-grid">
                            <div class="resource-item" data-id="1" data-price="2.50">
                                <div class="resource-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path
                                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                    </svg>
                                </div>
                                <div class="resource-info">
                                    <div class="resource-name">Lot de Conserves</div>
                                    <div class="resource-meta">
                                        <span>📍 Paris</span>
                                        <span class="resource-price">2.50 €/u</span>
                                    </div>
                                </div>
                                <div class="resource-check"><svg viewBox="0 0 24 24">
                                        <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                    </svg></div>
                            </div>
                            <div class="resource-item" data-id="5" data-price="1.20">
                                <div class="resource-icon"><svg viewBox="0 0 24 24">
                                        <path
                                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                    </svg></div>
                                <div class="resource-info">
                                    <div class="resource-name">Farine (vrac)</div>
                                    <div class="resource-meta">
                                        <span>📍 Paris</span>
                                        <span class="resource-price">1.20 €/kg</span>
                                    </div>
                                </div>
                                <div class="resource-check"><svg viewBox="0 0 24 24">
                                        <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                    </svg></div>
                            </div>
                        </div>
                    </div>

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

                    <!-- Custom -->
                    <div class="custom-toggle" id="customToggle">
                        <div class="toggle" id="toggleBtn"></div>
                        <span>Autre ressource</span>
                    </div>
                    <div class="custom-inputs" id="customInputs">
                        <input type="text" class="input-field" id="customName" placeholder="Nom de la ressource">
                        <input type="text" class="input-field" id="customDesc" placeholder="Description (optionnel)">
                    </div>
                </section>

                <!-- Quantity -->
                <section class="section">
                    <div class="section-title">Quantité</div>
                    <div class="quantity-row">
                        <div class="quantity-control">
                            <button type="button" class="qty-btn" id="qtyMinus">−</button>
                            <input type="number" class="qty-input" id="qtyInput" value="1" min="1">
                            <button type="button" class="qty-btn" id="qtyPlus">+</button>
                        </div>
                        <div class="value-display">
                            <div class="value-label">Valeur estimée</div>
                            <div class="value-amount" id="estValue">0,00 €</div>
                        </div>
                    </div>
                </section>

                <!-- Donor -->
                <section class="section">
                    <div class="section-title">Vos informations (optionnel)</div>
                    <div class="donor-grid">
                        <input type="text" class="input-field" id="donorName" placeholder="Nom">
                        <input type="email" class="input-field" id="donorEmail" placeholder="Email">
                    </div>
                    <input type="text" class="input-field" id="donorMsg" placeholder="Message d'encouragement">
                </section>
            </div>

            <!-- Submit -->
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
            <h2 class="success-title">Merci !</h2>
            <p class="success-text">Votre générosité apporte de l'espoir.</p>
            <div class="success-details" id="successDetails"></div>
            <button class="new-don-btn" id="newDonBtn">Nouveau don</button>
        </div>
    </div>

    <script nonce="<?= Flight::get('csp_nonce') ?>">
        const state = { type: null, resource: null, qty: 1, price: 0, custom: false };

        // Type selection
        document.querySelectorAll('.type-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                state.type = card.dataset.type;

                document.querySelectorAll('.resource-panel').forEach(p => p.classList.remove('active'));
                document.getElementById(state.type + 'Panel').classList.add('active');

                document.querySelectorAll('.resource-item').forEach(r => r.classList.remove('selected'));
                state.resource = null;
                state.price = 0;
                updateValue();
            });
        });

        // Resource selection
        document.querySelectorAll('.resource-item').forEach(item => {
            item.addEventListener('click', () => {
                if (state.custom) toggleCustom();
                item.closest('.resource-panel').querySelectorAll('.resource-item').forEach(r => r.classList.remove('selected'));
                item.classList.add('selected');
                state.resource = item.dataset.id;
                state.price = parseFloat(item.dataset.price);
                updateValue();
            });
        });

        // Custom toggle
        const toggleBtn = document.getElementById('toggleBtn');
        const customInputs = document.getElementById('customInputs');

        function toggleCustom() {
            state.custom = !state.custom;
            toggleBtn.classList.toggle('on', state.custom);
            customInputs.classList.toggle('show', state.custom);
            if (state.custom) {
                document.querySelectorAll('.resource-item').forEach(r => r.classList.remove('selected'));
                state.resource = null;
                state.price = 0;
                updateValue();
            }
        }

        document.getElementById('customToggle').addEventListener('click', toggleCustom);

        // Quantity
        const qtyInput = document.getElementById('qtyInput');

        document.getElementById('qtyMinus').addEventListener('click', () => {
            state.qty = Math.max(1, state.qty - 1);
            qtyInput.value = state.qty;
            updateValue();
        });

        document.getElementById('qtyPlus').addEventListener('click', () => {
            state.qty++;
            qtyInput.value = state.qty;
            updateValue();
        });

        qtyInput.addEventListener('change', () => {
            state.qty = Math.max(1, parseInt(qtyInput.value) || 1);
            qtyInput.value = state.qty;
            updateValue();
        });

        function updateValue() {
            const val = (state.qty * state.price).toLocaleString('fr-FR', { style: 'currency', currency: 'EUR' });
            document.getElementById('estValue').textContent = val;
        }

        // Submit
        document.getElementById('donForm').addEventListener('submit', (e) => {
            e.preventDefault();

            if (!state.type) return alert('Sélectionnez un type de ressource.');
            if (!state.resource && !state.custom) return alert('Sélectionnez une ressource.');

            const details = [];
            if (state.custom) {
                details.push(`<strong>Ressource:</strong> ${document.getElementById('customName').value || 'Personnalisée'}`);
            } else {
                const selected = document.querySelector('.resource-item.selected');
                details.push(`<strong>Ressource:</strong> ${selected.querySelector('.resource-name').textContent}`);
            }
            details.push(`<strong>Type:</strong> ${state.type}`);
            details.push(`<strong>Quantité:</strong> ${state.qty}`);
            if (state.price > 0) details.push(`<strong>Valeur:</strong> ${document.getElementById('estValue').textContent}`);

            const name = document.getElementById('donorName').value;
            if (name) details.push(`<strong>De:</strong> ${name}`);

            document.getElementById('successDetails').innerHTML = details.join('');
            document.getElementById('successModal').classList.add('show');
        });

        // New donation
        document.getElementById('newDonBtn').addEventListener('click', () => {
            document.getElementById('successModal').classList.remove('show');
            document.querySelectorAll('.type-card, .resource-item').forEach(el => el.classList.remove('selected'));
            document.querySelectorAll('.resource-panel').forEach(p => p.classList.remove('active'));
            if (state.custom) toggleCustom();
            state.type = null;
            state.resource = null;
            state.qty = 1;
            state.price = 0;
            qtyInput.value = 1;
            updateValue();
            document.getElementById('donForm').reset();
        });
    </script>
</body>

</html>