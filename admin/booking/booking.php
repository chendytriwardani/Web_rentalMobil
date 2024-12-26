<?php

    require '../../koneksi/koneksi.php';
    $title_web = 'Daftar Booking';
    include '../header.php';
    if(empty($_SESSION['USER']))
    {
        session_start();
    }
    if(!empty($_GET['id'])){
        $id = strip_tags($_GET['id']);
        $sql = "SELECT mobil.merk, booking.* FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil WHERE id_login = '$id' ORDER BY id_booking DESC";
    }else{
        $sql = "SELECT * FROM `v_booking`";
    }
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
            Daftar Booking
            </h5>
            <div class="float-right">
                    <a class="btn btn-success" href="riwayat.php" role="button">Riwayat</a>
                </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Kode Booking</th>
                            <th>Merk Mobil</th>
                            <th>Nama </th>
                            <th>Tanggal Sewa </th>
                            <th>Lama Sewa </th>
                            <th>Total Harga</th>
                            <th>Konfirmasi</th>
                            <th>pengembalian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $no=1; foreach($hasil as $isi){?>
                        <tr>
                            <td><?php echo $no;?></td>
                            <td><?= $isi['kode_booking'];?></td>
                            <td><?= $isi['merk'];?></td>
                            <td><?= $isi['nama'];?></td>
                            <td><?= $isi['tanggal'];?></td>
                            <td><?= $isi['lama_sewa'];?> hari</td>
                            <td>Rp. <?= number_format($isi['total_harga']);?></td>
                            <td><?= $isi['konfirmasi_pembayaran'];?></td>
                            <td><?= $isi['pengembalian'];?></td>
                            <td>
                                <a class="btn btn-primary" href="bayar.php?id=<?= $isi['kode_booking'];?>" 
                                role="button">Detail</a>   
                            </td>
                        </tr>
                        <?php $no++;}?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php  include '../footer.php';?>