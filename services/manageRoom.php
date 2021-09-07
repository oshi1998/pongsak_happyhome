<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");

    if ($_POST['action'] == "insert") {

        $sql = "SELECT r_id FROM rooms WHERE r_id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['r_id']]);
        $row = $stmt->fetchAll();

        if (!empty($row)) {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "ห้องพักซ้ำ!! ห้องพัก $_POST[r_id] มีอยู่แล้ว"]);
        } else {
            $sql = "INSERT INTO rooms (r_id,rt_id) VALUES (:r_id,:rt_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'r_id' => $_POST['r_id'],
                'rt_id' => $_POST['rt_id']
            ]);

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "เพิ่มห้องพัก $_POST[r_id] สำเร็จ!"]);
        }
    } else if ($_POST['action'] == 'update') {

        $sql = "UPDATE rooms SET rt_id=:rt_id WHERE r_id=:r_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'rt_id' => $_POST['rt_id'],
            'r_id' => $_POST['r_id']
        ]);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "อัพเดตห้องพัก $_POST[r_id] สำเร็จ!"]);
    } else if ($_POST['action'] == 'delete') {

        $sql = "DELETE FROM rooms WHERE r_id=?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$_POST['id']]);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "ลบห้องพัก $_POST[id] สำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "ไม่สามารถลบได้เนื่องจากห้องพักมีการใช้งานแล้ว"]);
        }
    } else if ($_POST['action'] == 'getData') {

        $sql = "SELECT * FROM rooms WHERE r_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['id']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "โหลดข้อมูลห้องพัก $_POST[id] สำเร็จ!", 'data' => $row]);
    } else {
        http_response_code(405);
    }
} else {
    http_response_code(405);
}
