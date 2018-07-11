$(function(){
	$(".sort-ul").sortable({
		cursor: "move",
        items: "li", 
        opacity: 0.6, //拖动时，透明度为0.6
        revert: true, //释放时，增加动画
        connectWith: ".todo-list",
		cancel: ".ui-state-disabled,input",
    	update : function(event, ui){       //更新排序之后
    		// console.log(event);
    		// console.log(ui);
            // console.log($(this));
            // var category_ids = [];
            // $.each($(this),function(n,value){
            //     category_ids.push($(value).attr('data-category-id'));
            // });
            // console.log(category_ids);
            // $.ajax({
            //     url:U('/task/reorder'),
            //     type:'POST',
            //     data:{
            //         task_id:obj.find('input[type="hidden"][name="task_id"]').val(),
            //         index: $(obj).parent().find('li').index(obj),
            //         category_id:$(obj).parent().siblings('.box-header').find('input[type="hidden"][name="category_id"]').val(),
            //     },
            //     dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
            //     success:function(data,textStatus,jqXHR){
            //         console.log(data)
            //     },
            // });
            // var paixu = $(this).sortable("toArray");
            // console.log(paixu);
        },
        change : function(event,ui){
      //   	console.log(event);
    		// console.log(ui);
        },
        receive: function(event,ui){
            // console.log(event);
        },
        stop: function(event,ui){
            // console.log(event);  
            // console.log(ui);
            var post_data = {};
            post_data.data = [];
            post_data.recategory = {};
            $.each($(event.target).find('li'),function(n,value){
                if( typeof $(value).attr('data-task-id') == 'undefined'){
                    return true;
                }
                var data = {};
                data.task_id = $(value).attr('data-task-id');
                data.index = n;
                post_data.data.push(data);
            }); 
            
            
            var taget_category_id = $(event.target).attr('data-category-id');
            

            var to_category_id = $(event.toElement).parent().parent().attr('data-category-id');
            if( to_category_id != taget_category_id){
                post_data.recategory.task_id = $(event.toElement).parent().attr('data-task-id');
                post_data.recategory.category_id = to_category_id;
                $.each($(event.toElement).parent().parent().find('li'),function(n,value){
                    var data = {};
                    data.task_id = $(value).attr('data-task-id');
                    data.index = n;
                    post_data.data.push(data);
                }); 
            }
            // console.log(post_data);

            $.ajax({
                url:U('/task/reorder'),
                type:'POST',
                data:post_data,
                dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
                success:function(data,textStatus,jqXHR){
                    console.log(data);
                },
            });
        }
    });
    
    
   
    
});

