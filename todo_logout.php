<?php


// 毎回３手順

include("functions.php");

session_start();
//session_start();使うときinclude("functions.php");必要


check_session_id();
// ログインした人しか画面見せないとき追加
//check_session_id();使うときinclude("functions.php");必要



$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();
header('Location:todo_login.php');
exit();
