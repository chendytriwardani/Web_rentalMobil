<?php

    require '../../koneksi/koneksi.php';
    $title_web = 'Daftar Booking';
    include '../header.php';
    if(empty($_SESSION['USER']))
    {
        session_start();
    }
    $sql = "SELECT * FROM `v_riwayat_bayar`";
    $hasil = $koneksi->query($sql)->fetchAll();
?>

<br>
<br>
<br>
<br>
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-white bg-primary">
            <h5 class="card-title">
            Riwayat pembayaran
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama </th>
                            <th>Nama Pengirim</th>
                            <th>Nominal Bayar</th>
                            <th>Total Harga</th>
                            <th>Konfirmasi Pembayaran </th>
                            <th>Tanggal bayar</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php  $no=1; foreach($hasil as $isi){?>
                        <tr>
                            <td><?php echo $no;?></td>
                            <td><?= $isi['nama'];?></td>
                            <td><?= $isi['nama_rekening'];?></td>
                            <td>Rp. <?= number_format($isi['nominal']);?></td>
                            <td>Rp. <?= number_format($isi['total_harga']);?></td>
                            <td><?= $isi['konfirmasi_pembayaran'];?></td>
                            <td><?= $isi['tanggal'];?></td>
                        </tr>
                        <?php $no++;}?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php  include '../footer.php';?>