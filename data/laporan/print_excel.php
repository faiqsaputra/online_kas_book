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

// Tampil data kas umum
$query = mysqli_query($conn, "SELECT * FROM db_kas");

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

while ($row = mysqli_fetch_assoc($query)) {
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
