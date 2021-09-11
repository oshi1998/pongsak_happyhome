<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('connect.php');

    if (empty($_FILES['welcome_img']['name'])) {
        $welcome_img = $_POST['old_image'];
    } else {

        if ($_POST['old_image'] != '' && $_POST['old_image'] != null) {
            $delete_target = "../assets/img/" . $_POST['old_image'];
            unlink($delete_target);
        }

        $type = strrchr($_FILES['welcome_img']['name'], '.');
        $welcome_img = md5(microtime()) . $type;
        $save_target = "../assets/img/" . $welcome_img;
        move_uploaded_file($_FILES['welcome_img']['tmp_name'], $save_target);
    }

    $sql = "UPDATE welcome SET welcome_head=:head,welcome_desc=:desc,welcome_img=:img";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'head' => $_POST['welcome_head'],
        'desc' => $_POST['welcome_desc'],
        'img' => $welcome_img,
    ]);

    http_response_code(200);
    echo json_encode(['status' => 200, 'message' => 'อัพเดตข้อมูลส่วนข้อความต้อนรับหน้าเว็บสำเร็จ!']);
} else {
    http_response_code(405);
}
