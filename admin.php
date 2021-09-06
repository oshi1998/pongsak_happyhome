<?php

session_start();

if (!isset($_SESSION['USER_LOGIN']) || $_SESSION['USER_ROLE'] != "ADMIN") {
    header('location:index.php');
} else {

    require_once('services/connect.php');

    $sql = "SELECT * FROM website";
    $stmt = $pdo->query($sql);
    $web = $stmt->fetch(PDO::FETCH_OBJ);

    if (empty($_GET)) {
        $page_title = "จัดการข้อมูลพื้นฐานเว็บไซต์";
    } else {
        if (isset($_GET['admins'])) {

            $page_title = "จัดการข้อมูลผู้ดูแลระบบ";

            $sql = "SELECT * FROM admins";
            $stmt = $pdo->query($sql);
            $data = $stmt->fetchAll();
        } else if (isset($_GET['customers'])) {
            $page_title = "จัดการข้อมูลลูกค้า";

            $sql = "SELECT * FROM customers";
            $stmt = $pdo->query($sql);
            $data = $stmt->fetch();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= $web->web_name . " | " . $page_title ?></title>
    <meta content="<?= $web->web_description ?>" name="description">
    <meta content="<?= $web->web_keywords ?>" name="keywords">

    <?php require_once('layouts/head.php'); ?>
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
                    <li><a class="nav-link <?= (empty($_GET)) ? "active" : '' ?>" href="admin.php">ข้อมูลพื้นฐานเว็บไซต์</a></li>
                    <li><a class="nav-link <?= (isset($_GET['admins'])) ? "active" : '' ?>" href="admin.php?admins">ข้อมูลผู้ดูแลระบบ</a></li>
                    <li><a class="nav-link <?= (isset($_GET['customers'])) ? "active" : '' ?>" href="admin.php?customers">ข้อมูลลูกค้า</a></li>
                    <?php if (!isset($_SESSION['USER_LOGIN'])) : ?>
                        <li><a class="nav-link" role="button" data-bs-toggle="modal" data-bs-target="#loginModal">เข้าสู่ระบบ</a></li>
                        <li><a class="nav-link" role="button" data-bs-toggle="modal" data-bs-target="#registerModal">สมัครสมาชิก</a></li>
                    <?php else : ?>
                        <li class="dropdown"><a href="#"><span><?= $_SESSION['USER_USERNAME'] ?></span> <i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <?php if ($_SESSION['USER_ROLE'] == "CUSTOMER") : ?>
                                    <li><a role="button" onclick="myAccount('<?= $_SESSION['USER_USERNAME'] ?>')">ตั้งค่าบัญชี</a></li>
                                    <li><a role="button" onclick="closeAccount('<?= $_SESSION['USER_USERNAME'] ?>')">ปิดบัญชี</a></li>
                                <?php elseif ($_SESSION['USER_ROLE'] == "ADMIN") : ?>
                                    <li><a class="nav-link" href="index.php">กลับไปหน้าบ้าน</a></li>
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

    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="admin.php">หลังบ้าน</a></li>
                    <li><?= $page_title; ?></li>
                </ol>
                <h2><?= $page_title; ?></h2>
            </div>
        </section><!-- End Breadcrumbs -->

        <section class="inner-page">
            <?php

            if (empty($_GET)) {
                require_once('website_table_form.php');
            } else {
                if (isset($_GET['admins'])) {
                    require_once('admins_table_form.php');
                }
            }

            ?>
        </section>

    </main><!-- End #main -->




    <?php require_once('layouts/footer.php'); ?>
</body>

</html>