<?php

function connect_to_db()
{
    $dbn = 'mysql:dbname=gs_l10_01_work;charset=utf8mb4;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';

    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
}

// ログイン状態のチェックをする関数  ここfunctions.phpに書くと複数画面でチェックが使える
function check_session_id()
{
    if (!isset($_SESSION["session_id"]) || $_SESSION["session_id"] !== session_id()) {
        header('Location:work_picture_login.php');
        exit();
    } else {
        session_regenerate_id(true);
        $_SESSION["session_id"] = session_id();
    }
}




//管理者ユーザだけ入れるページ作りための関数
function check_is_admin()
{
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
        header('Location:work_picture_read.php');
        exit();
    }
}
