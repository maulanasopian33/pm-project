<?php

namespace App\Http\Controllers\Api;

use App\Events\GlobalMessage;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Workspace;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminController extends Controller
{
    public function addteam(Request $req){
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
                'nomor'     => $req->nomor,
                'password'  => bcrypt($req->password)
            ]);
            return response()->json([
                'status' => true,
                'message'=> 'berhasil menambahkan member'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message'=> 'gagal menambahkan member',
                'data'   => $e
            ]);
        }
    }
    public function getteam(){
        return response()->json([
            'status' => true,
            'data'   => User::get()
        ]);
    }
    public function sendNotif(Request $req){
        $mytime = Carbon::now();
        GlobalMessage::dispatch([
            'message' => $req->message,
            'from'    => $req->from,
            'type'    => $req->type,
            'time'    => $mytime->toDateTimeString()
        ]);
        return response()->json([
            'status' => true,
            'message'=> "Notif Published"
        ]);
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
        // return $req;
        try{
            $file = $req->avatar->move(public_path('uploads/image'), $req->avatar->getClientOriginalName());
            // $image_path = $req->file('avatar')->store('image', 'public');
            $image_path = '/uploads/image/'.$req->avatar->getClientOriginalName();
            $data = Workspace::create([
                'name'      => $req->name,
                'assigment' => $req->assigment,
                'deskripsi' => $req->deskripsi,
                'avatar'    => $image_path
            ]);
            return response()->json([
                'status' => true,
                'message'=> 'berhasil menambahkan workspace'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message'=> 'gagal menambahkan gagal',
                'data'   => $e
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

    public function getworkspaceByName($name){
        return response()->json([
            "data" => Workspace::where('name',$name)->get()]);
    }


    public function destroymember($id)
    {
        try{
            $hapus = User::find($id)->delete();
                if($hapus){
                    return response()->json([
                        'status'  => true,
                        'message' => "Deleted",
                    ]);
                }else{
                    return response()->json([
                        'status'  => false,
                        'message' => "Gagal Menghapus",
                    ]);
                }
        }catch(\Exception $e){
            return response()->json([
                'status'  => false,
                'message' => $e,
            ],404);
        }

    }
}
