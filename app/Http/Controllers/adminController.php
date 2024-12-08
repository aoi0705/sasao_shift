<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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



    public function show(){
        session_start();

        $_SESSION = [];

        return view('admin_entry');
    }
    public function admin_entryconfirm(Request $request)
    {
        session_start();

        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['name'] = $_POST['name'];

        return view('admin_entryconfirm');
    }

    public function admin_entrynow(Request $request)
    {
        session_start();

        $param = [
			'name' => $_SESSION['name'],
            'stafftype' => 'admin',
            'furigana' => '',
            'sex' => '',
            'postnumber' => '',
            'address' => '',
            'train_route' => '',
            'station' => '',
            'mynumber' => '',
            'dependent' => '',
            'password' => Hash::make($_SESSION['password']),
            'email' => $_SESSION['email'],
            'role' => 'admin',
            'created_at' => now(),
		];

        DB::table('users')->insert($param);
        
        // セッション変数をクリア
        $_SESSION = [];

        // セッションを破棄
        if (session_id() != "" || isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        session_destroy(); // セッションを破棄

        return view('staffentry_complete');
    }

    public function setting_stafftype_show(){
        session_start();

        $article = DB::table('option')->find(1);

        return view('setting_stafftype',compact('article'));
    }
    public function setting_stafftype(Request $request){
        session_start();

        $arr = array();
        for($i=1;$i<=100;$i++){
            if(!isset($_POST['type_name'.$i])){
                break;
            }

            $arr[$_POST['type_name'.$i]] = $_POST['wage'.$i];
        }

        $param = [
            'stafftype_list' => json_encode($arr)
        ];

        if(DB::table('option')->where('id', 1)->doesntExist()){
            $option = DB::table('option')->insert($param);
        }
        else{
            $option = DB::table('option')->where('id', 1)->update($param);
        }

        return redirect()->route('admin_config_show');
    }

    public function back(){
        session_start();

        return redirect()->route('admin_entryshow');
    }
}
