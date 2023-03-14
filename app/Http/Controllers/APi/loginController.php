<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class loginController extends Controller
{
    public function index(Request $req){


        try{
            Auth::attempt(['email' => $req->email, 'password' => $req->password]);
            $users = Auth::user();
            return response()->json([
                'status' => true,
                'data' => [
                    'token' => $users->createToken('Token Name')->accessToken
                ]
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ]);
        }

    }
    public function whois(){
        return response()->json(Auth::user());
    }
}
