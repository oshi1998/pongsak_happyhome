<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");

    if ($_POST['action'] == "insert") {

        $sql = "SELECT rt_name FROM roomtypes WHERE rt_name= ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['rt_name']]);
        $row = $stmt->fetchAll();

        if (!empty($row)) {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "ชื่อประเภทห้องพักซ้ำ! $_POST[rt_name] มีอยู่แล้ว"]);
        } else {

            $type = strrchr($_FILES['rt_image']['name'], '.');
            $rt_image = md5(microtime()) . $type;
            $save_target = "../assets/img/roomtypes/" . $rt_image;
            move_uploaded_file($_FILES['rt_image']['tmp_name'], $save_target);

            $rt_view = rand(999, 5999);

            $sql = "INSERT INTO roomtypes (rt_name,rt_image,rt_view,rt_content,rt_price) 
            VALUES (:name,:image,:view,:content,:price)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'name' => $_POST['rt_name'],
                'image' => $rt_image,
                'view' => $rt_view,
                'content' => $_POST['rt_content'],
                'price' => $_POST['rt_price']
            ]);


            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "เพิ่มประเภทห้องพัก $_POST[rt_name] สำเร็จ!"]);
        }
    } else if ($_POST['action'] == 'update') {

        $sql = "SELECT rt_name FROM roomtypes WHERE rt_name= ? AND rt_id!= ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['rt_name'], $_POST['rt_id']]);
        $row = $stmt->fetchAll();

        if (!empty($row)) {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "ชื่อประเภทห้องพักซ้ำ! $_POST[rt_name] มีอยู่แล้ว"]);
        } else {

            if (empty($_FILES['rt_image']['name'])) {
                $rt_image = $_POST['old_image'];
            } else {

                $delete_target = "../assets/img/roomtypes/" . $_POST['old_image'];
                unlink($delete_target);

                $type = strrchr($_FILES['rt_image']['name'], '.');
                $rt_image = md5(microtime()) . $type;
                $save_target = "../assets/img/roomtypes/" . $rt_image;
                move_uploaded_file($_FILES['rt_image']['tmp_name'], $save_target);
            }

            $sql = "UPDATE roomtypes SET rt_name=:name,rt_content=:content,rt_price=:price,rt_image=:image WHERE rt_id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'name' => $_POST['rt_name'],
                'content' => $_POST['rt_content'],
                'price' => $_POST['rt_price'],
                'image' => $rt_image,
                'id' => $_POST['rt_id']
            ]);

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "อัพเดตประเภทห้องพัก $_POST[rt_id] สำเร็จ!"]);
        }
    } else if ($_POST['action'] == 'delete') {

        $sql = "SELECT r_id FROM rooms WHERE rt_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['id']]);
        $parent_row = $stmt->fetchAll();

        if (empty($parent_row)) {

            $sql = "SELECT rt_image FROM roomtypes WHERE rt_id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['id']]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            $rt_image = $row->rt_image;

            $sql = "DELETE FROM roomtypes WHERE rt_id = ?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$_POST['id']]);

            if ($result) {

                $delete_target = "../assets/img/roomtypes/" . $rt_image;
                unlink($delete_target);

                http_response_code(200);
                echo json_encode(['status' => 200, 'message' => "ลบประเภทห้องพัก $_POST[id] สำเร็จ"]);
            } else {
                http_response_code(412);
                echo json_encode(['status' => 412, 'message' => "เกิดข้อผิดพลาด ไม่สามารถลบข้อมูลได้!"]);
            }
        } else {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "ไม่สามารถลบได้ เนื่องจากประเภทห้องพัก $_POST[id] มีรายชื่อห้องอยู่"]);
        }
    } else if ($_POST['action'] == 'getData') {

        $sql = "SELECT * FROM roomtypes WHERE rt_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['id']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "โหลดข้อมูลประเภทที่พัก $_POST[id] สำเร็จ!", 'data' => $row]);
    } else if ($_POST['action'] == 'removeImage') {

        $sql = "DELETE FROM images WHERE file_name = '$_POST[file_name]'";
        $result = $pdo->exec($sql);

        if ($result > 0) {
            $delete_target = "../assets/img/roomtypes/other/" . $_POST['file_name'];
            unlink($delete_target);

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "ลบรูปภาพ $_POST[file_name] สำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "ลบรูปภาพไม่สำเร็จ"]);
        }
    } else {
        http_response_code(405);
    }
} else {
    http_response_code(405);
}
