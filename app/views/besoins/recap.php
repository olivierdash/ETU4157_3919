<script nonce="<?= Flight::get('csp_nonce') ?>" src="<?= BASE_URL ?>/assets/js/recap.js" defer></script>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style_recap.css">
    <div class="wrap">
        <!-- HERO SECTION -->
        <div class="hero">
            <div class="icon-container">
                <svg viewBox="0 0 24 24">
                    <path d="M12,2C6.48,2 2,6.48 2,12C2,17.52 6.48,22 12,22C17.52,22 22,17.52 22,12C22,6.48 17.52,2 12,2M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,6C8.69,6 6,8.69 6,12C6,15.31 8.69,18 12,18C15.31,18 18,15.31 18,12C18,8.69 15.31,6 12,6Z" />
                </svg>
            </div>
            <h1>État des <span>Besoins</span></h1>
            <p>Suivi des ressources requises et collectées</p>
        </div>

        <!-- REFRESH BUTTON -->
        <div class="refresh-container">
            <button class="refresh-btn" id="refreshBtn" title="Rafraîchir les données">
                <svg viewBox="0 0 24 24">
                    <path d="M1,4V10H7M23,20V14H17M20.54,5.54C19.89,4.89 18.76,4 16.57,4C13.29,4 10.44,6.85 10.44,10.13C10.44,13.41 13.3,16.26 16.58,16.26C18.68,16.26 20.37,15.15 21.13,13.89H17.95V11.5H23.5C23.8,12.2 24,12.97 24,13.8C24,17.25 21.25,20 17.8,20C12.35,20 8,15.65 8,10.2C8,4.77 12.35,0.4 17.8,0.4C19.58,0.4 21.37,0.9 22.81,2.29L20.54,5.54Z" />
                </svg>
                Rafraîchir
            </button>
        </div>

        <!-- GLOBAL STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Besoins Totaux</div>
                <div class="stat-value">24</div>
            </div>
            <div class="stat-card" style="border-left-color: var(--y);">
                <div class="stat-label">Besoins satisfaits</div>
                <div class="stat-value">4</div>
            </div>
        </div>

        <!-- NEEDS BY CATEGORY -->
       
    </div>