
<?php
// Periksa apakah sesi sudah dimulai sebelumnya
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// tampil data kas umum
$db_kas = mysqli_query($conn, "SELECT * FROM db_kas");

// tampil jumlah transaksi
$jumlah_transaksi = mysqli_num_rows($db_kas);

// tampil total kas masuk 
$kas_masuk = 0;
foreach ($db_kas as $data) {
    $kas_masuk += $data['kas_masuk'];
}

// tampil total kas keluar 
$kas_keluar = 0;
foreach ($db_kas as $data) {
    $kas_keluar += $data['kas_keluar'];
}

// tampil total saldo
$saldo = $kas_masuk - $kas_keluar;

// Fungsi untuk format rupiah
function num($rp)
{
    if ($rp - 0) {
        $hasil = number_format($rp, 0, '.', '.');
    } else {
        $hasil = 0;
    }
    return $hasil;
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</div>

<div class="row mb-3">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body" style="background-color: #5CD1EB; border-radius: 10px;">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1 text-gray-900">Jumlah transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_transaksi; ?> Transaksi</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-2x text-succes"><img src="assets/img/transaksi.png" alt=""></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body" style="background-color: #31C32E; border-radius: 10px;">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-gray-900 text-uppercase mb-1">Kas Masuk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-900">Rp. <?= num($kas_masuk); ?></div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-2x text-primary"><img src="assets/img/pemasukan.png" alt=""></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body" style="background-color: #E5BD56; border-radius: 10px;">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Kas Keluar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.<?= num($kas_keluar); ?></div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-2x text-primary"><img src="assets/img/pengeluaran.png" alt=""></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body" style="background-color: #EE2632; border-radius: 10px;">
                <div class="row align-items-center" >
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1 text-gray-900">Saldo</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-900">Rp.<?= num($saldo); ?></div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-2x text-primary"><img src="assets/img/saldo.png" alt=""></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success' role='alert'>
            {$_SESSION['message']}
            </div>";
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
}
?>
