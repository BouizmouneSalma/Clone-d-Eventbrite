<?php require '../views/layout/header.php'; ?>

<div class="container mt-5">
    <h2>Gestion des ventes</h2>
    
    <!-- Résumé des ventes -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total des ventes</h5>
                    <p class="card-text"><?php echo number_format($totalSales, 2); ?> €</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Billets vendus</h5>
                    <p class="card-text"><?php echo $totalTicketsSold; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Événements actifs</h5>
                    <p class="card-text"><?php echo $activeEvents; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des ventes par événement -->
    <h3>Ventes par événement</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Événement</th>
                <th>Date</th>
                <th>Billets vendus</th>
                <th>Total des ventes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventSales as $sale): ?>
                <tr>
                    <td><?php echo $sale['event_title']; ?></td>
                    <td><?php echo $sale['event_date']; ?></td>
                    <td><?php echo $sale['tickets_sold']; ?></td>
                    <td><?php echo number_format($sale['total_sales'], 2); ?> €</td>
                    <td>
                        <a href="/organizer/event-sales/<?php echo $sale['event_id']; ?>" class="btn btn-sm btn-info">Détails</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Graphique des ventes -->
    <h3>Graphique des ventes</h3>
    <canvas id="salesChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($salesData, 'date')); ?>,
            datasets: [{
                label: 'Ventes quotidiennes',
                data: <?php echo json_encode(array_column($salesData, 'amount')); ?>,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

<?php require '../views/layout/footer.php'; ?>