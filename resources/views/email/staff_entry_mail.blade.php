<?php

$data = session()->all();
$data_len = count($data);

echo 'スタッフ情報登録フォーム'.nl2br("\n");

echo nl2br("\n");

echo '以下のページよりスタッフ情報登録をお願い致します。'.nl2br("\n");
echo asset('/') . 'staff_entry/' . $_SESSION['staff_id'] .nl2br("\n");

echo nl2br("\n");

echo '※本メールにはご返信いただけません。'.nl2br("\n");