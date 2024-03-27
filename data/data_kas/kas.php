<?php
require 'functions.php';

// tampil data kas
$db_kas = query("SELECT * FROM db_kas");

// function urut id_kas kas Masuk
$no = mysqli_query($conn, "SELECT id_kas FROM db_kas ORDER BY id_kas DESC");
$id_kas = mysqli_fetch_array($no);
$kode   = $id_kas['id_kas'];

$urut   = substr($kode, 2, 3);

$tambah = (int) $urut;

if(strlen($tambah) == 1) {
    $format1 = "KS"."00".$tambah;
} elseif(strlen($tambah) == 2) {
    $format1 = "KS"."0".$tambah;
} else {
    $format1 = "KS".$tambah;
}

// function urut nomor bukti kas masuk
if(strlen($tambah) == 1) {
    $format2 = "MSK"."00".$tambah;
} elseif(strlen($tambah) == 2) {
    $format2 = "MSK"."0".$tambah;
} else {
    $format2 = "MSK".$tambah;
}

// function urut nomor bukti kas keluar
if(strlen($tambah) == 1) {
    $format3 = "KLR"."00".$tambah;
} elseif(strlen($tambah) == 2) {
    $format3 = "KLR"."0".$tambah;
} else {
    $format3 = "KLR".$tambah;
}

// aksi tambah data kas
if (isset($_POST["tambah"])) {
    // cek apakah data berhasil di tambahkan atau tidak
    if(tambah($_POST) > 0) {
        echo "<script>
            alert('Data berhasil di tambahkan!');
            document.location.href = 'index.php?page=kas';
            </script>";
    } else {
        echo "<script>
            alert('Data gagal di tambahkan!');
            </script>";
    }
}
?>


<div class="content">
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="text-center">
                <h1 class="m-0 font-weight-bold text-primary">DATA KAS UMUM</h1>
                <hr>
            </div>

            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <button type="button" data-toggle="modal" data-target="#kas_masuk" class="btn btn-primary">
                        <i class="fa fa-plus"></i>Kas Masuk</button>

                    <button type="button" data-toggle="modal" data-target="#kas_keluar" class="btn btn-primary">
                        <i class="fa fa-plus"></i>Kas Keluar</button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Id Kas</th>
                                <th scope="col" class="text-center">Tgl-bln-thn</th>
                                <th scope="col" class="text-center">No Bukti</th>
                                <th scope="col" class="text-center">Uraian</th>
                                <th scope="col" class="text-center">Kas Masuk</th>
                                <th scope="col" class="text-center">Kas Keluar</th>
                                <th scope="col" class="text-center">Saldo</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1; ?>
                            <?php foreach ($db_kas as $row) : ?>

                                <tr>
                                    <td class="text-center"><?= $i; ?></td>
                                    <td class="text-center"><?= $row["id_kas"]; ?></td>
                                    <td class="text-center"><?= $row["tanggal"]; ?></td>
                                    <td class="text-center"><?= $row["no_bukti"]; ?></td>
                                    <td class="text-center"><?= $row["uraian"]; ?></td>

                                    <?php
                                    if ($i == 1) {
                                        // pertama kali diklarifikasi debit
                                        echo "<td class='text-center'>" . $row['kas_masuk'] . "</td>";
                                        echo "<td class='text-center' style='color:red'>" . $row['kas_keluar'] . "</td>";
                                        $kas_masuk = $row['kas_masuk'];
                                        $saldo = $row['kas_masuk'] . "</td>";
                                        echo "<td class='text-center'>" . $saldo . "</td>";
                                    } else {
                                        if ($row['kas_masuk'] != 0) {
                                            // jika kas masuk tidak sama dengan 0
                                            echo "<td class='text-center'>" . $row['kas_masuk'] . "</td>";
                                            echo "<td class='text-center' style='color:red'>" . $row['kas_keluar'] . "</td>";
                                            $kas_masuk = $kas_masuk + $row['kas_masuk'];
                                            $saldo = $saldo + $row['kas_masuk'] . "</td>";
                                            echo "<td class='text-center'>" . $saldo . "</td>";
                                        } else {
                                            // jika kas masuk sama dengan 0
                                            echo "<td class='text-center' style='color:red'>" . $row['kas_masuk'] . "</td>";
                                            echo "<td class='text-center'>" . $row['kas_keluar'] . "</td>";
                                            $kas_keluar = $kas_keluar + $row['kas_keluar'];
                                            $saldo = $saldo - $row['kas_keluar'];
                                            echo "<td class='text-center'>" . $saldo . "</td>";
                                        }
                                    }
                                    ?>
                                    <td class="text-center">...</td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Kas Masuk -->
<div class="modal fade" id="kas_masuk" tabindex="-1" role aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">

                    <div class="form group">

                        <label for="id_kas">Id Kass</label>
                        <input type="text" name="id_kas" id="id_kas" class="form-control" value="<?= $format1; ?>" required autocomplete="off" readonly>

                        <label for="tanggal">tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required autocomplete="off">

                        <label for="no_bukti">No Bukti</label>
                        <input type="text" name="no_bukti" id="no_bukti" class="form-control" value="<?= $format2; ?>" required autocomplete="off" readonly>

                        <label for="uraian">Uraian</label>
                        <input type="text" name="uraian" id="uraian" class="form-control" required autocomplete="off">

                        <label for="kas_masuk">Kas Masuk</label>
                        <input type="text" name="kas_masuk" id="kas_masuk" class="form-control" required autocomplete="off">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Kas Keluar -->
<div class="modal fade" id="kas_keluar" tabindex="-1" role aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">

                    <div class="form group">

                        <label for="id_kas">Id Kass</label>
                        <input type="text" name="id_kas" id="id_kas" class="form-control" value="<?= $format1; ?>" required autocomplete="off" readonly>

                        <label for="tanggal">tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required autocomplete="off">

                        <label for="no_bukti">No Bukti</label>
                        <input type="text" name="no_bukti" id="no_bukti" class="form-control" value="<?= $format3; ?>" required autocomplete="off" readonly>

                        <label for="uraian">Uraian</label>
                        <input type="text" name="uraian" id="uraian" class="form-control" required autocomplete="off">

                        <label for="kas_keluar">Kas Keluar</label>
                        <input type="text" name="kas_keluar" id="kas_keluar" class="form-control" required autocomplete="off">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>