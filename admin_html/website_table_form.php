<div class="container">
    <form id="updateWebsiteForm">

        <div class="row">
            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-header">
                        ข้อมูลเกี่ยวกับเว็บไซต์
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>ชื่อเว็บไซต์</label>
                            <input type="text" class="form-control" value="<?= $web->web_name ?>" name="web_name" required>
                        </div>
                        <div class="form-group">
                            <label>คำอธิบายเว็บไซต์</label>
                            <textarea class="form-control" name="web_description" required><?= $web->web_description ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>คำค้นหาเว็บไซต์</label>
                            <textarea class="form-control" name="web_keywords" required><?= $web->web_keywords ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-header">
                        ข้อมูลติดต่อ
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>ที่อยู่</label>
                            <input type="text" class="form-control" value="<?= $web->web_address ?>" name="web_address" required>
                        </div>
                        <div class="form-group">
                            <label>เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" value="<?= $web->web_phone ?>" minlength="10" maxlength="10" name="web_phone" required>
                        </div>
                        <div class="form-group">
                            <label>อีเมล</label>
                            <input type="email" class="form-control" value="<?= $web->web_email ?>" name="web_email" required>
                        </div>
                        <div class="form-group">
                            <label>แผนที่ Google Map</label>
                            <textarea class="form-control" name="web_google_map" required><?= $web->web_google_map ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-header">
                        โซเชียลมีเดีย
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Facebook</label>
                            <input type="text" class="form-control" value="<?= $web->web_facebook ?>" name="web_facebook">
                        </div>
                        <div class="form-group">
                            <label>Instagram</label>
                            <input type="text" class="form-control" value="<?= $web->web_ig ?>" name="web_ig">
                        </div>
                        <div class="form-group">
                            <label>Twitter</label>
                            <input type="text" class="form-control" value="<?= $web->web_twitter ?>" name="web_twitter">
                        </div>
                        <div class="form-group">
                            <label>Youtube</label>
                            <input type="text" class="form-control" value="<?= $web->web_youtube ?>" name="web_youtube">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success w-100">บันทึก</button>
            </div>
        </div>

    </form>
</div>

<script src="js_function/admin_website.js"></script>