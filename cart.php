<!doctype html>
<html lang="zxx">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Keranjang - Furnimart</title>
  <link rel="icon" href="img/favicon.png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- animate CSS -->
  <link rel="stylesheet" href="css/animate.css">
  <!-- owl carousel CSS -->
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <!-- nice select CSS -->
  <link rel="stylesheet" href="css/nice-select.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="css/all.css">
  <!-- flaticon CSS -->
  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/themify-icons.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="css/magnific-popup.css">
  <!-- swiper CSS -->
  <link rel="stylesheet" href="css/slick.css">
  <link rel="stylesheet" href="css/price_rangs.css">
  <!-- style CSS -->
  <link rel="stylesheet" href="css/style.css">
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
                  <a class="nav-link" href="contact.html">Hubungi Kami</a>
                </li>
              </ul>
            </div>
            <?php session_start(); ?>
            <?php if (isset($_SESSION['username'])) : ?>
              <div class="header_icon d-flex">
                <!-- Cart Link -->
                <div class="cart">
                  <a href="cart.php" id="cartLink">
                    <i class="fas fa-cart-plus"></i>
                  </a>
                </div>

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
              <h2>Keranjang</h2>
              <p>Beranda <span>-</span>Keranjang</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb start-->

  <!--================Cart Area =================-->
  <section class="cart_area padding_top">
    <div class="container">
      <div class="cart_inner">
        <div class="table-responsive">
          <?php
          include 'admin/koneksi.php'; // Pastikan koneksi ke database dimuat

          if (!isset($_SESSION['id_user'])) {
            echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
            exit;
          }

          $id_user = $_SESSION['id_user']; // Ambil user_id dari sesi
          $query = "SELECT p.id_pesanan, pr.nm_produk, pr.harga, p.qty, (pr.harga * p.qty) AS total, pr.gambar 
FROM tb_pesanan p
JOIN tb_produk pr ON p.id_produk = pr.id_produk
JOIN tb_user u ON p.id_user = u.id_user
WHERE u.id_user = '$id_user'";

          $result = mysqli_query($koneksi, $query);

          if (!$result) {
            die("Query Error: " . mysqli_error($koneksi));
          }

          // Inisialisasi subtotal
          $subtotal = 0;
          ?>

          <table class="table">
            <thead>
              <tr>
                <th style="width: 40%;">Produk</th>
                <th style="width: 20%;">Harga</th>
                <th style="width: 20%;">Jumlah</th>
                <th style="width: 15%;">Total</th>
                <th style="width: 5%;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)) {
                // Tambahkan ke subtotal
                $subtotal += $row['total'];
                // Hitung diskon berdasarkan subtotal
                $diskon = 0;
                if ($subtotal > 700000 && $subtotal <= 1500000) {
                  $diskon = 0.05 * $subtotal; // Diskon 5%
                } elseif ($subtotal > 1500000) {
                  $diskon = 0.08 * $subtotal; // Diskon 8%
                }

                // Hitung total bayar
                $total_bayar = $subtotal - $diskon;
              ?>
                <tr>
                  <td>
                    <div class="media d-flex align-items-center">
                      <img src="admin/produk_img/<?php echo $row['gambar']; ?>" alt="" width="80px" class="me-3" />
                      <p class="mb-0 p-3"><?php echo $row['nm_produk']; ?></p>
                    </div>
                  </td>
                  <td>
                    <h5>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></h5>
                  </td>
                  <td>
                    <div class="product_count">
                      <span class="input-number-decrement"> <i class="ti-angle-down"></i></span>
                      <input class="input-number" type="text" value="<?php echo $row['qty']; ?>" min="1">
                      <span class="input-number-increment"> <i class="ti-angle-up"></i></span>
                    </div>
                  </td>

                  <script>
                    document.addEventListener("DOMContentLoaded", function() {
                      // Hapus semua event listener sebelumnya (mencegah duplikasi event)
                      document.querySelectorAll(".input-number-decrement, .input-number-increment").forEach(button => {
                        let newButton = button.cloneNode(true); // Clone untuk reset event listener
                        button.replaceWith(newButton); // Ganti dengan tombol baru tanpa event lama
                      });

                      // Tambahkan event listener yang baru
                      document.querySelectorAll(".product_count").forEach(product => {
                        let decrementButton = product.querySelector(".input-number-decrement");
                        let incrementButton = product.querySelector(".input-number-increment");
                        let inputField = product.querySelector(".input-number");

                        decrementButton.addEventListener("click", function() {
                          let value = parseInt(inputField.value);
                          if (value > 1) {
                            inputField.value = value - 1;
                          }
                        });

                        incrementButton.addEventListener("click", function() {
                          let value = parseInt(inputField.value);
                          inputField.value = value + 1;
                        });
                      });
                    });
                  </script>
                  <td>
                    <h5>Rp. <?php echo number_format($row['total'], 0, ',', '.'); ?></h5>
                  </td>
                  <td>
                    <form action="hapus_cart.php" method="POST">
                      <input type="hidden" name="id_pesanan" value="<?php echo $row['id_pesanan']; ?>">
                      <button type="submit" class="btn btn-danger btn-sm">
                        <i class="ti-close"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php } ?>

              <tr class="bottom_button">
                <td>
                  <a class="btn_1" href="#">Update Cart</a>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <div class="cupon_text float-right">
                    <a class="btn_1" href="#">Close Coupon</a>
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="3"></td> <!-- Mengosongkan tiga kolom pertama -->
                <td>
                  <h5>Subtotal</h5>
                </td>
                <td style="text-align: right;">
                  <h5>Rp. <?php echo number_format($subtotal, 0, ',', '.'); ?></h5>
                </td>
              </tr>
              <tr>
                <td colspan="3"></td> <!-- Mengosongkan tiga kolom pertama -->
                <td>
                  <h5>Diskon</h5>
                </td>
                <td style="text-align: right;">
                  <h5>Rp. <?php echo number_format($diskon, 0, ',', '.'); ?></h5>
                </td>
              </tr>
              <tr>
                <td colspan="3"></td> <!-- Mengosongkan tiga kolom pertama -->
                <td>
                  <h5>Total Bayar</h5>
                </td>
                <td style="text-align: right;">
                  <h5>Rp. <?php echo number_format($total_bayar, 0, ',', '.'); ?></h5>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="checkout_btn_inner float-right">
            <a class="btn_1" href="belanja.php">Continue Shopping</a>
            <a class="btn_1 checkout_btn_1" href="#">Proceed to checkout</a>
          </div>
        </div>
      </div>
  </section>
  <!--================End Cart Area =================-->

  <!--::footer_part start::-->
  <footer class="footer_part">
    <div class="container">
      <div class="row justify-content-around">
        <div class="col-sm-6 col-lg-2">
          <div class="single_footer_part">
            <h4>Top Products</h4>
            <ul class="list-unstyled">
              <li><a href="">Managed Website</a></li>
              <li><a href="">Manage Reputation</a></li>
              <li><a href="">Power Tools</a></li>
              <li><a href="">Marketing Service</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-lg-2">
          <div class="single_footer_part">
            <h4>Quick Links</h4>
            <ul class="list-unstyled">
              <li><a href="">Jobs</a></li>
              <li><a href="">Brand Assets</a></li>
              <li><a href="">Investor Relations</a></li>
              <li><a href="">Terms of Service</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-lg-2">
          <div class="single_footer_part">
            <h4>Features</h4>
            <ul class="list-unstyled">
              <li><a href="">Jobs</a></li>
              <li><a href="">Brand Assets</a></li>
              <li><a href="">Investor Relations</a></li>
              <li><a href="">Terms of Service</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-lg-2">
          <div class="single_footer_part">
            <h4>Resources</h4>
            <ul class="list-unstyled">
              <li><a href="">Guides</a></li>
              <li><a href="">Research</a></li>
              <li><a href="">Experts</a></li>
              <li><a href="">Agencies</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4">
          <div class="single_footer_part">
            <h4>Newsletter</h4>
            <p>Heaven fruitful doesn't over lesser in days. Appear creeping
            </p>
            <div id="mc_embed_signup">
              <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe_form relative mail_part">
                <input type="email" name="email" id="newsletter-form-email" placeholder="Email Address" class="placeholder hide-on-focus" onfocus="this.placeholder = ''" onblur="this.placeholder = ' Email Address '">
                <button type="submit" name="submit" id="newsletter-submit" class="email_icon newsletter-submit button-contactForm">subscribe</button>
                <div class="mt-10 info"></div>
              </form>
            </div>
          </div>
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
                </script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></P>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="footer_icon social_icon">
              <ul class="list-unstyled">
                <li><a href="#" class="single_social_icon"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#" class="single_social_icon"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#" class="single_social_icon"><i class="fas fa-globe"></i></a></li>
                <li><a href="#" class="single_social_icon"><i class="fab fa-behance"></i></a></li>
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
  <script src="js/stellar.js"></script>
  <script src="js/price_rangs.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
</body>

</html>