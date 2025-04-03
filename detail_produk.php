<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Produk - Furnimart</title>
    <link rel="icon" href="img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/lightslider.min.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/all.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css">
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

    <!-- breadcrumb start-->
    <section class="breadcrumb breadcrumb_bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb_iner">
                        <div class="breadcrumb_iner_item">
                            <h2>Detail Produk</h2>
                            <p>Beranda <span>-</span> Detail Produk</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb start-->
    <!--================End Home Banner Area =================-->

    <!--================Single Product Area =================-->
    <?php
    include 'admin/koneksi.php';

    // Pastikan ada parameter id_produk yang dikirim dari URL
    $id_produk = isset($_GET['id']) ? $_GET['id'] : '';

    $query = "SELECT p.nm_produk, p.harga, p.stok, p.desk, p.gambar, k.nm_kategori 
          FROM tb_produk p
          JOIN tb_kategori k ON p.id_kategori = k.id_kategori
          WHERE p.id_produk = '$id_produk'";

    $result = $koneksi->query($query);
    $produk = $result->fetch_assoc();

    // Tambahkan pesanan ke database
    if (isset($_POST['add_to_cart'])) {
        if (!isset($_SESSION['login'])) {
            echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
        } else {
            $id_user = $_SESSION['id_user'];
            $qty = $_POST['qty'];
            $total = $produk['harga'] * $qty;

            // Periksa stok
            if ($qty > $produk['stok']) {
                echo "<script>alert('Stok tidak mencukupi!');</script>";
            } else {
                // Buat id_pesanan otomatis dengan format M001, M002, dst.
                $query_id = "SELECT id_pesanan FROM tb_pesanan ORDER BY id_pesanan DESC LIMIT 1";
                $result_id = $koneksi->query($query_id);
                if ($result_id->num_rows > 0) {
                    $row = $result_id->fetch_assoc();
                    $last_id = intval(substr($row['id_pesanan'], 1)); // Ambil angka dari id terakhir
                    $new_id = "M" . str_pad($last_id + 1, 3, '0', STR_PAD_LEFT); // Format M001, M002
                } else {
                    $new_id = "M001"; // Jika belum ada pesanan, mulai dari M001
                }

                // Simpan ke database
                $query_insert = "INSERT INTO tb_pesanan (id_pesanan, id_produk, qty, total, id_user) 
                             VALUES ('$new_id', '$id_produk', '$qty', '$total', '$id_user')";

                if ($koneksi->query($query_insert) === TRUE) {
                    echo "<script>alert('Produk berhasil ditambahkan ke keranjang!'); window.location.href='belanja.php';</script>";
                } else {
                    echo "<script>alert('Terjadi kesalahan, coba lagi!');</script>";
                }
            }
        }
    }
    ?>

    <!-- Kode HTML Produk -->
    <div class="product_image_area section_padding">
        <div class="container">
            <div class="row s_product_inner justify-content-between">
                <div class="col-lg-7 col-xl-7">
                    <div class="product_slider_img">
                        <div id="vertical">
                            <div data-thumb="admin/produk_img/<?php echo $produk['gambar']; ?>">
                                <img src="admin/produk_img/<?php echo $produk['gambar']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-4">
                    <div class="s_product_text">
                        <h3><?php echo $produk['nm_produk']; ?></h3>
                        <h2>Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></h2>
                        <ul class="list">
                            <li>
                                <a class="active" href="#">
                                    <span>Kategori</span> : <?php echo $produk['nm_kategori']; ?>
                                </a>
                            </li>
                        </ul>
                        <p><?php echo nl2br($produk['desk']); ?></p>

                        <form method="post">
                            <div class="card_area d-flex justify-content-between align-items-center">
                                <div class="product_count">
                                    <span class="inumber-decrement"> <i class="ti-minus"></i></span>
                                    <input class="input-number" type="text" name="qty" value="1" min="1" max="<?php echo $produk['stok']; ?>">
                                    <span class="number-increment"> <i class="ti-plus"></i></span>
                                </div>
                                <button type="submit" name="add_to_cart" class="btn_3">Add to Cart</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Deskripsi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Stok</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <p><?php echo nl2br($produk['desk']); ?></p>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <h5>Stok</h5>
                                    </td>
                                    <td>
                                        <h5><?php echo $produk['stok']; ?></h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--================End Product Description Area =================-->

    <!-- product_list part start-->
    <section class="product_list best_seller">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section_tittle text-center">
                        <h2>Produk Lainnya</h2>
                    </div>
                </div>
            </div>
            <?php
            // Ambil produk lain dari database, kecuali produk yang sedang dilihat
            $query_produk_lain = "SELECT id_produk, nm_produk, harga, gambar FROM tb_produk WHERE id_produk != '$id_produk' LIMIT 5";
            $result_produk_lain = $koneksi->query($query_produk_lain);
            ?>

            <div class="row align-items-center justify-content-between">
                <div class="col-lg-12">
                    <h3 class="text-center mb-4">Produk Lainnya</h3>
                    <div class="best_product_slider owl-carousel">
                        <?php while ($produk_lain = $result_produk_lain->fetch_assoc()) { ?>
                            <div class="single_product_item">
                                <img src="admin/produk_img/<?php echo $produk_lain['gambar']; ?>" alt="<?php echo $produk_lain['nm_produk']; ?>">
                                <div class="single_product_text">
                                    <h4><?php echo $produk_lain['nm_produk']; ?></h4>
                                    <h3>Rp <?php echo number_format($produk_lain['harga'], 0, ',', '.'); ?></h3>
                                    <a href="detail_produk.php?id=<?php echo $produk_lain['id_produk']; ?>" class="add_cart">Lihat Detail</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product_list part end-->

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
    <script src="js/lightslider.min.js"></script>
    <!-- swiper js -->
    <script src="js/masonry.pkgd.js"></script>
    <!-- particles js -->
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <!-- slick js -->
    <script src="js/slick.min.js"></script>
    <script src="js/swiper.jquery.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>
    <script src="js/stellar.js"></script>
    <!-- custom js -->
    <script src="js/theme.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>