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
										<h3 class="content-title pull-left">新增科研成果</h3>
									</div>
									<div class="description">手动添加科研成果</div>
								</div>
							</div>
						</div>
						<!-- /PAGE HEADER -->
						<!-- USER PROFILE -->
						<div class="row">
							<div class="col-md-12">
								<!-- BOX -->
								<div class="box border">
									<div class="box-title">
										<h4><i class="fa fa-user"></i><span class="hidden-inline-mobile">软件著作权</span></h4>
									</div>
									<div class="box-body">
										<div class="tabbable header-tabs">
											<ul class="nav nav-tabs">
												<li class="active"><a href="#box_tab1" data-toggle="tab"><i class="fa fa-calendar-o"></i> <span class="hidden-inline-mobile">基本信息</span></a></li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane fade in active" id="box_tab1">
													<form class="form-horizontal" action="/PaperManager/index.php/Home/Achievement/software_add_db" method="post">
														<div class="row">
															<div class="col-md-12">
																<div class="box-body">
																	<div class="form-group">
																		<label class="col-md-2 control-label">软件名称(中文)(*)</label> 
																		<div class="col-md-8"><input type="text" name="title_zh" class="form-control" value=""></div>
																	</div>
																	<div class="form-group">
																		<label class="col-md-2 control-label">软件名称(英文)</label> 
																		<div class="col-md-8"><input type="text" name="title_en" class="form-control" value=""></div>
																	</div>
																	<div class="form-group">
																		<label class="col-md-2 control-label">登记号(*)</label> 
																		<div class="col-md-8"><input type="text" name="reg_num" class="form-control" value=""></div>
																	</div>
																	<div class="form-group">
																	<label class="col-md-2 control-label">权利获得方式(*)</label> 
																		<div class="col-md-8">
																			<label class="radio-inline"> <input type="radio" class="uniform" name="get_type" value="原始取得"> 原始取得 </label> 
																			<label class="radio-inline"> <input type="radio" class="uniform" name="get_type" value="继受取得"> 继受取得 </label>
																		</div>
																	</div>
																	<div class="form-group">
																	<label class="col-md-2 control-label">权利范围(*)</label> 
																		<div class="col-md-8">
																			<label class="radio-inline"> <input type="radio" class="uniform" name="right_type" value="全部权利"> 全部权利 </label> 
																			<label class="radio-inline"> <input type="radio" class="uniform" name="right_type" value="部分权利"> 部分权利 </label>
																		</div>
																	</div>
																	
																	<div class="form-group">
																		<label class="col-md-2 control-label">请注明</label> 
																		<div class="col-md-8"><input type="text" name="specific" class="form-control" value=""></div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-2 control-label">开发完成时间(*)</label> 
																		<div class="col-md-2"><input type="date" name="over_date" class="form-control" value=""></div>
																		
																	</div>									
																	<div class="form-group">
																		<label class="col-md-2 control-label">备注</label> 
																		<div class="col-md-8"><textarea name="content" class="form-control"></textarea></div>
																	</div>
																	<div class="form-group">
																		<label class="col-md-2 control-label">全文链接</label> 
																		<div class="col-md-8"><input type="text" name="paper_link" class="form-control" value=""></div>
																	</div>
																</div>
															</div>
														</div>
														<div class="form-actions clearfix"> <input type="submit" value="保存并下一步" class="btn btn-primary pull-right"></div>
													</form>
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
		var count=0;
		jQuery(document).ready(function() {		
			App.setPage("user_profile");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>