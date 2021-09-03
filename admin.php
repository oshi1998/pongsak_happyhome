<?php
session_start();

if (!isset($_SESSION['USER_LOGIN']) || $_SESSION['USER_ROLE'] != "ADMIN") {
    header('location:index.php');
} else {

    require_once('services/connect.php');

    $sql = "SELECT * FROM admins";
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll();
}
?>
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
                    <li><a class="nav-link scrollto" href="index.php">กลับไปหน้าบ้าน</a></li>
                    <li><a class="nav-link scrollto active" href="admin.php">ข้อมูล Admin</a></li>
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

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="admin.php">หลังบ้าน</a></li>
                    <li>จัดการข้อมูล Admin</li>
                </ol>
                <h2>จัดการข้อมูล Admin</h2>
            </div>
        </section><!-- End Breadcrumbs -->

        <section class="inner-page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-12">
                        <div class="card">
                            <div class="card-header">
                                แบบฟอร์มจัดการข้อมูล Admin
                            </div>
                            <div class="card-body">
                                <form id="manageAdminForm">
                                    <input class="form-control" name="action" id="action" value="insert" readonly hidden>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="adm_username" id="adm_username" placeholder="ชื่อผู้ใช้งาน" required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="adm_password" id="adm_password" placeholder="รหัสผ่าน" required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="adm_firstname" id="adm_firstname" placeholder="ชื่อจริง" required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="adm_lastname" id="adm_lastname" placeholder="นามสกุล" required>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-success w-100">บันทึก</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 col-12">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>ชื่อผู้ใช้งาน</th>
                                    <th>ชื่อจริง-นามสกุล</th>
                                    <th>แก้ไข</th>
                                    <th>ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $row) { ?>
                                    <tr>
                                        <td><?= $row['adm_username'] ?></td>
                                        <td><?= $row['adm_firstname'] . " " . $row['adm_lastname'] ?></td>
                                        <td>
                                            <button class="btn btn-warning" onclick="editAdmin('<?= $row['adm_username'] ?>')">
                                                แก้ไข
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" onclick="deleteAdmin('<?= $row['adm_username'] ?>')">
                                                ลบ
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <?php require_once('layouts/footer.php'); ?>
</body>

</html>