<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController
{
    //get.admin/links   全部友情链接列表
    public function index()
    {
        $data = Links::orderBy('link_order','asc')->get();
        return view('admin.links.index',compact('data'));
    }

    //分类排序
    public function changeOrder()
    {
        $input = Input::all();
        $link =  Links::find($input['link_id']);
        $link->link_order = $input['link_order'];
        $res = $link->update();
        if($res){
            $data = [
                'status' => 0,
                'msg' => '友情链接排序更新成功!',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接排序更新失败,请稍后重试!',
            ];
        }
        return $data;
    }

    //get.admin/links/create 添加友情链接展示
    public function create()
    {
        return view('admin/links/add');
    }

    //post.admin/links  添加分类
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'link_name'=>'required',
            'link_url'=>'required',

        ];
        $message = [
            'link_name.required'=>'链接名称不能为空!',
            'link_url.required'=>'Url不能为空!',

        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = Links::create($input);
            if($res){
                return redirect('admin/links');
            }else{
                return back()->with('error','数据填充失败,请稍后重试');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/links/{category}/edit   编辑友情链接
    public function edit($link_id)
    {
        $field = Links::find($link_id);
        return view('admin.links.edit',compact('field'));
    }

    //put.admin/links/{category}          更新友情链接
    public function update($link_id)
    {
        $input = Input::except('_token','_method');
        $res = Links::where('link_id',$link_id)->update($input);
        if($res){
            return redirect('admin/links');
        }else{
            return back()->with('error','数据填充失败,请稍后重试');
        }


    }

    //get.admin/links/{category}  显示单个链接
    public function show()
    {

    }

    //delete.admin/category/{category} 删除单个分类
    public function destroy($link_id)
    {
        $res = Links::where('link_id',$link_id)->delete();
        if($res){
            $data = [
                'status'=>0,
                'msg'=>'链接删除成功!',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'链接删除失败!',
            ];
        }
        return $data;
    }
}
