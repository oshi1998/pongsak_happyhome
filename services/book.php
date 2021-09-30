<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");
    session_start();

    if ($_POST['action'] == 'checkin-checkout') {

        if (isset($_SESSION['MYBOOK'])) {
            unset($_SESSION['MYBOOK']);
        }

        $sql = "SELECT * FROM roomtypes WHERE rt_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['roomtype']]);
        $row = $stmt->fetchObject();

        $_SESSION['MYBOOK'] = array(
            "daterange" => $_POST['daterange'],
            "duration" => $_POST['duration'],
            "checkin" => $_POST['checkin'],
            "checkout" => $_POST['checkout'],
            "time" => $_POST['time'],
            "roomtype_id" => $row->rt_id,
            "roomtype_name" => $row->rt_name,
            "roomtype_price" => $row->rt_price,
            "total" => $row->rt_price * intval($_POST['duration']),
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

        $b_id = "b-" . uniqid();

        $sql = "INSERT INTO book (b_id,b_cus_username,b_daterange,b_duration,b_check_in,b_check_out,b_time,b_cost,b_rt_id,b_status)
        VALUES (:b_id,:cus_username,:daterange,:duration,:checkin,:checkout,:time,:cost,:rt_id,:status)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'b_id' => $b_id,
            'cus_username' => $_SESSION['USER_USERNAME'],
            'daterange' => $_SESSION['MYBOOK']['daterange'],
            'duration' => $_SESSION['MYBOOK']['duration'],
            'checkin' => $_SESSION['MYBOOK']['checkin'],
            'checkout' => $_SESSION['MYBOOK']['checkout'],
            'time' => $_SESSION['MYBOOK']['time'],
            'cost' => $_SESSION['MYBOOK']['total'],
            'rt_id' => $_SESSION['MYBOOK']['roomtype_id'],
            'status' => 'รอตรวจสอบ'
        ]);

        if ($result) {
            unset($_SESSION['MYBOOK']);
            $_SESSION['book_success'] = "การดำเนินการขอจองที่พักสำเร็จ หมายเลขของท่าน คือ $b_id ขณะนี้อยู่ระหว่างรอการตรวจสอบ";

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "ดำเนินการขอจองที่พักสำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => 'เกิดข้อผิดพลาด ไม่สามารถส่งคำร้องขอจองได้ กรุณาลองใหม่อีกครั้ง!']);
        }
    } else if ($_POST['action'] == 'getData') {
        $sql = "SELECT b_id,b_cus_username,cus_firstname,cus_lastname,b_daterange,b_duration,b_check_in,b_check_out,TIME_FORMAT(b_time, '%H:%i') as b_time ,b_cost,rt_name,rt_price,b_r_id,b_deposit_slip,b_deposit_datetime,b_bank_id,b_bank_name,b_bank_owner,b_status,b_check_in_datetime,b_check_out_datetime,b_date 
        FROM book,customers,roomtypes WHERE book.b_cus_username=customers.cus_username AND book.b_rt_id=roomtypes.rt_id AND b_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['b_id']]);
        $row1 = $stmt->fetchObject();

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "โหลดข้อมูลรายละเอียดการจอง $_POST[b_id] สำเร็จ", 'book' => $row1]);
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

        $sql = "UPDATE book SET b_bank_id=:bank_id,b_bank_name=:bank_name,b_bank_branch=:bank_branch,b_bank_owner=:bank_owner,b_deposit_slip=:slip,b_deposit_datetime=:datetime,b_status=:status,b_note=:note WHERE b_id=:b_id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'bank_id' => $_POST['bank_id'],
            'bank_name' => $_POST['bank_name'],
            'bank_branch' => $_POST['bank_branch'],
            'bank_owner' => $_POST['bank_owner'],
            'slip' => $slip,
            'datetime' => $_POST['deposit_datetime'],
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
            'status' => 'สำเร็จ',
            'note' => 'โปรดชำระอีก 50% วันที่เช็คอิน แล้วพบกัน ขอให้ท่านเดินทางมาโดยสวัสดิภาพ',
            'b_id' => $_POST['b_id']
        ]);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "ยอมรับการโอนค่ามัดจำ เลขจอง $_POST[b_id] สำเร็จ"]);
    } else if ($_POST['action'] == 'checkIn') {

        $sql = "UPDATE book SET b_status=:status,b_note=:note WHERE b_id=:b_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'status' => 'อยู่ระหว่างการเช็คอิน',
            'note' => '',
            'b_id' => $_POST['b_id']
        ]);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "เช็คอิน เลขจอง $_POST[b_id] สำเร็จ"]);
    } else if ($_POST['action'] == 'checkOut') {
        $sql = "UPDATE book SET b_status=:status,b_note=:note WHERE b_id=:b_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'status' => 'เช็คเอาท์เรียบร้อย',
            'note' => 'ขอขอบคุณที่ไว้วางใจเรา โอกาสหน้าเชิญใหม่ ขอให้ท่านเดินทางกลับบ้านโดยสวัสดิภาพ',
            'b_id' => $_POST['b_id']
        ]);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "เช็คเอาท์ เลขจอง $_POST[b_id] สำเร็จ"]);
    }
} else {
    http_response_code(405);
}
