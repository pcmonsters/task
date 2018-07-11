$(function(){
	$('#save_btn').click(function(){
		var post_data = {};
		post_data.project_id = $('#project_id').val();
		post_data.code = $('#code').val();
		$.ajax({
            url:U('/task/save_task_detail'),
            type:'POST',
            data:post_data,
            dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
            success:function(data,textStatus,jqXHR){
                console.log(data);
            },
        });
	});
});