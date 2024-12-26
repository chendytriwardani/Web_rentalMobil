<?php

require 'koneksi/koneksi.php';
if(empty($_SESSION['USER']))
{
    session_start();
}
include 'header.php';

?>
<br>

<div class="container-fluid mt-6">

    <div id="carouselId" class="carousel slide mt-5" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php 
            $querymobil =  $koneksi -> query('SELECT * FROM mobil ORDER BY id_mobil DESC')->fetchAll();
            $no =1;
            foreach($querymobil as $isi)
            {
                ?>
        <li data-target="#carouselId" data-slide-to="<?= $no;?>" class="<?php if($no == '1'){ echo 'active';}?>"></li>
    <?php $no++;}?>
</ol>
<div class="carousel-inner" role="listbox">
    <?php 
            $no =1;
            foreach($querymobil as $isi)
            {
                ?>
        <div class="carousel-item <?php if($no == '1'){ echo 'active';}?>">
            <img src="assets/image/<?= $isi['gambar'];?>" alt="First slide" 
        class="img-fluid" style="object-fit:cover;width:100%;height:500px;">
    </div>
        <?php $no++;}?>
    </div>
<a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
<span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
</a>
</div>
</div>

<section id="features" class="features">
      <div class="container">

        <div class="row">

          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="bi bi-bar-chart"></i></div>
            <h4 class="title"><a href="">Paket Tour</a></h4>
            <p class="description">Kami menawarkan berbagai paket tour menarik yang akan membawa Anda menjelajahi berbagai destinasi wisata terbaik</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="bi bi-broadcast"></i></div>
            <h4 class="title"><a href="">Sopir Berpengalaman</a></h4>
            <p class="description">Jika Anda membutuhkan sopir berpengalaman untuk memandu perjalanan Anda, kami siap menyediakannya</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="bi bi-camera"></i></div>
            <h4 class="title"><a href="">Pemandu Wisata</a></h4>
            <p class="description">Jika Anda ingin mengenal lebih dalam tentang budaya dan sejarah</p>

        </div>

      </div>
    </section><!-- End Features Section -->

        <!-- ======= My & Family Section ======= -->
        <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2>Jasa Rental Mobil</h2>
          <p> Rental Sinar Jaya Mobil berkomitmen untuk memberikan Anda pengalaman perjalanan yang menyenangkan dan bebas repot. Kami menawarkan berbagai pilihan mobil berkualitas dengan harga yang kompetitif, sehingga Anda dapat memilih kendaraan yang sesuai dengan kebutuhan dan budget Anda.</p>
        </div>

        <div class="row content">
          <div class="col-lg-6">
            <img src="assets\img\img_1.jpeg"class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <p>
            Selain rental mobil, Rental Sinar Jaya Mobil juga menyediakan berbagai layanan tambahan untuk memudahkan perjalanan Anda di Jawa, seperti :
            </p>
            <ul>
              <li><i class="ri-check-double-line"></i>Paket Tour : Kami menawarkan berbagai paket tour menarik yang akan membawa Anda menjelajahi berbagai destinasi wisata terbaik</li>
              <li><i class="ri-check-double-line"></i>Sopir Berpengalaman : Jika Anda membutuhkan sopir berpengalaman untuk memandu perjalanan Anda, kami siap menyediakannya.</li>
              <li><i class="ri-check-double-line"></i>Pemandu Wisata : Jika Anda ingin mengenal lebih dalam tentang budaya dan sejarah</li>
            </ul>
            <p>
            Mobil Berkualitas : Kami menyediakan berbagai jenis mobil yang terawat dengan baik, mulai dari mobil keluarga, mobil SUV, hingga mobil mewah. Semua mobil kami dilengkapi dengan fitur keamanan dan kenyamanan yang lengkap untuk memastikan perjalanan Anda aman dan nyaman.
Harga Kompetitif : Kami menawarkan harga rental yang kompetitif dan transparan, tanpa biaya tersembunyi. Kami juga memberikan berbagai promo menarik untuk Anda.
Layanan Profesional : Tim kami yang ramah dan berpengalaman siap memberikan pelayanan terbaik dan membantu Anda dalam memilih mobil yang tepat serta menjawab pertanyaan Anda.
Fleksibel dan Mudah : Kami menyediakan berbagai pilihan durasi rental dan penjemputan.
            </p>
            <a href="#" class="btn-learn-more">Learn More</a>
          </div>
        </div>

      </div>
    </section><!-- End My & Family Section -->


                


<?php
include 'footer.php';
?>