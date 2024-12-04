<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Datetime;

class shiftController extends Controller
{
    //
    public function make_shift(){
        session_start();

        $users = DB::table('users')->get()->toArray();
        $shifts = DB::table('shift')->get()->toArray();

        return view('shift_entry',compact('users','shifts'));
    }

    public function shift_add(Request $request){
        session_start();

        $insert_arr = [];

        for($i=1;$i<=$_POST['field_cnt'];$i++){
            $start_arr = array();
            $end_arr = array();

            $user_id = $_POST['staffname'.$i];
            $user_name = DB::table('users')->where('id', $_POST['staffname'.$i])->value('name');
            $user_date = $_POST['date'.$i];
            $start_time = $_POST['start_time'.$i];
            $end_time = $_POST['end_time'.$i];

            $month = date('Y-m', strtotime($user_date));
            $start = date('Y-m-d', strtotime($user_date));
            $end = date('Y-m-d', strtotime($user_date));

            if(DB::table('shift')->where('staff_id', $user_id)->where('month', $month)->exists()){
                $start_json = DB::table('shift')->where('staff_id', $user_id)->where('month', $month)->value('start_time');
                $end_json = DB::table('shift')->where('staff_id', $user_id)->where('month', $month)->value('end_time');

                $start_arr = json_decode($start_json,true);
                $end_arr = json_decode($end_json,true);
                $start_arr[$start] = $start_time;
                $end_arr[$end] = $end_time;
                $start_json = json_encode($start_arr);
                $end_json = json_encode($end_arr);

                $param = [
                    'start_time' => $start_json,
                    'end_time' => $end_json,
                ];

                DB::table('shift')
                ->where('staff_id', $user_id)
                ->where('month', $month)
                ->update($param);

            }
            else{
                $start_arr[$start] = $start_time;
                $end_arr[$end] = $end_time;
                $start_json = json_encode($start_arr);
                $end_json = json_encode($end_arr);

                $param = [
                    'staff_id' => $user_id,
                    'staff_name' => $user_name,
                    'month' => $month,
                    'start_time' => $start_json,
                    'end_time' => $end_json,
                ];

                DB::table('shift')->insert($param);
            }
            
        }

        if(Auth::user()->role == 'admin'){
            $users = DB::table('users')->get()->toArray();
            $shifts = DB::table('shift')->get()->toArray();
            return view('shift_entry',compact('users','shifts'));
        }
        else{
            $users = DB::table('users')->get()->toArray();
            $shifts = DB::table('shift')->where('staff_id',Auth::id())->get()->toArray();
            return view('shift',compact('users','shifts'));
        }
        

    }

    public function shift(){
        session_start();

        $shifts = DB::table('shift')->where('staff_id',Auth::id())->get()->toArray();

        return view('shift',compact('shifts'));
    }

    public function modify(Request $request){
        session_start();

        $start = DB::table('shift')->where('staff_id',Auth::id())->where('month',$_POST['date'])->value('start_time');
        $end = DB::table('shift')->where('staff_id',Auth::id())->where('month',$_POST['date'])->value('end_time');
        $start_arr = json_decode($start,true);
        $end_arr = json_decode($end,true);

        $date_datetime = new DateTime($_POST['date']);
        $month_date = $date_datetime->format('Y-m');
        $start_datetime = new DateTime($_POST['full_date']);
        $start_date = $start_datetime->format('Y-m-d');

        $start_arr[$start_date] = $_POST['start_time'];
        $end_arr[$start_date] = $_POST['end_time'];

        $start_json = json_encode($start_arr);
        $end_json = json_encode($end_arr);

        $param = [
            'staff_id' => Auth::id(),
            'staff_name' => Auth::user()->name,
            'month' => $month_date,
            'start_time' => $start_json,
            'end_time' => $end_json,
        ];

        DB::table('shift')->where('staff_id',Auth::id())->where('month',$month_date)->update($param);

        return redirect()->route('shift');
    }
    public function delete(Request $request){
        session_start();

        $start = DB::table('shift')->where('staff_id',Auth::id())->where('month',$_POST['date'])->value('start_time');
        $end = DB::table('shift')->where('staff_id',Auth::id())->where('month',$_POST['date'])->value('end_time');
        $start_arr = json_decode($start,true);
        $end_arr = json_decode($end,true);

        $date_datetime = new DateTime($_POST['date']);
        $month_date = $date_datetime->format('Y-m');
        $start_datetime = new DateTime($_POST['full_date']);
        $start_date = $start_datetime->format('Y-m-d');

        unset($start_arr[$start_date]);
        unset($end_arr[$start_date]);

        $start_json = empty($start_arr) ? '{}' : json_encode($start_arr);
        $end_json = empty($end_arr) ? '{}' : json_encode($end_arr);

        $param = [
            'staff_id' => Auth::id(),
            'staff_name' => Auth::user()->name,
            'month' => $month_date,
            'start_time' => $start_json,
            'end_time' => $end_json,
        ];

        DB::table('shift')->where('staff_id',Auth::id())->where('month',$month_date)->update($param);

        return redirect()->route('shift');
    }
}
