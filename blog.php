<?php

    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
    if($_GET['cari'])
    {
        $cari = strip_tags($_GET['cari']);
        $query =  $koneksi -> query('SELECT * FROM mobil WHERE merk LIKE "%'.$cari.'%" ORDER BY id_mobil DESC')->fetchAll();
    }else{
        $query =  $koneksi -> query('SELECT * FROM `v_mobil`')->fetchAll();
    }
?>
<br>
<br>
<div class="container">
<section id="event-list" class="event-list">
      <div class="container">

        <div class="row">
        <?php 
            $no =1;
            foreach($query as $isi)
            {
        ?>
          <div class="col-md-4 d-flex align-items-stretch">
            <div class="card">
              <div class="card-img">
                <img src="assets/image/<?php echo $isi['gambar'];?>" style="height:250px;" alt="...">
              </div>
              <div class="card-body">

                <p class="card-text">
                <h5 class="card-title"><?php echo $isi['merk'];?></h5>
                <?php if($isi['status'] == 'Tersedia'){?>
                    <li class="list-group-item ">
                        <i class="fa fa-check" style="color:#06D001;"></i> Available
                    </li>
                <?php }else{?>
                    <li class="list-group-item">
                        <i class="fa fa-close" style="color:#FF0000;"></i> Not Available
                    </li>
                <?php }?>
                </p>
                <p class="card-text"><i class="fa fa-check" style="color:#06D001;"></i> Free E-toll 50k</p>
                <p class="card-text ">
                            <i class="fa fa-money"></i> Rp. <?php echo number_format($isi['harga']);?>/ day
                </p>
                <br>
                <p class="card-text"><?php echo $isi['deskripsi'];?></p>
                <p class="card-text mt-5"><a href="booking.php?id=<?php echo $isi['id_mobil'];?>" class="btn-booking">Booking Now!</a><a href="detail.php?id=<?php echo $isi['id_mobil'];?>" class="btn-detil">Detail </a></p>
                <p class="card-text mt-5"></p>

              </div>
            </div>
          </div>
          <?php $no++;}?>

          </div>
        </div>

      </div>
    </section><!-- End Event List Section -->

</div>



<br>

<br>

<br>


<?php include 'footer.php';?>