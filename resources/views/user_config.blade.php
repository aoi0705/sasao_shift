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
		<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf
        </form></li>
	</ul>
</li>
</ul>
</nav>
</header>

<main>

<section>

<h2>ユーザー情報</h2>
<form id="form" method="post" action="{{route('user_config_modify')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" id="field_cnt" name="field_cnt" value="1">

<h3>基本情報</h3>
<table class="ta1">
<tr>
<th>お名前※</th>
<td><input type="text" name="name" size="30" class="ws" value="{{Auth::user()->name}}" required></td>
</tr>
<tr>
<th>ふりがな※</th>
<td><input type="text" name="furigana" size="30" class="ws" value="{{Auth::user()->furigana}}" required></td>
</tr>
<tr>
<th>性別※</th>
<td>
<select name="sex">
    <option value="男性" @if(Auth::user()->sex == "男性") selected @endif>男性</option>
    <option value="女性" @if(Auth::user()->sex == "女性") selected @endif>女性</option>
</select>
</td>
</tr>
<tr>
<th>郵便番号※</th>
<td><input name="postnumber" size="30" class="ws" value="{{Auth::user()->postnumber}}" required></input></td>
</tr>
<tr>
<th>住所※</th>
<td><input name="address" size="30" class="ws" value="{{Auth::user()->address}}" required></input></td>
</tr>
<tr>
<th>最寄り路線※</th>
<td><input name="train_route" size="30" class="ws" value="{{Auth::user()->train_route}}" required></input></td>
</tr>
<tr>
<th>最寄り駅※</th>
<td><input name="station" size="30" class="ws" value="{{Auth::user()->station}}" required></input></td>
</tr>
<tr>
<th>マイナンバー※</th>
<td><input name="mynumber" size="30" class="ws" value="{{Auth::user()->mynumber}}" required></input></td>
</tr>
<tr>
<th>扶養の有無※</th>
<td>
    <select name="dependent" id="dependent">
        <option value="無" @if(Auth::user()->dependent == "無") selected @endif>無</option>
        <option value="有" @if(Auth::user()->dependent == "有") selected @endif>有</option>
    </select>
</td>
</tr>
</table>

<?php
    $income_arr = json_decode(Auth::user()->dependent_income, true);
    $name_arr = json_decode(Auth::user()->dependent_name, true);
    $furigana_arr = json_decode(Auth::user()->dependent_furigana, true);
    $sex_arr = json_decode(Auth::user()->dependent_sex, true);

    if(Auth::user()->dependent == "有"){
        echo "<table class='ta1'>";
        for($i=1;$i<=6;$i++){
            if(!array_key_exists('dependent_income'.$i, $income_arr)){
                echo '<input type="hidden" name="field_cnt" value="' . $i-1 . '">';
                break;
            }

            echo "<h3>扶養家族の情報{$i}</h3>";
            echo "<tr>";
            echo "<th>扶養家族の年収</th>";
            echo "<td><input name='dependent_income{$i}' size='30' class='ws' value='" . $income_arr['dependent_income'.$i] . "' required></input></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>扶養家族のお名前</th>";
            echo "<td><input name='dependent_name{$i}' size='30' class='ws' value='" . $name_arr['dependent_name'.$i] . "' required></input></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>扶養家族のふりがな</th>";
            echo "<td><input name='dependent_furigana{$i}' size='30' class='ws' value='" . $furigana_arr['dependent_furigana'.$i] . "' required></input></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>扶養家族の性別</th>";
            echo "<td>";
            echo "<select name='dependent_sex{$i}'>";
            echo "<option value='男性' " . ($sex_arr['dependent_sex'.$i] == "男性" ? "selected" : "") . ">男性</option>";
            echo "<option value='女性' " . ($sex_arr['dependent_sex'.$i] == "女性" ? "selected" : "") . ">女性</option>";
            echo "</select>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
?>
</table>

<div id="dependent_area">
</div>

<p class="btn">
<input type="submit" value="変更する">
&nbsp;
<input type="button" value="ユーザーメニュー" onclick="location.href='{{route('user_menu_show')}}'">
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
<!--<script>
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
</script> -->

<!--ハンバーガーボタン（開閉操作のボタン）-->
<div id="menubar_hdr"></div>

<!--ページの上部へ戻るボタン-->
<div class="pagetop"><a href="#">↑</a></div>

</body>
</html>