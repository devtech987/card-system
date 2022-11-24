<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller; 
use Validator;
use App\Models\Admin;

class AdminController extends Controller
{
    //
    public function register(Request $req)
    {
        
          $admin = New Admin;
          $admin->firstname=$req->firstname;
          $admin->lastname=$req->lastname;
          $admin->username=$req->username;
          $admin->password=$req->password;
          if($admin->save())
          {
               return ['result'=>'Data have been save'];
          }
    }
}
