<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth; 
use Validator;
class LeaveController extends Controller
{
     public $successStatus = 200;
    //
    public function addleave(Request $req)
    {
          $user = Auth::user();
          $userId = $user->id;
          $employee = Employee::where('userId', $userId)->first();
          $employeeId = $employee->id;
        
        $validator = Validator::make($req->all(), [ 
            'days' => 'required', 
            'fromdate' => 'required', 
            'todate' => 'required', 
            'reason' => 'required', 
                    ]);
        if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
                }
        $success = "Add successfully";
        $input = $req->all(); 
        $input['userId'] = $userId;
        $input['employeeId'] = $employeeId;
        $input['status'] = "UnApproved";
        $leave = Leave::create($input); 

         return response()->json(['success'=>$success], $this->successStatus); 



    }

    public function Leavelist()
    {
        $user = Auth::user();
        $userId = $user->id;
        $data = Leave::where('userId',$userId)->get();
        return response()->json($data); 
    }

    public function employeeLeaveList()
    {
       $user = Auth::user();
        $userId = $user->id;

       $c = Leave::select(['leaves.*','employees.firstname','employees.lastname'])->leftJoin('employees', function($join) {
            $join->on('leaves.employeeId', '=', 'employees.id');
       })->where('employees.companyID', $userId)
        ->get();

       return response()->json($c); 
    }

    public function updateLeavesApprove($id)
    {
        $leave = Leave::where('id', $id)->first();
        $leave->status='Approved';
       if($leave->save())
          {
               return ['result'=>"success" ,'msg'=>"data is updated  "];
          }
    }

    public function updateLeavesUnApprove($id)
    {
        $leave = Leave::where('id', $id)->first();
        $leave->status='UnApproved';
       if($leave->save())
          {
               return ['result'=>"success" ,'msg'=>"data is updated  "];
          }
    }
}
