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

            $_SESSION['MYBOOK']['cost'] = floatval($cost);

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => 'จองห้องพักสำเร็จ!']);
        } else {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => 'ไม่สามารถจองห้องพักได้ คุณต้องทำการเลือกช่วงเวลา เช็คอิน-เช็คเอาท์ ก่อน!']);
        }
    } else if ($_POST['action'] == 'removeBook') {
        if (isset($_SESSION['MYBOOK']['room'][$_POST['r_id']])) {
            $cost = 0;

            unset($_SESSION['MYBOOK']['room'][$_POST['r_id']]);

            foreach ($_SESSION['MYBOOK']['room'] as $room) {
                $cost += $room['price'];
            }

            $_SESSION['MYBOOK']['cost'] = number_format($cost, 2);

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "ลบห้องหมายเลข $_POST[r_id] ออกจากรายการจองสำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "ลบไม่สำเร็จ กรุณาลองใหม่อีกครั้ง"]);
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
            'cost' => $_SESSION['MYBOOK']['cost'] * $_SESSION['MYBOOK']['duration'],
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
                echo json_encode(['status' => 200, 'message' => "ดำเนินการขอจองที่พักสำเร็จ"]);
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
    } else if ($_POST['action'] == 'getData') {
        $sql = "SELECT b_id,b_cus_username,cus_firstname,cus_lastname,b_daterange,b_duration,b_check_in,b_check_out,TIME_FORMAT(b_time, '%H:%i') as b_time ,b_qty,b_cost,b_deposit_slip,b_deposit_datetime,b_bank_id,b_bank_name,b_bank_owner,b_status,b_check_in_datetime,b_check_out_datetime,b_date 
        FROM book,customers WHERE book.b_cus_username=customers.cus_username AND b_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['b_id']]);
        $row1 = $stmt->fetchObject();

        $sql = "SELECT r_id,rt_name,rt_price FROM book_detail,rooms,roomtypes WHERE book_detail.bd_r_id=rooms.r_id AND rooms.rt_id=roomtypes.rt_id AND book_detail.bd_b_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['b_id']]);
        $row2 = $stmt->fetchAll();

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "โหลดข้อมูลรายละเอียดการจอง $_POST[b_id] สำเร็จ", 'book' => $row1, 'book_detail' => $row2]);
    } else if ($_POST['action'] == 'approve') {

        $sql = "UPDATE book SET b_status=:status,b_note=:note WHERE b_id=:b_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'status' => 'รอชำระค่ามัดจำ',
            'note' => 'กรุณาชำระค่ามัดจำ 50% ก่อนถึงกำหนดการเช็คอิน มิเช่นนั้นรายการจองของท่านจะถูกยกเลิก',
            'b_id' => $_POST['b_id']
        ]);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "อนุมัติหมายเลขจอง $_POST[b_id] สำเร็จ"]);
    } else if ($_POST['action'] == 'disApprove') {

        $sql = "UPDATE book SET b_status=:status,b_note=:note WHERE b_id=:b_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'status' => 'ไม่อนุมัติ',
            'note' => $_POST['b_note'],
            'b_id' => $_POST['b_id']
        ]);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "ไม่อนุมัติหมายเลขจอง $_POST[b_id] สำเร็จ"]);
    } else if ($_POST['action'] == 'deposit') {

        $type = strrchr($_FILES['deposit_slip']['name'], '.');
        $slip = $_POST['b_id'] . $type;
        $save_target = "../assets/img/slip/" . $slip;
        move_uploaded_file($_FILES['deposit_slip']['tmp_name'], $save_target);

        $sql = "UPDATE book SET b_bank_id=:bank_id,b_bank_name=:bank_name,b_bank_branch=:bank_branch,b_bank_owner=:bank_owner,b_deposit_slip=:slip,b_status=:status,b_note=:note WHERE b_id=:b_id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'bank_id' => $_POST['bank_id'],
            'bank_name' => $_POST['bank_name'],
            'bank_branch' => $_POST['bank_branch'],
            'bank_owner' => $_POST['bank_owner'],
            'slip' => $slip,
            'status' => "รอตรวจสอบการชำระค่ามัดจำ",
            'b_id' => $_POST['b_id'],
            'note' => "รอแอดมินตรวจสอบหลักฐานการโอนเงิน"
        ]);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "แจ้งชำระค่ามัดจำ $_POST[b_id] สำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "แจ้งชำระค่ามัดจำ $_POST[b_id] ไม่สำเร็จ"]);
        }
    } else if ($_POST['action'] == 'accept') {

        $sql = "UPDATE book SET b_status=:status,b_note=:note WHERE b_id=:b_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'status' => 'รอเช็คอิน',
            'note' => 'โปรดชำระอีก 50% วันที่เช็คอิน แล้วพบกัน ขอให้ท่านเดินทางมาโดยสวัสดิภาพ',
            'b_id' => $_POST['b_id']
        ]);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "ยอมรับการโอนค่ามัดจำ เลขจอง $_POST[b_id] สำเร็จ"]);
    }
} else {
    http_response_code(405);
}
