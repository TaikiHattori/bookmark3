<?php
// sessionに保存されている変数を取り出して表示しよう

session_start();

var_dump($_SESSION["number"]);
exit();
//普通、このファイル内で$_SESSION["number"]を定義せなvar_dumpできんけど
//SESSION変数は他ファイルでサーバーに保存した変数をいきなり取ってこれる
//※例session01.phpで動かしてない変数は、いきなりは取れない
