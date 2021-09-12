<div class="container">
    <form id="updateAboutUsForm" enctype="multipart/form-data">

        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <textarea id="editor"><?= $aboutus->aboutus_content ?></textarea>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <h3>อัพโหลดรูปภาพเกี่ยวกับเรา</h3>
                    <img id="previewImage" class="img-responsive" src="assets/img/<?= $aboutus->aboutus_image ?>">
                    <input type="file" class="form-control" name="image" id="uploadAboutImg">
                    <input type="text" name="old_image" value="<?= $aboutus->aboutus_image ?>" hidden readonly>
                </div>
            </div>
        </div>

        <br><br>
        <button type="submit" class="btn btn-success w-100">บันทึก</button>

    </form>

</div>

<script src="assets/vendor/ckeditor/ckeditor.js"></script>
<script src="js_function/admin_aboutus.js"></script>