<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{
    //
    public function admin_config_show(){
        session_start();

        $article = DB::table('users')->where('role', 'admin')->get()->toArray();

        return view('admin_config',compact('article'));
    }

    public function paid_holiday_list(){
        session_start();

        $articles = DB::table('holiday')->get()->toArray();

        return view('paid_holiday_list',compact('articles'));
    }
    public function holiday_approval($id){
        session_start();

        $param= [
            'state' => '承認済'
        ];

        $paid_holiday = DB::table('holiday')->where('id', $id)->update($param);

        return redirect()->route('paid_holiday_list');
    }
    public function holiday_denial($id){
        session_start();

        $param= [
            'state' => '未承認'
        ];

        $paid_holiday = DB::table('holiday')->where('id', $id)->update($param);

        return redirect()->route('paid_holiday_list');
    }

    public function modify_adminpassword_show(){
        session_start();

        return view('modify_adminpassword');
    }
    public function modify_adminpassword(Request $request){
        session_start();

        $param= [
            'password' => Hash::make($request->password)
        ];

        $admin = DB::table('users')->where('role', 'admin')->update($param);

        return redirect()->route('admin_config_show');
    }
}
