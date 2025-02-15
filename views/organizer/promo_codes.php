<?php require '../views/layout/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Mes Codes Promo</h1>

    <div class="mb-6 flex justify-end">
        <a href="/organizer/promo-codes/create" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-lg transform hover:scale-105 transition duration-200">
            Créer un nouveau code promo
        </a>
    </div>

    <?php if (empty($promoCodes)): ?>
        <p class="text-gray-600 text-center">Vous n'avez pas encore créé de codes promo.</p>
    <?php else: ?>
        <div class="bg-white shadow-lg rounded-lg my-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Code</th>
                        <th class="py-3 px-6 text-left">Événement</th>
                        <th class="py-3 px-6 text-center">Réduction</th>
                        <th class="py-3 px-6 text-center">Validité</th>
                        <th class="py-3 px-6 text-center">Utilisations</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php foreach ($promoCodes as $promoCode): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <span class="font-medium"><?php echo htmlspecialchars($promoCode['code']); ?></span>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <?php echo htmlspecialchars($promoCode['event_title']); ?>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <?php echo $promoCode['discount_percentage']; ?>%
                            </td>
                            <td class="py-3 px-6 text-center">
                                <?php 
                                echo date('d/m/Y', strtotime($promoCode['valid_from']));
                                echo ' - ';
                                echo date('d/m/Y', strtotime($promoCode['valid_to']));
                                ?>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <?php echo $promoCode['uses_count']; ?> / <?php echo $promoCode['max_uses'] ?: '∞'; ?>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-4">
                                    <a href="/organizer/promo-codes/edit/<?php echo $promoCode['id']; ?>" class="w-6 h-6 text-gray-600 hover:text-purple-500 transform hover:scale-110 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                    <a href="/organizer/promo-codes/delete/<?php echo $promoCode['id']; ?>" class="w-6 h-6 text-red-600 hover:text-red-700 transform hover:scale-110 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require '../views/layout/footer.php'; ?>
