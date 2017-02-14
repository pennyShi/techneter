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
          <div class="box box-primary">
              <div class="box-header">
                  <h3 class="box-title">个人资料修改</h3>
              </div>
              <form class="form-horizontal" method="post">
                  <div class="form-group">
                      <label for="inpuTitle" class="col-sm-2 control-label">头像</label>
                      <div class="col-sm-8 col-md-6 col-lg-4">
                          <img id="avatarImage" class="img-circle img-md img-bordered-sm" src="{{ $userInfo->avatar }}">
                          <input type="hidden" id="avatar" value="{{ $userInfo->avatar }}">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="inpuTitle" class="col-sm-2 control-label">名称</label>
                      <div class="col-sm-8 col-md-6 col-lg-4">
                          <input type="text" name="name" class="form-control" id="name" placeholder="名称" value="{{ $userInfo->name }}">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="inpuTitle" class="col-sm-2 control-label">性别</label>
                      <div class="col-sm-6 col-md-4 col-lg-2">   
                          <label style="margin-top: 5px">
                              <input type="radio" name="gender" value="{{ $userInfoGenders['male'] }}" @if($userInfo->gender == $userInfoGenders['male']) CHECKED @endif  />
                              男&nbsp;&nbsp;
                          </label>
                          <label style="margin-top: 5px">
                              <input type="radio" name="gender" value="{{ $userInfoGenders['famale'] }}" @if($userInfo->gender == $userInfoGenders['famale']) CHECKED @endif   />
                              女&nbsp;&nbsp;
                          </label>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label"></label>
                      <div class="col-sm-6">
                          <div class="box-footer">
                              <button type="button" onclick="updateUserInfo()" class="btn btn-primary">确定</button>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
        </div>
    </div>

<script type="text/javascript" src="/framework/plupload-2.1.1/js/moxie.js"></script>
<script type="text/javascript" src="/framework/plupload-2.1.1/js/plupload.full.min.js"></script>
<script type="text/javascript" src="/framework/plupload-2.1.1/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="/framework/qiniu/qiniu.js"></script>
<script type="text/javascript" src="/js/upload/upload.js"></script>
<script type="text/javascript">
    var uploadDom = 'avatarImage';
    var fileUploaded = function(up, file, info) {
                  var domain = up.getOption('domain');
                  var res = $.parseJSON(info);
                  var sourceLink = domain + res.key;
                  $("#avatar").val(sourceLink);
                  $("#avatarImage").attr('src',sourceLink);
              };

    upload(uploadDom,fileUploaded);
    function updateUserInfo()
    {

      var avatar = $("#avatar").val();
      var name = $("#name").val();
      var gender = $("input[name='gender']:checked").val();
      var url = "/user/info";
      var data ={
        'avatar':avatar,
        'name':name,               
        'gender':gender
      };

      $.ajax( {
          url:url,
          data:data,  
          type:'post',  
          dataType:'json',  
          success:function(response) {  

              if(response.status == 200)
              {
                  swal({
                    title: "修改资料成功!",
                    text: "",
                    type: "success",
                  });

              }else if(response.status == 203){
                  swal({
                    title: "登录之后才能修改个人资料",
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
              if(messageDatas.avatar)
              {
                  for(var i=0;i<messageDatas.avatar.length;i++)
                  {
                      info+=messageDatas.avatar[i]+"\n";
                  }
              }
              if(messageDatas.name)
              {
                  for(var i=0;i<messageDatas.name.length;i++)
                  {
                      info+=messageDatas.name[i]+"\n";
                  }
              }
              if(messageDatas.gender)
              {
                  for(var i=0;i<messageDatas.gender.length;i++)
                  {
                      info+=messageDatas.gender[i]+"\n";
                  }
              }
              sweetAlert("失败", info, "error");
          }  
      });



    }





</script>

@stop