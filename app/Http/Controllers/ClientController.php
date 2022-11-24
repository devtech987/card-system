<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\Client; 
use Illuminate\Support\Facades\Auth; 
use Validator;


class ClientController extends Controller
{
    function store(Request $req){
     
        $user = Auth::user();
        $validator = Validator::make($req->all(), [ 
            'firstname' => 'required', 
            'lastname' => 'required', 
            'country' => 'required',
            'startdate'=>'required',
            'enddate'=>'required',
            'tecnology'=>'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['type'=>'error','msg'=>$validator->errors()], 401);            
        }
        $input = $req->all(); 
        $input['companyID'] = $user->id;
        $userInfo = Client::create($input); 
        return response()->json(['type'=>'success', 'msg'=> 'Client Added Successfully']); 

    }
    function update($id,Request $req){

        $user = Auth::user();
        $validator = Validator::make($req->all(), [ 
            'firstname' => 'required', 
            'lastname' => 'required', 
            'country' => 'required',
            'startdate'=>'required',
            'enddate'=>'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['type'=>'error','msg'=>$validator->errors()], 401);            
        }

       
        $userInfo = Client::where('id',$id)->first(); 

        $userInfo->firstname=$req->firstname;
        $userInfo->lastname=$req->lastname;
        $userInfo->email=$req->email;
        $userInfo->country=$req->country;
        $userInfo->tecnology=$req->tecnology;
        $userInfo->status=$req->status;
        $userInfo->startdate=$req->startdate;
        $userInfo->enddate=$req->enddate;
        if($userInfo->save())
        {
         return response()->json(['type'=>'success', 'msg'=> 'Client update Successfully']); 
        }
        

    }



    function list(){
         $user = Auth::user();
         $userId = $user->id;
         $data = Client::where('companyID',$userId)->get();
         return response()->json(['type'=>'success','data'=>$data]);
    }

    function singalClient($id)
    {   
        $data = Client::where('id', $id)->first();
        return response()->json(['success' => $data]);
    }
}
