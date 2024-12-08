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
<h1 id="logo"><a href="index.html"><img src="images/logo.png" alt="JOB INFO"></a></h1>
</header>

<main>

<section>

<h2>スタッフ登録フォーム</h2>

<form id="form" action="{{route('staff_entry_confirm')}}" method="post" enctype="multipart/form-data">
@csrf
@if(isset($_SESSION['field_cnt']))
<input type="hidden" id="field_cnt" name="field_cnt" value="{{$_SESSION['field_cnt']}}">
@else
<input type="hidden" id="field_cnt" name="field_cnt" value="1">
@endif
<input type="hidden" name="id" value="{{$_SESSION['id']}}">
<table class="ta1" id="entry_form">
<tr>
<th>スタッフ種別※</th>
<td>
@if(isset($_SESSION['stafftype']))
{{$_SESSION['stafftype']}}
<input type="hidden" name="stafftype" value="{{$_SESSION['stafftype']}}">
@else
{{$article->stafftype}}
<input type="hidden" name="stafftype" value="{{$article->stafftype}}">
@endif
<td>
</tr>
<tr>
<th>メールアドレス※</th>
<td>
<input type="email" name="email" size="30" class="ws" value="{{$_SESSION['email']}}" required>
</td>
</tr>
<tr>
<th>パスワード※</th>
<td><input type="password" id="password" name="password" size="30" class="ws" required></td>
</tr>
<tr>
<th>パスワード（確認用）※</th>
<td>
    <input type="password" id="confirmPassword" name="password_confirm" size="30" class="ws" required>
    <br>
    <span id="message"></span>
</td>
</tr>
<tr>
<th>お名前※</th>
<td>
    @if(isset($_SESSION['name']))
        <input type="text" name="name" size="30" class="ws" value="{{$_SESSION['name']}}" required>
    @else
        <input type="text" name="name" size="30" class="ws" value="" required>
    @endif
</td>
</tr>
<tr>
<th>ふりがな</th>
<td>
@if(isset($_SESSION['furigana']))
    <input type="text" name="furigana" size="30" class="ws" value="{{$_SESSION['furigana']}}" required>
@else
    <input type="text" name="furigana" size="30" class="ws" required>
@endif
</td>
</tr>
<tr>
<th>性別</th>
<td>
<select name="sex" id="sex" required>
        <option value="">性別を選択してください</option>
        <option value="男性" {{ isset($_SESSION['sex']) && $_SESSION['sex'] == '男性' ? 'selected' : '' }}>男性</option>
        <option value="女性" {{ isset($_SESSION['sex']) && $_SESSION['sex'] == '女性' ? 'selected' : '' }}>女性</option>
    </select>
</td>
</tr>
<tr>
<th>郵便番号</th>
<td>
@if(isset($_SESSION['postnumber']))
    <input type="text" name="postnumber" size="30" class="ws" value="{{$_SESSION['postnumber']}}" required>
@else
    <input type="text" name="postnumber" size="30" class="ws" required>
@endif
</td>
</tr>
<tr>
<th>住所</th>
<td>
@if(isset($_SESSION['address']))
    <input type="text" name="address" size="30" class="ws" value="{{$_SESSION['address']}}" required>
@else
    <input type="text" name="address" size="30" class="ws" required>
@endif
</td>
</tr>
<tr>
<th>最寄り路線</th>
<td>
@if(isset($_SESSION['train_route']))
    <input type="text" name="train_route" size="30" class="ws" value="{{$_SESSION['train_route']}}" required>
@else
    <input type="text" name="train_route" size="30" class="ws" required>
@endif
</td>
</tr>
<tr>
<th>最寄り駅</th>
<td>
@if(isset($_SESSION['station']))
    <input type="text" name="station" size="30" class="ws" value="{{$_SESSION['station']}}" required>
@else
    <input type="text" name="station" size="30" class="ws" required>
@endif
</td>
</tr>
<tr>
<th>マイナンバー</th>
<td>
@if(isset($_SESSION['mynumber']))
    <input type="text" name="mynumber" size="30" class="ws" value="{{$_SESSION['mynumber']}}" required>
@else
    <input type="text" name="mynumber" size="30" class="ws" required>
@endif
</td>
</tr>
<tr>
<th>扶養の有無</th>
<td>
<select name="dependent" id="dependent">
        <option value="無" {{ isset($_SESSION['dependent']) && $_SESSION['dependent'] == '無' ? 'selected' : '' }}>無</option>
        <option value="有" {{ isset($_SESSION['dependent']) && $_SESSION['dependent'] == '有' ? 'selected' : '' }}>有</option>
    </select>
</td>
</tr>
</table>

<div id="dependent_area">
<?php
    if(isset($_SESSION['dependent']) && $_SESSION['dependent'] == '有'){
        for($i=1;$i<=$_SESSION['field_cnt'];$i++){
            echo '<div id="dependent_bio'.$i.'">';
            echo '<h2>扶養者情報'.$i.'</h2>';
            echo '<table class="ta1">';
            echo '<tr>';
            echo '<th>扶養者の年収</th>';
            echo '<td>';
            echo '<input type="text" name="dependent_income'.$i.'" size="30" class="ws" value="'.$_SESSION['dependent_income'.$i].'" required>';
            echo '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<th>扶養者の名前</th>';
            echo '<td>';
            echo '<input type="text" name="dependent_name'.$i.'" size="30" class="ws" value="'.$_SESSION['dependent_name'.$i].'" required>';
            echo '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<th>扶養者のふりがな</th>';
            echo '<td>';
            echo '<input type="text" name="dependent_furigana'.$i.'" size="30" class="ws" value="'.$_SESSION['dependent_furigana'.$i].'" required>';
            echo '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<th>扶養者の性別</th>';
            echo '<td>';
            echo '<select name="sex'.$i.'" id="sex'.$i.'">';
            echo '<option value="男性" '.(isset($_SESSION['sex'.$i]) && $_SESSION['sex'.$i] == '男性' ? 'selected' : '').'>男性</option>';
            echo '<option value="女性" '.(isset($_SESSION['sex'.$i]) && $_SESSION['sex'.$i] == '女性' ? 'selected' : '').'>女性</option>';
            echo '</select>';
            echo '</td>';
            echo '</tr>';
            echo '</table>';
            echo '</div>';
        }
    }
?>
</div>

<p class="btn">
    <input type="button" value="追加" id="add">
    <input type="button" value="削除" id="remove">
</p>

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
<script src="{{asset('js/password.js')}}"></script>

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