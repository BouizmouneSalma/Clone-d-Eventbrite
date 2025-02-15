<?php require '../views/layout/header.php'; ?>

<div class="max-w-3xl mx-auto mt-10 p-8 bg-white shadow-lg rounded-lg">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Créer un nouvel événement</h2>
    <form action="/events/create" method="POST" enctype="multipart/form-data" class="space-y-6">
        <div>
            <label for="title" class="block text-lg font-medium text-gray-700">Titre de l'événement</label>
            <input type="text" id="title" name="title" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        
        <div>
            <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" rows="4" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="event_date" class="block text-lg font-medium text-gray-700">Date de l'événement</label>
                <input type="date" id="event_date" name="event_date" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="event_time" class="block text-lg font-medium text-gray-700">Heure de l'événement</label>
                <input type="time" id="event_time" name="event_time" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>
        
        <div>
            <label for="location" class="block text-lg font-medium text-gray-700">Lieu</label>
            <input type="text" id="location" name="location" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        
        <div>
            <label for="category" class="block text-lg font-medium text-gray-700">Catégorie</label>
            <select id="category" name="category_id" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Sélectionnez une catégorie</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="total_tickets" class="block text-lg font-medium text-gray-700">Nombre total de billets</label>
                <input type="number" id="total_tickets" name="total_tickets" min="1" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="price" class="block text-lg font-medium text-gray-700">Prix du billet</label>
                <input type="number" id="price" name="price" min="0" step="0.01" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>
        
        <div>
            <label for="image" class="block text-lg font-medium text-gray-700">Image de l'événement</label>
            <input type="file" id="image" name="image" accept="image/*"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        
        <button type="submit"
            class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-indigo-500 transition-all">Créer l'événement</button>
    </form>
</div>

<?php require '../views/layout/footer.php'; ?>
