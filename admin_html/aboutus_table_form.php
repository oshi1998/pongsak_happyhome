<div class="container">

    <form id="updateAboutUsForm" enctype="multipart/form-data">
        <div class="form-group">
            <textarea id="editor"><?= $aboutus->aboutus_content ?></textarea>
        </div>

        <button type="submit" class="btn btn-success w-100">บันทึก</button>
    </form>
    
</div>

<script src="assets/vendor/ckeditor/ckeditor.js"></script>
<script src="js_function/admin_aboutus.js"></script>