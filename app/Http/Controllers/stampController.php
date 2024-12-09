<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class stampController extends Controller
{
    //
    public function stamp_show(){
        session_start();

        $article = DB::table('users')->find(Auth::id());
        if($article->stamp_state == '稼働中'){
            $stamp = DB::table('stamp')->find($article->stamp_id);

            return view('stamp_entry',compact('article','stamp'));
        }
        else{
            return view('stamp_entry',compact('article'));
        }
    }

    public function stamp_start(Request $request){
        session_start();

        $param = [
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'punch_in' => date('Y-m-d H:i:s'),
        ];

        $db_id = DB::table('stamp')->insertGetId($param);

        $state_param = [
            'stamp_state' => '稼働中',
            'stamp_id' => $db_id,
        ];
        $user = DB::table('users')->where('id', Auth::id())->update($state_param);

        return;
    }

    public function stamp_end(Request $request){
        session_start();

        $stamp_id = DB::table('users')->where('id',Auth::id())->value('stamp_id');

        //ループで実行される処理
        $param = [
            'punch_out' => date('Y-m-d H:i:s'),
        ];

        DB::table('stamp')
        ->where('id', $stamp_id) // 条件が必要な場合はwhere()など指定可能
        ->update($param);

        $state_param = [
            'stamp_state' => '未稼働',
            'stamp_id' => null,
        ];
        $user = DB::table('users')->where('id', Auth::id())->update($state_param);

        return;
    }

    public function attendance_confirmation(){
        session_start();

        $articles = DB::table('stamp')
        //->where('user_id', Auth::id())
        ->get()
        ->toArray();

        $holidays = DB::table('holiday')
        ->get()
        ->toArray();

        return view('attendance_confirmation', compact('articles','holidays'));
    }

    public function attendance_show(){
        session_start();

        $articles = DB::table('stamp')
        ->where('user_id', Auth::id())
        ->get()
        ->toArray();

        $holidays = DB::table('holiday')
        ->where('user_id', Auth::id())
        ->get()
        ->toArray();

        return view('attendance', compact('articles','holidays'));
    }

    public function attendance_modify(){
        session_start();

        $articles = DB::table('stamp')
        ->where('user_id', Auth::id())
        ->get()
        ->toArray();

        return view('attendance_modify', compact('articles'));
    }

    public function attendance_modify_now(Request $request){
        session_start();

        for($i=1;$i<=31;$i++){
            if(!isset($_POST['punch_in'.$i])){
                break;
            }

            $param = [
                'punch_in' => $_POST['day'.$i] . ' ' . $_POST['punch_in'.$i],
                'punch_out' => $_POST['day'.$i] . ' ' . $_POST['punch_out'.$i],
            ];

            DB::table('stamp')
            ->where('id', $_POST['id'.$i]) // 条件が必要な場合はwhere()など指定可能
            ->update($param);
        }

        return redirect()->route('user_menu_show');
    }
}
