<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
    header("Content-type:application/json");
    require_once("connect.php");

    $sql = "UPDATE book SET b_r_id=:r_id,b_status=:status WHERE b_id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'r_id' => $_POST['r_id'],
        'status' => 'รอชำระค่ามัดจำ',
        'id' => $_POST['b_id']
    ]);

    if($result){
        http_response_code(200);
        echo json_encode(['message'=>"เลือกห้องพักสำเร็จ"]);
    }else{
        http_response_code(412);
        echo json_encode(['message'=>"เลือกห้องไม่สำเร็จ"]);
    }
}else{
    http_response_code(405);
}