<?php

session_start();

if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_ROLE'] == "CUSTOMER") {
    require_once('services/connect.php');

    $sql = "SELECT * FROM website";
    $stmt = $pdo->query($sql);
    $web = $stmt->fetch(PDO::FETCH_OBJ);

    $sql = "SELECT * FROM customers WHERE cus_username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['USER_USERNAME']]);
    $info = $stmt->fetch(PDO::FETCH_OBJ);

    $sql = "SELECT * FROM book WHERE b_cus_username = ? ORDER BY b_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['USER_USERNAME']]);
    $books = $stmt->fetchAll();

    $sql = "SELECT * FROM banks ORDER BY bank_created DESC";
    $stmt = $pdo->query($sql);
    $banks = $stmt->fetchAll();
} else {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>รายการจองของฉัน | <?= $web->web_name ?></title>
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
                    <li><a href="index.php" class="nav-link">กลับไปหน้าแรก</a></li>
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
                    <li>รายการจองของฉัน</li>
                </ol>
                <h2>รายการจองของฉัน</h2>
            </div>
        </section><!-- End Breadcrumbs -->

        <section class="inner-page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-12" data-aos="fade-right">
                        <div class="card">
                            <div class="card-header">
                                ข้อมูลผู้ใช้งาน
                            </div>
                            <div class="card-body">

                                <div class="text-center">
                                    <img class="rounded-circle" width="100px" height="100px" src="assets/img/customers/<?= $_SESSION['USER_PROFILE'] ?>">
                                </div>

                                <br>
                                <table class="table table-bordered text-center">
                                    <tr>
                                        <td><i class="bx bx-user"></i></td>
                                        <td><?= $_SESSION['USER_NAME'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="<?= ($info->cus_gender == 'ชาย') ? 'bx bx-male-sign' : 'bx bx-female-sign' ?>"></i></td>
                                        <td><?= $info->cus_gender ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="bi bi-envelope-fill"></i></td>
                                        <td><?= $info->cus_email ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="bx bx-map"></i></td>
                                        <td><?= $info->cus_address ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="bx bx-phone"></i></td>
                                        <td><?= $info->cus_phone ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-12" data-aos="fade-left">
                        <div class="table-responsive">
                            <table class="table table-striped text-center dataTable">
                                <thead>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>หมายเลขจอง</th>
                                        <th>เช็คอิน-เช็คเอาท์</th>
                                        <th>หมายเหตุ</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($books as $book) { ?>
                                        <tr>
                                            <td><?= $book['b_date'] ?></td>
                                            <td>
                                                <button class="btn btn-outline-danger" onclick="viewBookDetail('<?= $book['b_id'] ?>')">
                                                    <?= $book['b_id'] ?>
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                            </td>
                                            <td><?= $book['b_daterange'] ?></td>
                                            <td><?= $book['b_note'] ?></td>
                                            <td>
                                                <?php if ($book['b_status'] == 'รอตรวจสอบ') : ?>
                                                    <span class="badge bg-warning text-dark"><?= $book['b_status'] ?></span>
                                                <?php elseif ($book['b_status'] == 'รอชำระค่ามัดจำ') : ?>
                                                    <button class="btn btn-outline-success" onclick="deposit('<?= $book['b_id'] ?>','<?= $book['b_cost'] ?>')">ชำระค่ามัดจำ คลิก!</button>
                                                <?php elseif ($book['b_status'] == 'รอตรวจสอบการชำระค่ามัดจำ') : ?>
                                                    <span class="badge bg-warning text-dark"><?= $book['b_status'] ?></span>
                                                <?php elseif ($book['b_status'] == 'รอเช็คอิน') : ?>
                                                    <span class="badge bg-warning text-dark"><?= $book['b_status'] ?></span>
                                                <?php elseif ($book['b_status'] == 'อยู่ระหว่างการเช็คอิน') : ?>
                                                    <span class="badge bg-success"><?= $book['b_status'] ?></span>
                                                <?php elseif ($book['b_status'] == 'เช็คเอาท์เรียบร้อย') : ?>
                                                    <span class="badge bg-success"><?= $book['b_status'] ?></span>
                                                <?php elseif ($book['b_status'] == 'ไม่อนุมัติ') : ?>
                                                    <span class="badge bg-danger"><?= $book['b_status'] ?></span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Book Detail Modal -->
        <div class="modal fade" id="bookDetailModal" tabindex="-1" aria-labelledby="bookDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookDetailModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body" id="showBookDetail">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deposit Modal -->
        <div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="depositModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="depositForm" enctype="multipart/form-data">

                        <div class="modal-body">

                            <div class="card">
                                <div class="card-header">
                                    กรุณาเลือกธนาคาร
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th>ภาพ</th>
                                                    <th>ธนาคาร</th>
                                                    <th>เลือก</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($banks as $bank) { ?>
                                                    <tr>
                                                        <td>
                                                            <img width="200px" height="200px" src="assets/img/banks/<?= $bank['bank_img'] ?>">
                                                        </td>
                                                        <td><?= $bank['bank_name'] ?></td>
                                                        <td>
                                                            <input class="form-check-input" type="radio" name="bankRadio" onclick="checkRadioBank('<?= $bank['bank_id'] ?>')">
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>หมายเลขจอง</label>
                                <input type="text" class="form-control" name="b_id" id="dep_b_id" readonly>
                            </div>

                            <div class="form-group">
                                <label>ธนาคาร</label>
                                <input type="text" class="form-control" name="bank_name" id="dep_bank_name" readonly>
                            </div>

                            <div class="form-group">
                                <label>เลขบัญชี</label>
                                <input type="text" class="form-control" name="bank_id" id="dep_bank_id" readonly>
                            </div>

                            <div class="form-group">
                                <label>สาขา</label>
                                <input type="text" class="form-control" name="bank_branch" id="dep_bank_branch" readonly>
                            </div>

                            <div class="form-group">
                                <label>เจ้าของบัญชี</label>
                                <input type="text" class="form-control" name="bank_owner" id="dep_bank_owner" readonly>
                            </div>

                            <div class="form-group">
                                <label id="deposit_cost_label"></label>
                                <input type="text" class="form-control" id="deposit_cost" readonly>
                            </div>

                            <div class="form-group">
                                <label>วันเวลาที่โอน</label>
                                <input type="datetime-local" class="form-control" name="deposit_datetime" required>
                            </div>

                            <div class="form-group">
                                <label>แนบสลิปโอนเงิน</label>
                                <input type="file" class="form-control" name="deposit_slip" accept="image/*" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">แจ้งชำระค่ามัดจำ</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </main><!-- End #main -->

    <?php require_once('layouts/footer.php'); ?>

    <script src="js_function/mybooking.js"></script>
</body>

</html>