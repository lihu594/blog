@extends('layouts.admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 配置项
    </div>
    <!--面包屑配置项 结束-->

    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>全部配置项
                    @if(count($errors)>0)
                        @foreach($errors->all() as $error)
                            <font style="color: red">{{$error}}</font>
                        @endforeach
                    @endif
                    @if(session('error'))
                        <font style="color: red">{{session('error')}}</font>
                    @endif
                    @if(session('info'))
                        <font style="color: green">{{session('info')}}</font>
                    @endif
                </h3>
            </div>

            <!--快捷配置项 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>新增配置项</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-refresh"></i>刷新</a>
                </div>
            </div>
            <!--快捷配置项 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/config/changecontent')}}" method="post" >
                {{csrf_field()}}
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" onchange="changeOrder(this,{{$v->conf_id}})" name="ord[]" value="{{$v->conf_order}}">
                            </td>
                            <td class="tc">{{$v->conf_id}}</td>
                            <td>
                                <a href="#">{{$v->conf_title}}</a>
                            </td>
                            <td>{{$v->conf_name}}</td>
                            <td>
                                <input type="hidden" name="conf_id[]" value="{{$v->conf_id}}" >
                                {!! $v->_html !!}
                            </td>

                            <td>
                                <a href="{{url('admin/config/'.$v->conf_id.'/edit')}}">修改</a>
                                <a href="javascript::" onclick="delLink({{$v->conf_id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                    <div class="btn_group">
                        <input type="submit" value="提交" >
                        <input type="button" onclick="history.back(-1);" value="返回" >
                    </div>
                </form>
            </div>
        </div>
    <!--搜索结果页面 列表 结束-->
    <script>

        function changeContent(){


        }


        //实时排序
        function changeOrder(obj,conf_id){
            var conf_order = $(obj).val();
            conf_order = parseInt(conf_order);

            if(conf_order>100 || conf_order<0){
                layer.msg('请输入0-100范围数字', {icon: 5});
                setTimeout(function(){
                    window.location.href="{{url('admin/config')}}"
                } ,500);
            }else{
                $.post('{{url('admin/config/changeorder')}}',{"_token":"{{csrf_token()}}",conf_id:conf_id,conf_order:conf_order},function(data){
                    if(data.status==0){
                        layer.msg(data.msg, {icon: 6});
                        setTimeout(function(){
                            window.location.href="{{url('admin/config')}}"
                        } ,500);
                    }else{
                        layer.msg(data.msg, {icon: 5});
                        setTimeout(function(){
                            window.location.href="{{url('admin/config')}}"
                        } ,500);
                    }
                });
            }
        }
        function delLink(conf_id){
            layer.confirm('您确定要删除这个配置项吗',{
                btn:['确定','取消']
            },function(){
                $.post("{{url('admin/config/')}}/"+conf_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
                    if(data.status==0){
                        layer.msg(data.msg,{icon:6});
                        setTimeout(function(){
                            window.location.href="{{url('admin/config')}}"
                        } ,500);
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }
                });
            });
        }
    </script>

@endsection