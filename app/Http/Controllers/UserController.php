<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\User; 
use App\Models\Employee; 
use App\Models\leave; 
use App\Models\EmployeeUpdate; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            // $success['type'] =  $user->role;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
             $success['role'] =  $user->role; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function register(Request $req)
    { 
        $validator = Validator::make($req->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'username' => 'required',
            'address' => 'required',
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $req->all(); 
        $input['role'] = 'company';
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['companyID'] =  $user->id;
        $success['name'] =  $user->name;
        $success['role'] =  $user->role;
        return response()->json(['success'=>$success], $this-> successStatus); 
    }


   public function list ()
    {
       
        return User::all();
    }

    public function singaluserList()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus); 
    }
// update api
    public function updateuserdata($id,Request $req)
    {
        $user = User::where('id', $id)->first();
        $user->name=$req->name;
        $user->email=$req->email;
        $user->address=$req->address;
        $user->username=$req->username;
        $user->password=$req->password;
        if($user->save())
          {
               return ['result'=>"success" ,'msg'=>"data is updated  "];
          }
    }
// delete api
    // function delete($id)
    // {
    //     $user = User::find($id);
    //     $result  = $user->delete();
    //     if($result)
    //     {
    //        return ['result'=>"Record delete successfully"];
    //     }
        
    // }
// singaldata api
    public function singaldata()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus); 
    }

    public function logout(Request $req)
    {
        $token = $req->user()->token();
        $token->revoke();
        return response()->json(['success' => 'You Have logout successfully !!']); 
    }


      public function count(Request $req)
    {
          $user = Auth::user();
          $id = $user->id; 
        $collection = Leave::groupBy('status')
                     ->selectRaw('count(id) as total,status')
                     ->where('userId',$id)
                     ->get();

        $employee = Employee::groupBy('status')
                     ->selectRaw('count(id) as total,status')
                      ->where('companyID',$id)
                     ->get();

       
        $data =  Employee::where('companyID', $id)->count();
        
        $result = ['employee'=>$data, 'leave'=>$collection,'active'=>$employee];           
        return response()->json($result); 
    }
 
       public function employeecount()
    {
         $user = Auth::user();
         $id = $user->id; 
        $data =  Employee::where('companyID', $id)->count();
        $result = ['employee'=>$data];           
        return response()->json($result); 
    }

    public function employeeEntrycount($value='')
    {
         $user = Auth::user();
          $id = $user->id; 
           $employee = Employee::groupBy('date')
                     ->selectRaw('count(id) as total,date')
                      ->where('companyID',$id)
                     ->get();

        $result = ['employee'=>$employee];           
        return response()->json($result); 
        
    }
}
