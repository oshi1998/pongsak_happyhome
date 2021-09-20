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
            $('#dep_bank_name').val(res.data['bank_name']);
            $('#dep_bank_id').val(id);
            $('#dep_bank_branch').val(res.data['bank_branch']);
            $('#dep_bank_owner').val(res.data['bank_owner']);
        }
    });
}

$('#depositForm').submit(function (e) {

    e.preventDefault();

    let fd = new FormData(this);
    fd.append("action","deposit");

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