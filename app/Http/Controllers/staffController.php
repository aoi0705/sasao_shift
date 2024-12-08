<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\staffMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class staffController extends Controller
{
    //
    public function entry_send(){
        session_start();

        $articles = DB::table('option')->find(1);

        return view('staff_entrysend',compact('articles'));
    }

    public function entry_show($id){
        session_start();

        $article = DB::table('users')->find($id);

        $_SESSION['id'] = $id;
        $_SESSION['email'] = $article->email;
        $_SESSION['stafftype'] = $article->stafftype;

        return view('staff_entry',compact('article'));
    }

    public function entry_mail(Request $request)
    {
        session_start();

        $_SESSION['email'] = $_POST['email'];
        $_SESSION['stafftype'] = $_POST['stafftype'];

        $param = [
			'name' => '',
            'password' => '@a@a@a@a@a@a',
            'email' => $_SESSION['email'],
            'stafftype' => $_SESSION['stafftype'],
			'furigana' => '',
			'sex' => '',
			'postnumber' => '',
			'address' => '',
			'train_route' => '',
			'station' => '',
			'mynumber' => '',
            'dependent' => '',
            'dependent_income' => '',
            'dependent_name' => '',
            'dependent_furigana' => '',
            'dependent_sex' => '', 
		];

		$staff = DB::table('users')->insertGetId($param);
        $_SESSION['staff_id'] = $staff;

        Mail::send(new staffMail());

        return view('send_complete');
    }

    public function staff_entry_confirm(Request $request)
    {
        session_start();

        $_SESSION['id'] = $_POST['id'];
        $_SESSION['field_cnt'] = $_POST['field_cnt'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['stafftype'] = $_POST['stafftype'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['furigana'] = $_POST['furigana'];
        $_SESSION['sex'] = $_POST['sex'];
        $_SESSION['postnumber'] = $_POST['postnumber'];
        $_SESSION['address'] = $_POST['address'];
        $_SESSION['train_route'] = $_POST['train_route'];
        $_SESSION['station'] = $_POST['station'];
        $_SESSION['mynumber'] = $_POST['mynumber'];
        $_SESSION['dependent'] = $_POST['dependent'];
        if($_POST['dependent'] == "有"){
            for($i=1;$i<=$_POST['field_cnt'];$i++){
                $_SESSION['dependent_income'.$i] = $_POST['dependent_income'.$i];
                $_SESSION['dependent_name'.$i] = $_POST['dependent_name'.$i];
                $_SESSION['dependent_furigana'.$i] = $_POST['dependent_furigana'.$i];
                $_SESSION['dependent_sex'.$i] = $_POST['dependent_sex'.$i];
            }
        }

        //Mail::send(new staffMail());

        return view('staff_entryconfirm');
    }

    public function staff_entry_now(Request $request)
    {
        session_start();

        $param = [
			'name' => $_SESSION['name'],
			'furigana' => $_SESSION['furigana'],
			'sex' => $_SESSION['sex'],
			'postnumber' => $_SESSION['postnumber'],
			'address' => $_SESSION['address'],
			'train_route' => $_SESSION['train_route'],
			'station' => $_SESSION['station'],
			'mynumber' => $_SESSION['mynumber'],
            'dependent' => $_SESSION['dependent'],
            'password' => Hash::make($_SESSION['password']),
		];

        if($_SESSION['dependent'] == "有"){
            $income_arr = array();
            $name_arr = array();
            $furigana_arr = array();
            $sex_arr = array();

            for($i=1;$i<=$_SESSION['field_cnt'];$i++){
                $income_arr['dependent_income'.$i] = $_SESSION['dependent_income'.$i];
                $name_arr['dependent_name'.$i] = $_SESSION['dependent_name'.$i];
                $furigana_arr['dependent_furigana'.$i] = $_SESSION['dependent_furigana'.$i];
                $sex_arr['dependent_sex'.$i] = $_SESSION['dependent_sex'.$i];
            }

            $income_json = json_encode($income_arr);
            $name_json = json_encode($name_arr);
            $furigana_json = json_encode($furigana_arr);
            $sex_json = json_encode($sex_arr);
        }
        else{
            $income_json = '{}';
            $name_json = '{}';
            $furigana_json = '{}';
            $sex_json = '{}';
        }

        $param['dependent_income'] = $income_json;
        $param['dependent_name'] = $name_json;
        $param['dependent_furigana'] = $furigana_json;
        $param['dependent_sex'] = $sex_json;

		//$users = DB::table('stafflist')->insert($param);
        DB::table('users')
        ->where('id', $_SESSION['id']) // 条件が必要な場合はwhere()など指定可能
        ->update($param);

        session_destroy();

        return view('staffentry_complete');
    }

    public function staff_listshow(){
        session_start();

        $articles = DB::table('users')->where('role','user')->get()->toArray();

        return view('staff_list', compact('articles'));
    }
    public function staff_detail($id){
        session_start();

        $article = DB::table('users')->find($id);

        return view('staff_detail', compact('article'));
    }

    public function staff_delete(Request $request){
        session_start();

        if($_POST['admin_password_delete'] == "admin"){
            DB::table('users')->where('id', $_POST['id'])->delete();
            $articles = DB::table('users')->get()->toArray();
            return view('staff_list', compact('articles'));
        }
        else{
            return redirect()->back()->with('alert', '管理者パスワードが違います');
        }
    }
    public function staff_edit(Request $request){
        session_start();

        if($_POST['admin_password_modify'] == "admin"){
            $param = [
                'name' => $_POST['name'],
                'furigana' => $_POST['furigana'],
                'sex' => $_POST['sex'],
                'postnumber' => $_POST['postnumber'],
                'address' => $_POST['address'],
                'train_route' => $_POST['train_route'],
                'station' => $_POST['station'],
                'mynumber' => $_POST['mynumber'],
                'dependent' => $_POST['dependent'],
            ];

            if($_POST['dependent'] == "有"){
                $income_arr = array();
                $name_arr = array();
                $furigana_arr = array();
                $sex_arr = array();

                for($i=1;$i<=$_POST['field_cnt'];$i++){
                    $income_arr['dependent_income'.$i] = $_POST['dependent_income'.$i];
                    $name_arr['dependent_name'.$i] = $_POST['dependent_name'.$i];
                    $furigana_arr['dependent_furigana'.$i] = $_POST['dependent_furigana'.$i];
                    $sex_arr['dependent_sex'.$i] = $_POST['dependent_sex'.$i];
                }

                $income_json = json_encode($income_arr);
                $name_json = json_encode($name_arr);
                $furigana_json = json_encode($furigana_arr);
                $sex_json = json_encode($sex_arr);
            }
            else{
                $income_json = '{}';
                $name_json = '{}';
                $furigana_json = '{}';
                $sex_json = '{}';
            }

            $param['dependent_income'] = $income_json;
            $param['dependent_name'] = $name_json;
            $param['dependent_furigana'] = $furigana_json;
            $param['dependent_sex'] = $sex_json;

            //$users = DB::table('stafflist')->insert($param);
            DB::table('users')
            ->where('id', $_POST['id']) // 条件が必要な場合はwhere()など指定可能
            ->update($param);

            session_destroy();

            $articles = DB::table('users')->get()->toArray();

            return view('staff_list', compact('articles'));
        }
        else{
            return redirect()->back()->with('alert', '管理者パスワードが違います');
        }
    }
}
