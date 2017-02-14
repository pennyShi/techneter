@extends('web/layout')

    @section('content')
    @include('web/headNavbar')

      <div class="container">
        <div class="col-md-9" style="padding-left: 0px;padding-right: 0px">
          <div class="panel panel-default" style="border-radius:0px">
            <div class="panel-heading">
              <ul class="list-inline" style="margin-bottom: 0px;font-size: 14px;">
                  <li><a href="/forum" @if($order=="default") class="forumPanelBarActive" @endif>默认</a></li>
                  <li><a href="/forum?order=hot" @if($order=="hot") class="forumPanelBarActive" @endif >热度</a></li>
                  <li><a href="/forum?order=praise" @if($order=="praise") class="forumPanelBarActive" @endif >关注度</a></li>
              </ul>
            </div>
            <ul class="list-group">
            @foreach($forumPostPaginate AS $forumPost)
            @set('userInfo',$userInfos->where('user_passport_id',$forumPost->user_passport_id)->first())
                <li class="list-group-item" style="padding-top: 5px;padding-bottom: 5px; height:70px;">
                 <a href="/forum/post/{{ $forumPost->id }}">
                  <div class="pull-left">
                    <img class="img-circle img-md img-bordered-sm" src="{{ $userInfo->avatar }}">
                  </div>
                  <div class="pull-left" style="margin-top:10px;margin-left: 15px;">
                    <h4 style="font-size: 16px;" class="text-muted ellipsis" >
                        <!--
                        <span class="label label-success">精选</span>
                        -->
                        {{ $forumPost->title }}
                    </h4>
                  </div>
                  <div class="pull-right">
                      <div style="line-height: 30px;height: 30px; margin-top: 15px">
                         <span style="font-size: 17px;color: #9e78c0;">
                            {{ $forumPost->reply_count }}
                         </span> 
                         <span class="text-muted" style="margin-left: 5px;margin-right: 5px;">
                           /
                         </span>
                         <span class="text-muted" style="font-size: 17px">
                            {{ $forumPost->praise_count }}
                         </span>
                         <span class="text-muted" style="margin-left: 5px;margin-right: 5px;" >
                           /
                         </span>
                         <span class="text-muted" style="font-size: 17px">
                            {{ $forumPost->view_count }}
                         </span>
                         <span class="text-muted"  style="margin-left: 5px;margin-right: 5px;" >
                           |
                         </span>
                         <span class="text-muted" style="font-size: 13px">
                          {{ Utility::tranTimeToSimpleString($forumPost->created_at) }}  
                         </span>
                      </div> 
                  </div>
                  </a>
                </li>
            @endforeach
            </ul>

            <div class="box-footer clearfix">
              {{ $forumPostPaginate->appends([])->render() }}
            </div>
          </div>

        </div>

        <div class="col-md-3" >
          <div class="panel panel-default" style="border-radius:0px;height: 100px;line-height: 100px;padding-top:35px;padding-left: 20px;padding-right: 20px;">
            <a href="/forum/post/pub" class="btn btn-block btn-social btn-twitter">
              <i class="fa fa-twitter"></i> 发帖
            </a>
          </div>

          <div class="panel panel-default" style="border-radius:0px;border:0px;" >
            <div class="panel-heading">热门帖子</div>
            <div class="panel-body">
               <ul class="list-group">
                <li class="list-group-item" style="border-radius:0px;border:0px;text-overflow:ellipsis;overflow: hidden; white-space: nowrap;" >
                  基于 Laravel collect 的 PHP Extension
                </li>
                <li class="list-group-item" style="border-radius:0px;border:0px;text-overflow:ellipsis;overflow: hidden; white-space: nowrap;" >
                  基于 Laravel collect 的 PHP Extension
                </li>
                <li class="list-group-item" style="border-radius:0px;border:0px;text-overflow:ellipsis;overflow: hidden; white-space: nowrap;" >
                  基于 Laravel collect 的 PHP Extension
                </li>
                <li class="list-group-item" style="border-radius:0px;border:0px;text-overflow:ellipsis;overflow: hidden; white-space: nowrap;" >
                  基于 Laravel collect 的 PHP Extension
                </li>
               </ul>
            </div>
          </div>
      
          @set('adLocations',Ad::getAdLocations())
          @set('ads',Ad::getAdByLocation($adLocations['forum_index_side']))
          @foreach($ads AS $ad)
          <div class="panel panel-default" style="border-radius:0px;">
            <a href="{{ $ad->url }}">
              <img class="img-responsive" src="{{ $ad->image }}" alt="{{ $ad->title }}">
            </a>
          </div>
          @endforeach

          <div class="panel panel-default" style="border-radius:0px;" >
            <div class="panel-heading">热门资源</div>
            <div class="panel-body">
               <ul class="list-group">
                <li class="list-group-item" style="border-radius:0px;" >
                  Laravel 中文文档
                </li>
                <li class="list-group-item" style="border-radius:0px;" >
                  Laravel 中文文档
                </li>

                <li class="list-group-item" style="border-radius:0px;" >
                  Laravel 中文文档
                </li>
                <li class="list-group-item" style="border-radius:0px;" >
                  Laravel 中文文档
                </li>
               </ul>
            </div>
          </div>

        </div>

      </div>
@stop