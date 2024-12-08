<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>勤怠管理システム</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="勤怠管理システム">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>

<div id="container">

<header>
<h1 id="logo"><a href="index.html"><img src="images/logo.png" alt="JOB INFO"></a></h1>
</header>

<main>

<section>

<h2>スタッフ登録情報確認</h2>

<!-- フォームの情報はここからです -->
<form enctype="multipart/form-data" method="post" action="{{route('staff_entry_now')}}">
@csrf
<table class="ta1">
<tr>
<th>スタッフ種別※</th>
<td>{{$_SESSION['stafftype']}}</td>
<input type="hidden" name="stafftype" value="{{$_SESSION['stafftype']}}">
</tr>
<tr>
<th>メールアドレス※</th>
<td>{{$_SESSION['email']}}</td>
</tr>
<tr>
<th>お名前※</th>
<td>{{$_SESSION['name']}}</td>
</tr>
<tr>
<th>ふりがな</th>
<td>{{$_SESSION['furigana']}}</td>
</tr>
<tr>
<th>性別</th>
<td>
{{$_SESSION['sex']}}
</td>
</tr>
<tr>
<th>郵便番号</th>
<td>{{$_SESSION['postnumber']}}</td>
</tr>
<tr>
<th>住所</th>
<td>{{$_SESSION['address']}}</td>
</tr>
<tr>
<th>最寄り路線</th>
<td>{{$_SESSION['train_route']}}</td>
</tr>
<tr>
<th>最寄り駅</th>
<td>{{$_SESSION['station']}}</td>
</tr>
<tr>
<th>マイナンバー</th>
<td>{{$_SESSION['mynumber']}}</td>
</tr>
<tr>
<th>扶養の有無</th>
<td>
{{$_SESSION['dependent']}}
</td>
</tr>
@if($_SESSION['dependent'] == '有')
<?php
    for($i=1;$i<=$_SESSION['field_cnt'];$i++){
        echo '<tr>';
        echo '<th>扶養者の年収</th>';
        echo '<td>';
        echo $_SESSION['dependent_income'.$i];
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>扶養者の名前</th>';
        echo '<td>';
        echo $_SESSION['dependent_name'.$i];
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>扶養者のふりがな</th>';
        echo '<td>';
        echo $_SESSION['dependent_furigana'.$i];
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>扶養者の性別</th>';
        echo '<td>';
        echo $_SESSION['dependent_sex'.$i];
        echo '</td>';
        echo '</tr>';
    }
?>
@endif
</table>

<p class="btn">
<input type="submit" value="送信する">
&nbsp;
<input type="button" value="戻る" onclick="location.href='{{route('staff_entrysend_back')}}'">
</p>

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

<!--ハンバーガーボタン（開閉操作のボタン）-->
<div id="menubar_hdr"></div>

<!--ページの上部へ戻るボタン-->
<div class="pagetop"><a href="#">↑</a></div>

</body>
</html>