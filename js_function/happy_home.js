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

        /* รับค่าตัวแปร username,password จาก input */
        let username = $('input[name="username"]').val();
        let password = $('input[name="password"]').val();
        /* ----------------------------------- */


        /* ตรวจสอบค่าตัวแปร username,password ว่าเป็นค่าว่างหรือไม่ */
        if (username == "" || username == null) {
            $('#login-usr-alert').text("* กรุณากรอกชื่อผู้ใช้งาน").css('color', 'red'); //แสดงข้อความเตือนสีแดง
            $('input[name="username"]').focus(); //โฟกัส input username
            return false; //หยุดการทำงานฟังก์ชั่น
        } else {
            $('#login-usr-alert').text(""); //เคลียร์ login-usr-alert เป็น "" ค่าว่าง
        }

        if (password == "" || password == null) {
            $('#login-pass-alert').text("* กรุณากรอกรหัสผ่าน").css('color', 'red');
            $('input[name="password"]').focus();
            return false;
        } else {
            $('#login-pass-alert').text("");
        }

        /* ----------------------------------- */

        /* Ajax ส่งรีเควสไปหา API */

        e.preventDefault();

        $.ajax({
            method: "post", //เมธอด post
            url: "services/login.php", //เส้นทางไปหาไฟล์ api
            data: $(this).serialize() //ข้อมูลที่ส่งไป ก็คือทั้งหมด loginForm
        }).done(function (res) { //done คือ กรณีที่ฝั่งเซิฟเวอร์ตอบกลับมา http code 200
            console.log(res);
            window.location.reload(); //รีโหลดหน้าใหม่
        }).fail(function (res) { //fail คือกรณีที่ฝั่งเซิฟเวอร์ตอบกลับมา http code 400+
            console.log(res);
            /* เรียกใช้ sweetalert */
            swal({
                title: "ล้มเหลว!",
                text: res.responseJSON['message'],
                icon: "error",
            });
            /* --------------- */
        });

        /* ----------------------------------- */

    });


    $('#registerForm').submit(function (e) {
    
        /* รับค่าตัวแปรทังหมดจาก input */
        let username = $('input[name="cus_username"]').val();
        let password = $('input[name="cus_password"]').val();
        let firstname = $('input[name="cus_firstname"]').val();
        let lastname = $('input[name="cus_lastname"]').val();
        let gender = $('select[name="cus_gender"]').val();
        let email = $('input[name="cus_email"]').val();
        let phone = $('input[name="cus_phone"]').val();

        /* --------------------------- */


        /* ตรวจสอบตัวแปรที่รับจาก input ทั้งหมด ว่าเป็นค่าว่างหรือไม่ */
        if (username == "" || username == null) {
            $('#rg-usr-alert').text("* กรุณากรอกชื่อผู้ใช้งาน").css("color", "red");  //แสดงข้อความเตือนสีแดง
            $('input[name="cus_username"]').focus(); //โฟกัสที่ input
            return false;
        } else {
            $('#rg-usr-alert').text("");
        }

        if (password == "" || password == null) {
            $('#rg-pass-alert').text("* กรุณากรอกรหัสผ่าน").css("color", "red"); //แสดงข้อความเตือนสีแดง
            $('input[name="cus_password"]').focus(); //โฟกัสที่ input
            return false;
        } else {
            $('#rg-pass-alert').text("");
        }

        if (firstname == "" || firstname == null) { 
            $('#rg-fname-alert').text("* กรุณากรอกชื่อจริง").css("color", "red"); //แสดงข้อความเตือนสีแดง
            $('input[name="cus_firstname"]').focus(); //โฟกัสที่ input
            return false;
        } else {
            $('#rg-fname-alert').text("");
        }

        if (lastname == "" || lastname == null) {
            $('#rg-lname-alert').text("* กรุณากรอกนามสกุล").css("color", "red"); //แสดงข้อความเตือนสีแดง
            $('input[name="cus_lastname"]').focus(); //โฟกัสที่ input
            return false;
        } else {
            $('#rg-lname-alert').text("");
        }

        if (gender == "" || gender == null) {
            $('#rg-gender-alert').text("* กรุณาระบุเพศ").css("color", "red"); //แสดงข้อความเตือนสีแดง
            $('select[name="cus_gender"]').focus(); //โฟกัสที่ input
            return false;
        } else{
            $('#rg-gender-alert').text("");
        }

        if (email == "" || email == null) {
            $('#rg-email-alert').text("* กรุณากรอกอีเมล").css("color", "red");//แสดงข้อความเตือนสีแดง
            $('input[name="cus_email"]').focus(); //โฟกัสที่ input
            return false;
        } else{
            $('#rg-email-alert').text("");
        }

        if (phone == "" || phone == null) {
            $('#rg-phone-alert').text("* กรุณากรอกเบอร์โทร").css("color", "red"); //แสดงข้อความเตือนสีแดง
            $('input[name="cus_phone"]').focus(); //โฟกัสที่ input
            return false;
        } else{
            $('#rg-phone-alert').text("");
        }
        /* ------------------------------------------------------------------------- */


        /* Ajax ส่งรีเควสไปหา API register.php */

        e.preventDefault();

        $.ajax({
            method: "post", //รีเควสเมธอด post
            url: "services/register.php", //เส้นทาง services/register.php
            data: $(this).serialize() //ส่งข้อมูลจากแบบฟอร์ม registerForm ไป
        }).done(function (res) {
            console.log(res);
            /* เรียกใช้ sweetalert */
            swal({
                title: "สำเร็จ!",
                text: res.message, //ข้อความที่แสดงคือจากตัวแปร res.message ที่ตอบกลับมาจากฝั่ง Server
                icon: "success",
            }).then(() => {
                window.location.reload(); //หลังจากกดปุ่่ม ok ให้ reload หน้าใหม่
            });
            /* ------------------------- */
        }).fail(function (res) {
            console.log(res);
            swal({
                title: "ล้มเหลว!",
                text: res.responseJSON['message'], //ข้อความที่แสดงคือจากตัวแปร res.responseJSON['message'] ที่ตอบกลับมาจากฝั่ง Server
                icon: "error",
            });
        });
    });

    /* END LOGIN AND REGISTER */
});