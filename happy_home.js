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

uploadImg.onchange = evt => {
    const [file] = uploadImg.files
    if (file) {
        previewImg.src = URL.createObjectURL(file)
    }
}

/* CUSTOMER */

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
            $('#acc_firstname').val(res.data['cus_firstname']);
            $('#acc_lastname').val(res.data['cus_lastname']);
            $('#acc_gender').val(res.data['cus_gender']);
            $('#acc_email').val(res.data['cus_email']);
            $('#acc_address').val(res.data['cus_address']);
            $('#acc_phone').val(res.data['cus_phone']);
            $("#myAccountModal").modal('show');
        }
    });
}

function closeAccount(username) {
    $("#close_username").val(username);
    $("#closeAccountModal").modal('show');
}

function changePassword(username) {
    $('#cp_username').val(username);
    $('#changePasswordModal').modal('show');
}

/* END CUSTOMER */


/* ADMIN */

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

/* END ADMIN */


$(document).ready(function () {


    /* LOGIN AND REGISTER */

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

    /* END LOGIN AND REGISTER */


    /* CUSTOMER */

    $('#updateAccountForm').submit(function (e) {

        e.preventDefault();

        let fd = new FormData(this);

        $.ajax({
            method: "post",
            url: "services/updateAccount.php",
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

    $('#changePassForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "post",
            url: "services/changePassword.php",
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

    /* END CUSTOMER */


    /* ADMIN FORM */

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

    /* END ADMIN FORM */

    /* WEBSITE FORM */
    $('#updateWebsiteForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: "post",
            url: "services/manageWebsite.php",
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
    /* END WEBSITE FORM */
});