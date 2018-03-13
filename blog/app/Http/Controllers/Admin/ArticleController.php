<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use Illuminate\Http\Request;
use App\Http\Model\Category;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //get.admin/article   全部分类列表
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(10);
        return view('admin.article.index',compact('data'));
    }

    //get.admin/article/create 添加文章展示
    public function create()
    {
        $gory = new Category();
        $cateorys =$gory->orderBy('cate_order','asc')->get();
        $data = $gory->getTree($cateorys);

        return view('admin.article.add',compact('data'));
    }

    //post.admin/article  添加文章
    public function store()
    {
        $input = Input::except('_token');
        $input['art_time'] = time();

        $rules = [
            'art_title'=>'required',
            'art_editor'=>'required',
            'art_content'=>'required',
        ];
        $message = [
            'art_title.required'=>'请填写文章标题',
            'art_editor.required'=>'请填写文章作者',
            'art_content.required'=>'请输入文章类容',
        ];
        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = Article::create($input);
            if($res){
                return redirect('admin/article');
            }else{
                return back()->with('error','数据填充失败,请稍后重试');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    //get.admin/article/{category}/edit   编辑文章
    public function edit($art_id)
    {
        $gory = new Category();
        $cateorys =$gory->orderBy('cate_order','asc')->get();
        $data = $gory->getTree($cateorys);
        $field = Article::find($art_id);
        return view('admin.article.edit',compact('data','field'));
    }

    //put.admin/article/{category}       更新文章
    public function update($art_id)
    {
        $input = Input::except('_token','_method');
        $res = Article::where('art_id',$art_id)->update($input);
        if($res){
            return redirect('admin/article');
        }else{
            return back()->with('error','文章更新失败,请稍后重试');
        }
    }

    //delete.admin/article/{article}  删除单个文章
    public function destroy($art_id)
    {
        $res = Article::where('art_id',$art_id)->delete();
        if($res){
            $data = [
                'status'=>0,
                'msg'=>'文章删除成功!',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'文章删除失败!',
            ];
        }
        return $data;
    }


}
