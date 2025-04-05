<!doctype html>
<html lang="zxx">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Hubungi Kami - Furnimart</title>
  <link rel="icon" href="img/favicon.png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- animate CSS -->
  <link rel="stylesheet" href="css/animate.css">
  <!-- owl carousel CSS -->
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="css/all.css">
  <!-- flaticon CSS -->
  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/themify-icons.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="css/magnific-popup.css">
  <!-- swiper CSS -->
  <link rel="stylesheet" href="css/slick.css">
  <!-- style CSS -->
  <link rel="stylesheet" href="css/style.css">
  <style>
    .map-container {
      filter: grayscale(90%) brightness(110%);
      width: 100%;
      height: 450px;
      overflow: hidden;
      border-radius: 10px;
    }

    .map-container iframe {
      width: 100%;
      height: 100%;
      border: 0;
    }

    .cart-badge {
      position: absolute;
      top: -5px;
      right: -8px;
      background: #f72a74;
      color: white;
      border-radius: 50%;
      padding: 2px 6px;
      font-size: 10px;
      font-weight: bold;
      line-height: 1;
      min-width: 16px;
      text-align: center;
      z-index: 10;
    }
  </style>
</head>

<body>
  <!--::header part start::-->
  <header class="main_menu home_menu">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-12">
          <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand mx-auto" href="index.php">
              <h1 class="m-0">Furnimart</h1>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="menu_icon"><i class="fas fa-bars"></i></span>
            </button>

            <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="index.php">Beranda</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="belanja.php">Belanja</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact.php">Hubungi Kami</a>
                </li>
              </ul>
            </div>
            <?php session_start(); ?>
            <?php if (isset($_SESSION['username'])) : ?>
              <div class="header_icon d-flex">
                <!-- Cart Link -->
                <?php
                include 'admin/koneksi.php';

                $user_id = $_SESSION['id_user'] ?? null;

                if ($user_id) {
                  $query = "SELECT COUNT(*) as total FROM tb_pesanan WHERE id_user = '$user_id'";
                  $result = mysqli_query($koneksi, $query);
                  $data = mysqli_fetch_assoc($result);
                  $jumlah_item = $data['total'] ?? 0;
                } else {
                  $jumlah_item = 0;
                }
                ?>

                <a href="cart.php" id="cartLink" style="position: relative; display: inline-block;">
                  <i class="fas fa-cart-plus" style="font-size: 16px;"></i>
                  <span class="cart-badge"><?= $jumlah_item ?></span>
                </a>

                <!-- User Dropdown -->
                <div class="dropdown user">
                  <a class="dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>
                    <span class="ml-2 text-dark"><?= htmlspecialchars($_SESSION['username']); ?></span> <!-- Menampilkan username dari session -->
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="logout.php">Logout</a>
                  </div>
                </div>
              </div>


            <?php else : ?>
              <!-- Login Button -->
              <a href="login.php" class="btn btn-primary ml-3 px-3 py-2" style="border-radius: 20px;">Login</a>
            <?php endif; ?>

          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- Header part end-->

  <!--================Home Banner Area =================-->
  <!-- breadcrumb start-->
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Hubungi Kami</h2>
              <p>Beranda <span>-</span> Hubungi Kami</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb start-->

  <!-- ================ contact section start ================= -->
  <section class="contact-section padding_top">
    <div class="container">
      <div class="d-none d-sm-block mb-5 pb-4">
        <div id="map"></div>
        <div class="map-container">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.973730217078!2d111.58744367410984!3d-7.1290351699173575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e776411abeabb93%3A0x3ccba806cf9ef497!2sSTT%20Ronggolawe%20Cepu!5e0!3m2!1sid!2sid!4v1743766946322!5m2!1sid!2sid" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen>
          </iframe>
        </div>
      </div>


      <div class="row">
        <div class="col-12">
          <h2 class="contact-title">Menghubungi</h2>
        </div>
        <div class="col-lg-8">
          <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
            <div class="row">
              <div class="col-12">
                <div class="form-group">

                  <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukkan Pesan'" placeholder='Masukkan Pesan'></textarea>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <input class="form-control" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukkan Nama Anda'" placeholder='Masukkan Nama Anda'>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <input class="form-control" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukkan Email Anda'" placeholder='Masukkan Email Anda'>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <input class="form-control" name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukkan Subjek'" placeholder='Masukkan Subjek'>
                </div>
              </div>
            </div>
            <div class="form-group mt-3">
              <a href="#" class="btn_3 button-contactForm">Kirim Pesan</a>
            </div>
          </form>
        </div>
        <div class="col-lg-4">
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-home"></i></span>
            <div class="media-body">
              <h3>Cepu, Jawa Tengah.</h3>
              <p>Balun, Gang 04.</p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="fab fa-whatsapp"></i></span>
            <div class="media-body">
              <h3>
                <a href="https://wa.me/6281215008533" target="_blank" style="text-decoration: none; color: inherit;">
                  +62 812-1500-8533
                </a>
              </h3>
              <p>Hubungi via WhatsApp (Senin - Jumat, 9 pagi - 6 malam)</p>
            </div>
          </div>

          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-email"></i></span>
            <div class="media-body">
              <h3>Furnimart@gmail.com</h3>
              <p>Kirimkan pertanyaan Anda kapan saja!</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ================ contact section end ================= -->

  <!--::footer_part start::-->
  <footer class="footer_part">
    <div class="container">
      <div class="row justify-content-around">
        <div class="col-sm-6 col-lg-2">
        </div>
        <div class="col-sm-6 col-lg-2">
        </div>
        <div class="col-sm-6 col-lg-2">
        </div>
        <div class="col-sm-6 col-lg-2">
        </div>
        <div class="col-sm-6 col-lg-4">
        </div>
      </div>

    </div>
    <div class="copyright_part">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="copyright_text">
              <P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>
                  document.write(new Date().getFullYear());
                </script> All rights reserved | Furnimart by <a href="#" target="_blank">Dea Salsabilla</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></P>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="footer_icon social_icon">
              <ul class="list-unstyled">
                <li><a href="https://instagram.com/dea.salsa.503/" class="single_social_icon" target="_blank"><i class="fab fa-instagram"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--::footer_part end::-->

  <!-- jquery plugins here-->
  <!-- jquery -->
  <script src="js/jquery-1.12.1.min.js"></script>
  <!-- popper js -->
  <script src="js/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.min.js"></script>
  <!-- easing js -->
  <script src="js/jquery.magnific-popup.js"></script>
  <!-- swiper js -->
  <script src="js/swiper.min.js"></script>
  <!-- swiper js -->
  <script src="js/masonry.pkgd.js"></script>
  <!-- particles js -->
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <!-- slick js -->
  <script src="js/slick.min.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script src="js/contact.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.form.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/mail-script.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
</body>

</html>