function editRoom(id) {

    $.ajax({
        method: "post",
        url: "services/manageRoom.php",
        data: {
            "id": id,
            "action": "getData"
        },
        success: function (res) {
            $('#editModalLabel').text('แก้ไขห้องพักเลข ' + id);
            $('#upd_id').val(id);
            $('#upd_rt_id').val(res.data['rt_id']);
            $('#editModal').modal('show');
        }
    });
}

function deleteRoom(id) {
    swal({
        title: "โปรดยืนยันการลบห้องพัก " + id + "?",
        text: "หากลบไปแล้วคุณจะไม่สามารถกู้คืนได้",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {

        if (willDelete) {

            $.ajax({
                method: "post",
                url: "services/manageRoom.php",
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


$('#createRoomForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        url: "services/manageRoom.php",
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

$('#updateRoomForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        url: "services/manageRoom.php",
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