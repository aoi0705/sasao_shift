<?php
	if(Auth::user()->role == 'user'){
		header('Location: ' . route('user_menu_show'));
        exit();
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>勤怠管理システム</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="勤怠管理システム">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<style>
.modal-shift {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1000; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal-content-shift {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

.close-shift {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close-shift:hover,
.close-shift:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>

<body>

<div id="container">

<header>
<h1 id="logo"><a href="{{route('admin_menu')}}"><img src="images/logo.png" alt="JOB INFO"></a></h1>
<!--メインメニュー-->
<nav id="menubar">
<ul>
<li><a href="{{route('attendance_confirmation')}}">勤怠管理</a></li>
<li><a href="{{route('staff_listshow')}}">スタッフ一覧</a></li>
<li><a href="{{route('admin_config_show')}}">各種設定</a></li>
<li><a href="{{route('received_file')}}">スタッフ送信ファイル確認</a></li>
<li><a href="{{route('paid_holiday_list')}}">有給申請確認</a></li>
<li><a href="">管理者アカウント</a>
	<ul>
		<li><a href="">パスワード変更</a></li>
		<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf
        </form></li>
	</ul>
</li>
</ul>
</nav>
</header>

<main>

<section>

<h2>スタッフ登録情報確認</h2>
@if(session('alert'))
<p style="color:red;">管理者パスワードが違います。</p>
@endif
<!-- フォームの情報はここからです -->
<form id="form" enctype="multipart/form-data" method="post" action="{{route('staff_edit')}}">
@csrf
<input type="hidden" name="id" value="{{$article->id}}">
<table class="ta1">
<tr>
<th>email※</th>
<td><input type="email" name="email" value="{{$article->email}}" required><td>
</tr>
<tr>
<th>スタッフ種別※</th>
<td><input type="text" name="stafftype" value="{{$article->stafftype}}" required></td>
</tr>
<tr>
<th>お名前※</th>
<td><input type="text" name="name" value="{{$article->name}}" required></td>
</tr>
<tr>
<th>ふりがな</th>
<td><input type="text" name="furigana" value="{{$article->furigana}}" required></td>
</tr>
<tr>
<th>性別</th>
<td>
<select name="sex">
    <option value="男性" @if($article->sex == "男性") selected @endif>男性</option>
    <option value="女性" @if($article->sex == "女性") selected @endif>女性</option>
</select>
</td>
</tr>
<tr>
<th>郵便番号</th>
<td><input type="text" name="postnumber" value="{{$article->postnumber}}" required></td>
</tr>
<tr>
<th>住所</th>
<td><input type="text" name="address" value="{{$article->address}}" required></td>
</tr>
<tr>
<th>最寄り路線</th>
<td><input type="text" name="train_route" value="{{$article->train_route}}" required></td>
</tr>
<tr>
<th>最寄り駅</th>
<td><input type="text" name="station" value="{{$article->station}}" required></td>
</tr>
<tr>
<th>マイナンバー</th>
<td><input type="text" name="mynumber" value="{{$article->mynumber}}" required></td>
</tr>
<tr>
<th>扶養の有無</th>
<td>
<select name="dependent" id="dependent">
        <option value="無" @if($article->dependent == "無") selected @endif>無</option>
        <option value="有" @if($article->dependent == "有") selected @endif>有</option>
</select>
</td>
</tr>
@if($article->dependent == '有')
<?php
    for($i=1;$i<=5;$i++){
        $income_arr = json_decode($article->dependent_income, true);
        $name_arr = json_decode($article->dependent_name, true);
        $furigana_arr = json_decode($article->dependent_furigana, true);
        $sex_arr = json_decode($article->dependent_sex, true);

        if(!isset($income_arr['dependent_income'.$i])){
            echo '<input type="hidden" name="field_cnt" value="' . $i-1 . '">';
            break;
        }

        echo '<tr>';
        echo '<th>扶養者の年収' . $i . '</th>';
        echo '<td>';
        echo '<input type="text" name="dependent_income'.$i.'" value="'.$income_arr['dependent_income'.$i].'" required>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>扶養者の名前' . $i . '</th>';
        echo '<td>';
        echo '<input type="text" name="dependent_name'.$i.'" value="'.$name_arr['dependent_name'.$i] .'" required>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>扶養者のふりがな' . $i . '</th>';
        echo '<td>';
        echo '<input type="text" name="dependent_furigana'.$i.'" value="'.$furigana_arr['dependent_furigana'.$i] .'" required>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>扶養者の性別' . $i . '</th>';
        echo '<td>';
        echo "<select name='dependent_sex{$i}'>";
        echo "<option value='男性' " . ($sex_arr['dependent_sex'.$i] == "男性" ? "selected" : "") . ">男性</option>";
        echo "<option value='女性' " . ($sex_arr['dependent_sex'.$i] == "女性" ? "selected" : "") . ">女性</option>";
        echo "</select>";
        echo '</td>';
        echo '</tr>';
    }
?>
@endif
</table>

<p class="btn">
<input type="button" id="modify" value="変更する">
&nbsp;
<input type="button" id="delete" value="削除する">
&nbsp;
<input type="button" value="管理者画面" onclick="location.href='{{route('admin_menu')}}'">
</p>

<!-- Custom Modal -->
<div id="eventModal-shift" class="modal-shift">
  <div class="modal-content-shift">
    <span class="close-shift">&times;</span>
    <div id="modalBody-shift">
      <!-- Event details will be inserted here -->
    </div>
  </div>
</div>


</form>
<!-- フォームの情報はここまでです -->

</section>

</main>

</div>
<!--/#container-->

<!--jQueryの読み込み-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!--job4用のスクリプト-->
<script src="{{asset('js/main.js')}}"></script>
<script>
$(function(){
  // 変数に要素を入れる
  var open = $('#modify'),
    close = $('.close-shift')[0],
    container = $('#modal_modify');

  //開くボタンをクリックしたらモーダルを表示する
  open.on('click',function(){ 
    document.getElementById('modalBody-shift').innerHTML = `
      <h3>変更</h3>
      <p>管理者パスワードを入力してください。</p>
      <input type="text" name="admin_password_modify" class="ws"><br>
      <button type="submit" id="modify_submit">変更</button>
    `;
    var modal = document.getElementById('eventModal-shift');
    modal.style.display = "block";
  });

  // Close the modal when the user clicks on <span> (x)
  var span = document.getElementsByClassName("close-shift")[0];
  span.onclick = function() {
    var modal = document.getElementById('eventModal-shift');
    modal.style.display = "none";
  }

  // Close the modal when the user clicks anywhere outside of the modal
  window.onclick = function(event) {
    var modal = document.getElementById('eventModal-shift');
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
});

$(function(){
  // 変数に要素を入れる
  var open = $('#delete'),
    close = $('.close-shift')[0],
    container = $('#modal_delete');

  //開くボタンをクリックしたらモーダルを表示する
  open.on('click',function(){ 
    document.getElementById('modalBody-shift').innerHTML = `
      <h3>削除</h3>
      <p>削除：管理者パスワードを入力してください。</p>
      <input type="text" name="admin_password_delete" class="ws"><br>
      <button type="button" id="delete_submit">変更</button>
    `;
    var modal = document.getElementById('eventModal-shift');
    modal.style.display = "block";
  });

  // Close the modal when the user clicks on <span> (x)
  var span = document.getElementsByClassName("close-shift")[0];
  span.onclick = function() {
    var modal = document.getElementById('eventModal-shift');
    modal.style.display = "none";
  }

  // Close the modal when the user clicks anywhere outside of the modal
  window.onclick = function(event) {
    var modal = document.getElementById('eventModal-shift');
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
});

$(document).on("click", "#delete_submit", function(){
  var formObject = document.getElementById('form');
  formObject.action = "{{route('staff_delete')}}";

  formObject.submit();
});

</script>

<!--ハンバーガーボタン（開閉操作のボタン）-->
<div id="menubar_hdr"></div>

<!--ページの上部へ戻るボタン-->
<div class="pagetop"><a href="#">↑</a></div>

</body>
</html>