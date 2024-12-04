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
</ul>
</nav>
</header>

<main>

<section>

<h2>有給申請一覧</h2>

<!-- フォームの情報はここからです -->
<form name="form1" enctype="multipart/form-data" method="post" action="">
<h3>未承認</h3>
<table class="ta1">
<!--<tr><td colspan="2" class="auto"><strong>確認画面</strong></td></tr>-->
<!-- 入力／確認 -->
<!--<tr><th class="tamidashi" colspan="2">お問い合わせフォーム</th></tr>-->
<?php
foreach($articles as $article){
    if($article->state == "未承認"){
        echo "<tr>";
        echo "<th>ユーザー名：".$article->user_name."</th>";
        echo "<td>取得日　　：".$article->date."</td>";
        echo "<td>送信日時　：".$article->created_at."</td>";
        echo "<td><a href='".asset('holiday_approval')."/".$article->id."'>承認する</a></td>";
        echo "</tr>";
    }
}
?>
</table>

<h3>承認済み</h3>
<table class="ta1">
<!--<tr><td colspan="2" class="auto"><strong>確認画面</strong></td></tr>-->
<!-- 入力／確認 -->
<!--<tr><th class="tamidashi" colspan="2">お問い合わせフォーム</th></tr>-->
<?php
foreach($articles as $article){
    if($article->state == "承認済"){
        echo "<tr>";
        echo "<th>ユーザー名：".$article->user_name."</th>";
        echo "<td>取得日　　：".$article->date."</td>";
        echo "<td>送信日時　：".$article->created_at."</td>";
        echo "<td><a href='".asset('holiday_denial')."/".$article->id."'>差し戻す</a></td>";
        echo "</tr>";
    }
}
?>
</table>


<p class="btn">
<input type="submit" value="送信する">
&nbsp;
<input type="button" value="管理者画面" onclick="location.href='{{route('admin_menu')}}'">
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
