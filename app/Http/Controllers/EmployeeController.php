<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\User; 
use App\Models\Employee;
use Illuminate\Support\Facades\Auth; 
use Validator;

class EmployeeController extends Controller
{
    //
    public $successStatus = 200;


    // public function Emplogin()
    // { 
    //     $data = Auth::user(); 
    //         if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
    //             $success['token'] =   $data->createToken('MyApp')-> accessToken; 
    //             return response()->json(['success' => $success], $this-> successStatus); 
    //         } 
    //         else{ 
    //             return response()->json(['error'=>'Unauthorised'], 401); 
    //         } 
    // }


    public function register(Request $req)
    { 
        $user = Auth::user();
        $validator = Validator::make($req->all(), [ 
            'firstname' => 'required', 
            'lastname' => 'required', 
            'email' => 'required|email', 
            'username' => 'required',
            'address' => 'required',
            'experience' => 'required',
            'employeetype' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
            'password' => 'required', 
            'confirmpassword' => 'required|same:password', 
                    ]);
        if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
                }
        $imageName = time().'.'.$req->photo->extension();
        $req->photo->move(public_path('images'), $imageName);

        $input = $req->all(); 
        $input['companyID'] = $user->id;
        $input['photo'] = $imageName;
        $success = "Add successfully";
        // $input['password'] = bcrypt($input['password']); 
        $userArray = ['name'=>$input['firstname'].' '.$input['lastname'],'email'=>$input['email'],'username'=>$input['username'],'address'=>$input['address'],'password'=>bcrypt($input['password']),'role'=>'employee'];

        $userInfo = User::create($userArray); 
        $input['userId'] = $userInfo->id;
        //return response()->json(['success'=> $input, 'img'=> $imageName], $this->successStatus); 
        $employee = Employee::create($input); 
        
        return response()->json(['success'=>$success, 'img'=> $imageName], $this->successStatus); 
    }

    public function listEmployee()
    {
        $user = Auth::user();
         $userId = $user->id;
         $data = Employee::where('companyID',$userId)->get();
         foreach($data as $val){
            $val['photo'] = url('/').'/images/'. $val['photo'];
         }
         return response()->json($data);
    }

    public function singalEmployeeData($id)
    {
        $employee = Employee::where('id', $id)->first();
        $employee->photo = url('/').'/images/'. $employee->photo ;
        return response()->json(['success' => $employee], $this-> successStatus);
    }

     public function updateEmployeedata($id,Request $req)
    { 
        $employee = Employee::where('id', $id)->first();
        $user = User::where('id', $employee->userId)->first();
        
        $input = $req->all(); 
        $user->address=$req->address;
        $user->email=$req->email;
        $user->username=$req->username;
        $user->name=$req->firstname.' '.$req->lastname;

        $employee->firstname=$req->firstname;
        $employee->lastname=$req->lastname;
        $employee->username=$req->username;
        $employee->email=$req->email;
        $employee->address=$req->address;
        $employee->experience=$req->experience;
        $employee->employeetype=$req->employeetype;
        $employee->status=$req->status;
        $employee->is_notice=$req->is_notice;
        $employee->date=$req->date;
        if($req->photo){
          $imageName = time().'.'.$req->photo->extension();
           $req->photo->move(public_path('images'), $imageName);
           $employee->photo=$imageName;
        }
       
        if($employee->save() && $user->save())
          {
               return ['result'=>"success" ,'msg'=>"data is updated  "];
          }
    }

    function delete($id)
    {
        $employee = Employee::find($id);
        $result  = $employee->delete();
        if($result)
        {
           return ['result'=>"Record delete successfully"];
        }
        
    }

    function getemployee()
    {
       $id = Auth::user()->id;
        $employee = Employee::where('userId', $id)->first();
        $employee->photo = url('/').'/images/'. $employee->photo ;
        return response()->json(['success' => $employee], $this-> successStatus);
        
    }

    
}
