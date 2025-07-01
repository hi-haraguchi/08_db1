<?php

// DB接続

// 各種項目設定
$dbn ='mysql:dbname=gs20250703db1;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// 「dbError:...」が表示されたらdb接続でエラーが発生していることがわかる．




// SQL作成&実行

$sql = 'SELECT * FROM exam_table';

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}


// SQL実行の処理

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$elements = "";
foreach ($result as $record) {
  $elements .= "
    <tr><td>{$record["name"]}</td><td>{$record["nameuniv"]}</td><td>{$record["passfail"]}</td></tr>
  ";
}



?>




<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>各生徒の合否一覧</title>
</head>

<body>
  <fieldset>
    <legend>各生徒の合否一覧</legend>
    <a href="hrteacher_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th>氏名</th>
          <th>大学名</th>
          <th>合格</th>          
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
        <?= $elements?>
    </table>
  </fieldset>
</body>

</html>