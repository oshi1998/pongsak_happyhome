<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") { //เช็ครีเควสจากฝั่ง Client ที่ส่งมาว่าเป็น POST หรือไม่?

    header("Content-Type:application/json");  //ตั้ง header content-type เป็น application/json
    require_once("connect.php"); //include ไฟล์ connect.php สำหรับติดต่อฐานข้อมูล

    $sql = "SELECT * FROM customers WHERE cus_username = ?"; //โค้ด sql select จากตาราง customers where ด้วย username

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['username']]);
    $row = $stmt->fetch(PDO::FETCH_OBJ); //fetch ข้อมูลแบบออบเจ็กเก็บไว้ที่ตัวแปร $row

    if (!empty($row)) { //เช็คตัวแปร $row ว่ามีข้อมูลหรือไม่
        if (password_verify($_POST['password'], $row->cus_password)) { //หากมีจะทำการตรวจสอบรหัสผ่านด้วย password_verify

            if ($row->cus_active == 'Disable') { //หากรหัสผ่านถูกจะ ตรวจสอบสถานะ เป็น Disabled หรือไม่
                http_response_code(401); //หากสถานะเป็น Disable ให้ตอบกลับไปฝั่ง Client 401
                echo json_encode(['status' => 401, 'message' => "ชื่อผู้ใช้งาน $row->cus_username ถูกปิดการใช้งานชั่วคราว กรุณาติดต่อผู้ดูแลระบบ"]);
            } else {
                session_start(); // หากไม่เป็น Disable ใ้ห้ทำการสร้างแปร $_SESSION เพื่อเก็บข้อมูลการล็อกอิน

                $_SESSION['USER_LOGIN'] = true;
                $_SESSION['USER_USERNAME'] = $row->cus_username;
                $_SESSION['USER_NAME'] = $row->cus_firstname." ".$row->cus_lastname;
                $_SESSION['USER_PROFILE'] = $row->cus_profile;
                $_SESSION['USER_ROLE'] = "CUSTOMER";
                http_response_code(200); //ตอบกลับไปฝั่ง Client 200
                echo json_encode(['status' => 200, 'message' => 'เข้าสู่ระบบสำเร็จ']);
            }
        } else {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
        }
    } else {

        $sql = "SELECT * FROM admins WHERE adm_username = ?"; //ถ้าเช็คจาก customers แล้วไม่มีข้อมูลให้ลองเรียกจาก admins
        // เพราะ อาจเป็น Admin ที่ Login เข้ามา

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['username']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if (!empty($row)) {
            if (password_verify($_POST['password'], $row->adm_password)) {

                session_start();

                $_SESSION['USER_LOGIN'] = true;
                $_SESSION['USER_USERNAME'] = $row->adm_username;
                $_SESSION['USER_NAME'] = $row->adm_firstname." ".$row->adm_lastname;
                $_SESSION['USER_ROLE'] = "ADMIN";
                http_response_code(200);
                echo json_encode(['status' => 200, 'message' => 'เข้าสู่ระบบสำเร็จ']);
            } else {
                http_response_code(401);
                echo json_encode(['status' => 401, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
            }
        } else {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
        }
    }
} else {
    http_response_code(405);
}
