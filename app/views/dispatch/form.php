<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Simulation de Dispatch de Ressources</h1>
            <p class="lead">Choisissez un mode de dispatch pour voir comment les ressources seraient distribuées aux villes.</p>
            
            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Mode 1: FIFO (Par Date)</h5>
                            <p class="card-text">Le premier qui a demandé reçoit en premier. Les demandes sont traitées par ordre chronologique.</p>
                            <a href="/dispatch/results?mode=fifo" class="btn btn-primary">Voir le dispatch</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Mode 2: Par Quantité</h5>
                            <p class="card-text">La ville qui demande le moins reçoit en premier. Les demandes sont traitées de la plus petite à la plus grande.</p>
                            <a href="/dispatch/results?mode=quantity" class="btn btn-primary">Voir le dispatch</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Mode 3: Proportionnalité</h5>
                            <p class="card-text">Distribution proportionnelle basée sur les quantités demandées. Chaque ville reçoit sa part selon: (demande) / (total demandes) × (disponible)</p>
                            <a href="/dispatch/results?mode=proportionality" class="btn btn-primary">Voir le dispatch</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Comparatif</h5>
                            <p class="card-text">Comparez les trois modes côte à côte pour voir les différences de distribution.</p>
                            <a href="/dispatch/comparative" class="btn btn-primary">Voir le comparatif</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <h3>Explication des modes</h3>
                    <ul>
                        <li><strong>FIFO (First In First Out):</strong> Les demandes sont satisfaites dans l'ordre chronologique. Favorise l'équité temporelle.</li>
                        <li><strong>Quantité minimale:</strong> Les villes ayant les besoins les plus modestes sont servies en premier. Favorise les villes avec les besoins les plus urgents/petits.</li>
                        <li><strong>Proportionnalité:</strong> Les ressources sont distribuées proportionnellement aux besoins. Favorise une distribution équitable basée sur les demandes.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-left: 4px solid #007bff;
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .card-body p {
        margin-bottom: 0;
        min-height: 60px;
        display: flex;
        align-items: center;
    }
</style>
