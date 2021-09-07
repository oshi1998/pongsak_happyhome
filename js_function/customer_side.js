uploadImg.onchange = evt => {
    const [file] = uploadImg.files
    if (file) {
        previewImg.src = URL.createObjectURL(file)
    }
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
    $('#ccp_username').val(username);
    $('#changePasswordModal').modal('show');
}

function forgotPassword() {
    $('#loginModal').modal('hide');
    $('#forgotPassModal').modal('show');
}

function checkCusUsername() {

    let cus_username = $('#c_cus_username').val();
    let cus_firstname = $('#c_cus_firstname').val();
    let cus_lastname = $('#c_cus_lastname').val();
    //console.log(cus_username);

    $.ajax({
        method: "post",
        url: "services/manageCustomer.php",
        data: {
            "username": cus_username,
            "firstname": cus_firstname,
            "lastname": cus_lastname,
            "action": "check_cus_username"
        },
    }).done(function (res) {
        console.log(res);
        $('#c_cus_username').prop('readonly', true);
        $('#c_cus_firstname').prop('readonly', true);
        $('#c_cus_lastname').prop('readonly', true);
        $('#c_cus_password').prop('disabled', false);
        $('#btn_submit_forgot_pass_form').prop('disabled', false);
        swal({
            title: "สำเร็จ!",
            text: res.message,
            icon: "success",
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

$('#resetCusPassForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        url: "services/manageCustomer.php",
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