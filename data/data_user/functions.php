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

    // Validasi data
    if (empty($id_user) || empty($username) || empty($password) || empty($confirm_password) || empty($level)) {
        throw new Exception("Semua bidang harus diisi.");
    }

    if (strlen($password) < 8) {
        throw new Exception("Password harus terdiri dari minimal 8 karakter.");
    }

    if ($password !== $confirm_password) {
        throw new Exception("Konfirmasi password tidak sesuai.");
    }

    // Hash password
    $password_hashed = hashPassword($password);

    // Simpan ke database
    beginTransaction();

    try {
        insertUser($id_user, $username, $password_hashed, $level);
        commitTransaction();
        return true;
    } catch (Exception $exception) {
        rollbackTransaction();
        throw $exception;
    }
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function beginTransaction() {
    global $conn;
    mysqli_begin_transaction($conn);
}

function commitTransaction() {
    global $conn;
    mysqli_commit($conn);
}

function rollbackTransaction() {
    global $conn;
    mysqli_rollback($conn);
}

function insertUser($id_user, $username, $password_hashed, $level) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO db_user (id_user, username, password, level) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $id_user, $username, $password_hashed, $level);
    $stmt->execute();
    if ($stmt->affected_rows <= 0) {
        throw new Exception("Gagal menyimpan data pengguna.");
    }
}

function edit($data) {
    global $conn;

    // Ambil data dari form
    $id_user = htmlspecialchars($data["id_user"]);
    $username = htmlspecialchars($data["username"]);
    $level = htmlspecialchars($data["level"]);
    $passwordlama = htmlspecialchars($data["passwordlama"]);
    $passwordbaru = htmlspecialchars($data["passwordbaru"]);

    // Validasi data
    if (empty($id_user) || empty($username) || empty($level)) {
        throw new Exception("Semua bidang kecuali password baru harus diisi.");
    }

    // Variabel untuk menyimpan password yang akan digunakan
    $password_hashed = '';

    // Jika password baru diisi, lakukan validasi
    if (!empty($passwordbaru)) {
        if (strlen($passwordbaru) < 8) {
            throw new Exception("Password baru harus terdiri dari minimal 8 karakter.");
        }

        // Verifikasi password lama
        $stmt = $conn->prepare("SELECT password FROM db_user WHERE id_user = ?");
        $stmt->bind_param("s", $id_user);
        $stmt->execute();
        $stmt->bind_result($stored_password);
        $stmt->fetch();
        $stmt->close();

        if (!password_verify($passwordlama, $stored_password)) {
            throw new Exception("Password lama tidak sesuai.");
        }

        // Hash password baru
        $password_hashed = password_hash($passwordbaru, PASSWORD_DEFAULT);
    } else {
        // Jika password baru kosong, gunakan password lama dari database
        $stmt = $conn->prepare("SELECT password FROM db_user WHERE id_user = ?");
        $stmt->bind_param("s", $id_user);
        $stmt->execute();
        $stmt->bind_result($stored_password);
        $stmt->fetch();
        $stmt->close();

        $password_hashed = $stored_password;
    }

    // Update data
    $stmt = $conn->prepare("UPDATE db_user SET username = ?, level = ?, password = ? WHERE id_user = ?");
    $stmt->bind_param("ssss", $username, $level, $password_hashed, $id_user);
    $stmt->execute();

    if ($stmt->affected_rows <= 0) {
        throw new Exception("Gagal mengubah data pengguna.");
    }

    $stmt->close();

    return true;
}

// Fungsi hapus data
function hapus($data) {
    global $conn;
    $id_user = htmlspecialchars($data["id_user"]);

    // query hapus data
    $query = "DELETE FROM db_user WHERE id_user = '$id_user'";
    
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function checkUserRole($allowed_roles) {
    session_start();
    $user_level = $_SESSION['user_level'];
    
    if (!in_array($user_level, $allowed_roles)) {
        // Jika pengguna tidak memiliki akses, arahkan ke halaman lain atau tampilkan pesan kesalahan
        // Misalnya, arahkan ke halaman dashboard dengan pesan kesalahan
        header("location: ../index.php?page=dashboard&error=access_denied");
        exit();
    }
}
?>