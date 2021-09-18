<div class="container">
    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-header">
                    แบบฟอร์มเพิ่มบัญชีธนาคาร
                </div>
                <div class="card-body">
                    <form id="createBankForm" enctype="multipart/form-data">
                        <input class="form-control" name="action" value="insert" readonly hidden>
                        <div class="form-group text-center">
                            <img id="previewBankImg" width="150px" height="150px">
                            <br><br>
                            <input type="file" class="form-control" name="bank_img" id="uploadBankImg" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="bank_name">ชื่อธนาคาร</label>
                            <input type="text" class="form-control" name="bank_name" required>
                        </div>
                        <div class="form-group">
                            <label for="bank_id">เลขบัญชี (ไม่ต้องมีขีด -)</label>
                            <input type="text" class="form-control" name="bank_id" maxlength="12" required>
                        </div>
                        <div class="form-group">
                            <label for="bank_owner">เจ้าของบัญชี</label>
                            <input type="text" class="form-control" name="bank_owner" required>
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
                            <th>ภาพ</th>
                            <th>ชื่อธนาคาร</th>
                            <th>เลขบัญชี</th>
                            <th>เจ้าของบัญชี</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) { ?>
                            <tr>
                                <td>
                                    <img width="100%" height="100px" src="assets/img/banks/<?= $row['bank_img'] ?>">
                                </td>
                                <td><?= $row['bank_name'] ?></td>
                                <td><?= $row['bank_id'] ?></td>
                                <td><?= $row['bank_owner'] ?></td>
                                <td>
                                    <button class="btn btn-warning" onclick="editBank('<?= $row['bank_id'] ?>')">
                                        แก้ไข
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-danger" onclick="deleteBank('<?= $row['bank_id'] ?>')">
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
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateBankForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input class="form-control" name="action" value="update" readonly hidden>
                    <div class="form-group text-center">
                        <img id="previewUpdBankImg" width="150px" height="150px">
                        <br><br>
                        <input type="text" name="old_image" id="old_image" readonly hidden>
                        <input type="file" class="form-control" name="bank_img" id="updBankImg" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="bank_name">ชื่อธนาคาร</label>
                        <input type="text" class="form-control" name="bank_name" id="upd_name" required>
                    </div>
                    <div class="form-group">
                        <label for="bank_id">เลขบัญชี</label>
                        <input type="text" name="old_id" id="old_id" readonly hidden>
                        <input type="text" class="form-control" name="bank_id" id="upd_id" maxlength="12" required>
                    </div>
                    <div class="form-group">
                        <label for="bank_owner">เจ้าของบัญชี</label>
                        <input type="text" class="form-control" name="bank_owner" id="upd_owner" required>
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

<script src="js_function/admin_bank.js"></script>