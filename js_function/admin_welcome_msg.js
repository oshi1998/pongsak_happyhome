$('#updateWelcomeMsgForm').submit(function (e) {
    e.preventDefault();
    
    let fd = new FormData(this);

    $.ajax({
        method: "post",
        url: "services/updateWelcome.php",
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