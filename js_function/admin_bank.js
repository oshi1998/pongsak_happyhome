uploadBankImg.onchange = evt => {
    const [file] = uploadBankImg.files
    if (file) {
        previewBankImg.src = URL.createObjectURL(file)
    }
}

updBankImg.onchange = evt => {
    const [file] = updBankImg.files
    if (file) {
        previewUpdBankImg.src = URL.createObjectURL(file)
    }
}


function editBank(id) {
    $.ajax({
        method: "post",
        url: "services/manageBank.php",
        data: {
            "id": id,
            "action": "getData"
        },
        success: function (res) {
            console.log(res);
            $('#editModalLabel').text('แก้ไขบัญชีธนาคาร เลข ' + id);
            $('#previewUpdBankImg').prop('src', 'assets/img/banks/' + res.data['bank_img']);
            $('#old_image').val(res.data['bank_img']);
            $('#old_id').val(id);
            $('#upd_id').val(id);
            $('#upd_name').val(res.data['bank_name']);
            $('#upd_owner').val(res.data['bank_owner']);
            $('#editModal').modal('show');
        }
    });
}

function deleteBank(id) {
    swal({
        title: "โปรดยืนยันการลบบัญชีธนาคาร " + id + "?",
        text: "หากลบไปแล้วคุณจะไม่สามารถกู้คืนได้",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {

        if (willDelete) {

            $.ajax({
                method: "post",
                url: "services/manageBank.php",
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


$('#createBankForm').submit(function (e) {
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        method: "post",
        url: "services/manageBank.php",
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

$('#updateBankForm').submit(function (e) {
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        method: "post",
        url: "services/manageBank.php",
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