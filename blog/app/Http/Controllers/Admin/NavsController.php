<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends CommonController
{
    //get.admin/Navs   全部自定义导航列表
    public function index()
    {
        $data = Navs::orderBy('nav_order','asc')->get();
        return view('admin.navs.index',compact('data'));
    }

    //分类排序
    public function changeOrder()
    {
        $input = Input::all();
        $nav =  Navs::find($input['nav_id']);
        $nav->nav_order = $input['nav_order'];
        $res = $nav->update();
        if($res){
            $data = [
                'status' => 0,
                'msg' => '自定义导航排序更新成功!',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '自定义导航排序更新失败,请稍后重试!',
            ];
        }
        return $data;
    }

    //get.admin/navs/create 添加自定义导航展示
    public function create()
    {
        return view('admin/navs/add');
    }

    //post.admin/navs  添加分类
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'nav_name'=>'required',
            'nav_url'=>'required',

        ];
        $message = [
            'nav_name.required'=>'导航名称不能为空!',
            'nav_url.required'=>'Url不能为空!',

        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = Navs::create($input);
            if($res){
                return redirect('admin/navs');
            }else{
                return back()->with('error','数据填充失败,请稍后重试');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/navs/{category}/edit   编辑自定义导航
    public function edit($nav_id)
    {
        $field = Navs::find($nav_id);
        return view('admin.navs.edit',compact('field'));
    }

    //put.admin/navs/{category}          更新自定义导航
    public function update($nav_id)
    {
        $input = Input::except('_token','_method');
        $res = Navs::where('nav_id',$nav_id)->update($input);
        if($res){
            return redirect('admin/navs');
        }else{
            return back()->with('error','数据填充失败,请稍后重试');
        }


    }

    //get.admin/navs/{category}  显示单个导航
    public function show()
    {

    }

    //delete.admin/navs/{category} 删除单个配置项
    public function destroy($nav_id)
    {
        $res = Navs::where('nav_id',$nav_id)->delete();
        if($res){
            $data = [
                'status'=>0,
                'msg'=>'导航删除成功!',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'导航删除失败!',
            ];
        }
        return $data;
    }
}
