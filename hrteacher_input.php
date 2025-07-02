<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>(担任用)受験データ入力フォーム</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Klee+One&display=swap" rel="stylesheet">

</head>

<body>

  <header>
        <h4 id="header1">～担任の先生入力用～</h4>
        <h2 id="header2">生徒の受験データ入力フォーム</h2>
  </header>


  <form action="student_create.php" method="POST">
      <div class="form-group">
        <label for="classnumber">組:</label>
        <input type="number" min="1" step="1" name="classnumber">
      </div>
      <div class="form-group">
        <label for="attendancenumber">出席番号:</label>
        <input type="number" min="1" step="1" name="attendancenumber">
      </div>
      <div  hidden>
        id1000: <input type="number" min="1" step="1" name="id1000" id="id1000input">
      </div>
      <div class="form-group">
        <label for="nameInput">氏名: </label>        
        <input type="text" name="name" id="nameInput" readonly>
      </div>
      <p id="nameattention">※クラスと出席番号を入力すれば自動で入力されます</p>
      <div class="univinputflex">
          <div>
            <input type="text" name="nameuniv">
          </div>
          <div>
              <select id="nameuniv2" name="nameuniv2">
                  <option value="大学">大学</option>
                  <option value="大学校">大学校</option>
              </select>
          </div>
      </div>
      <div  class="univinputflex">
          <div>
            <input type="text" name="faculty">
          </div>                     
          <div>
              <select id="faculty2" name="faculty2">
                  <option value="学部">学部</option>
                  <option value="学群">学群</option>
              </select>
          </div>
      </div>
      <div  class="univinputflex">
          <div>
            <input type="text" name="department">
          </div>                     
          <div>
              <select id="department2" name="department2">
                  <option value="学科">学科</option>
                  <option value="学類">学類</option>
              </select>
          </div>
      </div>
      <div class="form-group">
          <label for="univkind">大学の種類:</label>
          <select id="univkind" name="univkind">
              <option value="">選択してください</option>
              <option value="国立文">国立文</option>
              <option value="国立理">国立理</option>
              <option value="私立文">私立文</option>
              <option value="私立理">私立理</option>
              <option value="その他">その他</option>
          </select>
      </div>  
      <div class="form-group">
          <label for="academicfield">学系:</label>
          <select id="academicfield" name="academicfield">
              <option value="">選択してください</option>
              <option value="文・人文">文・人文</option>
              <option value="外国語">外国語</option>
              <option value="商・経済・経営">商・経済・経営</option>
              <option value="法・政治">法・政治</option>
              <option value="教育・心理">教育・心理</option>              
              <option value="社会・福祉・家政">社会・福祉・家政</option>
              <option value="芸術・スポーツ">芸術・スポーツ</option>
              <option value="国際">国際</option>
              <option value="共創・ﾘﾍﾞﾗﾙｱｰﾂ・他">共創・ﾘﾍﾞﾗﾙｱｰﾂ・他</option>
              <option value="理学・工学">理学・工学</option>              
              <option value="医学">医学</option>
              <option value="歯学">歯学</option>
              <option value="薬学">薬学</option>
              <option value="看護">看護</option>
              <option value="保健">保健</option>              
              <option value="獣医">獣医</option>
              <option value="農・食品">農・食品</option>
          </select>
      </div>      
      <div class="form-group">
          <label for="examsystem">入試方式:</label>
          <select id="examsystem" name="examsystem">
              <option value="">選択してください</option>
              <option value="指定校推薦">指定校推薦</option>
              <option value="公募制推薦">公募制推薦</option>
              <option value="総合型選抜">総合型選抜</option>
              <option value="一般選抜">一般選抜</option>
              <option value="その他">その他</option>
          </select>
      </div>
      <div class="form-group">
          <label for="commontest">共テ利用:</label>
          <select id="commontest" name="commontest">
              <option value="">選択してください</option>
              <option value="利用">利用</option>
              <option value="なし">なし</option>
          </select>
      </div>
      <div class="form-group">
          <label for="oneormulti">専願or併願:</label>
          <select id="oneormulti" name="oneormulti">
              <option value="">選択してください</option>
              <option value="専願">専願</option>
              <option value="併願">併願</option>
              <option value="なし">なし</option>              
          </select>
      </div>
      <div class="form-group">
          <label for="passfail">合否:</label>
          <select id="passfail" name="passfail">
              <option value="">選択してください</option>
              <option value="合格">合格</option>
              <option value="不合格">不合格</option>
              <option value="未受験">未受験</option>              
          </select>
      </div>
      <div>
        <button>送信</button>
      </div>


      <div id="classlink">
          <p>各クラスの状況</p>
          <div id="eachclass">
            <a href="class1_read.php" target="_blank">1組</a>
            <a href="class2_read.php" target="_blank">2組</a>
            <a href="class3_read.php" target="_blank">3組</a>
            <a href="classex_read.php" target="_blank">過年度生</a>            
          </div>
      </div>

      <a href="congratulations_read.php" target="_blank" id="resultlink">合格実績の画面へ</a>

  </form>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
      const $classNumberInput = $('input[name="classnumber"]');
      const $attendanceNumberInput = $('input[name="attendancenumber"]');
      const $id1000Input = $('#id1000input');
      const $nameInput = $('#nameInput'); // 新しく追加したname入力フィールド

      // id1000を計算し、名前を取得する関数
      function calculateAndFetchName() {
        const classNumber = parseInt($classNumberInput.val());
        const attendanceNumber = parseInt($attendanceNumberInput.val());

        if (!isNaN(classNumber) && !isNaN(attendanceNumber)) {
          const id1000 = (classNumber * 1000) + attendanceNumber;
          $id1000Input.val(id1000); // id1000を表示

          // id1000が有効な値の場合のみ、名前を取得するAJAXリクエストを送信
          fetchNameById1000(id1000);
        } else {
          $id1000Input.val('');
          $nameInput.val(''); // 無効な場合は名前もクリア
          $messageDiv.text('');
        }
      }

      // サーバーから名前を取得する関数
      function fetchNameById1000(id1000Value) {
        $nameInput.val(''); // 取得前に名前フィールドをクリア

        $.ajax({
          url: 'fetch_name.php', // 名前を取得するサーバーサイドスクリプトのURL
          type: 'GET', // GETリクエストでデータを送信
          data: { id1000: id1000Value }, // サーバーに送信するデータ
          dataType: 'json', // レスポンスのデータタイプをJSONに指定
          success: function(response) {
            if (response.status === 'success') {
              if (response.name) {
                $nameInput.val(response.name); // 取得した名前を表示
              } else {
                $nameInput.val('');
              }
            } 
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error, xhr.responseText);
          }
        });
      }

      // 「組」または「出席番号」が変更されたときに、計算と名前の取得を実行
      $classNumberInput.on('input', calculateAndFetchName);
      $attendanceNumberInput.on('input', calculateAndFetchName);

      // ページロード時に一度実行（初期値が設定されている場合のため）
      calculateAndFetchName();
    });
    </script>


</html>