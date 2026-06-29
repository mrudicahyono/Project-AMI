<!-- 
    
    MOHON DI BACA !!!

    INI ADALAH SEMUA LAYOUT YANG BELUM DI BAGI BAGIKAN SESUAI KEBUTUHAN APLIKASI
    WALAPUN UDAH DI HAPUS BEBERAPA YANG TIDAK PENTING, NAMUN INI ADALAH LAYOUT INTI,
    YANG TIDAK BERPENGARUH KARENA TIDAK ROUTESNYA, DAN LAYOUT
    SUDAH DI DETAIL BERDASARKAN ROLE DAN MEMILIKI FOLDER MASING MASING
-->


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo-title.png') ?>" />
    <link rel="stylesheet" href=" <?= base_url('assets/css/backend-plugin.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/backend.css?v=1.0.0') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/remixicon/fonts/remixicon.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') ?>">
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
                <a href="../backend/index.html" class="header-logo ml-2">
                    <img src="<?= base_url('assets/images/logo-umrah.png') ?>" alt="logo">
                    <!-- <h3 class="logo-title light-logo">Webkit</h3> -->
                </a>
                <div class="iq-menu-bt-sidebar ml-0">
                    <i class="las la-bars wrapper-menu"></i>
                </div>
            </div>

            <div class="data-scrollbar" data-scroll="1">
                <nav class="iq-sidebar-menu">
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        <li class="active">
                            <a href="../backend/index.html" class="svg-icon">
                                <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <small class="ml-4">Dashboard</small>
                            </a>
                        </li>
                        <li class="">
                            <a href="../backend/page-employee.html" class="svg-icon">
                                <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <small class="ml-4">Kelola Akun</small>
                            </a>
                        </li>
                        <li class="">
                            <a href="../backend/page-employee.html" class="svg-icon">
                                <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <small class="ml-4">Kelola Ban-PT</small>
                            </a>
                        </li>
                        <li class="">
                            <a href="../backend/page-employee.html" class="svg-icon">
                                <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <small class="ml-4">Monitoring Prodi</small>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="#otherpage" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <small class="ml-4">Kelola Auditor</small>
                                <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="otherpage" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class=" ">
                                    <a href="#user" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                        <svg class="svg-icon" id="p-dash10" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <polyline points="17 11 19 13 23 9"></polyline>
                                        </svg>
                                        <small class="ml-4">Detail Data Auditee</small>
                                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                                    </a>
                                    <ul id="user" class="iq-submenu collapse" data-parent="#otherpage">
                                        <li class="">
                                            <a href="../app/user-profile.html">
                                                <i class="las la-minus"></i><small>User Profile</small>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="../app/user-add.html">
                                                <i class="las la-minus"></i><small>User Add</small>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="<?= base_url('app/user-list.html') ?>">
                                                <i class="las la-minus"></i><small>User List</small>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="">
                                    <a href="../backend/pages-invoice.html" class="svg-icon">
                                        <svg class="svg-icon" id="p-dash07" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                        <small class="ml-4">Hasil Auditee</small>
                                    </a>
                                </li>


                            </ul>
                        </li>
                        <li class="">
                            <a href="../backend/page-employee.html" class="svg-icon">
                                <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <small class="ml-4">Penugasan Auditor</small>
                            </a>
                        </li>
                        <li class="">
                            <a href="../backend/page-employee.html" class="svg-icon">
                                <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <small class="ml-4">Periode Audit</small>
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
                        <a href="../backend/index.html" class="header-logo">
                            <h4 class="logo-title text-uppercase">AMI UMRAH</h4>

                        </a>
                    </div>
                    <div class="navbar-breadcrumb">
                        <h5>Dashboard</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
                            <i class="ri-menu-3-line"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto navbar-list align-items-center">
                                <li class="nav-item nav-icon nav-item-icon dropdown">
                                    <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                        </svg>
                                        <span class="bg-primary "></span>
                                    </a>
                                    <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <div class="card shadow-none m-0">
                                            <div class="card-body p-0 ">
                                                <div class="cust-title p-3">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h5 class="mb-0">Notifications</h5>
                                                        <a class="badge badge-primary badge-card" href="#">3</a>
                                                    </div>
                                                </div>
                                                <div class="px-3 pt-0 pb-0 sub-card">
                                                    <a href="#" class="iq-sub-card">
                                                        <div class="media align-items-center cust-card py-3 border-bottom">
                                                            <div class="">
                                                                <img class="avatar-50 rounded-small" src="../assets/images/user/01.jpg" alt="01">
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <h6 class="mb-0">Emma Watson</h6>
                                                                    <small class="text-dark"><b>12 : 47 pm</b></small>
                                                                </div>
                                                                <small class="mb-0">Lorem ipsum dolor sit amet</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="iq-sub-card">
                                                        <div class="media align-items-center cust-card py-3 border-bottom">
                                                            <div class="">
                                                                <img class="avatar-50 rounded-small" src="../assets/images/user/02.jpg" alt="02">
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <h6 class="mb-0">Ashlynn Franci</h6>
                                                                    <small class="text-dark"><b>11 : 30 pm</b></small>
                                                                </div>
                                                                <small class="mb-0">Lorem ipsum dolor sit amet</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="iq-sub-card">
                                                        <div class="media align-items-center cust-card py-3">
                                                            <div class="">
                                                                <img class="avatar-50 rounded-small" src="../assets/images/user/03.jpg" alt="03">
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <h6 class="mb-0">Kianna Carder</h6>
                                                                    <small class="text-dark"><b>11 : 21 pm</b></small>
                                                                </div>
                                                                <small class="mb-0">Lorem ipsum dolor sit amet</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <a class="right-ic btn btn-primary btn-block position-relative p-2" href="#" role="button">
                                                    View All
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item nav-icon dropdown caption-content">
                                    <a href="#" class="search-toggle dropdown-toggle  d-flex align-items-center" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="<?= base_url('assets/images/user/user.png') ?>" class="img-fluid rounded-circle" alt="user">
                                        <div class="caption ml-3">
                                            <h6 class="mb-0 line-height">Jokowi<i class="las la-angle-down ml-2"></i></h6>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right border-none" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item d-flex svg-icon">
                                            <svg class="svg-icon mr-0 text-primary" id="h-01-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <a href="../app/user-profile.html">My Profile</a>
                                        </li>
                                        <li class="dropdown-item d-flex svg-icon">
                                            <svg class="svg-icon mr-0 text-primary" id="h-02-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <a href="../app/user-profile-edit.html">Edit Profile</a>
                                        </li>
                                        <li class="dropdown-item d-flex svg-icon">
                                            <svg class="svg-icon mr-0 text-primary" id="h-03-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <a href="../app/user-account-setting.html">Account Settings</a>
                                        </li>
                                        <li class="dropdown-item d-flex svg-icon">
                                            <svg class="svg-icon mr-0 text-primary" id="h-04-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            <a href="../app/user-privacy-setting.html">Privacy Settings</a>
                                        </li>
                                        <li class="dropdown-item  d-flex svg-icon border-top">
                                            <svg class="svg-icon mr-0 text-primary" id="h-05-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <a href="../backend/auth-sign-in.html">Logout</a>
                                        </li>
                                    </ul>
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

            <p class="text-center">Copyright © UMRAH 2024 </p>

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