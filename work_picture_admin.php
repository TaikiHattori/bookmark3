<?php
include("work_picture_functions.php");
session_start();

check_session_id();
//↑ログインしてない人はURLからも飛べなくする

check_is_admin();
//↑管理者ユーザ以外は入れないようにする  ※今回はis_adminが1番のユーザを管理者とする





$pdo = connect_to_db();

$sql = 'SELECT * FROM session_login_users_table ORDER BY created_at ASC';

$stmt = $pdo->prepare($sql);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {
    $output .= "
    <tr>
      <td>{$record["id"]}</td>
      <td>{$record["username"]}</td>
      <td>{$record["password"]}</td>
      <td>{$record["is_admin"]}</td>
      <td>{$record["created_at"]}</td>
      <td>{$record["updated_at"]}</td>
      <td>{$record["deleted_at"]}</td>

      <td><a href='work_picture_admin_edit.php?id={$record["id"]}'>edit</a></td>
      <td><a href='javascript:void(0);' class='deleteBtn' data-id='{$record["id"]}'>delete</a></td>
    </tr>
  ";
}

// <td><a href='work_picture_admin_delete.php?id={$record["id"]}'>delete</a></td>


?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ページ</title>

    <style>
        /* モーダルのスタイル */
        .modal {
            display: none;
            /* モーダルを初めは非表示にする */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* ボタンのスタイル */
        .deleteBtn {
            cursor: pointer;
            color: red;
        }
    </style>
</head>

<body>
    <h1>管理者ページ</h1>

    <!-- モーダル -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <p>本当に削除してもよろしいですか？</p>
            <!-- <form id="deleteForm" action="work_picture_admin_delete.php" method="POST"> -->
            <form id="deleteForm" action="work_picture_admin_delete.php" method="GET">
                <!-- ↑work_picture_admin_delete.phpファイルは$_GETで受け取ろうとしてるから -->
                <!-- ↑送る側もGETにしないとダメ -->

                <input type="hidden" name="id" id="deleteId">
                <button type="submit" name="confirm_delete">はい</button>
                <button type="button" id="cancelDelete">いいえ</button>
            </form>
        </div>
    </div>


    <fieldset>
        <legend>DB連携（ユーザ一覧画面）<?= $_SESSION["username"] ?></legend>
        <!-- ↑ログイン時ユーザー名を一覧画面に表示したいとき追加$_SESSION["username"] -->

        <!-- <a href="work_picture_input.php">入力画面</a> -->
        <a href="work_picture_register.php">ユーザ登録画面</a>
        <a href="work_picture_logout.php">logout</a>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>username</th>
                    <th>password</th>
                    <th>is_admin</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>deleted_at</th>



                </tr>
            </thead>
            <tbody>
                <?= $output ?>
            </tbody>
        </table>
    </fieldset>


    <script>
        // 削除ボタンをクリックした時の処理
        document.querySelectorAll('.deleteBtn').forEach(item => {
            item.addEventListener('click', event => {
                const id = item.getAttribute('data-id'); // 削除対象のIDを取得
                document.getElementById('deleteId').value = id; // 削除フォームにIDを設定
                document.getElementById('myModal').style.display = "block"; // モーダルを表示
            });
        });

        // モーダル外のクリックやキャンセルボタンをクリックした時の処理
        document.getElementById('cancelDelete').addEventListener('click', event => {
            document.getElementById('myModal').style.display = "none"; // モーダルを非表示
        });

        // モーダルの外をクリックした時の処理
        window.addEventListener('click', event => {
            const modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = "none"; // モーダルを非表示
            }
        });


        // 削除フォームの送信時の処理
        // document.getElementById('deleteForm').addEventListener('submit', event => {
        //     event.preventDefault(); // デフォルトの送信をキャンセル
        //     const form = event.target;
        //     const formData = new FormData(form);
        //     fetch(form.action, {
        //             method: form.method,
        //             body: formData
        //         })
        //         .then(response => {
        //             if (!response.ok) {
        //                 throw new Error('Network response was not ok');
        //             }
        //             return response.text();
        //         })
        //         .then(data => {
        //             console.log(data); // サーバーからの応答をログに表示
        //             // 削除が成功した場合はモーダルを非表示にする
        //             document.getElementById('myModal').style.display = "none";
        //             // ここに他の任意の処理を追加できます
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //             // エラーが発生した場合は何らかのエラー処理を行います
        //         });
        // });
    </script>

</body>

</html>