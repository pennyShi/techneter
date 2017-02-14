@extends('admin/layout')

    @section('content')

        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    更新帖子分类
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
                                <h3 class="box-title">更新帖子分类表单</h3>
                            </div><!-- /.box-header -->
                            @inject('parameterPersenter','App\Presenters\Contracts\ConsoleParameterPersenterInterface')
                            @include('admin/messages/reviseMessage')
                            @if ($type === "create")
                            <form class="form-horizontal" action="/admin/forum/category" method="post" >
                            @else
                            <form class="form-horizontal" action="/admin/forum/category/{{ $forumCategory->id }}" method="post"  >
                            <input type="hidden" name="_method" value="put" >
                            {{ $parameterPersenter->setReviseModel($forumCategory) }}
                            @endif
                            
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">名称</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="名称" value="{{ $parameterPersenter->getReviseParameter('name') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">权重</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
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