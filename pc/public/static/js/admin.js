var admin = {};

admin.add_new_task = function(obj){
	_ul = $(obj).parents('.new_task_wrap');
	var post_data = {
            title:_ul.find('input[name="title"]').val(),
            project_id:$('input[type="hidden"][name="project_id"]').val(),
            index:_ul.siblings('.sort-ul').find('li').length,
        };
    if(_ul.siblings('.sort-ul').attr('data-category-id') != '0'){
    	post_data.category_id = _ul.siblings('.sort-ul').attr('data-category-id');
    }   
	$.ajax({
        url:U('/task/add_task'),
        type:'POST',
        data:post_data,
        dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
        success:function(data,textStatus,jqXHR){
        	var html = admin.get_new_task(JSON.parse(data));
        	_ul.siblings('.sort-ul').append($(html));
        	admin.remove_task(obj);
        },
    });
}

admin.remove_task = function(obj){
	$(obj).parents('.new_task_wrap').remove();
}
admin.get_new_task = function(data){
	var href = U('/Task/detail',["id",data.id]);
  	var html = "<li data-task-id='"+data.id+"'>"
			    +"<span class='handle'>"
                +"    <i class='fa fa-ellipsis-v'></i>"
                +"    <i class='fa fa-ellipsis-v'></i>"
              	+"</span>"
              	+"<input type='checkbox' value=''>"
              	+"<a href='"+href+"' class='text'>"+data.title+"</a>"
              	+"<div class='tools'>"
                +"    <i class='fa fa-edit'></i>"
              	+"</div>"
			    +"</li>";
	return html;
}
admin.new_task_wrap = 
            "<ul class='todo-list new_task_wrap'><li >"
            + "<span class='handle ui-sortable-handle'>"
            + "<i class='fa fa-ellipsis-v'></i>"
            + "<i class='fa fa-ellipsis-v'></i>"
            + "</span>"
            + "<input type='checkbox' disabled/>"
            + "<input name='title' type='text' class='form-control text'  style='width:70%;'/>"
            + "<div class='tools'>"
            + "<i class='fa fa-edit'></i>"
            + "</div>"
            + "<div class='row' style='padding-left:70px;padding-top:10px;'><button type='button' class='btn btn-primary' style='margin-right:10px;' onclick='admin.add_new_task(this)'>确定</button>"
            + "<button onclick='admin.remove_task(this)' type='button' class='btn btn-default'>取消</button></div>"
            + "</li></ul>";
admin.add_task_wrap_without_category = function(){
	if($('#list_without_categorys .new_task_wrap').length){
		$('#list_without_categorys .new_task_wrap').find('input[name="title"]').focus();
        return;
    }
    $('#list_without_categorys').append($(admin.new_task_wrap));
}
admin.add_task_wrap = function(obj){
	if($(obj).parent().siblings('.box-body').find('.new_task_wrap').length){
		$(obj).parent().siblings('.box-body').find('.new_task_wrap').find('input[name="title"]').focus();
		return;
	}
	$(obj).parent().siblings('.box-body').append($(admin.new_task_wrap));
}
