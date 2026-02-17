<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo htmlspecialchars($mode_label); ?></h1>
            <p class="text-muted">Simulation du dispatch de ressources</p>
            
            <a href="/dispatch" class="btn btn-secondary mb-3">← Retour</a>

            <?php if (empty($results)): ?>
                <div class="alert alert-info">
                    Aucune demande de ressource disponible.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Ressource</th>
                                <th>Type</th>
                                <th>Ville Demandeuse</th>
                                <th>Date Demande</th>
                                <th class="text-center">Quantité Demandée</th>
                                <th class="text-center">Quantité Allouée</th>
                                <?php if ($mode === 'proportionality'): ?>
                                    <th class="text-center">Proportion</th>
                                <?php endif; ?>
                                <th class="text-center">Taux Satisfaction</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total_demande = 0;
                            $total_allouee = 0;
                            
                            foreach ($results as $result): 
                                $total_demande += $result['quantite_demandee'];
                                $total_allouee += $result['quantite_allouee'];
                                $taux = $result['quantite_demandee'] > 0 ? 
                                    round(($result['quantite_allouee'] / $result['quantite_demandee']) * 100, 1) : 0;
                            ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($result['ressource_nom']); ?></strong></td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo htmlspecialchars($result['type']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($result['ville_demandeuse']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($result['date_demande'])); ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-warning">
                                            <?php echo htmlspecialchars($result['quantite_demandee']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">
                                            <?php echo htmlspecialchars($result['quantite_allouee']); ?>
                                        </span>
                                    </td>
                                    <?php if ($mode === 'proportionality'): ?>
                                        <td class="text-center">
                                            <?php echo htmlspecialchars($result['proportion']); ?>%
                                        </td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <?php 
                                            $color = $taux >= 100 ? 'bg-success' : ($taux >= 50 ? 'bg-warning' : 'bg-danger');
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
                                    <span class="badge bg-warning">
                                        <?php echo $total_demande; ?>
                                    </span>
                                </th>
                                <th class="text-center">
                                    <span class="badge bg-success">
                                        <?php echo $total_allouee; ?>
                                    </span>
                                </th>
                                <?php if ($mode === 'proportionality'): ?>
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

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Résumé</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Total demandé:</strong> <?php echo $total_demande; ?> unités</li>
                                    <li><strong>Total alloué:</strong> <?php echo $total_allouee; ?> unités</li>
                                    <li><strong>Taux de satisfaction:</strong> 
                                        <span class="badge bg-info">
                                            <?php echo $taux_total; ?>%
                                        </span>
                                    </li>
                                    <li><strong>Mode:</strong> <?php echo htmlspecialchars($mode_label); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <a href="/dispatch/results?mode=<?php echo $mode === 'fifo' ? 'quantity' : 'fifo'; ?>" class="btn btn-primary">
                            Comparer avec un autre mode →
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.1);
    }
    
    .badge {
        font-size: 0.95rem;
        padding: 0.5rem 0.75rem;
    }
</style>
