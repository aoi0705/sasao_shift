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
<title>求人サイト向け 無料ホームページテンプレート tp_job4</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="ここにサイト説明を入れます">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
	initialView: 'dayGridMonth',
	events: [
                <?php
                    $i = 1;
                    foreach($articles as $article){
                        echo "{";
                        echo "id: '".strval($i)."',";
                        echo "title: '".$article->user_name."',";
                        echo "start: '".$article->punch_in."',";
                        echo "end: '".$article->punch_out."',";
                        echo "url: '#'";
                        echo "},";

                        $i = $i + 1;
                    }
                ?>
                ],
	locale: 'ja',
	buttonText: {
		prev:     '<',
		next:     '>',
		prevYear: '<<',
		nextYear: '>>',
		today:    '今日',
		month:    '月',
		week:     '週',
		day:      '日',
		list:     '一覧'
	},
	headerToolbar: {
                    left: 'title',
                    center: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                    right: 'prev,today,next'
                },
  });
  calendar.render();
});

</script>
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

<h2>勤怠状況</h2>
<form method="post" action="{{route('excel_export')}}" enctype="multipart/form-data" id="form">
@csrf
<div id='calendar'></div>

<section>
	<h2>勤怠状況ダウンロード</h2>
	<div class="download_area">
	<select name="date" required>
	<option value="">選択してください</option>
	<?php
		$arr = array();

		foreach($articles as $article){
            $date = new DateTime($article->punch_in);
            $formattedDate = $date->format('Y年m月'); // Change the format as needed
            array_push($arr, $formattedDate);
		}

		$arr = array_unique($arr);

		foreach($arr as $date){
			echo "<option value='".$date."'>".$date."</option>";
		}
	?>
	</select>

	<p class="btn">
		<input type="submit" value="ダウンロード">
	</p>
	</div>
</section>

<p class="btn">
<input type="button" value="管理者画面" onclick="location.href='{{route('admin_menu')}}'">
</p>

</form>

</section>

</main>

<div id="footermenu">
<ul>
<li class="title">メニュー</li>
<li><a href="index.html">ホーム</a></li>
<li><a href="company.html">会社概要</a></li>
<li><a href="info.html">掲載のご案内</a></li>
<li><a href="faq.html">よく頂く質問</a></li>
<li><a href="contact.html">お問い合わせ</a></li>
</ul>
<ul>
<li class="title">求人一覧</li>
<li><a href="list.html">飲食店の求人</a></li>
<li><a href="list.html">営業の求人</a></li>
<li><a href="list.html">接客・販売の求人</a></li>
<li><a href="list.html">事務の求人</a></li>
</ul>
<ul>
<li class="title">メニュー見出し</li>
<li><a href="#">サンプルメニューサンプルメニュー</a></li>
<li><a href="#">サンプルメニュー</a></li>
<li><a href="#">サンプルメニュー</a></li>
<li><a href="#">サンプルメニュー</a></li>
</ul>
<ul>
<li class="title">メニュー見出し</li>
<li><a href="#">サンプルメニューサンプルメニュー</a></li>
<li><a href="#">サンプルメニュー</a></li>
<li><a href="#">サンプルメニュー</a></li>
<li><a href="#">サンプルメニュー</a></li>
</ul>
</div>
<!--/#footermenu-->

<footer>
<small>Copyright&copy; <a href="index.html">JOB INFO</a> All Rights Reserved.</small>
<span class="pr"><a href="https://template-party.com/" target="_blank">《Web Design:Template-Party》</a></span>
</footer>

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
