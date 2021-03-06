<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('connect.php');

    $sql = "SELECT * FROM customers WHERE cus_username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['cus_username']]);
    $row = $stmt->fetch(PDO::FETCH_OBJ);

    if (!empty($row)) {
        if (password_verify($_POST['cus_password'], $row->cus_password)) {
            session_start();

            $sql = "DELETE FROM customers WHERE cus_username = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['cus_username']]);
            session_destroy();

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => 'ลบบัญชีสำเร็จ กำลังออกจากระบบอัตโนมัติ']);
        } else {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
        }
    } else {
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
    }
} else {
    http_response_code(405);
}
