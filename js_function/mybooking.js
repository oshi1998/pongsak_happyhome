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
                <td>${res.book['b_cus_username']+" ("+res.book['cus_firstname']+" "+res.book['cus_lastname']+")"}</td>
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
