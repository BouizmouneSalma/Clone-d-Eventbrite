<?php ob_start(); ?>

<h1 class="text-4xl mt-10 text-center font-bold text-gray-800 mb-8">Tableau de bord organisateur</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
        <div class="bg-indigo-100 p-3 rounded-full mr-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 10h6m-3-3v6m9-3c0 7-9 13-9 13S3 14 3 7a9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-semibold text-gray-700">Événements totaux</h2>
            <p class="text-3xl font-bold text-indigo-700"><?php echo $stats['total_events']; ?></p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
        <div class="bg-green-100 p-3 rounded-full mr-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 16v-4m0 0V8m0 4H8m8 0h4M4 4l16 16"></path>
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-semibold text-gray-700">Billets vendus</h2>
            <p class="text-3xl font-bold text-green-700"><?php echo $stats['total_tickets_sold']; ?></p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
        <div class="bg-yellow-100 p-3 rounded-full mr-4">
            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-semibold text-gray-700">Revenus totaux</h2>
            <p class="text-3xl font-bold text-yellow-700"><?php echo number_format($stats['total_revenue'], 2); ?> €</p>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-lg mb-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Mes événements</h2>
    <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
            <tr class="text-left text-gray-700">
                <th class="py-3 px-4 border-b">Titre</th>
                <th class="py-3 px-4 border-b">Date</th>
                <th class="py-3 px-4 border-b">Billets vendus</th>
                <th class="py-3 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4"><?php echo htmlspecialchars($event['title']); ?></td>
                    <td class="py-3 px-4"><?php echo date('d/m/Y', strtotime($event['event_date'])); ?></td>
                    <td class="py-3 px-4"><?php echo $event['tickets_sold'] ?? 0; ?> / <?php echo $event['total_tickets']; ?></td>
                    <td class="py-3 px-4 flex space-x-2">
                        <a href="/events/<?php echo $event['id']; ?>" class="text-blue-500 hover:text-blue-700">Voir</a>
                        <a href="/events/del/<?php echo $event['id']; ?>" class="text-red-500 hover:text-red-700">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Actions rapides</h2>
    <div class="flex flex-wrap gap-3">
        <a href="/events/create" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 shadow-md transition-all">Créer un événement</a>   
        <a href="/organizer/manage-sales" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 shadow-md transition-all">Gérer les ventes</a>
        <a href="/organizer/promo-codes/create" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 shadow-md transition-all">Créer un code promo</a>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require '../views/layout.php'; ?>
