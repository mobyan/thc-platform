<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
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
<body>
    <div id="app">
        <pulse-loader id="loading" :loading="loading" color="#00aadf" ></pulse-loader>

        <div id="header" class="container">
            <nav class="navbar navbar-default navbar-custom navbar-static-top">
                <div class="container" id="header-container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
<!--                         <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a> -->
                    </div>

                    <div v-if=""class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        @if (!Auth::guest())
                        <ul class="nav navbar-nav">
                            <li v-if="canAppRead()">
                                <router-link to="/map">站点地图</router-link>
                            </li>
                            <li v-if="canAppRead()">
                                <router-link to="/station">站点列表</router-link>
                            </li>
                            <li v-if="canAppRead()">
                                <router-link to="/data_download">数据下载</router-link>
                            </li>
                            <!--<li v-if="canAppRead()">
                                <router-link to="/apply">权限申请</router-link>
                            </li>-->
                            <!--<li v-if="isAdmin()">
                                <router-link to="/apply_audit">权限审核</router-link>
                            </li>-->
                            <li v-if="isAppAdmin()">
                                <router-link to="/user">用户管理</router-link>
                            </li>

                            <li v-if="isAdmin()">
                                <router-link to="/admin/app">生产线管理</router-link>
                            </li>
                            <li v-if="isAdmin()">
                                <router-link to="/admin/station">站点管理</router-link>
                            </li>
                            <li v-if="isAdmin()">
                                <router-link to="/admin/user">用户管理</router-link>
                            </li>

                        </ul>
                        @endif

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">登录</a></li>
                            <li><a href="{{ url('/register') }}">注册</a></li>
                            @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <router-link to="/user_profile">个人资料</router-link>
                                    </li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        退出</a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="container" id="content-container">
            @yield('content')
            @if (!Auth::guest())
            <router-view name="header"></router-view>
            <div>
                <router-view ></router-view>
            </div>
            @endif
        </div>
    </div>
    <div id="footer" >
        <div class="container" style="text-align: center;"><p>版权所有 生态环境与烟草质量重点实验室; 技术支持 北京天航华创科技股份有限公司|Tianhang Create technology Co. Ltd.</p></div>
    </div>

    <!-- Scripts -->
    <script src="{{ elixir('js/app.js') }}"></script>
    <div class="alert alert-success" role="alert" ></div>
    <div class="alert alert-warning" role="alert" ></div>
</body>
</html>
