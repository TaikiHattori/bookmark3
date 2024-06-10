<?php
include("work_picture_functions.php");

session_start();
check_session_id();
// ログインした人しか画面見せないとき追加




// 以下、create.phpと似ている
// 入力項目のチェック  入力ちゃんとできてるか
if (
    !isset($_POST['taitoru']) || $_POST['taitoru'] === '' ||

    !isset($_FILES['gazou']) || $_FILES['gazou'] === '' ||
    //$_FILES['gazou']['error'] !== UPLOAD_ERR_OK || // ファイルが正しくアップロードされているかを確認

    !isset($_POST['suraida']) || $_POST['suraida'] === '' ||
    !isset($_POST['id']) || $_POST['id'] === ''

) {
    exit('paramError');
}
// echo"編集項目チェックOK";
//⇒ここまでOK


//入力ちゃんとできてるなら、POSTで受け取る
$taitoru = $_POST['taitoru'];
$gazou = $_FILES['gazou'];

// $gazou_taipu = $_POST['gazou_taipu'];
$suraida = $_POST['suraida'];
$id = $_POST['id'];
// var_dump($taitoru);
// exit();
//⇒string(21) "クランプダンス"
// var_dump($gazou);
// exit();
//⇒array(6) { ["name"]=> string(25) "クランプダンス.jpg" ["full_path"]=> string(25) "クランプダンス.jpg" ["type"]=> string(10) "image/jpeg" ["tmp_name"]=> string(52) "C:\Users\Taiki Hattori\Desktop\xampp\tmp\php1AE4.tmp" ["error"]=> int(0) ["size"]=> int(89762) }

// var_dump($suraida);
// exit();
//⇒string(2) "42"

// var_dump($id);
// exit();
//⇒string(1) "2"



// DB接続  関数使って
$pdo = connect_to_db();




// SQL実行

$sql = 'UPDATE session_login_table SET title=:title, picture=:picture,level=:level,  updated_at=now() WHERE id=:id';
// ↑WHEREで条件設定しないと、更新かけた時にカラム内のデータ全てが
//同じ名前に更新されるみたいなことが起きてしまう！！！！！！！！！




$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $taitoru, PDO::PARAM_STR);
// 画像データをバイナリ形式でデータベースに挿入
$stmt->bindValue(':picture', file_get_contents($_FILES['gazou']['tmp_name']), PDO::PARAM_LOB);

// $stmt->bindValue(':picture_type', $gazou_taipu, PDO::PARAM_STR);

$stmt->bindValue(':level', $suraida, PDO::PARAM_INT);
//↑PDO::PARAM_「INT」にせな。「STR」だとエラー出る

$stmt->bindValue(':id', $id, PDO::PARAM_STR);



try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:work_picture_read.php");
exit();
// ⇒ここまでOK
