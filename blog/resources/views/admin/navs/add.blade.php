@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 自定义导航管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加自定义导航
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
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>全部导航</a>
                <a href="{{url('admin/navs/create')}}"><i class="fa fa-refresh"></i>刷新</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/navs')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>导航名称：</th>
                        <td>
                            <input type="text" name="nav_name">
                            <input type="text" class="sm" name="nav_alias">
                            <span><i class="fa fa-exclamation-circle yellow"></i>导航名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Url：</th>
                        <td>
                            <input type="text" class="lg" name="nav_url" value="http://">
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="nav_order" value="0">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection