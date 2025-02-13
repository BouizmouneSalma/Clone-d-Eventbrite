<?php require '../views/layout/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="/register">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="mb-6">
                    <label for="role" class="block text-gray-700 mb-2">Sélectionner un rôle :</label>
                    <select id="role" name="role" class="w-full p-2 border rounded" required>
                        <!-- <option value="admin">Admin</option> -->
                        <option value="participant">Participant</option>
                        <option value="organisateur">Organisateur</option>
                    </select>
                </div>
                        <div class="form-group" id="company_name_group" style="display: none;">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name">
                        </div>
                        <!-- <div class="form-group" id="website_group" style="display: none;">
                            <label for="website">Website</label>
                            <input type="url" class="form-control" id="website" name="website">
                        </div> -->
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('role').addEventListener('change', function() {
    var companyNameGroup = document.getElementById('company_name_group');
    var websiteGroup = document.getElementById('website_group');
    if (this.value === 'organisateur') {
        companyNameGroup.style.display = 'block';
        websiteGroup.style.display = 'block';
    } else {
        companyNameGroup.style.display = 'none';
        websiteGroup.style.display = 'none';
    }
});
</script>

<?php require '../views/layout/footer.php'; ?>

