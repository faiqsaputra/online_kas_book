<?php

//building query
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// function tambah data users
function tambah($data)
{
    global $conn;
    $id_user   = htmlspecialchars($data["id_user"]);
    $username  = htmlspecialchars($data["username"]);
    $password  = htmlspecialchars($data["password"]);
    $password2 = htmlspecialchars($data["password2"]);

    // cek username sudah ada atau belum di database
    $result = mysqli_query($conn, "SELECT username FROM db_user where username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
            alert('username yang dipilih sudah terdaftar di database')
            </script>";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
            alert('konfirmasi password tidak sesuai');
            </script>";
        return false;
    }

    // query insert data
    $query = "INSERT INTO db_user VALUES('$id_user','$username','$password')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// function ubah data user
function edit($data)
{
    global $conn;
    // Ensure $data["id_user"], $data["username"], $data["passwordlama"], and $data["passwordbaru"] are not null
    $id_user      = htmlspecialchars($data["id_user"] ?? "");
    $username     = htmlspecialchars($data["username"] ?? "");
    $passwordlama = $data["passwordlama"] ?? "";
    $passwordbaru = $data["passwordbaru"] ?? "";

    // verifikasipassword
    if ($passwordbaru !== $passwordlama) {
        echo "<script>
            alert('Konfirmasi password tidak sesuaidengan password lama');
            </script>";
        return false;
    }

    // query update data
    $query = "UPDATE db_user SET
        username = '$username',
        password = '$passwordbaru'
        WHERE id_user = '$id_user'";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// function hapus data user
function hapus($data)
{
    global $conn;
    $id_user = htmlspecialchars($data["id_user"]);

    // query hapus data
    $query = "DELETE FROM db_user WHERE id_user = '$id_user'";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
