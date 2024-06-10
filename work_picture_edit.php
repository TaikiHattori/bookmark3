<?php
include("work_picture_functions.php");


session_start();
check_session_id();
// ログインした人しか画面見せないとき追加



$id = $_GET["id"];

$pdo = connect_to_db();

$sql = 'SELECT * FROM session_login_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);


//取得した画像バイナリデータをbase64で変換。
$img = "data:image/jpeg;base64," . base64_encode($record["picture"]);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB連携（編集画面）</title>
</head>

<body>
    <form action="work_picture_update.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>DB連携（編集画面）</legend>
            <a href="work_picture_read.php">一覧画面</a>
            <div>
                title: <input type="text" name="taitoru" value="<?= $record['title'] ?>">
            </div>
            <div>
                picture: <img src="<?= $img ?>" alt="画像">
                画像を選択:<input type="file" name="gazou">
                <!-- inputのtypeがfileの場合、valueにファイルパス指定できないというルールがある -->

            </div>

            <!-- <div>
                picture_type: <input type="text" name="gazou_taipu" value="?= $record['picture_type'] ?>">
            </div> -->

            <div>
                <input type="range" min="0" max="100" name="suraida" value="<?= $record["level"] ?>" class="slider"><!--初期値を0に設定 -->
            </div>


            <div>
                <input type="hidden" name="id" value="<?= $record['id'] ?>">
            </div>


            <div>
                <button>編集する</button>
            </div>
        </fieldset>
    </form>

</body>

</html>