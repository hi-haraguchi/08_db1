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

$sql = 'SELECT * FROM exam_table WHERE classnumber = 2 ORDER BY attendancenumber ASC';

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
    <title>２組の受験データ一覧</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style123ex.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Klee+One&display=swap" rel="stylesheet">
</head>

<body>

<header>
        <h2 id="header2">２組の受験データ一覧</h2>
</header>


<div class="table-container">
<table>
    <thead>
    <tr>
        <th>出席番号</th>
        <th>氏名</th>
        <th>大学名</th>
        <th>学部名</th>
        <th>学科名</th>
        <th>合否</th>
    </tr>
    </thead>
    <tbody>
    <?= $elements?>
    </tbody>
    </table>
</div>

    <a href="hrteacher_input.php" target="_blank" id="inputlink">入力画面へ</a>

</body>

</html>