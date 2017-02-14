@extends('web/layout')

    @section('content')
    @include('web/headNavbar')

      <div class="container">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">如果我的文章对您有用，请随意打赏。你的支持将鼓励我继续创作！</h4>
                    </div>
                    <div class="modal-body">
                      <div class="box box-solid center-block" style="border-radius:0px;">
                        @if($forumPostUserInfo->reward)                 
                        <img class="center-block img-responsive pad" src="{{ $forumPostUserInfo->reward }}" alt="打赏二维码">
                        @else
                        <img class="center-block img-responsive pad" src="http://techneter.sport-x.cn/images/web/reward.png" alt="打赏二维码">
                        @endif

                      </div>    
                    </div>
                    <div class="modal-footer">
                       <p style="text-align: center;">请使用微信扫描二维码。<a target="_blank" href="http://okor2yqni.bkt.clouddn.com/o_1b8s0a4a213vnf2f13qmqj1s9o7.png">如何开启打赏？</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9" style="padding-left: 0px;padding-right: 0px">
          <div class="box box-solid" >
            <div class="box-header with-border">
              <h1 style="font-size:27px;margin-top:5px;margin-bottom:5px;">{{ $forumPost->title }}</h1>
            </div>

            <div class="box-body">
              {!! $forumPost->content !!}
            </div>

            <div class="box-footer">

              <div class="text-center" style="margin-top: 10px;margin-bottom: 10px;" >
                @if(in_array($userPassportId,$forumPostPraiseUserPassportIds))
                <span id="praiseButton">
                  <a href="javascript:cancelPraise({{ $forumPost->id }})" class="btn btn-success">
                    <span class="fa fa-fw fa-thumbs-up"></span>已赞
                  </a>
                </span>
                @else
                <span id="praiseButton">
                  <a href="javascript:doPraise({{ $forumPost->id }})" class="btn btn-success">
                    <span class="fa fa-fw fa-thumbs-up"></span>点赞
                  </a>
                </span>
                @endif
                &nbsp;or&nbsp;
                <span id="rewardButton">
                  <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-warning">
                    <span class="fa fa-fw fa-cny"></span>打赏
                  </a> 
                </span>
              </div>

              <ul class="users-list clearfix" id="praiseBox">
                @foreach($forumPostPraises AS $forumPostPraise) 
                @set('userInfo',$userInfos->where('user_passport_id',$forumPostPraise->user_passport_id)->first())
                <li style="width: 8%" id="praise_{{ $userInfo->user_passport_id }}">
                  <a target="_blank" href="/user/{{ $userInfo->user_passport_id }}">
                    <img src="{{ $userInfo->avatar }}" alt="{{ $userInfo->name }}">
                  </a>
                  <a class="users-list-name" target="_blank" href="/user/{{ $userInfo->user_passport_id }}" >{{ $userInfo->name }}</a>
                  <span class="users-list-date ellipsis" >{{Utility::tranTimeToSimpleString($forumPostPraise->created_at)}}</span>
                </li>
                @endforeach
              </ul>
            </div>

          </div>

          <div class="box box-solid" >
            <div class="box-header with-border">
              <h5> 回复量：<span id="replyCount" >{{ $forumPost->reply_count }}</span> </h5>
            </div>

            <div class="box-body box-comments" id="commentBox" style="background-color: #ffffff;">
              @foreach($forumReplies AS $forumReply)
              @set('userInfo',$userInfos->where('user_passport_id',$forumReply->user_passport_id)->first())
              <div class="box-comment">
                <a target="_blank" href="/user/{{ $forumReply->user_passport_id }}">
                  <img class="img-circle img-sm" src="{{ $userInfo->avatar }}" alt="{{ $userInfo->name }}">
                </a>
                <div class="comment-text">
                      <span class="username">
                        {{ $userInfo->name }}
                        <span class="text-muted pull-right">{{ Utility::tranTimeToString( $forumReply->created_at ) }}</span>
                      </span>
                  {{ $forumReply->content }}
                </div>
              </div>
              @endforeach
            </div>
            <div class="box-footer">
              <form action="#" method="post">
                @if($passportUserInfo)
                <img class="img-responsive img-circle img-sm" src="{{ $passportUserInfo->avatar }}">
                @else
                <img class="img-responsive img-circle img-sm" src="/framework/AdminLTE/img/avatar5.png">
                @endif
                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
                  <div class="input-group">
                      <input type="text" name="reply_content" id="replyContent" placeholder="说点什么 ..." class="form-control">
                      <span class="input-group-btn">
                        <button type="button"  onclick="reply({{ $forumPost->id }})" class="btn btn-primary btn-flat">回复</button>
                      </span>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-md-3" >
         <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <a href="/user/{{ $forumPostUserInfo->user_passport_id }}" target="_blank" >
                <div class="widget-user-image">
                  <img class="img-circle" src="{{ $forumPostUserInfo->avatar }}" alt="{{ $forumPostUserInfo->name }}">
                </div>
             </a>  
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">{{ $forumPostUserInfo->name }}</h3>
              <h5 class="widget-user-desc"><br></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">浏览数 <span class="pull-right badge bg-blue">{{ $forumPost->view_count }}</span></a></li>
                <li><a href="#">点赞数 <span class="pull-right badge bg-aqua">{{ $forumPost->praise_count }}</span></a></li>
                <li><a href="#">回复数<span class="pull-right badge bg-green">{{ $forumPost->reply_count }}</span></a></li>
              </ul>
            </div>
          </div>

          @set('adLocations',Ad::getAdLocations())
          @set('ads',Ad::getAdByLocation($adLocations['forum_detail_side']))
          @foreach($ads AS $ad)
          <div class="box box-solid" style="border-radius:0px;">
            <a href="{{ $ad->url }}">
              <img class="img-responsive" src="{{ $ad->image }}" alt="{{ $ad->title }}">
            </a>
          </div>
          @endforeach

        </div>

      </div>

      <script type="text/javascript">
      function reply(forumPostId)
      {
        var replyContent = $("#replyContent").val();
        var data = {
                'forum_post_id':forumPostId,               
                'content':replyContent
           };

        var url = "/forum/reply";
        $.ajax( {
            url:url,
            data:data,  
            type:'post',  
            dataType:'json',  
            success:function(response) {  

                if(response.status == 200)
                {
                    var userInfo = response.data.userInfo;
                    var userPassportId = userInfo.user_passport_id;
                    var avatar = userInfo.avatar;
                    var name = userInfo.name;
                    var htmlString='<div class="box-comment"><a href="/user/'+userPassportId+'" target="_blank" ><img class="img-circle img-sm" src="'+avatar+'" alt="'+name+'"></a><div class="comment-text"><span class="username">'+name+'<span class="text-muted pull-right">刚刚</span></span>'+replyContent+'</div></div>';
                    $("#commentBox").append(htmlString);
                    swal("回帖成功!", "", "success");
                    $("#replyContent").val('');

                }else if(response.status == 203){
                    swal({
                      title: "登录之后才能回复~",
                      text: "点击去<a href='/login/qq'>登录</a>",
                      html: true
                    });
                }else{
                    sweetAlert("异常", "发生了一个致命的错误!", "error");
                }
            },  
            error : function(messages) {
              var messageDatas = messages.responseJSON;
              var info="";
              if(messageDatas.forum_post_id)
              {
                  for(var i=0;i<messageDatas.forum_post_id.length;i++)
                  {
                      info+=messageDatas.forum_post_id[i]+"\n";
                  }
              }
              if(messageDatas.content)
              {
                  for(var i=0;i<messageDatas.content.length;i++)
                  {
                      info+=messageDatas.content[i]+"\n";
                  }
              }
              sweetAlert("失败", info, "error");
            }  
        });
      }

      function doPraise(forumPostId)
      {
        var data = {
              'forum_post_id':forumPostId,               
           };

        var url = "/forum/praise";
        $.ajax( {
            url:url,
            data:data,  
            type:'post',  
            dataType:'json',  
            success:function(response) {  
                if(response.status == 200)
                {
                  var userInfo = response.data.userInfo;
                  var avatar = userInfo.avatar;
                  var name = userInfo.name;
                  var userPassportId = userInfo.user_passport_id;
                  var htmlString = '<li style="width: 8%" id="praise_'+userPassportId+'"><a href="/user/'+userPassportId+'" target="_blank" ><img src="'+avatar+'" alt="'+name+'"></a><a class="users-list-name" href="/user/'+userPassportId+'" target="_blank">'+name+'</a><span class="users-list-date ellipsis" >刚刚</span></li>';
                  $("#praiseBox").append(htmlString);
                  var htmlString = '<a href="javascript:cancelPraise('+forumPostId+')" class="btn btn-success"><span class="fa fa-fw fa-thumbs-up"></span>已赞</a>';
                  $("#praiseButton").html(htmlString);
                }else if(response.status == 203){
                    swal({
                      title: "登录之后才能点赞~",
                      text: "点击去<a href='/login/qq'>登录</a>",
                      html: true
                    });
                }else{
                  sweetAlert("异常", "发生了一个致命的错误!", "error");
                }
            },  
            error : function(messages) {
              var messageDatas = messages.responseJSON;
              var info="";
              if(messageDatas.forum_post_id)
              {
                  for(var i=0;i<messageDatas.forum_post_id.length;i++)
                  {
                      info+=messageDatas.forum_post_id[i]+"\n";
                  }
              }
              sweetAlert("失败", info, "error");
            }  
        });
      }

      function cancelPraise(forumPostId)
      {
        var data = {
                'forum_post_id':forumPostId,               
          };

        var url = "/forum/praise";
        $.ajax( {
            url:url,
            data:data,  
            type:'delete',  
            dataType:'json',  
            success:function(response) {  
              
                if(response.status == 200)
                {
                  var userInfo = response.data.userInfo;
                  var userPassportId = userInfo.user_passport_id;
                  $("#praise_"+userPassportId).remove();
                  //swal("取消成功", "", "success");
                  var htmlString = '<a href="javascript:doPraise('+forumPostId+')" class="btn btn-success"><span class="fa fa-fw fa-thumbs-up"></span>点赞</a>';
                  $("#praiseButton").html(htmlString);

                }else if(response.status == 203){
                    swal({
                      title: "登录之后才能点赞~",
                      text: "点击去<a href='/login/qq'>登录</a>",
                      html: true
                    });
                }else{
                  sweetAlert("异常", "发生了一个致命的错误!", "error");
                }

            },  
            error : function(message) {
                var messageDatas = messages.responseJSON;
                var info="";
                if(messageDatas.forum_post_id)
                {
                    for(var i=0;i<messageDatas.forum_post_id.length;i++)
                    {
                        info+=messageDatas.forum_post_id[i]+"\n";
                    }
                }
                sweetAlert("失败", info, "error");
            }  
        });
      }

      </script>

@stop