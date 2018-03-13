<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

require_once '/resources/org/code/Code.class.php';


class LoginController extends CommonController
{
    public function login()
    {
        if($input = Input::all()){

            $code = new \Code;
            $_code = $code->getcode();

            if(strtoupper($input['code'])!=$_code){
                return back()->with('msg','验证码错误!');
            }
            $user = User::first();

            if($user->user==$input['user_name'] && Crypt::decrypt($user->password)==$input['user_pass']){
                session(['user'=>$user]);
                return redirect('admin');
            }else{
                return back()->with('msg','账号或者密码错误!');
            }
        }else{
            return view('admin.login');
        }
    }

    public function code()
    {
        $code = new \Code;
        $code->make();
    }

    public function quit()
    {
        $_SESSION['user'] = null;
        return redirect('admin/login');
    }


}
