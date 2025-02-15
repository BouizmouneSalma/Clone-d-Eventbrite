<?php ob_start(); ?>

<h1 class="text-4xl mt-10 text-center font-bold text-gray-800 mb-8">📊 Gestion des ventes</h1>

<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-700 flex items-center">
            🎟️ Filtrer par statut :
        </h2>
        <select id="statusFilter" class="p-2 border rounded">
            <option value="all">Tous</option>
            <option value="active">Actifs</option>
            <option value="cancelled">Annulés</option>
        </select>
    </div>

    <?php foreach ($salesData as $eventId => $data): ?>
        <div class="bg-gray-50  p-4 rounded-lg shadow-md mb-6">
            <h2 class="text-2xl text-center  font-semibold text-gray-800 mb-2 ">

                <?php echo htmlspecialchars($data['event']['title']); ?>
            </h2>
            <p class="text-gray-600">📅 Date : <strong><?php echo date('d/m/Y', strtotime($data['event']['event_date'])); ?></strong></p>
            <p class="text-gray-600">💰 Total des ventes : <strong><?php echo number_format($data['total_sales'], 2); ?> €</strong></p>

            <div class="overflow-x-auto mt-4">
                <table class="w-full border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-gray-700">
                            <th class="py-3 px-4 border-b"># ID</th>
                            <th class="py-3 px-4 border-b">👤 Utilisateur</th>
                            <th class="py-3 px-4 border-b">📅 Date de réservation</th>
                            <th class="py-3 px-4 border-b">📌 Statut</th>
                            <th class="py-3 px-4 border-b">⚡ Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['reservations'] as $reservation): ?>
                            <tr class="border-b hover:bg-gray-50 transition duration-200 reservation-row" data-status="<?php echo $reservation['status']; ?>">
                                <td class="py-3 px-4 font-mono"><?php echo $reservation['id']; ?></td>
                                <td class="py-3 px-4"><?php echo htmlspecialchars($reservation['user_email']); ?></td>
                                <td class="py-3 px-4"><?php echo date('d/m/Y H:i', strtotime($reservation['reservation_date'])); ?></td>
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-full text-white text-sm font-semibold 
                                        <?php echo $reservation['status'] === 'active' ? 'bg-green-500' : 'bg-gray-400'; ?>">
                                        <?php echo ucfirst($reservation['status']); ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <?php if ($reservation['status'] === 'active'): ?>
                                        <a href="/organizer/cancel-reservation/<?php echo $reservation['id']; ?>" 
                                            class="text-red-500 hover:text-red-700 transition duration-200 font-semibold cancel-button">
                                            ❌ Annuler
                                        </a>
                                    <?php else: ?>
                                    <a href="/organizer/active-reservation/<?php echo $reservation['id']; ?>" 
                                            class="text-green-500 hover:text-green-700 transition duration-200 font-semibold cancel-button">
                                            ✅ Activer
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>



<?php $content = ob_get_clean(); ?>
<?php require '../views/layout.php'; ?>
