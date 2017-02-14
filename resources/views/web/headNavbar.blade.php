@inject('webPresenter','App\Presenters\Contracts\WebPersenterInterface')
<nav class="navbar navbar-default" role="navigation">
  <div class="container">

    <div class="navbar-header">
      <a class="navbar-brand" href="/">
        <img alt="Brand" height="100%" src="http://techneter.sport-x.cn/images/web/logo4.png">
      </a>
    </div>
    <ul class="nav navbar-nav">
      <li @if($webPresenter->getHeadNavbarActive() == 'forum') class="navbarActive" @endif ><a href="/forum">社区</a></li>
      <li @if($webPresenter->getHeadNavbarActive() == 'article') class="navbarActive" @endif ><a href="/article">资讯</a></li>
      <li @if($webPresenter->getHeadNavbarActive() == 'specialColumn') class="navbarActive" @endif ><a href="/forum/category/2">专栏</a></li>
      <li @if($webPresenter->getHeadNavbarActive() == 'pioneer') class="navbarActive" @endif ><a href="/article/category/1">创业</a></li>
      <li @if($webPresenter->getHeadNavbarActive() == 'technology') class="navbarActive" @endif ><a href="/forum/category/1">技术</a></li>
    </ul>
    <form class="navbar-form navbar-left" role="search">
      <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">
            <span class="glyphicon glyphicon-search"></span> 
          </button>
        </span>
        <input type="text" class="form-control">
      </div>
    </form>

    @if(User::getSessionUserinfo())
    @set('userInfo',User::getSessionUserinfo())
    <div class="nav navbar-nav navbar-right">
      <li class="dropdown user user-menu" >
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="{{ $userInfo->avatar }}" class="user-image" alt="{{ $userInfo->name }}">
          <span class="hidden-xs">{{ $userInfo->name }}</span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header" style="background-color:#3c8dbc">
            <img src="{{ $userInfo->avatar }}" class="img-circle" alt="{{ $userInfo->name }}">
            <p>
              {{ $userInfo->name }}
              <small>{{ $userInfo->created_at }}</small>
            </p>
          </li>
          <!-- Menu Body -->
          <!--
          <li class="user-body">
            <div class="row">
              <div class="col-xs-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Friends</a>
              </div>
            </div>
          </li>
          -->
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="/user/{{ $userInfo->user_passport_id }}" class="btn btn-default btn-flat">个人中心</a>
            </div>
            <div class="pull-right">
              <a href="/logout" class="btn btn-default btn-flat">退出</a>
            </div>
          </li>
        </ul>
      </li>
    </div>
    @else
    <div class="navbar-right">
      <a href="#" class="btn btn-success navbar-btn ">
        <span class="fa fa-fw fa-wechat"></span>微信
      </a>
      &nbsp;&nbsp;
      <a href="/login/qq" class="btn btn-info navbar-btn ">
        <span class="fa fa-fw fa-qq"></span>QQ
      </a>
    </div>            
    @endif

  </div>
</nav>