<div class="dispatch-page">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="dispatch-header">
                    <h1>⚡ Simulation de Dispatch de Ressources</h1>
                    <p>Choisissez un mode de dispatch pour voir comment les ressources seraient distribuées aux villes.</p>
                </div>
                
                <a href="/" class="btn btn-secondary mb-3">← Retour</a>

                <!-- Contrôles -->
                <div class="card dispatch-control">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="dispatchMode" class="form-label"><strong>Sélectionnez le mode de dispatch :</strong></label>
                                <select id="dispatchMode" class="form-select form-select-lg">
                                    <option value="">-- Choisir un mode --</option>
                                    <option value="fifo">Mode 1: FIFO (Par Date) - Premier arrivé, premier servi</option>
                                    <option value="quantity">Mode 2: Par Quantité - Les demandes les plus petites en premier</option>
                                    <option value="proportionality">Mode 3: Proportionnalité - Distribution proportionnelle aux demandes</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div id="modeDescription" class="alert alert-info mt-5" style="display:none;">
                                    <strong id="descTitle"></strong>
                                    <p id="descText" class="mb-1"></p>
                                    <div id="descDetails"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton Valider -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button id="validateBtn" class="btn btn-primary btn-lg w-100" style="display:none;">
                                    ✓ Valider et Voir les Résultats
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Indicateur de chargement -->
                <div id="loadingSpinner" class="text-center mb-4" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-2">Chargement des données...</p>
                </div>

                <!-- Résultats -->
                <div id="resultsContainer" style="display:none;">
                    <!-- Statistiques -->
                    <div class="dispatch-stats">
                        <div class="stat-card">
                            <h6>Total Demandé</h6>
                            <h3 id="totalDemanded">0</h3>
                        </div>
                        <div class="stat-card">
                            <h6>Total Alloué</h6>
                            <h3 id="totalAllocated">0</h3>
                        </div>
                        <div class="stat-card">
                            <h6>Taux de Satisfaction</h6>
                            <h3 id="satisfactionRate">0%</h3>
                        </div>
                        <div class="stat-card">
                            <h6>Nombre de Demandes</h6>
                            <h3 id="requestCount">0</h3>
                        </div>
                    </div>

                    <!-- Tableau -->
                    <div class="table-responsive dispatch-table-wrapper">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Ressource</th>
                                    <th>Type</th>
                                    <th>Ville Demandeuse</th>
                                    <th class="text-center">Date Demande</th>
                                    <th class="text-center">Quantité Demandée</th>
                                    <th class="text-center">Quantité Allouée</th>
                                    <th id="proportionHeader" class="text-center" style="display:none;">Proportion</th>
                                    <th class="text-center">Taux Satisfaction</th>
                                </tr>
                            </thead>
                            <tbody id="resultsTableBody">
                                <tr id="emptyRow">
                                    <td colspan="8" class="text-center text-muted">Aucune donnée</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script nonce="<?= Flight::get('csp_nonce') ?>">
document.addEventListener('DOMContentLoaded', function() {
    const modeSelect = document.getElementById('dispatchMode');
    const validateBtn = document.getElementById('validateBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const resultsContainer = document.getElementById('resultsContainer');
    const resultsTableBody = document.getElementById('resultsTableBody');
    const proportionHeader = document.getElementById('proportionHeader');
    const modeDescription = document.getElementById('modeDescription');
    const descTitle = document.getElementById('descTitle');
    const descText = document.getElementById('descText');
    const descDetails = document.getElementById('descDetails');

    const modeDescriptions = {
        'fifo': {
            title: 'Mode 1: FIFO (First In First Out)',
            text: 'Le premier qui a demandé reçoit en premier. Les demandes sont traitées par ordre chronologique.',
            details: `
                <p class="mb-1"><strong>Avantages:</strong> Équité temporelle, transparence, pas de favoritisme</p>
                <p class="mb-0"><strong>Inconvénients:</strong> Peut ignorer les besoins réels, pas d'optimisation</p>
            `
        },
        'quantity': {
            title: 'Mode 2: Par Quantité',
            text: 'La ville qui demande le moins reçoit en premier. Les demandes sont traitées de la plus petite à la plus grande.',
            details: `
                <p class="mb-1"><strong>Avantages:</strong> Priorité aux besoins modestes, maximise le nombre de bénéficiaires</p>
                <p class="mb-0"><strong>Inconvénients:</strong> Peut pénaliser les besoins réels importants</p>
            `
        },
        'proportionality': {
            title: 'Mode 3: Proportionnalité',
            text: 'Distribution proportionnelle: (quantité demandée) / (total des quantités) × (quantité disponible)',
            details: `
                <p class="mb-1"><strong>Avantages:</strong> Équité proportionnelle, optimisation globale, pas de perte</p>
                <p class="mb-0"><strong>Inconvénients:</strong> Complexité de calcul, résultats fractionnels</p>
            `
        }
    };

    modeSelect.addEventListener('change', function() {
        const mode = this.value;
        
        if (!mode) {
            validateBtn.style.display = 'none';
            modeDescription.style.display = 'none';
            resultsContainer.style.display = 'none';
            return;
        }

        // Afficher la description
        if (modeDescriptions[mode]) {
            descTitle.textContent = modeDescriptions[mode].title;
            descText.textContent = modeDescriptions[mode].text;
            descDetails.innerHTML = modeDescriptions[mode].details;
            modeDescription.style.display = 'block';
            validateBtn.style.display = 'block';
        }
    });

    validateBtn.addEventListener('click', function() {
        const mode = modeSelect.value;
        
        if (!mode) {
            alert('Veuillez sélectionner un mode');
            return;
        }

        // Afficher le spinner de chargement
        loadingSpinner.style.display = 'block';
        resultsContainer.style.display = 'none';

        // Afficher/cacher la colonne proportion selon le mode
        proportionHeader.style.display = mode === 'proportionality' ? 'table-cell' : 'none';

        // Charger les données via AJAX
        fetch(`/dispatch/api?mode=${mode}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors du chargement des données');
                }
                return response.json();
            })
            .then(data => {
                loadingSpinner.style.display = 'none';
                resultsContainer.style.display = 'block';
                
                // Remplir le tableau
                populateTable(data, mode);
                
                // Calculer et afficher les statistiques
                updateStatistics(data);
            })
            .catch(error => {
                loadingSpinner.style.display = 'none';
                resultsTableBody.innerHTML = `<tr><td colspan="8" class="text-center text-danger">Erreur: ${error.message}</td></tr>`;
                resultsContainer.style.display = 'block';
            });
    });

    function populateTable(data, mode) {
        resultsTableBody.innerHTML = '';
        
        if (data.length === 0) {
            resultsTableBody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Aucune donnée disponible</td></tr>';
            return;
        }

        data.forEach(result => {
            const taux = result.quantite_demandee > 0 
                ? Math.round((result.quantite_allouee / result.quantite_demandee) * 100) 
                : 0;
            
            const tauxColor = taux >= 100 ? 'bg-success' : (taux >= 50 ? 'bg-warning text-dark' : 'bg-danger');
            
            const date = new Date(result.date_demande);
            const dateStr = date.toLocaleDateString('fr-FR');
            
            let row = `
                <tr>
                    <td><strong>${escapeHtml(result.ressource_nom)}</strong></td>
                    <td><span class="badge bg-info">${escapeHtml(result.type)}</span></td>
                    <td>${escapeHtml(result.ville_demandeuse)}</td>
                    <td class="text-center">${dateStr}</td>
                    <td class="text-center"><span class="badge bg-warning text-dark">${result.quantite_demandee}</span></td>
                    <td class="text-center"><span class="badge bg-success">${result.quantite_allouee}</span></td>
            `;
            
            if (mode === 'proportionality') {
                row += `<td class="text-center">${(result.proportion || 0).toFixed(2)}%</td>`;
            }
            
            row += `
                    <td class="text-center"><span class="badge ${tauxColor}">${taux}%</span></td>
                </tr>
            `;
            
            resultsTableBody.innerHTML += row;
        });
    }

    function updateStatistics(data) {
        let totalDemanded = 0;
        let totalAllocated = 0;

        data.forEach(item => {
            totalDemanded += item.quantite_demandee;
            totalAllocated += item.quantite_allouee;
        });

        const satisfactionRate = totalDemanded > 0 
            ? Math.round((totalAllocated / totalDemanded) * 100) 
            : 0;

        document.getElementById('totalDemanded').textContent = totalDemanded;
        document.getElementById('totalAllocated').textContent = totalAllocated;
        document.getElementById('satisfactionRate').textContent = satisfactionRate + '%';
        document.getElementById('requestCount').textContent = data.length;
    }

    function escapeHtml(text) {
        // Convertir en string si ce n'est pas déjà une string
        text = String(text);
        
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
});
</script>

<style>

