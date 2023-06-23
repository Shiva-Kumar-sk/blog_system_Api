<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::all();
        if (!$post) {
            return response()->json(['status' => false, 'data' => null, 'message' => ' data not found'], 401);
        }
        return response()->json(['status' => true, 'data' => $post, 'message' => 'all data found'], 200);
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|Min:4|Max:10',
            'content' => 'required|Min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response(['status' => false, 'data' => null, 'message' => 'validation error', 'errors' => $validator->errors()], 400);
        }
        $validated = $validator->valid();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $imageUrl = asset('storage/images/' . basename($imagePath));
        } else {
            $imageUrl = null;
        }
        $post = Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $imageUrl,
            'user_id' => auth()->user()->id
        ]);

        return response()->json(['status' => true, 'data' => $post, 'message' => "all data inserted"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['status' => false, 'data' => null, 'message' => ' data not found'], 404);
        }
        return response()->json(['status' => true, 'data' => $post, 'message' => 'all data found'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function my_data()
    {
        $post = Post::get()->where('user_id',auth()->user()->id);
        if(is_null($post)){
        return response()->json(['status'=>false, 'data'=>null, 'message'=>'data not found'],404);
            
        }
        
        return response()->json(['status'=>true, 'data'=>$post, 'message'=>'all  data found'],200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|Min:4|Max:10',
            'content' => 'required|Min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response(['status' => false, 'data' => null, 'message' => 'validation error', 'errors' => $validator->errors()], 400);
        }
        $validated = $validator->valid();
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $imageUrl = asset('storage/images/' . basename($imagePath));
        } else {
            $imageUrl = null;
        }
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['status' => false, 'data' => null, 'message' => "data not found"], 404);
        }
        if ($post->user_id !== auth()->user()->id) {
            return response()->json(['status' => false, 'data' => null, 'message' => "You are not authorized to do this action."], 401);
        }
       
        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $imageUrl,
            'user_id' => auth()->user()->id
        ]);

        return response()->json(['status' => true, 'data' => $post, 'message' => "data updated"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['status' => false, 'data' => null, 'message' => "data not found"], 404);
        }
        if ($post->user_id !== auth()->user()->id) {
            return response()->json(['status' => false, 'data' => null, 'message' => "You are not authorized to do this action."], 401);
        }
        $post->delete();
        return response()->json(['status' => true, 'data' => $post, 'message' => 'post deleted successfully'], 200);
    }
}
