<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('connect.php');

    if (str_contains($_POST['mem_username'], 'admin') || str_contains($_POST['mem_username'], 'owner') || str_contains($_POST['mem_username'], 'founder')) {
        http_response_code(412);
        echo json_encode(['status' => 412, 'message' => "ไม่สามารถใช้ชื่อ $_POST[mem_username] ได้ กรุณาเปลี่ยนใหม่"]);
    } else {
        $sql = "SELECT mem_username FROM members WHERE mem_username=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['mem_username']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if (!empty($row)) {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "ชื่อผู้ใช้งาน $_POST[mem_username] ถูกใช้งานแล้ว กรุณาเปลี่ยนใหม่"]);
        } else {

            $sql = "SELECT adm_username FROM admins WHERE adm_username=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['mem_username']]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if (!empty($row)) {
                http_response_code(412);
                echo json_encode(['status' => 412, 'message' => "ชื่อผู้ใช้งาน $_POST[mem_username] ถูกใช้งานแล้ว กรุณาเปลี่ยนใหม่"]);
            } else {
                $password = password_hash($_POST['mem_password'], PASSWORD_DEFAULT);

                $sql = "INSERT INTO members (mem_username,mem_password,mem_firstname,mem_lastname,mem_email,mem_address,mem_phone) VALUES (:username,:password,:firstname,:lastname,:email,:address,:phone)";
                $stmt = $pdo->prepare($sql);

                if ($stmt->execute([
                    'username' => $_POST['mem_username'],
                    'password' => $password,
                    'firstname' => $_POST['mem_firstname'],
                    'lastname' => $_POST['mem_lastname'],
                    'email' => $_POST['mem_email'],
                    'address' => $_POST['mem_address'],
                    'phone' => $_POST['mem_phone']
                ])) {

                    session_start();
                    $_SESSION['USER_LOGIN'] = true;
                    $_SESSION['USER_USERNAME'] = $_POST['mem_username'];
                    $_SESSION['USER_ROLE'] = "MEMBER";

                    http_response_code(200);
                    echo json_encode(['status' => 200, 'message' => 'สมัครสมาชิกสำเร็จ']);
                } else {
                    http_response_code(412);
                    echo json_encode(['status' => 412, 'message' => 'สมัครสมาชิกไม่สำเร็จ เนื่องจากข้อมูลไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง']);
                }
            }
        }
    }
} else {
    http_response_code(405);
}
