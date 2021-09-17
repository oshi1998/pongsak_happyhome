<div class="container">
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
                            รอเช็คอิน
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">
                                <?= count($books_status4) ?>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="status5-tab" data-bs-toggle="tab" href="#status5" role="tab" aria-controls="status5" aria-selected="false">
                        <span class="badge bg-light text-dark position-relative">
                            อยู่ระหว่างการเช็คอิน
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                <?= count($books_status5) ?>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="status6-tab" data-bs-toggle="tab" href="#status6" role="tab" aria-controls="status6" aria-selected="false">
                        <span class="badge bg-light text-dark position-relative">
                            เช็คเอาท์เรียบร้อย
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                <?= count($books_status6) ?>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="status7-tab" data-bs-toggle="tab" href="#status7" role="tab" aria-controls="status7" aria-selected="false">
                        <span class="badge bg-light text-dark position-relative">
                            ไม่อนุมัติ
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= count($books_status7) ?>
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
                                    <th>อนุมัติ</th>
                                    <th>ไม่อนุมัติ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books_status1 as $book) { ?>
                                    <tr>
                                        <td><?= $book['b_date'] ?></td>
                                        <td>
                                            <span role="button" class="badge bg-danger fs-6" onclick="viewBookDetail('<?= $book['b_id'] ?>')">
                                                <?= $book['b_id'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </span>
                                        </td>
                                        <td>
                                            <span role="button" class="badge bg-primary fs-6" onclick="viewCusDetail('<?= $book['b_cus_username'] ?>')">
                                                <?= $book['b_cus_username'] ?>
                                                <i class="bi bi-eye-fill"></i>
                                            </span>
                                        </td>
                                        <td><?= $book['b_daterange'] ?></td>
                                        <td>
                                            <button class="btn btn-success" onclick="approve('<?= $book['b_id'] ?>')">อนุมัติ</button>
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
                <div class="tab-pane fade" id="status2" role="tabpanel" aria-labelledby="status2-tab">status2</div>
                <div class="tab-pane fade" id="status3" role="tabpanel" aria-labelledby="status3-tab">status3</div>
                <div class="tab-pane fade" id="status4" role="tabpanel" aria-labelledby="status4-tab">status4</div>
                <div class="tab-pane fade" id="status5" role="tabpanel" aria-labelledby="status5-tab">status5</div>
                <div class="tab-pane fade" id="status6" role="tabpanel" aria-labelledby="status6-tab">status6</div>
                <div class="tab-pane fade" id="status7" role="tabpanel" aria-labelledby="status7-tab">status6</div>
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
                            <label class="text-danger">โปรดระบุหมายเหตุ ที่ไม่อนุมัติ!</label>
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