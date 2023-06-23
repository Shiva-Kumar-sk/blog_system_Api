<?php

namespace App\Http\Controllers\API;
 
use App\Http\Controllers\Controller;
 
use Illuminate\Http\Request;
 
use App\Models\User;
use Illuminate\Support\Facades\Validator;

 
class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:15',
            'email' => 'required|email',
            'password' => 'required|min:8|max:16',
        ]);
        if ($validator->fails()) {
            return response(['status' => false, 'data' => null, 'message' => 'validation error', 'errors' => $validator->errors()], 400);
        }
        $validated = $validator->valid();



        $this->validate($request, [
            'name' => 'required|min:4|max:15',
            'email' => 'required|email',
            'password' => 'required|min:8|max:16',
        ]);
  
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
  
        $token = $user->createToken('Token')->accessToken;
  
        return response()->json(['status' => true, 'data' => $user, 'token' => $token , 'message' => 'register success'], 200);
    }
  
    
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
  
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Token')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
 
    public function userInfo() 
    {
 
     $user = auth()->user();
      
     return response()->json(['user' => $user], 200);

 
    }
}
