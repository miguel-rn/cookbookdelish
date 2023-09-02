<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{site_name} - {page_title}</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="{base_url}assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{base_url}assets/css/styles.css" rel="stylesheet" />
</head>

<body>
    <nav class="navbar navbar-expand-lg py-5">
        <div class="container">
            <a class="navbar-brand" href="{base_url}">{site_name}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="input-group me-1 w-100">
                    <input type="text" class="form-control rounded-0" placeholder="Search..." aria-label="Input group example" aria-describedby="btnGroupAddon" />
                    <div class="input-group-text" id="btnGroupAddon">
                        <span class="material-symbols-outlined"> search </span>
                    </div>
                    {if $user_logged_in==true}
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary rounded-pill ms-2 me-1 dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome {user_first_name}!
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            {if $user_is_admin==true}
                            <li><a class="dropdown-item" href="{base_url}admin">Admin Panel</a></li>
                            {endif}
                            <li><a class="dropdown-item" href="{base_url}saved">Saved Recipes</a></li>
                            <li><a class="dropdown-item" href="{base_url}account">Account Settings</a></li>
                            <li><a class="dropdown-item" href="{base_url}logout">Logout</a></li>
                        </ul>
                    </div>
                    {else}
                    <button type="button" class="btn btn-outline-secondary rounded-pill ms-2 me-1" data-bs-toggle="modal" data-bs-target="#loginModal">Sign In</button>
                    <button type="button" class="btn btn-bd-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#registerModal">Sign Up</button>
                    {endif}
                </div>
            </div>
        </div>
    </nav>
    <!-- Page content-->
    <?= $this->renderSection('content') ?>

    <!-- Footer -->
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-muted">&copy; 2023</p>

            <p class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto text-muted text-pacifico">{site_name}</p>

            <p class="col-md-4 mb-0 text-muted justify-content-end d-flex">Made by Miguel Renaud-Nolte</p>
        </footer>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="loginModalLabel">Sign In</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="alert alert-danger d-none" role="alert" id="errorAlert"></div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <p>New to Cookbook Delish? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="registerModalLabel">Sign Up</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registrationForm">
                        <div class="alert alert-danger d-none" role="alert" id="errorAlert"></div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="acceptTerms" name="acceptTerms">
                            <label class="form-check-label" for="acceptTerms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Sign Up</button>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <p>Already have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Sign In</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="{base_url}assets/js/bootstrap.bundle.min.js"></script>
    <script src="{base_url}assets/js/jquery-3.6.4.min.js"></script>
    <script src="{base_url}assets/js/jquery.validate.min.js"></script>
    <script src="{base_url}assets/js/main.js"></script>
</body>

</html>