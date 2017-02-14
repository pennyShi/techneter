@extends('web/layout')
  
    @section('content')
    @include('web/headNavbar')

    <div class="container">

      <div class="row">
        <div class="col-md-9">
          <div class="box box-solid">
            <!-- /.box-header -->
            <div class="box-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                @set('adLocations',Ad::getAdLocations())
                @set('ads',Ad::getAdByLocation($adLocations['article_index_slide']))
                <ol class="carousel-indicators">
                  @foreach($ads AS $ad)
                  <li data-target="#carousel-example-generic" data-slide-to="{{ $loop->index }}"  @if($loop->first) class="active" @endif></li>
                  @endforeach
                </ol>
                <div class="carousel-inner">
                  @foreach($ads AS $ad)
                  <div class="item @if($loop->first) active @endif">
                    <img src="{{ $ad->image }}?imageView2/1/w/900/h/400" alt="{{ $ad->title }}">
                    <div class="carousel-caption">
                      {{ $ad->title }}
                    </div>
                  </div>
                  @endforeach
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-3">
          @set('adLocations',Ad::getAdLocations())
          @set('ads',Ad::getAdByLocation($adLocations['article_index_side']))
          @foreach($ads AS $ad)
          <div class="box box-solid"  style="border-radius:0px;@if($loop->first)margin-top: 5px;@endif"   >
            <a href="{{ $ad->url }}">
              <img class="img-responsive" src="{{ $ad->image }}" alt="{{ $ad->title }}">
            </a>
          </div>
          @endforeach
        </div>
      </div>

      @foreach($articleCategories AS $articleCategory)
      @set('articles',$categoryArticles[$articleCategory->id])
      @if($loop->index%3 == 0)
      <div class="box box-primary">
      @endif

      @if($loop->index%3 == 1)
      <div class="box box-info">
      @endif

      @if($loop->index%3 == 2)
      <div class="box box-success">
      @endif

        <div class="box-header with-border">
          <h3 class="box-title">{{ $articleCategory->name }}</h3>
          <div class="box-tools pull-right">
            <a href="/article/category/{{ $articleCategory->id }}">
              @if($loop->index%3 == 0)
              <span class="label label-primary">
              @endif

              @if($loop->index%3 == 1)
              <span class="label label-info">
              @endif

              @if($loop->index%3 == 2)
              <span class="label label-success">
              @endif
                更多<i class="fa fa-fw fa-plus"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            @foreach($articles AS $article)
            <div class="col-md-3" style="padding-right: 10px;padding-left: 10px;">
              <a href="/article/{{ $article->id }}">
                <div class="box box-solid">
                  <div class="box-body" style="padding: 0px">
                    <img class="img-responsive" src="{{ $article->image }}?imageView2/1/w/424/h/212" alt="">
                  </div>
                  <div class="box-footer text-muted">
                    <h4 class="ellipsis">
                      {{ $article->title }}
                    </h4>
                    <p class="ellipsis">
                      {{ $article->description }}
                    </p>
                  </div>
                </div>  
              </a>  
            </div>


            @endforeach
          </div>
        </div>
      </div>

      @endforeach


    </div>

@stop