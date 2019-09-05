<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>天航华创</title>
    <!--[if lte IE 9]>
 	  <link rel="stylesheet" href="/css/ace/ace-ie.min.css" />
 		<![endif]-->
    <!--[if lte IE 8]>
 		<script src="/js/ace/html5shiv.min.js"></script>
 		<script src="/js/ace/respond.min.js"></script>
 		<![endif]-->
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <!-- ace styles -->
	<link rel="stylesheet" href="/css/ace/ace.min.css" class="ace-main-stylesheet" id="main-ace-style"/>
    <link rel="stylesheet" href="/css/ace/ace-skins.min.css"/>
	<link rel="stylesheet" href="/css/ace/ace-rtl.min.css"/>
    <script src="/js/ace/ace-extra.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            ]); ?>;
        window.thc = {}
        @if (!Auth::guest())
        window.thc.user = {!! $user !!};
        @endif
    </script>
</head>
<body class="no-skin">
    <div id="app">
        <pulse-loader id="loading" :loading="loading" color="#00aadf"></pulse-loader>
        <div id="navbar" class="navbar navbar-default ace-save-state">
          <div class="navbar-container ace-save-state" id="navbar-container">
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
    					<span class="sr-only">Toggle sidebar</span>

    					<span class="icon-bar"></span>

    					<span class="icon-bar"></span>

    					<span class="icon-bar"></span>
    				</button>
            <div class="navbar-header pull-left">
    					<a href="/eason" class="navbar-brand">
    						<small>
    							<i class="fa fa-leaf"></i>
    							Tianon Admin
    						</small>
    					</a>
    				</div>
            <div class="navbar-buttons navbar-header pull-right" role="navigation">
              <ul class="nav ace-nav">
                @if (Auth::guest())

                <li class="blue"><a href="{{ url('/eason/login') }}"><i class="ace-icon fa fa-user"></i>登录</a></li>
                <li class="green"><a href="{{ url('/eason/register') }}"><i class="ace-icon fa fa-registered"></i>注册</a></li>
                @else
                <li class="light-blue dropdown-modal">
                  <a data-toggle="dropdown" href="#" class="dropdown-toggle">
    								<img class="nav-user-photo" src="{{ Auth::user()->user_profile->avatar_url }}" alt="Jason's Photo" />
    								<span class="user-info">
    									<small>欢迎,</small>
    									{{ Auth::user()->name }}
    								</span>

    								<i class="ace-icon fa fa-caret-down"></i>
    							</a>
                  <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
    								<li v-if="canAppWrite()">
    									<router-link to="/invitation">
    										<i class="ace-icon fa fa-cog"></i>
    										邀请码管理
    									</router-link>
    								</li>

    								<li v-if="canAppRead()">
    									<router-link to="/profile">
    										<i class="ace-icon fa fa-user"></i>
    										个人资料
    									</router-link>
    								</li>

    								<li class="divider"></li>

    								<li>
                      <a href="{{ url('/eason/logout') }}"
                      onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                      <i class="ace-icon fa fa-power-off"></i>
                      退出</a>

                      <form id="logout-form" action="{{ url('/eason/logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
    								</li>
    							</ul>
                </li>
                @endif
              </ul>
            </div>
          </div>
        </div>

        <!--main-container-->
        <div class="main-container ace-save-state" id="main-container">
          @if (!Auth::guest())
          <div id="sidebar" class="sidebar                  responsive                    ace-save-state">

            <ul class="nav nav-list">

              <li v-if="canAppRead()">
    						<router-link to="/dashboard">
    							<i class="menu-icon fa fa-tachometer"></i>
    							<span class="menu-text"> 信息概况 </span>
    						</router-link>
    						<b class="arrow"></b>
    					</li>
              <li  v-if="canAppRead()">
    						<router-link to="/map">
    							<i class="menu-icon fa fa-map-o"></i>
    							<span class="menu-text"> 站点地图 </span>
    						</router-link>
    						<b class="arrow"></b>
    					</li>
              <li  v-if="canAppRead()">
    						<router-link to="/station">
    							<i class="menu-icon fa fa-list-ul"></i>
    							<span class="menu-text"> 站点列表 </span>
    						</router-link>
    						<b class="arrow"></b>
    					</li>
              <li class="" v-if="canAppRead()">
    						<router-link to="/data_download">
    							<i class="menu-icon fa fa-download"></i>
    							<span class="menu-text"> 数据下载 </span>
    						</router-link>
    						<b class="arrow"></b>
    					</li>
              <!--app admin-->
              <li class="" v-if="canAppWrite()">
    						<router-link to="/user">
    							<i class="menu-icon fa fa-user-circle-o"></i>
    							<span class="menu-text"> 用户管理 </span>
    						</router-link>
    						<b class="arrow"></b>
    					</li>


              <!--admin part-->
              <li class="" v-if="canSysWrite()">
    						<router-link to="/admin/user">
    							<i class="menu-icon fa fa-user-circle-o"></i>
    							<span class="menu-text"> 用户管理 </span>
    						</router-link>
    						<b class="arrow"></b>
    					</li>

              <li class="" v-if="canSysWrite()">
    						<router-link to="/admin/app">
    							<i class="menu-icon fa fa-envira"></i>
    							<span class="menu-text"> 公司管理 </span>
    						</router-link>
    						<b class="arrow"></b>
    					</li>

              <li class="" v-if="canSysWrite()">
    						<router-link to="/admin/station">
    							<i class="menu-icon fa fa-tablet"></i>
    							<span class="menu-text"> 站点管理 </span>
    						</router-link>
    						<b class="arrow"></b>
    					</li>

            </ul>
          </div><!--sidebar-->
          @endif
          <div class="main-content">
            <div class="main-content-inner">
              <div class="page-content">
                @yield('content')
                @if (!Auth::guest())
                <router-view name="header"></router-view><!--page-header-->
                <div class="container">
                  <router-view></router-view>
                </div>
                @endif
              </div>
            </div>
          </div><!--main content-->
          <div class="footer">
            <div class="footer-inner">
    					<div class="footer-content">
    						<span class="bigger-120">
    							<span class="blue bolder">北京天航华创科技股份有限公司</span>
    							 &copy; 2017
    						</span>
    						<span class="action-buttons">
    							<a href="#">
    								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
    							</a>

    							<a href="#">
    								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
    							</a>

    							<a href="#">
    								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
    							</a>
    						</span>
    					</div>
    				</div>
    			</div>
            <!--<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    			</a>-->
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ elixir('js/app.js') }}"></script>
    <!--<script src="js/ace/jquery-2.1.4.min.js"></script>-->
	<script src="/js/ace/jquery-ui.custom.min.js"></script>
	<script src="/js/ace/jquery.ui.touch-punch.min.js"></script>
	<script src="/js/ace/ace-elements.min.js"></script>
	<script src="/js/ace/ace.min.js"></script>
    <script src="/js/ace/ace-extra.min.js"></script>
    <div class="alert alert-success" role="alert" ></div>
    <div class="alert alert-warning" role="alert" ></div>
</body>
</html>
