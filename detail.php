<?php

session_start();

if (isset($_GET['id'])) {

    require_once('services/connect.php');

    $sql = "SELECT * FROM website";
    $stmt = $pdo->query($sql);
    $web = $stmt->fetch(PDO::FETCH_OBJ);

    $sql = "SELECT * FROM roomtypes WHERE rt_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $room = $stmt->fetchObject();

    $sql = "SELECT * FROM images WHERE rt_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $images = $stmt->fetchAll();

    $sql = "UPDATE roomtypes SET rt_view = rt_view+1 WHERE rt_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);

} else {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>รายละเอียดห้องพัก | <?= $room->rt_name ?></title>
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
                    <li><a class="nav-link" role="button" onclick="window.history.back()">ย้อนกลับ</a></li>
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
                    <li><a href="index.php">หน้าแรก</a></li>
                    <li>รายละเอียดห้องพัก <?= $room->rt_name ?></li>
                </ol>
                <h2>ยอดผู้เข้าชม : <?= $room->rt_view ?></h2>
            </div>
        </section><!-- End Breadcrumbs -->

        <section class="inner-page">
            <?php



            ?>
        </section>

    </main><!-- End #main -->

    <?php require_once('layouts/footer.php'); ?>
</body>

</html>