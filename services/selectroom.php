<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    header("Content-type:application/json");
    require_once('connect.php');

    $sql = "SELECT r_id,rt_name,rt_price FROM rooms,roomtypes
    WHERE rooms.rt_id=roomtypes.rt_id
    AND rooms.rt_id = :rt_id 
    AND r_id NOT IN
    (SELECT b_id FROM book WHERE :checkin_date < b_check_out AND :checkout_date > b_check_in AND b_status != :status)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'rt_id' => $_GET['rt_id'],
        'checkin_date' => $_GET['checkin'],
        'checkout_date' => $_GET['checkout'],
        'status' => 'ไม่อนุมัติ'
    ]);

    $rooms = $stmt->fetchAll();

    if(!empty($rooms)){
        http_response_code(200);
        echo json_encode(['message'=>"โหลดข้อมูลห้องพักที่พร้อมบริการสำเร็จ",'data'=>$rooms]);
    }else{
        http_response_code(412);
        echo json_encode(['message'=>"ไม่มีห้องพักพร้อมบริการ $_GET[checkin] ถึง $_GET[checkout]"]);
    }

    
} else {
    http_response_code(405);
}
