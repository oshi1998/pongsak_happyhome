<div class="container">
    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-header">
                    แบบฟอร์มเพิ่มข้อมูลห้องพัก
                </div>
                <div class="card-body">
                    <form id="createRoomForm" enctype="multipart/form-data">
                        <input class="form-control" name="action" value="insert" readonly hidden>
                        <div class="form-group">
                            <input type="text" class="form-control" name="r_id" maxlength="10" placeholder="หมายเลขห้อง" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <select class="form-control" name="rt_id" required>
                                <option value="" disabled selected>---- เลือกประเภทห้องพัก ----</option>
                                <?php foreach ($data as $row) { ?>
                                    <option value="<?= $row['rt_id'] ?>"><?= $row['rt_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success w-100">บันทึก</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-12">

            <?php $i = 0; ?>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <?php foreach ($data as $row) { ?>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link <?= ($i == 0) ? 'active' : '' ?>" id="<?= $row['rt_name'] . "-tab" ?>" data-bs-toggle="tab" href="<?= "#" . $row['rt_name'] ?>" role="tab" aria-controls="<?= $row['rt_name'] ?>" aria-selected="<?= ($i == 0) ? 'true' : 'false' ?>"><?= $row['rt_name'] ?></a>
                    </li>
                <?php $i++;
                } ?>
            </ul>


            <?php $i = 0; ?>

            <div class="tab-content" id="myTabContent">
                <?php foreach ($data as $row) { ?>

                    <?php

                    $sql = "SELECT * FROM rooms,roomtypes WHERE rooms.rt_id=roomtypes.rt_id AND roomtypes.rt_id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$row['rt_id']]);
                    $rooms = $stmt->fetchAll();
                    ?>

                    <div class="tab-pane fade <?= ($i == 0) ? 'show active' : '' ?>" id="<?= $row['rt_name'] ?>" role="tabpanel" aria-labelledby="<?= $row['rt_name'] . "-tab" ?>">
                        <br><br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center dataTable">
                                <thead>
                                    <tr>
                                        <th>หมายเลขห้อง</th>
                                        <th>ประเภทห้อง</th>
                                        <th>แก้ไข</th>
                                        <th>ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rooms as $room) { ?>
                                        <tr>
                                            <td><?= $room['r_id'] ?></td>
                                            <td><?= $room['rt_name'] ?></td>
                                            <td>
                                                <button class="btn btn-warning" onclick="editRoom('<?= $room['r_id'] ?>')">
                                                    แก้ไข
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger" onclick="deleteRoom('<?= $room['r_id'] ?>')">
                                                    ลบ
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php $i++;
                } ?>
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
            <form id="updateRoomForm">
                <div class="modal-body">
                    <input class="form-control" name="action" value="update" readonly hidden>

                    <div class="form-group">
                        <label>หมายเลขห้อง</label>
                        <input type="text" class="form-control" name="r_id" id="upd_id" readonly>
                    </div>
                    <div class="form-group">
                        <label>ประเภทห้อง</label>
                        <select class="form-control" name="rt_id" id="upd_rt_id">
                            <?php foreach ($data as $row) { ?>
                                <option value="<?= $row['rt_id'] ?>"><?= $row['rt_name'] ?></option>
                            <?php } ?>
                        </select>
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

<script src="js_function/admin_rooms.js"></script>