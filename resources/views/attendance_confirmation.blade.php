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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.11.0/main.min.js'></script>
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
	selectable: true,
	editable: true,
    eventClick: function(info) {
      var eventDate = info.event.start;
      var year = eventDate.getFullYear();
      var month = eventDate.getMonth() + 1;
      var day = eventDate.getDate();

	  var startTime = info.event.start.toLocaleString('ja-JP', { hour: '2-digit', minute: '2-digit' , timeZone: 'Asia/Tokyo'});
      var endTime = info.event.end ? info.event.end.toLocaleString('ja-JP', { hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Tokyo' }) : 'N/A';

      document.getElementById('modalBody-shift').innerHTML = `
        <p><strong>勤務者:</strong>${info.event.title}</p>
        <p><strong>勤務開始時刻:</strong>${startTime}</p>
        <p><strong>勤務終了時刻:</strong>${endTime}</p>
      `;

      var modal = document.getElementById('eventModal-shift');
      modal.style.display = "block";

      var span = document.getElementsByClassName("close-shift")[0];
      span.onclick = function() {
        modal.style.display = "none";
      }

      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
    }
  });
  calendar.render();
});

</script>
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
            $formattedDate = $date->format('Y年m月');
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
