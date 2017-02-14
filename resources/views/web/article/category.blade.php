@extends('web/layout')
  
    @section('content')
    @include('web/headNavbar')
      <div class="container">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $articleCategory->name }}</h3>
            </div>
            <div class="box-body">
              <div class="row">
                @foreach($articlePaginate AS $article)
                <div class="col-md-3">
                  <a href="/article/{{ $article->id }}">
                    <div class="box box-solid">
                      <div class="box-body" style="padding: 0px">
                        <img class="img-responsive" src="{{ $article->image }}?imageView2/1/w/380/h/225" alt="Photo">
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
      </div>      
@stop