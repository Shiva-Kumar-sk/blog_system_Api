<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Mobile;
use App\Models\User;

class MobileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        if($user){
        return response(['status'=>true,'data'=>$user, 'message'=>'all data of user'],200);
        }else{
            return response(['status'=>false,'data'=>null, 'message'=>'all not data of user'],401);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "hello";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        print_r($request);
        die();
      $this->validate($request,[
        'name' => 'required',
        'company' => 'required',
        'price' => 'required',
      ]);
      $mobile = Mobile::create([
        'name' => $request->name,
        'company' => $request->company,
        'price' => $request->price,
      ]);
      return response()->json(['data' => $mobile], 200);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
