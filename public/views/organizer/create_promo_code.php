<?php require '../views/layout/header.php'; ?>

<div class="container mt-5">
    <h2>Créer un nouveau code promo</h2>
    <form action="/organizer/promo-codes/create" method="POST">
        <div class="form-group">
            <label for="event">Événement</label>
            <select class="form-control" id="event" name="event_id" required>
                <option value="">Sélectionnez un événement</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?php echo $event['id']; ?>"><?php echo $event['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="code">Code promo</label>
            <input type="text" class="form-control" id="code" name="code" required>
        </div>
        <div class="form-group">
            <label for="discount_percentage">Pourcentage de réduction</label>
            <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" min="0" max="100" required>
        </div>
        <div class="form-group">
            <label for="valid_from">Valide à partir de</label>
            <input type="date" class="form-control" id="valid_from" name="valid_from" required>
        </div>
        <div class="form-group">
            <label for="valid_to">Valide jusqu'à</label>
            <input type="date" class="form-control" id="valid_to" name="valid_to" required>
        </div>
        <div class="form-group">
            <label for="max_uses">Nombre maximum d'utilisations</label>
            <input type="number" class="form-control" id="max_uses" name="max_uses" min="1">
        </div>
        <button type="submit" class="btn btn-primary">Créer le code promo</button>
    </form>
</div>

<?php require '../views/layout/footer.php'; ?>