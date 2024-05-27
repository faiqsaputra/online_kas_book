<?php
// tampil data kas
$db_kas = mysqli_query($conn, "SELECT * FROM db_kas");

// function format tanggal indonesia
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

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . '' . $bulan[(int)$pecahkan[1]] . $pecahkan[0];
}

// function format rupiah
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


<div class="content">
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="text-center">
                <h1 class="m-0 font-weight-bold text-primary">DATA KAS UMUM</h1>
                <hr>
            </div>

            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <button type="button" data-toggle="modal" data-target="#print" class="btn btn-primary">
                        <i class="fa fa-print"></i>
                        Print
                    </button>
                    <a href="data/laporan/print_excel.php"><button type="button" class="btn btn-primary" style="margin-top: 8px;">
                    <i class="fa fa-print"></i> ExportToExcel</button></a>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
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
                            <?php foreach ($db_kas as $row) : ?>

                                <tr>
                                    <td class="text-center"><?= $i; ?></td>
                                    <td class="text-center"><?= $row["id_kas"]; ?></td>
                                    <td class="text-center"><?= tgl_indo($row["tanggal"]); ?></td>
                                    <td class="text-center"><?= $row["no_bukti"]; ?></td>
                                    <td class="text-center"><?= $row["uraian"]; ?></td>

                                    <?php
                                    if ($i == 1) {
                                        // pertama kali diklarifikasi debit
                                        echo "<td class='text-center'>" . "RP" . num($row['kas_masuk']) . "</td>";
                                        echo "<td class='text-center' style='color:red'>" . "RP" . num($row['kas_keluar']) . "</td>";
                                        $kas_masuk = $row['kas_masuk'];
                                        $saldo = $row['kas_masuk'] . "</td>";
                                        echo "<td class='text-center'>" . "RP" . number_format(floatval($saldo), 0, '.', '.');
                                    } else {
                                        if ($row['kas_masuk'] != 0) {
                                            // jika kas masuk tidak sama dengan 0
                                            echo "<td class='text-center'>" . "RP" . num($row['kas_masuk']) . "</td>";
                                            echo "<td class='text-center' style='color:red'>" . "RP" . num($row['kas_keluar']) . "</td>";
                                            $kas_masuk = $kas_masuk + $row['kas_masuk'];
                                            $saldo = $saldo + $row['kas_masuk'] . "</td>";
                                            echo "<td class='text-center'>" . "RP" . number_format(floatval($saldo), 0, '.', '.');
                                        } else {
                                            // jika kas masuk sama dengan 0
                                            echo "<td class='text-center' style='color:red'>" . "RP" . num($row['kas_masuk']) . "</td>";
                                            echo "<td class='text-center'>" . "RP" . num($row['kas_keluar']) . "</td>";
                                            $kas_keluar = $kas_keluar + $row['kas_keluar'];
                                            $saldo = $saldo - $row['kas_keluar'];
                                            echo "<td class='text-center'>" . "RP" . number_format(floatval($saldo), 0, '.', '.');
                                        }
                                    }
                                    ?>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal print data -->
<div class="modal fade" id="print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Print Data Kas Umum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="data/laporan/print_pdf.php" target="blank" method="POST">
                    <div class="form-group">
                        <label for="tanggal">Pariode Tanggal</label>
                        <input type="date" name="tgl_awal" id="tanggal" class="form-control" required autocomplete="off">

                        <label for="tanggal">s/d</label>
                        <input type="date" name="tgl_akhir" id="tanggal" class="form-control" required autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="print" class="btn btn-primary">Print</button>
                    </div>
                </form>
                <a href="data/laporan/print_pdf.php" target="_BLANK" class="btn btn-success">Print Semua</a>
            </div>
        </div>
    </div>
</div>