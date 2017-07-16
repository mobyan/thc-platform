<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>天航华创</title>

    <!-- Styles -->


    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/freelancer.min.css" rel="stylesheet">
    <link href="/css/ace/ace.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Scripts -->
    <style>
    .slider{
      padding-bottom: 50%;
      position: relative;
      overflow: hidden;
    }
    .btn{
      background-color: rgba(0,0,0,0.1)!important;
    }
    .btn:Hover{
      background-color: rgba(0,0,0,0.2)!important;
    }
    </style>

</head>
<body id="page-top" class="index">
<div id="skipnav"><a href="#maincontent">Skip to main content</a></div>
<!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">天航华创</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#terminal">智能终端</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#uav">无人机</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#eason">智慧农业在线</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#about">关于公司</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <div id="slider">
      <slider animation="fade" width="100%" height="0px">
        <slider-item v-for="(i, index) in list" :key="index">
          <div>
            <img :src="i.url" :style="i.style"/>
          </div>
        </slider-item>
      </slider>
    </div>
    <!-- eason Section -->
    <section id="terminal">
        <div class="container">
            <div class="row">
              <h2 class="text-center primary red">智能终端</h2>
              <hr class="primary">
                <div class="panel panel-default">
                    <div class="panel-body row clearfix">
                      <div class="col-xs-12 col-md-4">
                        <img class="img-responsive" src="/image/tianon/zc100-2.jpg"/>
                      </div>
                      <div class="col-xs-12 col-md-8">
                        <div>
                          <img class="img-responsive center" src="/image/tianon/zc100-3.jpg"/>
                          <div class="text-center">
                            <div class="hr hr16 dotted"></div>
                            <h3 class="text-center">智传100自动气象站</h3>
                            <div class="hr hr16 dotted"></div>
                            <div class="space-6"></div>
                            <p class="product">智传100自动气象站继承太阳能循环能源，可长期于野外工作，记录作物图像和重要气象参数，利用无限物联技术上传至天航智慧农业管理平台。</p>
                            <ul class="list-group">
                              <li class="list-group-item list-group-item-success">太阳能循环能源供电</li>
                              <li class="list-group-item list-group-item-success">高精度气象要素</li>
                              <li class="list-group-item list-group-item-success">高分辨率作物图像信息</li>
                              <li class="list-group-item list-group-item-success">支持多种无限传输，GPRS、LoRa、NB-IoT</li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="panel panel-default">
                  <div class="panel-body row clearfix">
                    <div class="col-xs-12 col-md-8">
                      <div>
                        <img class="img-responsive center" src="/image/tianon/zc50-2.jpg"/>
                        <div class="text-center">
                          <div class="hr hr16 dotted"></div>
                          <h3>智传50微型气象站</h3>
                          <div class="hr hr16 dotted"></div>
                          <div class="space-6"></div>
                          <p class="product">智传50微型气象站基于智采50数据采集器，集成了环境气象传感器和双目图像采集模块，是一款具有图像采集功能的经济型气象观测站。</p>
                          <ul class="list-group">
                            <li class="list-group-item list-group-item-success">超低功耗，4节5号碱性电池可长期检测记录</li>
                            <li class="list-group-item list-group-item-success">支持环境气象传感器和图片数据的采集和分析</li>
                            <li class="list-group-item list-group-item-success">支持多平台系统多数据浏览和下载</li>
                            <li class="list-group-item list-group-item-success">支持多种无限传输，GPRS、LoRa、NB-IoT</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <img class="img-responsive" src="/image/tianon/zc50-1.jpg"/>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </section>
    <!-- eason Section -->
    <section id="uav">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="text-center red">无人机</h2>
                    <hr class="primary">
                    <div class="col-xs-12 col-md-6">
                      <h3 class="red">多光谱无人机</h3>
                      <div class="hr hr16 dotted"></div>
                      <img class="img-responsive center" src="/image/tianon/uav-1.png"/>
                      <img class="img-responsive center" src="/image/tianon/uav-logo-2.png"/>
                      <div class="text-center well well-lg" style="margin-top:5%">

                        <p class="product">天航多光谱无人机采用模块化设计，机翼可拆装，易于携带；可搭载RGB、多光谱相机；操作简单，无需任何发射架和跑道；飞控系统自动规划航线，
                          完成区域遥感，采集校准光谱数据，应用于病虫害监测、农田产量评估、土地肥力分析</p>
                          <table class="table table-hover">
                            <caption>技术参数</caption>
                            <tbody>
                              <tr>
                                <td>翼展</td>
                                <td>1.15m</td>
                              </tr>
                              <tr>
                                <td>总重</td>
                                <td>1500g</td>
                              </tr>
                              <tr>
                                <td>航时</td>
                                <td>40min</td>
                              </tr>
                              <tr>
                                <td>巡航速度</td>
                                <td>40～100km/h</td>
                              </tr>
                              <tr>
                                <td>传感器</td>
                                <td>多光谱相机，可见光相机</td>
                              </tr>
                            </tbody>
                          </table>
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                      <h3 class="red">多旋翼无人机</h3>
                      <div class="hr hr16 dotted"></div>
                      <img class="img-responsive center" src="/image/tianon/uav-2.png"/>
                      <img class="img-responsive center" src="/image/tianon/uav-logo-3.png"/>
                      <!-- <div class="blank"></div> -->
                      <div class="text-center well well-lg" style="margin-top:5%">
                        <p class="product">天航多旋翼无人机便携易用、操作简便、安全稳定。无人机可选配RGB、多光谱、高光谱相机，为科学调研、光谱信息取证、卫星资源校准提供全套解决方案。
                        飞控系统安全可靠，在区域光谱信息普查、生态调研等方面具有广泛易用</p>
                        <table class="table table-hover">
                          <caption>技术参数</caption>
                          <tbody>
                            <tr>
                              <td>直径</td>
                              <td>96cm</td>
                            </tr>
                            <tr>
                              <td>总重</td>
                              <td>2.7kg</td>
                            </tr>
                            <tr>
                              <td>航时</td>
                              <td>30min</td>
                            </tr>
                            <tr>
                              <td>巡航速度</td>
                              <td>0～80km/h</td>
                            </tr>
                            <tr>
                              <td>传感器</td>
                              <td>高光谱相机，多光谱相机，可见光相机</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
            </div>

            <div class="row col-xs-12 col-md-12">
              <h3 class="text-center red">太阳能无人机</h3>
              <div class="hr hr16 dotted"></div>
              <img class="img-responsive center" src="/image/tianon/solaruav.png"/>
              <div class="col-xs-12 col-md-6">
                <img class="img-responsive center" src="/image/tianon/uav-logo-1.png"/>
                <table class="table table-hover">
                  <caption>技术参数</caption>
                  <tbody>
                    <tr>
                      <td>翼展</td>
                      <td>5.0m</td>
                    </tr>
                    <tr>
                      <td>总重</td>
                      <td>4kg</td>
                    </tr>
                    <tr>
                      <td>有效载荷</td>
                      <td>2kg</td>
                    </tr>
                    <tr>
                      <td>航时</td>
                      <td>5-8小时</td>
                    </tr>
                    <tr>
                      <td>巡航速度</td>
                      <td>45km/h</td>
                    </tr>
                    <tr>
                      <td>传感器</td>
                      <td>高光谱相机，多光谱相机，可见光相机</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="text-center well well-lg">
                  <p class="product">太阳能无人机采用高效柔性太阳能电池系统，可延长航时至8小时。整机模块化设计方便运输使用，机身采用
                  碳纤维符合材料，轻质高强，飞行控制简单易操作，支持航线自动规划，在农业数据采集、国土资源普查、海洋监测、大气环境监测等领域具有广泛应用</p>
                </div>
              </div>
            </div>
        </div>
    </section>
    <!-- eason Section -->
    <section id="eason" style="padding-bottom:0px;">
        <div class="panel panel-default" style="margin-bottom:0px;">
            <div class="panel-body">
                <div class="col-lg-12 text-center" style="padding-top: 5%;">
                    <h2 class="red">智慧农业在线</h2>

                    <div class="row center" style="margin-top:5%">
                      <div class="col-xs-12 col-md-6">
                        <img src="/image/tianon/tianon-1.jpg" class="img-responsive"></img>
                      </div>
                      <div class="col-xs-12 col-md-6">
                        <img src="/image/tianon/tianon-2.jpg" class="img-responsive"></img>
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                        <p><span style="color: #18BC9C;">T</span>hcreate <span style="color: #18BC9C;">I</span>ntelligent <span style="color: #18BC9C;">A</span>griculture k<span style="color: #18BC9C;">N</span>ownledge <span style="color: #18BC9C;">ON</span>line</p>
                        <p>为您提供专业的智能农业大数据服务 <a href="/eason" class="product">天航智能农业管理平台-Tianon</a></p>

                        <p class="product">天航智慧农业管理平台融合了物联网、大数据、云计算等技术，实现对气象数据、土壤信息、作物图像等数据采集分析，
                        实现农业生态自动化监测，为智能化管理提供科学依据和数据支持</p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section -->
    <section id="about" style="background-image: url(/image/tianon/banner1.jpg); background-position: center 50%;background-size: cover; padding-top:0px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center" style="padding-top: 5%;">
                    <h2 class="white">关于公司</h2>
                    <p class="white product">北京天航华创科技股份有限公司成立于2013年，以“技术源于创新，智能改变世界”为理念，为航空航天
                    农业、生态、环保、海洋等行业提供优质产品及解决方案。2015年公司评为国家高新技术企业，研发团队来自北京航空航天大学，目前团队50余人
                  ，其中博士11人，硕士21人，具有丰富等研究和工程开发经验；重点发展等业务方向为先进无人飞行器、智能农业生态装备和农业大数据服务；为生态农业、生态林业、环境保护等提供从传感到测量
              、从采集到分析、从监控到处理到成套系统与服务。</p>
                </div>
            </div>
            <div class="row">

            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <div class="btn-social btn-outline center"><i class="fa fa-fw fa-map-marker"></i></div>
                        <p>北京市海淀区学清路9号
                            <br>汇智大厦A309室</p>
                    </div>
                    <div class="footer-col col-md-4">
                        <div class="btn-social btn-outline center"><i class="fa fa-fw fa-phone"></i></div>
                        <p>010-82338480</p>
                    </div>
                    <div class="footer-col col-md-4">
                        <div class="btn-social btn-outline center"><i class="fa fa-fw fa-envelope"></i></div>
                        <p>thcreate@thcreate.com.cn</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; 北京天航华创科技股份有限公司|Tianhang Create technology Co. Ltd. 2017
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="{{ elixir('js/main.js') }}"></script>
    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <!-- Theme JavaScript -->
    <script src="js/freelancer.min.js"></script>

    <!-- jssor slider scripts-->
</body>
</html>
