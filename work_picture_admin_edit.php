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
//⇒string(1) "2"




$pdo = connect_to_db();

$sql = 'SELECT * FROM session_login_users_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$record) {
    echo "No user found with that ID.";
    exit();
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB連携（ユーザ編集画面）</title>
</head>

<body>
    <h1>管理者ページ</h1>

    <form action="work_picture_admin_update.php" method="POST">
        <fieldset>
            <legend>DB連携（ユーザ編集画面）</legend>
            <a href="work_picture_admin.php">ユーザ一覧画面</a>
            <div>
                id: <input type="text" name="aidi" value="<?= $record["id"] ?>">
                <!-- ↑管理者ページなので、value="?= $record["id"] ?>"でid丸々出してて良い -->

            </div>
            <div>
                username: <input type="text" name="yuza" value="<?= $record["username"] ?>">
            </div>
            <div>
                password: <input type="text" name="pasu" value="<?= $record["password"] ?>">
            </div>
            <div>
                is_admin: <input type="text" name="adomin" value="<?= $record["is_admin"] ?>">
            </div>



            <div>
                <button>submit</button>
            </div>
            <!-- <input type="hidden" name="id" value="?= $record["id"] ?>"> -->
            <!-- ↑上でid丸々出してて、片方で良いのでこっちは消す -->

        </fieldset>
    </form>

</body>

</html>