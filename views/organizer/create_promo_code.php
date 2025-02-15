<?php require '../views/layout/header.php'; ?>

<div class="max-w-2xl mx-auto mt-10 bg-white p-8 shadow-xl rounded-2xl hover:shadow-2xl transition duration-300">
    <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">🚀 Créer un Code Promo</h2>

    <form action="/organizer/promo-codes/create" method="POST" class="space-y-6">
        
        <div>
            <label for="event" class="block font-semibold text-gray-700 mb-1 flex items-center">
               
                Événement
            </label>
            <select id="event" name="event_id" required 
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Sélectionnez un événement</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['title']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="code" class="block font-semibold text-gray-700 mb-1 flex items-center">
                
                Code Promo
            </label>
            <input type="text" id="code" name="code" required 
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>

        <div>
            <label for="discount_percentage" class="block font-semibold text-gray-700 mb-1 flex items-center">
                
                Pourcentage de réduction
            </label>
            <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" required 
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
        </div>


        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="valid_from" class="block font-semibold text-gray-700 mb-1">Valide à partir de</label>
                <input type="date" id="valid_from" name="valid_from" required 
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div>
                <label for="valid_to" class="block font-semibold text-gray-700 mb-1">Valide jusqu'à</label>
                <input type="date" id="valid_to" name="valid_to" required 
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
        </div>


        <div>
            <label for="max_uses" class="block font-semibold text-gray-700 mb-1 flex items-center">
                
                Nombre maximum d'utilisations
            </label>
            <input type="number" id="max_uses" name="max_uses" min="1" 
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-red-500 focus:border-transparent">
        </div>


        <button type="submit" 
            class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold py-3 rounded-lg shadow-lg hover:from-indigo-600 hover:to-blue-500 transition duration-300 transform hover:scale-105">
             Créer le Code Promo
        </button>
    </form>
</div>

<?php require '../views/layout/footer.php'; ?>
