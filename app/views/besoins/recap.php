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
                <div class="stat-subtext">ressources demandées</div>
            </div>
            <div class="stat-card orange">
                <div class="stat-label">En Attente</div>
                <div class="stat-value">8</div>
                <div class="stat-subtext">à satisfaire</div>
            </div>
            <div class="stat-card yellow">
                <div class="stat-label">Partiellement Reçu</div>
                <div class="stat-value">12</div>
                <div class="stat-subtext">besoins avancés</div>
            </div>
            <div class="stat-card" style="border-left-color: var(--g2);">
                <div class="stat-label">Complétés</div>
                <div class="stat-value">4</div>
                <div class="stat-subtext">100% satisfaits</div>
            </div>
        </div>

        <!-- NEEDS BY CATEGORY -->
        <div class="needs-section">
            <div class="section-title">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12,2C6.48,2 2,6.48 2,12C2,17.52 6.48,22 12,22C17.52,22 22,17.52 22,12C22,6.48 17.52,2 12,2M10,17L5,12L6.41,10.59L10,14.17L17.59,6.59L19,8L10,17Z" />
                </svg>
                Nature & Environnement
            </div>
            <div class="needs-list">
                <div class="need-item">
                    <div class="need-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z" />
                        </svg>
                    </div>
                    <div class="need-info">
                        <div class="need-name">Semis et Plants</div>
                        <div class="need-desc">Variétés légumes biologiques</div>
                    </div>
                    <div class="need-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 65%;"></div>
                        </div>
                        <div class="progress-text">
                            <span>65% reçu</span>
                            <span class="progress-amount">130/200 unités</span>
                        </div>
                    </div>
                </div>

                <div class="need-item">
                    <div class="need-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z" />
                        </svg>
                    </div>
                    <div class="need-info">
                        <div class="need-name">Compost & Engrais</div>
                        <div class="need-desc">Amendements naturels</div>
                    </div>
                    <div class="need-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 100%;"></div>
                        </div>
                        <div class="progress-text">
                            <span>100% reçu</span>
                            <span class="progress-amount">500/500 kg</span>
                        </div>
                    </div>
                </div>

                <div class="need-item">
                    <div class="need-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z" />
                        </svg>
                    </div>
                    <div class="need-info">
                        <div class="need-name">Outils de Jardinage</div>
                        <div class="need-desc">Bêches, râteaux, pelles</div>
                    </div>
                    <div class="need-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 30%;"></div>
                        </div>
                        <div class="progress-text">
                            <span>30% reçu</span>
                            <span class="progress-amount">6/20 unités</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MATERIALS SECTION -->
        <div class="needs-section" style="margin-top: 2rem;">
            <div class="section-title" style="color: var(--o);">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z" />
                </svg>
                Matériaux & Construction
            </div>
            <div class="needs-list">
                <div class="need-item materiaux">
                    <div class="need-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z" />
                        </svg>
                    </div>
                    <div class="need-info">
                        <div class="need-name">Bois de Construction</div>
                        <div class="need-desc">Planches et poutres</div>
                    </div>
                    <div class="need-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 45%;"></div>
                        </div>
                        <div class="progress-text">
                            <span>45% reçu</span>
                            <span class="progress-amount">2,250/5,000 m²</span>
                        </div>
                    </div>
                </div>

                <div class="need-item materiaux">
                    <div class="need-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z" />
                        </svg>
                    </div>
                    <div class="need-info">
                        <div class="need-name">Ciment & Béton</div>
                        <div class="need-desc">Pour les fondations</div>
                    </div>
                    <div class="need-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 70%;"></div>
                        </div>
                        <div class="progress-text">
                            <span>70% reçu</span>
                            <span class="progress-amount">35/50 tonnes</span>
                        </div>
                    </div>
                </div>

                <div class="need-item materiaux">
                    <div class="need-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z" />
                        </svg>
                    </div>
                    <div class="need-info">
                        <div class="need-name">Quincaillerie</div>
                        <div class="need-desc">Vis, clous, boulons</div>
                    </div>
                    <div class="need-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%;"></div>
                        </div>
                        <div class="progress-text">
                            <span>0% reçu</span>
                            <span class="progress-amount">0/50 kg</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MONETARY SECTION -->
        <div class="needs-section" style="margin-top: 2rem;">
            <div class="section-title" style="color: var(--y);">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,17V16H9V14H13V13H10A1,1 0 0,1 9,12V10A1,1 0 0,1 10,9H11V8H13V9H15V11H11V12H14A1,1 0 0,1 15,13V15A1,1 0 0,1 14,16H13V17H11Z" />
                </svg>
                Ressources Financières
            </div>
            <div class="needs-list">
                <div class="need-item argent">
                    <div class="need-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,17V16H9V14H13V13H10A1,1 0 0,1 9,12V10A1,1 0 0,1 10,9H11V8H13V9H15V11H11V12H14A1,1 0 0,1 15,13V15A1,1 0 0,1 14,16H13V17H11Z" />
                        </svg>
                    </div>
                    <div class="need-info">
                        <div class="need-name">Budget Opérationnel</div>
                        <div class="need-desc">Frais de maintenance</div>
                    </div>
                    <div class="need-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 80%;"></div>
                        </div>
                        <div class="progress-text">
                            <span>80% reçu</span>
                            <span class="progress-amount">8,000 €/10,000 €</span>
                        </div>
                    </div>
                </div>

                <div class="need-item argent">
                    <div class="need-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,17V16H9V14H13V13H10A1,1 0 0,1 9,12V10A1,1 0 0,1 10,9H11V8H13V9H15V11H11V12H14A1,1 0 0,1 15,13V15A1,1 0 0,1 14,16H13V17H11Z" />
                        </svg>
                    </div>
                    <div class="need-info">
                        <div class="need-name">Équipements Techniques</div>
                        <div class="need-desc">Outils et machinerie</div>
                    </div>
                    <div class="need-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 55%;"></div>
                        </div>
                        <div class="progress-text">
                            <span>55% reçu</span>
                            <span class="progress-amount">2,750 €/5,000 €</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER STATS -->
        <div class="footer-stats">
            <div class="footer-stat">
                <div class="footer-stat-label">Taux de Collecte Global</div>
                <div class="footer-stat-value">62%</div>
            </div>
            <div class="footer-stat">
                <div class="footer-stat-label">Besoins Totaux (€)</div>
                <div class="footer-stat-value">25,000 €</div>
            </div>
            <div class="footer-stat">
                <div class="footer-stat-label">Montant Collecté (€)</div>
                <div class="footer-stat-value">15,500 €</div>
            </div>
        </div>
    </div>