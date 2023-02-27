<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminController extends Controller
{
    public function addmember(Request $req){
        $user = Auth::user();
        $admin = $user->admin;
        if(!$admin){
            return response()->json([
                'status' => false,
                'message'=> 'anda bukan admin'
            ]);
        }
        $data = User::create([
            'name' => $req->name,
            'email'=> $req->email,
            'password'=> $req->password
        ]);
    }
}
