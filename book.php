<?php

session_start();

if (isset($_SESSION['USER_LOGIN'])) {
    require_once('services/connect.php');

    $sql = "SELECT * FROM website";
    $stmt = $pdo->query($sql);
    $web = $stmt->fetch(PDO::FETCH_OBJ);


    $sql = "SELECT * FROM roomtypes";
    $stmt = $pdo->query($sql);
    $roomtypes = $stmt->fetchAll();

    if (isset($_GET['step'])) {

        if ($_GET['step'] == 2) {
            if (empty($_SESSION['MYBOOK'])) {
                $_SESSION['error'] = "ขออภัย ท่านยังไม่ได้กรอกแบบฟอร์มขอจอง สำหรับการจอง";
                header('location:book.php');
            }
        } else if ($_GET['step'] == 3) {
            if (!isset($_SESSION['book_success']) || empty($_SESSION['book_success'])) {
                header('location:book.php');
            }
        }
    }
} else {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>จองที่พัก | <?= $web->web_name ?></title>
    <meta content="<?= $web->web_description ?>" name="description">
    <meta content="<?= $web->web_keywords ?>" name="keywords">

    <link rel="stylesheet" href="assets/vendor/daterangepicker/daterangepicker.css">

    <?php require_once('layouts/head.php'); ?>

    <style>
        .progressbar {
            counter-reset: step;
        }

        .progressbar li {
            list-style-type: none;
            width: 25%;
            float: left;
            font-size: 12px;
            position: relative;
            text-align: center;
            text-transform: uppercase;
            color: #7d7d7d;
        }

        .progressbar li:before {
            width: 30px;
            height: 30px;
            content: counter(step);
            counter-increment: step;
            line-height: 30px;
            border: 2px solid #7d7d7d;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: white;
        }

        .progressbar li:after {
            width: 100%;
            height: 2px;
            content: '';
            position: absolute;
            background-color: #7d7d7d;
            top: 15px;
            left: -50%;
            z-index: -1;
        }

        .progressbar li:first-child:after {
            content: none;
        }

        .progressbar li.active {
            color: green;
        }

        .progressbar li.active:before {
            border-color: #55b776;
        }

        .progressbar li.active+li:after {
            background-color: #55b776;
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
                    <li>จองที่พัก</li>
                </ol>
                <h2>จองที่พัก</h2>
            </div>
        </section><!-- End Breadcrumbs -->

        <section class="inner-page">

            <div class="container">

                <ul class="progressbar d-flex justify-content-center" data-aos="zoom-in">
                    <li class="active">กรอกแบบฟอร์ม</li>
                    <li class="<?= (isset($_GET['step']) && $_GET['step'] == 2 || isset($_GET['step']) && $_GET['step'] == 3) ? 'active' : '' ?>">ตรวจสอบ</li>
                    <li class="<?= (isset($_GET['step']) && $_GET['step'] == 3) ? 'active' : '' ?>">เสร็จสิ้น</li>
                </ul>

                <br><br><br>
                <hr>


                <?php if (!isset($_GET['step'])) : ?>
                    <div class="card" data-aos="fade-up">
                        <div class="card-header">
                            ขั้นที่ 1 กรอกแบบฟอร์มขอจองห้องพัก
                        </div>
                        <div class="card-body">
                            <form id="checkIn-checkOut-Form">

                                <input type="text" name="action" value="checkin-checkout" readonly hidden>
                                <input type="text" name="checkin" readonly hidden>
                                <input type="text" name="checkout" readonly hidden>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">ช่วงวันที่</label>
                                    <div class="col-sm-10">
                                        <input role="button" class="form-control" name="daterange">
                                    </div>
                                </div>

                                <br>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">ระยะเวลา (คืน)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="duration" value="1" readonly>
                                    </div>
                                </div>

                                <br>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">เวลา</label>
                                    <div class="col-sm-10">
                                        <input type="time" class="form-control" name="time" required>
                                    </div>
                                </div>

                                <br>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">ประเภทห้อง</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="roomtype">
                                            <?php foreach ($roomtypes as $type) { ?>
                                                <option value="<?= $type['rt_id'] ?>"><?= $type['rt_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <br>
                                <button type="submit" class="btn btn-success float-end">ต่อไป</button>
                            </form>
                        </div>
                    </div>
                <?php else : ?>
                    <?php if ($_GET['step'] == 2) : ?>
                        <div class="card" data-aos="fade-up">
                            <div class="card-header">
                                ขั้นที่ 2 ตรวจสอบข้อมูลการขอจองที่พัก
                            </div>
                            <div class="card-body">
                                <div class="table table-responsive">
                                    <table class="table table-condensed">
                                        <tr>
                                            <th>ผู้ทำการจอง</th>
                                            <td><?= $_SESSION['USER_USERNAME'] . " (" . $_SESSION['USER_NAME'] . ")" ?></td>
                                        </tr>
                                        <tr>
                                            <th>ช่วงเวลา</th>
                                            <td><?= $_SESSION['MYBOOK']['daterange'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>ระยะเวลา</th>
                                            <td><?= $_SESSION['MYBOOK']['duration'] . " คืน" ?></td>
                                        </tr>
                                        <tr>
                                            <th>ประเภทห้อง</th>
                                            <td><?= $_SESSION['MYBOOK']['roomtype_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>ค่าห้อง/คืน</th>
                                            <td><?= number_format($_SESSION['MYBOOK']['roomtype_price'], 2) ?></td>
                                        </tr>
                                        <tr>
                                            <th>กำหนดการเช็คอิน</th>
                                            <td><?= $_SESSION['MYBOOK']['checkin'] . " เวลา " . $_SESSION['MYBOOK']['time'] . " น." ?></td>
                                        </tr>
                                        <tr>
                                            <th>กำหนดการเช็คเอาท์</th>
                                            <td><?= $_SESSION['MYBOOK']['checkout'] . " เวลา " . $_SESSION['MYBOOK']['time'] . " น." ?></td>
                                        </tr>
                                        <tr>
                                            <th>รวมค่าที่พักทั้งหมด</th>
                                            <td><?= number_format($_SESSION['MYBOOK']['total'], 2) ?></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="justify-content-between text-end">
                                    <a href="book.php" class="btn btn-info">ย้อนกลับ</a>
                                    <a role="button" class="btn btn-success" onclick="booking()">ดำเนินการจอง</a>
                                </div>
                            </div>


                        </div>
                    <?php elseif ($_GET['step'] == 3) : ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['book_success']; ?>
                            <br>
                            ท่านสามารถติดตามสถานะการขอจองที่พักของท่านได้ที่ <a href="mybooking.php">รายการจองของฉัน</a>
                        </div>
                        <div class="text-center">
                            <a href="index.php" class="btn btn-danger">กลับหน้าแรก</a>
                        </div>
                    <?php endif ?>

                <?php endif ?>
            </div>
        </section>

    </main><!-- End #main -->

    <?php require_once('layouts/footer.php'); ?>

    <script src="assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="js_function/book.js"></script>
</body>

</html>