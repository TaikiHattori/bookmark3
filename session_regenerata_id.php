<?php
// sessionをスタートしてidを再生成しよう．
// 旧idと新idを表示しよう．


session_start();
// ↑忘れがち


// idを取得
$old_id=session_id();
var_dump($old_id);
// string(26) "dn2cevghtqibu6cuk47h4g9hfc"



// id再生成
session_regenerate_id(true);
//trueをすると古いid消える
// 消えないと古いidばれる
//それは困る


$new_id=session_id();
var_dump($new_id);
exit();
// string(26) "kvpeeneehq928lle77r7nl5eqi"
