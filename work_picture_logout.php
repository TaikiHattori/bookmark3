<?php


// 毎回３手順

include("work_picture_functions.php");

session_start();
//session_start();使うときinclude("functions.php");必要


check_session_id();
// ログインした人しか画面見せないとき追加
//check_session_id();使うときinclude("functions.php");必要





// 指定したsession変数の削除  ※講義のを俺がメモした分にはここ書いてなかった
// unset($_SESSION[key]);


$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
//↑なぜ42000かは解明されていない

}
session_destroy();
header('Location:work_picture_login.php');
exit();
