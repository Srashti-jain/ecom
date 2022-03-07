<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    //
    function login(Request $req)
    {
    //     $req->session()->get('user');
    // if(session()->has('user'))
    //    {
    //      include('notlogin.login');
    //  }
    // else
    // {
    //      include('index');
    //  }
    $user= User::where(['email'=>$req->email])->first();
        //return $user;
        //dd($user);


        if(!$user || !Hash::check($req->password,$user->password))
        {
            return "username or password is not matched";
        }
        else
        {
            $req->session()->put('user',$user);
            return redirect('/index');
        }
    }
}
