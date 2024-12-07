$(document).on("click", "#add", function(){

    var field_cnt = $('#field_cnt').val();
    var cnt = Number(field_cnt)+1;
    var area = document.getElementById('add_area');

    if(cnt > 10){
        alert('最大10個までです');
        return false;
    }

    var newField = $('<li>'+cnt+'<ul>' +
        '<li><label>種別名：<input type="text" name="type_name'+cnt+'" required></label></li>' +
        '<li><label>時給　：<input type="number" name="wage'+cnt+'" required></label></li>' +
        '</ul></li>'
    );

    $('#add_area').append(newField);
    var field_cnt = $('#field_cnt').val(cnt)
});

$(document).on("click", "#del", function(){

    var field_cnt = $('#field_cnt').val();
    var cnt = Number(field_cnt)-1;
    var area = document.getElementById('add_area');

    if(cnt < 1){
        alert('最小1個までです');
        return false;
    }

    // Remove the last <li> element under the <ul> with id 'add_area'
    $('#add_area ul:last').remove();
    $('#add_area li:last').remove();
    $('#field_cnt').val(cnt);
    
});