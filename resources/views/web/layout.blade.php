<!DOCTYPE html>
<html lang="zh-cn">
    <head>

      @if(isset($title))
      <title>{{ $title }}</title>
      @else
      <title>Techneter-为创业者提供最好的产品与资讯</title>
      @endif
      @if(isset($keywords)) 
      <meta name="keywords" content="{{ $keywords }}" />
      @else
      <meta name="keywords" content="创业,互联网创业,资讯,运城,山西,明星公司,动态,宏观,趋势,创业,精选,有料,干货,有用,细节,内幕,互联网技术,PHP,网站开发,APP开发,软件外包,社区" />
      @endif
      @if(isset($description))
      <meta name="description" content="{{ $description }}" />
      @else
      <meta name="description" content="Techneter是运城最大的创业者和互联网人的社区，提供创业资讯、行业动态、互联网产品的推广、创业技术交流社区等创业服务，致力于推动运城创业创新的互联网产品。" />
      @endif
      <meta name="author" content="Techneter" />      
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="/framework/bootstrap/css/bootstrap.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
      <link rel="stylesheet" href="/framework/AdminLTE/css/AdminLTE.css">
      <link rel="stylesheet" href="/css/web/style.css">
      <link rel="stylesheet" href="/framework/wangEditor-2.1.22/dist/css/wangEditor.min.css">
      <link rel="stylesheet" href="/framework/sweetalert/dist/sweetalert.css">
      <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
      <script src="/framework/bootstrap/js/bootstrap.js"></script>
      <script src="/framework/sweetalert/dist/sweetalert.min.js"></script>
      <script src="/framework/AdminLTE/js/app.js"></script>
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body>

      @yield('content')
      
      <footer class="main-footer" style="margin-right: 0px;margin-left: 0px;margin-top: 20px;">
        <div class="container">
          <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
          </div>
          <strong>Copyright &copy; 2014-2017 <a href="/">Techneter</a>.</strong> All rights
          reserved.
        </div>
      </footer>
        
    </body>

  </html>
