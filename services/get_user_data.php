<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");

    $sql = "SELECT * FROM customers WHERE cus_username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['username']]);
    $row = $stmt->fetch(PDO::FETCH_OBJ);

    http_response_code(200);
    echo json_encode(['status' => 200, 'message' => "โหลดข้อมูลสมาชิก $_POST[username] สำเร็จ!", 'data' => $row]);
} else {
    http_response_code(405);
}
