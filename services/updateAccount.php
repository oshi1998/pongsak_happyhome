<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('connect.php');

    $sql = "UPDATE members SET mem_firstname=:firstname,mem_lastname=:lastname,mem_email=:email,mem_address=:address,mem_phone=:phone WHERE mem_username=:username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'firstname' => $_POST['mem_firstname'],
        'lastname' => $_POST['mem_lastname'],
        'email' => $_POST['mem_email'],
        'address' => $_POST['mem_address'],
        'phone' => $_POST['mem_phone'],
        'username' => $_POST['mem_username']
    ]);

    http_response_code(200);
    echo json_encode(['status' => 200, 'message' => 'อัพเดตบัญชีสำเร็จ!']);
} else {
    http_response_code(405);
}
