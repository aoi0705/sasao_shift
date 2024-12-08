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

<h2>管理者情報登録</h2>

<form id="form" action="{{route('admin_entryconfirm')}}" method="post" enctype="multipart/form-data">
@csrf
<input type="hidden" id="field_cnt" name="field_cnt" value="1">
<table class="ta1" id="entry_form">
<tr>
<th>メールアドレス</th>
<td>
    @if(isset($_SESSION['email']))
        <input type="email" name="email" size="30" class="ws" value="{{$_SESSION['email']}}" required>
    @else
        <input type="email" name="email" size="30" class="ws" value="" required>
    @endif
</td>
</tr>
<tr>
<th>パスワード</th>
<td><input type="password" id="password" name="password" size="30" class="ws" required></td>
</tr>
<tr>
<th>パスワード（確認用）</th>
<td>
    <input type="password" id="confirmPassword" name="password_confirm" size="30" class="ws" required>
    <br>
    <span id="message"></span>
</td>
</tr>
<tr>
<th>お名前</th>
<td>
    @if(isset($_SESSION['name']))
    <input type="text" name="name" size="30" class="ws" value="{{$_SESSION['name']}}" required>
    @else
        <input type="text" name="name" size="30" class="ws" value="" required>
    @endif
</td>
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
<script src="{{asset('js/password.js')}}"></script>


<!--ハンバーガーボタン（開閉操作のボタン）-->
<div id="menubar_hdr"></div>

<!--ページの上部へ戻るボタン-->
<div class="pagetop"><a href="#">↑</a></div>

</body>
</html>