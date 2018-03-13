@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 友情链接
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>全部链接
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
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>新增链接</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-refresh"></i>刷新</a>
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
                        <th>链接名称</th>
                        <th>链接标题</th>
                        <th>链接地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" onchange="changeOrder(this,{{$v->link_id}})" name="ord[]" value="{{$v->link_order}}">
                            </td>
                            <td class="tc">{{$v->link_id}}</td>
                            <td>
                                <a href="#">{{$v->link_name}}</a>
                            </td>
                            <td>{{$v->link_title}}</td>
                            <td>{{$v->link_url}}</td>

                            <td>
                                <a href="{{url('admin/links/'.$v->link_id.'/edit')}}">修改</a>
                                <a href="javascript::" onclick="delLink({{$v->link_id}})">删除</a>
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
        function changeOrder(obj,link_id){
            var link_order = $(obj).val();
            link_order = parseInt(link_order);

            if(link_order>100 || link_order<0){
                layer.msg('请输入0-100范围数字', {icon: 5});
                setTimeout(function(){
                    window.location.href="{{url('admin/links')}}"
                } ,500);
            }else{
                $.post('{{url('admin/links/changeorder')}}',{"_token":"{{csrf_token()}}",link_id:link_id,link_order:link_order},function(data){

                    if(data.status==0){
                        layer.msg(data.msg, {icon: 6});
                        setTimeout(function(){
                            window.location.href="{{url('admin/links')}}"
                        } ,500);
                    }else{
                        layer.msg(data.msg, {icon: 5});
                        setTimeout(function(){
                            window.location.href="{{url('admin/links')}}"
                        } ,500);
                    }
                });
            }

        }
        function delLink(link_id){
            layer.confirm('您确定要删除这个链接吗',{
                btn:['确定','取消']
            },function(){
                $.post("{{url('admin/links/')}}/"+link_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
                    if(data.status==0){
                        layer.msg(data.msg,{icon:6});
                        setTimeout(function(){
                            window.location.href="{{url('admin/links')}}"
                        } ,500);
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }
                });
            });
        }
    </script>

@endsection