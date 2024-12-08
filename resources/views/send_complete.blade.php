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

<main>

<section>

<h2>送信完了</h2>

<form name="form1" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER["REQUEST_URI"];?>">
<input type="hidden" name="mode" value="finish" />
<p>送信が完了しました。</p>
</form>

<p class="btn">
	<input type="button" value="ログイン" onclick="location.href='./'">
</p>

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