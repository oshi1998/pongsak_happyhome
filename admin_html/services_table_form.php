<div class="container">

    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-header">
                    แบบฟอร์มเพิ่มข้อมูลบริการ
                </div>
                <div class="card-body">
                    <form id="createServiceForm">
                        <input class="form-control" name="action" value="insert" readonly hidden>
                        <div class="form-group">
                            <a href="https://boxicons.com/" target="_blank">เลือก Font Box Icon จากผู้ให้บริการ และ Copy Font มาวาง</a>
                            <br>
                            <input type="text" class="form-control" name="sv_icon" placeholder="โค้ด Box Icon" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="text" class="form-control" name="sv_heading" maxlength="100" placeholder="หัวข้อบริการ ไม่เกิน 100 ตัวอักษร" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <textarea class="form-control" name="sv_desc" maxlength="100" placeholder="คำอธิบายบริการ ไม่เกิน 100 ตัวอักษร" required></textarea>
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
                            <th>เปลี่ยนลำดับการแสดงผล</th>
                            <th>ไอคอน</th>
                            <th>หัวข้อ</th>
                            <th>คำอธิบาย</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) { ?>
                            <tr>
                                <td>
                                    <select class="form-control" onchange="changeNo('<?= $row['sv_id'] ?>','<?= $row['sv_no'] ?>',event.target.value)">
                                        <option value="<?= $row['sv_no'] ?>"><?= $row['sv_no'] ?></option>
                                        <?php
                                        $sql = "SELECT sv_no FROM services WHERE sv_no != '$row[sv_no]' ORDER BY sv_no ASC";
                                        $stmt = $pdo->query($sql);
                                        $sv_no_list = $stmt->fetchAll();

                                        foreach ($sv_no_list as $item) {
                                        ?>
                                            <option value="<?= $item['sv_no'] ?>"><?= $item['sv_no'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td><?= $row['sv_icon'] ?></td>
                                <td><?= $row['sv_heading'] ?></td>
                                <td><?= $row['sv_desc'] ?></td>
                                <td>
                                    <button class="btn btn-warning" onclick="editService('<?= $row['sv_id'] ?>')">
                                        แก้ไข
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-danger" onclick="deleteService('<?= $row['sv_id'] ?>')">
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
            <form id="updateServiceForm">
                <div class="modal-body">
                    <input class="form-control" name="action" value="update" readonly hidden>
                    <div class="form-group">
                        <label>รหัสบริการ</label>
                        <input type="text" class="form-control" name="sv_id" id="upd_id" readonly>
                    </div>
                    <div class="form-group">
                        <label>ไอคอน</label>
                        <a href="https://boxicons.com/" target="_blank">เลือก Font Box Icon จากผู้ให้บริการ และ Copy Font มาวาง</a>
                        <input type="text" class="form-control" name="sv_icon" id="upd_icon" required>
                    </div>
                    <div class="form-group">
                        <label>หัวข้อบริการ</label>
                        <input type="text" class="form-control" name="sv_heading" id="upd_heading" required>
                    </div>
                    <div class="form-group">
                        <label>คำอธิบายบริการ</label>
                        <input type="text" class="form-control" name="sv_desc" id="upd_desc" required>
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


<script src="js_function/admin_services.js"></script>