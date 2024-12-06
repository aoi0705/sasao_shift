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

<h2>管理者情報登録</h2>

<form id="form" action="{{route('admin_entryconfirm')}}" method="post" enctype="multipart/form-data">
@csrf
<input type="hidden" id="field_cnt" name="field_cnt" value="1">
<table class="ta1" id="entry_form">
<tr>
<th>メールアドレス※</th>
<td><input type="email" name="email" size="30" class="ws" value="" required></td>
</tr>
<tr>
<th>パスワード※</th>
<td><input type="password" name="password" size="30" class="ws" required></td>
</tr>
<tr>
<th>パスワード（確認用）※</th>
<td><input type="password" name="password_confirm" size="30" class="ws" required></td>
</tr>
<tr>
<th>お名前※</th>
<td><input type="text" name="name" size="30" class="ws" required></td>
</tr>
</table>

<p class="btn">
<input type="submit" value="内容を確認する">
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
    $('#dependent').on('change', function () {

        if($('#dependent').val() == '有') {
            var newField = $('<div id="dependent_bio1">' +
            '<h2>扶養者情報1</h2>' +
            '<table class="ta1">' +
            '<tr>' +
            '<th>扶養者の年収</th>' +
            '<td><input type="text" name="dependent_income1" size="30" class="ws" required></td>' +
            '</tr>' +
            '<tr>' +
            '<th>扶養者の名前</th>' +
            '<td><input type="text" name="dependent_name1" size="30" class="ws" required></td>' +
            '</tr>' +
            '<tr>' +
            '<th>扶養者のふりがな</th>' +
            '<td><input type="text" name="dependent_furigana1" size="30" class="ws" required></td>' +
            '</tr>' +
            '<tr>' +
            '<th>扶養者の性別</th>' +
            '<td><select name="dependent_sex1" id="dependent_sex1" required><option value="">性別を選択してください</option><option value="男性">男性</option><option value="女性">女性</option></select></td>' +
            '</tr>' +
            '</table>' +
			'</div>'
		    );
            
            $('#dependent_area').append(newField);
        } else {
            $('#dependent_bio1').remove();
        }
    });

    $(document).on("click", "#add", function(){
        var cnt = $('#field_cnt').val();
        var after_cnt = parseInt(cnt) + 1;
        $('#field_cnt').val(String(after_cnt));

        var newField = $('<div id="dependent_bio' + String(after_cnt) + '">' +
            '<h2>扶養者情報' + String(after_cnt) + '</h2>' +
            '<table class="ta1">' +
            '<tr>' +
            '<th>扶養者の年収</th>' +
            '<td><input type="text" name="dependent_income' + String(after_cnt) + '" size="30" class="ws" required></td>' +
            '</tr>' +
            '<tr>' +
            '<th>扶養者の名前</th>' +
            '<td><input type="text" name="dependent_name' + String(after_cnt) + '" size="30" class="ws" required></td>' +
            '</tr>' +
            '<tr>' +
            '<th>扶養者のふりがな</th>' +
            '<td><input type="text" name="dependent_furigana' + String(after_cnt) + '" size="30" class="ws" required></td>' +
            '</tr>' +
            '<tr>' +
            '<th>扶養者の性別</th>' +
            '<td><select name="dependent_sex' + String(after_cnt) + '" id="dependent_sex'+String(after_cnt)+'" required><option value="">性別を選択してください</option><option value="男性">男性</option><option value="女性">女性</option></select></td>' +
            '</tr>' +
            '</table>' +
            '</div>'
        );
        $('#dependent_area').append(newField);

    });

    $(document).on("click", "#remove", function(){
        var cnt = $('#field_cnt').val();
        var after_cnt = parseInt(cnt) - 1;
        $('#field_cnt').val(String(after_cnt));

        $('#dependent_bio' + String(cnt)).remove();
    });
</script>

<!--ハンバーガーボタン（開閉操作のボタン）-->
<div id="menubar_hdr"></div>

<!--ページの上部へ戻るボタン-->
<div class="pagetop"><a href="#">↑</a></div>

</body>
</html>