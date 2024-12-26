<?php

    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
?>
<br>
<br>

<section id="contact-us" class="contact-us">
      <div class="container">

        <div>
          <iframe style="border:0; width: 100%; height: 500px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.984794327841!2d112.72050577367442!3d-7.127754792876121!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd803dd886bbff5%3A0x9777ca139b28195d!2sUniversity%20of%20Trunojoyo%20Madura!5e0!3m2!1sen!2sid!4v1718124799151!5m2!1sen!2sid" frameborder="0" allowfullscreen></iframe>
        </div>

        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
                
              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Pemilik:</h4>
                <p><?= $info_web->nama_rental;?></p>
              </div>

            


              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p><?= $info_web->telp;?></p>
              </div>
              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>No. Rek:</h4>
                <p><?= $info_web->no_rek;?></p>
              </div>

            </div>

          </div>
          <div class="col-lg-4 mt-5">
            <div class="info">
                
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Alamat:</h4>
                <p><?= $info_web->alamat;?></p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p><?= $info_web->email;?></p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p><?= $info_web->telp;?></p>
              </div>


            </div>

          </div>


        </div>

      </div>
    </section><!-- End Contact Us Section -->

<br>
<br>
<br>
<?php include 'footer.php';?>