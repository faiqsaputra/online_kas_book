<?php
// koneksi ke database
include "database/koneksi.php";

session_start();

// if( !isset($_SESSION["home"])) {
//     header("location: home.php");
//     exit;
// }


?>

<?php error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="assets/img/cashbook.png" rel="icon">
    <title>CashBook - Dashboard</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/ruang-admin.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<style>
    /* Styling untuk ikon pengguna */
.user-icon {
    font-size: 24px; /* Ubah ukuran ikon sesuai kebutuhan */
}

/* Styling untuk informasi pengguna */
.user-info {
    font-size: 14px; /* Ukuran teks informasi pengguna */
}

/* Efek hover untuk item dropdown */
.dropdown-item:hover {
    background-color: #f8f9fc; /* Ubah warna latar belakang saat hover */
    color: #000; /* Ubah warna teks saat hover */
}

</style>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion bg-gradient-dark" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center bg-gradient-dark" href="home.php">
                <div class="sidebar-brand-icon">
                    <img src="assets/img/cashbook.png">
                </div>
                <div class="sidebar-brand-text mx-3">CashBook</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link text-gray-100" href="?page=dashboard">
                    <i class="fas fa-fw text-gray-100 col col-3 m-lg-0"><img src="assets/img/home.png"></i>
                    <span class="content m-sm-2">Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading text-gray-100">
                Features
            </div>
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="far fa-fw fa-window-maximize"></i>
                    <span>Bootstrap UI</span>
                </a>
                <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Bootstrap UI</h6>
                        <a class="collapse-item" href="alerts.html">Alerts</a>
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="dropdowns.html">Dropdowns</a>
                        <a class="collapse-item" href="modals.html">Modals</a>
                        <a class="collapse-item" href="popovers.html">Popovers</a>
                        <a class="collapse-item" href="progress-bar.html">Progress Bars</a>
                    </div>
                </div>
            </li> -->
            <li class="nav-item active">
                <a class="nav-link text-gray-100" href="?page=user">
                    <i class="fas fa-fw text-gray-100 col col-3 m-lg-0"><img src="assets/img/typcn_book.png"></i>
                    <span class="content m-sm-2">Data User</span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link text-gray-100" href="?page=kas">
                    <i class="fas fa-fw text-gray-100 col col-3 m-sm-1"><img src="assets/img/kas.png"></i>
                    <span class="content m-sm-0">Data Kas Umum</span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link text-gray-100" href="?page=laporan">
                    <i class="fas fa-fw text-gray-100 col col-3 m-lg-0"><img src="assets/img/laporan.png"></i>
                    <span class="content m-sm-2">Laporan</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="version" id="version-ruangadmin"></div>
        </ul>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <nav class="navbar navbar-expand navbar-light bg-gray-100 topbar mb-4 static-top text-dark">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3 ">
                        <i class="fa fa-bars bg-dark"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-icon mr-2">
                                        <i class="fa fa-user-circle text-primary"></i>
                                    </div>
                                    <div class="user-info d-none d-lg-inline-block mb-1">
                                        <span class="text-dark h5 font-weight-lighter"><?php echo $_SESSION['username']; ?></span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="log/logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">

                    <?php
                    $page = $_GET["page"];

                    // Dashboard
                    if ($page == "dashboard") {
                        include
                            "data/dashboard/dashboard.php";
                    }

                    //Data user
                    if ($page == "user") {
                        include
                            "data/data_user/user.php";
                    }

                    //Data kas
                    if ($page == "kas") {
                        include
                            "data/data_kas/kas.php";
                    }

                    //Laporan
                    if ($page == "laporan") {
                        include
                            "data/laporan/laporan.php";
                    }

                    ?>

                    <!-- Modal Logout -->
                    <!-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to logout?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                    <a href="login.html" class="btn btn-primary">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>copyright &copy; <script>
                                document.write(new Date().getFullYear());
                            </script> - developed by
                            <b><a href="#" target="_blank">SMKN1Bangsri</a></b>
                        </span>
                    </div>
                </div>
            </footer>
            <!-- Footer -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/ruang-admin.min.js"></script>
    <script src="assets/vendor/chart.js/Chart.min.js"></script>
    <script src="assets/js/demo/chart-area-demo.js"></script>
    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable(); // ID From dataTable 
            $('#dataTableHover').DataTable(); // ID From dataTable with Hover
        });
    </script>
</body>

</html>