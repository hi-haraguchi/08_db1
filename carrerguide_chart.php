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




// SQLクエリ
$sql = "
    SELECT
        u.iduniv,
        e.nameuniv,
        e.faculty,
        e.department
    FROM
        exam_table AS e
    JOIN
        universitylist AS u ON e.nameuniv = u.nameuniv
    WHERE
        e.passfail = '合格'

";

$results = []; // 結果を初期化

try {
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
} catch (\PDOException $e) {
    // クエリ実行に失敗した場合のエラーハンドリング
    echo "<p style='color: red;'>クエリ実行エラー: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit(); // 処理を終了
}



?>




<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>各種割合のグラフ</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/stylecongratulations.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Klee+One&display=swap" rel="stylesheet">
</head>

<body>

<header>
        <h2 id="header2">各種割合のグラフ</h2>
</header>

<div id="cong-container">

</div>

<a href="hrteacher_input.php" target="_blank" id="inputlink">入力画面へ</a>

</body>

</html>