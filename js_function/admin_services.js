function editService(id) {
    $.ajax({
        method: "post",
        url: "services/manageService.php",
        data: {
            "id": id,
            "action": "getData"
        },
        success: function (res) {
            $('#editModalLabel').text('แก้ไขบริการ ' + res.data['sv_heading']);
            $('#upd_id').val(id);
            $('#upd_icon').val(res.data['sv_icon']);
            $("#upd_heading").val(res.data['sv_heading']);
            $('#upd_desc').val(res.data['sv_desc']);
            $('#editModal').modal('show');
        }
    });
}

function deleteService(id) {
    swal({
        title: "โปรดยืนยันการลบข้อมูลบริการ " + id + "?",
        text: "หากลบไปแล้วคุณจะไม่สามารถกู้คืนได้",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {

        if (willDelete) {

            $.ajax({
                method: "post",
                url: "services/manageService.php",
                data: {
                    "id": id,
                    "action": "delete"
                }
            }).done(function (res) {
                console.log(res);
                swal({
                    title: "สำเร็จ!",
                    text: res.message,
                    icon: "success",
                }).then((action) => {
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

function changeNo(id, old_value, new_value) {

    $.ajax({
        method: "post",
        url: "services/manageService.php",
        data: {
            "id": id,
            "old_no": old_value,
            "new_no": new_value,
            "action": "changeNo"
        }
    }).done(function (res) {
        console.log(res);
        swal({
            title: "สำเร็จ!",
            text: res.message,
            icon: "success",
        }).then((action) => {
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


$('#createServiceForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        url: "services/manageService.php",
        data: $(this).serialize()
    }).done(function (res) {
        console.log(res);
        swal({
            title: "สำเร็จ!",
            text: res.message,
            icon: "success",
        }).then((action) => {
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

$('#updateServiceForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        url: "services/manageService.php",
        data: $(this).serialize()
    }).done(function (res) {
        console.log(res);
        swal({
            title: "สำเร็จ!",
            text: res.message,
            icon: "success",
        }).then((action) => {
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