@extends('admin.public.header')
@section('title',$title)
@section('listcontent')
    <style>
        .temp-info{
            border: 1px solid silver;
            border-radius: 4px;
            margin-bottom: 15px;
            padding-top: 10px;
            position: relative;
        }

        .temp-info .temp-info-title{
            position: absolute;
            top: -11px;
            width: calc(100% - 20px);;
            height: 24px;
            line-height: 24px;
            background: #fff;
            left: 10px;
        }

        .temp-info .layui-form-item{
            margin-top: 15px;
        }
    </style>
    <div class="layui-form layuimini-form">
        @foreach($list as $item)
            @if(!empty($item["data"]))
                <div class="temp-info">
                    <div class="temp-info-title">{{$item["title"]}}</div>
                    @foreach($item["data"] as $info)
                    <div class="layui-form-item">
                        <label class="layui-form-label" style="min-width:100px; width: auto">{{$info["title"]}}</label>
                        <div class="layui-input-block">
                            <input type="text" name="{{$info['code']}}" placeholder="请输入模版 ID ..." value="{{$info['value'] ?? ''}}" class="layui-input" />
                            @if($info['remark'] != '')<div style="font-size: 12px; color: #636c72;">{{$info['remark']}}</div>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        @endforeach

        <div class="hr-line"></div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" id="saveBtn" lay-submit lay-filter="saveBtn">保存</button>
            </div>
        </div>

    </div>
@endsection

@section('listscript')
    <script type="text/javascript">
        layui.use(['iconPickerFa', 'form', 'layer', 'upload'], function () {
            var iconPickerFa = layui.iconPickerFa,
                form = layui.form,
                layer = layui.layer,
                upload = layui.upload,
                $ = layui.$;

            //拖拽上传
            upload.render({
                elem: '#upload1'
                ,url: '/admin/upload/upload' //改成您自己的上传接口
                ,accept: 'images'
                ,acceptMime: 'image/*'
                ,size: 800 //限制文件大小，单位 KB
                ,headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                ,done: function(res){
                    if(res.code==0){
                        layer.msg("上传成功",{icon: 1});
                        layui.$('#uploadShowImg').removeClass('layui-hide').find('img').attr('src', domain + "/" + res.data[0]);
                        $("input[name='pic']").val(res.data[0]);
                    }else{
                        layer.msg(res.message,{icon: 2});
                        layui.$('#uploadShowImg').addClass('layui-hide');
                        $("input[name='pic']").val('');
                    }
                }
            });

            //监听提交
            form.on('submit(saveBtn)', function(data){
                $("#saveBtn").addClass("layui-btn-disabled");
                $("#saveBtn").attr('disabled', 'disabled');
                $.ajax({
                    url:'/admin/wechat_applet/template',
                    type:'post',
                    data:data.field,
                    dataType:'JSON',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success:function(res){
                        if(res.code==0){
                            layer.msg(res.message,{icon: 1});
                            $("#saveBtn").removeClass("layui-btn-disabled");
                            $("#saveBtn").removeAttr('disabled');
                        }else{
                            layer.msg(res.message,{icon: 2},function (){
                                window.location.reload();
                            });
                        }
                    },
                    error:function (data) {
                        layer.msg(res.message,{icon: 2},function (){
                            window.location.reload();
                        });
                    }
                });
            });
        });
    </script>
@endsection