@extends('web/layout')
  
    @section('content')
    @include('web/headNavbar')

    <div class="container">

      <div class="row">

        @set('adLocations',Ad::getAdLocations())
        @set('ads',Ad::getAdByLocation($adLocations['index_collection']))
        @foreach($ads AS $ad)
        <div class="col-md-3" style="padding-right: 10px;padding-left: 10px;">
          <a target="_blank" href="{{ $ad->url }}">
            <div class="box box-solid">
              <div class="box-body" style="padding: 0px">
                <img class="img-responsive" src="{{ $ad->image }}?imageView2/1/w/424/h/212" alt="">
              </div>
              <div class="box-footer text-muted">
                <h4 class="ellipsis">
                  {{ $ad->title }}
                </h4>
                <p class="ellipsis">
                  {{ $ad->description }}
                </p>
              </div>
            </div>  
          </a>  
        </div>
        @endforeach
      </div>

      <div class="row">

        <div class="panel panel-default" style="border-radius:0px">
          <div class="panel-heading" style="text-align: center;">
            社区精华帖<i class="fa fa-fw fa-rss-square"></i>
          </div>
          <ul class="list-group">
              @foreach($forumPosts AS $forumPost)
              @set('userInfo',$userInfos->where('user_passport_id',$forumPost->user_passport_id)->first())
              <li class="list-group-item col-md-6" style="padding-top: 5px;padding-bottom: 5px; height:70px; border-top-width: 1px;">
               <a href="/forum/post/{{ $forumPost->id }}">
                <div class="pull-left">
                  <img class="img-circle img-md img-bordered-sm" src="{{ $userInfo->avatar }}">
                </div>
                <div class="pull-left" style="margin-top:10px;margin-left: 15px;">
                  <h4 style="font-size: 16px;" class="text-muted ellipsis" >
                      {{ $forumPost->title }}
                  </h4>
                </div>
                <div class="pull-right">
                    <div style="line-height: 30px;height: 30px; margin-top: 13px">
                       <span class="text-muted" style="font-size: 13px">
                         {{ $forumPost->praise_count }}点赞·{{ $forumPost->reply_count }}回复
                       </span>
                    </div> 
                </div>
                </a>
              </li>
              @endforeach
          </ul>
        </div>

      </div>

    </div>

@stop