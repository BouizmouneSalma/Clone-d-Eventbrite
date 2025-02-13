<?php ob_start(); ?>

<h1 class="text-3xl mt-10 text-center font-bold mb-6">Tableau de bord administrateur</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Utilisateurs totaux</h2>
        <p class="text-3xl font-bold"><?php echo $stats['total_users']; ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Événements totaux</h2>
        <p class="text-3xl font-bold"><?php echo $stats['total_events']; ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Billets vendus</h2>
        <p class="text-3xl font-bold"><?php echo $stats['total_tickets_sold']; ?></p>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <h2 class="text-2xl font-semibold mb-4">Événements en attente d'approbation</h2>
    <table class="w-full">
        <thead>
            <tr>
                <th class="text-left">Titre</th>
                <th class="text-left">Organisateur</th>
                <th class="text-left">Date</th>
                <th class="text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendingEvents as $event): ?>
                <tr>
                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                    <td><?php echo htmlspecialchars($event['first_name']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($event['event_date'])); ?></td>
                    <td>
                        <form method="POST" action="/admin/events" class="inline">
                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                            <button type="submit" name="action" value="approve" class="bg-green-500 text-white px-2 py-1 rounded text-sm">Approuver</button>
                            <button type="submit" name="action" value="reject" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Rejeter</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Actions rapides</h2>
    <a href="/admin/users" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors mr-2">Gérer les utilisateurs</a>
    
</div>

<?php $content = ob_get_clean(); ?>

<?php require '../views/layout.php'; ?>