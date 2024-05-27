
<?php
// Fungsi untuk mengambil data dari database
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Function untuk generate id_kas baru
function generateNewKasId() {
    global $conn;
    $query = "SELECT max(id_kas) as max_id FROM db_kas";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $maxId = $row['max_id'];
    $maxIdNum = (int)str_replace('KS', '', $maxId);
    $newIdNum = $maxIdNum + 1;
    $newId = 'KS' . str_pad($newIdNum, 3, '0', STR_PAD_LEFT);
    return $newId;
}

// Function untuk generate no_bukti baru kas masuk
function generateNewKasMasukId() {
    global $conn;
    $query = "SELECT max(no_bukti) as max_bukti FROM db_kas WHERE no_bukti LIKE 'MSK%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $maxBukti = $row['max_bukti'];
    $maxBuktiNum = (int)str_replace('MSK', '', $maxBukti);
    $newBuktiNum = $maxBuktiNum + 1;
    $newBukti = 'MSK' . str_pad($newBuktiNum, 3, '0', STR_PAD_LEFT);
    return $newBukti;
}

// Function untuk generate no_bukti baru kas keluar
function generateNewKasKeluarId() {
    global $conn;
    $query = "SELECT max(no_bukti) as max_bukti FROM db_kas WHERE no_bukti LIKE 'KLR%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $maxBukti = $row['max_bukti'];
    $maxBuktiNum = (int)str_replace('KLR', '', $maxBukti);
    $newBuktiNum = $maxBuktiNum + 1;
    $newBukti = 'KLR' . str_pad($newBuktiNum, 3, '0', STR_PAD_LEFT);
    return $newBukti;
}


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function tambah($data) {
    global $conn;
    $query = "INSERT INTO db_kas (id_kas, tanggal, no_bukti, uraian, kas_masuk, kas_keluar) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssii", $data['id_kas'], $data['tanggal'], $data['no_bukti'], $data['uraian'], $data['kas_masuk'], $data['kas_keluar']);
    $stmt->execute();
    return $stmt->affected_rows;
}

function edit($data) {
    global $conn;
    $query = "UPDATE db_kas SET tanggal = ?, no_bukti = ?, uraian = ?, kas_masuk = ?, kas_keluar = ? WHERE id_kas = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssiii", $data['tanggal'], $data['no_bukti'], $data['uraian'], $data['kas_masuk'], $data['kas_keluar'], $data['id_kas']);
    $stmt->execute();
    return $stmt->affected_rows;
}

function hapus($data) {
    global $conn;
    $query = "DELETE FROM db_kas WHERE id_kas = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $data['id_kas']);
    $stmt->execute();
    return $stmt->affected_rows;
}