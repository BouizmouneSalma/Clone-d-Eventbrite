<?php ob_start(); ?>


<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg mt-8 overflow-hidden">
    <?php if (!empty($event['image'])): ?>
        <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="w-full h-64 object-cover">
    <?php endif; ?>
    
    <div class="p-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($event['title']); ?></h1>
        <p class="text-gray-600 text-lg mb-4"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
        
        <div class="flex items-center space-x-4 text-gray-500 text-sm mb-4">
            <span class="flex items-center">
                <svg class="w-5 h-5 text-indigo-600 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v4l3 3m0 0l3-3V7m6 5c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                </svg>
                <?php echo date('d/m/Y H:i', strtotime($event['event_date'])); ?>
            </span>
            <span class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657A8 8 0 018 21m9-4a8 8 0 00-9-9m9 0a8 8 0 00-9-9m0 9a8 8 0 018 9"></path>
                </svg>
                <?php echo htmlspecialchars($event['location']); ?>
            </span>
        </div>

        <div class="flex justify-between items-center bg-gray-100 px-4 py-3 rounded-md mb-4">
            <span class="text-lg font-semibold text-indigo-600">Prix : <?php echo number_format($event['price'], 2); ?> €</span>
            <span class="text-sm text-gray-500">
        Billets restants : <?php echo $remainingTickets['remaining_tickets'] ?? 'Non disponible'; ?>
    </span>

        </div>
        
        <?php if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'organizer'): ?>
    <button class="reserve-button w-full bg-green-500 text-white font-semibold py-3 rounded-md shadow-md hover:bg-green-600 transition-all duration-300" data-event-id="<?php echo $event['id']; ?>">
        Réserver maintenant
    </button>
<?php elseif ($_SESSION['user_role'] === 'organizer'): ?>
    <p class="text-gray-500 text-center font-semibold">Vous êtes organisateur, la réservation est désactivée.</p>
<?php else: ?>
    <p class="text-red-500 font-semibold text-center">Cet événement est complet.</p>
<?php endif; ?>

    </div>
</div>



<?php $content = ob_get_clean(); ?>

<?php require '../views/layout.php'; ?>
