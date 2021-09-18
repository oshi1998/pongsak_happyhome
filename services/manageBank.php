<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");

    if ($_POST['action'] == "insert") {

        $sql = "SELECT bank_id FROM banks WHERE bank_id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['bank_id']]);
        $row = $stmt->fetchAll();

        if (!empty($row)) {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "เลขบัญชีธนาคารซ้ำ!! $_POST[bank_id] มีอยู่แล้ว"]);
        } else {

            $type = strrchr($_FILES['bank_img']['name'], '.');
            $bank_img = uniqid() . $type;
            $save_target = "../assets/img/banks/" . $bank_img;
            move_uploaded_file($_FILES['bank_img']['tmp_name'], $save_target);

            $sql = "INSERT INTO banks (bank_id,bank_name,bank_owner,bank_img) VALUES (:id,:name,:owner,:img)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id' => $_POST['bank_id'],
                'name' => $_POST['bank_name'],
                'owner' => $_POST['bank_owner'],
                'img' => $bank_img
            ]);

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "เพิ่มบัญชีธนาคาร $_POST[bank_id] สำเร็จ!"]);
        }
    } else if ($_POST['action'] == 'update') {

        $row = "";

        if ($_POST['old_id'] != $_POST['bank_id']) {
            $sql = "SELECT bank_id FROM banks WHERE bank_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['bank_id']]);
            $row = $stmt->fetchAll();
        }

        if (!empty($row)) {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "เลขบัญชีธนาคารซ้ำ!! $_POST[bank_id] มีอยู่แล้ว"]);
        } else {

            if (empty($_FILES['bank_img']['name'])) {
                $bank_img = $_POST['old_image'];
            } else {

                $delete_target = "../assets/img/banks/" . $_POST['old_image'];
                unlink($delete_target);

                $type = strrchr($_FILES['bank_img']['name'], '.');
                $bank_img = uniqid() . $type;
                $save_target = "../assets/img/banks/" . $bank_img;
                move_uploaded_file($_FILES['bank_img']['tmp_name'], $save_target);
            }

            $sql = "UPDATE banks SET bank_id=:id,bank_name=:name,bank_owner=:owner,bank_img=:img WHERE bank_id=:old_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id' => $_POST['bank_id'],
                'name' => $_POST['bank_name'],
                'owner' => $_POST['bank_owner'],
                'img' => $bank_img,
                'old_id' => $_POST['old_id']
            ]);

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "อัพเดตบัญชีธนาคาร $_POST[bank_id] สำเร็จ!"]);
        }
    } else if ($_POST['action'] == 'delete') {

        $sql = "SELECT bank_img FROM banks WHERE bank_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['id']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        $bank_img = $row->bank_img;

        $sql = "DELETE FROM banks WHERE bank_id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$_POST['id']]);

        if ($result) {

            $delete_target = "../assets/img/banks/" . $bank_img;
            unlink($delete_target);

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "ลบบัญชีธนาคาร $_POST[id] สำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "เกิดข้อผิดพลาด ไม่สามารถลบข้อมูลได้!"]);
        }
    } else if ($_POST['action'] == 'getData') {

        $sql = "SELECT * FROM banks WHERE bank_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['id']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "โหลดข้อมูลบัญชีธนาคาร $_POST[id] สำเร็จ!", 'data' => $row]);
    } else {
        http_response_code(405);
    }
} else {
    http_response_code(405);
}
