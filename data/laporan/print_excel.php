<?php
require "../../database/koneksi.php";

// Fungsi untuk format rupiah
function num($rp)
{
    return "RP" . number_format($rp, 0, ',', '.');
}

// Fungsi untuk format tanggal Indonesia
function tgl_indo($tanggal)
{
    return date('d/m/Y', strtotime($tanggal));
}

// Validasi input tanggal
$tgl_awal = $_POST["tgl_awal"];
$tgl_akhir = $_POST["tgl_akhir"];

if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $tgl_awal) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $tgl_akhir)) {
    // Tampilkan pesan kesalahan jika format tanggal tidak sesuai
    echo "Format tanggal tidak valid!";
    exit();
}

// Kueri SQL menggunakan prepared statements
$stmt = $conn->prepare("SELECT * FROM db_kas WHERE tanggal BETWEEN ? AND ?");
$stmt->bind_param("ss", $tgl_awal, $tgl_akhir);
$stmt->execute();
$result = $stmt->get_result();

$filename = "kas_excel-" . date('d-m-Y') . ".csv";

// Set header untuk file CSV
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Type: application/csv; ");

// Membuat file CSV dan menulis data ke file
$file = fopen('php://output', 'w');

// Menambahkan header ke CSV
fputcsv($file, array('No', 'Id Kas', 'Tanggal', 'No Bukti', 'Uraian', 'Kas Masuk (Rp)', 'Kas Keluar (Rp)', 'Saldo (Rp)'));

$no = 1;
$kas_masuk = 0;
$kas_keluar = 0;
$saldo = 0;

// Tambahkan beberapa properti CSS
$header_style = 'font-weight: bold; background-color: #f2f2f2;';
$data_style = 'background-color: #ffffff;';

while ($row = $result->fetch_assoc()) {
    $kas_masuk += $row['kas_masuk'];
    $kas_keluar += $row['kas_keluar'];
    $saldo += $row['kas_masuk'] - $row['kas_keluar'];

    // Tulis baris data ke file CSV
    fputcsv($file, array(
        $no,
        $row["id_kas"],
        tgl_indo($row["tanggal"]),
        $row["no_bukti"],
        $row["uraian"],
        num($row["kas_masuk"]),
        num($row["kas_keluar"]),
        num($saldo)
    ));

    // Tambahkan properti CSS pada baris data
    $row_style = ($no % 2 == 0) ? 'background-color: #f2f2f2;' : 'background-color: #ffffff;';

    $no++;
}

// Tutup file CSV
fclose($file);
?>