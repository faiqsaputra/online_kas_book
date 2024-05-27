<?php
require 'functions.php';

// tampil data user
$db_user = query("SELECT * FROM db_user");

// Form submission handling
if (isset($_POST["tambah"])) {
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validasi password minimal 8 karakter
    if (strlen($password) < 8) {
        echo "<script>alert('mohon maaf password minimal harus terdiri dari 8 karakter');</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Konfirmasi password tidak sesuai');</script>";
    } else {
        if (tambah($_POST) > 0) {
            echo "<script>
            alert('Data berhasil ditambahkan');
            document.location.href = 'index.php?page=user';
            </script>";
            exit;
        } else {
            echo "<script>alert('Maaf terjadi kesalahan, data gagal ditambahkan, coba periksa kembali pastikan data yang anda masukan sesuai dengan ketentuan!');</script>";
        }
    }
}


// Edit data user 
if (isset($_POST["edit"]))

    if (strlen($password) < 8) {
        echo "<script>alert('mohon maaf password minimal harus terdiri dari 8 karakter');</script>";
    } elseif ($password !== $passwordlama) {
        echo "<script>
        alert('Konfirmasi password tidak sesuai dengan password lama, mohon cek kembali dan pastikan untuk memasukan password yang benar');
        </script>";
    } else {
        if (edit($_POST) > 0) {
            echo "<script>
        alert('Data berhasil dirubah');
        document.location.href = 'index.php?page=user';
        </script>";
            exit;
        } else {
            echo "<script>alert('Maaf terjadi kesalahan, data gagal ditambahkan, coba periksa kembali pastikan data yang anda masukan sesuai dengan ketentuan!');</script>";
        }
    }


// aksi hapus data
    if(isset($_POST["hapus"]))

        if(hapus($_POST) > 0){
            echo "<script>
                alert('data berhasil di hapus');
                document.location.href = 'index.php?page=user';
                </script>";
            }else{
                echo "<script>
                    alert('terjadi kesalahan, data gagal dihapus')
                    </script>";
            }

// kode otomatis id_user
$no = mysqli_query($conn, "SELECT id_user FROM db_user ORDER BY id_user DESC");

$id_user = mysqli_fetch_array($no);
$kode = $id_user['id_user'];

$urut   = substr($kode, 2, 3);
$tambah = (int) $urut + 1;

if (strlen($tambah) == 1) {
    $format1 = "Id" . "00" . $tambah;
} else if (strlen($tambah) == 2) {
    $format1 = "Id" . "0" . $tambah;
} else {
    $format1 = "Id" . $tambah;
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
                    <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary"><i class="fa fa-user"></i> Tambah Data </button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Id User</th>
                                <th scope="col" class="text-center">Username</th>
                                <th scope="col" class="text-center">Level</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($db_user as $row) : ?>
                                <tr>
                                    <td class="text-center"><?= $i; ?></td>
                                    <td class="text-center"><i class="fa fa-user-circle text-primary"></i> <?= $row["id_user"]; ?></td>
                                    <td class="text-center"><?= $row["username"]; ?></td>
                                    <td class="text-center"><?= $row["level"]; ?></td>
                                    <td>

                                    <div class="text-center">
                                        <form action="" method="POST" class="inline">
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit<?= $row["id_user"]; ?>">
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            </button>

                                            <input type="hidden" name="id_user" id="id_user" class="form-control" required autocomplete="off" value="<?= $row['id_user']?>" readonly>

                                            <button type="submit" name="hapus" id="hapus" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data user yang ada')">
                                                <i class="fa fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>

                                        <!-- Modal Edit Data -->
                                        <div class="modal fade" id="edit<?= $row["id_user"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-label="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-gray-100">
                                                        <h1 class="modal-title" id="exampleModallabel">Rubah Data User</h1>
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

                                                                <label for="level">Level</label>
                                                                <select name="level" id="level" class="form-control" required>
                                                                    <option value="admin">Admin</option>
                                                                    <option value="pengelola">Pengelola</option>
                                                                    <option value="anggota">Anggota</option>
                                                                </select>

                                                                <label for="passwordlama">Password Lama</label>
                                                                <input type="password" name="passwordlama" id="passwordlama" class="form-control" required autocomplete="off">
                                                                <input type="checkbox" id="togglePasswordLama"> Perlihatkan<br>

                                                                <label for="passwordbaru">Password Baru</label>
                                                                <input type="password" name="passwordbaru" id="passwordbaru" class="form-control" required autocomplete="off">
                                                                <input type="checkbox" id="togglePasswordBaru"> Perlihatkan<br>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="edit" class="btn btn-primary"><i class="fa fa-save"></i>Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Tambah Data -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-label="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModallabel">Tambah Data User</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="id_user">Id User</label>
                        <input type="text" name="id_user" id="id_user" class="form-control" value="<?php echo $format1; ?>" require autocomplete="off" readonly>

                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" require autocomplete="off">

                        <label for="level">Level</label>
                        <select name="level" id="level" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="pengelola">Pengelola</option>
                            <option value="anggota">Anggota</option>
                        </select>

                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required autocomplete="off">
                        <input type="checkbox" id="togglePassword1"> Perlihatkan
                        <br>

                        <label for="password2">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required autocomplete="off">
                        <input type="checkbox" id="toggleconfirm_password"> Perlihatkan

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal hapus -->
<?php foreach ($db_user as $row) : ?>
    <div class="modal fade" id="hapus<?= $row["id_user"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data user</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <input type="hidden" name="id_user" value="<?= $row["id_user"]; ?>">
                        <p>Apakah anda yakin ingin menghapus data user ini?</p>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePasswordVisibility = (checkboxId, inputId) => {
            const checkbox = document.querySelector(checkboxId);
            const inputField = document.querySelector(inputId);

            checkbox.addEventListener('change', function() {
                const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                inputField.setAttribute('type', type);
            });
        };

        togglePasswordVisibility('#togglePassword1', '#password');
        togglePasswordVisibility('#toggleconfirm_password', '#confirm_password');
        togglePasswordVisibility('#togglePasswordLama', '#passwordlama');
        togglePasswordVisibility('#togglePasswordBaru', '#passwordbaru');
    });
</script>