<?php
header('Content-Type: application/json'); // レスポンスがJSON形式であることを指定

// データベース接続情報
$servername = "localhost"; // ホスト名 (通常はlocalhost)
$username = "root";       
$password = "";          
$dbname = "gs20250703db1"; // データベース名
$tablename = "studentlist"; // テーブル名

// テーブルのカラム名（ご提示の構造より）
$id1000ColumnName = "id1000";
$nameColumnName = "name";

// データベースに接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続エラーを確認
if ($conn->connect_error) {
    // 接続に失敗した場合、エラーメッセージをJSON形式で返す
    echo json_encode(['status' => 'error', 'message' => 'データベース接続エラー: ' . $conn->connect_error]);
    exit(); // スクリプトの実行を終了
}

// GETリクエストからid1000の値を取得
// $_GET['id1000']が存在しない、またはnullの場合はnullを代入
$id1000 = $_GET['id1000'] ?? null;

// id1000が有効な数値であるかを確認
if (is_null($id1000) || !is_numeric($id1000)) {
    echo json_encode(['status' => 'error', 'message' => '有効なIDが指定されていません。']);
    $conn->close();
    exit();
}

// SQLインジェクションを防ぐためにプリペアドステートメントを使用
// SELECTクエリを準備
$stmt = $conn->prepare("SELECT {$nameColumnName} FROM {$tablename} WHERE {$id1000ColumnName} = ?");

// パラメータをバインド（'i' はid1000が整数型であることを示す）
$stmt->bind_param("i", $id1000);

// ステートメントを実行
if ($stmt->execute()) {
    // クエリ結果を取得
    $result = $stmt->get_result();

    // 結果の行をフェッチ
    if ($row = $result->fetch_assoc()) {
        // 名前が見つかった場合
        echo json_encode(['status' => 'success', 'name' => $row[$nameColumnName]]);
    } else {
        // id1000に一致する名前が見つからなかった場合
        echo json_encode(['status' => 'success', 'name' => null, 'message' => '一致する名前は見つかりませんでした。']);
    }
} else {
    // クエリ実行中にエラーが発生した場合
    echo json_encode(['status' => 'error', 'message' => '名前の取得に失敗しました: ' . $stmt->error]);
}

// ステートメントとデータベース接続をクローズ
$stmt->close();
$conn->close();

?>