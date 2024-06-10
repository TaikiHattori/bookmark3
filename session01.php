<?php
// session変数を定義して値を入れよう


session_start();


// サーバーにデータを保存  配列、連想配列も入れれる
$_SESSION["number"] = 100;
$_SESSION["text"] = "hello world";

// 私は入場券のイメージでいますbyこなさん曰く
// 各部屋に入るたびに入場券をもらって、次の部屋では古いの回収＆新しい入場券もらう
// 書いてある内容は建物によって違う
// みたいな



echo "<pre>";
var_dump($_SESSION["number"]);
echo "<pre>";
exit();
