<?php
// データ受け取り

// var_dump($_POST);
// exit();
//array(2) { ["username"]=> string(10) "testuser01" ["password"]=> string(6) "111111" }




session_start();
// 忘れるな



include('functions.php');

$username = $_POST['username'];
$password = $_POST['password'];



// DB接続   以降read.phpと似ている
$pdo = connect_to_db();




// SQL実行
// username，password，deleted_atの3項目全ての条件満たすデータを抽出する．
$sql = 'SELECT * FROM users_table WHERE username=:username AND password=:password AND deleted_at IS NULL';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}



// ユーザ有無で条件分岐
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    echo "<p>ログイン情報に誤りがあります</p>";
    echo "<a href=todo_login.php>ログイン</a>";
    exit();
} else {
    $_SESSION = array();
    $_SESSION['session_id'] = session_id();
    $_SESSION['is_admin'] = $user['is_admin'];
    $_SESSION['username'] = $user['username'];
    header("Location:todo_read.php");
    exit();
}


// else
// else以降がつくるものによって変わる



// $_  arrayは一旦空を作るため


// 「$_SESSION[]=...」OKならセッションにデータ入れましょう