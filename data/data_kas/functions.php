
<?php
// Fungsi untuk mengambil data dari database
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

// Function untuk generate id_kas baru
function generateNewKasId()
{
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
function generateNewKasMasukId()
{
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
function generateNewKasKeluarId()
{
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

function tambah($data)
{
    global $conn;

    $id_kas = $data['id_kas'];
    $tanggal = $data['tanggal'];
    $no_bukti = $data['no_bukti'];
    $uraian = $data['uraian'];
    $kas_masuk = $data['kas_masuk'];
    $kas_keluar = $data['kas_keluar'];

    $query = "INSERT INTO db_kas (id_kas, tanggal, no_bukti, uraian, kas_masuk, kas_keluar) 
              VALUES ('$id_kas', '$tanggal', '$no_bukti', '$uraian', '$kas_masuk', '$kas_keluar')";

    return mysqli_query($conn, $query);
}

function edit($data)
{
    global $conn;

    $id_kas = $data['id_kas'];
    $tanggal = $data['tanggal'];
    $no_bukti = $data['no_bukti'];
    $uraian = $data['uraian'];
    $kas_masuk = $data['kas_masuk'];
    $kas_keluar = $data['kas_keluar'];

    $query = "UPDATE db_kas SET 
                tanggal = '$tanggal', 
                no_bukti = '$no_bukti', 
                uraian = '$uraian', 
                kas_masuk = '$kas_masuk', 
                kas_keluar = '$kas_keluar' 
                WHERE id_kas = '$id_kas'";

    return mysqli_query($conn, $query);
}

function hapus($data)
{
    global $conn;

    $id_kas = $data['id_kas'];

    $query = "DELETE FROM db_kas WHERE id_kas = '$id_kas'";

    return mysqli_query($conn, $query);
}
// Fungsi untuk format tanggal Indonesia
function tgl_indo($tanggal) {
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

// Fungsi untuk mendapatkan data kas per bulan
function getKasDataPerBulan($conn) {
    $query = "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, 
                    SUM(kas_masuk) AS total_kas_masuk, 
                    SUM(kas_keluar) AS total_kas_keluar 
                FROM db_kas 
                GROUP BY DATE_FORMAT(tanggal, '%Y-%m')";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['bulan'] = tgl_indo($row['bulan'] . '-01'); // Format tanggal ke format Indonesia
        $data[] = $row;
    }

    return $data;
}

?>