@extends('admin/layout')

    @section('content')

        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    更新管理员
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
                                <h3 class="box-title">更新管理员表单</h3>
                            </div><!-- /.box-header -->
                            @inject('parameterPersenter','App\Presenters\Contracts\ConsoleParameterPersenterInterface')
                            @include('admin/messages/reviseMessage')
                            @if ($type === "create")
                            <form class="form-horizontal" action="/admin/administrators/user" method="post" >
                            @else
                            <form class="form-horizontal" action="/admin/administrators/user/{{ $adminUser->id }}" method="post"  >
                            <input type="hidden" name="_method" value="put" >
                            {{ $parameterPersenter->setReviseModel($adminUser) }}
                            @endif
                            
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">邮箱</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" name="email" class="form-control" id="email" placeholder="邮箱" value="{{ $parameterPersenter->getReviseParameter('email') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">密码</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" name="password" class="form-control" id="password" placeholder="密码" value="{{ $parameterPersenter->getInputParameter('password') }}">
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