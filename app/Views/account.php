<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Your Account</h5>
                    <form id="updateAccount">
                        <div class="alert alert-danger d-none" role="alert" id="errorAlert"></div>
                        <div class="alert alert-success d-none" role="alert" id="successAlert"></div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{user_first_name}">
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="first_name" name="last_name" value="{user_last_name}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{user_email}">
                        </div>
                        <button type="submit" class="btn btn-bd-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Update Password</h5>
                    <form id="updatePassword">
                        <div class="alert alert-danger d-none" role="alert" id="errorAlert"></div>
                        <div class="alert alert-success d-none" role="alert" id="successAlert"></div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-bd-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>