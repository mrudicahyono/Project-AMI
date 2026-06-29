<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo-title.png') ?>" />
    <link rel="stylesheet" href=" <?= base_url('assets/css/backend-plugin.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/backend.css?v=1.0.0') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/remixicon/fonts/remixicon.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') ?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />


    <!-- font awesome  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />


</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
            <div class="loader"></div>
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">

        <div class="iq-sidebar  sidebar-default ">
            <div class="iq-sidebar-logo d-flex align-items-center border-bottom">
                <a href="/pimpinan/dashboard" class="header-logo ml-2">
                    <img src="<?= base_url('assets/images/logo-umrah.png') ?>" alt="logo">
                    <!-- <h3 class="logo-title light-logo">Webkit</h3> -->
                </a>
                <div class="iq-menu-bt-sidebar ml-0">
                    <i class="ri-menu-line  wrapper-menu"></i>
                </div>
            </div>

            <div class="data-scrollbar" data-scroll="1">
                <nav class="iq-sidebar-menu">
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        <li <?= ($currentPage == 'dashboard') ? 'class="active"' : ''; ?>>
                            <a href="/pimpinan/dashboard" class="svg-icon">
                                <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <small class="ml-4">Dashboard</small>

                            </a>
                        </li>
                        <li <?= ($currentPage == 'lihat-berkas') ? 'class="active"' : ''; ?>>
                            <a href="/pimpinan/lihat-berkas" class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="25" height="25">
                                    <path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"></path>
                                </svg>
                                <small class="ml-4"> Lihat Laporan</small>
                            </a>
                        </li>
                        <li <?= ($currentPage == 'kelola-data') ? 'class="active"' : ''; ?>>
                            <a href="/pimpinan/kelola-data" class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25" height="25" fill="currentColor">
                                    <path d="M20 22H18V20C18 18.3431 16.6569 17 15 17H9C7.34315 17 6 18.3431 6 20V22H4V20C4 17.2386 6.23858 15 9 15H15C17.7614 15 20 17.2386 20 20V22ZM12 13C8.68629 13 6 10.3137 6 7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7C18 10.3137 15.3137 13 12 13ZM12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"></path>
                                </svg>
                                <small class="ml-4">Kelola Data Pribadi</small>
                            </a>
                        </li>




                    </ul>
                </nav>
                <div class="pt-5 pb-2"></div>
            </div>
        </div>
        <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
                <nav class="navbar navbar-expand-lg navbar-light p-0">
                    <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                        <i class="ri-menu-line wrapper-menu"></i>
                        <a href="/pimpinan/dashboard" class="header-logo">
                            <h4 class="logo-title text-uppercase">AMI UMRAH</h4>

                        </a>
                    </div>
                    <div class="navbar-breadcrumb">

                    </div>
                    <div class="d-flex align-items-center">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
                            <i class="ri-menu-3-line"></i>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto navbar-list align-items-center">
                                <li class="d-flex align-items-center">
                                    <a href="<?= base_url('logout') ?>" class="text-red  rounded">Logout</a>
                                </li>
                                <li class="nav-item nav-icon caption-content">
                                    <a href="#" class="search-toggle dropdown-toggle  d-flex align-items-center" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="<?= base_url('assets/images/user/user.png') ?>" class="img-fluid rounded-circle" alt="user">
                                        <div class="caption ml-2 mt-2">
                                            <small class="mb-0 line-height text-uppercase"><?= session()->get('name') ?><i class="las la-angle-down ml-2 w-50%"></i></small>
                                            <p><?= session()->get('role_id') ?></p>
                                        </div>

                                    </a>

                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="content-page">
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>

            </div>
        </div>
    </div>
    <!-- Wrapper End-->


    <footer class="iq-footer">
        <div class="container-fluid">

            <p class="text-center">Copyright © LPMPP UMRAH 2024 </p>

        </div>
    </footer>
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