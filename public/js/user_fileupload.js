var submit = document.getElementById('send01');

submit.addEventListener('click', (e) => {
    const upload_file = document.getElementById('file');
    if(upload_file.value == ""){
        e.preventDefault();
        upload_file.value = "";
        $(this).off('submit');
        console.log("ファイルを選択してください");
        alert('ファイルを選択してください');
    }

    // value属性にアクセスできる
    
    const form = document.getElementById('form');
    let file = null;
    let slice_size = 10 * 1024 * 1024; //切り取るサイズ 2M
    const input = form.querySelector('#file');
    let size = 0;
    let count = 0;
    let postForm = null;
    let splitData = null;
    //const progress = document.getElementById('progress'); //進捗
    form.addEventListener('submit', async (e) => {
    e.preventDefault();
    console.log(input.files.length)
    for(var i=0;i<input.files.length;i++){
        file = input.files[i];
        size = file.size;
        const name = `${(new Date()).getTime()}-${file.name}`;  //アップロード時の名前を固定するように
        //inputSize.innerText = size.toString(); //インプット時に計測されるファイルサイズを表示
        count = Math.ceil(size / slice_size); //分割数を計算
        for (let k = 0; k < count; k++) {  //分割アップロード実施
            splitData = file.slice(k * slice_size, (k + 1) * slice_size); //該当箇所をスライス
            postForm = new FormData(); //アップロード用フォーム
            postForm.append('file', splitData); //スライスしたファイルをフォームにセット
            postForm.append('name', name); //名前
            postForm.append('count', i+1); //名前
            if(k == count - 1){
                postForm.append('flg', 'true');
            }
            else{
                postForm.append('flg', 'false'); //名前
            }
            let result = await fetch('/file_send', {
            body: postForm,
            method: 'POST',
            headers: { Accept: 'application/json','X-CSRF-TOKEN': $("[name='csrf-token']").attr("content")
            }
            }).then(res => res.json());
            //uploadSize.innerText = result.size; //アップロード結合したサイズを表示
            await new Promise(res => setTimeout(() => {
            res();
            }, 500)); //ゆっくり見せたいのでpost完了後、次のpostまで1000ms
        }
    }

    var title =document.getElementById('title').value;

    postForm = new FormData(); //アップロード用フォーム
    postForm.append('title', title); //名前
    let result = await fetch('/file_db', {
    body: postForm,
    method: 'POST',
    headers: { Accept: 'application/json','X-CSRF-TOKEN': $("[name='csrf-token']").attr("content")
    }
    })

    return window.location.href = '/user_menu';
});

});