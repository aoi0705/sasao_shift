function updateClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const dayOfWeek = ["日", "月", "火", "水", "木", "金", "土"][now.getDay()];
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');

    document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
    document.getElementById('date').textContent = `${year}年${month}月${day}日 (${dayOfWeek})`;
}

setInterval(updateClock, 1000);
updateClock();

$(document).on("click", "#work_start", function(){
    $('#start').hide();
    $('#end').show();

    $('#start_time').val(new Date().toLocaleString());
    $('#work_area').append('<p>勤務開始：' + new Date().toLocaleString() + '</p>');
    console.log(new Date().toLocaleString())


    postForm = new FormData(); //アップロード用フォーム
    postForm.append('start_time', new Date().toLocaleString()); //スライスしたファイルをフォームにセット
    //postForm.append('id', name); //名前
    let result = fetch('/stamp_start', {
    body: postForm,
    method: 'POST',
    headers: { Accept: 'application/json','X-CSRF-TOKEN': $("[name='csrf-token']").attr("content")
        }
    });
});

$(document).on("click", "#work_end", function(){
    $('#end').hide();
    $('#start').show();

    $('#end_time').val(new Date().toLocaleString());
    $('#work_area').append('<p>勤務修了：' + new Date().toLocaleString() + '</p><p>お疲れさまでした。</p>');
    console.log(new Date().toLocaleString())

    postForm = new FormData(); //アップロード用フォーム
    postForm.append('end_time', new Date().toLocaleString()); //スライスしたファイルをフォームにセット
    //postForm.append('id', name); //名前
    let result = fetch('/stamp_end', {
    body: postForm,
    method: 'POST',
    headers: { Accept: 'application/json','X-CSRF-TOKEN': $("[name='csrf-token']").attr("content")
        }
    });

    
    return;
});