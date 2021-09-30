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

        if(res.book['b_r_id']=="" || res.book['b_r_id']==null){
            your_room = "แอดมินยังไม่ได้ตรวจสอบ";
        }else{
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

function deposit(id, cost) {

    let deposit_cost = cost / 2;

    $('#depositModalLabel').text('ชำระค่ามัดจำ หมายเลขจอง ' + id);
    $('#dep_b_id').val(id);
    $('#deposit_cost_label').text(`ยอดชำระค่ามัดจำ 50% (ทั้งหมด : ${cost})`);
    $('#deposit_cost').val(deposit_cost.toFixed(2));
    $('#depositModal').modal('show');
}

function checkRadioBank(id) {
    $.ajax({
        method: "post",
        url: "services/manageBank.php",
        data: {
            "id": id,
            "action": "getData"
        },
        success: function (res) {
            $('#dep_bank_id').val(id);
            $('#dep_bank_branch').val(res.data['bank_branch']);
            $('#dep_bank_owner').val(res.data['bank_owner']);
        }
    });
}

$('#depositForm').submit(function (e) {

    e.preventDefault();

    let fd = new FormData(this);
    fd.append("action", "deposit");

    $.ajax({
        method: "post",
        url: "services/book.php",
        data: fd,
        cache: false,
        contentType: false,
        processData: false
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
});