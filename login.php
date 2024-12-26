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
<br>
<br>
<section class="login">
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-3">
            
            <div class="card text-center" style=" background: #ddd">
                <div class="card-body ">
                    <?php if($_SESSION['USER']){?>
                        Selamat Datang , <?php echo $_SESSION['USER']['nama_pengguna'];?>
                        <br/>
                        <br/>
                        <center>
                            <?php if($_SESSION['USER']['level'] == 'admin'){?>
                                <a href="admin/index.php" class="btn btn-primary mb-2 btn-block">Dashboard</a>
                            <?php }else{?>
                                <a href="blog.php" class="btn btn-primary mb-2 btn-block">Booking Sekarang !</a>
                            <?php }?>
                            <!-- Button trigger modal -->
                            <a href="admin/logout.php" class="btn btn-danger text-white btn-block">
                                Logout
                            </a>
                        </center>
                    <?php }else{?>
                    <form method="post" action="koneksi/proses.php?id=login">
                        <center><h5 class="card-title">Login</h5></center>
                        <h6 class="card-subtitle mb-2 text-muted"></h6>
                        <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" name="user" id="" class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="pass" id="" class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                        <center><button class="btn btn-primary">Login</button>
                        
                        <!-- Button trigger modal -->
                        <a class="btn btn-danger text-white" data-toggle="modal" data-target="#modelId">
                            Daftar
                         </a></center>
                    </form>
                    <?php }?>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form method="post" action="koneksi/proses.php?id=daftar">
                    <div class="form-group">
                    <label for="">Nama Pengguna</label>
                    <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="user" id="" class="form-control"  required placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="pass" id="" class="form-control" required placeholder="" aria-describedby="helpId">
                    </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary text-white" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
</section>   



<br>

<br>

<br>


<?php include 'footer.php';?>