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

$sql = 'SELECT * FROM exam_table ';

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
    <tr>
        <td>{$record["attendancenumber"]}</td>
        <td>{$record["name"]}</td>
        <td>{$record["nameuniv"]}</td>
        <td>{$record["faculty"]}</td>
        <td>{$record["department"]}</td>               
        <td>{$record["passfail"]}</td>
    </tr>
    ";
}

?>





<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>合格実績</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/stylecongratulations.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Klee+One&display=swap" rel="stylesheet">
</head>

<body>

<header>
        <h2 id="header2">合格実績</h2>
</header>

    <table>
      <thead>
        <tr>
          <th>deadline</th>
          <th>todo</th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
        <?= $elements?>
    </table>

    <a href="hrteacher_input.php" target="_blank" id="inputlink">入力画面へ</a>

</body>

</html>