<?php
include("work_picture_functions.php");


session_start();

check_session_id();
// ログインしてない人に画面見せないとき追加


check_is_admin();
//↑管理者ユーザ以外は入れないようにする  ※今回はis_adminが1番のユーザを管理者とする



$id = $_GET["id"];
// var_dump($id);
// exit();
//⇒string(1) "5"

$pdo = connect_to_db();

$sql = "DELETE FROM session_login_users_table WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:work_picture_admin.php");
exit();
