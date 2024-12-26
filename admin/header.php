<?php

    session_start();
    if(!empty($_SESSION['USER']['level'] == 'admin')){ 

    }else{ 
        echo '<script>alert("Login Khusus Admin !");window.location="../index.php";</script>';
    }
 
    // select untuk panggil nama admin
    $id_login = $_SESSION['USER']['id_login'];
    
    $row = $koneksi->prepare("SELECT * FROM login WHERE id_login=?");
    $row->execute(array($id_login));
    $hasil_login = $row->fetch();
?>

<!doctype html>
<html lang="en">
  <head>
    <title><?php echo $title_web;?> | Rental Mobil</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo $url;?>assets/css/bootstrap.css" >
    <link rel="stylesheet" href="<?php echo $url;?>assets/css/font-awesome.css" >

    <!-- Favicons -->
    <link href="<?php echo $url;?>assets/img/favicon.png" rel="icon">
    <link href="<?php echo $url;?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo $url;?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $url;?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo $url;?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo $url;?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?php echo $url;?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo $url;?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo $url;?>assets/css/main.css" rel="stylesheet">
    <link href="<?php echo $url;?>assets/css/style.css" rel="stylesheet">
  </head>
  <body>

  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="#"><?= $info_web->nama_rental;?> </h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link" href=""><span class="sr-only"></span></a></li>
          <li><a class="navbar-brand" href="<?php echo $url;?>admin/"><b>Admin Panel</b></a></li>
          <a class="nav-link" href="<?php echo $url;?>admin/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php if($title_web == 'User'){ echo 'active';}?>">
                <a class="nav-link" href="<?php echo $url;?>admin/user/index.php">User</a>
            </li>
            <li class="nav-item <?php if($title_web == 'Daftar Mobil'){ echo 'active';}?>
            <?php if($title_web == 'Tambah Mobil'){ echo 'active';}?>
            <?php if($title_web == 'Edit Mobil'){ echo 'active';}?>">
                <a class="nav-link" href="<?php echo $url;?>admin/mobil/mobil.php">Daftar Mobil</a>
            </li>
            <li class="nav-item <?php if($title_web == 'Daftar Booking'){ echo 'active';}?>
            <?php if($title_web == 'Konfirmasi'){ echo 'active';}?>">
                <a class="nav-link" href="<?php echo $url;?>admin/booking/booking.php">Daftar Booking</a>
            </li>
            <li class="nav-item <?php if($title_web == 'Peminjaman'){ echo 'active';}?>">
                <a class="nav-link" href="<?php echo $url;?>admin/peminjaman/peminjaman.php">Peminjaman / Pengembalian</a>
            </li>
            
            <?php if(!empty($_SESSION['USER'])){?>

            <?php }?>


          <li class="dropdown"><a href="#"><span><i class="fa fa-user"> </i> Hallo, <?php echo $hasil_login['nama_pengguna'];?></a>
            <ul>
            <li>
            <?php if($_SESSION['USER']){?>
                        <center>
                            <?php if($_SESSION['USER']['level'] == 'admin'){?>
                                <a href="admin/index.php"><?php echo $hasil_login['nama_pengguna'];?></a>
                                
                            <?php }else{?>
                                <a href="#"></i> Hallo, <?php echo $_SESSION['USER']['nama_pengguna'];?></a>
                                <a href="blog.php" class="btn btn mb-2 btn-block">Booking Sekarang !</a>
                            <?php }?>
                            <!-- Button trigger modal -->
                            <li><a class="nav-link" onclick="return confirm('Apakah anda ingin logout ?');" href="<?php echo $url;?>admin/logout.php">Logout</a></li>
                        </center>
                    <?php }else{?>
                        <a href="blog.php" class="btn btn mb-2 btn-block">Booking Sekarang !</a>
                        <a href="login.php" class="btn btn mb-2 btn-block">Login</a>
                    <?php }?>
            
                
            </li>
              <li></li>
              
              
            </ul>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- beda -->