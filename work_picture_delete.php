<?php
include("work_picture_functions.php");


session_start();
check_session_id();
// ログインした人しか画面見せないとき追加



$id = $_GET["id"];

$pdo = connect_to_db();

$sql = "DELETE FROM session_login_table WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:work_picture_read.php");
exit();
