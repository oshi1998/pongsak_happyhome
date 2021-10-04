<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") { //เช็ครีเควสจากฝั่ง Client ที่ส่งมาว่าเป็น POST หรือไม่?

    header("Content-Type:application/json"); //ตั้ง header content-type เป็น application/json
    require_once('connect.php'); //include ไฟล์ connect.php สำหรับติดต่อฐานข้อมูล

    /* เช็คค่าในตัวแปร $_POST[cus_username] ว่ามีค่าตามเงื่อนไขดังกล่าวหรือเปล่า ถ้ามีให้แจ้งเตือนกลับไปหา Client */
    if (str_contains($_POST['cus_username'], 'admin') || str_contains($_POST['cus_username'], 'owner') || str_contains($_POST['cus_username'], 'founder')) {
        http_response_code(412);
        echo json_encode(['status' => 412, 'message' => "ไม่สามารถใช้ชื่อ $_POST[cus_username] ได้ กรุณาเปลี่ยนใหม่"]);
    } else {
        $sql = "SELECT cus_username FROM customers WHERE cus_username=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['cus_username']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if (!empty($row)) {
            http_response_code(412);
            echo json_encode(['status' => 412, 'message' => "ชื่อผู้ใช้งาน $_POST[cus_username] ถูกใช้งานแล้ว กรุณาเปลี่ยนใหม่"]);
        } else {

            $sql = "SELECT adm_username FROM admins WHERE adm_username=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['cus_username']]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if (!empty($row)) {
                http_response_code(412);
                echo json_encode(['status' => 412, 'message' => "ชื่อผู้ใช้งาน $_POST[cus_username] ถูกใช้งานแล้ว กรุณาเปลี่ยนใหม่"]);
            } else {
                $password = password_hash($_POST['cus_password'], PASSWORD_DEFAULT);

                if($_POST['cus_gender']=='ชาย'){ 
                    $profile = 'avatar_male.JPG'; //เพศชายใช้ไฟล์ภาพ avatar_male.jpg
                }else{
                    $profile = 'avatar_female.JPG'; //เพศหญิงใช้ไฟล์ภาพ avatar_female.jpg
                }

                $sql = "INSERT INTO customers (cus_username,cus_password,cus_firstname,cus_lastname,cus_gender,cus_email,cus_address,cus_phone,cus_profile) VALUES (:username,:password,:firstname,:lastname,:gender,:email,:address,:phone,:profile)";
                $stmt = $pdo->prepare($sql);

                if ($stmt->execute([
                    'username' => $_POST['cus_username'],
                    'password' => $password,
                    'firstname' => $_POST['cus_firstname'],
                    'lastname' => $_POST['cus_lastname'],
                    'gender' => $_POST['cus_gender'],
                    'email' => $_POST['cus_email'],
                    'address' => $_POST['cus_address'],
                    'phone' => $_POST['cus_phone'],
                    'profile' => $profile
                ])) {

                    session_start();
                    $_SESSION['USER_LOGIN'] = true;
                    $_SESSION['USER_USERNAME'] = $_POST['cus_username'];
                    $_SESSION['USER_NAME'] = $_POST['cus_firstname']." ".$_POST['cus_lastname'];
                    $_SESSION['USER_PROFILE'] = $profile;
                    $_SESSION['USER_ROLE'] = "CUSTOMER";

                    http_response_code(200);
                    echo json_encode(['status' => 200, 'message' => 'สมัครสมาชิกสำเร็จ']);
                } else {
                    http_response_code(412);
                    echo json_encode(['status' => 412, 'message' => 'สมัครสมาชิกไม่สำเร็จ เนื่องจากข้อมูลไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง']);
                }
            }
        }
    }
} else {
    http_response_code(405);
}
