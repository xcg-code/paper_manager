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
										<h4><i class="fa fa-bars"></i>Form Wizard - <span class="stepHeader">Step 1 of 3</h4>
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
									<div class="box-body form">
										<form id="wizForm" action="#" class="form-horizontal" >
										<div class="wizard-form">
										   <div class="wizard-content">
											  <ul class="nav nav-pills nav-justified steps">
												 <li>
													<a href="#account" data-toggle="tab" class="wiz-step">
													<span class="step-number">1</span>
													<span class="step-name"><i class="fa fa-check"></i> Create Account </span>   
													</a>
												 </li>

												 <li>
													<a href="#payment" data-toggle="tab" class="wiz-step active">
													<span class="step-number">2</span>
													<span class="step-name"><i class="fa fa-check"></i> Payment Details</span>   
													</a>
												 </li>
												 <li>
													<a href="#confirm" data-toggle="tab" class="wiz-step">
													<span class="step-number">3</span>
													<span class="step-name"><i class="fa fa-check"></i> Submit </span>   
													</a> 
												 </li>
											  </ul>
											  <div id="bar" class="progress progress-striped progress-sm active" role="progressbar">
												 <div class="progress-bar progress-bar-warning"></div>
											  </div>
											  <div class="tab-content">
												 <div class="alert alert-danger display-none">
													<a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
													Your form has errors. Please correct them to proceed.
												 </div>
												 <div class="alert alert-success display-none">
													<a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
													Your form validation is successful!
												 </div>
												 <div class="tab-pane active" id="account">
													<div class="form-group">
													   <label class="control-label col-md-3">Email<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="email" placeholder="Please provide email address"/>
														  <span class="error-span"></span>
													   </div>
													</div>
													<div class="form-group">
													   <label class="control-label col-md-3">Password<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="password" class="form-control" name="password" placeholder="Please provide password"/>
														  <span class="error-span"></span>
													   </div>
													</div>
													<div class="form-group">
													   <label class="control-label col-md-3">Name<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="name" placeholder="Please provide your name"/>
														  <span class="error-span"></span>
													   </div>
													</div>
													<div class="form-group">
													   <label class="control-label col-md-3">Gender<span class="required">*</span></label>
													   <div class="col-md-4">
															 <label class="radio">
																<input type="radio" name="gender" value="M" data-title="Male" class="uniform" checked="checked" />
															 Male
															 </label>
															 <label class="radio">
																<input type="radio" name="gender" value="F" data-title="Female" class="uniform"/>
															 Female
															 </label>														  
													   </div>
													</div>
													<div class="form-group">
													   <label class="control-label col-md-3">Location<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="location" placeholder="Please provide home address"/>
														  <span class="error-span"></span>
													   </div>
													</div>
													<div class="form-group">
													   <label class="control-label col-md-3">Country</label>
													   <div class="col-md-4">
														  <select name="country" id="country_select" class="col-md-12 full-width-fix">
															 <option value=""></option>
															 <option value="AF">Afghanistan</option>
															 <option value="AL">Albania</option>
															 <option value="DZ">Algeria</option>
															 <option value="AS">American Samoa</option>
															 <option value="AD">Andorra</option>
															 <option value="AO">Angola</option>
															 <option value="AI">Anguilla</option>
															 <option value="AQ">Antarctica</option>
															 <option value="AR">Argentina</option>
															 <option value="AM">Armenia</option>
															 <option value="AW">Aruba</option>
															 <option value="AU">Australia</option>
															 <option value="AT">Austria</option>
															 <option value="AZ">Azerbaijan</option>
															 <option value="BS">Bahamas</option>
															 <option value="BH">Bahrain</option>
															 <option value="BD">Bangladesh</option>
															 <option value="BB">Barbados</option>
															 <option value="BY">Belarus</option>
															 <option value="BE">Belgium</option>
															 <option value="BZ">Belize</option>
															 <option value="BJ">Benin</option>
															 <option value="BM">Bermuda</option>
															 <option value="BT">Bhutan</option>
															 <option value="BO">Bolivia</option>
															 <option value="BA">Bosnia and Herzegowina</option>
															 <option value="BW">Botswana</option>
															 <option value="BV">Bouvet Island</option>
															 <option value="BR">Brazil</option>
															 <option value="IO">British Indian Ocean Territory</option>
															 <option value="BN">Brunei Darussalam</option>
															 <option value="BG">Bulgaria</option>
															 <option value="BF">Burkina Faso</option>
															 <option value="BI">Burundi</option>
															 <option value="KH">Cambodia</option>
															 <option value="CM">Cameroon</option>
															 <option value="CA">Canada</option>
															 <option value="CV">Cape Verde</option>
															 <option value="KY">Cayman Islands</option>
															 <option value="CF">Central African Republic</option>
															 <option value="TD">Chad</option>
															 <option value="CL">Chile</option>
															 <option value="CN">China</option>
															 <option value="CX">Christmas Island</option>
															 <option value="CC">Cocos (Keeling) Islands</option>
															 <option value="CO">Colombia</option>
															 <option value="KM">Comoros</option>
															 <option value="CG">Congo</option>
															 <option value="CD">Congo, the Democratic Republic of the</option>
															 <option value="CK">Cook Islands</option>
															 <option value="CR">Costa Rica</option>
															 <option value="CL">Cloud Admin</option>
															 <option value="CI">Cote d'Ivoire</option>
															 <option value="HR">Croatia (Hrvatska)</option>
															 <option value="CU">Cuba</option>
															 <option value="CY">Cyprus</option>
															 <option value="CZ">Czech Republic</option>
															 <option value="DK">Denmark</option>
															 <option value="DJ">Djibouti</option>
															 <option value="DM">Dominica</option>
															 <option value="DO">Dominican Republic</option>
															 <option value="EC">Ecuador</option>
															 <option value="EG">Egypt</option>
															 <option value="SV">El Salvador</option>
															 <option value="GQ">Equatorial Guinea</option>
															 <option value="ER">Eritrea</option>
															 <option value="EE">Estonia</option>
															 <option value="ET">Ethiopia</option>
															 <option value="FK">Falkland Islands (Malvinas)</option>
															 <option value="FO">Faroe Islands</option>
															 <option value="FJ">Fiji</option>
															 <option value="FI">Finland</option>
															 <option value="FR">France</option>
															 <option value="GF">French Guiana</option>
															 <option value="PF">French Polynesia</option>
															 <option value="TF">French Southern Territories</option>
															 <option value="GA">Gabon</option>
															 <option value="GM">Gambia</option>
															 <option value="GE">Georgia</option>
															 <option value="DE">Germany</option>
															 <option value="GH">Ghana</option>
															 <option value="GI">Gibraltar</option>
															 <option value="GR">Greece</option>
															 <option value="GL">Greenland</option>
															 <option value="GD">Grenada</option>
															 <option value="GP">Guadeloupe</option>
															 <option value="GU">Guam</option>
															 <option value="GT">Guatemala</option>
															 <option value="GN">Guinea</option>
															 <option value="GW">Guinea-Bissau</option>
															 <option value="GY">Guyana</option>
															 <option value="HT">Haiti</option>
															 <option value="HM">Heard and Mc Donald Islands</option>
															 <option value="VA">Holy See (Vatican City State)</option>
															 <option value="HN">Honduras</option>
															 <option value="HK">Hong Kong</option>
															 <option value="HU">Hungary</option>
															 <option value="IS">Iceland</option>
															 <option value="IN">India</option>
															 <option value="ID">Indonesia</option>
															 <option value="IR">Iran (Islamic Republic of)</option>
															 <option value="IQ">Iraq</option>
															 <option value="IE">Ireland</option>
															 <option value="IL">Israel</option>
															 <option value="IT">Italy</option>
															 <option value="JM">Jamaica</option>
															 <option value="JP">Japan</option>
															 <option value="JO">Jordan</option>
															 <option value="KZ">Kazakhstan</option>
															 <option value="KE">Kenya</option>
															 <option value="KI">Kiribati</option>
															 <option value="KP">Korea, Democratic People's Republic of</option>
															 <option value="KR">Korea, Republic of</option>
															 <option value="KW">Kuwait</option>
															 <option value="KG">Kyrgyzstan</option>
															 <option value="LA">Lao People's Democratic Republic</option>
															 <option value="LV">Latvia</option>
															 <option value="LB">Lebanon</option>
															 <option value="LS">Lesotho</option>
															 <option value="LR">Liberia</option>
															 <option value="LY">Libyan Arab Jamahiriya</option>
															 <option value="LI">Liechtenstein</option>
															 <option value="LT">Lithuania</option>
															 <option value="LU">Luxembourg</option>
															 <option value="MO">Macau</option>
															 <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
															 <option value="MG">Madagascar</option>
															 <option value="MW">Malawi</option>
															 <option value="MY">Malaysia</option>
															 <option value="MV">Maldives</option>
															 <option value="ML">Mali</option>
															 <option value="MT">Malta</option>
															 <option value="MH">Marshall Islands</option>
															 <option value="MQ">Martinique</option>
															 <option value="MR">Mauritania</option>
															 <option value="MU">Mauritius</option>
															 <option value="YT">Mayotte</option>
															 <option value="MX">Mexico</option>
															 <option value="FM">Micronesia, Federated States of</option>
															 <option value="MD">Moldova, Republic of</option>
															 <option value="MC">Monaco</option>
															 <option value="MN">Mongolia</option>
															 <option value="MS">Montserrat</option>
															 <option value="MA">Morocco</option>
															 <option value="MZ">Mozambique</option>
															 <option value="MM">Myanmar</option>
															 <option value="NA">Namibia</option>
															 <option value="NR">Nauru</option>
															 <option value="NP">Nepal</option>
															 <option value="NL">Netherlands</option>
															 <option value="AN">Netherlands Antilles</option>
															 <option value="NC">New Caledonia</option>
															 <option value="NZ">New Zealand</option>
															 <option value="NI">Nicaragua</option>
															 <option value="NE">Niger</option>
															 <option value="NG">Nigeria</option>
															 <option value="NU">Niue</option>
															 <option value="NF">Norfolk Island</option>
															 <option value="MP">Northern Mariana Islands</option>
															 <option value="NO">Norway</option>
															 <option value="OM">Oman</option>
															 <option value="PK">Pakistan</option>
															 <option value="PW">Palau</option>
															 <option value="PA">Panama</option>
															 <option value="PG">Papua New Guinea</option>
															 <option value="PY">Paraguay</option>
															 <option value="PE">Peru</option>
															 <option value="PH">Philippines</option>
															 <option value="PN">Pitcairn</option>
															 <option value="PL">Poland</option>
															 <option value="PT">Portugal</option>
															 <option value="PR">Puerto Rico</option>
															 <option value="QA">Qatar</option>
															 <option value="RE">Reunion</option>
															 <option value="RO">Romania</option>
															 <option value="RU">Russian Federation</option>
															 <option value="RW">Rwanda</option>
															 <option value="KN">Saint Kitts and Nevis</option>
															 <option value="LC">Saint LUCIA</option>
															 <option value="VC">Saint Vincent and the Grenadines</option>
															 <option value="WS">Samoa</option>
															 <option value="SM">San Marino</option>
															 <option value="ST">Sao Tome and Principe</option>
															 <option value="SA">Saudi Arabia</option>
															 <option value="SN">Senegal</option>
															 <option value="SC">Seychelles</option>
															 <option value="SL">Sierra Leone</option>
															 <option value="SG">Singapore</option>
															 <option value="SK">Slovakia (Slovak Republic)</option>
															 <option value="SI">Slovenia</option>
															 <option value="SB">Solomon Islands</option>
															 <option value="SO">Somalia</option>
															 <option value="ZA">South Africa</option>
															 <option value="GS">South Georgia and the South Sandwich Islands</option>
															 <option value="ES">Spain</option>
															 <option value="LK">Sri Lanka</option>
															 <option value="SH">St. Helena</option>
															 <option value="PM">St. Pierre and Miquelon</option>
															 <option value="SD">Sudan</option>
															 <option value="SR">Suriname</option>
															 <option value="SJ">Svalbard and Jan Mayen Islands</option>
															 <option value="SZ">Swaziland</option>
															 <option value="SE">Sweden</option>
															 <option value="CH">Switzerland</option>
															 <option value="SY">Syrian Arab Republic</option>
															 <option value="TW">Taiwan, Province of China</option>
															 <option value="TJ">Tajikistan</option>
															 <option value="TZ">Tanzania, United Republic of</option>
															 <option value="TH">Thailand</option>
															 <option value="TG">Togo</option>
															 <option value="TK">Tokelau</option>
															 <option value="TO">Tonga</option>
															 <option value="TT">Trinidad and Tobago</option>
															 <option value="TN">Tunisia</option>
															 <option value="TR">Turkey</option>
															 <option value="TM">Turkmenistan</option>
															 <option value="TC">Turks and Caicos Islands</option>
															 <option value="TV">Tuvalu</option>
															 <option value="UG">Uganda</option>
															 <option value="UA">Ukraine</option>
															 <option value="AE">United Arab Emirates</option>
															 <option value="GB">United Kingdom</option>
															 <option value="US">United States</option>
															 <option value="UM">United States Minor Outlying Islands</option>
															 <option value="UY">Uruguay</option>
															 <option value="UZ">Uzbekistan</option>
															 <option value="VU">Vanuatu</option>
															 <option value="VE">Venezuela</option>
															 <option value="VN">Viet Nam</option>
															 <option value="VG">Virgin Islands (British)</option>
															 <option value="VI">Virgin Islands (U.S.)</option>
															 <option value="WF">Wallis and Futuna Islands</option>
															 <option value="EH">Western Sahara</option>
															 <option value="YE">Yemen</option>
															 <option value="ZM">Zambia</option>
															 <option value="ZW">Zimbabwe</option>
														  </select>
													   </div>													
													</div>
													<div class="form-group">
													   <label class="control-label col-md-3">Phone Number<span class="required">*</span></label>
													   <div class="col-md-4">
														  <input type="text" class="form-control" name="phone" placeholder="Please provide phone number"/>
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
														<i class="fa fa-arrow-circle-left"></i> Back 
													   </a>
													   <a href="javascript:;" class="btn btn-primary nextBtn">
														Continue <i class="fa fa-arrow-circle-right"></i>
													   </a>
													   <a href="javascript:;" class="btn btn-success submitBtn">
														Submit <i class="fa fa-arrow-circle-right"></i>
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
	<script src="/PaperManager/Public/js/jquery-validate/jquery.validate.min.js"></script>
	<script src="/PaperManager/Public/js/jquery-validate/additional-methods.min.js"></script>
	<!-- BOOTBOX -->
	<script type="text/javascript" src="/PaperManager/Public/js/bootbox/bootbox.min.js"></script>
	<!-- COOKIE -->
	<script type="text/javascript" src="/PaperManager/Public/js/jQuery-Cookie/jquery.cookie.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="/PaperManager/Public/js/script.js"></script>
	<script src="/PaperManager/Public/js/bootstrap-wizard/form-wizard.min.js"></script>
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