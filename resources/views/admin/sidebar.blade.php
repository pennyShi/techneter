@inject('sidebarPresenter','App\Presenters\Contracts\ConsoleSidebarPersenterInterface')
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">功能列表</li>

            <li @if($sidebarPresenter->getPlate() == 'admin') class="active" @endif >
                <a href="/admin/administrators/user">
                    <i class="fa fa-github"></i> <span>管理员管理</span>
                </a>
            </li>

            <li @if($sidebarPresenter->getPlate() == 'userinfo') class="active" @endif >
                <a href="/admin/userinfo">
                    <i class="fa fa-info-circle"></i> <span>用户资料管理</span>
                </a>
            </li>

            <li @if($sidebarPresenter->getModuleName() == 'forum') class="active" @endif >
                <a href="#">
                    <i class="fa fa-windows"></i> <span>论坛管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @if($sidebarPresenter->getPlate() == 'post') class="active" @endif ><a href="/admin/forum/post/"><i class="fa fa-circle-o"></i>帖子管理</a></li>
                    <li @if($sidebarPresenter->getPlate() == 'category') class="active" @endif ><a href="/admin/forum/category"><i class="fa fa-circle-o"></i>分类管理</a></li>
                </ul>
            </li>

            <li @if($sidebarPresenter->getModuleName() == 'article') class="active" @endif >
                <a href="#">
                    <i class="fa fa-wordpress"></i> <span>文章管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @if($sidebarPresenter->getPlate() == 'category') class="active" @endif ><a href="/admin/article/category"><i class="fa fa-circle-o"></i>分类管理</a></li>
                    <li @if($sidebarPresenter->getPlate() == 'article') class="active" @endif ><a href="/admin/article/article/"><i class="fa fa-circle-o"></i>文章管理</a></li>
                </ul>
            </li>

            <li @if($sidebarPresenter->getPlate() == 'ad') class="active" @endif >
                <a href="/admin/ad/ad">
                    <i class="fa fa-paper-plane"></i> <span>广告管理</span>
                </a>
            </li>

            <li @if($sidebarPresenter->getPlate() == 'seo') class="active" @endif >
                <a href="/admin/seo">
                    <i class="fa fa-google"></i> <span>SEO管理</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>