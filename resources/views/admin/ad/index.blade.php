@extends('admin/layout')

    @section('content')

    <div class="content-wrapper">

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">添加广告</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid" id="modalThemes">
                            <div class="col-xs-12">

                                <form class="form-horizontal">
                                    <input type="hidden" id="location" name="location" value="">
                                    <div class="form-group">
                                        <label for="inpuTitle" class="col-sm-2 control-label">标题</label>
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            <input type="text" name="title" class="form-control" id="title" placeholder="标题" value="" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inpuDescription" class="col-sm-2 control-label">描述</label>
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            <textarea id="description" name="description" class="form-control" rows="3" ></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inpuTitle" class="col-sm-2 control-label">广告图片</label>
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="image" name="image" placeholder="广告图片" value="" >
                                                <span class="input-group-btn">
                                                    <div class="btn btn-info btn-file" id="uploadImageButton">
                                                        <i class="fa fa-paperclip"></i>上传!
                                                    </div>
                                                </span>
                                            </div>    
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inpuTitle" class="col-sm-2 control-label">URL</label>
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            <input type="text" name="url" class="form-control" id="url" placeholder="URL" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inpuTitle" class="col-sm-2 control-label">权重</label>
                                        <div class="col-sm-10 col-md-10 col-lg-5">
                                            <input type="text" name="weight" class="form-control" id="weight" placeholder="权重" value="">
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="storeAd()" >确定</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">修改广告</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid" id="modalThemes">
                            <div class="col-xs-12">

                                <form class="form-horizontal">
                                    <input type="hidden" id="idUpdate" name="idUpdate" value="">
                                    <input type="hidden" id="locationUpdate" name="locationUpdate" value="">
                                    <div class="form-group">
                                        <label for="inpuTitle" class="col-sm-2 control-label">标题</label>
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            <input type="text" name="titleUpdate" class="form-control" id="titleUpdate" placeholder="标题" value="" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inpuDescription" class="col-sm-2 control-label">描述</label>
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            <textarea id="descriptionUpdate" name="descriptionUpdate" class="form-control" rows="3" ></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inpuTitle" class="col-sm-2 control-label">广告图片</label>
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="imageUpdate" name="imageUpdate" placeholder="广告图片" value="" >
                                                <span class="input-group-btn">
                                                    <div class="btn btn-info btn-file" id="uploadImageUpdateButton">
                                                        <i class="fa fa-paperclip"></i>上传!
                                                    </div>
                                                </span>
                                            </div>    
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inpuTitle" class="col-sm-2 control-label">URL</label>
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            <input type="text" name="urlUpdate" class="form-control" id="urlUpdate" placeholder="URL" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inpuTitle" class="col-sm-2 control-label">权重</label>
                                        <div class="col-sm-10 col-md-10 col-lg-5">
                                            <input type="text" name="weightUpdate" class="form-control" id="weightUpdate" placeholder="权重" value="">
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateAd()" >确定</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                广告管理
                <small>example</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">UI</a></li>
                <li class="active">Timeline</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- row -->
          <div class="row">
            <div class="col-md-12">
              <!-- The time line -->
              <ul class="timeline">
                <!-- timeline time label -->
                <li class="time-label">
                    <span class="bg-green">
                        推荐位管理
                    </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                @foreach($locations AS $location)
                @set('locationAds',$ads->where('location',$location))
                <li>
                    <i class="fa fa-windows bg-purple"></i>
                    <div class="timeline-item">
                        <h3 class="timeline-header"><a href="#">@if(isset($transLocations[$location])) {{ $transLocations[$location] }} @endif</a></h3>
                        <div class="timeline-body">
                            <ul id="adContent_{{ $location }}" class="mailbox-attachments clearfix">
                                @foreach($locationAds AS $locationAd)
                                <li id="{{ $locationAd->id }}">
                                    <span class="mailbox-attachment-icon has-img"><img src="{{ $locationAd->image }}" alt="Attachment" /></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i>{{ $locationAd->title }}</a>
                                        <span class="mailbox-attachment-size">
                                            权重：{{ $locationAd->weight }}
                                            <a data-toggle="modal" data-target="#myModal2" onclick="showEditAd({{ $locationAd->id }})" class="btn btn-default btn-xs pull-right"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:destroy({{ $locationAd->id }})" class="btn btn-default btn-xs pull-right"><i class="fa fa-trash-o"></i></a>
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="timeline-footer">
                            <button class="btn btn-block btn-primary" style="width:80px"  data-toggle="modal" data-target="#myModal" onclick="showAddAd({{ $location }})">添加</button>
                        </div>
                    </div>
                </li>
                @endforeach

                <!-- END timeline item -->
                <!-- END timeline item -->
                <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                </li>
              </ul>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    @stop

