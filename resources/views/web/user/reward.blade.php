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
            </div>
          </div>
        </div>

        <div class="col-md-9">
          <div class="box box-widget">
            <div class="box-body">            
              @if($userInfo->reward)
              <img id="rewardImage" class="img-responsive pad" src="{{ $userInfo->reward }}" alt="Photo">
              @else
              <img id="rewardImage" class="img-responsive pad" src="http://techneter.sport-x.cn/images/web/reward.png" alt="打赏">
              @endif
              <button type="button" id="rewardButton" class="btn btn-info"><i class="fa fa-cny"></i> 上传我的打赏二维码</button>
            </div>
          </div>    
        </div>
    </div>

    <script type="text/javascript" src="/framework/plupload-2.1.1/js/moxie.js"></script>
    <script type="text/javascript" src="/framework/plupload-2.1.1/js/plupload.full.min.js"></script>
    <script type="text/javascript" src="/framework/plupload-2.1.1/js/i18n/zh_CN.js"></script>
    <script type="text/javascript" src="/framework/qiniu/qiniu.js"></script>
    <script type="text/javascript" src="/js/upload/upload.js"></script>
    <script type="text/javascript">
    var uploadDom = 'rewardButton';
    var fileUploaded = function(up, file, info) {
                  var domain = up.getOption('domain');
                  var res = $.parseJSON(info);
                  var sourceLink = domain + res.key;
                  var url = '/user/reward';
                  var data = {
                    'reward':sourceLink
                  };

                  $.ajax({
                      url:url,
                      data:data,  
                      type:'post',  
                      dataType:'json',  
                      success:function(response) {  

                          if(response.status == 200)
                          {
                              swal({
                                title: "修改打赏成功!",
                                text: "",
                                type: "success",
                              });
                              $("#rewardImage").attr('src',sourceLink);
                          }else if(response.status == 203){
                              swal({
                                title: "登录之后才能修改打赏成",
                                text: "点击去<a href='/login/qq'>登录</a>",
                                html: true
                              });
                          }else{
                              alert("失败");
                          }

                      },  
                      error : function(messages) {
                          var messageDatas = messages.responseJSON;
                          var info="";
                          if(messageDatas.reward)
                          {
                              for(var i=0;i<messageDatas.reward.length;i++)
                              {
                                  info+=messageDatas.reward[i]+"\n";
                              }
                          }
                          sweetAlert("失败", info, "error");
                      }  
              
                 });     
              };

    upload(uploadDom,fileUploaded);
    </script>

@stop