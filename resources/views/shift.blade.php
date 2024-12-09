<?php
	if(Auth::user()->role == 'admin'){
		header('Location: ' . route('admin_menu'));
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
                            //echo 'editable: true,';
                            //echo 'selectable: true,';
                            echo '},';
            
                            $cnt = $cnt + 1;
                        }
                    }

                    foreach($holidays as $holiday){
                      echo "{";
                      echo "id: '".strval($i)."',";
                      echo "title: '有給 ".$holiday->state." ：".$holiday->user_name."',";
                      echo "start: '".$holiday->date." 00:00:00',";
                      echo "end: '".$holiday->date." 23:59:59',";
                      echo "},";

                      $i = $i + 1;
                  }
                ?>
                ],
	locale: 'ja',
	//timeZone: 'Asia/Tokyo',
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
      // Set the event details in the 
      var eventDate = info.event.start;
      var year = eventDate.getFullYear();
      var month = eventDate.getMonth() + 1; // Months are zero-based
      var day = eventDate.getDate();

	  var startTime = info.event.start.toLocaleString('ja-JP', { hour: '2-digit', minute: '2-digit' , timeZone: 'Asia/Tokyo'});
      var endTime = info.event.end ? info.event.end.toLocaleString('ja-JP', { hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Tokyo' }) : 'N/A';
	  console.log(startTime);
	  console.log(endTime);

      document.getElementById('modalBody-shift').innerHTML = `
        <p><strong>勤務者:</strong>${info.event.title}</p>
        <p><strong>勤務開始時刻:</strong><input type="time" name="start_time" value="${startTime}"></p>
        <p><strong>勤務終了時刻:</strong><input type="time" name="end_time" value="${endTime}"></p>
		<input type="hidden" name="date" value="${year}-${month}">
		<input type="hidden" name="full_date" value="${year}-${month}-${day}">

		<p class="btn">
			<input type="button" id="modify" value="変更">
			<input type="button" id="delete" value="削除">
		</p>
      `;

      // Show the modal
      var modal = document.getElementById('eventModal-shift');
      modal.style.display = "block";

      // Close the modal when the user clicks on <span> (x)
      var span = document.getElementsByClassName("close-shift")[0];
      span.onclick = function() {
        modal.style.display = "none";
      }

      // Close the modal when the user clicks anywhere outside of the modal
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

<h2>シフト確認</h2>
<form id="form" enctype="multipart/form-data" method="post" action="{{route('shift_add')}}">
@csrf
<input type="hidden" name="field_cnt" id="field_cnt" value="1">
<input type="hidden" id="del_url" value="{{route('shift_delete')}}">
<input type="hidden" id="mod_url" value="{{route('shift_modify')}}">

<div id='calendar'></div>
<h3>シフト追加</h3>
<div id="add_area">
	<section id="add_shift1">
		<ul>
		<?php
			//$stafftype_arr_material = [];
			//$staffname_arr_material = [];
			//foreach($users as $user){
			//	array_push($stafftype_arr_material, $user->stafftype);
			//	array_push($staffname_arr_material, $user->name);
			//}

			//$stafftype_arr = array_unique($stafftype_arr_material);
			//echo '<li><select name="stafftype" id="stafftype">';
			//echo '<option value="">スタッフ種別を選択してください</option>';
			//foreach($stafftype_arr as $stafftype){
			//	echo '<option value="'.$stafftype.'">'.$stafftype.'</option>';
			//}
			//echo '</select></li>';
			//echo '<li><select name="staffname1" id="staffname1">';
			//echo '<option value="">スタッフ名を選択してください</option>';
			//foreach($staffname_arr_material as $staffname){
			//	echo '<option value="'.$user->id.'">'.$staffname.'</option>';
			//}
			//echo '</select></li>';

			echo '<input type="hidden" name="staffname1" value="'.Auth::id().'">';
		?>

		<li><label>勤務日　：</label><input type="date" name="date1" id="date1"></label></li>
		<li><label>勤務時間：</label><input type="time" name="start_time1" id="start_time1">～<input type="time" name="end_time1" id="end_time1"></li>
		</ul>
	</section>
</div>

<p class="btn">
<input type="button" id="add" value="入力欄を追加する">
&nbsp;
<input type="button" id="del" value="入力欄を削除する">
</p>

<br>
<p class="btn">
	<input type="submit" value="シフト登録">
</p>

<br>
<p class="btn">
	<input type="button" onclick="location.href='{{route('user_menu_show')}}'" value="ユーザーメニュー"> 
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
<script src="{{asset('js/user_shift.js')}}"></script>

<!--ハンバーガーボタン（開閉操作のボタン）-->
<div id="menubar_hdr"></div>

<!--ページの上部へ戻るボタン-->
<div class="pagetop"><a href="#">↑</a></div>

</body>
</html>
