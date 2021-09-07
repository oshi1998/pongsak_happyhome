uploadRtImg.onchange = evt => {
    const [file] = uploadRtImg.files
    if (file) {
        previewRtImg.src = URL.createObjectURL(file)
    }
}

updRtImg.onchange = evt => {
    const [file] = updRtImg.files
    if (file) {
        previewUpdRtImg.src = URL.createObjectURL(file)
    }
}

function editRoomType(id) {
    $.ajax({
        method: "post",
        url: "services/manageRoomType.php",
        data: {
            "id": id,
            "action": "getData"
        },
        success: function (res) {
            console.log(res);
            $('#editModalLabel').text('แก้ไขประเภทที่พัก รหัส ' + id);
            $('#previewUpdRtImg').prop('src', 'assets/img/roomtypes/' + res.data['rt_image']);
            $('#old_image').val(res.data['rt_image']);
            $('#upd_id').val(id);
            $('#upd_name').val(res.data['rt_name']);
            $('#upd_content').val(res.data['rt_content']);
            $('#upd_price').val(res.data['rt_price']);
            $('#editModal').modal('show');
        }
    });
}

function deleteRoomType(id) {
    swal({
        title: "โปรดยืนยันการลบประเภทที่พัก " + id + "?",
        text: "หากลบไปแล้วคุณจะไม่สามารถกู้คืนได้",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {

        if (willDelete) {

            $.ajax({
                method: "post",
                url: "services/manageRoomType.php",
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

$('#createRoomTypeForm').submit(function (e) {
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        method: "post",
        url: "services/manageRoomType.php",
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

$('#updateRoomTypeForm').submit(function (e) {
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        method: "post",
        url: "services/manageRoomType.php",
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