<?php
require 'functions.php';

// tampil data kas
$db_kas = query("SELECT * FROM db_kas");

// aksi tambah data kas
if (isset($_POST["tambah"])) {
    $_POST['id_kas'] = generateNewKasId();
    if (isset($_POST['kas_masuk']) && $_POST['kas_masuk'] != 0) {
        $_POST['no_bukti'] = generateNewKasMasukId();
    } else if (isset($_POST['kas_keluar']) && $_POST['kas_keluar'] != 0) {
        $_POST['no_bukti'] = generateNewKasKeluarId();
    }

    // Validasi dan sanitasi input
    $data = [
        'id_kas' => (int)$_POST['id_kas'],
        'tanggal' => htmlspecialchars($_POST['tanggal']),
        'no_bukti' => htmlspecialchars($_POST['no_bukti']),
        'uraian' => htmlspecialchars($_POST['uraian']),
        'kas_masuk' => (int)$_POST['kas_masuk'],
        'kas_keluar' => (int)$_POST['kas_keluar']
    ];

    if (tambah($data) > 0) {
        echo "<script>alert('Data Berhasil ditambahkan'); document.location.href = 'index.php?page=kas';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan');</script>";
    }
}

// aksi edit data kas
if (isset($_POST["edit"])) {
    // Validasi dan sanitasi input
    $data = [
        'id_kas' => (int)$_POST['id_kas'],
        'tanggal' => htmlspecialchars($_POST['tanggal']),
        'no_bukti' => htmlspecialchars($_POST['no_bukti']),
        'uraian' => htmlspecialchars($_POST['uraian']),
        'kas_masuk' => (int)$_POST['kas_masuk'],
        'kas_keluar' => (int)$_POST['kas_keluar']
    ];

    if (edit($data) > 0) {
        echo "<script>alert('Data dengan ID Kas {$data['id_kas']} berhasil diubah'); document.location.href = 'index.php?page=kas';</script>";
    } else {
        echo "<script>alert('Data gagal diubah');</script>";
    }
}

// aksi hapus data kas
if (isset($_POST["hapus"])) {
    // Validasi dan sanitasi input
    $data = [
        'id_kas' => (int)$_POST['id_kas']
    ];

    if (hapus($data) > 0) {
        echo "<script>alert('Data Berhasil dihapus'); document.location.href = 'index.php?page=kas';</script>";
    } else {
        echo "<script>alert('Data gagal dihapus');</script>";
    }
}

// function format tanggal indonesia
function tgl_indo($tanggal) {
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

// function format rupiah
function num($rp) {
    return $rp != 0 ? number_format($rp, 0, '.', '.') : 0;
}
?>

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h1 class="m-0 font-weight-bold text-primary">Data Kas Umum</h1>
                <hr>
            </div>
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <button type="button" data-toggle="modal" data-target="#kasmasuk" class="btn btn-success">Kas Masuk</button>
                    <button type="button" data-toggle="modal" data-target="#kaskeluar" class="btn btn-success">Kas Keluar</button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Id Kas</th>
                                <th class="text-center">Tgl-bln-thn</th>
                                <th class="text-center">No Bukti</th>
                                <th class="text-center">Uraian</th>
                                <th class="text-center">Kas Masuk</th>
                                <th class="text-center">Kas Keluar</th>
                                <th class="text-center">Saldo</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; $saldo = 0; ?>
                            <?php foreach ($db_kas as $row) : ?>
                                <tr>
                                    <td class="text-center"><?= $i; ?></td>
                                    <td class="text-center"><?= $row["id_kas"]; ?></td>
                                    <td class="text-center"><?= tgl_indo($row["tanggal"]); ?></td>
                                    <td class="text-center"><?= $row["no_bukti"]; ?></td>
                                    <td class="text-center"><?= $row["uraian"]; ?></td>
                                    <td class="text-center"><?= num($row["kas_masuk"]); ?></td>
                                    <td class="text-center" style="color:red"><?= num($row["kas_keluar"]); ?></td>
                                    <td class="text-center">
                                        <?php 
                                            $saldo += $row['kas_masuk'] - $row['kas_keluar'];
                                            echo num($saldo);
                                        ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editkas<?= $row["id_kas"]; ?>">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $row["id_kas"]; ?>">Hapus</button>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editkas<?= $row["id_kas"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Data Kas</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="id_kas" value="<?= $row["id_kas"]; ?>">
                                                            <div class="form-group">
                                                                <label for="tanggal">Tanggal</label>
                                                                <input type="date" class="form-control" name="tanggal" value="<?= $row["tanggal"]; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="no_bukti">No Bukti</label>
                                                                <input type="text" class="form-control" name="no_bukti" value="<?= $row["no_bukti"]; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="uraian">Uraian</label>
                                                                <input type="text" class="form-control" name="uraian" value="<?= $row["uraian"]; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kas_masuk">Kas Masuk</label>
                                                                <input type="number" class="form-control" name="kas_masuk" value="<?= $row["kas_masuk"]; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kas_keluar">Kas Keluar</label>
                                                                <input type="number" class="form-control" name="kas_keluar" value="<?= $row["kas_keluar"]; ?>" required>
                                                            </div>
                                                            <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="hapus<?= $row["id_kas"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus Data Kas</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus data ini?</p>
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="id_kas" value="<?= $row["id_kas"]; ?>">
                                                            <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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
