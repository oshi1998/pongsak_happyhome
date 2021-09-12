<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");

    if ($_POST['action'] == "insert") {

        $sql = "SELECT MAX(sv_no) as last_no FROM services";
        $stmt = $pdo->query($sql);
        $row = $stmt->fetchObject();

        if (empty($row)) {
            $sv_no = 1;
        } else {
            $sv_no = intval($row->last_no) + 1;
        }

        $sql = "INSERT INTO services (sv_no,sv_icon,sv_heading,sv_desc) VALUES (:no,:icon,:heading,:desc)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'no' => $sv_no,
            'icon' => $_POST['sv_icon'],
            'heading' => $_POST['sv_heading'],
            'desc' => $_POST['sv_desc']
        ]);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "เพิ่มบริการ $_POST[sv_heading] สำเร็จ!"]);
    } else if ($_POST['action'] == 'update') {

        $sql = "UPDATE services SET sv_icon=:icon,sv_heading=:heading,sv_desc=:desc WHERE sv_id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $_POST['sv_id'],
            'icon' => $_POST['sv_icon'],
            'heading' => $_POST['sv_heading'],
            'desc' => $_POST['sv_desc']
        ]);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "อัพเดตบริการ $_POST[sv_id] สำเร็จ!"]);
    } else if ($_POST['action'] == 'delete') {

        $sql = "DELETE FROM services WHERE sv_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['id']]);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "ลบบริการ $_POST[id] สำเร็จ"]);
    } else if ($_POST['action'] == 'getData') {

        $sql = "SELECT * FROM services WHERE sv_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['id']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "โหลดข้อมูลบริการ $_POST[id] สำเร็จ!", 'data' => $row]);
    } else if ($_POST['action'] == 'changeNo') {

        $sql = "UPDATE services SET sv_no = '$_POST[old_no]' WHERE sv_no = '$_POST[new_no]'";
        $stmt = $pdo->query($sql);

        $sql = "UPDATE services SET sv_no = '$_POST[new_no]' WHERE sv_id = '$_POST[id]'";
        $stmt = $pdo->query($sql);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "เปลี่ยนลำดับการแสดงผลสำเร็จ"]);
    } else {
        http_response_code(405);
    }
} else {
    http_response_code(405);
}
