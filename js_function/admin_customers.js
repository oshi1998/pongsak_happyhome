uploadCusProfile.onchange = evt => {
    const [file] = uploadCusProfile.files
    if (file) {
        previewCusProfile.src = URL.createObjectURL(file)
    }
}

function editCus(username) {
    $.ajax({
        method: "post",
        url: "services/manageCustomer.php",
        data: {
            "username": username,
            "action": "getData"
        },
        success: function (res) {
            console.log(res);
            $('#editModalLabel').text('แก้ไขข้อมูลลูกค้า ' + username);
            $('#old_profile').val(res.data['cus_profile']);
            $('#previewCusProfile').attr('src', 'assets/img/customers/' + res.data['cus_profile']);
            $("#upd_username").val(username);
            $('#upd_firstname').val(res.data['cus_firstname']);
            $('#upd_lastname').val(res.data['cus_lastname']);
            $('#upd_gender').val(res.data['cus_gender']);
            $('#upd_email').val(res.data['cus_email']);
            $('#upd_address').val(res.data['cus_address']);
            $('#upd_phone').val(res.data['cus_phone']);
            $("#editModal").modal('show');
        }
    });
}

function editPasswordCustomer(username) {
    $('#changePassLabel').text('เปลี่ยนรหัสผ่านลูกค้า ' + username);
    $('#cp_username').val(username);
    $('#changePassModal').modal('show');
}

function enableCus(username) {
    $('#activeModalLabel').text('เปิดใช้งานลูกค้า ' + username);
    $('#active_username').val(username);
    $('#active_action').val('enable');
    $('#activeModal').modal('show');
}

function disableCus(username) {
    $('#activeModalLabel').text('ปิดใช้งานลูกค้า ' + username);
    $('#active_username').val(username);
    $('#active_action').val('disable');
    $('#activeModal').modal('show');
}

$('#createCustomerForm').submit(function (e) {
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


$('#updateCustomerForm').submit(function (e) {
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        method: "post",
        url: "services/manageCustomer.php",
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

$('#changePassCustomerForm').submit(function (e) {
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

$('#activeCustomerForm').submit(function (e) {
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