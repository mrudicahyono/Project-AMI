<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo-title.png') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/backend-plugin.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/backend.css?v=1.0.0') ?> ">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/remixicon/fonts/remixicon.css') ?> ">

    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') ?> ">
</head>

<body class="">
    <div id="loading">
        <div id="loading-center">
            <div class="loader"></div>
        </div>
    </div>

    <div class="wrapper">
        <section class="login-content">
            <div class="container">
                <div class="row align-items-center justify-content-center height-self-center">
                    <div class="col-lg-8">
                        <div class="card auth-card">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center auth-content">
                                    <div class="col-lg-6 bg-primary content-left">
                                        <div class="p-3">
                                            <h2 class="mb-2 text-white">Sign In</h2>
                                            <?php if (!empty(session()->getFlashdata('pesan'))) : ?>
                                                <div class="alert bg-<?= session()->getFlashdata('alert_type') ?>" role="alert">

                                                    <div class="iq-alert-text"> <small><?= session()->getFlashdata('pesan') ?> </small></div>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <i class="ri-close-line"></i>
                                                    </button>
                                                </div>
                                            <?php endif ?>




                                            <form method="POST" action="<?= base_url('/') ?>">
                                                <?= csrf_field() ?>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" type="email" name="email" value="<?= old('email'); ?>" placeholder=" ">
                                                            <label>Email</label>
                                                            <div class="invalid-feedback">

                                                                <?= $validation->getError('email') ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" type="password" name="password" placeholder=" ">
                                                            <label>Password</label>
                                                            <div class="invalid-feedback">

                                                                <?= $validation->getError('password') ?>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <button type="submit" class="btn btn-white text-sm w-25"><small>Sign In</small></button>
                                                <p class="mt-3"> <small>
                                                        Create an Account?&nbsp;<a href="<?= base_url('/register') ?>" class="text-white text-underline">Sign Up</a>
                                                    </small>
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 content-right">
                                        <img src="<?= base_url('assets/images/login/logo-login.png') ?>" class="img-fluid image-right" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Backend Bundle JavaScript -->
    <script src="<?= base_url('assets/js/backend-bundle.min.js') ?>"></script>

    <!-- Table Treeview JavaScript -->
    <script src="<?= base_url('assets/js/table-treeview.js') ?>"></script>

    <!-- Chart Custom JavaScript -->
    <script src="<?= base_url('assets/js/customizer.js') ?>"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="<?= base_url('assets/js/chart-custom.js') ?>"></script>
    <!-- Chart Custom JavaScript -->
    <script async src="<?= base_url('assets/js/slider.js') ?>"></script>

    <!-- app JavaScript -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>

    <script src="<?= base_url('assets/vendor/moment.min.js') ?>"></script>
</body>

</html>