<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Register</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo-title.png') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/backend-plugin.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/backend.css?v=1.0.0') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/remixicon/fonts/remixicon.css') ?>" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') ?>" />
</head>

<body class=" ">

    <div id="loading">
        <div id="loading-center">
            <div class="loader"></div>
        </div>
    </div>
    <div class="wrapper">
        <section class="login-content">
            <div class="container">
                <div class="row align-items-center justify-content-center height-self-center">
                    <div class="col-lg-5">
                        <div class="card auth-card">
                            <div class="card-body p-0">
                                <div class=" align-items-center auth-content">
                                    <div class="col-lg-12 bg-primary content-left">
                                        <div class="p-3">
                                            <h2 class="mb-2 text-white">Sign Up</h2>
                                            <p>Create your account.</p>
                                            <?php if (!empty(session()->getFlashdata('gagal'))) : ?>
                                                <div class="alert bg-danger" role="alert">
                                                    <div class="iq-alert-text"> <small><?= session()->getFlashdata('gagal') ?> </small></div>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <i class="ri-close-line"></i>
                                                    </button>
                                                </div>
                                            <?php endif ?>
                                            <?php if (session('validation')) { ?>
                                                <div class="alert bg-danger" role="alert">
                                                    <ul>
                                                        <?php foreach (session('validation') as $error) : ?>
                                                            <li><?= esc($error) ?></li>
                                                        <?php endforeach ?>
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                            <form action="<?= base_url('register/save') ?>" method="POST">
                                                <?= csrf_field(); ?>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="text" placeholder=" " name="name" value="<?= old('name') ?>" autofocus required />
                                                            <label>Nama</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="email" placeholder=" " name="email" value="<?= old('email') ?>" required />
                                                            <label>Email</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="password" placeholder=" " name="password" required />
                                                            <label>Password</label>
                                                        </div>

                                                    </div>
                                                    <div class="col-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="password" placeholder=" " name="confirmpassword" required />
                                                            <label>Confirm Password</label>
                                                        </div>

                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <button type=" submit" class="btn btn-white w-100">
                                                            <small>
                                                                Submit
                                                            </small>
                                                        </button>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <small>
                                                            <p class="mt-3">
                                                                Already have an Account?&nbsp;
                                                                <a href="<?= base_url('/') ?>" class="text-white text-underline">Sign In</a>
                                                            </p>
                                                        </small>
                                                    </div>

                                                </div>


                                            </form>
                                        </div>
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