<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\xampp\htdocs\pc_1\pc\public/../application/index\view\index\index.html";i:1531332081;}*/ ?>
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
    <link href='__CSS__/fullcalendar.min.css' rel='stylesheet' />
    <link href='__CSS__/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <!-- <link rel="stylesheet" href="__CSS__/fullcalendar.print.min.css"> -->
    <script type="text/javascript">
        var ThinkPHP = window.Think = {
            "ROOT": "__ROOT__", //当前网站地址
            "APP": "__APPNAME__", //当前模块地址
        }
        var _ROOT_ = "__ROOT__";
    </script>
    
<style>
        .fc-day-grid-event .fc-content {
    white-space: nowrap;
    overflow: hidden;
    height: 100px;
    font-size: 20px;
    text-align: center;
    line-height: 100px;
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
                        <i class="fa fa-dashboard"></i> <span>排班</span>                        
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
            
                <div id='calendar'></div>
            
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
<script src='__JS__/moment.min.js'></script>
<!-- <script src='__JS__/jquery.min.js'></script> -->
<script src="__JS__/fullcalendar.min.js"></script>

<script>

</script>
</body>
</html>
<script>
// var _date = new Date();
    // now = moment().format('YYYY-MM-DD');
    // console.log(now);
  $(document).ready(function() {

    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      defaultDate: moment().format('YYYY-MM-DD'),
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: {
        url: "<?php echo url('Index/getSchedule'); ?>",
        error: function() {
          $('#script-warning').show();
        }
      },
      loading: function(bool) {
        $('#loading').toggle(bool);
      }
      // events: [
      //   {
      //     title: 'All Day Event',
      //     start: moment().format('YYYY-MM-DD'),
      //     end: moment().format('YYYY-MM-DD'),
      //   }
      // ]
    });

  });

</script>

