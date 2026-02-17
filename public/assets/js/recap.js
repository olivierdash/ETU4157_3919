// Gestion du bouton Rafraîchir avec AJAX
document.addEventListener('DOMContentLoaded', function() {
    const refreshBtn = document.getElementById('refreshBtn');
    
    if (refreshBtn) {
        refreshBtn.addEventListener('click', refreshBesoins);
    }
});

async function refreshBesoins() {
    const refreshBtn = document.getElementById('refreshBtn');
    
    // Désactiver le bouton et ajouter l'animation
    refreshBtn.disabled = true;
    refreshBtn.classList.add('loading');
    
    try {
        // Appel AJAX pour récupérer les données
        const response = await fetch('<?= BASE_URL ?>/api/besoins/data', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) {
            throw new Error('Erreur lors du chargement des données');
        }
        
        const data = await response.json();
        
        // Mettre à jour les données
        updateStats(data);
        updateNeeds(data);
        
        // Afficher un toast de succès
        showToast('Données rafraîchies avec succès !', 'success');
        
    } catch (error) {
        console.error('Erreur:', error);
        showToast('Erreur lors du rafraîchissement des données', 'error');
    } finally {
        // Réactiver le bouton et retirer l'animation
        refreshBtn.disabled = false;
        refreshBtn.classList.remove('loading');
    }
}

function updateStats(data) {
    // Mettre à jour les cartes de statistiques globales
    const statCards = document.querySelectorAll('.stat-card');
    
    if (statCards.length >= 4) {
        statCards[0].querySelector('.stat-value').textContent = data.total_besoins;
        statCards[1].querySelector('.stat-value').textContent = data.en_attente;
        statCards[2].querySelector('.stat-value').textContent = data.partiellement_recu;
        statCards[3].querySelector('.stat-value').textContent = data.completes;
    }
}

function updateNeeds(data) {
    // Mettre à jour les barres de progression et les pourcentages
    if (data.besoins && Array.isArray(data.besoins)) {
        data.besoins.forEach(need => {
            const needElement = document.querySelector(`[data-need-id="${need.id}"]`);
            if (needElement) {
                // Mettre à jour la barre de progression
                const progressFill = needElement.querySelector('.progress-fill');
                const progressText = needElement.querySelector('.progress-text');
                const progressAmount = needElement.querySelector('.progress-amount');
                
                if (progressFill) {
                    progressFill.style.width = need.pourcentage + '%';
                }
                if (progressAmount) {
                    progressAmount.textContent = need.montant;
                }
                if (progressText) {
                    const percentageSpan = progressText.querySelector('span:first-child');
                    if (percentageSpan) {
                        percentageSpan.textContent = need.pourcentage + '% reçu';
                    }
                }
            }
        });
    }
    
    // Mettre à jour le footer
    if (data.footer_stats) {
        const footerStats = document.querySelectorAll('.footer-stat-value');
        if (footerStats.length >= 3) {
            footerStats[0].textContent = data.footer_stats.taux_collecte;
            footerStats[1].textContent = data.footer_stats.besoins_totaux;
            footerStats[2].textContent = data.footer_stats.montant_collecte;
        }
    }
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast ${type === 'error' ? 'error' : ''}`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Retirer le toast après 3 secondes
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// Animation pour le départ du toast
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(400px);
        }
    }
`;
document.head.appendChild(style);