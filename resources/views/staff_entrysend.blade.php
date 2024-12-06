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

<h2>スタッフ登録メール送信</h2>
<form method="post" enctype="multipart/form-data" action="{{route('entry_mail')}}">
@csrf
<table class="ta1">
<tr>
<th>メールアドレス※</th>
<td><input type="email" name="email" size="30" class="ws" required></td>
</tr>
<tr>
<th>スタッフ種別</th>
<td>
    <select name="stafftype" required>
		<option value="">スタッフ種別を選択して下さい</option>
        <option value="正社員">正社員</option>
        <option value="アルバイト">アルバイト</option>
        <option value="パート">パート</option>
    </select>
</td>
</tr>
</table>

<p class="btn">
<input type="submit" value="メールを送信する">
</p>
<form>

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