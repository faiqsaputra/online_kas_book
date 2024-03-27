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

// function tambah data kas
function tambah($data)
{
    global $conn;
    $id_kas    = htmlspecialchars($data["id_kas"]);
    $tanggal   = htmlspecialchars($data["tanggal"]);
    $no_bukti  = htmlspecialchars($data["no_bukti"]);
    $uraian    = htmlspecialchars($data["uraian"]);
    $kas_masuk = htmlspecialchars($data["kas_masuk"]);

    // $query insert data
    $query = "INSERT INTO db_kas VALUES  
            ('$id_kas','$tanggal', '$no_bukti', '$uraian', '$kas_masuk', '0')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
