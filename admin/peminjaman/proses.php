<?php

 require '../../koneksi/koneksi.php';

if($_GET['id'] == 'konfirmasi')
{
    $data2[] = $_POST['status'];
    $data2[] = $_POST['id_mobil'];
    $sql2 = "UPDATE `mobil` SET `status`= ? WHERE id_mobil= ?";
    $row2 = $koneksi->prepare($sql2);
    $row2->execute($data2);

    echo '<script>alert("Status Mobil di pinjam");history.go(-1);</script>'; 
}


try {
    // Menyiapkan query SQL untuk memanggil prosedur tersimpan
    $sql = "CALL HitungDendaPengembalian()";
    $stmt = $koneksi->prepare($sql);

    // Menjalankan query
    $stmt->execute();

    echo "Penghitungan denda selesai.";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

