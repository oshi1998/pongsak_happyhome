<style>
    #hero {
        width: 100%;
        height: calc(100vh - 110px);
        background: url("assets/img/<?= $welcome->welcome_img ?>") top center;
        background-size: cover;
        position: relative;
    }

    #hero h1 input[type="text"]{
        margin: 0 0 10px 0;
        font-size: 48px;
        font-weight: 700;
        line-height: 56px;
        text-transform: uppercase;
        color: #fff;
        background: transparent;
        border: none;
        outline: none;
        width: 100%;
    }

    #hero h2 textarea{
        color: #eee;
        margin-bottom: 30px;
        font-size: 24px;
        background: transparent;
        border: none;
        outline: none;
        width: 100%;
    }
</style>


<div class="container">

    <form id="updateWelcomeMsgForm" enctype="multipart/form-data">
        <!-- ======= Hero Section ======= -->
        <section id="hero" class="d-flex align-items-center">
            <div class="container position-relative" data-aos="fade-up" data-aos-delay="500">
                <h1>
                    <input type="text" name="welcome_head" rows="1" placeholder="แก้ไขหัวข้อ" value="<?= $welcome->welcome_head ?>">
                </h1>
                <h2>
                    <textarea name="welcome_desc" placeholder="แก้ไขคำอธิบาย"><?= $welcome->welcome_desc ?></textarea>
                </h2>
            </div>
        </section><!-- End Hero -->

        <br><br>
        <div class="form-group">
            <h1>เปลี่ยนรูปภาพ</h1>
            <input type="text" name="old_image" value="<?= $welcome->welcome_img ?>" hidden readonly>
            <input type="file" class="form-control" accept="image/*" name="welcome_img">
        </div>

        <button type="submit" class="btn btn-success w-100">บันทึก</button>
    </form>
</div>

<script src="js_function/admin_welcome_msg.js"></script>