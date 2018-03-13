<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    //get.admin/Config   全部配置项列表
    public function index()
    {
        $data = Config::orderBy('conf_order','asc')->get();

        foreach ($data as $k=>$v) {
            switch ($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'" />';
                    break;

                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" class="lg" name="conf_content[]" >'.$v->conf_content.'</textarea>';
                    break;

                case 'radio':
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    foreach ($arr as $m=>$n){
                        $r = explode('|',$n);
                        $c = $v->conf_content==$r[0]? 'checked':'';
                        $str .= '<input type="radio" name="conf_content[]" value="'.$r[0].'" '.$c.'>'.$r[1].'　';
                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }


        return view('admin.config.index',compact('data'));
    }

    //配置项更新
    public function changeContent()
    {
        $input = Input::all();
        foreach ($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('info','配置项更新成功');
    }

    //配置项写入文件
    public function putFile()
    {
        $config = Config::pluck('conf_content','conf_name')->all();



        $path = base_path().'\config\web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);

    }

    //分类排序
    public function changeOrder()
    {
        $input = Input::all();
        $conf =  Config::find($input['conf_id']);
        $conf->conf_order = $input['conf_order'];
        $res = $conf->update();
        if($res){
            $data = [
                'status' => 0,
                'msg' => '配置项排序更新成功!',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置项排序更新失败,请稍后重试!',
            ];
        }
        return $data;
    }

    //get.admin/config/create 添加配置项展示
    public function create()
    {
        return view('admin/config/add');
    }

    //post.admin/config  添加分类
    public function store()
    {

        $input = Input::except('_token');

        $rules = [
            'conf_name'=>'required',
            'conf_title'=>'required',
        ];
        $message = [
            'conf_name.required'=>'配置项名称不能为空!',
            'conf_title.required'=>'配置项标题不能为空!',

        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = Config::create($input);
            if($res){
                return redirect('admin/config');
            }else{
                return back()->with('error','数据填充失败,请稍后重试');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/config/{category}/edit   编辑配置项
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);
        return view('admin.config.edit',compact('field'));
    }

    //put.admin/config/{category}          更新配置项
    public function update($conf_id)
    {
        $input = Input::except('_token','_method');
        $res = Config::where('conf_id',$conf_id)->update($input);
        if($res){
            $this->putFile();
            return redirect('admin/config');
        }else{
            return back()->with('error','数据填充失败,请稍后重试');
        }


    }

    //get.admin/config/{category}  显示单个配置项
    public function show()
    {

    }

    //delete.admin/config/{category} 删除单个配置项
    public function destroy($conf_id)
    {
        $res = Config::where('conf_id',$conf_id)->delete();
        if($res){
            $data = [
                'status'=>0,
                'msg'=>'配置项删除成功!',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'配置项删除失败!',
            ];
        }
        return $data;
    }
}
