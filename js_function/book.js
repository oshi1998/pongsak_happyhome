function addBook(id) {
    $.ajax({
        method: "post",
        url: "services/book.php",
        data: {
            "r_id": id,
            "action": "addBook"
        }
    }).done(function (res) {
        swal({
            title: "สำเร็จ!",
            text: res.message,
            icon: "success",
        }).then(() => {
            window.location.reload();
        });
    }).fail(function (res) {
        swal({
            title: "ล้มเหลว!",
            text: res.responseJSON['message'],
            icon: "error",
        });
    });
}

function removeBook(id) {
    $.ajax({
        method: "post",
        url: "services/book.php",
        data: {
            "r_id": id,
            "action": "removeBook"
        }
    }).done(function (res) {
        swal({
            title: "สำเร็จ!",
            text: res.message,
            icon: "success",
        }).then(() => {
            window.location.reload();
        });
    }).fail(function (res) {
        swal({
            title: "ล้มเหลว!",
            text: res.responseJSON['message'],
            icon: "error",
        });
    });
}

function booking() {
    swal({
        title: "โปรดยืนยันการดำเนินการจอง?",
        text: "หากยืนยันไปแล้ว จะไม่สามารถย้อนกลับมาแก้ไขได้",
        icon: "info",
        buttons: true,
    }).then((willBooking) => {

        if (willBooking) {

            $.ajax({
                method: "post",
                url: "services/book.php",
                data: {
                    "action": "booking"
                }
            }).done(function (res) {
                console.log(res);
                swal({
                    title: "สำเร็จ!",
                    text: res.message,
                    icon: "success",
                }).then(() => {
                    window.location = 'book.php?step=4';
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


$(function () {

    let start = moment().startOf('hour');
    let end = moment().startOf('hour').add(24, 'hour');
    $('input[name="checkin"]').val(start.format('YYYY-MM-DD'));
    $('input[name="checkout"]').val(end.format('YYYY-MM-DD'));

    $('input[name="daterange"]').daterangepicker({
        autoApply: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(24, 'hour'),
        minDate: moment().startOf('hour'),
        locale: {
            format: 'Y-MM-DD'
        }
    }, function (start, end) {
        let duration = end.diff(start, 'days');
        $('input[name="checkin"]').val(start.format('YYYY-MM-DD'));
        $('input[name="checkout"]').val(end.format('YYYY-MM-DD'));
        $('input[name="duration"]').val(duration);
    });

});

$('#checkIn-checkOut-Form').submit(function (e) {

    e.preventDefault();

    $.ajax({
        method: "post",
        url: "services/book.php",
        data: $(this).serialize(),
        success: function (res) {
            console.log(res);
            window.location = "book.php?step=2";
        }
    });
});
