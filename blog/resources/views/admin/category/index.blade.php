@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 文章分类
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>全部分类
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
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分类</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-refresh"></i>刷新</a>
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
                        <th>分类名称</th>
                        <th>标题</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" onchange="changeOrder(this,{{$v->cate_id}})" name="ord[]" value="{{$v->cate_order}}">
                            </td>
                            <td class="tc">{{$v->cate_id}}</td>
                            <td>
                                <a href="#">{{$v->_cate_name}}</a>
                            </td>
                            <td>{{$v->cate_title}}</td>
                            <td>{{$v->cate_view}}</td>

                            <td>
                                <a href="{{url('admin/category/'.$v->cate_id.'/edit')}}">修改</a>
                                <a href="javascript::" onclick="delCate({{$v->cate_id}})">删除</a>
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
        function changeOrder(obj,cate_id){
            var cate_order = $(obj).val();
            cate_order = parseInt(cate_order);

            if(cate_order>100 || cate_order<0){
                layer.msg('请输入0-100范围数字', {icon: 5});
                setTimeout(function(){
                    window.location.href="{{url('admin/category')}}"
                } ,500);
            }else{
                $.post('{{url('admin/cate/changeorder')}}',{"_token":"{{csrf_token()}}",cate_id:cate_id,cate_order:cate_order},function(data){
                    if(data.status==0){
                        layer.msg(data.msg, {icon: 6});
                        setTimeout(function(){
                            window.location.href="{{url('admin/category')}}"
                        } ,500);
                    }else{
                        layer.msg(data.msg, {icon: 5});
                        setTimeout(function(){
                            window.location.href="{{url('admin/category')}}"
                        } ,500);
                    }
                });
            }

        }
        function delCate(cate_id){
            layer.confirm('您确定要删除这个分类吗',{
                btn:['确定','取消']
            },function(){
                $.post("{{url('admin/category/')}}/"+cate_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
                    if(data.status==0){
                        layer.msg(data.msg,{icon:6});
                        setTimeout(function(){
                            window.location.href="{{url('admin/category')}}"
                        } ,500);
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }

                });
            });
        }
    </script>

@endsection