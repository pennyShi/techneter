@extends('web/layout')

    @section('content')
    @include('web/headNavbar')

    <div class="container">

        <div class="col-md-3" style="padding-left: 0px;padding-right: 0px">

          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username">{{ $userInfo->name }}</h3>
              <h5 class="widget-user-desc">第{{ $userInfo->id }}位用户</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="{{ $userInfo->avatar }}" alt="{{ $userInfo->name }}">
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{ $userInfo->post_count }}</h5>
                    <span class="description-text">发帖</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{ $userInfo->reply_count }}</h5>
                    <span class="description-text">回复</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">{{ $userInfo->praise_count }}</h5>
                    <span class="description-text">点赞</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>

              @if($passport && $passport->id == $userInfo->user_passport_id )

              <div class="row" style="margin-top: 10px">
                <div class="col-sm-12">
                  <a href="/user/info" class="btn btn-block btn-info" role="button">编辑个人资料</a>
                </div>
              </div>

              <div class="row" style="margin-top: 10px">
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li>
                      <a href="/user/info">
                        <i class="fa fa-user"></i>个人资料修改<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
                      </a>
                    </li>
                    <li>
                      <a href="/user/reward">
                        <i class="fa fa-cny"></i>我的打赏<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-qq"></i>绑定信息<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>

              @endif

            </div>
          </div>

        </div>

        <div class="col-md-9">

          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#tab_1-1" data-toggle="tab">Ta发布的帖子</a></li>
              <li><a href="#tab_2-2" data-toggle="tab">Ta回复的帖子</a></li>
              <li><a href="#tab_3-2" data-toggle="tab">Ta赞过的帖子</a></li>
              <li class="pull-left header"><i class="fa fa-th"></i>Ta的动态</li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1-1">
                <ul class="products-list product-list-in-box">
                  @foreach($userForumPosts AS $userForumPost)
                  @set('forumPost',$forumPosts->find($userForumPost->id))
                  <li class="item">
                    <div class="product-info" style="margin-left:0px">
                      <a href="/forum/post/{{ $forumPost->id }}" class="product-title">
                        {{ $forumPost->title }}
                        <span class="label label-info pull-right">{{ Utility::tranTimeToSimpleString($forumPost->created_at) }}</span></a>
                        <span class="product-description">
                            {{ $forumPost->reply_count }}个回复⋅{{ $forumPost->praise_count }}个点赞⋅{{ $forumPost->view_count }}次阅读
                        </span>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2-2">
                <ul class="products-list product-list-in-box">
                  @foreach($userForumReplies AS $userForumRepliy)
                  @set('forumPost',$forumPosts->find($userForumRepliy->forum_post_id))
                  <li class="item">
                    <div class="product-info" style="margin-left:0px">
                      <a href="/forum/post/{{ $forumPost->id }}" class="product-title">
                        {{ $forumPost->title }}
                        <span class="label label-info pull-right">{{ Utility::tranTimeToSimpleString($forumPost->created_at) }}</span></a>
                        <span class="product-description">
                            {{ $forumPost->reply_count }}个回复⋅{{ $forumPost->praise_count }}个点赞⋅{{ $forumPost->view_count }}次阅读
                        </span>
                    </div>
                  </li>
                  @endforeach                          
                </ul>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3-2">
                <ul class="products-list product-list-in-box">
                  @foreach($userForumPraises AS $userForumPraise)
                  @set('forumPost',$forumPosts->find($userForumPraise->forum_post_id))
                  <li class="item">
                    <div class="product-info" style="margin-left:0px">
                      <a href="/forum/post/{{ $forumPost->id }}" class="product-title">
                        {{ $forumPost->title }}
                        <span class="label label-info pull-right">{{ Utility::tranTimeToSimpleString($forumPost->created_at) }}</span></a>
                        <span class="product-description">
                            {{ $forumPost->reply_count }}个回复⋅{{ $forumPost->praise_count }}个点赞⋅{{ $forumPost->view_count }}次阅读
                        </span>
                    </div>
                  </li>
                  @endforeach                  
                </ul>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>

        </div>

    </div>
@stop