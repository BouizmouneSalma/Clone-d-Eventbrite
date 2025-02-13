<?php require '../views/layout/header.php'; ?>

<div class="container mt-5">
    <h2>Créer un nouvel événement</h2>
    <form action="/events/create" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Titre de l'événement</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="event_date">Date de l'événement</label>
            <input type="date" class="form-control" id="event_date" name="event_date" required>
        </div>
        <div class="form-group">
            <label for="event_time">Heure de l'événement</label>
            <input type="time" class="form-control" id="event_time" name="event_time" required>
        </div>
        <div class="form-group">
            <label for="location">Lieu</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="form-group">
            <label for="category">Catégorie</label>
            <select class="form-control" id="category" name="category_id" required>
                <option value="">Sélectionnez une catégorie</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="total_tickets">Nombre total de billets</label>
            <input type="number" class="form-control" id="total_tickets" name="total_tickets" min="1" required>
        </div>
        <div class="form-group">
            <label for="price">Prix du billet</label>
            <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="image">Image de l'événement</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Créer l'événement</button>
    </form>
</div>

<?php require '../views/layout/footer.php'; ?>