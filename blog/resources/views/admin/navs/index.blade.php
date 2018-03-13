@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 导航管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>全部导航
                    @if(count($errors)>0)
                        @foreach($errors->all() as $error)
                            <font style="color: red">{{$error}}</font>
                        @endforeach
                    @endif
                    @if(session('error'))
                        <font style="color: red">{{session('error')}}</font>
                    @endif
                </h3>
            </div>

            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>新增导航</a>
                    <a href="{{url('admin/navs')}}"><i class="fa fa-refresh"></i>刷新</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>导航名称</th>
                        <th>导航别名</th>
                        <th>导航地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" onchange="changeOrder(this,{{$v->nav_id}})" name="ord[]" value="{{$v->nav_order}}">
                            </td>
                            <td class="tc">{{$v->nav_id}}</td>
                            <td>
                                <a href="#">{{$v->nav_name}}</a>
                            </td>
                            <td>{{$v->nav_alias}}</td>
                            <td>{{$v->nav_url}}</td>

                            <td>
                                <a href="{{url('admin/navs/'.$v->nav_id.'/edit')}}">修改</a>
                                <a href="javascript::" onclick="delLink({{$v->nav_id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        //实时排序
        function changeOrder(obj,nav_id){
            var nav_order = $(obj).val();
            nav_order = parseInt(nav_order);

            if(nav_order>100 || nav_order<0){
                layer.msg('请输入0-100范围数字', {icon: 5});
                setTimeout(function(){
                    window.location.href="{{url('admin/navs')}}"
                } ,500);
            }else{
                $.post('{{url('admin/navs/changeorder')}}',{"_token":"{{csrf_token()}}",nav_id:nav_id,nav_order:nav_order},function(data){
                    if(data.status==0){
                        layer.msg(data.msg, {icon: 6});
                        setTimeout(function(){
                            window.location.href="{{url('admin/navs')}}"
                        } ,500);
                    }else{
                        layer.msg(data.msg, {icon: 5});
                        setTimeout(function(){
                            window.location.href="{{url('admin/navs')}}"
                        } ,500);
                    }
                });
            }
        }
        function delLink(nav_id){
            layer.confirm('您确定要删除这个导航吗',{
                btn:['确定','取消']
            },function(){
                $.post("{{url('admin/navs/')}}/"+nav_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
                    if(data.status==0){
                        layer.msg(data.msg,{icon:6});
                        setTimeout(function(){
                            window.location.href="{{url('admin/navs')}}"
                        } ,500);
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }
                });
            });
        }
    </script>

@endsection