

<!doctype html>
<html lang="en">
  <head>
    <title>Rental Mobil</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css" >
    <link rel="stylesheet" href="assets/css/font-awesome.css" >

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

  </head>
  <body>
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.html"><?= $info_web->nama_rental;?> </h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link" href=""><span class="sr-only"></span></a></li>
          <li><a class="nav-link" href="index.php">Home</a></li>
          <li><a class="nav-link" href="blog.php">Daftar Mobil</a></li>
          <li><a class="nav-link" href="kontak.php">Kontak Kami</a></li>
            <?php if(!empty($_SESSION['USER'])){?>
            <li class="nav-item active">
                <a class="nav-link" href="history.php">History</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="profil.php">Profil</a>
            </li>
            <?php }?>
            
            <?php if(!empty($_SESSION['USER'])){?>

            <?php }?>
          <li class="dropdown"><a href="#"><span><i class="fa fa-user"> </i> Hallo, <?php echo $_SESSION['USER']['nama_pengguna'];?></span> <i class="bi bi-chevron-down"></i></a>
            <ul>
            <li>
            <?php if($_SESSION['USER']){?>
                        <center>
                            <?php if($_SESSION['USER']['level'] == 'admin'){?>
                                <a href="admin/index.php" class="btn btn-primary mb-2 btn-block">Dashboard</a>
                                
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
