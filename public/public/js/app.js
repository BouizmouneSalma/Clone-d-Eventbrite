document.addEventListener('DOMContentLoaded', function() {
    const reserveButtons = document.querySelectorAll('.reserve-button');

    reserveButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const eventId = this.dataset.eventId;

            fetch('/reserve', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ event_id: eventId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Réservation effectuée avec succès !');
                    // Mettre à jour l'interface utilisateur
                } else {
                    alert('Erreur lors de la réservation : ' + data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Une erreur est survenue lors de la réservation.');
            });
        });
    });
});