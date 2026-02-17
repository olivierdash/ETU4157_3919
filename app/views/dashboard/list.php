
<header class="main-header">
            <h1>Tableau de Bord des Sinistrés</h1>
            <p>Suivi des besoins et distribution des dons - Février 2026</p>
            
            <!-- Boutons d'action -->
            <div class="header-actions">
                <a href="/dispatch" class="btn btn-dispatch">
                    📦 Dispatcher les Ressources
                </a>
            </div>
            
            <!-- Stats rapides -->
            <div class="header-stats">
                <div class="stat-item">
                    <span class="stat-value">156</span>
                    <span class="stat-label">Sinistrés</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">24</span>
                    <span class="stat-label">Villes</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value"><?= $countDons ?></span>
                    <span class="stat-label">Dons</span>
                </div>
            </div>
        </header>

        <!-- Contenu Principal -->
        <main class="container">
            <div class="dashboard-grid">
                <?php foreach ($ressource_lib as $row): ?>
                    <article class="city-card">
                        <div class="card-header">
                            <h2><?= $row['nom_ville']; ?></h2>
                        </div>

                        <div class="card-body">
                            <section class="section-besoins">
                                <h3>Besoins (Ressources)</h3>
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Type</th>
                                            <th>P.U.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($row['besoins'] as $ligne): ?>
                                            <tr>
                                                <td><?= $ligne['nom'] ?></td>
                                                <td>
                                                    <span
                                                        class="badge <?= strtolower($ligne['type_ressource']) === 'materiel' ? 'mat' : 'fin' ?>">
                                                        <?= $ligne['type_ressource']; ?>
                                                    </span>
                                                </td>
                                                <td><?= $ligne['prixUnitaire'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </section>

                        <section class="section-dons">
                            <h3>Dons Attribués</h3>
                            <ul class="donation-list">
                                <li>
                                    <div class="donation-info">
                                        <span class="qty">50 unités</span>
                                        <span class="date">Reçu le: 05/03/2024</span>
                                    </div>
                                </li>
                            </ul>
                        </section>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </main>

    <!-- Script pour le menu mobile -->
 
