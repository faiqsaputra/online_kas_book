<?php
require 'functions.php';

// Tampil data users
$db_user = query("SELECT * FROM db_user");

// Automatic ID generation
$no = mysqli_query($conn, "SELECT id_user FROM db_user ORDER BY id_user DESC");
$id_user = mysqli_fetch_array($no);
$kode = $id_user['id_user'];
$urut = substr($kode, 2, 3);
$tambah = (int) $urut + 1;

if (strlen($tambah) == 1) {
    $format1 = "id" . "00" . $tambah;
} else if (strlen($tambah) == 2) {
    $format1 = "id" . "0" . $tambah;
} else {
    $format1 = "id" . $tambah;
}

// Form submission handling
if (isset($_POST["tambah"])) {
    if (tambah($_POST) > 0) {
        echo "<script>
        alert('data berhasil ditambahkan');
        document.location.href = 'index.php?page=user';
        </script>";
        exit; // Exit to prevent further execution
    } else {
        echo "<script>alert('data gagal ditambahkan');</script>";
    }
}

if (isset($_POST["edit"])) {
    if (edit($_POST) > 0) {
        echo "<script>
        alert('data berhasil diubah');
        document.location.href = 'index.php?page=user';
        </script>";
        exit; // Exit to prevent further execution
    } else {
        echo "<script>alert('data gagal diubah');</script>";
    }
}

if (isset($_POST["hapus"])) {
    if (hapus($_POST) > 0) {
        echo "<script>
        alert('data berhasil dihapus');
        document.location.href = 'index.php?page=user';
        </script>";
        exit; // Exit to prevent further execution
    } else {
        echo "<script>alert('data gagal dihapus');</script>";
    }
}
?>

<div class="content">
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">

            <div class="text-center">
                <h1 class="m-0 font-weight-bold text-primary">DATA USER</h1>
                <hr>
            </div>

            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Datatables</h6>

                    <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Tambah Data
                    </button>
                </div>


                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Id User</th>
                                <th scope="col" class="text-center">Username</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($db_user as $row) : ?>
                                <tr>
                                    <td class="text-center"><?= $i; ?></td>
                                    <td class="text-center"><?= $row["id_user"]; ?></td>
                                    <td class="text-center"><?= $row["username"]; ?></td>
                                    <td>

                                        <form action="" method="POSt" class="inline">
                                            <a href="#" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit<?= $rows["id_user"]; ?>"><i class="fas fa-edit"></i></a>

                                            <input type="hidden" name="id_user" id="id_user" class="form-control" required autocomplete="off" value="<?= $row['id_user']; ?>" readonly>
                                            <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('Yakin data ingin dihapus!!!');"><i class="fas fa-trash"></i></button>
                                        </form>

                                        <!-- Modal Edit Data -->
                                        <div class="modal fade" id="edit<?= $rows["id_user"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data User</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="POST">

                                                            <div class="form-group">

                                                                <?php
                                                                $id_user = $row["id_user"];

                                                                $row = query("SELECT * FROM db_user WHERE id_user = '$id_user'")[0];
                                                                ?>

                                                                <input type="hidden" name="id_user" id="id_user" class="form-control" required autocomplete="off" value="<?= $row['id_user']; ?>" readonly>

                                                                <input type="hidden" name="password" id="password" class="form-control" required autocomplete="off" value="<?= $row['password']; ?>" readonly>

                                                                <label for="username">Username</label>
                                                                <input type="text" name="username" id="username" class="form-control" required autocomplete="off" value="<?= $row['username']; ?>">

                                                                <label for="passwordlama">Password Lama</label>
                                                                <input type="password" name="passwordlama" id="passwordlama" class="form-control" required autocomplete="off">

                                                                <label for="passwordlama">Password Baru</label>
                                                                <input type="password" name="passwordbaru" id="passwordbaru" class="form-control" required autocomplete="off">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
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


<!-- Modal Tambah Data -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">

                    <div class="form-group">

                        <label for="id_user">NIS</label>
                        <input type="text" name="id_user" id="id_user" class="form-control" require autocomplete="" value="<?php echo $format1; ?>" readonly>

                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" require autocomplete="off">

                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" require autocomplete="off">

                        <label for="password2">Komfirmasi Password</label>
                        <input type="password" name="password2" id="password2" class="form-control" require autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>