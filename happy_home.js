$('#dataTable').DataTable();

function logOut() {
    $.ajax({
        type: "get",
        url: "services/logout.php",
        success: function (res) {
            console.log(res);
            window.location = 'index.php';
        }
    });
}

function myAccount(username) {
    $.ajax({
        method: "post",
        url: "services/get_user_data.php",
        data: {
            "username": username
        },
        success: function (res) {
            console.log(res);
            $("#acc_username").val(username);
            $('#acc_firstname').val(res.data['mem_firstname']);
            $('#acc_lastname').val(res.data['mem_lastname']);
            $('#acc_email').val(res.data['mem_email']);
            $('#acc_address').val(res.data['mem_address']);
            $('#acc_phone').val(res.data['mem_phone']);
            $("#myAccountModal").modal('show');
        }
    })
}

function closeAccount(username) {
    $.ajax({
        method: "post",
        url: "services/get_user_data.php",
        data: {
            "username": username
        },
        success: function (res) {
            console.log(res);
            $("#close_username").val(username);
            $("#closeAccountModal").modal('show');
        }
    })
}

function editAdmin(username) {

    $.ajax({
        method: "post",
        url: "services/get_admin_data.php",
        data: {
            "username": username
        },
        success: function (res) {
            console.log(res);
            $('#action').val('update');
            $('#adm_username').prop('readonly', true);
            $('#adm_password').prop('disabled', true);
            $('#adm_username').val(username);
            $('#adm_firstname').val(res.data['adm_firstname']);
            $('#adm_lastname').val(res.data['adm_lastname']);
        }
    })
}

function deleteAdmin(username) {
    swal({
        title: "โปรดยืนยันการลบบัญชีผู้ใช้งาน "+username+"?",
        text: "หากลบไปแล้วคุณจะไม่สามารถกู้คืนบัญชีได้",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {

        if (willDelete) {

            $.ajax({
                method: "post",
                url: "services/deleteAdmin.php",
                data: {
                    "username" : username
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


$(document).ready(function () {

    $('#loginForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "post",
            url: "services/login.php",
            data: $(this).serialize()
        }).done(function (res) {
            console.log(res);
            window.location.reload();
        }).fail(function (res) {
            console.log(res);
            swal({
                title: "ล้มเหลว!",
                text: res.responseJSON['message'],
                icon: "error",
            });
        });
    });


    $('#registerForm').submit(function (e) {

        e.preventDefault();

        $.ajax({
            method: "post",
            url: "services/register.php",
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

    $('#updateAccountForm').submit(function (e) {

        e.preventDefault();

        $.ajax({
            method: "post",
            url: "services/updateAccount.php",
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


    $('#closeAccountForm').submit(function (e) {

        e.preventDefault();

        swal({
            title: "โปรดยืนยันการลบบัญชีผู้ใช้งาน?",
            text: "หากลบไปแล้วคุณจะไม่สามารถกู้คืนบัญชีได้",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {

            if (willDelete) {

                $.ajax({
                    method: "post",
                    url: "services/closeAccount.php",
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
            }
        });
    });

    $('#manageAdminForm').submit(function (e) {
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
});