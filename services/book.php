<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");
    session_start();

    if ($_POST['action'] == 'checkin-checkout') {

        if (isset($_SESSION['MYBOOK'])) {
            unset($_SESSION['MYBOOK']);
        }

        $_SESSION['MYBOOK'] = array(
            "daterange" => $_POST['daterange'],
            "duration" => $_POST['duration'],
            "checkin" => $_POST['checkin'],
            'checkout' => $_POST['checkout'],
            "time" => $_POST['time'],
            "room" => array(),
            "cost" => 0,
        );

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => 'ทำขั้นตอนที่ 1 สำเร็จ!']);
    } else if ($_POST['action'] == 'addBook') {

        $sql = "SELECT * FROM rooms,roomtypes WHERE rooms.rt_id=roomtypes.rt_id AND r_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['r_id']]);
        $row = $stmt->fetchObject();

        $cost = 0;

        if (isset($_SESSION['MYBOOK'])) {

            if (empty($_SESSION['MYBOOK']['room'])) {
                $_SESSION['MYBOOK']['room'][$_POST['r_id']]['price'] = $row->rt_price;
                $_SESSION['MYBOOK']['room'][$_POST['r_id']]['type'] = $row->rt_name;
            } else {

                if (!isset($_SESSION['MYBOOK']['room'][$_POST['r_id']])) {
                    $_SESSION['MYBOOK']['room'][$_POST['r_id']]['price'] = $row->rt_price;
                    $_SESSION['MYBOOK']['room'][$_POST['r_id']]['type'] = $row->rt_name;
                } else {
                    http_response_code(412);
                    echo json_encode(['status' => 412, 'message' => "คุณจองห้องพัก $_POST[r_id] ไปแล้ว"]);
                }
            }

            foreach ($_SESSION['MYBOOK']['room'] as $room) {
                $cost += $room['price'];
            }

            $_SESSION['MYBOOK']['cost'] = number_format($cost, 2);

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => 'จองห้องพักสำเร็จ!']);
        } else {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => 'ไม่สามารถจองห้องพักได้ คุณต้องทำการเลือกช่วงเวลา เช็คอิน-เช็คเอาท์ ก่อน!']);
        }
    }
} else {
    http_response_code(405);
}
