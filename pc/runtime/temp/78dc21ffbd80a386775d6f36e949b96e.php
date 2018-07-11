<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"D:\xampp\htdocs\pc\public/../application/index\view\task\projects.html";i:1488898952;s:68:"D:\xampp\htdocs\pc\public/../application/index\view\Index\index.html";i:1488900016;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>标题</title>
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="__CSS__/bootstrap.min.css">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> -->
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="__CSS__/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="__CSS__/skins/_all-skins.min.css">
    <link rel="stylesheet" href="__CSS__/jquery-ui.min.css">
    <script type="text/javascript">
        var ThinkPHP = window.Think = {
            "ROOT": "__ROOT__", //当前网站地址
            "APP": "__APPNAME__", //当前模块地址
        }
        var _ROOT_ = "__ROOT__";
    </script>
    
<style>
	.todo-list{
		padding:20px 0;
		overflow: inherit;
	}
	.project-header{
		padding:10px;
	}
	.new_task_wrap{
		margin-top:-40px;
		padding-top:0;
	}	
</style>

</head>
<body class="sidebar-mini skin-blue-light">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo">
            BM
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>

    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
            pc
            </div>             
            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active treeview">
                    <a href="<?php echo url('Task/index');; ?>">
                        <i class="fa fa-dashboard"></i> <span>项目</span>                        
                    </a>
                  
                </li>
            </ul>
        </section>
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            Dashboard
            <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            </ol>
        </section>
        <section class="content">
            
<input type="hidden" name="project_id" value="<?php echo $project_id;?>">
<div class="row">
	<div class="project-header">
		<button type="button" class="btn btn-default" onclick="admin.add_task_wrap_without_category()">添加任务</button>
	</div>
	
	<div class="box-body " id="list_without_categorys">
		<ul class="todo-list sort-ul"  data-category-id="0">
		<?php if(count($data_without_categorys)){foreach($data_without_categorys as $value){?>
			<li data-task-id="<?php echo $value['task_id']; ?>">
				<span class="handle ui-sortable-handle">
                    <i class="fa fa-ellipsis-v"></i>
                    <i class="fa fa-ellipsis-v"></i>
              	</span>
              	<input type="checkbox" value="">
              	<a href="<?php echo url('Task/detail',[ 'id'=>$value['task_id'] ]); ?>" class="text"><?php echo $value['title']; ?></a>
              	<div class="tools">
                    <i class="fa fa-edit"></i>
              	</div>
			</li>			
		<?php }}?>
		</ul>
	</div>
	
	<?php if(count($data)){
	foreach($data as $value){?>
		<div class="box box-primary">
			<div class="box-header">
				<i class="ion ion-clipboard"></i>
				<h3 class="box-title"><?php echo $value['category_name']; ?></h3>
			</div>		
			
			<div class="box-body ">
				<ul class="todo-list sort-ul" data-category-id="<?php echo $value['category_id']; ?>">
				<?php if(count($value['tasks'])){foreach($value['tasks'] as $task){?>
					<li data-task-id="<?php echo $task['task_id']; ?>" >
						<span class="handle ui-sortable-handle">
	                        <i class="fa fa-ellipsis-v"></i>
	                        <i class="fa fa-ellipsis-v"></i>
                      	</span>
                      	<input type="checkbox" value="">
                      	<a href="<?php echo url('Task/detail',[ 'id'=>$task['task_id'] ]); ?>" class="text"><?php echo $task['title']; ?></a>
                      	<div class="tools">
		                    <i class="fa fa-edit"></i>
	                  	</div>
					</li>					
                <?php }}//end-of tasks?>
				</ul>
			</div>
			
			<div class="box-footer clearfix no-border">
              	<button type="button" onclick="admin.add_task_wrap(this)" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add Tasks</button>
            </div>
		</div>
	<?php }
	}?>
</div>

        </section>
    </div>
</div>

<!-- jQuery 2.2.3 -->
<script src="__JS__/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="__JS__/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="__JS__/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="__JS__/app.min.js"></script>
<script src="__JS__/think.js"></script>
<script src="__JS__/admin.js"></script>

<script src="__JS__/task_projects.js"></script>
<script>

</script>

<script>

</script>
</body>
</html>