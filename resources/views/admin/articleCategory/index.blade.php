@extends('admin/layout')

    @section('content')
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                文章分类管理
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
                <div class="col-xs-12">

                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">文章分类列表</h3>
                            <div style="float:right;margin-right:30px">
                                <a href="/admin/article/category/create" class="btn btn-block btn-success" role="button">新建</a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                  
                            <table class="table table-hover">
                                <tr>
                                    <th>ID</th>
                                    <th>名称</th>
                                    <th>权重</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach ($articleCategoryPaginate as $articleCategory)
                                <tr>
                                    <td>
                                        {{ $articleCategory->id }}
                                    </td>
                                    <td>
                                        {{ $articleCategory->name }}
                                    </td>
                                    <td>
                                        {{ $articleCategory->weight }}
                                    </td>
                                    <td>
                                        {{ $articleCategory->created_at }}
                                    </td>
                                    <td>
                                        <div style="float:left">
                                            <div style="float:left;margin-right:15px">
                                                <a href="/admin/article/category/{{ $articleCategory->id }}/edit" class="btn btn-block btn-primary" role="button">修改</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                           {{ $articleCategoryPaginate->render() }}
                        </div>
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper --> 

@stop

