
var uploadDom = 'uploadImageButton';
var fileUploaded = function(up, file, info) {
              var domain = up.getOption('domain');
              var res = $.parseJSON(info);
              var sourceLink = domain + res.key;
              $("#image").val(sourceLink);
          };

upload(uploadDom,fileUploaded);

var uploadUpdateDom = 'uploadImageUpdateButton';
var fileUpdateUploaded = function(up, file, info) {
              var domain = up.getOption('domain');
              var res = $.parseJSON(info);
              var sourceLink = domain + res.key;
              $("#imageUpdate").val(sourceLink);
          };
upload(uploadUpdateDom,fileUpdateUploaded);

function showAddAd(location)
{
    $("#title").val('');
    $("#description").val('');
    $("#image").val('');
    $("#url").val('');
    $("#weight").val('');
    $("#location").val(location);
}

function storeAd()
{
    var location    = $("#location").val();
    var title       = $("#title").val();
    var description = $("#description").val();
    var image       = $("#image").val();
    var url         = $("#url").val();
    var weight      = $("#weight").val();

    var api = '/admin/ad/ad';

    $.ajax( {  
        url:api,// 跳转到 action  
        data:{  
              location      : location,
              title         : title,
              description   : description,
              image         : image,
              url           : url,
              weight        : weight
        },  
        type:'post',  
        dataType:'json',  
        success:function(response) {  
            var html='<li id="'+response.data.ad.id+'"><span class="mailbox-attachment-icon has-img"><img src="'+response.data.ad.image+'" alt="Attachment" /></span><div class="mailbox-attachment-info"><span class="mailbox-attachment-size">权重：'+response.data.ad.weight+'<a data-toggle="modal" data-target="#myModal2" onclick="showEditAd('+response.data.ad.id+')" class="btn btn-default btn-xs pull-right"><i class="fa fa-edit"></i></a><a href="javascript:destroy('+response.data.ad.id+')" class="btn btn-default btn-xs pull-right"><i class="fa fa-trash-o"></i></a></span></div></li>';
            $("#adContent_"+response.data.ad.location).append(html);
        },  
        error : function() {
            alert("异常！");  
        }  
    });
}

function showEditAd(id)
{
    var api = '/admin/ad/ad/getById';

    $.ajax( {  
        url:api,// 跳转到 action  
        data:{  
              id  : id,
        },  
        type:'get',  
        dataType:'json',  
        success:function(response) {  

            $("#titleUpdate").val(response.data.ad.title);
            $("#descriptionUpdate").val(response.data.ad.description);
            $("#imageUpdate").val(response.data.ad.image);
            $("#urlUpdate").val(response.data.ad.url);
            $("#weightUpdate").val(response.data.ad.weight);
            $("#locationUpdate").val(response.data.ad.location);
            $("#idUpdate").val(response.data.ad.id);
        },  
        error : function() {
            alert("异常！");  
        }  
    });
}

function updateAd()
{
    var id          = $("#idUpdate").val();
    var location    = $("#locationUpdate").val();
    var title       = $("#titleUpdate").val();
    var description = $("#descriptionUpdate").val();
    var image       = $("#imageUpdate").val();
    var url         = $("#urlUpdate").val();
    var weight      = $("#weightUpdate").val();

    var api = '/admin/ad/ad/'+id;

    $.ajax( {  
        url:api,// 跳转到 action  
        data:{
              location      : location,
              title         : title,
              description   : description,
              image         : image,
              url           : url,
              weight        : weight
        },  
        type:'put',  
        dataType:'json',  
        success:function(response) {  
            $("#"+id).remove();
            var html='<li id="'+response.data.ad.id+'"><span class="mailbox-attachment-icon has-img"><img src="'+response.data.ad.image+'" alt="Attachment" /></span><div class="mailbox-attachment-info"><a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i>'+response.data.ad.title+'</a><span class="mailbox-attachment-size">权重：'+response.data.ad.weight+'<a data-toggle="modal" data-target="#myModal2" onclick="showEditAd('+response.data.ad.id+')" class="btn btn-default btn-xs pull-right"><i class="fa fa-edit"></i></a><a href="javascript:destroy('+response.data.ad.id+')" class="btn btn-default btn-xs pull-right"><i class="fa fa-trash-o"></i></a></span></div></li>';
            $("#adContent_"+response.data.ad.location).append(html);
        },  
        error : function() {
            alert("异常！");  
        }  
    });
}

function destroy(id)
{
    var api = '/admin/ad/ad/'+id;
    $.ajax( {  
        url:api,// 跳转到 action  
        data:{},  
        type:'delete',  
        dataType:'json',  
        success:function(response) {  
            alert('删除成功!');
            $("#"+id).remove();
        },  
        error : function() {  
           alert("异常！");  
        }  
    });
}



