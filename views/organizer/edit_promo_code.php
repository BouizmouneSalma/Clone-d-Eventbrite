<?php require '../views/layout/header.php'; ?>
<h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Modifier le code promo</h1>
<div class="flex justify-center items-center min-h-screen px-4 py-8">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
       


        <form action="/organizer/promo-codes/edit/<?php echo $promoCode['id']; ?>" method="POST">
            <div class="mb-4">
                <label for="code" class="block text-gray-700 text-sm font-semibold mb-2">Code</label>
                <input type="text" id="code" name="code" value="<?php echo htmlspecialchars($promoCode['code']); ?>" required
                       class="shadow-sm appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
            </div>

            <div class="mb-4">
                <label for="discount_percentage" class="block text-gray-700 text-sm font-semibold mb-2">Pourcentage de réduction</label>
                <input type="number" id="discount_percentage" name="discount_percentage" value="<?php echo $promoCode['discount_percentage']; ?>" required
                       min="0" max="100" step="0.01"
                       class="shadow-sm appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
            </div>

            <div class="mb-4">
                <label for="valid_from" class="block text-gray-700 text-sm font-semibold mb-2">Valide à partir de</label>
                <input type="datetime-local" id="valid_from" name="valid_from" value="<?php echo date('Y-m-d\TH:i', strtotime($promoCode['valid_from'])); ?>" required
                       class="shadow-sm appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
            </div>

            <div class="mb-4">
                <label for="valid_to" class="block text-gray-700 text-sm font-semibold mb-2">Valide jusqu'à</label>
                <input type="datetime-local" id="valid_to" name="valid_to" value="<?php echo date('Y-m-d\TH:i', strtotime($promoCode['valid_to'])); ?>" required
                       class="shadow-sm appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
            </div>

            <div class="mb-4">
                <label for="max_uses" class="block text-gray-700 text-sm font-semibold mb-2">Nombre maximum d'utilisations (laisser vide pour illimité)</label>
                <input type="number" id="max_uses" name="max_uses" value="<?php echo $promoCode['max_uses'] ?: ''; ?>"
                       min="1" step="1"
                       class="shadow-sm appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Mettre à jour le code promo
                </button>
                <a href="/organizer/promo-codes" class="inline-block align-baseline font-semibold text-sm text-blue-500 hover:text-blue-700">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        const validFrom = new Date(document.getElementById('valid_from').value);
        const validTo = new Date(document.getElementById('valid_to').value);

        if (validFrom >= validTo) {
            event.preventDefault();
            alert('La date de fin de validité doit être postérieure à la date de début.');
        }
    });
});
</script>

<?php require '../views/layout/footer.php'; ?>
