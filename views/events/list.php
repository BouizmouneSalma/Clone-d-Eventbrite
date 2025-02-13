<?php ob_start(); ?>
<section class="bg-indigo-600 text-white text-center py-20">
        <h1 class="text-4xl font-bold mb-4">Bienvenue sur EventManager</h1>
        <p class="text-lg mb-8">Organisez, gérez et participez à des événements exceptionnels avec facilité.</p>
        <a href="#content" class="py-3 px-6 bg-green-500 text-white font-semibold rounded-md hover:bg-green-400 transition-all duration-300">Voir les événements</a>
    </section>
<h2 class="text-3xl mt-16 font-bold text-center text-gray-900 mb-10">📅 Événements à venir</h2>

<div class="max-w-4xl mx-auto mb-10">
    <label for="category" class="block text-lg font-semibold text-gray-700 mb-2">🎯 Filtrer par catégorie</label>
    <div class="relative">
        <select id="category" name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-700 appearance-none">
            <option value="">Toutes les catégories</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>" <?php echo isset($_GET['category_id']) && $_GET['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto text-center" id="content">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8" >
        <?php foreach ($events as $event): ?>
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-transform transform hover:scale-105 duration-300">
                <img src="https://via.placeholder.com/350x200" alt="Event" class="w-full h-48 object-cover rounded-md mb-4">
                <h3 class="text-xl font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($event['title']); ?></h3>
                <p class="text-gray-600 mb-4 line-clamp-3"><?php echo htmlspecialchars($event['description']); ?></p>
                <p class="text-sm text-gray-500">📆 <?php echo date('d/m/Y H:i', strtotime($event['event_date'])); ?></p>
                <p class="text-sm text-gray-500">📍 <?php echo htmlspecialchars($event['location']); ?></p>
                <a href="/events/<?php echo $event['id']; ?>" class="inline-block mt-4 px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-all duration-300">Voir les détails</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.getElementById('category').addEventListener('change', function() {
    window.location.href = '/events?category_id=' + this.value;
});
</script>

<?php $content = ob_get_clean(); ?>
<?php require '../views/layout.php'; ?>