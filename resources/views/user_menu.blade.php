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

<h2>ユーザーメニュー</h2>

<ul class="menu">
<li><a href="{{route('stamp_entry')}}">打刻</a></li>
<li><a href="{{route('shift')}}">シフト確認</a></li>
<li><a href="{{route('attendance_show')}}">勤怠管理</a></li>
<li><a href="{{route('user_config_show')}}">ユーザ設定</a></li>
<li><a href="{{route('paid_holiday')}}">有給申請</a></li>
<li><a href="{{route('file_send')}}">ファイル送信</a></li>
</ul>

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