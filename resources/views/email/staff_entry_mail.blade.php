<?php

// セッションの値を全て取得
$data = session()->all();
$data_len = count($data);

echo 'スタッフ情報登録フォーム'.nl2br("\n");

echo nl2br("\n");

echo '以下のページよりスタッフ情報登録をお願い致します。'.nl2br("\n");
echo 'http://localhost:8000/staff_entry/' . $_SESSION['staff_id'] .nl2br("\n");

echo nl2br("\n");

echo '※本メールにはご返信いただけません。'.nl2br("\n");