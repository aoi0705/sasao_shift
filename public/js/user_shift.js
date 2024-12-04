$(document).on("click", "#add", function(){

    var field_cnt = $('#field_cnt').val();
    var cnt = Number(field_cnt)+1;

    if(cnt > 10){
        alert('最大10個までです');
        return false;
    }

    var newField = $('<section id="add_shift'+cnt+'">' +
        '<ul>' +
        //'<li><select name="stafftype" id="stafftype">' +
        //'<option value="">スタッフ種別を選択してください</option>' +
        //'</select>' +
        //'</li>' +
        //'<li><select name="staffname' + cnt + '" id="staffname' + cnt + '">' +
        //'<option value="">スタッフ名を選択してください</option>' +
        //'</select>' +
        //'</li>' +
        '<input type="hidden" name="staffname' + cnt + '" value="<?php echo Auth::id(); ?>">' +
        '<li><label>勤務日　：</label><input type="date" name="date' + cnt + '" id="date' + cnt + '"></li>' +
        '<li><label>勤務時間：</label><input type="time" name="start_time' + cnt + '" id="start_time' + cnt + '">～<input type="time" name="end_time' + cnt + '" id="end_time' + cnt + '"></li>' +
        '</ul>' +
        '</section>'
    );

    $('#add_area').append(newField);
    var field_cnt = $('#field_cnt').val(cnt)
});

$(document).on("click", "#del", function(){
    var field_cnt = $('#field_cnt').val();
    var cnt = Number(field_cnt)-1;

    if(cnt < 1){
        alert('1個以上必要です');
        return false;
    }

    $('#add_shift'+field_cnt).remove();
    var field_cnt = $('#field_cnt').val(cnt)
});

$(document).on("click", "#modify", function(){
    var formObject = document.getElementById('form');
    formObject.action = "{{route('shift_modify')}}";

    formObject.submit();
});
$(document).on("click", "#delete", function(){
    var formObject = document.getElementById('form');
    formObject.action = "{{route('shift_delete')}}";

    formObject.submit();
});