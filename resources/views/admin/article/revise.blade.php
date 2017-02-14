@extends('admin/layout')

    @section('content')

        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    更新文章
                    <small>Admin List</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Tables</a></li>
                    <li class="active">Simple</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">更新文章表单</h3>
                            </div><!-- /.box-header -->
                            @inject('parameterPersenter','App\Presenters\Contracts\ConsoleParameterPersenterInterface')
                            @include('admin/messages/reviseMessage')
                            @if ($type === "create")
                            <form class="form-horizontal" action="/admin/article/article" method="post" >
                            @else
                            <form class="form-horizontal" action="/admin/article/article/{{ $article->id }}" method="post"  >
                            <input type="hidden" name="_method" value="put" >
                            {{ $parameterPersenter->setReviseModel($article) }}
                            @endif
                            
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">文章分类</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <select name="article_category_id" id="article_category_id" class="form-control">
                                            @foreach ($articleCategories as $articleCategory)
                                            <option value="{{ $articleCategory->id }}" @if ( $parameterPersenter->getReviseParameter('article_category_id') == $articleCategory->id ) SELECTED  @endif >{{ $articleCategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">标题</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" name="title" class="form-control" id="title" placeholder="名称" value="{{ $parameterPersenter->getReviseParameter('title') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">文章封面</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="image" name="image" placeholder="文章封面" value="{{ $parameterPersenter->getReviseParameter('image') }}" >
                                            <span class="input-group-btn">
                                                <div class="btn btn-info btn-file" id="uploadImageButton">
                                                    <i class="fa fa-paperclip"></i>上传!
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">文章描述</label>
                                    <div class="col-sm-8 col-md-8 col-lg-6">
                                        <textarea id="description" id="description" name="description" class="form-control" rows="3" placeholder="文章描述">{{ $parameterPersenter->getReviseParameter('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">文章内容</label>
                                    <div class="col-sm-10 col-md-10 col-lg-10">
                                        <textarea id="content" name="content" class="form-control" rows="3" style="height: 400px" >{{ $parameterPersenter->getReviseParameter('content') }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">权重</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <input type="text" name="weight" class="form-control" id="weight" placeholder="权重" value="{{ $parameterPersenter->getReviseParameter('weight') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-6">
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary">提交</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div><!-- /.box -->
                    </div><!--/.col (left) -->
                </div>   <!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

    @stop