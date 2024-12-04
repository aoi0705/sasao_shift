<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>勤怠管理システム</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="勤怠管理システム">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>

<div id="container">

<header>
<h1 id="logo"><a href="{{route('user_menu_show')}}"><img src="images/logo.png" alt="JOB INFO"></a></h1>
<!--メインメニュー-->
<nav id="menubar">
<ul>
<li><a href="{{route('stamp_entry')}}">打刻</a></li>
<li><a href="{{route('attendance_show')}}">勤怠確認</a></li>
<li><a href="{{route('shift')}}">シフト確認</a></li>
<li><a href="{{route('paid_holiday')}}">有給申請</a></li>
<li><a href="{{route('file_send')}}">ファイル送信</a></li>
<li><a href="">{{Auth::user()->name}}</a>
	<ul>
		<li><a href="">パスワード変更</a></li>
		<li><a href="{{route('logout')}}">ログアウト</a></li>
	</ul>
</li>
</ul>
</nav>
</header>

<main>

<section>

<h2>打刻</h2>
<form action="" method="post" enctype="multipart/form-data" id="form">
<input type="hidden" value="" name="start_time" id="start_time">
<input type="hidden" value="" name="end_time" id="end_time">
<input type="hidden" value="" name="break_time1" id="break_time1">
<input type="hidden" value="" name="break_time2" id="break_time2">

<div id="clock-container">
	<div id="date"></div>
	<div id="clock"></div>
</div>

<?php
    //勤務状態によって表示かえる
    if($article->stamp_state == '稼働中'){
        echo '<p class="btn" id="start" style="display:none;">';
        echo '<input type="button" id="work_start" value="勤務開始">';
        echo '</p>';

        echo '<p class="btn" id="end">';
        echo '<input type="button" id="work_end" value="勤務終了">';
        echo '</p>';

        echo '<div id="work_area">';
        echo '<p>勤務開始：'.$stamp->punch_in.'</p>';
        echo '</div>';
    }
    else{
        echo '<p class="btn" id="start">';
        echo '<input type="button" id="work_start" value="勤務開始">';
        echo '</p>';

        echo '<p class="btn" id="end" style="display:none;">';
        echo '<input type="button" id="work_end" value="勤務終了">';
        echo '</p>';

        echo '<div id="work_area">';
        echo '</div>';
    }
?>

<br>
<p class="btn">
	<input type="button" onclick="location.href='{{route('user_menu_show')}}'" value="ユーザーメニュー"> 
</p>

</form>

</section>

</main>

</div>
<!--/#container-->

<!--jQueryの読み込み-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!--job4用のスクリプト-->
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/user_stampentry.js')}}"></script>

<!--ハンバーガーボタン（開閉操作のボタン）-->
<div id="menubar_hdr"></div>

<!--ページの上部へ戻るボタン-->
<div class="pagetop"><a href="#">↑</a></div>

</body>
</html>
