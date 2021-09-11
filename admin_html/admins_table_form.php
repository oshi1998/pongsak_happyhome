<div class="container">
    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-header">
                    แบบฟอร์มเพิ่มข้อมูลผู้ดูแลระบบ
                </div>
                <div class="card-body">
                    <form id="createAdminForm">
                        <input class="form-control" name="action" value="insert" readonly hidden>
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
            <div class="table-responsive">
                <table class="table table-striped text-center dataTable">
                    <thead>
                        <tr>
                            <th>ชื่อผู้ใช้งาน</th>
                            <th>ชื่อจริง-นามสกุล</th>
                            <th>แก้ไข</th>
                            <th>เปลี่ยนรหัสผ่าน</th>
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
                                    <button class="btn btn-primary" onclick="editPasswordAdmin('<?= $row['adm_username'] ?>')">
                                        เปลี่ยนรหัสผ่าน
                                    </button>
                                </td>
                                <td>
                                    <?php if ($_SESSION['USER_USERNAME'] == $row['adm_username']) : ?>
                                        <button class="btn btn-danger" disabled>
                                            ไม่สามารถลบข้อมูลตัวเองได้
                                        </button>
                                    <?php else : ?>
                                        <button class="btn btn-danger" onclick="deleteAdmin('<?= $row['adm_username'] ?>')">
                                            ลบ
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
            <form id="updateAdminForm">
                <div class="modal-body">
                    <input class="form-control" name="action" value="update" readonly hidden>
                    <div class="form-group">
                        <label>ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="adm_username" id="upd_username" readonly>
                    </div>
                    <div class="form-group">
                        <label>ชื่อจริง</label>
                        <input type="text" class="form-control" name="adm_firstname" id="upd_firstname" required>
                    </div>
                    <div class="form-group">
                        <label>นามสกุล</label>
                        <input type="text" class="form-control" name="adm_lastname" id="upd_lastname" required>
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
            <form id="changePassAdminForm">
                <div class="modal-body">
                    <input class="form-control" name="action" value="changePassword" readonly hidden>
                    <div class="form-group">
                        <label>ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="adm_username" id="cp_username" readonly>
                    </div>
                    <div class="form-group">
                        <label>รหัสผ่านเดิม</label>
                        <input type="password" class="form-control" name="old_password" id="old_password" required>
                    </div>
                    <div class="form-group">
                        <label>รหัสผ่านใหม่</label>
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

<script src="js_function/admin_admins.js"></script>