@extends('web/layout')

    @section('content')
    @include('web/headNavbar')

      <div class="container">

        <div class="col-md-9" style="padding-left: 0px;padding-right: 0px">
          <div class="box box-solid" >
            <div class="box-header with-border" style="padding: 0px;">
              <img class="img-responsive" style="width: 100%" src="{{ $article->image }}" alt="Photo">
              <h1 style="text-align: center;">{{ $article->title }}</h1>
              <p style="text-align: center;">
                <i class="fa fa-fw fa-clock-o"></i>{{ Utility::tranTimeToString($article->created_at) }}
                &nbsp;&nbsp;
                <i class="fa fa-fw fa-eye"></i>{{ $article->view_count }}
              </p>
            </div>
            <div class="box-body">
              <div class="callout callout-default" style="padding-left: 15px;padding-right: 15px; background-color:#f9f9f7">
                <h4>摘要：</h4>
                <p>{{ $article->description }}</p>
              </div>
              {!! $article->content !!}
            </div>
            <div class="box-footer">
              <div class="pull-right">
                 <div class="jiathis_style">
                    <span class="jiathis_txt">分享到：</span>
                    <a class="jiathis_button_tools_1"></a>
                    <a class="jiathis_button_tools_2"></a>
                    <a class="jiathis_button_tools_3"></a>
                    <a class="jiathis_button_tools_4"></a>
                    <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
                  </div>
                  <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
              </div>
            </div>
          </div>

          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">推荐阅读</h3>
            </div>
            <div class="box-body">
              <div class="row">
                @foreach($recommendArticles AS $recommendArticle)
                <div class="col-md-4">
                  <a href="/article/{{ $recommendArticle->id }}">
                    <div class="box box-solid">
                      <div class="box-body" style="padding: 0px">
                        <img class="img-responsive" src="{{ $recommendArticle->image }}?imageView2/1/w/380/h/225" alt="{{ $recommendArticle->title }}">
                      </div>
                      <div class="box-footer text-muted" style="padding: 0px">
                        <h4>
                          {{ $recommendArticle->title }}
                        </h4>
                      </div>
                    </div>  
                  </a>  
                </div>
                @endforeach

              </div>
            </div>
          </div>

        </div>

        <div class="col-md-3" >

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

@stop