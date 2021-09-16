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
    } else if ($_POST['action'] == 'booking') {
        $b_id = "b-" . substr(uniqid(), 0, 6);

        $sql = "INSERT INTO book (b_id,b_cus_username,b_daterange,b_duration,b_check_in,b_check_out,b_time,b_qty,b_cost,b_status)
        VALUES (:b_id,:cus_username,:daterange,:duration,:checkin,:checkout,:time,:qty,:cost,:status)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'b_id' => $b_id,
            'cus_username' => $_SESSION['USER_USERNAME'],
            'daterange' => $_SESSION['MYBOOK']['daterange'],
            'duration' => $_SESSION['MYBOOK']['duration'],
            'checkin' => $_SESSION['MYBOOK']['checkin'],
            'checkout' => $_SESSION['MYBOOK']['checkout'],
            'time' => $_SESSION['MYBOOK']['time'],
            'qty' => count($_SESSION['MYBOOK']['room']),
            'cost' => number_format($_SESSION['MYBOOK']['cost'] * $_SESSION['MYBOOK']['duration'], 2),
            'status' => 'รอตรวจสอบ'
        ]);

        if ($result) {

            $count_query = 0;

            foreach ($_SESSION['MYBOOK']['room'] as $keys => $value) {
                $sql = "INSERT INTO book_detail (bd_b_id,bd_r_id) VALUES (:b_id,:r_id)";
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([
                    'b_id' => $b_id,
                    'r_id' => $keys
                ]);

                if ($result) {
                    $count_query += 1;
                }
            }

            if ($count_query == count($_SESSION['MYBOOK']['room'])) {
                unset($_SESSION['MYBOOK']);
                $_SESSION['book_success'] = "การดำเนินการขอจองที่พักสำเร็จ หมายเลขของท่าน คือ $b_id ขณะนี้อยู่ระหว่างรอการตรวจสอบ";
                http_response_code(200);
                echo json_encode(['status'=>200,'message'=>"ดำเนินการขอจองที่พักสำเร็จ"]);
            } else {

                $sql = "DELETE FROM book WHERE b_id = '$b_id'";
                $response = $pdo->exec($sql);

                http_response_code(412);
                echo json_encode(['status' => 412, 'message' => 'เกิดข้อผิดพลาด ไม่สามารถส่งคำร้องขอจองได้ กรุณาลองใหม่อีกครั้ง!']);
            }
        } else {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => 'เกิดข้อผิดพลาด ไม่สามารถส่งคำร้องขอจองได้ กรุณาลองใหม่อีกครั้ง!']);
        }
    }
} else {
    http_response_code(405);
}
