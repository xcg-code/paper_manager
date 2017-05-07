<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
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
										<h4><i class="fa fa-user"></i><span class="hidden-inline-mobile">上传文档及附件</span></h4>
									</div>
									<div class="box-body">
										<div class="tabbable header-tabs">
											<ul class="nav nav-tabs">
												<li class="active"><a href="#box_tab1" data-toggle="tab"><i class="fa fa-calendar-o"></i> <span class="hidden-inline-mobile">上传文档及附件</span></a></li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane fade in active" id="box_tab1">
													<div class="row">
														<div class="col-md-12">
															<div class="box-body">
																<div class="alert alert-info"><strong>全文电子文档 | 在上传附件前，请确信您已经从版权所有人得到使用该文件的授权，文件大小不能超过20MB。(允许上传的文件格式包括：*.pdf)</strong></div>
																<form class="form-horizontal" action="/PaperManager/index.php/Home/Achievement/file_upload_main_db/achi_id/<?php echo ($achi_id); ?>" method="post" enctype="multipart/form-data">
																	<div class="form-group">
																		<label class="col-md-2 control-label">文件</label> 
																		<div class="col-md-8"><input type="file" name="main" /></div>

																	</div>
																	<div class="form-group">
																		<label class="col-md-2 control-label">文件描述</label> 
																		<div class="col-md-8"><textarea name="description" class="form-control"></textarea></div>
																	</div>

																	<div class="form-actions clearfix"> <input type="submit" value="上传全文电子文档" class="btn btn-primary pull-right"></div>
																</form>

															</div>

															<div class="box-body">
																<div class="alert alert-info"><strong>上传其他附件 | 在上传附件前，请确信您已经从版权所有人得到使用该文件的授权，文件大小不能超过20MB。(允许上传的文件格式包括：*.pdf)</strong></div>
																<form class="form-horizontal" action="/PaperManager/index.php/Home/Achievement/file_upload_other_db/achi_id/<?php echo ($achi_id); ?>" method="post" enctype="multipart/form-data">
																	<div class="form-group">
																		<label class="col-md-2 control-label">文件</label> 
																		<div class="col-md-8"><input type="file" name="other" /></div>

																	</div>
																	<div class="form-group">
																		<label class="col-md-2 control-label">文件描述</label> 
																		<div class="col-md-8"><textarea name="description" class="form-control"></textarea></div>
																	</div>

																	<div class="form-actions clearfix"> <input type="submit" value="上传其他附件" class="btn btn-primary pull-right"></div>

																</form>
																<div class="box border blue">
																	<div class="box-title">
																	<h4><i class="fa fa-file"></i>已上传文件</h4>
																	</div>
																	<div class="box-body">
																		<table class="table table-striped">
																			<thead>
																				<tr>
																					<th style="width: 25%">文件名称</th>
																					<th>文件描述</th>
																					<th style="width: 15%">上传日期</th>
																					<th style="width: 10%">操作</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php if(is_array($FileInfo)): $i = 0; $__LIST__ = $FileInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
																					<td><?php echo ($vo["name"]); ?></td>
																					<td><?php echo ($vo["description"]); ?></td>
																					<td><?php echo ($vo["upload_time"]); ?></td>
																					<td><button class="btn btn-xs btn-success" onclick="window.location.href='/PaperManager/<?php echo ($vo["path"]); ?>'">下载</button>
																					<a href="/PaperManager/index.php/Home/Achievement/file_delete/id/<?php echo ($vo["id"]); ?>/file_type/<?php echo ($vo["type"]); ?>" onclick="return confirm('确定要删除该文件吗？')"><button type="button" class="btn btn-xs btn-danger">删除</button></a></td>
																					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
																				
																			</tbody>
																		</table>
																	</div>
																</div>
																<div class="form-actions clearfix"> <button type="button" id="NextStep" class="btn btn-primary pull-right" onclick="window.location.href='/PaperManager/index.php/Home/Achievement/project_add/achi_id/<?php echo ($achi_id); ?>'">下一步</button></div>
															</div>
														</div>
													</div>

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