function editAdmin(username) {

    $.ajax({
        method: "post",
        url: "services/manageAdmin.php",
        data: {
            "username": username,
            "action": "getData",
        },
        success: function (res) {
            console.log(res);
            $('#editModalLabel').text('แก้ไขข้อมูลแอดมิน ' + res.data['adm_username']);
            $('#upd_username').val(res.data['adm_username']);
            $('#upd_firstname').val(res.data['adm_firstname']);
            $('#upd_lastname').val(res.data['adm_lastname']);
            $('#editModal').modal('show');
        }
    });
}

function deleteAdmin(username) {
    swal({
        title: "โปรดยืนยันการลบบัญชีผู้ใช้งาน " + username + "?",
        text: "หากลบไปแล้วคุณจะไม่สามารถกู้คืนบัญชีได้",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {

        if (willDelete) {

            $.ajax({
                method: "post",
                url: "services/manageAdmin.php",
                data: {
                    "username": username,
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

function editPasswordAdmin(username) {
    $('#changePassLabel').text('แก้ไขรหัสผ่านแอดมิน ' + username);
    $('#cp_username').val(username);
    $('#changePassModal').modal('show');
}


$('#createAdminForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        url: "services/manageAdmin.php",
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

$('#updateAdminForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        url: "services/manageAdmin.php",
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

$('#changePassAdminForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        url: "services/manageAdmin.php",
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