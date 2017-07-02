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
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/freelancer.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Scripts -->
</head>
<body id="page-top" class="index">
<div id="skipnav"><a href="#maincontent">Skip to main content</a></div>
<!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
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
                        <a href="#eason">生态农业在线</a>
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
    <header>
        <div class="container" id="maincontent" tabindex="-1">
          <!-- Jssor Slider Begin -->

          <!-- ================================================== -->
          <div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto; width: 1216px; height: 500px; overflow: hidden;">

              <!-- Loading Screen -->
              <div data-u="loading" style="position:absolute;top:0px;left:0px;background:url('image/main/loading.gif') no-repeat 50% 50%; background-color: rgba(0, 0, 0, .7);"></div>

              <!-- Slides Container -->
              <div u="slides" style="position: absolute; left: 0px; top: 50px; width: 1216px; height: 500px;
              overflow: hidden;">
                  <div>
                      <img u="image" src2="image/main/env.jpg" />
                  </div>
                  <div>
                      <img u="image" src2="image/main/uav.jpg" />
                  </div>
              </div>

              <!--#region Bullet Navigator Skin Begin -->
              <!-- Help: https://www.jssor.com/development/slider-with-bullet-navigator.html -->
              <style>
                  /* jssor slider bullet navigator skin 05 css */
                  /*
                  .jssorb05 div           (normal)
                  .jssorb05 div:hover     (normal mouseover)
                  .jssorb05 .av           (active)
                  .jssorb05 .av:hover     (active mouseover)
                  .jssorb05 .dn           (mousedown)
                  */
                  .jssorb05 {
                      position: absolute;
                  }
                  .jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
                      position: absolute;
                      /* size of bullet elment */
                      width: 16px;
                      height: 16px;
                      background: url(image/main/b05.png) no-repeat;
                      overflow: hidden;
                      cursor: pointer;
                  }
                  .jssorb05 div { background-position: -7px -7px; }
                  .jssorb05 div:hover, .jssorb05 .av:hover { background-position: -37px -7px; }
                  .jssorb05 .av { background-position: -67px -7px; }
                  .jssorb05 .dn, .jssorb05 .dn:hover { background-position: -97px -7px; }
              </style>
              <!-- bullet navigator container -->
              <div u="navigator" class="jssorb05" style="bottom: 16px; right: 6px;">
                  <!-- bullet navigator item prototype -->
                  <div u="prototype"></div>
              </div>
              <!--#endregion Bullet Navigator Skin End -->

              <!--#region Arrow Navigator Skin Begin -->
              <!-- Help: https://www.jssor.com/development/slider-with-arrow-navigator.html -->
              <style>
                  /* jssor slider arrow navigator skin 11 css */
                  /*
                  .jssora11l                  (normal)
                  .jssora11r                  (normal)
                  .jssora11l:hover            (normal mouseover)
                  .jssora11r:hover            (normal mouseover)
                  .jssora11l.jssora11ldn      (mousedown)
                  .jssora11r.jssora11rdn      (mousedown)
                  */
                  .jssora11l, .jssora11r {
                      display: block;
                      position: absolute;
                      /* size of arrow element */
                      width: 37px;
                      height: 37px;
                      cursor: pointer;
                      background: url(image/main/a11.png) no-repeat;
                      overflow: hidden;
                  }
                  .jssora11l { background-position: -11px -41px; }
                  .jssora11r { background-position: -71px -41px; }
                  .jssora11l:hover { background-position: -131px -41px; }
                  .jssora11r:hover { background-position: -191px -41px; }
                  .jssora11l.jssora11ldn { background-position: -251px -41px; }
                  .jssora11r.jssora11rdn { background-position: -311px -41px; }
              </style>
              <!-- Arrow Left -->
              <span u="arrowleft" class="jssora11l" style="top: 123px; left: 8px;">
              </span>
              <!-- Arrow Right -->
              <span u="arrowright" class="jssora11r" style="top: 123px; right: 8px;">
              </span>

          </div>
          <!-- Jssor Slider End -->
        </div>
    </header>
    <!-- eason Section -->
    <section id="terminal">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>智能终端</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">

            </div>
        </div>
    </section>
    <!-- eason Section -->
    <section id="uav" class="success">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>无人机</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">

            </div>
        </div>
    </section>
    <!-- eason Section -->
    <section id="eason">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>生态农业在线</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">

            </div>
        </div>
    </section>
    <!-- Contact Section -->
    <section id="about" class="success">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>关于公司</h2>
                    <hr class="star-light">
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
                        <h3>联系地址</h3>
                        <p>北京市海淀区学清路9号
                            <br>汇智大厦A309室</p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>联系方式</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">微信</span><i class="fa fa-fw fa-weixin"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">phone</span><i class="fa fa-fw fa-phone"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>生态农业在线</h3>
                        <p><span style="color: #18BC9C;">E</span>colony <a href="#">A</a>griculture <a href="#">S</a>ystem <a href="#">ON</a>line</p>
                        <p>为您提供专业的生态农业大数据服务<a href="/eason">Eason</a>.</p>
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
    <script type="text/javascript" src="../js/jssor.slider.min.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: 1,                                       //[Optional] Auto play or not, to enable slideshow, this option must be set to greater than 0. Default value is 0. 0: no auto play, 1: continuously, 2: stop at last slide, 4: stop on click, 8: stop on user navigation (by arrow/bullet/thumbnail/drag/arrow key navigation)
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $Idle: 2000,                                        //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $ArrowKeyNavigation: 1,   			            //[Optional] Steps to go for each navigation request by pressing arrow key, default value is 1.
                $SlideEasing: $Jease$.$OutQuint,                    //[Optional] Specifies easing for right to left animation, default value is $Jease$.$OutQuad
                $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide, default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $Cols: 1,                                           //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $Align: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)
                $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                },
                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Rows: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 12,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 4,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1,                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider1_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    jssor_slider1.$ScaleWidth(parentWidth - 30);
                }
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>
</body>
</html>
