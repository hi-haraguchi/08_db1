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
    ORDER BY
        u.iduniv ASC;
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


$universities = [];

// 取得したデータを整形
foreach ($results as $row) {
    $univName = $row['nameuniv'];
    $department = $row['department'];
    $faculty = $row['faculty'];

    if (!isset($universities[$univName])) {
        $universities[$univName] = [
            'total' => 0,
            'departments' => [],
            'iduniv' => $row['iduniv']
        ];
    }
    $universities[$univName]['total']++;

    $key = htmlspecialchars($faculty . '/' . $department); // HTMLエスケープ
    if (!isset($universities[$univName]['departments'][$key])) {
        $universities[$univName]['departments'][$key] = 0;
    }
    $universities[$univName]['departments'][$key]++;
}

// 大学IDでソート (PHP側で再度ソートが必要な場合)
// usort($universities, function($a, $b) {
//     return $a['iduniv'] <=> $b['iduniv'];
// });


// 結果をHTMLとして$elementに格納
$element = '<div id="university-list-container">';

if (empty($universities)) {
    $element .= '<p>合格者データはありません。</p>';
} else {
    $element .= '<ul class="multi-column-list">'; // ここにクラスを追加
    foreach ($universities as $univName => $data) {
        $element .= '<li>';
        $element .= '<strong class="univ-name">' . htmlspecialchars($univName) . '</strong>';
        $element .= '<span class="total-count">' . $data['total'] . '名</span>';
        $deptDetails = [];
        foreach ($data['departments'] as $deptKey => $count) {
            $deptDetails[] = htmlspecialchars($deptKey) . '(' . $count . ')';
        }
        $element .= '<span class="dept-details">' . implode('、', $deptDetails) . '</span>';
        $element .= '</li>';
    }
    $element .= '</ul>';
}

$element .= '</div>';

?>





<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>（掲示用）合格実績</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/stylecongratulations.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Klee+One&display=swap" rel="stylesheet">
</head>

<body>

<header>
        <h2 id="header2">祝！　合格おめでとう</h2>
</header>

<div id="cong-container">
    <?= $element?>
</div>

<a href="hrteacher_input.php" target="_blank" id="inputlink">入力画面へ</a>

</body>

</html>