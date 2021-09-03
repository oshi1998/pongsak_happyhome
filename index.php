<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Pongsak Happy Home</title>
    <meta content="Pongsak Home Happy" name="description">
    <meta content="pongsak,home,happy" name="keywords">

    <?php require_once('layouts/head.php'); ?>
</head>

<body>

    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope-fill"></i><a href="mailto:contact@example.com">pongsak_happyhome@gmail.com</a>
                <i class="bi bi-phone-fill phone-icon"></i> 061 660 4587
            </div>
            <div class="social-links d-none d-md-block">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
            </div>
        </div>
    </section>

    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <h1 class="logo"><a href="index.html">Pongsak Happy Home</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">หน้าแรก</a></li>
                    <li><a class="nav-link scrollto" href="#about">เกี่ยวกับเรา</a></li>
                    <li><a class="nav-link scrollto" href="#services">บริการที่พัก</a></li>
                    <li><a class="nav-link scrollto" href="#pricing">ค่าบริการที่พัก</a></li>
                    <li><a class="nav-link scrollto" href="#contact">ติดต่อเรา</a></li>
                    <?php if (!isset($_SESSION['USER_LOGIN'])) : ?>
                        <li><a class="nav-link" role="button" data-bs-toggle="modal" data-bs-target="#loginModal">เข้าสู่ระบบ</a></li>
                        <li><a class="nav-link" role="button" data-bs-toggle="modal" data-bs-target="#registerModal">สมัครสมาชิก</a></li>
                    <?php else : ?>
                        <li class="dropdown"><a href="#"><span><?= $_SESSION['USER_USERNAME'] ?></span> <i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <?php if ($_SESSION['USER_ROLE'] == "MEMBER") : ?>
                                    <li><a role="button" onclick="myAccount('<?= $_SESSION['USER_USERNAME'] ?>')">ตั้งค่าบัญชี</a></li>
                                    <li><a role="button" onclick="closeAccount('<?= $_SESSION['USER_USERNAME'] ?>')">ปิดบัญชี</a></li>
                                <?php elseif ($_SESSION['USER_ROLE'] == "ADMIN") : ?>
                                    <li><a href="admin.php">ข้อมูลหลังบ้าน</a></li>
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
            <h1>ยินดีต้อนรับสู่ Pongsak Happy Home</h1>
            <h2>บริการที่พักราคาถูก สะอาด ปลอดภัย</h2>
            <a href="#about" class="btn-get-started scrollto">เกี่ยวกับเรา</a>
        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left">
                        <img src="assets/img/about/04.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
                        <h3>Pongsak Happy Home</h3>
                        <p class="fst-italic">
                            บริการที่พัก
                        </p>
                        <ul>
                            <li><i class="bi bi-check-circle" style="color: green;"></i> ราคาถูก</li>
                            <li><i class="bi bi-check-circle" style="color: green;"></i> สะอาด</li>
                            <li><i class="bi bi-check-circle" style="color: green;"></i> ปลอดภัย</li>
                        </ul>
                        <p>
                            รายละเอียดเกี่ยวกับบริการที่พักของเรา
                        </p>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <!-- ======= Why Us Section ======= -->
        <section id="why-us" class="why-us">
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
        </section><!-- End Why Us Section -->

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
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                        <div class="icon-box w-100">
                            <div class="icon"><i class='bx bxs-magic-wand'></i></div>
                            <h4><a href="javascript:void(0)">ทำความสะอาด</a></h4>
                            <p>บริการที่ความสะอาด ทุกสัปดาห์ ทุกวันจันทร์ ตั้งแต่เวลา 09.00 - 17.00 น.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="150">
                        <div class="icon-box w-100">
                            <div class="icon"><i class='bx bx-shield-quarter'></i></div>
                            <h4><a href="javascript:void(0)">ดูแลรักษาความปลอดภัย</a></h4>
                            <p>มีเจ้าหน้าที่คอยดูแลรักษาความปลอดภัยตลอด 24 ชั่วโมง</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon-box w-100">
                            <div class="icon"><i class='bx bxs-parking'></i></div>
                            <h4><a href="javascript:void(0)">ที่จอดรถ</a></h4>
                            <p>พื้นที่จอดรถสะดวก สามารถทจอดได้ทั้งรถมอเตอร์ไซค์ และรถยนต์</p>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Services Section -->

        <!-- ======= Pricing Section ======= -->
        <section id="pricing" class="pricing">
            <div class="container">

                <div class="section-title">
                    <span>ค่าบริการที่พัก</span>
                    <h2>ค่าบริการที่พัก</h2>
                    <p>อัตราค่าบริการที่พักของเรา</p>
                </div>

                <div class="row">

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="150">
                        <div class="box">
                            <h3>ชั่วคราว</h3>
                            <h4>300 บาท<span> / วัน</span></h4>
                            <ul>
                                <li>พักได้ 2 คน</li>
                                <li>เครื่องทำน้ำอุ่น</li>
                                <li>เฟอร์นิเจอร์ครบ</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="javascript:void(0)" class="btn-buy">จองทันที</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-4 mt-md-0" data-aos="zoom-in">
                        <div class="box featured">
                            <h3>ธรรมดา</h3>
                            <h4>3,500 บาท<span> / เดือน</span></h4>
                            <ul>
                                <li>พักได้ 3 คน</li>
                                <li>เครื่องทำน้ำอุ่น</li>
                                <li>มีพัดลม</li>
                                <li>เฟอร์นิเจอร์ครบ</li>
                                <li class="na">เครื่องปรับอากาศ</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">จองทันที</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="150">
                        <div class="box">
                            <h3>พิเศษ</h3>
                            <h4>4,500 บาท<span> / เดือน</span></h4>
                            <ul>
                                <li>พักได้ 4 คน</li>
                                <li>เครื่องทำน้ำอุ่น</li>
                                <li>มีพัดลม</li>
                                <li>มีเครื่องปรับอากาศ</li>
                                <li>เฟอร์นิเจอร์ครบ</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">จองทันที</a>
                            </div>
                        </div>
                    </div>

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
                            <p>A142/2 ถนนเจ้าฟ้า ตำบลไสไทย อำเภอเมืองกระบี่ กระบี่ 81000</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-envelope"></i>
                            <h3>อีเมล</h3>
                            <p>pongsak_happyhome@gmail.com</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-phone-call"></i>
                            <h3>เบอร์โทร</h3>
                            <p>061 660 4587</p>
                        </div>
                    </div>

                </div>

                <div class="row" data-aos="fade-up">

                    <div class="col-lg-6 ">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3950.398615732891!2d98.90286261477989!3d8.06075969419609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3051949507d2c113%3A0xb4a0317d7416670b!2z4Lie4LiH4Lio4LmM4Lio4Lix4LiB4LiU4Li04LmMIOC5geC4ruC4m-C4m-C4teC5iSDguYLguK7guKE!5e0!3m2!1sth!2sth!4v1630664254037!5m2!1sth!2sth" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>

                    <div class="col-lg-6">
                        <form>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="ชื่อของคุณ" required>
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="อีเมลของคุณ" required>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="หัวข้อ" required>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="message" rows="5" placeholder="ข้อความ" required></textarea>
                            </div>
                            <div class="my-3">
                                <div class="loading">กำลังโหลด...</div>
                                <div class="error-message"></div>
                                <div class="sent-message">ข้อความของคุณได้ถูกส่งแล้ว ขอบคุณมาก</div>
                            </div>
                            <div class="text-center"><button type="submit">ส่งข้อความ</button></div>
                        </form>
                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <?php require_once('layouts/footer.php'); ?>
</body>

</html>