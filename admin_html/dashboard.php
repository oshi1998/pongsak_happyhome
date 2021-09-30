<div class="container">

    <div class="row services">
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="icon-box w-100">
                <div class="icon"><i class="bi bi-person"></i></div>
                <h4><a href="javascript:void(0)">จำนวนสถานะที่รอตรวจสอบ</a></h4>
                <h1><?= $stats->num_status1 ?></h1>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="icon-box w-100">
                <div class="icon"><i class="bi bi-person-badge"></i></div>
                <h4><a href="javascript:void(0)">จำนวนสถานะที่รออนุมัติ</a></h4>
                <h1><?= $stats->num_status3 ?></h1>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="icon-box w-100">
                <div class="icon"><i class="bx bx-money"></i></div>
                <h4><a href="javascript:void(0)">จำนวนห้องพักที่ว่าง (วันนี้)</a></h4>
                <h1><?= $stats->num_free_room ?></h1>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <h1>ข้อมูลการจอง</h1>
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="status1-tab" data-bs-toggle="tab" href="#status1" role="tab" aria-controls="status1" aria-selected="true">
                        <span class="badge bg-light text-dark position-relative">
                            รอตรวจสอบ
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                <?= count($books_status1) ?>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="status2-tab" data-bs-toggle="tab" href="#status2" role="tab" aria-controls="status2" aria-selected="false">
                        <span class="badge bg-light text-dark position-relative">
                            รอชำระค่ามัดจำ
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                <?= count($books_status2) ?>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="status3-tab" data-bs-toggle="tab" href="#status3" role="tab" aria-controls="status3" aria-selected="false">
                        <span class="badge bg-light text-dark position-relative">
                            รอตรวจสอบการชำระค่ามัดจำ
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                <?= count($books_status3) ?>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="status4-tab" data-bs-toggle="tab" href="#status4" role="tab" aria-controls="status4" aria-selected="false">
                        <span class="badge bg-light text-dark position-relative">
                            สำเร็จ
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">
                                <?= count($books_status4) ?>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="status5-tab" data-bs-toggle="tab" href="#status5" role="tab" aria-controls="status5" aria-selected="false">
                        <span class="badge bg-light text-dark position-relative">
                            ไม่อนุมัติ
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= count($books_status5) ?>
                            </span>
                        </span>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="status1" role="tabpanel" aria-labelledby="status1-tab">
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-striped text-center dataTable">
                            <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>หมายเลขจอง</th>
                                    <th>ลูกค้า</th>
                                    <th>เช็คอิน-เช็คเอาท์</th>
                                    <th>เลือกห้องพัก</th>
                                    <th>ไม่อนุมัติ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books_status1 as $book) { ?>
                                    <tr>
                                        <td><?= $book['b_date'] ?></td>
                                        <td>
                                            <button class="btn btn-outline-danger" onclick="viewBookDetail('<?= $book['b_id'] ?>')">
                                                <?= $book['b_id'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-primary" onclick="viewCusDetail('<?= $book['b_cus_username'] ?>')">
                                                <?= $book['b_cus_username'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td><?= $book['b_daterange'] ?></td>
                                        <td>
                                            <button class="btn btn-success" onclick="selectRoom('<?= $book['b_id'] ?>','<?= $book['b_rt_id'] ?>','<?= $book['b_check_in'] ?>','<?= $book['b_check_out'] ?>')">เลือก</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" onclick="disApprove('<?= $book['b_id'] ?>')">ไม่อนุมัติ</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="status2" role="tabpanel" aria-labelledby="status2-tab">
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-striped text-center dataTable">
                            <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>หมายเลขจอง</th>
                                    <th>ลูกค้า</th>
                                    <th>เช็คอิน-เช็คเอาท์</th>
                                    <th>กำหนดจ่าย ไม่เกิน</th>
                                    <th>สถานะ</th>
                                    <th>ยกเลิกรายการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books_status2 as $book) { ?>
                                    <tr>
                                        <td><?= $book['b_date'] ?></td>
                                        <td>
                                            <button class="btn btn-outline-danger" onclick="viewBookDetail('<?= $book['b_id'] ?>')">
                                                <?= $book['b_id'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-primary" onclick="viewCusDetail('<?= $book['b_cus_username'] ?>')">
                                                <?= $book['b_cus_username'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td><?= $book['b_daterange'] ?></td>
                                        <td>
                                            <span class="badge bg-danger"><?= $book['b_check_in'] ?></span>
                                        </td>
                                        <td>
                                            <?php
                                            $now = date("Y-m-d H:i:s");
                                            $deposit_date = $book['b_check_in'] . " " . $book['b_time'];
                                            if ($now > $deposit_date) {
                                                echo "<span class='badge bg-danger'>เกินกำหนดจ่าย</span>";
                                            } else {
                                                echo "<span class='badge bg-success'>ยังไม่เกินกำหนดจ่าย</span>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" onclick="disApprove('<?= $book['b_id'] ?>')">ยกเลิก</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="status3" role="tabpanel" aria-labelledby="status3-tab">
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-striped text-center dataTable">
                            <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>หมายเลขจอง</th>
                                    <th>ลูกค้า</th>
                                    <th>เช็คอิน-เช็คเอาท์</th>
                                    <th>หลักฐาน</th>
                                    <th>ยอมรับ</th>
                                    <th>ยกเลิก</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books_status3 as $book) { ?>
                                    <tr>
                                        <td><?= $book['b_date'] ?></td>
                                        <td>
                                            <button class="btn btn-outline-danger" onclick="viewBookDetail('<?= $book['b_id'] ?>')">
                                                <?= $book['b_id'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-primary" onclick="viewCusDetail('<?= $book['b_cus_username'] ?>')">
                                                <?= $book['b_cus_username'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td><?= $book['b_daterange'] ?></td>
                                        <td>
                                            <button class="btn btn-outline-success" onclick="viewProof('<?= $book['b_id'] ?>')">
                                                ตรวจสอบ
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-success" onclick="accept('<?= $book['b_id'] ?>')">ยอมรับ</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" onclick="disApprove('<?= $book['b_id'] ?>')">ยกเลิก</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="status4" role="tabpanel" aria-labelledby="status4-tab">
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-striped text-center dataTable">
                            <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>หมายเลขจอง</th>
                                    <th>ลูกค้า</th>
                                    <th>เช็คอิน-เช็คเอาท์</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books_status4 as $book) { ?>
                                    <tr>
                                        <td><?= $book['b_date'] ?></td>
                                        <td>
                                            <button class="btn btn-outline-danger" onclick="viewBookDetail('<?= $book['b_id'] ?>')">
                                                <?= $book['b_id'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-primary" onclick="viewCusDetail('<?= $book['b_cus_username'] ?>')">
                                                <?= $book['b_cus_username'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td><?= $book['b_daterange'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="status5" role="tabpanel" aria-labelledby="status5-tab">
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-striped text-center dataTable">
                            <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>หมายเลขจอง</th>
                                    <th>ลูกค้า</th>
                                    <th>เช็คอิน-เช็คเอาท์</th>
                                    <th>หมายเหตุ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books_status5 as $book) { ?>
                                    <tr>
                                        <td><?= $book['b_date'] ?></td>
                                        <td>
                                            <button class="btn btn-outline-danger" onclick="viewBookDetail('<?= $book['b_id'] ?>')">
                                                <?= $book['b_id'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-primary" onclick="viewCusDetail('<?= $book['b_cus_username'] ?>')">
                                                <?= $book['b_cus_username'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td><?= $book['b_daterange'] ?></td>
                                        <td><?= $book['b_note'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Room List Modal -->
    <div class="modal fade" id="roomListModal" tabindex="-1" aria-labelledby="roomListModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomListModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body" id="showRoomList">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Book Detail Modal -->
    <div class="modal fade" id="bookDetailModal" tabindex="-1" aria-labelledby="bookDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookDetailModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body" id="showBookDetail">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Detail Modal -->
    <div class="modal fade" id="cusDetailModal" tabindex="-1" aria-labelledby="cusDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cusDetailModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body" id="showCusDetail">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DisApprove Modal -->
    <div class="modal fade" id="disApproveModal" tabindex="-1" aria-labelledby="disApproveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disApproveModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="disApproveForm">
                    <input type="text" name="action" value="disApprove" readonly hidden>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>หมายเลขจอง</label>
                            <input type="text" class="form-control" name="b_id" id="dis_app_id" readonly>
                        </div>
                        <div class="form-group">
                            <label class="text-danger">โปรดระบุหมายเหตุ</label>
                            <textarea class="form-control" name="b_note" rows="10" required></textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js_function/dashboard.js"></script>
</div>