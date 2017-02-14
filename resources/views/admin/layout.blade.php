<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Techneter</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="/framework/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="/framework/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris charts -->
    <link href="/framework/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- Select2 -->
    <link href="/framework/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/framework/AdminLTE/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="/framework/AdminLTE/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/framework/plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
    <!-- editor -->
    <link rel="stylesheet" href="/framework/wangEditor-2.1.22/dist/css/wangEditor.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      
      <header class="main-header">
        <a href="/adminUser" class="logo"><b>Techneter</b></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu" onclick="flush()" >
                  <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="hidden-xs">清除缓存</span>
                  </a>
                </li>
       
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">操作</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                    </div>
                    <div class="pull-right">
                      <a href="/adminSignout/" class="btn btn-default btn-flat">退出</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      
      <!-- Left side column. contains the logo and sidebar -->
      @include('admin/sidebar')
      <!-- Right side column. Contains the navbar and content of the page -->
      @yield('content')

    </div><!-- ./wrapper -->

    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=5cc5beb3d82a11d3b7da28fa3941fe15"></script>
    <!-- jQuery 2.1.3 -->
    <script src="/framework/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="http://www.veryhuo.com/uploads/Common/js/jQuery.md5.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="/framework/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Select2 -->
    <script src="/framework/plugins/select2/select2.full.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='/framework/plugins/fastclick/fastclick.min.js'></script>
    <!-- Morris.js charts -->
    <script src="/framework/raphael/raphael-min.js"></script>
    <script src="/framework/plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- jQuery Knob -->
    <script src="/framework/plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="/framework/AdminLTE/js/app.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="/framework/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <script src="/framework/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="/framework/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="/framework/plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="/framework/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    <!-- InputMask -->
    <script src="/framework/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="/framework/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="/framework/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    <!-- Select2 -->
    <script src="/framework/plugins/select2/select2.full.min.js" type="text/javascript"></script>

    <!-- Editor -->    
    <script type="text/javascript" src="/framework/wangEditor-2.1.22/dist/js/wangEditor.js"></script>

    <!-- Upload -->
    <script type="text/javascript" src="/framework/plupload-2.1.1/js/moxie.js"></script>
    <script type="text/javascript" src="/framework/plupload-2.1.1/js/plupload.full.min.js"></script>
    <script type="text/javascript" src="/framework/plupload-2.1.1/js/i18n/zh_CN.js"></script>
    <script type="text/javascript" src="/framework/qiniu/qiniu.js"></script>
    <script type="text/javascript" src="/js/upload/upload.js"></script>
    <script type="text/javascript" src="/js/upload/editUpload.js"></script>

    <!-- TOKEN -->
    <script type="text/javascript">
      var _token = "<?php echo csrf_token(); ?>";
    </script>
    <!-- js common -->

    <script type="text/javascript">

        $(function () {
            $(".knob").knob({});
        });

    </script>

    @inject('sidebarPresenter','App\Presenters\Contracts\ConsoleSidebarPersenterInterface')
    @if($sidebarPresenter->getPageMark() == 'article.article.create' || $sidebarPresenter->getPageMark() == 'article.article.edit') 
        <script src="/js/admin/article/revise.js" type="text/javascript"></script>
    @endif

    @if($sidebarPresenter->getPageMark() == 'ad.ad.index') 
        <script src="/js/admin/ad/index.js" type="text/javascript"></script>
    @endif


  </body>
</html>
