function viewBookDetail(id) {
    $.ajax({
        method: "post",
        url: "services/book.php",
        data: {
            "b_id": id,
            "action": "getData"
        }
    }).done(function (res) {
        console.log(res);

        let your_room;

        if (res.book['b_r_id'] == "" || res.book['b_r_id'] == null) {
            your_room = "แอดมินยังไม่ได้ตรวจสอบ";
        } else {
            your_room = res.book['b_r_id'];
        }

        let table_html = `
        <div class="table table-responsive">
        <table class="table table-condensed">
            <tr>
                <th>ผู้ทำการจอง</th>
                <td>${res.book['b_cus_username'] + " (" + res.book['cus_firstname'] + " " + res.book['cus_lastname'] + ")"}</td>
            </tr>
            <tr>
                <th>ช่วงเวลา</th>
                <td>${res.book['b_daterange']}</td>
            </tr>
            <tr>
                <th>ระยะเวลา</th>
                <td>${res.book['b_duration']} คืน</td>
            </tr>
            <tr>
                <th>ประเภทห้อง</th>
                <td>${res.book['rt_name']}</td>
            </tr>
            <tr>
                <th>ราคาห้อง/คืน</th>
                <td>${res.book['rt_price']} บาท</td>
            </tr>
            <tr>
                <th>หมายเลขห้อง</th>
                <td>${your_room}</td>
            </tr>
            <tr>
                <th>กำหนดการเช็คอิน</th>
                <td>${res.book['b_check_in'] + " เวลา " + res.book['b_time'] + " น. "}</td>
            </tr>
            <tr>
                <th>กำหนดการเช็คเอาท์</th>
                <td>${res.book['b_check_out'] + " เวลา " + res.book['b_time'] + " น. "}</td>
            </tr>
            <tr>
                <th>รวมค่าที่พักทั้งหมด</th>
                <td>${res.book['b_cost']} บาท</td>
            </tr>
            <tr>
                <th>สถานะ</th>
                <td><span class="badge bg-warning text-dark">${res.book['b_status']}</span></td>
            </tr>
        </table>
    </div> `;

        if (res.book['b_status'] == 'รอเช็คอิน' || res.book['b_status'] == 'อยู่ระหว่างการเช็คอิน' || res.book['b_status'] == 'เช็คเอาท์เรียบร้อย') {
            table_html += `
        <h1>หลักฐานการโอนค่ามัดจำ</h1>
        <div class="d-flex justify-content-between">
        <div class="text-center">
            <img width="300px" height="400px" src="assets/img/slip/${res.book['b_deposit_slip']}">
        </div>
    <table class="table table-condensed">
        <tr>
            <th>ผู้แจ้งโอน</th>
            <td>${res.book['b_cus_username'] + " (" + res.book['cus_firstname'] + " " + res.book['cus_lastname'] + ")"}</td>
        </tr>
        <tr>
            <th>วันเวลาโอน</th>
            <td>${res.book['b_deposit_datetime']}</td>
        </tr>
        <tr>
            <th>โอนเข้าบัญชี</th>
            <td>${res.book['b_bank_id'] + "-" + res.book['b_bank_owner'] + " (" + res.book['b_bank_name'] + ")"}</td>
        </tr>
        <tr>
            <th>จำนวนเงิน</th>
            <td>${(res.book['b_cost'] / 2).toFixed(2)} บาท</td>
        </tr>
    </table>
    </div>
    </div>
    `;
        }

        $('#bookDetailModalLabel').text('หมายเลขจอง ' + id);
        $('#showBookDetail').html(table_html);
        $('#bookDetailModal').modal('show');

    }).fail(function (res) {
        console.log(res);
    });
}

function viewCusDetail(username) {
    $.ajax({
        method: "post",
        url: "services/get_user_data.php",
        data: {
            "username": username,
        }
    }).done(function (res) {
        console.log(res);

        let table_html = "";

        table_html = `
        <div class="table table-responsive">
            <table class="table table-condensed">
                <tr>
                    <th>ชื่อจริง-นามสกุล</th>
                    <td>${res.data['cus_firstname'] + " " + res.data['cus_lastname']}</td>
                </tr>
                <tr>
                    <th>เพศ</th>
                    <td>${res.data['cus_gender']}</td>
                </tr>
                <tr>
                    <th>อีเมล</th>
                    <td>${res.data['cus_email']}</td>
                </tr>
                <tr>
                    <th>ที่อยู่</th>
                    <td>${res.data['cus_address']}</td>
                </tr>
                <tr>
                    <th>เบอร์โทร</th>
                    <td>${res.data['cus_phone']}</td>
                </tr>
            </table>
        </div> `

        $('#cusDetailModalLabel').text('ข้อมูลลูกค้า ' + username);
        $('#showCusDetail').html(table_html);
        $('#cusDetailModal').modal('show');

    }).fail(function (res) {
        console.log(res);
    });
}

function selectRoom(b_id,room_type, checkin, checkout) {
    $.ajax({
        method: "get",
        url: "services/selectroom.php",
        data: {
            "rt_id": room_type,
            "checkin": checkin,
            "checkout": checkout
        }
    }).done(function (res) {
        console.log(res);

        let rooms_html = '<div class="row">';

        res.data.forEach(element => {

            rooms_html += `
            <div class="col-lg-4 col-6">
                <div class="card">
                    <div class="card-header">
                        ห้องหมายเลข ${element['r_id']}
                    </div>
                    <div class="card-body d-flex justify-content-between">
                        <label>
                            ราคา ${element['rt_price']} บาท/คืน
                        </label>
                        <button type="button" class="btn btn-outline-success" onclick="chooseThisRoom('${b_id}','${element['r_id']}')">
                            <i class='bx bx-book-add'></i>
                        </button>
                    </div>
                </div>
            </div>
            `;
        });

        rooms_html += "</div>";

        $('#roomListModalLabel').text(`รายชื่อห้องพักพร้อมบริการ ${checkin} ถึง ${checkout}`);
        $('#showRoomList').html(rooms_html);
        $('#roomListModal').modal('show');

    }).fail(function (res) {
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    })
}

function chooseThisRoom(b_id,room_id){
    $.ajax({
        method: "post",
        url: "services/choose_this_room.php",
        data: {
            "b_id": b_id,
            "r_id": room_id
        }
    }).done(function(res){
        swal({
            title: "สำเร็จ",
            text: res.message,
            icon: "success"
        }).then(()=>{
            window.location.reload();
        });
    }).fail(function(res){
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function approve(id) {
    swal({
        title: "โปรดยืนยันการอนุมัติหมายเลข " + id + "?",
        text: "หากยืนยันไปแล้ว จะไม่สามารถย้อนกลับมาแก้ไขได้",
        icon: "info",
        buttons: true,
    }).then((willApprove) => {

        if (willApprove) {

            $.ajax({
                method: "post",
                url: "services/book.php",
                data: {
                    "b_id": id,
                    "action": "approve"
                }
            }).done(function (res) {
                console.log(res);
                swal({
                    title: "สำเร็จ!",
                    text: res.message,
                    icon: "success",
                }).then(() => {
                    window.location.reload();
                });
            }).fail(function (res) {
                console.log(res);
                swal({
                    title: "ล้มเหลว!",
                    text: res.responseJSON['message'],
                    icon: "error",
                });
            });
        }
    });
}

function disApprove(id) {
    $('#disApproveModalLabel').text('แบบฟอร์มปฏิเสธการจองหมายเลข ' + id);
    $('#dis_app_id').val(id);
    $('#disApproveModal').modal('show');
}

function viewProof(id) {
    $.ajax({
        method: "post",
        url: "services/book.php",
        data: {
            "b_id": id,
            "action": "getData"
        }
    }).done(function (res) {
        console.log(res);

        table_html = `
            <div class="text-center">
                <img width="100%" height="800px" src="assets/img/slip/${res.book['b_deposit_slip']}">
            </div>
        <table class="table table-condensed">
            <tr>
                <th>ผู้แจ้งโอน</th>
                <td>${res.book['b_cus_username'] + " (" + res.book['cus_firstname'] + " " + res.book['cus_lastname'] + ")"}</td>
            </tr>
            <tr>
                <th>วันเวลาโอน</th>
                <td>${res.book['b_deposit_datetime']}</td>
            </tr>
            <tr>
                <th>โอนเข้าบัญชี</th>
                <td>${res.book['b_bank_id'] + "-" + res.book['b_bank_owner'] + " (" + res.book['b_bank_name'] + ")"}</td>
            </tr>
            <tr>
                <th>ค่ามัดจำ 50%</th>
                <td>${(res.book['b_cost'] / 2).toFixed(2)} บาท</td>
            </tr>
            <tr>
                <th>รวมค่าที่พักทั้งหมด</th>
                <td>${res.book['b_cost']} บาท</td>
            </tr>
        </table>
    </div> `

        $('#bookDetailModalLabel').text('ตรวจสอบหลักฐานโอนเงินค่ามัดจำ หมายเลขจอง ' + id);
        $('#showBookDetail').html(table_html);
        $('#bookDetailModal').modal('show');

    }).fail(function (res) {
        console.log(res);
    });
}

function accept(id) {
    swal({
        title: "โปรดยืนยันการยอมรับการโอนค่ามัดจำ หมายเลข " + id + "?",
        text: "หากยืนยันไปแล้ว จะไม่สามารถย้อนกลับมาแก้ไขได้",
        icon: "info",
        buttons: true,
    }).then((willApprove) => {

        if (willApprove) {

            $.ajax({
                method: "post",
                url: "services/book.php",
                data: {
                    "b_id": id,
                    "action": "accept"
                }
            }).done(function (res) {
                console.log(res);
                swal({
                    title: "สำเร็จ!",
                    text: res.message,
                    icon: "success",
                }).then(() => {
                    window.location.reload();
                });
            }).fail(function (res) {
                console.log(res);
                swal({
                    title: "ล้มเหลว!",
                    text: res.responseJSON['message'],
                    icon: "error",
                });
            });
        }
    });
}

function checkIn(id) {
    swal({
        title: "โปรดยืนยันการเช็คอิน หมายเลข " + id + "?",
        text: "หากยืนยันไปแล้ว จะไม่สามารถย้อนกลับมาแก้ไขได้",
        icon: "info",
        buttons: true,
    }).then((willApprove) => {

        if (willApprove) {

            $.ajax({
                method: "post",
                url: "services/book.php",
                data: {
                    "b_id": id,
                    "action": "checkIn"
                }
            }).done(function (res) {
                console.log(res);
                swal({
                    title: "สำเร็จ!",
                    text: res.message,
                    icon: "success",
                }).then(() => {
                    window.location.reload();
                });
            }).fail(function (res) {
                console.log(res);
                swal({
                    title: "ล้มเหลว!",
                    text: res.responseJSON['message'],
                    icon: "error",
                });
            });
        }
    });
}

function checkOut(id) {
    swal({
        title: "โปรดยืนยันการเช็คเอาท์ หมายเลข " + id + "?",
        text: "หากยืนยันไปแล้ว จะไม่สามารถย้อนกลับมาแก้ไขได้",
        icon: "info",
        buttons: true,
    }).then((willApprove) => {

        if (willApprove) {

            $.ajax({
                method: "post",
                url: "services/book.php",
                data: {
                    "b_id": id,
                    "action": "checkOut"
                }
            }).done(function (res) {
                console.log(res);
                swal({
                    title: "สำเร็จ!",
                    text: res.message,
                    icon: "success",
                }).then(() => {
                    window.location.reload();
                });
            }).fail(function (res) {
                console.log(res);
                swal({
                    title: "ล้มเหลว!",
                    text: res.responseJSON['message'],
                    icon: "error",
                });
            });
        }
    });
}


$('#disApproveForm').submit(function (e) {

    e.preventDefault();

    swal({
        title: "โปรดยืนยันการไม่อนุมัติหมายเลข " + $("#dis_app_id").val() + "?",
        text: "หากยืนยันไปแล้ว จะไม่สามารถย้อนกลับมาแก้ไขได้",
        icon: "info",
        buttons: true,
    }).then((willDisApprove) => {

        if (willDisApprove) {

            $.ajax({
                method: "post",
                url: "services/book.php",
                data: $(this).serialize()
            }).done(function (res) {
                console.log(res);
                swal({
                    title: "สำเร็จ!",
                    text: res.message,
                    icon: "success",
                }).then(() => {
                    window.location.reload();
                });
            }).fail(function (res) {
                console.log(res);
                swal({
                    title: "ล้มเหลว!",
                    text: res.responseJSON['message'],
                    icon: "error",
                });
            });
        }
    });
});