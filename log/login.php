<?php

require '../database/koneksi.php';

if(isset($_POST["submit"])) {

    // ambil data dari form login
    
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/logo.png" rel="icon">
    <title>RuangAdmin - Login</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center mb-5">
                                        <img src="../assets/img/Frame 296 (1).png" alt="">
                                    </div>
                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <label for="username" class="font-weight-bold h5 text-dark">USERNAME</label>
                                            <input type="email" name="username" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Masukan Username">
                                        </div>
                                        <div class="form-group mb-5">
                                            <label for="password" class="font-weight-bold h5 text-dark">PASSWORD</label>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                        </div>
                                        <div class="form-group d-flex flex-column justify-content-center align-items-center text-center">
                                            <button type="submit" name="submit" class="btn btn-block p-3 text-gray-100 font-weight-bold btn-flat" style="border-radius: 1rem; background: rgb(184,222,184); background: linear-gradient(0deg, rgba(184,222,184,1) 0%, rgba(13,195,42,1) 100%);">Login</button>
                                        </div>
                                        <hr>
                                        <div class="text-center">
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../assets/js/ruang-admin.min.js"></script>
</body>

</html>