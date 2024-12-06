<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>勤怠管理システム</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="勤怠管理システム">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<style>
ul{
    list-style: none;
}
</style>
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
		<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf
        </form></li>
	</ul>
</li>
</ul>
</nav>
</header>


<main>

<section>

<h2>変更できる勤務</h2>
<form action="{{route('attendance_modify_now')}}" method="post" enctype="multipart/form-data" id="form">
@csrf
<table class="ta1">
<?php
	$now_date = new DateTime(date("Y-m-d H:i:s"));
	$cnt = 1;

    foreach($articles as $article){
        $date = new DateTime($article->punch_out);
		$add_date = $date->modify('+15 minute'); 
		$date = new DateTime($article->punch_out);

		if($add_date >= $now_date and $article->punch_out != null){
			$in_date = new Datetime($article->punch_in);
			$day = $in_date->format('Y-m-d');

			$start_time = $in_date->format('H:i');
			$end_time = $date->format('H:i');

			echo "<tr>";
			echo '<th>勤務日：'.$day.'</th>';
			echo '<input type="hidden" name="day'.$cnt.'" value="'.$day.'">';
			echo "<td>";
			echo '<ul>';
			echo '<li>勤務開始：<input type="time" name="punch_in'.$cnt.'" value="'.$start_time.'"></li>';
			echo '<li>勤務終了：<input type="time" name="punch_out'.$cnt.'" value="'.$end_time.'"></li>';
			echo '<input type="hidden" name="id'.$cnt.'" value="'.$article->id.'">';
			echo '</ul>';
			echo "</td>";
			echo "</tr>";

			$cnt = $cnt + 1;
		}
    }
?>
</table>

<p class="btn">
<input type="submit" value="勤務変更する">
&nbsp;
<input type="button" value="勤怠確認に戻る" onclick="location.href='{{route('attendance_show')}}'">
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

<!--ハンバーガーボタン（開閉操作のボタン）-->
<div id="menubar_hdr"></div>

<!--ページの上部へ戻るボタン-->
<div class="pagetop"><a href="#">↑</a></div>

</body>
</html>