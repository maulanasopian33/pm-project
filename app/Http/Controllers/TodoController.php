<?php

namespace App\Http\Controllers;

use App\Models\todo;
use App\Services\PayUService\Exception;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        return response()->json(todo::where('id_task',$id)->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try{
            todo::create([
                'id_task'   => $request->id_task,
                'name'      => $request->name,
                'status'    => $request->status
            ]);
            return response()->json([
                'status'  => true,
                'message' => 'created',
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updates(Request $request)
    {
        // return $request->name;
        try{
            $data =todo::where('name',$request->name)->get();
            // return $data;
            $data[0]->status = $request->status;
            $data[0]->save();
            return response()->json([
                'status'  => true,
                'message' => 'Updated',
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'status'  => false,
                'message' => 'Notfound',
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try{
            $todo = todo::where('name',$id)->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Deleted',
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'status'  => false,
                'message' => 'Notfound',
            ],404);
        }

    }
}
