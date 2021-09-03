<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">เข้าสู่ระบบเพื่อใช้งาน Pongsak Happy Home</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="loginForm">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="username">ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">รหัสผ่าน</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                </div>
                <div class="modal-footer">
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
                <h5 class="modal-title" id="registerModalLabel">ลงทะเบียนใช้งาน Pongsak Happy Home</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="registerForm">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="mem_username">ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="mem_username" required>
                    </div>

                    <div class="form-group">
                        <label for="mem_password">รหัสผ่าน</label>
                        <input type="password" class="form-control" name="mem_password" required>
                    </div>

                    <div class="form-group">
                        <label for="mem_firstname">ชื่อจริง</label>
                        <input type="text" class="form-control" name="mem_firstname" required>
                    </div>

                    <div class="form-group">
                        <label for="mem_lastname">นามสกุล</label>
                        <input type="text" class="form-control" name="mem_lastname" required>
                    </div>

                    <div class="form-group">
                        <label for="mem_email">อีเมล</label>
                        <input type="email" class="form-control" name="mem_email" required>
                    </div>

                    <div class="form-group">
                        <label for="mem_address">ที่อยู่</label>
                        <textarea class="form-control" name="mem_address" cols="30" rows="3s"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="mem_phone">เบอร์โทร</label>
                        <input type="text" class="form-control" name="mem_phone" pattern="\d*" minlength="10" maxlength="10" required>
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
            <form id="updateAccountForm">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="mem_username">ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="mem_username" id="acc_username" readonly>
                    </div>

                    <div class="form-group">
                        <label for="mem_firstname">ชื่อจริง</label>
                        <input type="text" class="form-control" name="mem_firstname" id="acc_firstname" required>
                    </div>

                    <div class="form-group">
                        <label for="mem_lastname">นามสกุล</label>
                        <input type="text" class="form-control" name="mem_lastname" id="acc_lastname" required>
                    </div>

                    <div class="form-group">
                        <label for="mem_email">อีเมล</label>
                        <input type="email" class="form-control" name="mem_email" id="acc_email" required>
                    </div>

                    <div class="form-group">
                        <label for="mem_address">ที่อยู่</label>
                        <textarea class="form-control" name="mem_address" id="acc_address" cols="30" rows="3s"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="mem_phone">เบอร์โทร</label>
                        <input type="text" class="form-control" name="mem_phone" id="acc_phone" pattern="\d*" minlength="10" maxlength="10" required>
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

<!-- Close Account Modal -->
<div class="modal fade" id="closeAccountModal" tabindex="-1" aria-labelledby="closeAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="closeAccountModalLabel">ลบบัญชีผู้ใช้งาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="closeAccountForm">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="mem_username">ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="mem_username" id="close_username" readonly>
                    </div>

                    <div class="form-group">
                        <label for="mem_password">รหัสผ่านของคุณ</label>
                        <input type="password" class="form-control" name="mem_password" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-danger">ปิดบัญชี</button>
                </div>
            </form>
        </div>
    </div>
</div>