<?php
include("work_picture_functions.php");

session_start();

check_session_id();
// ログインしてない人に画面見せないとき追加

check_is_admin();
//↑管理者ユーザ以外は入れないようにする  ※今回はis_adminが1番のユーザを管理者とする

if (
    !isset($_POST['aidi']) || $_POST['aidi'] === '' ||
    !isset($_POST['yuza']) || $_POST['yuza'] === '' ||
    !isset($_POST['pasu']) || $_POST['pasu'] === '' ||
    !isset($_POST['adomin']) || $_POST['adomin'] === ''

) {
    exit('paramError');
}

//⇒ここまでOK


$id = $_POST["aidi"];
$username = $_POST["yuza"];
$password = $_POST["pasu"];
$is_admin = $_POST["adomin"];



// var_dump($_POST["aidi"]);
// var_dump($_POST["yuza"]);
// var_dump($_POST["pasu"]);
// var_dump($_POST["adomin"]);
// exit();
//⇒string(1) "6" string(10) "testuser06" string(6) "666666" string(1) "0"
//⇒ここまでOK




$pdo = connect_to_db();

//☓$sql = "UPDATE session_login_users_table SET username=?, password=?, is_admin=?, updated_at=now() WHERE id=?";
// $sql = "UPDATE session_login_users_table SET username=:username,is_admin=:is_admin, updated_at=now() WHERE id=:id";
$sql = "UPDATE session_login_users_table SET username=:username,password=:password,is_admin=:is_admin, updated_at=now() WHERE id=:id";

// var_dump($sql);
// exit();
//⇒string(124) "UPDATE session_login_users_table SET username=:username,password=:password,is_admin=:is_admin, updated_at=now() WHERE id=:id"


$stmt = $pdo->prepare($sql);
// var_dump($stmt);
// exit();
//⇒object(PDOStatement)#2 (1) { ["queryString"]=> string(124) "UPDATE session_login_users_table SET username=:username,password=:password,is_admin=:is_admin, updated_at=now() WHERE id=:id" }


$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_INT);
//↑「INT」にせな。「STR」はエラー出る

$stmt->bindValue(':id', $id, PDO::PARAM_INT);




// ---------------------
// ちがう
// ------------
// $stmt->bindValue(1, $username, PDO::PARAM_STR);
// $stmt->bindValue(2, $password, PDO::PARAM_STR);
// $stmt->bindValue(3, $is_admin, PDO::PARAM_STR);
// $stmt->bindValue(4, $id, PDO::PARAM_INT);
// ---------------------
// ちがう
// ------------



try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:work_picture_admin.php");
exit();
