<?php require '../views/layout/header.php'; ?>

<div class="container mt-5">
    <h2 class="font-bold mb-4 text-3xl">Gestion des utilisateurs</h2>
    <table class="min-w-full table-auto bg-white border border-gray-200 rounded-lg shadow-md">
    <thead class="bg-gray-100">
        <tr class="text-left text-lg font-semibold text-gray-600">
            <th class="px-4 py-2 border-b">ID</th>
            <th class="px-4 py-2 border-b">Nom</th>
            <th class="px-4 py-2 border-b">Email</th>
            <th class="px-4 py-2 border-b">Rôle</th>
            <th class="px-4 py-2 border-b">Date d'inscription</th>
            <th class="px-4 py-2 border-b">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border-b text-gray-700"><?php echo $user['id']; ?></td>
                <td class="px-4 py-2 border-b text-gray-700"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                <td class="px-4 py-2 border-b text-gray-700"><?php echo $user['email']; ?></td>
                <td class="px-4 py-2 border-b text-gray-700"><?php echo $user['role']; ?></td>
                <td class="px-4 py-2 border-b text-gray-700"><?php echo $user['created_at']; ?></td>
                <td class="px-4 py-2 border-b">
                    <div class="flex space-x-2">
                        <button type="button" class="btn btn-sm btn-primary px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg" data-toggle="modal" data-target="#editUserModal<?php echo $user['id']; ?>">Modifier</button>
                        <button type="button" class="btn btn-sm btn-danger px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg" data-toggle="modal" data-target="#deleteUserModal<?php echo $user['id']; ?>">Supprimer</button>
                        <?php if (!$user['is_banned']) { ?>
                            <button type="button" class="btn btn-sm btn-warning px-4 py-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded-lg" data-toggle="modal" data-target="#banUserModal<?php echo $user['id']; ?>">Bannir</button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-sm btn-success px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded-lg" data-toggle="modal" data-target="#unbanUserModal<?php echo $user['id']; ?>">Débannir</button>
                        <?php } ?>
                    </div>
                </td>
            </tr>
                <!-- Modal pour modifier l'utilisateur -->
                <div class="modal fade" id="editUserModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
    <div class="modal-dialog relative w-full max-w-lg mx-auto" role="document">
        <div class="modal-content rounded-lg shadow-lg bg-white">
            <div class="modal-header flex justify-between items-center p-4 border-b">
                <h5 class="modal-title text-xl font-semibold text-gray-700" id="editUserModalLabel<?php echo $user['id']; ?>">Modifier l'utilisateur</h5>
                <button type="button" class="text-gray-500 hover:text-gray-700" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/users/update" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <div class="form-group mb-4">
                        <label for="edit_first_name<?php echo $user['id']; ?>" class="block text-sm font-medium text-gray-600">Prénom</label>
                        <input type="text" class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="edit_first_name<?php echo $user['id']; ?>" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="edit_last_name<?php echo $user['id']; ?>" class="block text-sm font-medium text-gray-600">Nom</label>
                        <input type="text" class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="edit_last_name<?php echo $user['id']; ?>" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="edit_email<?php echo $user['id']; ?>" class="block text-sm font-medium text-gray-600">Email</label>
                        <input type="email" class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="edit_email<?php echo $user['id']; ?>" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="edit_role<?php echo $user['id']; ?>" class="block text-sm font-medium text-gray-600">Rôle</label>
                        <select class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="edit_role<?php echo $user['id']; ?>" name="role" required>
                            <option value="participant" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                            <option value="organizer" <?php echo $user['role'] === 'organizer' ? 'selected' : ''; ?>>Organisateur</option>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer p-4 border-t">
                    <button type="button" class="btn btn-secondary text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-md" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary text-white bg-blue-500 hover:bg-blue-600 px-6 py-2 rounded-md">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

                <!-- Modal pour supprimer l'utilisateur -->
                <div class="modal fade" id="deleteUserModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
    <div class="modal-dialog relative w-full max-w-lg mx-auto" role="document">
        <div class="modal-content rounded-lg shadow-lg bg-white">
            <div class="modal-header flex justify-between items-center p-4 border-b">
                <h5 class="modal-title text-xl font-semibold text-gray-700" id="deleteUserModalLabel<?php echo $user['id']; ?>">Confirmer la suppression</h5>
                <button type="button" class="text-gray-500 hover:text-gray-700" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-gray-700">
                Êtes-vous sûr de vouloir supprimer l'utilisateur <?php echo $user['first_name'] . ' ' . $user['last_name']; ?> ?
            </div>
            <div class="modal-footer p-4 border-t flex justify-between">
                <button type="button" class="btn btn-secondary text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-md" data-dismiss="modal">Annuler</button>
                <form action="/admin/users/delete" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <button type="submit" class="btn btn-danger text-white bg-red-500 hover:bg-red-600 px-6 py-2 rounded-md">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

                <!-- Modal pour bannir l'utilisateur -->
                <div class="modal fade" id="banUserModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="banUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
    <div class="modal-dialog relative w-full max-w-lg mx-auto" role="document">
        <div class="modal-content rounded-lg shadow-lg bg-white">
            <div class="modal-header flex justify-between items-center p-4 border-b">
                <h5 class="modal-title text-xl font-semibold text-gray-700" id="banUserModalLabel<?php echo $user['id']; ?>">Confirmer le bannissement</h5>
                <button type="button" class="text-gray-500 hover:text-gray-700" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-gray-700">
                Êtes-vous sûr de vouloir bannir l'utilisateur <?php echo $user['first_name'] . ' ' . $user['last_name']; ?> ?
            </div>
            <div class="modal-footer p-4 border-t flex justify-between">
                <button type="button" class="btn btn-secondary text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-md" data-dismiss="modal">Annuler</button>
                <form action="/admin/users/ban" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <button type="submit" class="btn btn-danger text-white bg-red-500 hover:bg-red-600 px-6 py-2 rounded-md">Bannir</button>
                </form>
            </div>
        </div>
    </div>
</div>

                <!-- Modal pour debannir l'utilisateur -->
                <div class="modal fade" id="unbanUserModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="unbanUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
    <div class="modal-dialog relative w-full max-w-lg mx-auto" role="document">
        <div class="modal-content rounded-lg shadow-lg bg-white">
            <div class="modal-header flex justify-between items-center p-4 border-b">
                <h5 class="modal-title text-xl font-semibold text-gray-700" id="unbanUserModalLabel<?php echo $user['id']; ?>">Confirmer le débannissement</h5>
                <button type="button" class="text-gray-500 hover:text-gray-700" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-gray-700">
                Êtes-vous sûr de vouloir débannir l'utilisateur <?php echo $user['first_name'] . ' ' . $user['last_name']; ?> ?
            </div>
            <div class="modal-footer p-4 border-t flex justify-between">
                <button type="button" class="btn btn-secondary text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-md" data-dismiss="modal">Annuler</button>
                <form action="/admin/users/unban" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <button type="submit" class="btn btn-success text-white bg-green-500 hover:bg-green-600 px-6 py-2 rounded-md">Débannir</button>
                </form>
            </div>
        </div>
    </div>
</div>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require '../views/layout/footer.php'; ?>