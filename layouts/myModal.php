<style>
    .field-icon {
        float: right;
        margin-left: -25px;
        margin-top: -25px;
        margin-right: 10px;
        position: relative;
        z-index: 2;
    }
</style>


<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">เข้าสู่ระบบเพื่อใช้งาน <?= $web->web_name ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="loginForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">ชื่อผู้ใช้งาน</label> <div id="login-usr-alert"></div>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">รหัสผ่าน</label> <div id="login-pass-alert"></div>
                        <input type="password" class="form-control" name="password" id="password-field1">
                        <span toggle="#password-field1" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0)" onclick="forgotPassword()">ลืมรหัสผ่าน ?</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success">เข้าสู่ระบบ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">ลงทะเบียนใช้งาน <?= $web->web_name ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="registerForm">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="cus_username">ชื่อผู้ใช้งาน</label> <div id="rg-usr-alert"></div>
                        <input type="text" class="form-control" name="cus_username">
                    </div>

                    <div class="form-group">
                        <label for="cus_password">รหัสผ่าน</label> <div id="rg-pass-alert"></div>
                        <input type="password" class="form-control" name="cus_password" id="password-field2">
                        <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                    <div class="form-group">
                        <label for="cus_firstname">ชื่อจริง</label> <div id="rg-fname-alert"></div>
                        <input type="text" class="form-control" name="cus_firstname">
                    </div>

                    <div class="form-group">
                        <label for="cus_lastname">นามสกุล</label> <div id="rg-lname-alert"></div>
                        <input type="text" class="form-control" name="cus_lastname" >
                    </div>

                    <div class="form-group">
                        <label for="cus_gender">เพศ</label> <div id="rg-gender-alert"></div>
                        <select class="form-control" name="cus_gender" >
                            <option value="" disabled selected>---- เลือกเพศ ----</option>
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cus_email">อีเมล</label> <div id="rg-email-alert"></div>
                        <input type="email" class="form-control" name="cus_email" >
                    </div>

                    <div class="form-group">
                        <label for="cus_address">ที่อยู่</label> <div id="rg-add-alert"></div>
                        <textarea class="form-control" name="cus_address" cols="30" rows="3s"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="cus_phone">เบอร์โทร</label> <div id="rg-phone-alert"></div>
                        <input type="text" class="form-control" name="cus_phone" pattern="\d*" minlength="10" maxlength="10">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success">ลงทะเบียน</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- My Account Modal -->
<div class="modal fade" id="myAccountModal" tabindex="-1" aria-labelledby="myAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myAccountModalLabel">ตั้งค่าบัญชีผู้ใช้งาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateAccountForm" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="form-group text-center">
                        <img id="previewImg" class="rounded-circle" width="100px" height="100px" src="assets/img/customers/<?= $_SESSION['USER_PROFILE'] ?>">
                        <br><br>
                        <input type="file" class="form-control" name="cus_profile" id="uploadImg" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="cus_username">ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="cus_username" id="acc_username" readonly>
                    </div>

                    <div class="form-group">
                        <label for="cus_firstname">ชื่อจริง</label>
                        <input type="text" class="form-control" name="cus_firstname" id="acc_firstname" required>
                    </div>

                    <div class="form-group">
                        <label for="cus_lastname">นามสกุล</label>
                        <input type="text" class="form-control" name="cus_lastname" id="acc_lastname" required>
                    </div>

                    <div class="form-group">
                        <label for="cus_gender">เพศ</label>
                        <select class="form-control" name="cus_gender" id="acc_gender">
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cus_email">อีเมล</label>
                        <input type="email" class="form-control" name="cus_email" id="acc_email" required>
                    </div>

                    <div class="form-group">
                        <label for="acc_address">ที่อยู่</label>
                        <textarea class="form-control" name="cus_address" id="acc_address" cols="30" rows="3s"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="cus_phone">เบอร์โทร</label>
                        <input type="text" class="form-control" name="cus_phone" id="acc_phone" pattern="\d*" minlength="10" maxlength="10" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success">อัพเดต</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">เปลี่ยนรหัสผ่าน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changePassForm">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="cus_username">ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="cus_username" id="ccp_username" readonly>
                    </div>

                    <div class="form-group">
                        <label for="cus_password">รหัสผ่านเดิมของคุณ</label>
                        <input type="password" class="form-control" name="old_password" id="password-field3" required>
                        <span toggle="#password-field3" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                    <div class="form-group">
                        <label for="cus_password">รหัสผ่านใหม่</label>
                        <input type="password" class="form-control" name="new_password" id="password-field4" required>
                        <span toggle="#password-field4" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-danger">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPassModal" tabindex="-1" aria-labelledby="forgotPassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPassModalLabel">ลืมรหัสผ่าน (ต้องยืนยันตัวตนก่อนเปลี่ยนรหัสผ่าน)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="resetCusPassForm">
                <div class="modal-body">
                    <button type="button" class="btn btn-warning btn-sm" onclick="checkCusUsername()">ยืนยันตัวตน</button>
                    <br>

                    <input type="text" name="action" value="reset_password" readonly hidden>

                    <div class="form-group">
                        <label for="cus_username">ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="cus_username" id="c_cus_username" required>
                    </div>

                    <div class="form-group">
                        <label>ชื่อจริง</label>
                        <input type="text" class="form-control" name="cus_firstname" id="c_cus_firstname" required>
                    </div>

                    <div class="form-group">
                        <label>นามสกุล</label>
                        <input type="text" class="form-control" name="cus_lastname" id="c_cus_lastname" required>
                    </div>

                    <div class="form-group">
                        <label for="cus_password">ตั้งรหัสผ่านใหม่ของคุณ</label>
                        <input type="password" class="form-control" name="new_password" id="c_cus_password" id="password-field5" disabled required>
                        <span toggle="#password-field5" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-danger" id="btn_submit_forgot_pass_form" disabled>บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>