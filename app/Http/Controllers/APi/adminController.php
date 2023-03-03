<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Workspace;
use Exception;
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
        try{
            $data = User::create([
                'name'      => $req->name,
                'email'     => $req->email,
                'password'  => bcrypt($req->password)
            ]);
            return response()->json([
                'status' => true,
                'message'=> 'berhasil menambahkan member'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message'=> 'gagal menambahkan member'
            ]);
        }
    }

    public function addworkspace(Request $req){
        $user = Auth::user();
        $admin = $user->admin;
        if(!$admin){
            return response()->json([
                'status' => false,
                'message'=> 'anda bukan admin'
            ]);
        }
        try{
            $file = $req->avatar->move(public_path('uploads/image'), $req->avatar->getClientOriginalName());
            // $image_path = $req->file('avatar')->store('image', 'public');
            $image_path = '/uploads/image/'.$req->avatar->getClientOriginalName();
            $data = Workspace::create([
                'name'      => $req->name,
                'assigment' => $req->assigment,
                'avatar'    => $image_path
            ]);
            return response()->json([
                'status' => true,
                'message'=> 'berhasil menambahkan member'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message'=> 'gagal menambahkan member'
            ]);
        }
    }
    public function getworkspace(){
        $user = Auth::user();
        if($user->admin){
            return response()->json(Workspace::get());
        }
        return response()->json(Workspace::where('assigment','LIKE',"%{$user->id}%")->get());
    }
}
