<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('connect.php');

    if (empty($_FILES['image']['name'])) {
        $image = $_POST['old_image'];
    } else {

        if ($_POST['old_image'] != '' && $_POST['old_image'] != null) {
            $delete_target = "../assets/img/" . $_POST['old_image'];
            unlink($delete_target);
        }

        $type = strrchr($_FILES['image']['name'], '.');
        $image = md5(microtime()) . $type;
        $save_target = "../assets/img/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $save_target);
    }

    $sql = "UPDATE aboutus SET aboutus_content=:content,aboutus_image=:img";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'content' => $_POST['content'],
        'img' => $image
    ]);

    http_response_code(200);
    echo json_encode(['status' => 200, 'message' => 'อัพเดตข้อมูลส่วนเกี่ยวกับเราหน้าเว็บสำเร็จ!']);
} else {
    http_response_code(405);
}
