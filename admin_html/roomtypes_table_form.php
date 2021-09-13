<link rel="stylesheet" href="assets/vendor/dropzonejs/dist/min/dropzone.min.css">

<div class="container">
    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-header">
                    แบบฟอร์มเพิ่มข้อมูลประเภทห้องพัก
                </div>
                <div class="card-body">
                    <form id="createRoomTypeForm" enctype="multipart/form-data">
                        <input class="form-control" name="action" value="insert" readonly hidden>
                        <div class="form-group text-center">
                            <img id="previewRtImg" width="150px" height="150px">
                            <br><br>
                            <input type="file" class="form-control" name="rt_image" id="uploadRtImg" accept="image/*" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="text" class="form-control" name="rt_name" placeholder="ชื่อประเภท" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <textarea class="form-control" name="rt_content" placeholder="เนื้อหา" cols="30" rows="10"></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="number" class="form-control" name="rt_price" placeholder="ราคาที่พัก/คืน" required>
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
                            <th>รูปภาพ</th>
                            <th>รหัสประเภท</th>
                            <th>ชื่อประเภท</th>
                            <th>จัดการรูปภาพ</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) { ?>
                            <tr>
                                <td>
                                    <img width="150px" height="150px" src="assets/img/roomtypes/<?= $row['rt_image'] ?>">
                                </td>
                                <td><?= $row['rt_id'] ?></td>
                                <td><?= $row['rt_name'] ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="manageImages('<?= $row['rt_id'] ?>')">
                                        จัดการรูปภาพ
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-warning" onclick="editRoomType('<?= $row['rt_id'] ?>')">
                                        แก้ไข
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-danger" onclick="deleteRoomType('<?= $row['rt_id'] ?>')">
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
            <form id="updateRoomTypeForm">
                <div class="modal-body">
                    <input class="form-control" name="action" value="update" readonly hidden>

                    <div class="form-group text-center">
                        <img id="previewUpdRtImg" width="150px" height="150px">
                        <br><br>
                        <input type="text" name="old_image" id="old_image" readonly hidden>
                        <input type="file" class="form-control" name="rt_image" id="updRtImg" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>รหัสประเภท</label>
                        <input type="text" class="form-control" name="rt_id" id="upd_id" readonly>
                    </div>
                    <div class="form-group">
                        <label>ชื่อประเภท</label>
                        <input type="text" class="form-control" name="rt_name" id="upd_name" required>
                    </div>
                    <div class="form-group">
                        <label>เนื้อหา</label>
                        <textarea class="form-control" name="rt_content" id="upd_content" cols="30" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>ราคาที่พัก/คืน</label>
                        <input type="number" class="form-control" name="rt_price" id="upd_price" required>
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

<div class="modal fade" id="manageImageModal" tabindex="-1" aria-labelledby="manageImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageImageModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>อัพโหลดรูปภาพ ใหม่ๆ เพิ่ม ตรงนี้</h3>
                <form action="services/uploadImage_roomtype.php" class="dropzone" id="my-awesome-dropzone"></form>
                <br>
                <hr>
                <h3>รูปภาพทั้งหมด (หลังอัพโหลดเสร็จ กรุณารีเฟรช)</h3>
                <div class="row" id="uploadedImg">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/vendor/dropzonejs/dist/min/dropzone.min.js"></script>
<script src="js_function/admin_roomtypes.js"></script>