<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>求人サイト向け 無料ホームページテンプレート tp_job4</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="ここにサイト説明を入れます">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>

<div id="container">

<header>
<h1 id="logo"><a href="index.html"><img src="images/logo.png" alt="JOB INFO"></a></h1>
<!--メインメニュー-->
<nav id="menubar">
<ul>
<li><a href="">求人一覧<span>Recruit</span></a>
	<ul>
	<li><a href="list.html">飲食店の求人</a></li>
	<li><a href="list.html">営業の求人</a></li>
	<li><a href="list.html">接客・販売の求人</a></li>
	<li><a href="list.html">事務の求人</a></li>
	</ul>
</li>
<li><a href="info.html">掲載のご案内<span>Information</span></a></li>
<li><a href="">よく頂く質問<span>Faq</span></a>
	<ul>
	<li><a href="faq.html">求人に関するご質問</a></li>
	<li><a href="faq.html">掲載に関するご質問</a></li>
	</ul>
</li>
<li><a href="contact.html">お問い合わせ<span>Contact</span></a></li>
</ul>
</nav>
</header>

<main>

<section>

<h2>お問い合わせ</h2>

<form id="form" action="{{route('staff_entry_confirm')}}" method="post" enctype="multipart/form-data">
@csrf
<input type="hidden" id="field_cnt" name="field_cnt" value="1">
<input type="hidden" name="id" value="{{$_SESSION['id']}}">
<table class="ta1" id="entry_form">
<tr>
<th>スタッフ種別※</th>
<td>{{$article->stafftype}}
<input type="hidden" name="stafftype" value="{{$article->stafftype}}">
<td>
</tr>
<tr>
<th>メールアドレス※</th>
<td><input type="email" name="email" size="30" class="ws" value="{{$_SESSION['email']}}" required></td>
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
<tr>
<th>ふりがな</th>
<td><input type="text" name="furigana" size="30" class="ws" required></td>
</tr>
<tr>
<th>性別</th>
<td>
    <select name="sex" id="sex" required>
        <option value="">性別を選択してください</option>
        <option value="男性">男性</option>
        <option value="女性">女性</option>
    </select>
</td>
</tr>
<tr>
<th>郵便番号</th>
<td><input type="text" name="postnumber" size="30" class="ws" required></td>
</tr>
<tr>
<th>住所</th>
<td><input type="text" name="address" size="30" class="ws" required></td>
</tr>
<tr>
<th>最寄り路線</th>
<td><input type="text" name="train_route" size="30" class="ws" required></td>
</tr>
<tr>
<th>最寄り駅</th>
<td><input type="text" name="station" size="30" class="ws" required></td>
</tr>
<tr>
<th>マイナンバー</th>
<td><input type="text" name="mynumber" size="30" class="ws" required></td>
</tr>
<tr>
<th>扶養の有無</th>
<td>
    <select name="dependent" id="dependent">
        <option value="無">無</option>
        <option value="有">有</option>
    </select>
</td>
</tr>
</table>

<div id="dependent_area">
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