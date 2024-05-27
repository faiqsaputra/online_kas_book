<?php
require '././database/koneksi.php'; // Assuming you have a separate file for database connection

// building query
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {
    global $conn;
    $id_user = htmlspecialchars($data["id_user"]);
    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    $confirm_password = htmlspecialchars($data["confirm_password"]);
    $level = htmlspecialchars($data["level"]);

    // Validasi password minimal 8 karakter
    if (strlen($password) < 8) {
        return 0; // Password kurang dari 8 karakter, return 0 untuk menandakan gagal
    }

    // Validasi konfirmasi password
    if ($password !== $confirm_password) {
        return 0; // Konfirmasi password tidak sesuai, return 0 untuk menandakan gagal
    }

    // Hash password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Mulai transaksi
    mysqli_begin_transaction($conn);

    try {
        $stmt = $conn->prepare("INSERT INTO db_user (id_user, username, password, level) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $id_user, $username, $password_hashed, $level);
        $stmt->execute();

        // Commit transaksi
        mysqli_commit($conn);
        return $stmt->affected_rows;
    } catch (mysqli_sql_exception $exception) {
        // Rollback transaksi jika terjadi kesalahan
        mysqli_rollback($conn);
        throw $exception;  // Lempar kembali exception untuk ditangani oleh kode yang memanggil
    }
}

// function ubah data siswa
function edit($data){
    global $conn;
    $id_user =htmlspecialchars($data["id_user"]);
    $username =htmlspecialchars($data["username"]);
    $level =htmlspecialchars($data["level"]);
    $password =htmlspecialchars($data["password"]);
    $passwordlama =htmlspecialchars($data["passwordlama"]);                
    $passwordbaru =htmlspecialchars($data["passwordbaru"]);
}

// Validasi password minimal 8 karakter
if (strlen($password) < 8) {
    return 0; // Password kurang dari 8 karakter, return 0 untuk menandakan gagal
}

// verifikasi password
if ($password !== $passwordlama ){
    echo "<script>
    alert('Konfirmasi password tidak sesuai dengan password lama, mohon cek kembali dan pastikan untuk memasukan password yang benar');
    </script>";
    return false;
}

// Hash password jika password tidak kosong
$password_hashed = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;


// query update data
$query = "UPDATE db_user SET 
            username = '$username',
            level    = '$level',
            password = '$passwordbaru'
            where id_user = '$id_user'
            ";

mysqli_query($conn, $query);
return mysqli_affected_rows($conn);

// Fungsi hapus data
function hapus($data) {
    global $conn;
    $id_user = htmlspecialchars($data["id_user"]);

    // query hapus data
    $query = "DELETE FROM db_user WHERE id_user = '$id_user'";
    
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
?>
