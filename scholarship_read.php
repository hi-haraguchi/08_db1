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




 // --- 奨学金 A のレコードを抽出するSQLクエリ ---
    $sql_A = "
        SELECT
            e.classnumber,
            e.attendancenumber,
            e.name,
            s.scholarship,
            e.nameuniv,
            e.faculty,
            e.department,
            e.examsystem,
            e.passfail
        FROM
            exam_table AS e
        JOIN
            studentlist AS s
        ON
            e.id1000 = s.id1000
        WHERE
            s.scholarship = 'A'
        ORDER BY
            e.classnumber ASC,
            e.attendancenumber ASC;
    ";
    $stmt_A = $pdo->query($sql_A);
    $results_A = $stmt_A->fetchAll(PDO::FETCH_ASSOC);
    $table_rows_A = ''; 

    // 奨学金Aのテーブル行を生成し、変数に格納
    if (count($results_A) > 0) {
        foreach ($results_A as $row) {
            $table_rows_A .= '<tr>';
            $table_rows_A .= '<td>' . htmlspecialchars($row['classnumber']) . '</td>';
            $table_rows_A .= '<td>' . htmlspecialchars($row['attendancenumber']) . '</td>';
            $table_rows_A .= '<td>' . htmlspecialchars($row['name']) . '</td>';
            $table_rows_A .= '<td>' . htmlspecialchars($row['scholarship']) . '</td>';
            $table_rows_A .= '<td>' . htmlspecialchars($row['nameuniv']) . '</td>';
            $table_rows_A .= '<td>' . htmlspecialchars($row['faculty']) . '</td>';
            $table_rows_A .= '<td>' . htmlspecialchars($row['department']) . '</td>';
            $table_rows_A .= '<td>' . htmlspecialchars($row['examsystem']) . '</td>';
            $table_rows_A .= '<td>' . htmlspecialchars($row['passfail']) . '</td>';
            $table_rows_A .= '</tr>';
        }
    } else {
        $table_rows_A = '<tr><td colspan="9">奨学金 A の対象者はいません。</td></tr>'; // 9は列数に合わせてください
    }


    // --- 奨学金 B のレコードを抽出するSQLクエリ ---
    $sql_B = "
        SELECT
            e.classnumber,
            e.attendancenumber,
            e.name,
            s.scholarship,
            e.nameuniv,
            e.faculty,
            e.department,
            e.examsystem,
            e.passfail
        FROM
            exam_table AS e
        JOIN
            studentlist AS s
        ON
            e.id1000 = s.id1000
        WHERE
            s.scholarship = 'B'
        ORDER BY
            e.classnumber ASC,
            e.attendancenumber ASC;
    ";
    $stmt_B = $pdo->query($sql_B);
    $results_B = $stmt_B->fetchAll(PDO::FETCH_ASSOC);
    $table_rows_B = ''; 

    // 奨学金Bのテーブル行を生成し、変数に格納
    if (count($results_B) > 0) {
        foreach ($results_B as $row) {
            $table_rows_B .= '<tr>';
            $table_rows_B .= '<td>' . htmlspecialchars($row['classnumber']) . '</td>';
            $table_rows_B .= '<td>' . htmlspecialchars($row['attendancenumber']) . '</td>';
            $table_rows_B .= '<td>' . htmlspecialchars($row['name']) . '</td>';
            $table_rows_B .= '<td>' . htmlspecialchars($row['scholarship']) . '</td>';
            $table_rows_B .= '<td>' . htmlspecialchars($row['nameuniv']) . '</td>';
            $table_rows_B .= '<td>' . htmlspecialchars($row['faculty']) . '</td>';
            $table_rows_B .= '<td>' . htmlspecialchars($row['department']) . '</td>';
            $table_rows_B .= '<td>' . htmlspecialchars($row['examsystem']) . '</td>';
            $table_rows_B .= '<td>' . htmlspecialchars($row['passfail']) . '</td>';
            $table_rows_B .= '</tr>';
        }
    } else {
        $table_rows_B = '<tr><td colspan="9">奨学金 B の対象者はいません。</td></tr>'; // 9は列数に合わせてください
    }


?>




<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>奨学生の受験データ一覧</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/stylescholarship.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Klee+One&display=swap" rel="stylesheet">
</head>

<body>

<header>
        <h2 id="header2">奨学生の受験データ一覧</h2>
</header>


<div class="table-container">
<table>
    <thead>
    <tr>
        <th>クラス</th>
        <th>出席番号</th>
        <th>氏名</th>
        <th>奨学生区分</th>
        <th>大学名</th>        
        <th>学部名</th>
        <th>学科名</th>
        <th>選抜形式</th>       
        <th>合否</th>
    </tr>
    </thead>
    <tbody>
    <?= $table_rows_A?>
    </tbody>
    </table>
</div>

<div class="table-container">
<table>
    <thead>
    <tr>
        <th>クラス</th>
        <th>出席番号</th>
        <th>氏名</th>
        <th>奨学生区分</th>
        <th>大学名</th>        
        <th>学部名</th>
        <th>学科名</th>
        <th>選抜形式</th>       
        <th>合否</th>
    </tr>
    </thead>
    <tbody>
    <?= $table_rows_B?>
    </tbody>
    </table>
</div>

    <a href="hrteacher_input.php" target="_blank" id="inputlink">入力画面へ</a>

</body>

</html>