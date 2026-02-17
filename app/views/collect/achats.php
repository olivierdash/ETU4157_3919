<?php
/**
 * Vue pour l'achat de ressources avec argent collecté
 * Design personnalisé sans Bootstrap
 */
?>

<div class="achat-container">
    <!-- Message de succès/erreur -->
    <div id="alertContainer"></div>

    <!-- En-tête avec infos argent -->
    <div class="header-stats">
        <div class="stat-card">
            <div class="stat-icon collecte">💰</div>
            <div class="stat-content">
                <span class="stat-label">Argent Collecté</span>
                <h3 class="stat-value">€<?= number_format($argent_disponible['collecte'], 2) ?></h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon depense">💸</div>
            <div class="stat-content">
                <span class="stat-label">Argent Dépensé</span>
                <h3 class="stat-value">€<?= number_format($argent_disponible['depense'], 2) ?></h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon disponible">✓</div>
            <div class="stat-content">
                <span class="stat-label">Disponible pour Achats</span>
                <h3 class="stat-value">€<?= number_format($argent_disponible['disponible'], 2) ?></h3>
            </div>
        </div>
    </div>

    <!-- Tableau des besoins -->
    <div class="table-card">
        <div class="table-header">
            <h2>Besoins par Ville</h2>
        </div>
        <div class="table-responsive">
            <table class="besoins-table">
                <thead>
                    <tr>
                        <th>Ville</th>
                        <th>Ressource</th>
                        <th>Type</th>
                        <th>P.U.</th>
                        <th>Besoin</th>
                        <th>Distribué</th>
                        <th>Restant</th>
                        <th>Progression</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($besoins as $besoin): ?>
                        <tr data-besoin-id="<?= $besoin['id'] ?>" class="<?= $besoin['quantite_restante'] > 0 ? 'active' : 'satisfied' ?>">
                            <td class="ville"><strong><?= htmlspecialchars($besoin['ville']) ?></strong></td>
                            <td><?= htmlspecialchars($besoin['ressource']) ?></td>
                            <td>
                                <span class="type-badge type-<?= strtolower(str_replace(' ', '-', $besoin['type'])) ?>">
                                    <?= htmlspecialchars($besoin['type']) ?>
                                </span>
                            </td>
                            <td class="price">€<?= number_format($besoin['prixUnitaire'], 2) ?></td>
                            <td class="center"><?= $besoin['quantite_besoin'] ?></td>
                            <td class="center">
                                <span class="quantite-distribuee" data-besoin-id="<?= $besoin['id'] ?>">
                                    <?= $besoin['quantite_distribuee'] ?>
                                </span>
                            </td>
                            <td class="center">
                                <span class="quantite-restante" data-besoin-id="<?= $besoin['id'] ?>">
                                    <?= $besoin['quantite_restante'] ?>
                                </span>
                            </td>
                            <td class="progression">
                                <div class="progress-container">
                                    <div class="progress-bar" 
                                         style="width: <?= $besoin['pourcentage_comble'] ?>%"
                                         data-besoin-id="<?= $besoin['id'] ?>">
                                        <span class="progress-text"><?= $besoin['pourcentage_comble'] ?>%</span>
                                    </div>
                                </div>
                            </td>
                            <td class="action">
                                <?php if ($besoin['quantite_restante'] > 0): ?>
                                    <button class="btn-acheter" 
                                            onclick="openAchatModal(<?= $besoin['id'] ?>, '<?= htmlspecialchars($besoin['ressource']) ?>', <?= $besoin['quantite_restante'] ?>, <?= $besoin['prixUnitaire'] ?>)">
                                        Acheter
                                    </button>
                                <?php else: ?>
                                    <span class="badge-satisfied">Satisfait</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal d'achat -->
<div class="modal" id="achatModal">
    <div class="modal-overlay" onclick="closeModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Acheter <span id="modalRessource"></span></h3>
            <button class="modal-close" onclick="closeModal()">✕</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Quantité à acheter</label>
                <input type="number" class="form-input" id="quantiteAchat" min="1" value="1">
                <small class="form-hint">Max: <span id="maxQuantite"></span> unités</small>
            </div>
            <div class="form-group">
                <label class="form-label">Coût total</label>
                <h4 id="coutTotal" class="cout-display">€0.00</h4>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="closeModal()">Annuler</button>
            <button class="btn-primary" onclick="effectuerAchat()">Confirmer l'achat</button>
        </div>
    </div>
</div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.achat-container {
    padding: 40px 20px;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.header-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    display: flex;
    gap: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border-left: 5px solid #0ea5e9;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.stat-card:nth-child(1) { border-left-color: #22c55e; }
.stat-card:nth-child(2) { border-left-color: #ef4444; }
.stat-card:nth-child(3) { border-left-color: #0ea5e9; }

.stat-icon {
    font-size: 32px;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #f1f5f9;
}

.stat-content { flex: 1; }

.stat-label {
    display: block;
    font-size: 13px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    margin-bottom: 8px;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #0f172a;
}

.table-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}

.table-header {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    padding: 25px;
    border-bottom: 1px solid #e2e8f0;
}

.table-header h2 {
    font-size: 24px;
    color: #0f172a;
}

.table-responsive { overflow-x: auto; }

.besoins-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.besoins-table thead { background: #f8fafc; }

.besoins-table th {
    padding: 16px;
    text-align: left;
    font-weight: 700;
    color: #475569;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0;
}

.besoins-table td {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.besoins-table tbody tr {
    transition: all 0.2s ease;
}

.besoins-table tbody tr:hover { background: #f8fafc; }
.besoins-table tbody tr.satisfied { opacity: 0.7; }

.ville { font-weight: 600; color: #0f172a; }
.price { color: #0ea5e9; font-weight: 600; }
.center { text-align: center; font-weight: 600; color: #0ea5e9; }

.type-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.type-nature { background: #dcfce7; color: #166534; }
.type-materiaux { background: #dbeafe; color: #1e40af; }
.type-argent { background: #fed7aa; color: #92400e; }

.progression { width: 120px; }

.progress-container {
    width: 100%;
    height: 24px;
    background: #e2e8f0;
    border-radius: 6px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #22c55e 0%, #16a34a 100%);
    transition: width 0.4s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 30px;
}

.progress-text { color: white; font-size: 11px; font-weight: 700; }

.action { text-align: center; }

.btn-acheter {
    padding: 8px 16px;
    background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
    transition: all 0.3s ease;
}

.btn-acheter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.4);
}

.badge-satisfied {
    display: inline-block;
    padding: 6px 12px;
    background: #dcfce7;
    color: #166534;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
}

.modal.active {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.modal-content {
    position: relative;
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 25px;
    border-bottom: 1px solid #e2e8f0;
}

.modal-header h3 { font-size: 20px; color: #0f172a; }

.modal-close {
    background: none;
    border: none;
    font-size: 28px;
    color: #94a3b8;
    cursor: pointer;
    padding: 0;
    transition: all 0.2s ease;
}

.modal-close:hover {
    color: #0f172a;
    transform: rotate(90deg);
}

.modal-body { padding: 25px; }

.form-group { margin-bottom: 20px; }

.form-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 8px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
}

.form-hint {
    display: block;
    font-size: 12px;
    color: #64748b;
    margin-top: 6px;
}

.cout-display {
    font-size: 32px;
    color: #22c55e;
    font-weight: 700;
}

.modal-footer {
    display: flex;
    gap: 12px;
    padding: 25px;
    border-top: 1px solid #e2e8f0;
    justify-content: flex-end;
}

.btn-secondary, .btn-primary {
    padding: 12px 24px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
}

.btn-secondary {
    background: #f1f5f9;
    color: #475569;
}

.btn-secondary:hover { background: #e2e8f0; }

.btn-primary {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
}

#alertContainer {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2000;
    max-width: 500px;
    width: 90%;
}

.alert {
    padding: 16px 20px;
    border-radius: 8px;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    animation: slideDown 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #22c55e;
}

.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #ef4444;
}

.alert-close {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    font-size: 18px;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 768px) {
    .achat-container { padding: 20px 15px; }
    .header-stats { grid-template-columns: 1fr; gap: 15px; margin-bottom: 30px; }
    .besoins-table th, .besoins-table td { padding: 12px 8px; font-size: 13px; }
    .btn-acheter { padding: 6px 12px; font-size: 12px; }
    .modal-content { width: 95%; }
}

@media (max-width: 480px) {
    .besoins-table th, .besoins-table td { padding: 8px 4px; font-size: 11px; }
    .stat-card { flex-direction: column; text-align: center; }
    .progression { width: 80px; }
}
</style>

<script>
let currentBesoinId = null;
let currentPrixUnitaire = null;

function openAchatModal(besoinId, ressourceName, maxQuantite, prixUnitaire) {
    currentBesoinId = besoinId;
    currentPrixUnitaire = prixUnitaire;
    document.getElementById('modalRessource').textContent = ressourceName;
    document.getElementById('maxQuantite').textContent = maxQuantite;
    document.getElementById('quantiteAchat').max = maxQuantite;
    document.getElementById('quantiteAchat').value = 1;
    updateCoutTotal();
    document.getElementById('achatModal').classList.add('active');
}

function closeModal() {
    document.getElementById('achatModal').classList.remove('active');
}

function updateCoutTotal() {
    const quantite = parseInt(document.getElementById('quantiteAchat').value) || 0;
    const cout = quantite * currentPrixUnitaire;
    document.getElementById('coutTotal').textContent = '€' + cout.toFixed(2).replace('.', ',');
}

document.getElementById('quantiteAchat')?.addEventListener('input', updateCoutTotal);

function effectuerAchat() {
    const quantite = parseInt(document.getElementById('quantiteAchat').value);
    if (!quantite || quantite <= 0) {
        showAlert('Quantité invalide', 'danger');
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= BASE_URL ?>/acheter-ressource', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function() {
        try {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                document.querySelector(`[data-besoin-id="${currentBesoinId}"] .quantite-distribuee`).textContent = response.data.quantite_distribuee;
                document.querySelector(`[data-besoin-id="${currentBesoinId}"] .quantite-restante`).textContent = response.data.quantite_restante;
                const progressBar = document.querySelector(`[data-besoin-id="${currentBesoinId}"] .progress-bar`);
                progressBar.style.width = response.data.pourcentage_comble + '%';
                if (progressBar.querySelector('.progress-text')) {
                    progressBar.querySelector('.progress-text').textContent = response.data.pourcentage_comble + '%';
                }
                const row = document.querySelector(`[data-besoin-id="${currentBesoinId}"]`);
                if (response.data.quantite_restante <= 0) {
                    row.classList.remove('active');
                    row.classList.add('satisfied');
                    row.querySelector('.action').innerHTML = '<span class="badge-satisfied">Satisfait</span>';
                }
                closeModal();
                showAlert(response.message + ' - Argent restant: €' + response.data.argent_restant, 'success');
            } else {
                showAlert(response.message, 'danger');
            }
        } catch (e) {
            showAlert('Erreur traitement réponse', 'danger');
        }
    };

    xhr.onerror = function() {
        showAlert('Erreur de connexion', 'danger');
    };

    xhr.send(JSON.stringify({
        besoin_id: currentBesoinId,
        quantite_achat: quantite
    }));
}

function showAlert(message, type = 'info') {
    const alertHtml = `<div class="alert alert-${type}"><span>${message}</span><button class="alert-close" onclick="this.parentElement.remove()">✕</button></div>`;
    const container = document.getElementById('alertContainer');
    container.innerHTML = alertHtml;
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) alert.remove();
    }, 4000);
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
});
</script>