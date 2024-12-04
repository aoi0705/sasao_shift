<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class userController extends Controller
{
    //
    public function user_menu_show(){
        session_start();

        return view('user_menu');
    }

    public function user_config_show(){
        session_start();

        $article = DB::table('users')->find(Auth::id());

        return view('user_config',compact('article'));
    }

    public function user_config_modify(Request $request){
        session_start();

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
        ->where('id', Auth::user()->id) // 条件が必要な場合はwhere()など指定可能
        ->update($param);

        session_destroy();

        return view('user_menu');
    }

    public function paid_holiday(){
        session_start();

        $users = DB::table('users')->get()->toArray();
        $add_date = date("Y-m-d", strtotime("15 day"));
        return view('paid_holiday',compact('users','add_date'));
    }
    public function holiday(Request $request){
        session_start();

        $param = [
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'date' => $_POST['date'],
            'counselor' => $_POST['counselor'],
            'state' => '未承認',
            'created_at' => date("Y-m-d H:i:s"),
        ];

        DB::table('holiday')->insert($param);

        return view('user_menu');
    }

    public function file_send(){
        session_start();

        return view('file_send');
    }
    public function file_join(Request $request){
        session_start();

        $file_place = storage_path('app/public') . "/{$_POST['name']}"; //結合するファイル場所

        $file = $_FILES['file'];
        file_put_contents($file_place, file_get_contents($file['tmp_name']), FILE_APPEND); //FILE_APPENDで足していく

        echo json_encode(['size' => filesize($file_place)]); //結果を出力

        if($_POST['flg']=='true'){
            $_SESSION['filename'.strval($_POST['count'])] = "/storage/{$_POST['name']}";
        }

        return;
    }
    public function file_db(){
        session_start();

        $file_arr = array();

        for($i=1;$i<=100;$i++){
            if(!isset($_SESSION['filename'.strval($i)])){
                break;
            }

            $file_arr['file'.$i] = $_SESSION['filename'.strval($i)];
        }

        $file_json = json_encode($file_arr);

        $param = [
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'file_path' => $file_json,
            'title' => $_POST['title'],
            'created_at' => date("Y-m-d H:i:s"),
        ];

        DB::table('file')->insert($param);

        session_destroy();

        return;
    }

    public function send(Request $request){
        session_start();

        $file_arr = array();

        for($i=1;$i<=100;$i++){
            if(!isset($_SESSION['filename'.strval($i)])){
                break;
            }

            $file_arr['file'.$i] = $_SESSION['filename'.strval($i)];
        }

        $param = [
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'file_name' => json_encode($file_arr),
            'title' => $_POST['title'],
            'created_at' => date("Y-m-d H:i:s"),
        ];

        DB::table('file')->insert($param);

        return view('user_menu');
    }

    public function received_file(){
        session_start();

        $articles = DB::table('file')->get()->toArray();

        return view('received_file',compact('articles'));
    }
    public function download($id){
        session_start();

        $article = DB::table('file')->find($id);

        $file_arr = json_decode($article->file_path,true);

        $zip = new \ZipArchive();
        $zip_name = storage_path('app/public') . "/{$article->title}.zip"; //zipファイル名
        $zip->open($zip_name, \ZipArchive::CREATE);

        foreach($file_arr as $key => $value){
            $zip->addFile(storage_path('app/public') . $value, basename($value));
        }

        $zip->close();

        header('Content-Type: application/zip');
        header('Content-Length: '.filesize($zip_name));
        header('Content-Disposition: attachment; filename="'.$article->title.'.zip"');
        readfile($zip_name);

        unlink($zip_name);

        return;
    }
}
