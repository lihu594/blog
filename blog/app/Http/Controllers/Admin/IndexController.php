<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    public function index()
    {
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');
    }

    public function pass()
    {
        if($input = Input::all()){
            $rules = [
                'password'=>'required|between:6,20|confirmed',
            ];
            $message = [
                'password.required'=>'新密码不能为空!',
                'password.between'=>'新密码必须在6-20位之间!',
                'password.confirmed'=>'两次密码输入不一致!',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $user = User::first();
                $_pass = decrypt($user->password);

                if($_pass==$input['password_o']){
                    $user->password =  Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('error','密码修改成功!');
                }else{
                    return back()->with('error','原密码错误!');
                }

            }else{
                return back()->withErrors($validator);
            }

        }else{
            return view('admin.pass');
        }
    }
}
