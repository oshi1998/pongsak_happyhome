<?php

if(isset($_POST['setSession'])){

    header("Content-Type:application/json");
    require_once('connect.php');

    session_start();

    if($_POST['setSession']=="manageRoomTypeImage"){

        $_SESSION['mrt_id'] = $_POST['mrt_id'];

        $sql = "SELECT * FROM images WHERE rt_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['mrt_id']]);
        $row = $stmt->fetchAll();

        http_response_code(200);
        echo json_encode(['status'=>200,'message'=>"โหลดข้อมูลรูปภาพของห้องพักประเภท $_POST[mrt_id] สำเร็จ",'data'=>$row]);
    }
}