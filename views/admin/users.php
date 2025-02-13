<?php require '../views/layout/header.php'; ?>

<div class="container mt-5">
    <h2>Gestion des utilisateurs</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Date d'inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td><?php echo $user['created_at']; ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editUserModal<?php echo $user['id']; ?>">Modifier</button>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteUserModal<?php echo $user['id']; ?>">Supprimer</button>
                            <?php if (!$user['is_banned']) { ?>
                                <button type="button" class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#banUserModal<?php echo $user['id']; ?>">Bannir</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#unbanUserModal<?php echo $user['id']; ?>">Débannir</button>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <!-- Modal pour modifier l'utilisateur -->
                <div class="modal fade" id="editUserModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel<?php echo $user['id']; ?>">Modifier l'utilisateur</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/admin/users/update" method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <div class="form-group">
                                        <label for="edit_first_name<?php echo $user['id']; ?>">Prénom</label>
                                        <input type="text" class="form-control" id="edit_first_name<?php echo $user['id']; ?>" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_last_name<?php echo $user['id']; ?>">Nom</label>
                                        <input type="text" class="form-control" id="edit_last_name<?php echo $user['id']; ?>" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_email<?php echo $user['id']; ?>">Email</label>
                                        <input type="email" class="form-control" id="edit_email<?php echo $user['id']; ?>" name="email" value="<?php echo $user['email']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_role<?php echo $user['id']; ?>">Rôle</label>
                                        <select class="form-control" id="edit_role<?php echo $user['id']; ?>" name="role" required>
                                            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                                            <option value="organizer" <?php echo $user['role'] === 'organizer' ? 'selected' : ''; ?>>Organisateur</option>
                                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal pour supprimer l'utilisateur -->
                <div class="modal fade" id="deleteUserModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteUserModalLabel<?php echo $user['id']; ?>">Confirmer la suppression</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer l'utilisateur <?php echo $user['first_name'] . ' ' . $user['last_name']; ?> ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <form action="/admin/users/delete" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal pour bannir l'utilisateur -->
                <div class="modal fade" id="banUserModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="banUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="banUserModalLabel<?php echo $user['id']; ?>">Confirmer la bannissement</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir bannir l'utilisateur <?php echo $user['first_name'] . ' ' . $user['last_name']; ?> ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <form action="/admin/users/ban" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-danger">bannir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal pour debannir l'utilisateur -->
                <div class="modal fade" id="unbanUserModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="unbanUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="unbanUserModalLabel<?php echo $user['id']; ?>">Confirmer la debannissement</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir debannir l'utilisateur <?php echo $user['first_name'] . ' ' . $user['last_name']; ?> ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <form action="/admin/users/unban" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-success">debannir</button>
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