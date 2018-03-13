@extends('layouts/admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 配置项管理
    </div>
    <!--面包屑配置项 结束-->

	<!--结果集标题与配置项组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>修改配置项
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
                <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
                <a href="{{url('admin/config/create')}}"><i class="fa fa-refresh"></i>刷新</a>
            </div>
        </div>
    </div>
    <!--结果集标题与配置项组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/config/'.$field->conf_id)}}" method="post">
            {{method_field('put')}}
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" name="conf_title" value="{{$field->conf_title}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" name="conf_name" value="{{$field->conf_name}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>类型：</th>
                        <td>
                            <input type="radio" name="field_type" onclick="checkType()" value="input" @if($field->field_type=='input') checked @endif>input&nbsp;
                            <input type="radio" name="field_type" onclick="checkType()" value="textarea" @if($field->field_type=='textarea') checked @endif>textarea&nbsp;
                            <input type="radio" name="field_type" onclick="checkType()" value="radio" @if($field->field_type=='radio') checked @endif>radio&nbsp;
                            {{--<input type="text" class="sm" name="field_type" >--}}
                            <span><i class="fa fa-exclamation-circle yellow"></i>类型: input textarea radio</span>
                        </td>
                    </tr>
                    <tr class="radioType" style="display: none">
                        <th>类型值：</th>
                        <td>

                            <input type="text" class="lg" name="field_value"  value="{{$field->field_value}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>类型值只有在radio下才需要配置 格式(开启:1，关闭:0) </span>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="conf_order" value="{{$field->conf_order}}" >
                        </td>
                    </tr>
                    <tr>
                        <th>说明：</th>
                        <td>
                            <textarea id="" cols="30" rows="10" name="conf_tips">{{$field->conf_tips}}</textarea>
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
    <script>
        checkType();
        function checkType(obj){
            var type = $('input[name=field_type]:checked').val();
            if(type == 'radio'){
                $('.radioType').show();
            }else{
                $('.radioType').hide();
            }

        }
    </script>
@endsection