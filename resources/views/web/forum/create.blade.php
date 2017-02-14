@extends('web/layout')

    @section('content')
    @include('web/headNavbar')

    <div class="container">
  
      <div class="col-md-9" style="padding-left: 0px;padding-right: 0px">
        <div class="box box-solid" style="border-radius:0px">
          <div class="box-header with-border">
            <h1 style="font-size:22px;margin-top:5px;margin-bottom:5px;">发表对世界的看法</h1>
          </div>

          <div class="box-body">
            <form role="form">
              <div class="form-group">
                <label for="title">标题</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="标题">
              </div>
         
              <div class="form-group">
                <label for="forumCategoryId">分类</label>
                <select class="form-control" name="forum_category_id" id="forumCategoryId">
                    @foreach($forumCategories AS $forumCategory)
                    <option value="{{ $forumCategory->id }}">{{ $forumCategory->name }}</option>
                    @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="inputTitle">内容</label>
                <textarea class="form-control" id="content" name="content" style="display:none;height:500px;" rows="3"></textarea>
              </div>
            </form>
          </div>
        
          <div class="box-footer">
            <button type="button" onclick="store()" class="btn btn-primary">提交</button>
          </div>

        </div>
      </div>

      <div class="col-md-3" >
        @set('adLocations',Ad::getAdLocations())
        @set('ads',Ad::getAdByLocation($adLocations['forum_post_create']))
        @foreach($ads AS $ad)
        <div class="box box-solid" style="border-radius:0px;">
          <a href="{{ $ad->url }}">
            <img class="img-responsive" src="{{ $ad->image }}" alt="{{ $ad->title }}">
          </a>
        </div>
        @endforeach
      </div>
    </div>

    <script type="text/javascript" src="/framework/plupload-2.1.1/js/moxie.js"></script>
    <script type="text/javascript" src="/framework/plupload-2.1.1/js/plupload.full.min.js"></script>
    <script type="text/javascript" src="/framework/plupload-2.1.1/js/i18n/zh_CN.js"></script>
    <script type="text/javascript" src="/framework/qiniu/qiniu.js"></script>
    <script type="text/javascript" src="/framework/wangEditor-2.1.22/dist/js/wangEditor.js"></script>
    <script type="text/javascript" src="/js/upload/editUpload.js"></script>

    <script type="text/javascript">

        var editor = new wangEditor('content');
        editor.config.customUpload = true;  // 设置自定义上传的开关
        editor.config.customUploadInit = uploadInit;  // 配置自定义上传初始化事件，uploadInit方法在上面定义了     
        editor.config.emotionsShow = 'value';
        editor.config.emotions = {
            'default': {
                title: '默认',
                data: '/framework/wangEditor-2.1.22/test/emotions.data'
            },
            'weibo': {
                title: '微博表情',
                data: [
                    {
                        icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/7a/shenshou_thumb.gif',
                        value: '[草泥马]'    
                    },
                    {
                        icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/60/horse2_thumb.gif',
                        value: '[神马]'    
                    },
                    {
                        icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/bc/fuyun_thumb.gif',
                        value: '[浮云]'    
                    },
                    {
                        icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/c9/geili_thumb.gif',
                        value: '[给力]'    
                    },
                    {
                        icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/f2/wg_thumb.gif',
                        value: '[围观]'    
                    },
                    {
                        icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/70/vw_thumb.gif',
                        value: '[威武]'
                    }
                ]
            }
        };
        // onchange 事件
        editor.onchange = function () {
            console.log(this.$txt.html());
        };
        editor.create();
    </script>

    <script type="text/javascript">
        
    function store()
    {
        var title = $("#title").val();
        var forumCategoryId = $("#forumCategoryId").val();
        var content =  $("#content").val();
        var data = {
                'title':title,
                'forum_category_id':forumCategoryId,               
                'content':content
           };

        var url = "/forum/post";
        $.ajax( {
            url:url,
            data:data,  
            type:'post',  
            dataType:'json',  
            success:function(response) {  

                if(response.status == 200)
                {
                    var forumPost = response.data.forumPost;
                    swal({
                      title: "发帖成功!",
                      text: "点击确定跳转至帖子详情",
                      type: "success",
                    },
                    function(){
                        window.location.href = '/forum/post/'+forumPost.id;
                    });

                }else if(response.status == 203){
                    swal({
                      title: "登录之后才能发帖~",
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
                if(messageDatas.title)
                {
                    for(var i=0;i<messageDatas.title.length;i++)
                    {
                        info+=messageDatas.title[i]+"\n";
                    }
                }
                if(messageDatas.forum_category_id)
                {
                    for(var i=0;i<messageDatas.forum_category_id.length;i++)
                    {
                        info+=messageDatas.forum_category_id[i]+"\n";
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

    </script>

@stop