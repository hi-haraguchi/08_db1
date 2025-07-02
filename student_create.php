<?php

// var_dump($_POST);
// exit();



// POSTデータ確認
// 設定されていないor空文字

if (
  !isset($_POST['classnumber']) || $_POST['classnumber'] === '' ||
  !isset($_POST['attendancenumber']) || $_POST['attendancenumber'] === ''||
  !isset($_POST['id1000']) || $_POST['id1000'] === '' ||
  !isset($_POST['name']) || $_POST['name'] === '' ||
  !isset($_POST['nameuniv']) || $_POST['nameuniv'] === ''||
  !isset($_POST['nameuniv2']) || $_POST['nameuniv2'] === ''||  
  !isset($_POST['faculty']) || $_POST['faculty'] === '' ||  
  !isset($_POST['faculty2']) || $_POST['faculty2'] === '' ||
  !isset($_POST['department']) || $_POST['department'] === ''||
  !isset($_POST['department2']) || $_POST['department2'] === ''||
  !isset($_POST['univkind']) || $_POST['univkind'] === '' ||
  !isset($_POST['academicfield']) || $_POST['academicfield'] === '' ||      
  !isset($_POST['examsystem']) || $_POST['examsystem'] === '' ||
  !isset($_POST['commontest']) || $_POST['commontest'] === '' ||
  !isset($_POST['oneormulti']) || $_POST['oneormulti'] === ''||
  !isset($_POST['passfail']) || $_POST['passfail'] === '' 
) {
  exit('データがありません');
}

$classnumber = $_POST['classnumber'];
$attendancenumber = $_POST['attendancenumber'];
$id1000 = $_POST['id1000'];
$name = $_POST['name'];
$nameuniv = $_POST['nameuniv'];
$nameuniv2 = $_POST['nameuniv2'];
$faculty = $_POST['faculty'];
$faculty2 = $_POST['faculty2'];
$department = $_POST['department'];
$department2 = $_POST['department2'];
$univkind = $_POST['univkind'];
$academicfield = $_POST['academicfield'];
$examsystem = $_POST['examsystem'];
$commontest = $_POST['commontest'];
$oneormulti = $_POST['oneormulti'];
$passfail = $_POST['passfail'];


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
$sql = 'INSERT INTO exam_table (id, classnumber, attendancenumber, id1000, name, nameuniv, nameuniv2, faculty, faculty2, department, department2, univkind, academicfield, examsystem, commontest, oneormulti, passfail, created_at) 
                  VALUES (NULL, :classnumber, :attendancenumber, :id1000, :name, :nameuniv, :nameuniv2, :faculty, :faculty2, :department, :department2, :univkind, :academicfield, :examsystem, :commontest, :oneormulti, :passfail, now())';

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':classnumber', $classnumber, PDO::PARAM_STR);
$stmt->bindValue(':attendancenumber', $attendancenumber, PDO::PARAM_STR);
$stmt->bindValue(':id1000', $id1000, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':nameuniv', $nameuniv, PDO::PARAM_STR);
$stmt->bindValue(':nameuniv2', $nameuniv2, PDO::PARAM_STR);
$stmt->bindValue(':faculty', $faculty, PDO::PARAM_STR);
$stmt->bindValue(':faculty2', $faculty2, PDO::PARAM_STR);
$stmt->bindValue(':department', $department, PDO::PARAM_STR);
$stmt->bindValue(':department2', $department2, PDO::PARAM_STR);
$stmt->bindValue(':univkind', $univkind, PDO::PARAM_STR);
$stmt->bindValue(':academicfield', $academicfield, PDO::PARAM_STR);
$stmt->bindValue(':examsystem', $examsystem, PDO::PARAM_STR);
$stmt->bindValue(':commontest', $commontest, PDO::PARAM_STR);
$stmt->bindValue(':oneormulti', $oneormulti, PDO::PARAM_STR);
$stmt->bindValue(':passfail', $passfail, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:hrteacher_input.php');
exit();

?>