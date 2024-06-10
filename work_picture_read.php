<?php
include("work_picture_functions.php");

session_start();
// ↑ログイン時ユーザー名を一覧画面に表示したいとき追加

check_session_id();
// ログインした人しか画面見せないとき追加
//※login.phpとlogin_act.php以外には書いてよい




$pdo = connect_to_db();

$sql = 'SELECT * FROM session_login_table ORDER BY created_at ASC';

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
      <td>{$record["title"]}</td>
      <td>{$record["picture_type"]}</td>

      <td><img src='data:image/jpeg;base64," . base64_encode($record["picture"]) . "' alt='画像'></td>
      
      <td>
        <a href='work_picture_edit.php?id={$record["id"]}'>edit</a>
      </td>
      <td>
        <a href='work_picture_delete.php?id={$record["id"]}'>delete</a>
      </td>
    </tr>
  ";
}

//  <tr>
//       <td>{$record["deadline"]}</td>
//       <td>{$record["todo"]}</td>
//       <td><a href='work_picture_edit.php?id={$record["id"]}'>edit</a></td>
//       <td><a href='work_picture_delete.php?id={$record["id"]}'>delete</a></td>
//     </tr>


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB連携（一覧画面）</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.css">

    <style>
        img {
            width: 400px;
            height: 260px;
        }


        body {
            font-family: Arial, sans-serif;
        }

        .slider-container {
            width: 80%;
            margin: 50px auto;
            position: relative;
        }

        .rangeslider {
            background: none;
        }

        .rangeslider__fill {
            background: linear-gradient(to right, red, yellow, green);
            width: 100% !important;
        }

        .rangeslider__handle {
            background-color: #000;
            border-radius: 50%;
            position: relative;
        }

        .slider-value {
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            background-color: black;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            white-space: nowrap;
        }
    </style>

</head>

<body>
    <fieldset>
        <legend>DB連携（一覧画面）<?= $_SESSION["username"] ?></legend>
        <!-- ↑ログイン時ユーザー名を一覧画面に表示したいとき追加$_SESSION["username"] -->

        <a href="work_picture_input.php">入力画面</a>
        <a href="work_picture_logout.php">logout</a>

        <a href="work_picture_admin.php">管理者ページ</a>

        <table>
            <thead>
                <tr>
                    <th>title</th>
                    <th>picture_type</th>
                    <th>picture</th>
                    <th>達成度％</th>
                </tr>
            </thead>
            <tbody>
                <!-- ?= $output ?>以下と二重になってたので消したら、
                上部のconnect_to_DBの赤波線が消え、画像も同じの二重で出てくる問題解決 -->



                <!-- 画像とスライダーをループ内に追加 -->
                <?php foreach ($result as $record) : ?>
                    <tr>
                        <td><?= $record["title"] ?></td>
                        <td><?= $record["picture_type"] ?></td>
                        <td><img src="data:image/jpeg;base64,<?= base64_encode($record["picture"]) ?>" alt="画像"></td>

                        <td>
                            <input type="range" min="0" max="100" value="<?= $record["level"] ?>" class="slider"><!--初期値を0に設定 -->
                            <!-- ↑value="?= $record["level"] ?>"にする -->
                            <div class="slider-value">0%</div>
                            <!-- ↑不要かも -->


                            <?= $record["level"] ?>
                        </td>

                        <td>
                            <a href="work_picture_edit.php?id=<?= $record["id"] ?>">edit</a>
                        </td>
                        <td>
                            <a href="work_picture_delete.php?id=<?= $record["id"] ?>">delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>



            </tbody>
        </table>
    </fieldset>

    <!-- <div class="slider-container">
        <input type="range" min="0" max="100" value="0" id="slider"> 初期値を0に設定
        <div class="slider-value" id="slider-value">0%</div>
    </div> -->



    <!-- jQueryのインクルード -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.js"></script>



    <script>
        const pictures = <?= json_encode($result) ?>;
        console.log(pictures);




        $(document).ready(function() {

            $('.slider').each(function() {

                // const $slider = $('#slider');
                // const $sliderValue = $('#slider-value');
                const $slider = $(this);
                const $sliderValue = $slider.parent().find('.slider-value');


                // rangeslider.jsの初期化
                $slider.rangeslider({
                    polyfill: false,
                    onInit: function() {
                        updateSliderValue(this.value, $sliderValue);
                    },
                    onSlide: function(position, value) {
                        updateSliderValue(value, $sliderValue);
                    }
                });
            });

            function updateSliderValue(value, $sliderValue) {
                $sliderValue.text(value + '%');
                const handle = $sliderValue.parent().find('.rangeslider__handle')[0];
                const handleRect = handle.getBoundingClientRect();
                const sliderRect = $sliderValue.parent().find('.slider')[0].getBoundingClientRect();
                const handleLeft = handleRect.left - sliderRect.left + (handleRect.width / 2) - ($sliderValue.outerWidth() / 2);
                $sliderValue.css('left', handleLeft + 'px');
            }
        });
    </script>


</body>

</html>