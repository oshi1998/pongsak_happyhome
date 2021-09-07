<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type:application/json");
    require_once("connect.php");

    if ($_POST['action'] == "insert") {

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

                if ($_POST['cus_gender'] == 'ชาย') {
                    $profile = 'avatar_male.JPG';
                } else {
                    $profile = 'avatar_female.JPG';
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
                ]));


                http_response_code(200);
                echo json_encode(['status' => 200, 'message' => "เพิ่มลูกค้า $_POST[cus_username] สำเร็จ!"]);
            }
        }
    } else if ($_POST['action'] == 'update') {


        if (empty($_FILES['cus_profile']['name'])) {
            $cus_profile = $_POST['old_profile'];
        } else {

            if ($_POST['old_profile'] != 'avatar_female.JPG' && $_POST['old_profile'] != 'avatar_male.JPG') {
                $delete_target = "../assets/img/customers/" . $_POST['old_profile'];
                unlink($delete_target);
            }

            $type = strrchr($_FILES['cus_profile']['name'], '.');
            $cus_profile = $_POST['cus_username'] . $type;
            $save_target = "../assets/img/customers/" . $cus_profile;
            move_uploaded_file($_FILES['cus_profile']['tmp_name'], $save_target);
        }

        $sql = "UPDATE customers SET cus_firstname=:firstname,cus_lastname=:lastname,cus_email=:email,cus_address=:address,cus_phone=:phone,cus_profile=:profile WHERE cus_username=:username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'firstname' => $_POST['cus_firstname'],
            'lastname' => $_POST['cus_lastname'],
            'email' => $_POST['cus_email'],
            'address' => $_POST['cus_address'],
            'phone' => $_POST['cus_phone'],
            'username' => $_POST['cus_username'],
            'profile' => $cus_profile
        ]);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "อัพเดตลูกค้า $_POST[cus_username] สำเร็จ!"]);
    } else if ($_POST['action'] == 'enable') {

        session_start();

        $sql = "SELECT * FROM admins WHERE adm_username = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['USER_USERNAME']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if (!empty($row)) {
            if (password_verify($_POST['adm_password'], $row->adm_password)) {

                $sql = "UPDATE customers SET cus_active='Enable' WHERE cus_username=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$_POST['cus_username']]);

                http_response_code(200);
                echo json_encode(['status' => 200, 'message' => "เปิดใช้งานลูกค้า $_POST[cus_username] สำเร็จ!!"]);
            } else {
                http_response_code(401);
                echo json_encode(['status' => 401, 'message' => 'รหัสผ่านของคุณไม่ถูกต้อง']);
            }
        } else {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'รหัสผ่านของคุณไม่ถูกต้อง']);
        }
    } else if ($_POST['action'] == 'disable') {

        session_start();

        $sql = "SELECT * FROM admins WHERE adm_username = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['USER_USERNAME']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if (!empty($row)) {
            if (password_verify($_POST['adm_password'], $row->adm_password)) {

                $sql = "UPDATE customers SET cus_active='Disable' WHERE cus_username=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$_POST['cus_username']]);

                http_response_code(200);
                echo json_encode(['status' => 200, 'message' => "ปิดใช้งานลูกค้า $_POST[cus_username] สำเร็จ!!"]);
            } else {
                http_response_code(401);
                echo json_encode(['status' => 401, 'message' => 'รหัสผ่านของคุณไม่ถูกต้อง']);
            }
        } else {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'รหัสผ่านของคุณไม่ถูกต้อง']);
        }
    } else if ($_POST['action'] == 'getData') {

        $sql = "SELECT * FROM customers WHERE cus_username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['username']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => "โหลดข้อมูลลูกค้า $_POST[username] สำเร็จ!", 'data' => $row]);
    } else if ($_POST['action'] == 'changePassword') {

        session_start();

        $sql = "SELECT * FROM admins WHERE adm_username = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['USER_USERNAME']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if (!empty($row)) {
            if (password_verify($_POST['adm_password'], $row->adm_password)) {

                $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

                $sql = "UPDATE customers SET cus_password = ? WHERE cus_username = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([$new_password, $_POST['cus_username']]);

                http_response_code(200);
                echo json_encode(['status' => 200, 'message' => "เปลี่ยนรหัสผ่านลูกค้า $_POST[cus_username] สำเร็จ!!"]);
            } else {
                http_response_code(401);
                echo json_encode(['status' => 401, 'message' => 'รหัสผ่านของคุณไม่ถูกต้อง']);
            }
        } else {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'รหัสผ่านของคุณไม่ถูกต้อง']);
        }
    } else if ($_POST['action'] == 'check_cus_username') {

        $sql = "SELECT * FROM customers WHERE cus_firstname = ? AND cus_lastname = ? AND cus_username=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['firstname'], $_POST['lastname'], $_POST['username']]);
        $row = $stmt->fetchAll();

        session_start();

        if (!empty($row)) {

            $_SESSION['forgot_pass_active'] = TRUE;

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "ยืนยันตัวตนสำเร็จ สามารถดำเนินการเปลี่ยนรหัสผ่านได้"]);
        } else {

            $_SESSION['forgot_pass_active'] = FALSE;
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'ข้อมูลชื่อผู้ใช้งาน และ ชื่อ-นามสกุล ไม่มีอยู่ในระบบ!!']);
        }
    } else if ($_POST['action'] == 'reset_password') {
        session_start();

        if(isset($_SESSION['forgot_pass_active']) && $_SESSION['forgot_pass_active']==TRUE){

            $new_password = password_hash($_POST['new_password'],PASSWORD_DEFAULT);

            $sql = "UPDATE customers SET cus_password=:password WHERE cus_username=:username";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'password' => $new_password,
                'username' => $_POST['cus_username']
            ]);

            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => "รีเซ็ทรหัสผ่าน $_POST[cus_username] สำเร็จ!!"]);
        }else {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'คุณต้องยืนยันตัวตนก่อน ทำการเปลี่ยนรหัสผ่านใหม่']);
        }
    } else {
        http_response_code(405);
    }
} else {
    http_response_code(405);
}
