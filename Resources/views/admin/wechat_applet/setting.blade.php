@extends('admin.public.header')
@section('title',$title)
@section('listcontent')
    <div class="layui-form layuimini-form">

        @foreach($list as $i => $item)
            <div class="layui-form-item">
                <label class="layui-form-label" style="min-width:100px; width: auto">{{$item->title}}</label>
                <div class="layui-input-block" style="margin-left: 210px;">
                    <input type="hidden" name="data[{{$i}}][code]" value="{{$item->code}}">
                    @if($item->code == "cert_pem" || $item->code == "key_pem")
                    <textarea name="data[{{$i}}][value]" placeholder="请输入{{$item->title}}" class="layui-textarea">{{$item->value ?? ''}}</textarea>
                    @else
                    <input type="text" name="data[{{$i}}][value]" placeholder="请输入{{$item->title}}" value="{{$item->value ?? ''}}" class="layui-input" />
                    @endif
                    @if($item->remark != "")
                    <div style="font-size: 12px; color: #636c72;">{{$item->remark}}</div>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="hr-line"></div>

        <div class="layui-form-item">
            <div class="layui-input-block" style="margin-left: 210px;">
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
                    url:'/admin/wechat_applet/setting',
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