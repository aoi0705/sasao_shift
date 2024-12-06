$(document).on("click", "#add", function(){

    var field_cnt = $('#field_cnt').val();
    var cnt = Number(field_cnt)+1;
    var user_id = document.getElementsByName('staffname1')[0].value

    if(cnt > 10){
        alert('最大10個までです');
        return false;
    }

    var newField = $('<section id="add_shift'+cnt+'">' +
        '<ul>' +
        '<input type="hidden" name="staffname' + cnt + '" value="' + user_id + '">' +
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
    var mod_url = document.getElementById('mod_url');
    var formObject = document.getElementById('form');
    formObject.action = mod_url.value;

    formObject.submit();
});
$(document).on("click", "#delete", function(){
    var del_url = document.getElementById('del_url');
    var formObject = document.getElementById('form');
    formObject.action = del_url.value;

    formObject.submit();
});