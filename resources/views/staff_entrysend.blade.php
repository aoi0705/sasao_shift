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
        <?php
			$arr = json_decode($articles->stafftype_list,true);

			foreach($arr as $key => $val){
				echo "<option value='{$key}'>{$key}</option>";
			}
		?>
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