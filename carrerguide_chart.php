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




// --- univkindごとの合格者数を取得 ---
$sql_univkind = "SELECT e.univkind, COUNT(*) AS count
                FROM exam_table AS e
                JOIN universitylist AS u ON e.nameuniv = u.nameuniv
                WHERE e.passfail = '合格'
                GROUP BY e.univkind";
$stmt = $pdo->prepare($sql_univkind);
$stmt->execute();
$data_univkind = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data_univkind[$row['univkind']] = $row['count'];
}

// --- academicfieldごとの合格者数を取得 ---
$sql_academicfield = "SELECT e.academicfield, COUNT(*) AS count
                    FROM exam_table AS e
                    JOIN universitylist AS u ON e.nameuniv = u.nameuniv
                    WHERE e.passfail = '合格'
                    GROUP BY e.academicfield";
$stmt = $pdo->prepare($sql_academicfield);
$stmt->execute();
$data_academicfield = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data_academicfield[$row['academicfield']] = $row['count'];
}

// --- examsystemごとの合格者数を取得 ---
$sql_examsystem = "SELECT e.examsystem, COUNT(*) AS count
                FROM exam_table AS e
                JOIN universitylist AS u ON e.nameuniv = u.nameuniv
                WHERE e.passfail = '合格'
                GROUP BY e.examsystem";
$stmt = $pdo->prepare($sql_examsystem);
$stmt->execute();
$data_examsystem = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data_examsystem[$row['examsystem']] = $row['count'];
}

// --- regionごとの合格者数を取得 ---
$sql_region = "SELECT u.region, COUNT(*) AS count
            FROM exam_table AS e
            JOIN universitylist AS u ON e.nameuniv = u.nameuniv
            WHERE e.passfail = '合格'
            GROUP BY u.region";
$stmt = $pdo->prepare($sql_region);
$stmt->execute();
$data_region = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data_region[$row['region']] = $row['count'];
}

// --- 各データをJSON形式に変換 ---
$chart_data_univkind_json = json_encode($data_univkind);
$chart_data_academicfield_json = json_encode($data_academicfield);
$chart_data_examsystem_json = json_encode($data_examsystem);
$chart_data_region_json = json_encode($data_region);
?>






<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>各種グラフ</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Klee+One&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Klee One', sans-serif;
            font-family: Arial, sans-serif;
            display: flex;
            flex-wrap: wrap; /* グラフを横並びにするため */
            justify-content: center;
            align-items: flex-start; /* 上寄せ */
            gap: 30px; /* グラフ間のスペース */
            min-height: 100vh;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .chart-container {
            width: 90%; /* 小さな画面でも見やすく */
            max-width: 450px; /* PCでの最大幅 */
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            box-sizing: border-box; /* paddingとborderをwidthに含める */
        }
        /* 画面が広い場合は2列表示に */
        @media (min-width: 992px) {
            .chart-container {
                width: calc(50% - 30px); /* 2列表示でgapを考慮 */
            }
        }
    </style>
    
</head>

<body>

    <div class="chart-container">
        <canvas id="univKindDoughnutChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="academicFieldDoughnutChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="examSystemDoughnutChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="regionDoughnutChart"></canvas>
    </div>

    <script>
        // PHPから渡されたデータをJavaScript変数に代入
        const chartDataUnivkind = <?php echo $chart_data_univkind_json; ?>;
        const chartDataAcademicfield = <?php echo $chart_data_academicfield_json; ?>;
        const chartDataExamsystem = <?php echo $chart_data_examsystem_json; ?>;
        const chartDataRegion = <?php echo $chart_data_region_json; ?>;

        // 汎用的なグラフ作成関数
        function createDoughnutChart(canvasId, dataObject, titleText) {
            const labels = Object.keys(dataObject);
            const values = Object.values(dataObject);

            // 各データ項目に対応する色を動的に生成
            // 必要に応じて特定の項目に固定の色を割り当てることも可能
            const backgroundColors = labels.map(() => `hsl(${Math.floor(Math.random() * 360)}, 70%, 60%)`); // ランダムな色
            const borderColors = labels.map((color, index) => backgroundColors[index].replace('0.7)', '1)'));

            const data = {
                labels: labels,
                datasets: [{
                    label: '合格者数',
                    data: values,
                    backgroundColor: backgroundColors,
                    borderColor: backgroundColors.map(color => color.replace('0.7)', '1)')), // ボーダーは少し濃い色に
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: titleText
                        }
                    }
                },
            };

            new Chart(
                document.getElementById(canvasId),
                config
            );
        }

        // 各グラフを描画
        createDoughnutChart('univKindDoughnutChart', chartDataUnivkind, '大学の種類');
        createDoughnutChart('academicFieldDoughnutChart', chartDataAcademicfield, '学術分野');
        createDoughnutChart('examSystemDoughnutChart', chartDataExamsystem, '入試制度');
        createDoughnutChart('regionDoughnutChart', chartDataRegion, '大学の地域');

    </script>

</body>

</html>