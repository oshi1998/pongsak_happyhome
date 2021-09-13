<?php

session_start();

if ($_FILES['file']['tmp_name'] && isset($_SESSION['mrt_id'])) {

    require_once('connect.php');
    
    $ext = end(explode(".", $_FILES['file']['name']));
    $filename = uniqid() . "." . $ext;
    $img_path = $_SERVER['DOCUMENT_ROOT']."/pongsak_happyhome/assets/img/roomtypes/other/" . $filename;

    try {
        move_uploaded_file($_FILES['file']['tmp_name'],$img_path);

        $sql = "INSERT INTO images (file_name,rt_id) VALUES (:name,:id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $filename,
            'id' => $_SESSION['mrt_id']
        ]);
    } catch (Exception $err) {
        // Handle errors
        echo $err->getMessage();
    }
}
