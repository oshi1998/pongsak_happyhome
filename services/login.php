<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");

    $sql = "SELECT * FROM customers WHERE cus_username = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['username']]);
    $row = $stmt->fetch(PDO::FETCH_OBJ);

    if (!empty($row)) {
        if (password_verify($_POST['password'], $row->cus_password)) {

            if ($row->cus_active == 'Disable') {
                http_response_code(401);
                echo json_encode(['status' => 401, 'message' => "ชื่อผู้ใช้งาน $row->cus_username ถูกปิดการใช้งานชั่วคราว กรุณาติดต่อผู้ดูแลระบบ"]);
            } else {
                session_start();

                $_SESSION['USER_LOGIN'] = true;
                $_SESSION['USER_USERNAME'] = $row->cus_username;
                $_SESSION['USER_PROFILE'] = $row->cus_profile;
                $_SESSION['USER_ROLE'] = "CUSTOMER";
                http_response_code(200);
                echo json_encode(['status' => 200, 'message' => 'เข้าสู่ระบบสำเร็จ']);
            }
        } else {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
        }
    } else {

        $sql = "SELECT * FROM admins WHERE adm_username = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['username']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if (!empty($row)) {
            if (password_verify($_POST['password'], $row->adm_password)) {

                session_start();

                $_SESSION['USER_LOGIN'] = true;
                $_SESSION['USER_USERNAME'] = $row->adm_username;
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
