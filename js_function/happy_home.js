$('.dataTable').DataTable();

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
});