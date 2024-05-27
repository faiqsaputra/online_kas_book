<?php
// koneksi ke database
include "database/koneksi.php";

// session_start();

// if (!isset($_SESSION["login"])) {
//     header("location: log/login.php");
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
    body,
    html {
        height: 100%;
        /* Full height */
        margin: 0;
        /* Remove default margin */
    }

    #wrapper {
        display: flex;
        flex-direction: column;
        height: 100%;
        /* Full height */
    }

    #content-wrapper {
        flex: 1;
        /* Flex grow to fill available space */
        display: flex;
        flex-direction: column;
        /* Stack vertically */
    }

    #content {
        flex: 1;
        /* Flex grow to push the footer down */
    }
</style>


<body id="page-top">
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <nav class="navbar navbar-expand navbar-light bg-gray-100 topbar mb-4 static-top text-dark">
                    <a class="navbar-brand" href="#">
                        <img src="assets/img/logo.png" alt="CashBook" style="height: 40px; margin-right: 10px;">
                        <!-- Visible only on lg and larger screens -->
                        <ul class="list-inline mb-0 d-inline" style="font-weight: bold; ">
                            <li class="list-inline-item text-success">CASH</li>
                            <li class="list-inline-item" style="margin-left: -10px;">BOOK</li>
                        </ul>
                    </a>

                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="assets/img/boy.png" style="max-width: 60px">
                                <span class="ml-2 d-none d-lg-inline text-dark small">Maman Ketoprak</span>
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

                <!-- Content -->
                <div class="modal-body d-flex flex-row align-items-center justify-content-between " style="height: auto;">
                    <div class="modal-content border-0 h-100 d-block flex-row justify-content-between p-5">
                        <div class="d-block">
                            <ul class="list-inline mb-0 d-inline" style="font-weight: bold; ">
                                <h1 class="display-1 list-inline-item text-success">CASH</h1>
                                <h1 class="display-1 list-inline-item text-gray-900" style="margin-left: -10px;">BOOK</h1>
                                <h1 class="list-inline-item text-gray-900">.online</h1>
                            </ul>
                        </div>
                        <div class="modal-body mt-2 d-block">
                            <h2 class="modal-title" style="color: #3E69A8;">sit amet consectetur adipisicing elit.</h2>
                            <p class="modal-title">Pencatat pemasukan, pengeluaran, dan utang-piutang. Lengkap dengan fitur multiuser, laporan kas, dan online invoice. Mudah dan praktis untuk UMKM, pribadi, organisasi, dan bisnis.</p>
                        </div>
                        <a href="../db_online_kas/log/login.php">
                            <button type="button" class="d-flex justify-content-center align-items-center btn btn-success">
                                <h5 class="mr-5 mt-2 mb-2">Get Started</h5>
                                <i class="fa fa-angle-right"></i>
                                <i class="fa fa-angle-right"></i>
                            </button>
                        </a>
                    </div>
                    <div class="modal-content h-100 border-0">
                        <img src="assets/img/img.png" alt="">
                    </div>
                </div>
                <!-- Content -->
            </div>
            <!-- Footer -->
            <footer class="sticky-footer " style="background-color: #000000;">
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