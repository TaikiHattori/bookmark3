<?php
include("work_picture_functions.php");



session_start();
check_session_id();
// ログインした人しか画面見せないとき追加


if (
    !isset($_POST['taitoru']) || $_POST['taitoru'] === '' ||
    !isset($_FILES['gazou']) || $_FILES['gazou'] === '' ||

    !isset($_POST['level']) || $_POST['level'] === ''
) {
    exit('入力されていません');
}

$taitoru = $_POST['taitoru'];
$gazou = $_FILES['gazou'];

$level = $_POST['level'];

// var_dump($taitoru);
// exit();
//⇒string(18) "ロックダンス"
// var_dump($gazou);
// exit();
//⇒array(6) { ["name"]=> string(22) "ロックダンス.jpg" ["full_path"]=> string(22) "ロックダンス.jpg" ["type"]=> string(10) "image/jpeg" ["tmp_name"]=> string(52) "C:\Users\Taiki Hattori\Desktop\xampp\tmp\php594E.tmp" ["error"]=> int(0) ["size"]=> int(90690) }

// var_dump($level);
// exit();
//⇒string(2) "81"※ちゃんとスライドバーの値取れてる



// DB接続
$pdo = connect_to_db();


// ---------------------
// 画像保存
// ----------------


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
} else {
    // 画像を保存
    if (!empty($_FILES['gazou']['name'])) {

        $name = $_FILES['gazou']['name'];
        $type = $_FILES['gazou']['type'];

        // 1文丸々or拡張子のみDBに入れるかは好み
        //カラム追加
        // ⇒そうしないとバイナリ形式だと拡張子が何なのかわからない
        // read.phpファイルで$img = "data:image/jpeg;base64," . base64_encode($record["picture"]);に関わる話

        // var_dump($type);
        // exit();

        $content = file_get_contents($_FILES['gazou']['tmp_name']);
        $size = $_FILES['gazou']['size'];

        $sql = 'INSERT INTO session_login_table(id, title, picture,picture_type,level, created_at, updated_at,deleted_at) VALUES(NULL, :title, :picture,:picture_type,:level, now(), now(),now())';

        $stmt = $pdo->prepare($sql);

        //テキスト
        $stmt->bindValue(':title', $taitoru, PDO::PARAM_STR);
        // 画像データをバイナリ形式でデータベースに挿入
        $stmt->bindValue(':picture', file_get_contents($_FILES['gazou']['tmp_name']), PDO::PARAM_LOB);
        $stmt->bindValue(':picture_type', $type, PDO::PARAM_STR);

        $stmt->bindValue(':level', $level, PDO::PARAM_STR);


        try {
            $status = $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(["sql error" => "{$e->getMessage()}"]);
            exit();
        }
    }
}



header("Location:work_picture_input.php");
exit();
