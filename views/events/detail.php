<?php ob_start(); ?>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($event['title']); ?></h1>
        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($event['description']); ?></p>
        <p class="text-sm text-gray-500 mb-2">Date: <?php echo date('d/m/Y H:i', strtotime($event['event_date'])); ?></p>
        <p class="text-sm text-gray-500 mb-4">Lieu: <?php echo htmlspecialchars($event['location']); ?></p>
        <p class="text-lg font-semibold mb-4">Prix: <?php echo number_format($event['price'], 2); ?> €</p>
        
        <?php if ($event['total_tickets'] > 0): ?>
            <button class="reserve-button bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors" data-event-id="<?php echo $event['id']; ?>">
                
                Réserver
            </button>
            
        <?php else: ?>
            <p class="text-red-500">Cet événement est complet.</p>
        <?php endif; ?>
    </div>
</div>

<script>
document.querySelector('.reserve-button').addEventListener('click', function(e) {
    e.preventDefault();
    const eventId = this.dataset.eventId;

    // Envoi de la requête pour réserver un ticket
    fetch('/reserve', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ event_id: eventId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Réservation effectuée avec succès !');
            this.disabled = true;
            this.textContent = 'Réservé';
        } else {
            alert('Erreur lors de la réservation : ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Une erreur est survenue lors de la réservation.');
    });
});


</script>

<?php $content = ob_get_clean(); ?>

<?php require '../views/layout.php'; ?>