<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('connect.php');

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
} else {
    http_response_code(405);
}
