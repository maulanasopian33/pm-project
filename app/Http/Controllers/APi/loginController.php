<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function index(Request $req){
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
            $users = Auth::user();
            return response()->json([
                'status' => true,
                'data' => [
                    'token' => $users->createToken('Token Name')->accessToken
                ]
            ]);
        };
        return response()->json([
            'status' => false,
            'data' => []
        ]);

    }
}
