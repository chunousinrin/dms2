<?php

//use App\Http\Controllers\DrsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::post('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/', 'App\Http\Controllers\HomeController@index');


Route::get('/bill', [App\Http\Controllers\BillController::class, 'bill'])->name('bill');
Route::post('/bill', [App\Http\Controllers\BillController::class, 'bill'])->name('bill');
Route::post('/bill/preview', [App\Http\Controllers\BillController::class, 'bill_preview'])->name('bill_preview');
Route::post('/bill/deliveryslip', [App\Http\Controllers\BillController::class, 'deliveryslip'])->name('deliveryslip');
Route::post('/bill/repreview', [App\Http\Controllers\BillController::class, 'bill_repreview'])->name('bill_repreview');
Route::post('/bill/deliveryslip/repreview', [App\Http\Controllers\BillController::class, 'deliveryslip_repreview'])->name('deliveryslip_repreview');
Route::post('/bill/list_print', [App\Http\Controllers\BillController::class, 'bill_list_print'])->name('bill_list_print');


Route::get('/draft', [App\Http\Controllers\DraftController::class, 'draft'])->name('draft');
Route::post('/draft', [App\Http\Controllers\DraftController::class, 'draft'])->name('draft');
Route::post('/draft/preview', [App\Http\Controllers\DraftController::class, 'draft_preview'])->name('draft_preview');
Route::post('/draft/repreview', [App\Http\Controllers\DraftController::class, 'draft_repreview'])->name('draft_repreview');


Route::get('/estimate', [App\Http\Controllers\EstimateController::class, 'estimate'])->name('estimate');
Route::post('/estimate', [App\Http\Controllers\EstimateController::class, 'estimate'])->name('estimate');
Route::post('/estimate/preview', [App\Http\Controllers\EstimateController::class, 'estimate_preview'])->name('estimate_preview');
Route::post('/estimate/repreview', [App\Http\Controllers\EstimateController::class, 'estimate_repreview'])->name('estimate_repreview');
Route::post('/estimate2/preview', [App\Http\Controllers\EstimateController::class, 'estimate2_preview'])->name('estimate2_preview');
Route::post('/estimate2/repreview', [App\Http\Controllers\EstimateController::class, 'estimate2_repreview'])->name('estimate2_repreview');


Route::get('/customer', [App\Http\Controllers\MasterController::class, 'customer'])->name('customer');
Route::post('/customer', [App\Http\Controllers\MasterController::class, 'customer'])->name('customer');
Route::get('/customer/reg', [App\Http\Controllers\MasterController::class, 'customer_reg'])->name('customer_reg');
Route::post('/customer/reg', [App\Http\Controllers\MasterController::class, 'customer_reg'])->name('customer_reg');
Route::get('/master/classication', [App\Http\Controllers\MasterController::class, 'classication'])->name('classication');
Route::post('/master/classication', [App\Http\Controllers\MasterController::class, 'classication'])->name('classication');
Route::get('/master/bank', [App\Http\Controllers\MasterController::class, 'bank'])->name('bank');
Route::post('/master/bank', [App\Http\Controllers\MasterController::class, 'bank'])->name('bank');
Route::get('/master/dailyreport', [App\Http\Controllers\MasterController::class, 'dailyreport'])->name('dailyreport');
Route::post('/master/dailyreport', [App\Http\Controllers\MasterController::class, 'dailyreport'])->name('dailyreport');
Route::get('/master/users', [App\Http\Controllers\MasterController::class, 'users'])->name('users');
Route::post('/master/users', [App\Http\Controllers\MasterController::class, 'users'])->name('users');
Route::get('/admin/settings', [App\Http\Controllers\MasterController::class, 'user'])->name('user');
Route::post('/admin/settings', [App\Http\Controllers\MasterController::class, 'user'])->name('user');
Route::get('/admin/company', [App\Http\Controllers\MasterController::class, 'company'])->name('company');
Route::post('/admin/company', [App\Http\Controllers\MasterController::class, 'company'])->name('company');
Route::get('/admin/company', [App\Http\Controllers\MasterController::class, 'company'])->name('company');
Route::get('/attendance', [App\Http\Controllers\MasterController::class, 'attendance'])->name('attendance');
Route::post('/attendance', [App\Http\Controllers\MasterController::class, 'attendance'])->name('attendance');
Route::post('/attendance/list_print', [App\Http\Controllers\MasterController::class, 'at4'])->name('at4');
Route::get('/attendance/wath_view', [App\Http\Controllers\MasterController::class, 'wath_view'])->name('wath_view');
Route::post('/attendance/wath_view', [App\Http\Controllers\MasterController::class, 'wath_view'])->name('wath_view');


Route::get('/atmain', [App\Http\Controllers\AttendanceController::class, 'atmain'])->name('atmain');
Route::post('/atmain', [App\Http\Controllers\AttendanceController::class, 'atmain'])->name('atmain');
Route::get('/worker', [App\Http\Controllers\AttendanceController::class, 'worker'])->name('worker');
Route::post('/worker', [App\Http\Controllers\AttendanceController::class, 'worker'])->name('worker');
Route::get('/worker/print', [App\Http\Controllers\AttendanceController::class, 'worker_print'])->name('worker_print');
Route::post('/worker/print', [App\Http\Controllers\AttendanceController::class, 'worker_print'])->name('worker_print');


Route::get('/license', 'App\Http\Controllers\WorkController@license');

Route::get('/license/update', [App\Http\Controllers\WorkController::class, 'license_update'])->name('license_update');
Route::post('/license/update', [App\Http\Controllers\WorkController::class, 'license_update'])->name('license_update');
Route::get('/license/input', [App\Http\Controllers\WorkController::class, 'license_input'])->name('license_input');
Route::post('/license/input', [App\Http\Controllers\WorkController::class, 'license_input'])->name('license_input');
Route::get('/license/conf', [App\Http\Controllers\WorkController::class, 'license_conf'])->name('license_conf');
Route::post('/license/conf', [App\Http\Controllers\WorkController::class, 'license_conf'])->name('license_conf');
Route::get('/sending', [App\Http\Controllers\WorkController::class, 'sending'])->name('sending');
Route::post('/sending', [App\Http\Controllers\WorkController::class, 'sending'])->name('sending');
Route::get('/sending/preview', [App\Http\Controllers\WorkController::class, 'sending_preview'])->name('sending_preview');
Route::post('/sending/preview', [App\Http\Controllers\WorkController::class, 'sending_preview'])->name('sending_preview');
Route::post('/sinrinbo', [App\Http\Controllers\WorkController::class, 'sinrinbo'])->name('sinrinbo');
Route::get('/sinrinbo', [App\Http\Controllers\WorkController::class, 'sinrinbo'])->name('sinrinbo');
Route::post('/sinrinbo/export', [App\Http\Controllers\WorkController::class, 'sinrinbo_export'])->name('sinrinbo_export');
Route::post('/forestunion', [App\Http\Controllers\WorkController::class, 'forestunion'])->name('forestunion');
Route::get('/forestunion', [App\Http\Controllers\WorkController::class, 'forestunion'])->name('forestunion');

Route::get('/admin/user_list', [App\Http\Controllers\AdminController::class, 'user_list'])->name('user_list');
Route::post('/admin/user_list', [App\Http\Controllers\AdminController::class, 'user_list'])->name('user_list');
Route::get('/admin/user_edit', [App\Http\Controllers\AdminController::class, 'user_edit'])->name('user_edit');
Route::post('/admin/user_edit', [App\Http\Controllers\AdminController::class, 'user_edit'])->name('user_edit');
Route::get('/admin/user_workingtime', [App\Http\Controllers\AdminController::class, 'user_workingtime'])->name('user_workingtime');
Route::post('/admin/user_workingtime', [App\Http\Controllers\AdminController::class, 'user_workingtime'])->name('user_workingtime');
Route::get('/admin/working_list', [App\Http\Controllers\AdminController::class, 'working_list'])->name('working_list');
Route::post('/admin/working_list', [App\Http\Controllers\AdminController::class, 'working_list'])->name('working_list');

Route::get('/drs', [App\Http\Controllers\DrsController::class, 'drs'])->name('drs');
Route::post('/drs', [App\Http\Controllers\DrsController::class, 'drs'])->name('drs');

Route::post('/errl', [App\Http\Controllers\ErrlController::class, 'errl'])->name('errl');
Route::get('/errl', [App\Http\Controllers\ErrlController::class, 'errl'])->name('errl');
Route::post('/errl/list_print', [App\Http\Controllers\ErrlController::class, 'errl_list_print'])->name('errl_list_print');

Route::get('/calendar', [App\Http\Controllers\WorkController::class, 'calendar'])->name('calendar');
Route::post('/calendar', [App\Http\Controllers\WorkController::class, 'calendar'])->name('calendar');

Route::get('/shukei', [App\Http\Controllers\ZaisekiController::class, 'shukei'])->name('shukei');
Route::post('/shukei', [App\Http\Controllers\ZaisekiController::class, 'shukei'])->name('shukei');
