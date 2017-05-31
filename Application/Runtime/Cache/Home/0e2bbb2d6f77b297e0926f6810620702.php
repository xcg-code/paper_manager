<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Cloud Admin | User Profile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- STYLESHEETS --><!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<link rel="stylesheet" type="text/css" href="/PaperManager/Public/css/cloud-admin.css" >
	<link rel="stylesheet" type="text/css"  href="/PaperManager/Public/css/themes/default.css" id="skin-switcher" >
	<link rel="stylesheet" type="text/css"  href="/PaperManager/Public/css/responsive.css" >
	
	<link href="/PaperManager/Public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- DATE RANGE PICKER -->
	<link rel="stylesheet" type="text/css" href="/PaperManager/Public/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
	<!-- UNIFORM -->
	<link rel="stylesheet" type="text/css" href="/PaperManager/Public/js/uniform/css/uniform.default.min.css" />
	<!-- FONTS -->
</head>
<body>
	<!-- HEADER -->
	<header class="navbar clearfix" id="header">
		<div class="container">
			<div class="navbar-brand">
				<!-- COMPANY LOGO -->
				<a href="index.html">
					<img src="/PaperManager/Public/img/logo/logo.png" alt="Cloud Admin Logo" class="img-responsive" height="30" width="120">
				</a>
				<!-- /COMPANY LOGO -->
				<!-- TEAM STATUS FOR MOBILE -->
				<div class="visible-xs">
					<a href="#" class="team-status-toggle switcher btn dropdown-toggle">
						<i class="fa fa-users"></i>
					</a>
				</div>
				<!-- /TEAM STATUS FOR MOBILE -->
				<!-- SIDEBAR COLLAPSE -->
				<div id="sidebar-collapse" class="sidebar-collapse btn">
					<i class="fa fa-bars" 
					data-icon1="fa fa-bars" 
					data-icon2="fa fa-bars" ></i>
				</div>
				<!-- /SIDEBAR COLLAPSE -->
			</div>
			<!-- NAVBAR LEFT -->
			<ul class="nav navbar-nav pull-left hidden-xs" id="navbar-left">
	<li class="dropdown">
		<a href="#" class="team-status-toggle dropdown-toggle tip-bottom" data-toggtooltip" title="Toggle Team View">
			<i class="fa fa-users"></i>
			<span class="name">团队情况</span>
			<i class="fa fa-angle-down"></i>
		</a>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			<span class="name">界面皮肤</span>
			<i class="fa fa-angle-down"></i>
		</a>
		<ul class="dropdown-menu skins">
			<li class="dropdown-title">
				<span><i class="fa fa-leaf"></i> Theme Skins</span>
			</li>
			<li><a href="#" data-skin="default">Subtle (default)</a></li>
			<li><a href="#" data-skin="night">Night</a></li>
			<li><a href="#" data-skin="earth">Earth</a></li>
			<li><a href="#" data-skin="utopia">Utopia</a></li>
			<li><a href="#" data-skin="nature">Nature</a></li>
			<li><a href="#" data-skin="graphite">Graphite</a></li>
		 </ul>
	</li>
</ul>

			<!-- /NAVBAR LEFT -->
			<!-- BEGIN TOP NAVIGATION MENU -->		
			<ul class="nav navbar-nav pull-right">				
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<li class="dropdown user" id="header-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img alt="" src="/PaperManager/<?php echo (session('pic_path')); ?>" />
						<span class="username"><?php echo (session('fullname')); ?></span>
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#"><i class="fa fa-cog"></i> 修改密码</a></li>
						<li><a href="/PaperManager/index.php/Home/Index/logout"><i class="fa fa-power-off"></i>  退出系统</a></li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
			</ul>			
			<!-- END TOP NAVIGATION MENU -->
		</div>
		
		<!-- TEAM STATUS -->
		<div class="container team-status" id="team-status">
			<div id="scrollbar">
				<div class="handle">
				</div>
			</div>
			<div id="teamslider">
				<ul class="team-list">
					<li class="current">
						<a href="javascript:void(0);">
							<span class="image">
								<img src="/PaperManager/Public/img/avatars/avatar3.jpg" alt="" />
							</span>
							<span class="title">
								You
							</span>
							<div class="progress">
								<div class="progress-bar progress-bar-success" style="width: 35%">
									<span class="sr-only">35% Complete (success)</span>
								</div>
								<div class="progress-bar progress-bar-warning" style="width: 20%">
									<span class="sr-only">20% Complete (warning)</span>
								</div>
								<div class="progress-bar progress-bar-danger" style="width: 10%">
									<span class="sr-only">10% Complete (danger)</span>
								</div>
							</div>
							<span class="status">
								<div class="field">
									<span class="badge badge-green">6</span> completed
									<span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-orange">3</span> in-progress
									<span class="pull-right fa fa-adjust"></span>
								</div>
								<div class="field">
									<span class="badge badge-red">1</span> pending
									<span class="pull-right fa fa-list-ul"></span>
								</div>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- /TEAM STATUS -->
	</header>
	<!--/HEADER -->
	
	<!-- PAGE -->
	<section id="page">
		<!-- SIDEBAR -->
		<div id="sidebar" class="sidebar">
					<div class="sidebar-menu nav-collapse">
						<div class="divide-20"></div>
						
						<!-- SIDEBAR MENU -->
						<ul>
							<li>
								<a href="/PaperManager/index.php/Home/Profile/profile">
								<i class="fa fa-tachometer fa-fw"></i> <span class="menu-text">个人主页</span>
								<span class="selected"></span>
								</a>					
							</li>
							<li class="has-sub">
								<a href="javascript:;" class="">
								<i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">科研成果<span class="badge pull-right"></span></span>
								<span class="arrow"></span>
								</a>
								<ul class="sub">
									<li><a class="" href="/PaperManager/index.php/Home/Achievement/achievement_add"><span class="sub-menu-text">添加科研成果</span></a></li>
									<li><a class="" href="/PaperManager/index.php/Home/Achievement/my_achievement"><span class="sub-menu-text">我的科研成果</span></a></li>
								</ul>
							</li>
							<li class="has-sub">
								<a href="javascript:;" class="">
								<i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">科研项目<span class="badge pull-right"></span></span>
								<span class="arrow"></span>
								</a>
								<ul class="sub">
									<li><a class="" href="/PaperManager/index.php/Home/Project/my_project"><span class="sub-menu-text">我的科研项目</span></a></li>
									<li><a class="" href="/PaperManager/index.php/Home/Achievement/project_type"><span class="sub-menu-text">项目类别管理</span></a></li>
									<li><a class="" href="/PaperManager/index.php/Home/Project/project_git"><span class="sub-menu-text">项目跟踪与协作</span></a></li>
								</ul>
							</li>
							<li class="has-sub">
								<a href="javascript:;" class="">
								<i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">实验室<span class="badge pull-right"></span></span>
								<span class="arrow"></span>
								</a>
								<ul class="sub">
									<li><a class="" href="/PaperManager/index.php/Home/Lab/lab_apply"><span class="sub-menu-text">加入实验室</span></a></li>
									<li><a class="" href="/PaperManager/index.php/Home/Lab/my_lab"><span class="sub-menu-text">我的实验室</span></a></li>
								</ul>
							</li>

							<li class="has-sub">
								<a href="javascript:;" class="">
								<i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">我的收藏<span class="badge pull-right"></span></span>
								<span class="arrow"></span>
								</a>
								<ul class="sub">
									<li><a class="" href="/PaperManager/index.php/Home/Favorite/fav_achi"><span class="sub-menu-text">科研成果收藏</span></a></li>
									<li><a class="" href="/PaperManager/index.php/Home/Lab/my_lab"><span class="sub-menu-text">科研项目收藏</span></a></li>
								</ul>					
							</li>
						</ul>
						<!-- /SIDEBAR MENU -->
					</div>
				</div>
		<!-- /SIDEBAR -->
		<div id="main-content">
			<!-- SAMPLE BOX CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="box-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Box Settings</h4>
						</div>
						<div class="modal-body">
							Here goes box setting content.
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /SAMPLE BOX CONFIGURATION MODAL FORM-->
			<div class="container">
				<div class="row">
					<div id="content" class="col-lg-12">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
								<div class="page-header">
									<!-- STYLER -->
									
									<!-- /STYLER -->
									<!-- BREADCRUMBS -->
									<ul class="breadcrumb">
										
									</ul>
									<!-- /BREADCRUMBS -->
									<div class="clearfix">
										<h3 class="content-title pull-left"><?php echo ($ProjectInfo["name"]); ?></h3>
									</div>
									<div class="description">协作开发项目</div>
								</div>
							</div>
						</div>
						<!-- /PAGE HEADER -->
						<!-- USER PROFILE -->
						<div class="row">
							<div class="col-md-12">
								<div class="box">
									<div class="box-title">
										<h4><i class="fa fa-bars"></i><?php echo ($ProjectInfo["name"]); ?></h4>
										<div class="tools hidden-xs">
											<a href="#box-config" data-toggle="modal" class="config">
												<i class="fa fa-cog"></i>
											</a>
											<a href="javascript:;" class="reload">
												<i class="fa fa-refresh"></i>
											</a>
											<a href="javascript:;" class="collapse">
												<i class="fa fa-chevron-up"></i>
											</a>
											<a href="javascript:;" class="remove">
												<i class="fa fa-times"></i>
											</a>
										</div>
									</div>
									<div class="box-body">
										<div class="row">
											<div class="col-md-3">
												<div class="list-group">
													<?php if(($IsAdmin) == "1"): ?><div class="list-group-item profile-details">
															<h4>负责人操作</h4>
														</div>
														<a href="/PaperManager/index.php/Home/Project/git_finish/git_id/<?php echo ($ProjectInfo["id"]); ?>" onclick="return confirm('确定要完成这个项目吗？')" class="list-group-item"><i class="fa fa-user fa-fw"></i> 完成项目</a>
														<a href="/PaperManager/index.php/Home/Project/project_edit/id/<?php echo ($ProjectInfo["id"]); ?>" class="list-group-item"><span class="badge badge-red"></span><i class="fa fa-user fa-fw"></i> 导出未完成事务</a>
														<a href="/PaperManager/index.php/Home/Project/project_edit/id/<?php echo ($ProjectInfo["id"]); ?>" class="list-group-item"><span class="badge badge-red"></span><i class="fa fa-user fa-fw"></i> 项目开支管理</a>
														<a href="/PaperManager/index.php/Home/Project/project_edit/id/<?php echo ($ProjectInfo["id"]); ?>" class="list-group-item"><span class="badge badge-red"></span><i class="fa fa-user fa-fw"></i> 发布项目组通知</a><?php endif; ?>
													
													<div class="list-group-item profile-details">
														<h4>协同操作</h4>
													</div>
													<a href="/PaperManager/index.php/Home/Project/project_edit/id/<?php echo ($ProjectInfo["id"]); ?>" class="list-group-item"><span class="badge badge-red"></span><i class="fa fa-user fa-fw"></i> 项目详情</a>
													<a href="/PaperManager/index.php/Home/Project/project_show/id/<?php echo ($ProjectInfo["id"]); ?>" class="list-group-item"><span class="badge badge-red"></span><i class="fa fa-user fa-fw"></i> 项目文档管理</a>
													<a href="/PaperManager/index.php/Home/Project/project_show/id/<?php echo ($ProjectInfo["id"]); ?>" class="list-group-item"><span class="badge badge-red"></span><i class="fa fa-user fa-fw"></i> 项目组通知</a>
													<a href="/PaperManager/index.php/Home/Project/git_apply_cost/git_id/<?php echo ($ProjectInfo["id"]); ?>" class="list-group-item"><span class="badge badge-red"><?php echo ($CostCount); ?></span><i class="fa fa-user fa-fw"></i> 申请开支</a>
													<a href="/PaperManager/index.php/Home/Project/project_show/id/<?php echo ($ProjectInfo["id"]); ?>" class="list-group-item"><span class="badge badge-red"></span><i class="fa fa-user fa-fw"></i> 分配事务</a>
													<a href="/PaperManager/index.php/Home/Project/project_show/id/<?php echo ($ProjectInfo["id"]); ?>" class="list-group-item"><span class="badge badge-red"></span><i class="fa fa-user fa-fw"></i> 我的待完成事务</a>													
												</div>														
											</div>
											<div class="col-md-9">
												<div class="box border blue">
													<div class="box-title">
														<h4><i class="fa fa-table"></i>项目动态</h4>
													</div>
													<div class="box-body">
														
														<div class="feed-activity clearfix">
															<div>
																<i class="pull-left roundicon fa fa-check btn btn-info"></i>
																<a class="user" href="#"> John Doe </a>
																accepted your connection request.
																<br>
																<a href="#">View profile</a>

															</div>
															<div class="time">
																<i class="fa fa-clock-o"></i>
																5 hours ago
															</div>
														</div>
														<div class="feed-activity clearfix">
															<div>
																<i class="pull-left roundicon fa fa-picture-o btn btn-danger"></i>
																<a class="user" href="#"> Jack Doe </a>
																uploaded a new photo.
																<br>
																<a href="#">Take a look</a>

															</div>
															<div class="time">
																<i class="fa fa-clock-o"></i>
																5 hours ago
															</div>
														</div>
														<div class="feed-activity clearfix">
															<div>
																<i class="pull-left roundicon fa fa-edit btn btn-pink"></i>
																<a class="user" href="#"> Jess Doe </a>
																edited their skills.
																<br>
																<a href="#">Endorse them</a>

															</div>
															<div class="time">
																<i class="fa fa-clock-o"></i>
																5 hours ago
															</div>
														</div>
														<div class="feed-activity clearfix">
															<div>
																<i class="pull-left roundicon fa fa-bitcoin btn btn-yellow"></i>
																<a class="user" href="#"> Divine Doe </a>
																made a bitcoin payment.
																<br>
																<a href="#">Check your financials</a>

															</div>
															<div class="time">
																<i class="fa fa-clock-o"></i>
																6 hours ago
															</div>
														</div>
														<div class="feed-activity clearfix">
															<div>
																<i class="pull-left roundicon fa fa-dropbox btn btn-primary"></i>
																<a class="user" href="#"> Lisbon Doe </a>
																saved a new document to Dropbox.
																<br>
																<a href="#">Download</a>

															</div>
															<div class="time">
																<i class="fa fa-clock-o"></i>
																1 day ago
															</div>
														</div>
														<div class="feed-activity clearfix">
															<div>
																<i class="pull-left roundicon fa fa-pinterest btn btn-inverse"></i>
																<a class="user" href="#"> Bob Doe </a>
																pinned a new photo to Pinterest.
																<br>
																<a href="#">Take a look</a>

															</div>
															<div class="time">
																<i class="fa fa-clock-o"></i>
																2 days ago
															</div>
														</div>
														
													</div>
												</div>
												
												<div class="divide-20"></div>

												<div>
													<ul class='pagination'>
														<?php echo ($page); ?>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="footer-tools">
							<span class="go-top">
								<i class="fa fa-chevron-up"></i> Top
							</span>
						</div>
					</div><!-- /CONTENT-->
				</div>
			</div>
		</div>
	</section>
	<!--/PAGE -->
	<!-- JAVASCRIPTS -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- JQUERY -->
	<script src="/PaperManager/Public/js/jquery/jquery-2.0.3.min.js"></script>
	<!-- JQUERY UI-->
	<script src="/PaperManager/Public/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
	<!-- BOOTSTRAP -->
	<script src="/PaperManager/Public/bootstrap-dist/js/bootstrap.min.js"></script>
	

	<!-- DATE RANGE PICKER -->
	<script src="/PaperManager/Public/js/bootstrap-daterangepicker/moment.min.js"></script>
	
	<script src="/PaperManager/Public/js/bootstrap-daterangepicker/daterangepicker.min.js"></script>
	<!-- SLIMSCROLL -->
	<script type="text/javascript" src="/PaperManager/Public/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script>
	<!-- SLIMSCROLL -->
	<script type="text/javascript" src="/PaperManager/Public/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script><script type="text/javascript" src="/PaperManager/Public/js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
	<!-- BLOCK UI -->
	<script type="text/javascript" src="/PaperManager/Public/js/jQuery-BlockUI/jquery.blockUI.min.js"></script>
	<!-- EASY PIE CHART -->
	<script src="/PaperManager/Public/js/jquery-easing/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/PaperManager/Public/js/easypiechart/jquery.easypiechart.min.js"></script>
	<!-- SPARKLINES -->
	<script type="text/javascript" src="/PaperManager/Public/js/sparklines/jquery.sparkline.min.js"></script>
	<!-- UNIFORM -->
	<script type="text/javascript" src="/PaperManager/Public/js/uniform/jquery.uniform.min.js"></script>
	<!-- COOKIE -->
	<script type="text/javascript" src="/PaperManager/Public/js/jQuery-Cookie/jquery.cookie.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="/PaperManager/Public/js/script.js"></script>
	<script>
		jQuery(document).ready(function() {		
			App.setPage("user_profile");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>