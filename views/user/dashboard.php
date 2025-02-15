<?php require '../views/layout/header.php'; ?>

<div class="container mx-auto ">
    <div class="text-center bg-gradient-to-r from-purple-500 to-indigo-600 text-white p-8 rounded-lg shadow-xl">
        <h1 class="text-4xl font-extrabold tracking-wide">Tableau de bord du participant</h1>
    </div>
    
    <div class="mt-6 ">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Dernier événement réservé</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php if (empty($lastReservedEvent)): ?>
            <div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg shadow-md text-center">
                <i class="fas fa-exclamation-triangle"></i> Vous n'avez réservé aucun événement récemment.
            </div>
        <?php else: ?>
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
                <h3 class="text-xl text-center font-semibold text-gray-800"> <?php echo htmlspecialchars($lastReservedEvent['title']); ?> </h3>
                <p class="text-gray-600">Lieu : <?php echo htmlspecialchars($lastReservedEvent['location']); ?></p>
                <p class="text-gray-500">Date : <?php echo date('d/m/Y', strtotime($lastReservedEvent['event_date'])); ?></p>
                <p class="text-gray-400">Ticket # : <?php echo htmlspecialchars($lastReservedEvent['ticket_number']); ?></p>
                <div class="flex gap-3 mt-4">
                    <a href="/events/<?php echo $lastReservedEvent['id']; ?>" class="px-5 py-2.5 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-300">Détails</a>
                    <!-- <a href="/organizer/cancel-reservation/<?php echo $reservation['id']; ?>" class="px-5 py-2.5 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600 transition duration-300">Annuler</a> -->
                    <a href="/reservations/cancel/<?php echo $lastReservedEvent['res']; ?>" 
                    class="px-5 py-2.5 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600 transition duration-300">
                     Annuler
                    </a>
                </div>
            </div>
            
        <?php endif; ?></div>
    </div>
    
    <div class="mt-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Historique des événements</h2>
        <?php if (empty($pastEvents)): ?>
            <div class="p-4 bg-blue-100 text-blue-800 rounded-lg shadow-md text-center">
                <i class="fas fa-calendar-check"></i> Vous n'avez participé à aucun événement pour le moment.
            </div>
        <?php else: ?>
            <table class="w-full bg-white rounded-lg shadow-md hover:shadow-lg">
                <thead class="bg-gradient-to-r from-purple-400 to-indigo-400 text-white text-lg text-center text-lg">
                    <tr>
                        <th class="p-4">Événement</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Lieu</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach ($pastEvents as $event): ?>
                        <tr class="border-b hover:bg-gray-100 transition-colors duration-300">
                            <td class="p-4 font-medium text-gray-800"> <?php echo htmlspecialchars($event['title']); ?> </td>
                            <td class="p-4 text-gray-600"> <?php echo date('d/m/Y', strtotime($event['event_date'])); ?> </td>
                            <td class="p-4 text-gray-600"> <?php echo htmlspecialchars($event['location']); ?> </td>
                            <td class="p-4 space-x-4">
                                <a href="/events/<?php echo $event['id']; ?>" class="px-5 py-2.5 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-300">Détails</a>
                                <a href="/reservations/cancel/<?php echo $event['res']; ?>" class="px-5 py-2.5 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600 transition duration-300">Annuler</a>
                              
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require '../views/layout/footer.php'; ?>
