<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>(担任用)合否入力フォーム</title>
</head>

<body>
  <form action="student_create.php" method="POST">
    <fieldset>
      <legend>(担任用)合否入力フォーム</legend>
      <a href="student_read.php">一覧画面</a>
      <div>
        組: <input type="number" min="1" step="1" name="classnumber">
      </div>
      <div>
        出席番号: <input type="number" min="1" step="1" name="attendancenumber">
      </div>
      <div  hidden>
        id1000: <input type="number" min="1" step="1" name="id1000" id="id1000input">
      </div>
      <div>
        氏名: <input type="text" name="name" id="nameInput" readonly>
      </div> 
      <div>
        <input type="text" name="nameuniv">大学
      </div> 
      <div>
        <input type="text" name="faculty">
      </div>                     
      <div class="form-group">
          <select id="faculty2" name="faculty2">
              <option value="学部">学部</option>
              <option value="学群">学群</option>
          </select>
      </div>
      <div>
        <input type="text" name="department">
      </div>                     
      <div class="form-group">
          <select id="department2" name="department2">
              <option value="学科">学科</option>
              <option value="学類">学類</option>
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
              <option value="なし">なし</option>              
          </select>
      </div>
      <div>
        <button>送信</button>
      </div>
    </fieldset>
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