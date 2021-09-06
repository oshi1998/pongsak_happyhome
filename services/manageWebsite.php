<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");

    $sql = "UPDATE website SET web_name=:name,web_description=:description,web_keywords=:keywords,
    web_address=:address,web_phone=:phone,web_email=:email,web_facebook=:facebook,web_ig=:ig,
    web_youtube=:youtube,web_twitter=:twitter,web_google_map=:google_map";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name' => $_POST['web_name'],
        'description' => $_POST['web_description'],
        'keywords' => $_POST['web_keywords'],
        'address' => $_POST['web_address'],
        'phone' => $_POST['web_phone'],
        'email' => $_POST['web_email'],
        'facebook' => $_POST['web_facebook'],
        'ig' => $_POST['web_ig'],
        'youtube' => $_POST['web_youtube'],
        'twitter' => $_POST['web_twitter'],
        'google_map' => $_POST['web_google_map']
    ]);

    http_response_code(200);
    echo json_encode(['status'=>200,'message'=>'อัพเดตข้อมูลเว็บไซต์สำเร็จ']);
} else {
    http_response_code(405);
}
