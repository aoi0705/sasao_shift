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

<h2>管理者設定</h2>

<!-- フォームの情報はここからです -->
<form enctype="multipart/form-data" method="post" action="{{route('user_config_modify')}}">
@csrf
<table class="ta1">
<!--<tr><td colspan="2" class="auto"><strong>確認画面</strong></td></tr>-->
<!-- 入力／確認 -->
<!--<tr><th class="tamidashi" colspan="2">お問い合わせフォーム</th></tr>-->
<tr>
<th width="150">管理者アカウントのメールアドレス変更</th>
<td>
<input type="email" name="email" value="{{$article[0]->email}}" required>
</td>
</tr>
<tr>
<th width="150">管理者アカウントのパスワード変更</th>
<td>
<p class="btn">
    <input type="button" id="password" value="パスワード変更はこちら" onclick="location.href='{{route('modify_adminpassword')}}'">
</p>
</td>
</tr>
<tr>
<th width="150">スタッフ種別設定</th>
<td>
<p class="btn">
    <input type="button" id="setting_stafftype" value="スタッフ種別設定はこちら" onclick="location.href='{{route('setting_stafftype_show')}}'">
</p>
</td>
</tr>
</table>

<p class="btn">
<input type="submit" value="送信する">
&nbsp;
<input type="button" value="管理者画面" onclick="location.href='{{route('admin_menu')}}'">
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