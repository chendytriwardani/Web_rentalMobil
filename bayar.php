<?php

    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
    if(empty($_SESSION['USER']))
    {
        echo '<script>alert("Harap login !");window.location="index.php"</script>';
    }
    $kode_booking = $_GET['id'];
    $hasil = $koneksi->query("CALL get_booked('$kode_booking')")->fetch();

    $id = $hasil['id_mobil'];
    $isi = $koneksi->query("CALL get_mobil('$id')")->fetch();

    $unik  = random_int(100,999);

    if (!empty($_GET['aksi']) && $_GET['aksi'] == 'hapus' && !empty($_GET['id'])) {
        $id_booking = $_GET['id'];
    
        $sql = "DELETE FROM booking WHERE id_booking = :id_booking";
        $stmt = $koneksi->prepare($sql);
    
        if ($stmt->execute([':id_booking' => $id_booking])) {
            echo '<script>alert("Sukses hapus");window.location="blog.php"</script>';
        } else {
            echo '<script>alert("Gagal hapus");window.location="blog.php"</script>';
        }
        exit;
    }
    
    
?>
<br>
<br>
<div class="container mt-5">
<div class="row">
    <div class="col-sm-4">

        <div class="card">
            <div class="card-body text-center">
                <h5>Pembayaran Dapat Melalui :</h5>
                <hr/>
                <p> <?= $info_web->no_rek;?> </p>
            </div>
        </div>
        <br/>
        <div class="card">
                <div class="card-body" style="background:#ddd">
                <h5 class="card-title"><?php echo $isi['merk'];?></h5>
                </div>
                <ul class="list-group list-group-flush">

                <?php if($isi['status'] == 'Tersedia'){?>

                    <li class="list-group-item bg-primary text-white">
                        <i class="fa fa-check"></i> Available
                    </li>

                <?php }else{?>

                    <li class="list-group-item bg-danger text-white">
                        <i class="fa fa-close"></i> Not Available
                    </li>

                <?php }?>
            
            
                <li class="list-group-item bg-info text-white"><i class="fa fa-check"></i> Free E-toll 50k</li>
                <li class="list-group-item bg-dark text-white">
                    <i class="fa fa-money"></i> Rp. <?php echo number_format($isi['harga']);?>/ day
                </li>
                </ul>
            </div>
    </div>
    <div class="col-sm-8">
         <div class="card">
           <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Kode Booking  </td>
                            <td> :</td>
                            <td><?php echo $hasil['kode_booking'];?></td>
                        </tr>
                        <tr>
                            <td>KTP  </td>
                            <td> :</td>
                            <td><?php echo $hasil['ktp'];?></td>
                        </tr>
                        <tr>
                            <td>Nama  </td>
                            <td> :</td>
                            <td><?php echo $hasil['nama'];?></td>
                        </tr>
                        <tr>
                            <td>telepon  </td>
                            <td> :</td>
                            <td><?php echo $hasil['no_tlp'];?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Sewa </td>
                            <td> :</td>
                            <td><?php echo $hasil['tanggal'];?></td>
                        </tr>
                        <tr>
                            <td>Lama Sewa </td>
                            <td> :</td>
                            <td><?php echo $hasil['lama_sewa'];?> hari</td>
                        </tr>
                        <tr>
                            <td>Total Harga </td>
                            <td> :</td>
                            <td>Rp. <?php echo number_format($hasil['total_harga']);?></td>
                        </tr>
                        <tr>
                            <td>Status </td>
                            <td> :</td>
                            <td><?php echo $hasil['konfirmasi_pembayaran'];?></td>
                        </tr>
                    </table>

                <?php if($hasil['konfirmasi_pembayaran'] == 'Belum Bayar'){?>
                    <a href="konfirmasi.php?id=<?php echo $kode_booking;?>" 
                    class="btn btn-primary float-right">Konfirmasi Pembayaran</a>
                    <a class="btn btn-danger btn-sm" href="bayar.php?aksi=hapus&id=<?= $hasil['id_booking']; ?>" role="button">Batalkan Pembayaran</a>

                <?php }?>
               
           </div>
         </div> 
    </div>
</div>
</div>
<br>
<br>
<br>

<?php include 'footer.php';?>