<?php

session_start();

if (isset($_SESSION['USER_LOGIN'])) {
    require_once('services/connect.php');

    $sql = "SELECT * FROM website";
    $stmt = $pdo->query($sql);
    $web = $stmt->fetch(PDO::FETCH_OBJ);


    if (isset($_GET['step'])) {

        if ($_GET['step'] == 2) {
            if (!empty($_SESSION['MYBOOK'])) {
                $sql = "SELECT * FROM roomtypes";
                $stmt = $pdo->query($sql);
                $roomtypes = $stmt->fetchAll();
            } else {
                header('location:book.php');
            }
        } else if ($_GET['step'] == 3) {

            if (!empty($_SESSION['MYBOOK'])) {
                if (empty($_SESSION['MYBOOK']['room'])) {
                    $_SESSION['error'] = "ขออภัย ท่านยังไม่ได้ทำการเลือกห้องพัก สำหรับการจอง";
                    header('location:book.php?step=2');
                }
            } else {
                header('location:book.php');
            }
        } else if ($_GET['step'] == 4) {
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
                <ul>
                    <?php if (isset($_GET['step'])) : ?>
                        <li>
                            <?php if (!empty($_SESSION['MYBOOK'])) : ?>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#myBookModal" class="btn btn-info position-relative">
                                    รายการจอง
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?= count($_SESSION['MYBOOK']['room']) ?>
                                    </span>
                                </button>
                            <?php endif ?>
                        </li>
                    <?php endif ?>
                    <li><a href="index.php" class="nav-link">กลับไปหน้าแรก</a></li>
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
                    <li>จองที่พัก</li>
                </ol>
                <h2>จองที่พัก</h2>
            </div>
        </section><!-- End Breadcrumbs -->

        <section class="inner-page">

            <div class="container">

                <ul class="progressbar" data-aos="zoom-in">
                    <li class="active">เช็คอิน - เช็คเอาท์</li>
                    <li class="<?= (isset($_GET['step']) && $_GET['step'] == 2 || isset($_GET['step']) && $_GET['step'] == 3 || isset($_GET['step']) && $_GET['step'] == 4) ? 'active' : '' ?>">เลือกห้องพัก</li>
                    <li class="<?= (isset($_GET['step']) && $_GET['step'] == 3 || isset($_GET['step']) && $_GET['step'] == 4) ? 'active' : '' ?>">ตรวจสอบ</li>
                    <li class="<?= (isset($_GET['step']) && $_GET['step'] == 4) ? 'active' : '' ?>">เสร็จสิ้น</li>
                </ul>

                <br><br><br>
                <hr>

                <?php if (empty($_GET)) : ?>
                    <div class="card" data-aos="fade-up">
                        <div class="card-header">
                            ขั้นที่ 1 เลือกช่วงเวลา เช็คอิน - เช็คเอาท์
                        </div>
                        <div class="card-body">
                            <form id="checkIn-checkOut-Form">

                                <input type="text" name="action" value="checkin-checkout" readonly hidden>
                                <input type="text" name="checkin" readonly hidden>
                                <input type="text" name="checkout" readonly hidden>

                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">ช่วงวันที่</label>
                                    <div class="col-sm-10">
                                        <input role="button" class="form-control" name="daterange">
                                    </div>
                                </div>

                                <br>

                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">ระยะเวลา (คืน)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="duration" value="1" readonly>
                                    </div>
                                </div>

                                <br>

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">เวลา</label>
                                    <div class="col-sm-10">
                                        <input type="time" class="form-control" name="time" required>
                                    </div>
                                </div>

                                <br>
                                <button type="submit" class="btn btn-success float-end">ต่อไป</button>
                            </form>
                        </div>
                    </div>
                <?php else : ?>
                    <?php if ($_GET['step'] == 2) : ?>

                        <div class="text-center" data-aos="fade-down">
                            <h1>ระบบแสดงเฉพาะ ห้องพักที่พร้อมบริการ ในช่วงเวลาเช็คอิน - เช็คเอาท์ ของท่าน</h1>
                            <h3><?= $_SESSION['MYBOOK']['daterange'] ?></h3>
                        </div>

                        <br><br>

                        <div class="card" data-aos="fade-up">

                            <div class="card-header">
                                ขั้นที่ 2 เลือกห้องพัก
                            </div>
                            <div class="card-body">
                                <?php $i = 0; ?>

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <?php foreach ($roomtypes as $row) { ?>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link <?= ($i == 0) ? 'active' : '' ?>" id="<?= $row['rt_name'] . "-tab" ?>" data-bs-toggle="tab" href="<?= "#" . $row['rt_name'] ?>" role="tab" aria-controls="<?= $row['rt_name'] ?>" aria-selected="<?= ($i == 0) ? 'true' : 'false' ?>"><?= $row['rt_name'] ?></a>
                                        </li>
                                    <?php $i++;
                                    } ?>
                                </ul>


                                <?php $i = 0; ?>

                                <div class="tab-content" id="myTabContent">

                                    <?php foreach ($roomtypes as $row) { ?>

                                        <?php

                                        //code ค้นหาห้อง
                                        $sql = "SELECT r_id,rt_name,rt_price FROM rooms,roomtypes
                                        WHERE rooms.rt_id=roomtypes.rt_id
                                        AND rooms.rt_id = :rt_id 
                                        AND r_id NOT IN
                                        (SELECT bd_r_id FROM book,book_detail WHERE book_detail.bd_b_id=book.b_id AND :checkin_date < b_check_out AND :checkout_date > b_check_in AND b_status != :status)";

                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute([
                                            'rt_id' => $row['rt_id'],
                                            'checkin_date' => $_SESSION['MYBOOK']['checkin'],
                                            'checkout_date' => $_SESSION['MYBOOK']['checkout'],
                                            'status' => 'ไม่อนุมัติ'
                                        ]);

                                        $rooms = $stmt->fetchAll();

                                        ?>

                                        <div class="tab-pane fade <?= ($i == 0) ? 'show active' : '' ?>" id="<?= $row['rt_name'] ?>" role="tabpanel" aria-labelledby="<?= $row['rt_name'] . "-tab" ?>">
                                            <br><br>

                                            <?php if (isset($_SESSION['error'])) : ?>
                                                <div class="alert alert-danger">
                                                    <?= $_SESSION['error'] ?>
                                                    <?php unset($_SESSION['error']) ?>
                                                </div>
                                            <?php endif ?>



                                            <?php if (!empty($rooms)) : ?>
                                                <div class="row">
                                                    <?php foreach ($rooms as $room) { ?>
                                                        <div class="col-lg-4 col-6">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    ห้องหมายเลข <?= $room['r_id'] ?>
                                                                </div>
                                                                <div class="card-body d-flex justify-content-between">
                                                                    <label>
                                                                        ราคา <?= $room['rt_price'] . " บาท/คืน" ?>
                                                                    </label>
                                                                    <?php if (isset($_SESSION['MYBOOK']['room'][$room['r_id']])) : ?>
                                                                        <div>
                                                                            <button type="button" class="btn btn-danger" onclick="removeBook('<?= $room['r_id'] ?>')">
                                                                                <i class='bx bxs-minus-square'></i>
                                                                            </button>
                                                                            <button type="button" class="btn btn-success" disabled>
                                                                                <i class='bx bx-book-add'></i>
                                                                            </button>
                                                                        </div>
                                                                    <?php else : ?>
                                                                        <button type="button" class="btn btn-outline-success" onclick="addBook('<?= $room['r_id'] ?>')">
                                                                            <i class='bx bx-book-add'></i>
                                                                        </button>
                                                                    <?php endif ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <?php else : ?>
                                                <strong>ไม่มีห้องพร้อมบริการ</strong>
                                            <?php endif ?>
                                        </div>
                                    <?php $i++;
                                    } ?>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="justify-content-between text-end">
                            <a href="book.php" class="btn btn-info">ย้อนกลับ</a>
                            <a href="book.php?step=3" class="btn btn-success">ต่อไป</a>
                        </div>
                    <?php elseif ($_GET['step'] == 3) : ?>
                        <div class="card" data-aos="fade-up">
                            <div class="card-header">
                                ขั้นที่ 3 ตรวจสอบข้อมูลการขอจองที่พัก
                            </div>
                            <div class="card-body">
                                <div class="table table-responsive">

                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>ประเภท</th>
                                                <th>เลขห้อง</th>
                                                <th>ราคา/คืน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($_SESSION['MYBOOK']['room'] as $keys => $value) { ?>
                                                <tr>
                                                    <td><?= $value['type'] ?></td>
                                                    <td><?= $keys ?></td>
                                                    <td><?= $value['price'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>รวม</th>
                                                <td><?= count($_SESSION['MYBOOK']['room']) . " (ห้อง)" ?></td>
                                                <td><?= number_format($_SESSION['MYBOOK']['cost'],2) . " (บาท)" ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>

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
                                            <th>กำหนดการเช็คอิน</th>
                                            <td><?= $_SESSION['MYBOOK']['checkin'] . " เวลา " . $_SESSION['MYBOOK']['time'] . " น." ?></td>
                                        </tr>
                                        <tr>
                                            <th>กำหนดการเช็คเอาท์</th>
                                            <td><?= $_SESSION['MYBOOK']['checkout'] . " เวลา " . $_SESSION['MYBOOK']['time'] . " น." ?></td>
                                        </tr>
                                        <tr>
                                            <th>รวมค่าที่พักทั้งหมด</th>
                                            <td><?= number_format($_SESSION['MYBOOK']['cost'] * $_SESSION['MYBOOK']['duration'],2) ?></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="justify-content-between text-end">
                                    <a href="book.php?step=2" class="btn btn-info">ย้อนกลับ</a>
                                    <a role="button" class="btn btn-success" onclick="booking()">ดำเนินการจอง</a>
                                </div>
                            </div>


                        </div>
                    <?php elseif ($_GET['step'] == 4) : ?>
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

        <!-- My Book Modal -->
        <div class="modal fade" id="myBookModal" tabindex="-1" aria-labelledby="myBookModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myBookModalLabel">รายการจองห้องพัก <?= $web->web_name ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($_SESSION['MYBOOK'])) : ?>
                            <div class="table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ประเภท</th>
                                            <th>เลขห้อง</th>
                                            <th>ราคา/คืน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($_SESSION['MYBOOK']['room'] as $keys => $value) { ?>
                                            <tr>
                                                <td><?= $value['type'] ?></td>
                                                <td><?= $keys ?></td>
                                                <td><?= $value['price'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>รวม</th>
                                            <td><?= count($_SESSION['MYBOOK']['room']) . " (ห้อง)" ?></td>
                                            <td><?= number_format($_SESSION['MYBOOK']['cost'],2) . " (บาท)" ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        <?php endif ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
    </main><!-- End #main -->

    <?php require_once('layouts/footer.php'); ?>

    <script src="assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="js_function/book.js"></script>
</body>

</html>