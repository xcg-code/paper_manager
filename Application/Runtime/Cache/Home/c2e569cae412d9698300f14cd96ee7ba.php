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
			<span class="name">Team Status</span>
			<i class="fa fa-angle-down"></i>
		</a>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			<span class="name">Skins</span>
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
									<li><a class="" href="/PaperManager/index.php/Home/Achievement/project_type"><span class="sub-menu-text">项目类别管理</span></a></li>
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
										<h3 class="content-title pull-left">个人主页</h3>
									</div>
									<div class="description">基本信息, 研究领域, 科研成果</div>
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
										<h4><i class="fa fa-user"></i><span class="hidden-inline-mobile">你好，<?php echo ($Profile["fullname"]); ?></span></h4>
									</div>
									<div class="box-body">
										<div class="tabbable header-tabs user-profile">
											<ul class="nav nav-tabs">
												<li><a href="#pro_pic" data-toggle="tab"><i class="fa fa-picture-o"></i> <span class="hidden-inline-mobile">上传头像</span></a></li>
											   <li><a href="#pro_edit" data-toggle="tab"><i class="fa fa-edit"></i> <span class="hidden-inline-mobile">编辑资料</span></a></li>
											   <li class="active"><a href="#pro_overview" data-toggle="tab"><i class="fa fa-dot-circle-o"></i> <span class="hidden-inline-mobile">概述</span></a></li>
											</ul>
											<div class="tab-content">
											   <!-- OVERVIEW -->
											   <div class="tab-pane fade in active" id="pro_overview">
												  <div class="row">
													<!-- PROFILE PIC -->
													<div class="col-md-3">
														<div class="list-group">
														  <li class="list-group-item zero-padding">
															<img alt="" class="img-responsive" src="/PaperManager/<?php echo (session('pic_path')); ?>">
														  </li>
														  <div class="list-group-item profile-details">
																<h2><?php echo ($Profile["fullname"]); ?></h2>
														 </div>
														  <a href="#" class="list-group-item"><i class="fa fa-user fa-fw"></i> 基本资料</a>
														  <a href="#" class="list-group-item">
															<span class="badge badge-red">9</span>
															<i class="fa fa-calendar fa-fw"></i> 科研成果
														  </a>
														  <a href="#" class="list-group-item"><i class="fa fa-comment-o fa-fw"></i> 实验室</a>
														  <a href="#" class="list-group-item"><i class="fa fa-picture-o fa-fw"></i> 课题组</a>
														</div>														
													</div>
													<!-- /PROFILE PIC -->
													<!-- PROFILE DETAILS -->
													<div class="col-md-9">
														<!-- ROW 1 -->
														<div class="row">
															<div class="col-md-12 profile-details">		
																<h3>我的主要研究领域</h3>
																<div class="row">
																	<div class="col-md-4 text-center">
																		<div id="pie_1" class="piechart" data-percent="100">
																			<span class="percent"></span>
																		</div>
																		<div class="skill-name"><h4>人工智能</h4></div>
																	</div>
																	<div class="col-md-4 text-center">
																		<div id="pie_2" class="piechart" data-percent="100">
																			<span class="percent"></span>
																		</div>
																		<div class="skill-name"><h4>机器学习</h4></div>
																	</div>
																	<div class="col-md-4 text-center">
																		<div id="pie_3" class="piechart" data-percent="100">
																			<span class="percent"></span>
																		</div>
																		<div class="skill-name"><h4>自然语言处理</h4></div>
																	</div>
																</div>
																<div class="divide-20"></div>
																<!-- BUTTONS -->
																<div class="row">
																	<div class="col-md-3">
																		<a class="btn btn-danger btn-icon input-block-level" href="javascript:void(0);">
																			<div>期刊论文</div>
																			<span class="label label-right label-warning">4</span>
																		</a>
																	</div>
																	<div class="col-md-3">
																		<a class="btn btn-primary btn-icon input-block-level" href="javascript:void(0);">
																			<div>会议论文</div>
																			<span class="label label-right label-danger">7</span>
																		</a>
																	</div>
																	<div class="col-md-3">
																		<a class="btn btn-pink btn-icon input-block-level" href="javascript:void(0);">
																			<div>专利</div>
																			<span class="label label-right label-info">1</span>
																		</a>
																	</div>
																	<div class="col-md-3">
																		<a class="btn btn-success btn-icon input-block-level" href="javascript:void(0);">
																			<div>学术著作</div>
																			<span class="label label-right label-info">1</span>
																		</a>
																	</div>

																</div>
																<!-- /BUTTONS -->
															</div>
														</div>
														<!-- /ROW 1 -->
														<div class="divide-20"></div>
														<!-- ROW 2 -->
														
														<!-- /ROW 2 -->
													</div>
													<!-- /PROFILE DETAILS -->
												  </div>
											   </div>
											   <!-- /OVERVIEW -->
											   
											   <!-- EDIT ACCOUNT -->
											   <div class="tab-pane fade" id="pro_edit">
												  <form class="form-horizontal" action="/PaperManager/index.php/Home/Profile/edit/id/<?php echo ($Profile["id"]); ?>" method="post">
													<div class="row">
														 <div class="col-md-6">
															<div class="box border green">
																<div class="box-title">
																	<h4><i class="fa fa-bars"></i>基本信息</h4>
																</div>
																<div class="box-body big">
																	<div class="row">
																	 <div class="col-md-12">
																		<h4>个人基本信息</h4>
																		<div class="form-group">
																		   <label class="col-md-4 control-label">姓名</label> 
																		   <div class="col-md-8"><input type="text" name="fullname" class="form-control" value="<?php echo ($Profile["fullname"]); ?>"></div>
																		</div>
																		<div class="form-group">
																		   <label class="col-md-4 control-label">身份证号码</label> 
																		   <div class="col-md-8"><input type="text" name="id_num" class="form-control" value="<?php echo ($Profile["id_num"]); ?>"></div>
																		</div>
																		<div class="form-group">
																		   <label class="col-md-4 control-label">职称</label> 
																		   <div class="col-md-8"><input type="text" name="work_title" class="form-control" value="<?php echo ($Profile["work_title"]); ?>"></div>
																		</div>
																		
																		<h4>联系方式信息</h4>
																		<div class="form-group">
																		   <label class="col-md-4 control-label">手机</label> 
																		   <div class="col-md-8"><input type="text" name="phone" class="form-control" value="<?php echo ($Profile["phone"]); ?>"></div>
																		</div>
																		<div class="form-group">
																		   <label class="col-md-4 control-label">电子邮箱</label> 
																		   <div class="col-md-8"><input type="text" name="email" class="form-control" value="<?php echo ($Profile["email"]); ?>"></div>
																		</div>
																		<div class="form-group">
																		   <label class="col-md-4 control-label">通信地址</label> 
																		   <div class="col-md-8"><textarea name="address" class="form-control"><?php echo ($Profile["address"]); ?></textarea></div>
																		</div>
																	 </div>
																  </div>
																</div>
															</div>
														 </div>
														 <div class="col-md-6 form-vertical">
															<div class="box border green">
																<div class="box-title">
																	<h4><i class="fa fa-bars"></i>教育经历</h4>
																</div>
																<div class="box-body big">
																	<h4>学位信息</h4>
																		<div class="form-group">
																		   <label class="col-md-4 control-label">最高学位</label> 
																		   <div class="col-md-8"><input type="text" name="degree" class="form-control" value="<?php echo ($Profile["degree"]); ?>"></div>
																		</div>
																		<div class="form-group">
																		   <label class="col-md-4 control-label">授予学校</label> 
																		   <div class="col-md-8"><input type="text" name="degree_edu" class="form-control" value="<?php echo ($Profile["degree_edu"]); ?>"></div>
																		</div>
																		<div class="form-group">
																		   <label class="col-md-4 control-label">授予年份(4位数字)</label> 
																		   <div class="col-md-8"><input type="text" name="degree_year" class="form-control" value="<?php echo ($Profile["degree_year"]); ?>"></div>
																		</div>
																</div>
															</div>
														 </div>
														 <div class="col-md-6 form-vertical">
															<div class="box border green">
																<div class="box-title">
																	<h4><i class="fa fa-bars"></i>科研领域(最多填写三个)</h4>
																</div>
																<div class="box-body big">
																		<div class="form-group">
																		   <label class="col-md-4 control-label" style="width: 20%">中文关键词</label> 
																		   <div class="col-md-3"><input type="text" name="zh_keyword_1" class="form-control" value=""></div>
																		   <label class="col-md-4 control-label" style="width: 20%">英文关键词</label> 
																		   <div class="col-md-3"><input type="text" name="en_keyword_1" class="form-control" value=""></div>
																		</div>
																		<div class="form-group">
																		   <label class="col-md-4 control-label" style="width: 20%">中文关键词</label> 
																		   <div class="col-md-3"><input type="text" name="zh_keyword_2" class="form-control" value=""></div>
																		   <label class="col-md-4 control-label" style="width: 20%">英文关键词</label> 
																		   <div class="col-md-3"><input type="text" name="en_keyword_2" class="form-control" value=""></div>
																		</div>
																		<div class="form-group">
																		   <label class="col-md-4 control-label" style="width: 20%">中文关键词</label> 
																		   <div class="col-md-3"><input type="text" name="zh_keyword_3" class="form-control" value=""></div>
																		   <label class="col-md-4 control-label" style="width: 20%">英文关键词</label> 
																		   <div class="col-md-3"><input type="text" name="en_keyword_3" class="form-control" value=""></div>
																		</div>
																</div>
															</div>
														 </div>
													 </div>
													 <div class="form-actions clearfix"> <input type="submit" value="保存" class="btn btn-primary pull-right"></div>
												  </form>
											   </div>
											   <!-- /EDIT ACCOUNT -->
											   <div class="tab-pane fade" id="pro_pic">
												  <form class="form-horizontal" action="/PaperManager/index.php/Home/Profile/update_pic/id/<?php echo ($Profile["id"]); ?>" method="post" enctype="multipart/form-data">
														<div class="row">
															<div class="col-md-12">
																<!-- BOX -->
																	<div class="box-body">
																		<div class="form-group">
																		  <div class="col-md-4"><input type="file" name="picture" class="form-control" ></div>
																		</div>
																	</div>
															</div>
														</div>
													 <div class="form-actions clearfix"> <input type="submit" value="上传" class="btn btn-primary pull-right"></div>
												  </form>
											   </div>
											</div>
										</div>
										<!-- /USER PROFILE -->
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