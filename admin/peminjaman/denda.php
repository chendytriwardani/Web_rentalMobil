<?php

    require '../../koneksi/koneksi.php';
    $title_web = 'Daftar Booking';
    include '../header.php';
    if(empty($_SESSION['USER']))
    {
        session_start();
    }

    try {
        // Menyiapkan query SQL untuk menampilkan data denda
        $sql = "SELECT id_pengembalian, kode_booking, tanggal, denda FROM pengembalian";
        $stmt = $koneksi->prepare($sql);
    
        // Menjalankan query
        $stmt->execute();
    
    //     // Menampilkan hasil query

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>

<br>
<br>
<br>
<br>
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-white bg-primary">
            <h5 class="card-title">
            Daftar Denda Pengembalian
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Pengembalian</th>
                        <th>Kode Booking</th>
                        <th>Tanggal</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['id_pengembalian']."</td>";
                        echo "<td>".$row['kode_booking']."</td>";
                        echo "<td>".$row['tanggal']."</td>";
                        echo "<td>".$row['denda']."</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<?php  include '../footer.php';?>