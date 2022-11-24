<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\EmployeeUpdateController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("add",[UserController::class,'register']);
Route::post("login",[UserController::class,'login']);
Route::post("register",[UserController::class,'register']);
Route::get("edit",[UserController::class,'singaluserList']);
Route::put("edituser/{id}",[UserController::class,'updateuserdata']);
Route::get("userlist",[UserController::class,'list']);




// Route::post("emplogin",[EmployeeController::class,'Emplogin']);

Route::group(['middleware' => 'auth:api'], function(){

Route::post("profile",[UserController::class,'singaldata']);
Route::post("logout",[UserController::class,'logout']);

Route::get("count",[UserController::class,'count']);

Route::get("empcount",[UserController::class,'employeecount']);

Route::get("empEntrycount",[UserController::class,'employeeEntrycount']);
// employee
Route::post("addemp",[EmployeeController::class,'register']);
Route::get("listemp",[EmployeeController::class,'listEmployee']);
Route::get("editemp/{id}",[EmployeeController::class,'singalEmployeeData']);
Route::post("updateEmp/{id}",[EmployeeController::class,'updateEmployeedata']);
Route::post("deleteEmp/{id}",[EmployeeController::class,'delete']);
Route::get("employee",[EmployeeController::class,'getemployee']);
// employee

// Leave
Route::post("addleave",[LeaveController::class,'addleave']);
Route::get("viewleave",[LeaveController::class,'Leavelist']);
Route::get("listLeave",[LeaveController::class,'employeeLeaveList']);
Route::post("leaveApprove/{id}",[LeaveController::class,'updateLeavesApprove']);
Route::post("leaveUnApprove/{id}",[LeaveController::class,'updateLeavesUnApprove']);
// Leave

/*EmployeeUpdate*/
Route::post("workupdate",[EmployeeUpdateController::class,'workUpDate']);
Route::get("compworkupdate",[EmployeeUpdateController::class,'companyworkUpDatelist']);
Route::get("empworkupdate",[EmployeeUpdateController::class,'workUpDatelist']);
Route::get("singalupdate/{id}",[EmployeeUpdateController::class,'singalupdateData']);
/*EmployeeUpdate*/


/*cleint*/
Route::group(['prefix'=>'client'], function(){
	Route::get("/",[ClientController::class,'list']);
    Route::post("/add",[ClientController::class,'store']);
    Route::post("/edit/{id}",[ClientController::class,'update']);
    Route::get("/singalclient/{id}",[ClientController::class,'singalClient']);
});

/*client*/

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
