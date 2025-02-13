<?php require '../views/layout/header.php'; ?>

<div class="container">
    <h2 class="mt-4">Gestion des Ventes</h2>
    
    <?php if (!empty($events)) : ?>
        <?php foreach ($events as $event) : ?>
            <div class="card mt-4">
                <div class="card-body">
                   <h2><?= htmlspecialchars($event['title']) ?></h2>
                    <p>Date : <?= htmlspecialchars($event['event_date']) ?></p>
                    <p><strong>Lieu :</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                    <p><strong>Tickets vendus :</strong> <?php echo count($event['participants']); ?></p>
                    
                    <?php if (!empty($event['participants'])) : ?>
                        <h5 class="mt-3">Participants :</h5>
                        <ul class="list-group">
                            <?php foreach ($event['participants'] as $participant) : ?>
                                <li class="list-group-item">
                                    <?php echo htmlspecialchars($participant['name']) . ' - ' . htmlspecialchars($participant['email']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>Aucun participant enregistré pour cet événement.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Aucun événement trouvé.</p>
    <?php endif; ?>
</div>

<?php require '../views/layout/footer.php'; ?>
