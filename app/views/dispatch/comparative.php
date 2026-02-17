<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1>Comparatif des 3 Modes de Dispatch</h1>
            <p class="text-muted">Comparez comment les ressources seraient distribuées avec chacun des trois modes.</p>
            
            <a href="/dispatch" class="btn btn-secondary mb-3">← Retour</a>

            <?php 
                $modes = [
                    'fifo' => 'Mode 1: FIFO (Par Date)',
                    'quantity' => 'Mode 2: Par Quantité',
                    'proportionality' => 'Mode 3: Proportionnalité'
                ];
            ?>

            <!-- Navigation par onglets -->
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <?php foreach ($modes as $key => $label): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $key === 'fifo' ? 'active' : ''; ?>" 
                                id="tab-<?php echo $key; ?>" 
                                data-bs-toggle="tab" 
                                data-bs-target="#content-<?php echo $key; ?>" 
                                type="button" 
                                role="tab">
                            <?php echo htmlspecialchars($label); ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Contenu des onglets -->
            <div class="tab-content mt-3">
                <?php foreach ($modes as $key => $label): ?>
                    <div class="tab-pane <?php echo $key === 'fifo' ? 'active' : ''; ?>" 
                         id="content-<?php echo $key; ?>" 
                         role="tabpanel">
                        
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Ressource</th>
                                        <th>Type</th>
                                        <th>Ville</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Demandée</th>
                                        <th class="text-center">Allouée</th>
                                        <?php if ($key === 'proportionality'): ?>
                                            <th class="text-center">Proportion</th>
                                        <?php endif; ?>
                                        <th class="text-center">Taux</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_demande = 0;
                                    $total_allouee = 0;
                                    
                                    foreach ($comparatif[$key] as $result): 
                                        $total_demande += $result['quantite_demandee'];
                                        $total_allouee += $result['quantite_allouee'];
                                        $taux = $result['quantite_demandee'] > 0 ? 
                                            round(($result['quantite_allouee'] / $result['quantite_demandee']) * 100, 1) : 0;
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars(substr($result['ressource_nom'], 0, 20)); ?></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php echo htmlspecialchars(substr($result['type'], 0, 10)); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars(substr($result['ville_demandeuse'], 0, 15)); ?></td>
                                            <td class="text-center text-muted">
                                                <?php echo date('d/m', strtotime($result['date_demande'])); ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning text-dark">
                                                    <?php echo $result['quantite_demandee']; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success">
                                                    <?php echo $result['quantite_allouee']; ?>
                                                </span>
                                            </td>
                                            <?php if ($key === 'proportionality'): ?>
                                                <td class="text-center">
                                                    <?php echo htmlspecialchars($result['proportion']); ?>%
                                                </td>
                                            <?php endif; ?>
                                            <td class="text-center">
                                                <?php 
                                                    $color = $taux >= 100 ? 'bg-success' : ($taux >= 50 ? 'bg-warning text-dark' : 'bg-danger');
                                                ?>
                                                <span class="badge <?php echo $color; ?>">
                                                    <?php echo $taux; ?>%
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">TOTAL</th>
                                        <th class="text-center">
                                            <span class="badge bg-warning text-dark">
                                                <?php echo $total_demande; ?>
                                            </span>
                                        </th>
                                        <th class="text-center">
                                            <span class="badge bg-success">
                                                <?php echo $total_allouee; ?>
                                            </span>
                                        </th>
                                        <?php if ($key === 'proportionality'): ?>
                                            <th></th>
                                        <?php endif; ?>
                                        <th class="text-center">
                                            <?php 
                                                $taux_total = $total_demande > 0 ? 
                                                    round(($total_allouee / $total_demande) * 100, 1) : 0;
                                            ?>
                                            <span class="badge bg-info">
                                                <?php echo $taux_total; ?>%
                                            </span>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Total Alloué</h6>
                                        <h3 class="text-success"><?php echo $total_allouee; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Total Demandé</h6>
                                        <h3 class="text-warning"><?php echo $total_demande; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Taux de Satisfaction</h6>
                                        <h3>
                                            <?php 
                                                $taux_total = $total_demande > 0 ? 
                                                    round(($total_allouee / $total_demande) * 100, 1) : 0;
                                                echo $taux_total;
                                            ?>%
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Résumé comparatif -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <h3>Analyse Comparative</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <strong>Mode 1: FIFO (Par Date)</strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>Principe:</strong> Le premier qui a demandé reçoit en premier.</p>
                                    <p><strong>Avantages:</strong></p>
                                    <ul>
                                        <li>Équité temporelle</li>
                                        <li>Transparence</li>
                                        <li>Pas de favoritisme</li>
                                    </ul>
                                    <p><strong>Inconvénients:</strong></p>
                                    <ul>
                                        <li>Peut ignorer les besoins réels</li>
                                        <li>Pas d'optimisation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-dark">
                                    <strong>Mode 2: Par Quantité</strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>Principe:</strong> La ville qui demande le moins reçoit en premier.</p>
                                    <p><strong>Avantages:</strong></p>
                                    <ul>
                                        <li>Priorité aux besoins modestes</li>
                                        <li>Maximise le nombre de bénéficiaires</li>
                                        <li>Réduction des inégalités</li>
                                    </ul>
                                    <p><strong>Inconvénients:</strong></p>
                                    <ul>
                                        <li>Peut pénaliser les besoins réels importants</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <strong>Mode 3: Proportionnalité</strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>Principe:</strong> Distribution proportionnelle aux demandes.</p>
                                    <p><strong>Avantages:</strong></p>
                                    <ul>
                                        <li>Équité proportionnelle</li>
                                        <li>Optimisation globale</li>
                                        <li>Pas de perte de ressource</li>
                                    </ul>
                                    <p><strong>Inconvénients:</strong></p>
                                    <ul>
                                        <li>Complexité de calcul</li>
                                        <li>Peut donner des quantités fractionnelles</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
    }

    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
    }

    .nav-tabs .nav-link {
        color: #495057;
        border: none;
        border-bottom: 3px solid transparent;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background-color: transparent;
        border-bottom-color: #0d6efd;
    }

    .table-responsive {
        border-radius: 5px;
        overflow: hidden;
    }
</style>
