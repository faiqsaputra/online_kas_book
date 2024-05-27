<?php
require "../../database/koneksi.php";

// Data yang akan dicetak
if (isset($_POST["print"])) {
    $tgl_awal  = $_POST["tgl_awal"];
    $tgl_akhir = $_POST["tgl_akhir"];

    $db_kas = mysqli_query($conn, "SELECT * FROM db_kas WHERE tanggal BETWEEN '".$tgl_awal."' and '".$tgl_akhir."'");
} else {
    $db_kas = mysqli_query($conn, "SELECT * FROM db_kas");
}

// Fungsi untuk format tanggal Indonesia
function tgl_indo($tanggal)
{
    $bulan = array(
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );
    $pecahkan = explode('-', $tanggal);

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

// Fungsi untuk format rupiah
function num($rp)
{
    if ($rp - 0) {
        $hasil = number_format($rp, 0, '.', '.');
    } else {
        $hasil = 0;
    }
    return $hasil;
}

?>

<?php error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); ?>
<style>
    .content {
        font-family: "times new roman", times, serif;
    }

    .table {
        border-collapse: collapse;
    }

    .table th {
        padding: 8px 5px;
        font-size: 15px;
    }

    .table td {
        padding: 8px 5px;
        font-size: 12px;
    }
</style>


<page>
    <table class="tabel1" align="center">
        <tr>
            <th width="500">
                <div class="padding:4mm; border:0px solid;">
                    <span style="font-size: 10px;">LAPORAN KAS UMUM</span>
                    <hr>
                </div>
            </th>
        </tr>
    </table>

    <table border="1px" class="table1" align="center">
        <thead class="thead-light">
        <tr>
            <th scope="col" class="text-center">No</th>
            <th scope="col" class="text-center">Id Kas</th>
            <th scope="col" class="text-center">Tgl-bln-thn</th>
            <th scope="col" class="text-center">No Bukti</th>
            <th scope="col" class="text-center">Uraian</th>
            <th scope="col" class="text-center">Kas Masuk</th>
            <th scope="col" class="text-center">Kas Keluar</th>
            <th scope="col" class="text-center">Saldo</th>
        </tr>
        </thead>
        <tbody>

            <?php $i = 1; ?>
            <?php $kas_masuk = 0; $kas_keluar = 0; $saldo = 0; ?>
            <?php foreach ($db_kas as $row) : ?>

                <tr>
                    <td class="text-center"><?= $i; ?></td>
                    <td class="text-center"><?= $row["id_kas"]; ?></td>
                    <td class="text-center"><?= tgl_indo($row["tanggal"]); ?></td>
                    <td class="text-center"><?= $row["no_bukti"]; ?></td>
                    <td class="text-center"><?= $row["uraian"]; ?></td>

                    <?php
                    if ($i == 1) {
                        // Pertama kali dideklarasikan sebagai debit
                        echo "<td class='text-center'>" . "RP" . num($row['kas_masuk']) . "</td>";
                        echo "<td class='text-center' style='color:red'>" . "RP" . num($row['kas_keluar']) . "</td>";
                        $kas_masuk = $row['kas_masuk'];
                        $saldo = $row['kas_masuk'];
                        echo "<td class='text-center'>" . "RP" . num($saldo) . "</td>";
                    } else {
                        if ($row['kas_masuk'] != 0) {
                            // Jika kas masuk tidak sama dengan 0
                            echo "<td class='text-center'>" . "RP" . num($row['kas_masuk']) . "</td>";
                            echo "<td class='text-center' style='color:red'>" . "RP" . num($row['kas_keluar']) . "</td>";
                            $kas_masuk += $row['kas_masuk'];
                            $saldo += $row['kas_masuk'];
                            echo "<td class='text-center'>" . "RP" . num($saldo) . "</td>";
                        } else {
                            // Jika kas masuk sama dengan 0
                            echo "<td class='text-center' style='color:red'>" . "RP" . num($row['kas_masuk']) . "</td>";
                            echo "<td class='text-center'>" . "RP" . num($row['kas_keluar']) . "</td>";
                            $kas_keluar += $row['kas_keluar'];
                            $saldo -= $row['kas_keluar'];
                            echo "<td class='text-center'>" . "RP" . num($saldo) . "</td>";
                        }
                    }
                    ?>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
            <tr>
                <th colspan="5" class="text-center">Total jumlah</th>
                <th>Rp. <?= num($kas_masuk); ?></th>
                <th>Rp. <?= num($kas_keluar); ?></th>
                <th>Rp. <?= num($saldo); ?></th>
            </tr>
        <tbody>
    </table>
</page>

<script>
    window.print();
</script>
