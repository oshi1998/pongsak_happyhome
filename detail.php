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


    <style>
        .preview-main-img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .preview-other-img {
            width: 100%;
            height: 100px;
            object-fit: cover;
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
                    <li><a class="nav-link" role="button" onclick="window.history.back()">ย้อนกลับ</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

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
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-12" data-aos="fade-left">
                        <a role="button" onclick="viewImageMain('<?= $room->rt_image ?>')">
                            <img class="preview-main-img" src="assets/img/roomtypes/<?= $room->rt_image ?>">
                        </a>
                    </div>

                    <div class="col-lg-5 col-12" data-aos="fade-right">

                        <div class="card">
                            <div class="card-header">
                                ห้องพักแบบ <?= $room->rt_name ?>
                            </div>
                            <div class="card-body">
                                <?= $room->rt_content ?>
                            </div>
                            <div class="card-footer">
                                ราคาที่พัก : <?= $room->rt_price . " บาท/คืน" ?>
                            </div>
                        </div>

                        <br>
                        <a href="book.php" class="btn btn-outline-success">สนใจจองที่พัก</a>

                        <hr>
                        <?php if (!empty($images)) : ?>
                            <strong>รูปภาพเพิ่มเติม</strong>
                            <div class="row">
                                <?php foreach ($images as $image) { ?>
                                    <div class="col-lg-4 col-3" data-aos="zoom-in" data-aos-delay="150">
                                        <a role="button" onclick="viewImageOther('<?= $image['file_name'] ?>')">
                                            <div class="box">
                                                <img class="preview-other-img" src="assets/img/roomtypes/other/<?= $image['file_name'] ?>">
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </section>


        <!-- Zoom Image Modal -->
        <div class="modal fade" id="zoomImageModal" tabindex="-1" aria-labelledby="zoomImageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="showFullImage">

                    </div>
                </div>
            </div>
        </div>

    </main><!-- End #main -->

    <?php require_once('layouts/footer.php'); ?>


    <script src="js_function/detail_page.js"></script>
</body>

</html>