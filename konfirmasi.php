<?php

    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
    if(empty($_SESSION['USER']))
    {
        echo '<script>alert("Harap Login");window.location="index.php"</script>';
    }
    $kode_booking = $_GET['id'];
    $hasil = $koneksi->query("CALL get_booked('$kode_booking')")->fetch();

    $id = $hasil['id_mobil'];
    $isi = $koneksi->query("CALL get_mobil('$id')")->fetch();
?>
<br>
<br>
<div class="container mt-5">
<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">

            <h5>Pembayaran Dapat Melalui :</h5>
                <hr/>
                <p> <?= $info_web->no_rek;?> </p>

            </div>
        </div>
    </div>
    <div class="col-sm-8">
         <div class="card">
           <div class="card-body">
               <form method="post"  action="koneksi/proses.php?id=konfirmasi" id="paymentForm" onsubmit="return validateForm()">
                    <table class="table">
                        <tr>
                            <td>Kode Booking  </td>
                            <td> :</td>
                            <td><?php echo $hasil['kode_booking'];?></td>
                        </tr>
                        <tr>
                            <td>No Rekening   </td>
                            <td> :</td>
                            <td><input type="text" name="no_rekening" required class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Atas Nama </td>
                            <td> :</td>
                            <td><input type="text" name="nama" required class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Nominal  </td>
                            <td> :</td>
                            <td><input type="text" name="nominal" required class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Tanggal  Transfer</td>
                            <td> :</td>
                            <td><input type="date" name="tgl" required class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Total yg Harus di Bayar </td>
                            <td> :</td>
                            <td>Rp. <?php echo number_format($hasil['total_harga']);?></td>
                        </tr>
                    </table>
                    <input type="hidden" name="id_booking" value="<?php echo $hasil['id_booking'];?>">
                    <button type="submit" class="btn btn-primary float-right">Kirim</button>
               </form>
           </div>
         </div> 
    </div>
</div>
</div>
<br>
<br>
<br>

<?php include 'footer.php';?>

<script>
    function validateForm() {
        var nominal = parseFloat(document.forms["paymentForm"]["nominal"].value);
        var totalHarga = parseFloat(<?php echo json_encode($hasil['total_harga']); ?>);
        
        if (nominal <= totalHarga) {
            alert("Nominal harus lebih besar dari total harga yang harus dibayar.");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>
