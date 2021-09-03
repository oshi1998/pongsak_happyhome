<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");

    if ($_POST['action'] == "insert") {

        $sql = "SELECT mem_username FROM members WHERE mem_username=?";
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
    } else {
        $sql = "UPDATE admins SET adm_firstname = :firstname,adm_lastname = :lastname WHERE adm_username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'firstname' => $_POST['adm_firstname'],
            'lastname' => $_POST['adm_lastname'],
            'username' => $_POST['adm_username']
        ]);
        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "อัพเดตแอดมิน $_POST[adm_username] สำเร็จ!"]);
    }
} else {
    http_response_code(405);
}
