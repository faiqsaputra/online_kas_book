<?php
// dashboard.php
session_start();
include 'koneksi.php';
include 'function.php';

$db_kas = mysqli_query($conn, "SELECT * FROM db_kas");

$jumlah_transaksi = mysqli_num_rows($db_kas);
$kas_masuk = 0;
$kas_keluar = 0;

foreach ($db_kas as $data) {
    $kas_masuk += $data['kas_masuk'];
    $kas_keluar += $data['kas_keluar'];
}

$saldo = $kas_masuk - $kas_keluar;

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
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body" style="background-color: #5CD1EB; border-radius: 10px;">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1 text-gray-900">Jumlah transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_transaksi; ?> Transaksi</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-2x text-success"><img src="assets/img/transaksi.png" alt=""></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body" style="background-color: #31C32E; border-radius: 10px;">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-gray-900 text-uppercase mb-1">Kas Masuk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-900">Rp. <?= num($kas_masuk); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-2x text-primary"><img src="assets/img/pemasukan.png" alt=""></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body" style="background-color: #E5BD56; border-radius: 10px;">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Kas Keluar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.<?= num($kas_keluar); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-2x text-primary"><img src="assets/img/pengeluaran.png" alt=""></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body" style="background-color: #EE2632; border-radius: 10px;">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1 text-gray-900">Saldo</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-900">Rp.<?= num($saldo); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-2x text-primary"><img src="assets/img/saldo.png" alt=""></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Kas Masuk per Bulan</h6>
            </div>
            <div class="card-body">
                <canvas id="kasMasukChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Kas Keluar per Bulan</h6>
            </div>
            <div class="card-body">
                <canvas id="kasKeluarChart"></canvas>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success' role='alert'>
            {$_SESSION['message']}
            </div>";
    unset($_SESSION['message']);
}
?>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="assets/js/chart.js"></script>

<!-- Script untuk Mengambil dan Menampilkan Data di Grafik -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch('kas.php')
        .then(response => response.json())
        .then(data => {
            const dataBulan = data.map(item => item.bulan);
            const dataKasMasuk = data.map(item => item.total_kas_masuk);
            const dataKasKeluar = data.map(item => item.total_kas_keluar);

            // Chart Kas Masuk
            const ctxMasuk = document.getElementById('kasMasukChart').getContext('2d');
            new Chart(ctxMasuk, {
                type: 'bar',
                data: {
                    labels: dataBulan,
                    datasets: [{
                        label: 'Kas Masuk',
                        data: dataKasMasuk,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart Kas Keluar
            const ctxKeluar = document.getElementById('kasKeluarChart').getContext('2d');
            new Chart(ctxKeluar, {
                type: 'line',
                data: {
                    labels: dataBulan,
                    datasets: [{
                        label: 'Kas Keluar',
                        data: dataKasKeluar,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
</script>
