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

        let username = $('input[name="username"]').val();
        let password = $('input[name="password"]').val();

        if (username == "" || username == null) {
            $('#login-usr-alert').text("* กรุณากรอกชื่อผู้ใช้งาน").css('color', 'red');
            $('input[name="username"]').focus();
            return false;
        } else {
            $('#login-usr-alert').text("");
        }

        if (password == "" || password == null) {
            $('#login-pass-alert').text("* กรุณากรอกรหัสผ่าน").css('color', 'red');
            $('input[name="password"]').focus();
            return false;
        } else {
            $('#login-pass-alert').text("");
        }

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
    
        let username = $('input[name="cus_username"]').val();
        let password = $('input[name="cus_password"]').val();
        let firstname = $('input[name="cus_firstname"]').val();
        let lastname = $('input[name="cus_lastname"]').val();
        let gender = $('select[name="cus_gender"]').val();
        let email = $('input[name="cus_email"]').val();
        let phone = $('input[name="cus_phone"]').val();

        if (username == "" || username == null) {
            $('#rg-usr-alert').text("* กรุณากรอกชื่อผู้ใช้งาน").css("color", "red");
            $('input[name="cus_username"]').focus();
            return false;
        } else {
            $('#rg-usr-alert').text("");
        }

        if (password == "" || password == null) {
            $('#rg-pass-alert').text("* กรุณากรอกรหัสผ่าน").css("color", "red");
            $('input[name="cus_password"]').focus();
            return false;
        } else {
            $('#rg-pass-alert').text("");
        }

        if (firstname == "" || firstname == null) {
            $('#rg-fname-alert').text("* กรุณากรอกชื่อจริง").css("color", "red");
            $('input[name="cus_firstname"]').focus();
            return false;
        } else {
            $('#rg-fname-alert').text("");
        }

        if (lastname == "" || lastname == null) {
            $('#rg-lname-alert').text("* กรุณากรอกนามสกุล").css("color", "red");
            $('input[name="cus_lastname"]').focus();
            return false;
        } else {
            $('#rg-lname-alert').text("");
        }

        if (gender == "" || gender == null) {
            $('#rg-gender-alert').text("* กรุณาระบุเพศ").css("color", "red");
            $('select[name="cus_gender"]').focus();
            return false;
        } else{
            $('#rg-gender-alert').text("");
        }

        if (email == "" || email == null) {
            $('#rg-email-alert').text("* กรุณากรอกอีเมล").css("color", "red");
            $('input[name="cus_email"]').focus();
            return false;
        } else{
            $('#rg-email-alert').text("");
        }

        if (phone == "" || phone == null) {
            $('#rg-phone-alert').text("* กรุณากรอกเบอร์โทร").css("color", "red");
            $('input[name="cus_phone"]').focus();
            return false;
        } else{
            $('#rg-phone-alert').text("");
        }

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
            }).then(() => {
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