<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('/', [App\Http\Controllers\staffController::class, 'entry_send'])->name('staff_entrysend');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //打刻関連
    Route::get('/stamp_entry', [App\Http\Controllers\stampController::class, 'stamp_show'])->name('stamp_entry');
    Route::post('/stamp_start', [App\Http\Controllers\stampController::class, 'stamp_start'])->name('stamp_start');
    Route::post('/stamp_end', [App\Http\Controllers\stampController::class, 'stamp_end'])->name('stamp_end');
    //勤怠関連
    Route::get('/attendance_confirmation', [App\Http\Controllers\stampController::class, 'attendance_confirmation'])->name('attendance_confirmation');
    Route::get('/attendance', [App\Http\Controllers\stampController::class, 'attendance_show'])->name('attendance_show');
    Route::get('/attendance_modify', [App\Http\Controllers\stampController::class, 'attendance_modify'])->name('attendance_modify');
    Route::post('/attendance_modify', [App\Http\Controllers\stampController::class, 'attendance_modify_now'])->name('attendance_modify_now');
    //以下シフト関連
    Route::get('/make_shift', [App\Http\Controllers\shiftController::class, 'make_shift'])->name('make_shift');
    Route::post('/shift_add', [App\Http\Controllers\shiftController::class, 'shift_add'])->name('shift_add');
    Route::get('/shift', [App\Http\Controllers\shiftController::class, 'shift'])->name('shift');
    Route::post('/shift_modify', [App\Http\Controllers\shiftController::class, 'modify'])->name('shift_modify');
    Route::post('/shift_delete', [App\Http\Controllers\shiftController::class, 'delete'])->name('shift_delete');
    //有給申請
    Route::get('/paid_holiday', [App\Http\Controllers\userController::class, 'paid_holiday'])->name('paid_holiday');
    Route::post('/paid_holiday', [App\Http\Controllers\userController::class, 'holiday'])->name('holiday');
    Route::get('/paid_holiday_list', [App\Http\Controllers\adminController::class, 'paid_holiday_list'])->name('paid_holiday_list');
    Route::get('/holiday_approval/{id}', [App\Http\Controllers\adminController::class, 'holiday_approval'])->name('holiday_approval');
    Route::get('/holiday_denial/{id}', [App\Http\Controllers\adminController::class, 'holiday_denial'])->name('holiday_denial');
    //ファイル送信
    Route::get('/file_send', [App\Http\Controllers\userController::class, 'file_send'])->name('file_send');
    Route::post('/file_send', [App\Http\Controllers\userController::class, 'file_join'])->name('file_join');
    Route::post('/file_db', [App\Http\Controllers\userController::class, 'file_db'])->name('file_db');
    Route::get('/received_file', [App\Http\Controllers\userController::class, 'received_file'])->name('received_file');
    Route::get('/download/{id}', [App\Http\Controllers\userController::class, 'download'])->name('download');
    //スタッフ関連
    Route::get('/staff_list', [App\Http\Controllers\staffController::class, 'staff_listshow'])->name('staff_listshow');
    Route::get('/staff_detail/{id}', [App\Http\Controllers\staffController::class, 'staff_detail'])->name('staff_detail');
    Route::post('/staff_delete', [App\Http\Controllers\staffController::class, 'staff_delete'])->name('staff_delete');
    Route::post('/staff_edit', [App\Http\Controllers\staffController::class, 'staff_edit'])->name('staff_edit');
    //その管理者メニューの設定
    Route::get('/admin_config', [App\Http\Controllers\adminController::class, 'admin_config_show'])->name('admin_config_show');

    //ユーザ設定関連
    Route::get('/user_menu', [App\Http\Controllers\userController::class, 'user_menu_show'])->name('user_menu_show');
    Route::get('/user_config', [App\Http\Controllers\userController::class, 'user_config_show'])->name('user_config_show');
    Route::post('/userconfig_modify', [App\Http\Controllers\userController::class, 'user_config_modify'])->name('user_config_modify');
    Route::get('/modify_adminpassword', [App\Http\Controllers\adminController::class, 'modify_adminpassword_show'])->name('modify_adminpassword');
    Route::post('/modify_adminpassword', [App\Http\Controllers\adminController::class, 'modify_adminpassword'])->name('modify_adminpassword_now');

    //excel出力
    Route::post('/export', [App\Http\Controllers\excelController::class, 'excel_export'])->name('excel_export');

    Route::get('/admin_menu', function () {
        return view('admin_menu');
    })->name('admin_menu');
});


//ここから下はスタッフ登録、スタッフ管理
Route::post('/entry_email_send', [App\Http\Controllers\staffController::class, 'entry_mail'])->name('entry_mail');
Route::get('/staff_entrysend', [App\Http\Controllers\staffController::class, 'entry_send'])->name('staff_entrysend');
Route::get('/staff_entry/{id}', [App\Http\Controllers\staffController::class, 'entry_show'])->name('staff_entry');
Route::post('/staff_entry_confirm', [App\Http\Controllers\staffController::class, 'staff_entry_confirm'])->name('staff_entry_confirm');
Route::post('/staffentry_complete', [App\Http\Controllers\staffController::class, 'staff_entry_now'])->name('staff_entry_now');

Route::get('/admin_entry', [App\Http\Controllers\adminController::class, 'show'])->name('admin_entryshow');
Route::post('/admin_entryconfirm', [App\Http\Controllers\adminController::class, 'admin_entryconfirm'])->name('admin_entryconfirm');
Route::post('/admin_entrynow', [App\Http\Controllers\adminController::class, 'admin_entrynow'])->name('admin_entrynow');

//ここから下はシフト管理、シフト登録


require __DIR__.'/auth.php';
