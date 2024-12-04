<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>勤怠管理システム</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="勤怠管理システム">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
			$cnt = 1;

			foreach($shifts as $shift){
				$start_arr = json_decode($shift->start_time,true);
				$end_arr = json_decode($shift->end_time,true);

				foreach($start_arr as $key => $value){
					$start_time = $value;
					$end_time = $end_arr[$key];

					echo '{';
					echo 'id: '.$cnt.',';
					echo 'title: "'.$shift->staff_name.'",';
					echo 'description: "' . $shift->staff_name . '：'.$key.' '.$start_time.'～'.$key.' '.$end_time.'",';
					echo 'start: "'.$key.' '.$start_time.'",';
					echo 'end: "'.$key.' '.$end_time.'",';
					echo 'editable: true,';
					echo 'selectable: true,';
					echo '},';
	
					$cnt = $cnt + 1;
				}
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
  });

  calendar.render();
});
</script>
<style>
.tooltip {
    position: absolute;
    z-index: 10001;
    background: #fff;
    border: 1px solid #ccc;
    padding: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

li{
  list-style:none;
  margin-bottom: 1%;
}
input {
      font-family: inherit;
      font-size: inherit;
      border-radius: .25rem;
      border: 1px solid #707070;
      outline: none;
      padding: 0.375em 0.75em;
}

input:focus {
	border-color: rgba(var(--color_rgb), .5);
	box-shadow: 0 0 3px 1px rgba(var(--color_rgb), .5);
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
</ul>
</nav>
</header>

<main>

<section>

<h2>シフト登録</h2>
<form enctype="multipart/form-data" method="post" action="{{route('shift_add')}}">
@csrf
<input type="hidden" name="field_cnt" id="field_cnt" value="1">

<div id='calendar'></div>

<h3>シフト追加</h3>
<div id="add_area">
	<section id="add_shift1">
		<ul>
		<?php
			$stafftype_arr_material = [];
			$staffname_arr_material = [];
			foreach($users as $user){
				array_push($stafftype_arr_material, $user->stafftype);
				array_push($staffname_arr_material, $user->name);
			}

			$stafftype_arr = array_unique($stafftype_arr_material);
			//echo '<li><select name="stafftype" id="stafftype">';
			//echo '<option value="">スタッフ種別を選択してください</option>';
			//foreach($stafftype_arr as $stafftype){
			//	echo '<option value="'.$stafftype.'">'.$stafftype.'</option>';
			//}
			//echo '</select></li>';
			echo '<li><select name="staffname1" id="staffname1" required>';
			echo '<option value="">スタッフ名を選択してください</option>';
			foreach($staffname_arr_material as $staffname){
				echo '<option value="'.$user->id.'">'.$staffname.'</option>';
			}
			echo '</select></li>';
		?>

		<li><label><input type="date" name="date1" id="date1" required></label></li>
		<li><input type="time" name="start_time1" id="start_time1" required>～<input type="time" name="end_time1" id="end_time1" required></li>
		</ul>
	</section>
</div>

<p class="btn">
<input type="button" id="add" value="入力欄を追加する">
<input type="button" id="del" value="入力欄を削除する">
</p>

<br>
<p class="btn">
<input type="submit" value="シフト登録">
&nbsp;
<input type="button" value="管理者画面" onclick="location.href='{{route('admin_menu')}}'">
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
<script>
	$(document).on("click", "#add", function(){

		var field_cnt = $('#field_cnt').val();
		var cnt = Number(field_cnt)+1;

		if(cnt > 10){
			alert('最大10個までです');
			return false;
		}

		var newField = $('<section id="add_shift'+cnt+'">' +
			'<ul>' +
			//'<li><select name="stafftype" id="stafftype">' +
			//'<option value="">スタッフ種別を選択してください</option>' +
			//'</select>' +
			//'</li>' +
			'<li><select name="staffname' + cnt + '" id="staffname' + cnt + '" required>' +
			'<option value="">スタッフ名を選択してください</option>' +
			'</select>' +
			'</li>' +
			'<li><input type="date" name="date' + cnt + '" id="date' + cnt + '" required></li>' +
			'<li><input type="time" name="start_time' + cnt + '" id="start_time' + cnt + '" required>～<input type="time" name="end_time' + cnt + '" id="end_time' + cnt + '" required></li>' +
			'</ul>' +
			'</section>'
		);

		$('#add_area').append(newField);
		var field_cnt = $('#field_cnt').val(cnt)
	});

	$(document).on("click", "#del", function(){
		var field_cnt = $('#field_cnt').val();
		var cnt = Number(field_cnt)-1;

		if(cnt < 1){
			alert('1個以上必要です');
			return false;
		}

		$('#add_shift'+field_cnt).remove();
		var field_cnt = $('#field_cnt').val(cnt)
	});
</script>

<!--ハンバーガーボタン（開閉操作のボタン）-->
<div id="menubar_hdr"></div>

<!--ページの上部へ戻るボタン-->
<div class="pagetop"><a href="#">↑</a></div>

</body>
</html>