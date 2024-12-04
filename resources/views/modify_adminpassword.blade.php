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

<h2>パスワード変更</h2>
<form id="form" method="post" enctype="multipart/form-data" action="{{route('modify_adminpassword_now')}}">
@csrf
<table class="ta1">
<tr>
<th>パスワード</th>
<td><input type="password" name="password" size="30" class="ws" required></td>
</tr>
<tr>
<th>パスワード（確認用）</th>
<td><input type="password" name="password_confirm" size="30" class="ws" required></td>
</tr>
</table>

<p class="btn">
<input type="submit" value="パスワードを変更する">
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
const form = document.getElementById('form');

form.addEventListener('submit',(e) => {
    const password = form.elements['password'].value;
    const password_confirm = form.elements['password_confirm'].value;
    if(password !== password_confirm){
        alert('パスワードが一致しません');
        e.preventDefault();
    }

    /*
    正規表現条件
    ・半角数字、半角英字のみ
    ・半角数字、半角英字がそれぞれ一文字以上使用されている
    ・文字数が8~16字以内
    */
    const password_regex = /^(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-Z]{8,16}$/;
    const password_value = document.getElementsByClassName('content__form')[0].value;
    // formのvalueを正規表現でチェック
    const password_value_checked_result = password_regex.test(password_value);
    
    if(password_value_checked_result == true){
        return true;
    }
    else{
        alert('パスワードは半角英数字を8~16字で設定してください');
        e.preventDefault();
        return false;
    }
});
</script>

<!--ハンバーガーボタン（開閉操作のボタン）-->
<div id="menubar_hdr"></div>

<!--ページの上部へ戻るボタン-->
<div class="pagetop"><a href="#">↑</a></div>

</body>
</html>