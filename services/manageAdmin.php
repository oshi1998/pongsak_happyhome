<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");

    if ($_POST['action'] == "insert") {

        $sql = "SELECT cus_username FROM customers WHERE cus_username=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['adm_username']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if (!empty($row)) {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "ชื่อผู้ใช้งาน $_POST[adm_username] ถูกใช้งานแล้ว กรุณาเปลี่ยนใหม่"]);
        } else {

            $sql = "SELECT adm_username FROM admins WHERE adm_username=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['adm_username']]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if (!empty($row)) {
                http_response_code(412);
                echo json_encode(['status' => 412, 'message' => "ชื่อผู้ใช้งาน $_POST[adm_username] ถูกใช้งานแล้ว กรุณาเปลี่ยนใหม่"]);
            } else {
                $password = password_hash($_POST['adm_password'], PASSWORD_DEFAULT);

                $sql = "INSERT INTO admins (adm_username,adm_password,adm_firstname,adm_lastname) VALUES (:username,:password,:firstname,:lastname)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'username' => $_POST['adm_username'],
                    'password' => $password,
                    'firstname' => $_POST['adm_firstname'],
                    'lastname' => $_POST['adm_lastname']
                ]);
                http_response_code(200);
                echo json_encode(['status' => 200, 'message' => "เพิ่มแอดมิน $_POST[adm_username] สำเร็จ!"]);
            }
        }
    } else if ($_POST['action'] == 'update') {
        $sql = "UPDATE admins SET adm_firstname = :firstname,adm_lastname = :lastname WHERE adm_username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'firstname' => $_POST['adm_firstname'],
            'lastname' => $_POST['adm_lastname'],
            'username' => $_POST['adm_username']
        ]);
        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "อัพเดตแอดมิน $_POST[adm_username] สำเร็จ!"]);
    } else if ($_POST['action'] == 'delete') {
        session_start();

        if ($_SESSION['USER_USERNAME'] == $_POST['username']) {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'คุณไม่สามารถลบบัญชีตัวเองได้']);
        } else {
            $sql = "DELETE FROM admins WHERE adm_username =?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['username']]);

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "ลบบัญชี $_POST[username] สำเร็จ"]);
        }
    } else if ($_POST['action'] == 'getData') {

        $sql = "SELECT * FROM admins WHERE adm_username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['username']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "โหลดข้อมูลแอดมิน $_POST[username] สำเร็จ!", 'data' => $row]);
    } else if ($_POST['action'] == 'changePassword') {


        if ($_POST['old_password'] == $_POST['new_password']) {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'รหัสผ่านเดิม และ รหัสผ่านใหม่เหมือนกัน']);
        } else {
            $sql = "SELECT * FROM admins WHERE adm_username = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['adm_username']]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if (!empty($row)) {
                if (password_verify($_POST['old_password'], $row->adm_password)) {

                    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    $sql = "UPDATE admins SET adm_password = ? WHERE adm_username = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$new_password, $_POST['adm_username']]);

                    http_response_code(200);
                    echo json_encode(['status' => 200, 'message' => "เปลี่ยนรหัสผ่านแอดมิน $_POST[adm_username] สำเร็จ!!"]);
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
} else {
    http_response_code(405);
}
