$(function(){
    // 検索
    $('#addlist p').on('click', function(){
        var data = $('#searchForm').serialize();
        $.ajax({
            type: 'post',
            url: '/index/searchexecute/',
            data: data,
        }).done(function(data){
            $('#result').html(data);
        }).fail(function(){
            alert('エラーが発生しました');
            return false;
        });
        return false;
    });

});
