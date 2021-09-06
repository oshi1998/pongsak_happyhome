<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('connect.php');

    session_start();

    if (empty($_FILES['cus_profile']['name'])) {
        $cus_profile = $_SESSION['USER_PROFILE'];
    } else {

        if ($_SESSION['USER_PROFILE'] != 'avatar_female.JPG' && $_SESSION['USER_PROFILE'] != 'avatar_male.JPG') {
            $delete_target = "../assets/img/customers/".$_SESSION['USER_PROFILE'];
            unlink($delete_target);
        }

        $type = strrchr($_FILES['cus_profile']['name'], '.');
        $cus_profile = $_SESSION['USER_USERNAME'] . $type;
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

    $_SESSION['USER_PROFILE'] = $cus_profile;

    http_response_code(200);
    echo json_encode(['status' => 200, 'message' => 'อัพเดตบัญชีสำเร็จ!']);
} else {
    http_response_code(405);
}
