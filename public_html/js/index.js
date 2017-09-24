$(function(){
    if($('ul').length > 0)
    {
        // ステータスを変更
        $('.list_box p.status').on('click', function(){
            var id = $(this).attr('id');
            $.ajax({
                type: 'post',
                url: '/index/changestatus/',
                data: 'id=' + id,
            }).done(function(){
                location.reload(true);
            }).fail(function(){
                alert('エラーが発生しました');
                return false;
            });
            return false;
        });

        // Todoを削除
        $('.list_box p.delete').on('click', function(){
            if(!confirm('本当にこのTodoを削除しますか？')) {
                return false;
            } else {
                var id = $(this).prev().attr('id');
                $.ajax({
                    type: 'post',
                    url: '/index/delete/',
                    data: 'id=' + id,
                }).done(function(){
                    location.reload(true);
                }).fail(function(){
                    alert('エラーが発生しました');
                    return false;
                });
                return false;
            }
        });
    }
});
$(function() {
    $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
    $('#period').datepicker({
        changeYear: true, //表示年の指定が可能
        changeMonth: true, //表示月の指定が可能
        dateFormat: 'yy-mm-dd' //年-月-日(曜日)
    });
});
