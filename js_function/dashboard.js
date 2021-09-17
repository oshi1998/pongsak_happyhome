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

        let total_price = 0;
        let table_html = `
        <div class="table table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>ประเภท</th>
                        <th>เลขห้อง</th>
                        <th>ราคา/คืน</th>
                    </tr>
                </thead>
                <tbody id="bookDetailTB">`;

        res.book_detail.forEach(element => {
            total_price += Number(element.rt_price);
            table_html += `
            <tr>
                <td>${element.rt_name}</td>
                <td>${element.r_id}</td>
                <td>${element.rt_price}</td>
            </tr>
            `
        });

        total_price = total_price.toFixed(2);

        table_html += `
            </tbody>
            <tfoot>
                <tr>
                    <th>รวม</th>
                    <td>${res.book['b_qty']} (ห้อง)</td>
                    <td>${total_price} (บาท)</td>
                </tr>
            </tfoot>
        </table>`;

        table_html += `
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
    </div> `

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
    $('#disApproveModalLabel').text('แบบฟอร์มไม่อนุมัติการจองหมายเลข ' + id);
    $('#dis_app_id').val(id);
    $('#disApproveModal').modal('show');
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
                data : $(this).serialize()
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