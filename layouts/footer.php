<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6">
                    <div class="footer-info">
                        <h3><?= $web->web_name ?></h3>
                        <p>
                            <?= $web->web_address; ?><br>
                            <strong>เบอร์โทร:</strong><?= $web->web_phone ?><br>
                            <strong>อีเมล:</strong><?= $web->web_email ?><br>
                        </p>
                        <div class="social-links mt-3">
                            <a href="<?= $web->web_twitter ?>" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="<?= $web->web_facebook ?>" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="<?= $web->web_ig ?>" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="<?= $web->web_youtube ?>" class="youtube"><i class="bi bi-youtube"></i></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>เมนู</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#hero">หน้าแรก</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#about">เกี่ยวกับเรา</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#services">บริการที่พัก</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#pricing">ค่าบริการที่พัก</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#contact">ติดต่อเรา</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-newsletter">
                    <h4>ส่งข้อความถึงเรา</h4>
                    <p>หากต้องการส่งข้อความเสนอแนะถึงเรา สามารถส่งได้ที่แบบฟอร์มข้างล่างนี้</p>
                    <form action="javascript:void(0)" method="post">
                        <input type="email" name="email"><input type="submit" value="เสนอแนะ">
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span><?= $web->web_name ?></span></strong>. All Rights Reserved
        </div>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<!-- Happy Home Script -->
<script src="js_function/happy_home.js"></script>