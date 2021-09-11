<div class="container">
    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-header">
                    แบบฟอร์มเพิ่มข้อมูลลูกค้า
                </div>
                <div class="card-body">
                    <form id="createCustomerForm">
                        <input class="form-control" name="action" value="insert" readonly hidden>
                        <div class="form-group">
                            <label for="cus_username">ชื่อผู้ใช้งาน</label>
                            <input type="text" class="form-control" name="cus_username" required>
                        </div>

                        <div class="form-group">
                            <label for="cus_password">รหัสผ่าน</label>
                            <input type="password" class="form-control" name="cus_password" required>
                        </div>

                        <div class="form-group">
                            <label for="cus_firstname">ชื่อจริง</label>
                            <input type="text" class="form-control" name="cus_firstname" required>
                        </div>

                        <div class="form-group">
                            <label for="cus_lastname">นามสกุล</label>
                            <input type="text" class="form-control" name="cus_lastname" required>
                        </div>

                        <div class="form-group">
                            <label for="cus_gender">เพศ</label>
                            <select class="form-control" name="cus_gender" required>
                                <option value="" disabled selected>---- เลือกเพศ ----</option>
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cus_email">อีเมล</label>
                            <input type="email" class="form-control" name="cus_email" required>
                        </div>

                        <div class="form-group">
                            <label for="cus_address">ที่อยู่</label>
                            <textarea class="form-control" name="cus_address" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="cus_phone">เบอร์โทร</label>
                            <input type="text" class="form-control" name="cus_phone" pattern="\d*" minlength="10" maxlength="10" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success w-100">บันทึก</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-12">
            <div class="table-responsive">
                <table class="table table-striped text-center dataTable">
                    <thead>
                        <tr>
                            <th>ภาพโปรไฟล์</th>
                            <th>ชื่อผู้ใช้งาน</th>
                            <th>ชื่อจริง-นามสกุล</th>
                            <th>แก้ไข</th>
                            <th>เปลี่ยนรหัสผ่าน</th>
                            <th>สถานะใช้งาน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) { ?>
                            <tr>
                                <td>
                                    <img class="rounded-circle" width="50px" height="50px" src="assets/img/customers/<?= $row['cus_profile'] ?>">
                                </td>
                                <td><?= $row['cus_username'] ?></td>
                                <td><?= $row['cus_firstname'] . " " . $row['cus_lastname'] ?></td>
                                <td>
                                    <button class="btn btn-warning" onclick="editCus('<?= $row['cus_username'] ?>')">
                                        แก้ไข
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-primary" onclick="editPasswordCustomer('<?= $row['cus_username'] ?>')">
                                        เปลี่ยนรหัสผ่าน
                                    </button>
                                </td>
                                <td>
                                    <?php if ($row['cus_active'] == 'Enable') : ?>
                                        <button class="btn btn-danger" onclick="disableCus('<?= $row['cus_username'] ?>')">
                                            ปิดใช้งาน
                                        </button>
                                    <?php else : ?>
                                        <button class="btn btn-success" onclick="enableCus('<?= $row['cus_username'] ?>')">
                                            เปิดใช้งาน
                                        </button>
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

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateCustomerForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input class="form-control" name="action" value="update" readonly hidden>

                    <div class="form-group text-center">
                        <input type="text" class="form-control" name="old_profile" id="old_profile" readonly hidden>
                        <img id="previewCusProfile" class="rounded-circle" width="100px" height="100px">
                        <br><br>
                        <input type="file" class="form-control" name="cus_profile" id="uploadCusProfile" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="cus_username">ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="cus_username" id="upd_username" readonly>
                    </div>

                    <div class="form-group">
                        <label for="cus_firstname">ชื่อจริง</label>
                        <input type="text" class="form-control" name="cus_firstname" id="upd_firstname" required>
                    </div>

                    <div class="form-group">
                        <label for="cus_lastname">นามสกุล</label>
                        <input type="text" class="form-control" name="cus_lastname" id="upd_lastname" required>
                    </div>

                    <div class="form-group">
                        <label for="cus_gender">เพศ</label>
                        <select class="form-control" name="cus_gender" id="upd_gender">
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cus_email">อีเมล</label>
                        <input type="email" class="form-control" name="cus_email" id="upd_email" required>
                    </div>

                    <div class="form-group">
                        <label for="cus_address">ที่อยู่</label>
                        <textarea class="form-control" name="cus_address" id="upd_address" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="cus_phone">เบอร์โทร</label>
                        <input type="text" class="form-control" name="cus_phone" id="upd_phone" pattern="\d*" minlength="10" maxlength="10" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="changePassModal" tabindex="-1" aria-labelledby="changePassLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePassLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changePassCustomerForm">
                <div class="modal-body">
                    <input class="form-control" name="action" value="changePassword" readonly hidden>
                    <div class="form-group">
                        <label>ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="cus_username" id="cp_username" readonly>
                    </div>
                    <div class="form-group">
                        <label>รหัสผ่านของคุณ</label>
                        <input type="password" class="form-control" name="adm_password" required>
                    </div>
                    <div class="form-group">
                        <label>รหัสผ่านใหม่ของลูกค้า</label>
                        <input type="password" class="form-control" name="new_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="activeModal" tabindex="-1" aria-labelledby="activeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activeModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="activeCustomerForm">
                <div class="modal-body">
                    <input class="form-control" name="action" id="active_action" readonly hidden>
                    <div class="form-group">
                        <label>ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="cus_username" id="active_username" readonly>
                    </div>
                    <div class="form-group">
                        <label>รหัสผ่านของคุณ</label>
                        <input type="password" class="form-control" name="adm_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="js_function/admin_customers.js"></script>