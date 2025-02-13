<?php ob_start(); ?>

<h1 class="text-3xl mt-10 text-center font-bold mb-6">Tableau de bord organisateur</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Événements totaux</h2>
        <p class="text-3xl font-bold"><?php echo $stats['total_events']; ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Billets vendus</h2>
        <p class="text-3xl font-bold"><?php echo $stats['total_tickets_sold']; ?></p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Revenus totaux</h2>
        <p class="text-3xl font-bold"><?php echo number_format($stats['total_revenue'], 2); ?> €</p>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <h2 class="text-2xl font-semibold mb-4">Mes événements</h2>
    <table class="w-full">
        <thead>
            <tr>
                <th class="text-left">Titre</th>
                <th class="text-left">Date</th>
                <th class="text-left">Billets vendus</th>
                <th class="text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($event['event_date'])); ?></td>
                    <td><?php echo $event['sold_tickets'] ?? 0; ?> / <?php echo $event['total_tickets']; ?></td>

                    <td>
                        <a href="/events/<?php echo $event['id']; ?>" class="text-blue-500 hover:underline mr-2">Voir</a>
                        <a href="/events/del/<?php echo $event['id']; ?>" class="text-red-500 hover:underline mr-2">delete</a>
                        <!-- <a href="/organizer/export-participants/<?php echo $event['id']; ?>" class="text-green-500 hover:underline">Exporter </a> -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Actions rapides</h2>
    <a href="/events/create" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors mr-2">Créer un événement</a>   
    <a href="/organizer/gerer" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors mr-2">Gerer les ventes</a>
    <a href="/organizer/promo-codes/create" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">Créer un code promo</a>
</div>

<?php $content = ob_get_clean(); ?>

<?php require '../views/layout.php'; ?>