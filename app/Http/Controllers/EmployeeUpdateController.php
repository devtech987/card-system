<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Employee;
use App\Models\EmployeeUpdate;
use Validator;

class EmployeeUpdateController extends Controller
{
      public $successStatus = 200;
    //
    public function workUpDate(Request $req)
    {
          $user = Auth::user();
          $userId = $user->id;
          $employee = Employee::where('userId', $userId)->first();
          $employeeId = $employee->id;
        $validator = Validator::make($req->all(), [ 
            'starttime' => 'required', 
            'endtime' => 'required', 
            'update' => 'required', 
                    ]);
        if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
                }
        $success = "Add successfully";
        $input = $req->all(); 
        $input['employeeId'] = $employeeId;
        $update = EmployeeUpdate::create($input); 

         return response()->json(['success'=>$success], $this->successStatus); 



    }

    public function companyworkUpDatelist()
    {
          $user = Auth::user();
          $userId = $user->id;
          // $employee = Employee::where('userId', $userId)->first();
          // $employeeId = $employee->id;

           $c = EmployeeUpdate::select(['employeeupdates.*','employees.firstname','employees.lastname'])->leftJoin('employees', function($join) {
            $join->on('employeeupdates.employeeId', '=', 'employees.id');
       })->where('employees.companyID', $userId)
        ->get();

        return response()->json($c); 
    }

    public function workUpDatelist()
    {
         $user = Auth::user();
         $userId = $user->id;
         $employee = Employee::where('userId', $userId)->first();
         $employeeId = $employee->id;
         $data = EmployeeUpdate::where('employeeId',$employeeId)->get();

         return response()->json($data);
    }

    public function singalupdateData($id)
    {
         
         $data = EmployeeUpdate::select(['employeeupdates.*','employees.firstname','employees.lastname','employees.photo','employees.email'])->leftJoin('employees', function($join) {
            $join->on('employeeupdates.employeeId', '=', 'employees.id');
       })->where('employeeupdates.id', $id)
        ->get();

         foreach($data as $val){
            $val['photo'] = url('/').'/images/'. $val['photo'];
         }
         return response()->json($data);
    }
}
