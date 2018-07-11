<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"C:\xampp\htdocs\pc\pc\public/../application/index\view\task\detail.html";i:1497409269;s:71:"C:\xampp\htdocs\pc\pc\public/../application/index\view\Index\index.html";i:1488900016;}*/ ?>
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
    
<link rel="stylesheet" type="text/css" href="__JS__/simditor/simditor.css" />


<style>
	.task-title{
		padding-left:40px;
		float:left;
		border-bottom: 1px dotted #ccc;
	}
	.task-description{
		padding-left: 40px;
		float:left;
		word-break: break-all;
		padding-bottom: 20px;
		border-bottom: 1px dotted #ccc;
	}
	.task-code{
		padding-left: 40px;
		float:left;
		word-break: break-all;
	}

.detail-actions {
    position: absolute;
    top: 20px;
    right: -1px;
    right: 0px;
    padding: 10px 0 10px 10px;
    margin-top: 42px;
    font-size: 14px;
}
.detail-actions .item {
    float: right;
    clear: both;
    width: 100px;
    padding: 5px 5px 5px 10px;
    margin-right: 1px;
    background-color: #fff;
    border-bottom: 1px solid #ddd;
    -webkit-transition: width 0.3s, box-shadow 0.3s ease-in-out;
    -moz-transition: width 0.3s, box-shadow 0.3s ease-in-out;
    transition: width 0.3s, box-shadow 0.3s ease-in-out;
}
.task-complete{
	position: absolute;
    top: 20px;
}
.control-label{
	 float: left;
    line-height: 30px;
    color: #999;
    white-space: nowrap;
    width: 64px;
    margin: 0;
    padding-top: 0;
    text-align: left;
    font-size: 12px;
    font-weight: bold;
}
.controls{
	margin-left: 66px;
    position: relative;
}
.control-group{
	padding: 6px 20px;
    margin-bottom: 0;
    border-bottom: 1px solid #e5e5e5;
}
.control-group:hover {
    background: #f5f5f5;
}
.item{
	display: inline-block;
    vertical-align: middle;
    padding: 0 15px 0 0;
}
.control-each{
	clear:both;
	padding: 6px 0;
}
.add-person{
	width: 30px;
    height: 30px;
    color: #d9d7d3;
    border: solid 1px #d9d7d3;
    border-radius: 50%;
    display: inline-block;
    font-size: 15px!important;
    text-align:center;
}
.left-part{
	width:65%;
	float:left;
}
.right-part{

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
            
<div class="row">
	<div class="left-part">
		<div class="col-md-12" >
			<div class="task-complete"><input type="checkbox"  value="option1" ></div>
			<div class="h2 task-title"><?php echo $task['title']?></div>
		</div>
		<div class="col-md-12" style="margin-top:10px;">
		<div class="task-description"><?php echo $task['description']; ?></div>
		</div>
		<div class="col-md-12" style="margin-top:10px;">
			<div class="task-code"><?php echo $task['code']; ?></div>
		</div>
		<div class="col-md-12" >
		<input type="hidden" name="" id="project_id" value="<?php echo $task['project_id']; ?>">
		<textarea name="" id="code" cols="30" rows="10"><?php echo $task['code']; ?></textarea>
		</div>
	</div>
	<div class="right-part">
		<div class="col-md-4">
		<?php foreach($task_person as $value){?>
			<div class="control-group">
				<?php foreach($value as $val){?>
				<div class="control-each">
					<div class="control-label"><?php echo $val[0]['person_name']; ?></div>
					<div class="controls">
						<?php foreach($val as $person){?>
						<div class="item"><?php echo $person['member_name']; ?></div>
						<?php }?>
						<div class="add-person">+</div>
					</div>

				</div>
				
				<?php }?>	
			</div>
		<?php }?>
		</div>
	</div>
	<button id="save_btn">保存</button>
	

	
</div>
<div class="detail-actions">
	<div class="item" style="display: block;">
        <a style="">编辑</a>
    </div>
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

<script type="text/javascript" src="__JS__/simditor/module.min.js"></script>
<script type="text/javascript" src="__JS__/simditor/hotkeys.min.js"></script>
<script type="text/javascript" src="__JS__/simditor/uploader.min.js"></script>
<script type="text/javascript" src="__JS__/simditor/simditor.min.js"></script>
<script type="text/javascript" src="__JS__/detail.js"></script>
<script>
	var editor = new Simditor({
		textarea: $('textarea'),
	});
</script>

<script>

</script>
</body>
</html>