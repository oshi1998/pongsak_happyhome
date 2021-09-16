<?php
session_start();
require_once('services/connect.php');

$sql = "SELECT * FROM website";
$stmt = $pdo->query($sql);
$web = $stmt->fetch(PDO::FETCH_OBJ);

$sql = "SELECT * FROM welcome";
$stmt = $pdo->query($sql);
$welcome = $stmt->fetch(PDO::FETCH_OBJ);

$sql = "SELECT * FROM aboutus";
$stmt = $pdo->query($sql);
$aboutus = $stmt->fetch(PDO::FETCH_OBJ);


$sql = "SELECT * FROM services ORDER BY sv_no ASC";
$stmt = $pdo->query($sql);
$services = $stmt->fetchAll();

$sql = "SELECT * FROM roomtypes ORDER BY rt_created ASC";
$stmt = $pdo->query($sql);
$roomtypes = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ยินดีต้อนรับ <?= $web->web_name ?></title>
    <meta content="<?= $web->web_description ?>" name="description">
    <meta content="<?= $web->web_keywords ?>" name="keywords">

    <?php require_once('layouts/head.php'); ?>

    <style>
        #hero {
            width: 100%;
            height: calc(100vh - 110px);
            background: url("assets/img/<?= $welcome->welcome_img ?>") top center;
            background-size: cover;
            position: relative;
        }
    </style>
</head>

<body>

    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope-fill"></i><a href="mailto:<?= $web->web_email ?>"><?= $web->web_email ?></a>
                <i class="bi bi-phone-fill phone-icon"></i><?= $web->web_phone ?>
            </div>
            <div class="social-links d-none d-md-block">
                <a href="<?= $web->web_twitter ?>" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="<?= $web->web_facebook ?>" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="<?= $web->web_ig ?>" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="<?= $web->web_youtube ?>" class="youtube"><i class="bi bi-youtube"></i></i></a>
            </div>
        </div>
    </section>

    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <h1 class="logo"><a href="index.php"><?= $web->web_name ?></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">หน้าแรก</a></li>
                    <li><a class="nav-link scrollto" href="#about">เกี่ยวกับเรา</a></li>
                    <li><a class="nav-link scrollto" href="#services">บริการที่พัก</a></li>
                    <li><a class="nav-link scrollto" href="#pricing">จองที่พัก</a></li>
                    <li><a class="nav-link scrollto" href="#contact">ติดต่อเรา</a></li>
                    <?php if (!isset($_SESSION['USER_LOGIN'])) : ?>
                        <li><a class="nav-link" role="button" data-bs-toggle="modal" data-bs-target="#loginModal">เข้าสู่ระบบ</a></li>
                        <li><a class="nav-link" role="button" data-bs-toggle="modal" data-bs-target="#registerModal">สมัครสมาชิก</a></li>
                    <?php else : ?>
                        <li class="dropdown">
                            <a href="javascript:void(0)">
                                <span>
                                    <?php if ($_SESSION['USER_ROLE'] == "CUSTOMER") : ?>
                                        <img class="avatar" src="assets/img/customers/<?= $_SESSION['USER_PROFILE'] ?>">
                                    <?php endif ?>
                                    <strong><?= $_SESSION['USER_USERNAME'] ?></strong>
                                </span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <ul>
                                <?php if ($_SESSION['USER_ROLE'] == "CUSTOMER") : ?>
                                    <li><a href="mybooking.php">รายการจองของฉัน</a></li>
                                    <li><a role="button" onclick="myAccount('<?= $_SESSION['USER_USERNAME'] ?>')">ตั้งค่าบัญชี</a></li>
                                    <li><a role="button" onclick="changePassword('<?= $_SESSION['USER_USERNAME'] ?>')">เปลี่ยนรหัสผ่าน</a></li>
                                <?php elseif ($_SESSION['USER_ROLE'] == "ADMIN") : ?>
                                    <li><a href="admin.php">จัดการข้อมูลหลังบ้าน</a></li>
                                <?php endif ?>
                                <li><a role="button" onclick="logOut()">ออกจากระบบ</a></li>
                            </ul>
                        </li>
                    <?php endif ?>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->


    <!-- Include My Modal -->
    <?php include('layouts/myModal.php'); ?>
    <!-- End Include My Modal -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="500">
            <h1><?= $welcome->welcome_head ?></h1>
            <h2><?= $welcome->welcome_desc ?></h2>
        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left">
                        <img src="assets/img/<?= $aboutus->aboutus_image ?>" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
                        <?= $aboutus->aboutus_content ?>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <!-- ======= Why Us Section ======= -->
        <!-- <section id="why-us" class="why-us">
            <div class="container">

                <div class="row">

                    <div class="col-lg-4" data-aos="fade-up">
                        <div class="box">
                            <img class="img-responsive" src="assets/img/about/01.jpg">
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="150">
                        <div class="box">
                            <img class="img-responsive" src="assets/img/about/02.jpg">
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
                        <div class="box">
                            <img class="img-responsive" src="assets/img/about/03.jpg">
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="450">
                        <div class="box">
                            <img class="img-responsive" src="assets/img/about/04.jpg">
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="600">
                        <div class="box">
                            <img class="img-responsive" src="assets/img/about/05.jpg">
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="750">
                        <div class="box">
                            <img class="img-responsive" src="assets/img/about/06.jpg">
                        </div>
                    </div>

                </div>

            </div>
        </section> --><!-- End Why Us Section -->

        <!-- ======= Clients Section ======= -->
        <section id="clients" class="clients">
        </section><!-- End Clients Section -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services">
            <div class="container">

                <div class="section-title">
                    <span>บริการที่พัก</span>
                    <h2>บริการที่พัก</h2>
                    <p>รายละเอียดเกี่ยวกับบริการที่พักของเรา</p>
                </div>

                <div class="row">
                    <?php foreach ($services as $service) { ?>
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                            <div class="icon-box w-100">
                                <div class="icon"><?= $service['sv_icon'] ?></div>
                                <h4><a href="javascript:void(0)"><?= $service['sv_heading'] ?></a></h4>
                                <p><?= $service['sv_desc'] ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </section><!-- End Services Section -->

        <!-- ======= Pricing Section ======= -->
        <section id="pricing" class="pricing">
            <div class="container">

                <div class="section-title">
                    <span>ประเภทห้องพัก</span>
                    <h2>ประเภทห้องพัก</h2>
                    <p>อัตราค่าบริการห้องพักของเรา</p>
                </div>

                <div class="row">

                    <?php foreach ($roomtypes as $type) { ?>
                        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="150">
                            <div class="box">
                                <h3><?= $type['rt_name'] ?></h3>
                                <img class="img-responsive" src="assets/img/roomtypes/<?= $type['rt_image']?>">
                                <h4><?= $type['rt_price'] ?> บาท<span> / คืน</span></h4>
                                <div class="btn-wrap">
                                    <a href="detail.php?id=<?= $type['rt_id']?>" class="btn-buy">รายละเอียด</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>

            </div>
        </section><!-- End Pricing Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            
            <div class="container">

                <div class="section-title">
                    <span>ติดต่อเรา</span>
                    <h2>ติดต่อเรา</h2>
                    <p>ข้อมูลสำหรับติดต่อเรา</p>
                </div>

                <div class="row" data-aos="fade-up">
                    <div class="col-lg-6">
                        <div class="info-box mb-4">
                            <i class="bx bx-map"></i>
                            <h3>ที่อยู่</h3>
                            <p><?= $web->web_address ?></p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-envelope"></i>
                            <h3>อีเมล</h3>
                            <p><?= $web->web_email ?></p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-phone-call"></i>
                            <h3>เบอร์โทร</h3>
                            <p><?= $web->web_phone ?></p>
                        </div>
                    </div>

                </div>

                <div class="row" data-aos="fade-up">

                    <div class="col-lg-12">
                        <?= $web->web_google_map ?>
                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <script src="js_function/customer_side.js"></script>

    <?php require_once('layouts/footer.php'); ?>
</body>

</html>