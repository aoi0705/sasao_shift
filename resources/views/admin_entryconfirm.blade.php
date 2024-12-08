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
</header>

<main>

<section>

<h2>管理者登録情報確認</h2>

<!-- フォームの情報はここからです -->
<form enctype="multipart/form-data" method="post" action="{{route('admin_entrynow')}}">
@csrf
<table class="ta1">
<tr>
<th>メールアドレス※</th>
<td>{{$_SESSION['email']}}</td>
</tr>
<tr>
<th>お名前※</th>
<td>{{$_SESSION['name']}}</td>
</tr>
</table>

<p class="btn">
<input type="submit" value="送信する">
&nbsp;
<input type="button" value="戻る" onclick="location.href='{{route('admin_entry_back')}}'">
</p>

</form>
<!-- フォームの情報はここまでです -->

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