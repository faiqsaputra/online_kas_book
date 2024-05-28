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

    @keyframes moveUpDown {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }

        100% {
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    .btn-success:hover {
        transform: scale(1.05);
    }

    @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: orange; }
        }

        .typed-text {
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            border-right: 3px solid orange;
            animation: typing 4s steps(40, end), blink-caret 0.75s step-end infinite;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .fade-in {
            animation: fadeIn 1s ease;
        }

        .modal-title {
            font-size: 2.5vw;
            color: #3E69A8;
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
                <div class="modal-body d-flex flex-row align-items-center justify-content-between table-responsive" style="height: auto;">
                    <div class="modal-content border-0 h-auto d-block flex-row justify-content-between p-5" style="animation: fadeIn 1s ease;">
                        <div class="d-block">
                            <ul class="list-inline mb-0 d-inline" style="font-weight: bold; ">
                                <h1 class="display-1 list-inline-item text-success">CASH</h1>
                                <h1 class="display-1 list-inline-item text-gray-900" style="margin-left: -10px;">BOOK</h1>
                                <h1 class="list-inline-item text-gray-900">.online</h1>
                            </ul>
                        </div>
                        <div class="modal-body mt-2 d-block">
                            <h2 class="modal-title">
                                <span class="typed-text font-weight-light h2" id="typed-text"></span>
                            </h2>
                            <p class="modal-dialog ml-0 mt-0 h5" style="">Pencatat pemasukan, pengeluaran, dan utang-piutang. Lengkap dengan fitur multiuser, laporan kas, dan online invoice. Mudah dan praktis untuk UMKM, pribadi, organisasi, dan bisnis.</p>
                        </div>
                        <a href="../db_online_kas/log/login.php" class="d-flex justify-content-center align-items-center btn btn-success" style="text-decoration: none; transition: transform 0.2s; height: 3rem; width: 15rem;">
                            <h5 class="mr-3 mt-2 mb-2">Get Started</h5>
                            <i class="fa fa-angle-right"></i>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                    <div class="modal-content h-100 border-0" style="position: relative; overflow: hidden;">
                        <img src="assets/img/enlarge_img.png" alt="" style="max-width: 100%; height: auto; animation: moveUpDown 3s infinite;">
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

        document.addEventListener("DOMContentLoaded", function() {
            const typedTextElement = document.getElementById("typed-text");
            const texts = [
                "Mencatat Keuangan Menjadi Semakin Mudah!",
                "Nyathet Keuangan Dadi Tansaya Gampang!",
                "Recording Finances Becomes Easier!"
            ];
            let textIndex = 0;
            let charIndex = 0;

            function type() {
                if (charIndex < texts[textIndex].length) {
                    typedTextElement.textContent += texts[textIndex].charAt(charIndex);
                    charIndex++;
                    setTimeout(type, 100); // Adjust the speed of typing here
                } else {
                    setTimeout(erase, 2000); // Wait before erasing the text
                }
            }

            function erase() {
                if (charIndex > 0) {
                    typedTextElement.textContent = texts[textIndex].substring(0, charIndex - 1);
                    charIndex--;
                    setTimeout(erase, 50); // Adjust the speed of erasing here
                } else {
                    textIndex = (textIndex + 1) % texts.length;
                    setTimeout(type, 500); // Wait before typing the next text
                }
            }

            setTimeout(type, 1000); // Initial delay before starting the typing animation
        });
    </script>
</body>

</html>