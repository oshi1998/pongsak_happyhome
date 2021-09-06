<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('connect.php');

    if ($_POST['old_password'] == $_POST['new_password']) {
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'รหัสผ่านเดิม และ รหัสผ่านใหม่เหมือนกัน']);
    } else {
        $sql = "SELECT * FROM customers WHERE cus_username = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['cus_username']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if (!empty($row)) {
            if (password_verify($_POST['old_password'], $row->cus_password)) {

                $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                $sql = "UPDATE customers SET cus_password = ? WHERE cus_username = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$new_password, $_POST['cus_username']]);

                http_response_code(200);
                echo json_encode(['status' => 200, 'message' => "เปลี่ยนรหัสผ่านสมาชิก $_POST[cus_username] สำเร็จ!!"]);
            } else {
                http_response_code(401);
                echo json_encode(['status' => 401, 'message' => 'รหัสผ่านเดิมไม่ถูกต้อง']);
            }
        } else {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'รหัสผ่านเดิมไม่ถูกต้อง']);
        }
    }
} else {
    http_response_code(405);
}
