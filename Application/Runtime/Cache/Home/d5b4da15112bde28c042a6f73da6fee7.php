<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Cloud Admin | Wizards & Validations</title>
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
	<!-- SELECT2 -->
	<link rel="stylesheet" type="text/css" href="/PaperManager/Public/js/select2/select2.min.css" />
	<!-- UNIFORM -->
	<link rel="stylesheet" type="text/css" href="/PaperManager/Public/js/uniform/css/uniform.default.min.css" />
	<!-- WIZARD -->
	<link rel="stylesheet" type="text/css" href="/PaperManager/Public/js/bootstrap-wizard/wizard.css" />
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
						<a href="#" class="team-status-toggle dropdown-toggle tip-bottom" data-toggle="tooltip" title="Toggle Team View">
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
					<li class="dropdown user" id="header-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img alt="" src="/PaperManager/Public/img/avatars/avatar3.jpg" />
							<span class="username">John Doe</span>
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="fa fa-user"></i> My Profile</a></li>
							<li><a href="#"><i class="fa fa-cog"></i> Account Settings</a></li>
							<li><a href="#"><i class="fa fa-eye"></i> Privacy Settings</a></li>
							<li><a href="login.html"><i class="fa fa-power-off"></i> Log Out</a></li>
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
						<!-- SEARCH BAR -->
						
						<!-- SIDEBAR MENU -->
						<ul>
							<li>
								<a href="index.html">
								<i class="fa fa-tachometer fa-fw"></i> <span class="menu-text">Dashboard</span>
								<span class="selected"></span>
								</a>					
							</li>
							
						</ul>
						<!-- /SIDEBAR MENU -->
					</div>
				</div>
				<!-- /SIDEBAR -->
		<div id="main-content">
			<!-- SAMPLE BOX CONFIGURATION MODAL FORM-->
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
										<li>
											<i class="fa fa-home"></i>
											<a href="index.html">Home</a>
										</li>
										<li>
											<a href="#">Form Elements</a>
										</li>
										<li>Wizards & Validations</li>
									</ul>
									<!-- /BREADCRUMBS -->
									<div class="clearfix">
										<h3 class="content-title pull-left">初次登录，请完善个人信息</h3>
									</div>
									<div class="description">请按照向导完善个人信息</div>
								</div>
							</div>
						</div>
						<!-- /PAGE HEADER -->
						<!-- SAMPLE -->
						<div class="row">
							<div class="col-md-12">
								<!-- BOX -->
								<div class="box border red" id="formWizard">
									<div class="box-title">
										<h4><i class="fa fa-bars"></i>个人信息维护向导 - <span class="stepHeader">第一步 | 共三步</h4>
									</div>
									<div class="box-body form">
										<form id="wizForm" action="#" class="form-horizontal" >
										<div class="wizard-form">
										   <div class="wizard-content">
											  <ul class="nav nav-pills nav-justified steps">
												 <li>
													<a href="#account" data-toggle="tab" class="wiz-step">
													<span class="step-number">1</span>
													<span class="step-name"><i class="fa fa-check"></i> 基本信息 </span>   
													</a>
												 </li>

												 <li>
													<a href="#payment" data-toggle="tab" class="wiz-step active">
													<span class="step-number">2</span>
													<span class="step-name"><i class="fa fa-check"></i> 研究领域 </span>   
													</a>
												 </li>
												 <li>
													<a href="#confirm" data-toggle="tab" class="wiz-step">
													<span class="step-number">3</span>
													<span class="step-name"><i class="fa fa-check"></i> 个人简介 </span>   
													</a> 
												 </li>
											  </ul>
											  <div id="bar" class="progress progress-striped progress-sm active" role="progressbar">
												 <div class="progress-bar progress-bar-warning"></div>
											  </div>
											  <div class="tab-content">
												 <div class="alert alert-danger display-none">
													<a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
													所填信息有误，请核对后重新填写！
												 </div>
												 <div class="alert alert-success display-none">
													<a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
													您所填的信息验证通过！
												 </div>
												 <div class="tab-pane active" id="account">
													<div class="form-group">
													   <label class="control-label col-md-3" style="width: 150px">中文名<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="fullname" id="fullname" placeholder="请输入中文全名" />
														  <span class="error-span"></span>
													   </div>

													   	<label class="control-label col-md-3" style="width: 150px">性别<span class="required">*</span></label>
													   <div class="col-md-4">
															 <label class="radio">
																<input type="radio" name="gender" value="M" data-title="Male" class="uniform" checked="checked" />
															 男
															 </label>
															 <label class="radio">
																<input type="radio" name="gender" value="F" data-title="Female" class="uniform"/>
															 女
															 </label>														  
													   </div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-3" style="width: 150px">身份证号<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="id_num" id="id_num" placeholder="请输入18位身份证号" />
														  <span class="error-span"></span>
													   </div>
													   <label class="control-label col-md-3" style="width: 150px">电子邮箱<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="email" id="email" placeholder="请输入电子邮箱地址" />
														  <span class="error-span"></span>
													   </div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-3" style="width: 150px">所在单位<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="workspace" id="workspace" placeholder="请输入所在单位" />
														  <span class="error-span"></span>
													   </div>
													   <label class="control-label col-md-3" style="width: 150px">职称<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="job_title" id="job_title" placeholder="请输入职称" />
														  <span class="error-span"></span>
													   </div>
													</div>
													<div class="form-group">
													   <label class="control-label col-md-3"  style="width: 150px">最高学位<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="degree" id="degree" placeholder="请输入最高学位"/>
														  <span class="error-span"></span>
													   </div>

													  	<label class="control-label col-md-3"  style="width: 150px">授予年份<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="degree_year" id="degree_year" placeholder="请输入最高学位授予年份(4位数字)"/>
														  <span class="error-span"></span>
													   </div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-3" style="width: 150px">通信地址<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="address" id="address" placeholder="请输入通信地址" />
														  <span class="error-span"></span>
													   </div>

													   <label class="control-label col-md-3" style="width: 150px">手机号码<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="phone" id="phone" placeholder="请输入手机号码" />
														  <span class="error-span"></span>
													   </div>
													</div>
													
												 </div>
												 <div class="tab-pane" id="payment">
													<div class="form-group">
													   <label class="control-label col-md-3">Card Number<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="card_number" placeholder="Please provide 16 digit card number"/>
														  <span class="error-span"></span>
													   </div>
													</div>
													<div class="form-group">
													   <label class="control-label col-md-3">CVC<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" placeholder="Please provide 3 digit CVC" class="form-control" name="card_cvc"/>
														  <span class="error-span"></span>
													   </div>
													</div>
													<div class="form-group">
													   <label class="control-label col-md-3">Card Expiry (MM/YYYY)<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" placeholder="Please provide card expiry date in MM/YYYY" maxlength="7" class="form-control" name="card_expirydate"/>
														  <span class="error-span">e.g 12/1985</span>
													   </div>
													</div>												 
													<div class="form-group">
													   <label class="control-label col-md-3">Card Holder Name<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="card_holder_name" placeholder="Please provide card holder name"/>
														  <span class="error-span"></span>
													   </div>
													</div>													
												 </div>
												 <div class="tab-pane" id="confirm">
													<h3 class="block">Submit account details</h3>
													<h4 class="form-section">Account Information</h4>
													<div class="well">
														<div class="form-group">
														   <label class="control-label col-md-3">Email:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="email"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3">Fullname:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="fullname"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3">Gender:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="gender"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3">Phone:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="phone"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3">Address:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="address"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3">Country:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="country"></p>
														   </div>
														</div>
													</div>
													<h4 class="form-section">Payment Information</h4>
													<div class="well">														
														<div class="form-group">
														   <label class="control-label col-md-3">Card Number:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="card_number"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3">CVC:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="card_cvc"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3">Expiration:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="card_expiry_date"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3">Card Holder Name:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="card_name"></p>
														   </div>
														</div>
													</div>
												 </div>
											  </div>
										   </div>
										   <div class="wizard-buttons">
											  <div class="row">
												 <div class="col-md-12">
													<div class="col-md-offset-3 col-md-9">
													   <a href="javascript:;" class="btn btn-default prevBtn">
														<i class="fa fa-arrow-circle-left"></i> 上一步 
													   </a>
													   <a href="javascript:;" class="btn btn-primary nextBtn">
														下一步 <i class="fa fa-arrow-circle-right"></i>
													   </a>
													   <a href="javascript:;" class="btn btn-success submitBtn">
														提交 <i class="fa fa-arrow-circle-right"></i>
													   </a>                            
													</div>
												 </div>
											  </div>
										   </div>
										</div>
									 </form>
									</div>
								</div>
								<!-- /BOX -->
							</div>
						</div>
						<!-- /SAMPLE -->
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
	<script type="text/javascript" src="/PaperManager/Public/js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
	<!-- BLOCK UI -->
	<script type="text/javascript" src="/PaperManager/Public/js/jQuery-BlockUI/jquery.blockUI.min.js"></script>
	<!-- SELECT2 -->
	<script type="text/javascript" src="/PaperManager/Public/js/select2/select2.min.js"></script>
	<!-- UNIFORM -->
	<script type="text/javascript" src="/PaperManager/Public/js/uniform/jquery.uniform.min.js"></script>
	<!-- WIZARD -->
	<script src="/PaperManager/Public/js/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
	<!-- WIZARD -->
	<script src="/PaperManager/Public/js/jquery-validate/jquery.validate.js"></script>
	<script src="/PaperManager/Public/js/jquery-validate/additional-methods.min.js"></script>
	<!-- BOOTBOX -->
	<script type="text/javascript" src="/PaperManager/Public/js/bootbox/bootbox.min.js"></script>
	<!-- COOKIE -->
	<script type="text/javascript" src="/PaperManager/Public/js/jQuery-Cookie/jquery.cookie.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="/PaperManager/Public/js/script.js"></script>
	<script src="/PaperManager/Public/js/bootstrap-wizard/form-wizard.js"></script>
	<script>
		jQuery(document).ready(function() {		
			App.setPage("wizards_validations");  //Set current page
			App.init(); //Initialise plugins and elements
			FormWizard.init();
		});
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>