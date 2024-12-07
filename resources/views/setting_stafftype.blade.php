<?php
	if(Auth::user()->role == 'user'){
		header('Location: ' . route('user_menu_show'));
        exit();
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>勤怠管理システム</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="勤怠管理システム">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<style>
    ul{list-style-type: none;}
</style>
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

<h2>スタッフ種別設定</h2>

<!-- フォームの情報はここからです -->
<form enctype="multipart/form-data" method="post" action="{{route('setting_stafftype')}}">
@csrf

<ul id="add_area">
    <?php
        $arr = json_decode($article->stafftype_list,true);

        if(!empty($arr)){
            $cnt = 1;
            $count = count($arr);

            echo '<input type="hidden" id="field_cnt" value="'.$count.'">';

            foreach($arr as $key => $val){
                echo '<li>'.$cnt.'<ul>';
                echo '<li><label>種別名：<input type="text" name="type_name'.$cnt.'" value="'.$key.'" required></label></li>';
                echo '<li><label>時給　：<input type="number" name="wage'.$cnt.'" value="'.$val.'" required></label></li>';
                echo '</ul></li>';

                $cnt++;
            }
        }
        else{
            echo '<input type="hidden" id="field_cnt" value="1">';

            echo '<li>1<ul>';
            echo '<li><label>種別名：<input type="text" name="type_name1" required></label></li>';
            echo '<li><label>時給　：<input type="number" name="wage1" required></label></li>';
            echo '</ul></li>';
        }
    ?>
</ul>

<p class="btn">
    <input type="button" id="add" value="追加">
    &nbsp;
    <input type="button" id="del" value="削除">
</p>

<br>
<p class="btn">
<input type="submit" value="送信する">
&nbsp;
<input type="button" value="管理者設定画面" onclick="location.href='{{route('admin_config_show')}}'">
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
<script src="{{asset('js/setting_stafftype.js')}}"></script>

<!--ハンバーガーボタン（開閉操作のボタン）-->
<div id="menubar_hdr"></div>

<!--ページの上部へ戻るボタン-->
<div class="pagetop"><a href="#">↑</a></div>

</body>
</html>