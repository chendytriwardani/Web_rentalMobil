<?php

 require '../../koneksi/koneksi.php';

if($_GET['id'] == 'konfirmasi')
{
    $data2[] = $_POST['id_booking'];
    $data2[] = $_POST['status'];
    $data2[] = $_POST['pengembalian'];
    $sql2 = "CALL update_booking(?, ?, ?)";
    $row2 = $koneksi->prepare($sql2);
    $row2->execute($data2);
    
    echo '<script>alert("Kirim Sukses , Pembayaran berhasil");history.go(-1);</script>'; 
}
