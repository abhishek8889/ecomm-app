<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Hash;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:200',
                'email' => 'required|email',
                'contact' => 'required|max:12',
                'password' => 'required|min:6',
            ]);
     
            if ($validator->fails()) {
                return response()->json(['status'=>false,'message'=>'validation errors','errors'=>$validator->errors()],400);
            }
            $validated = $validator->safe()->only(['name', 'email','contact','password']);
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'contact' => $validated['contact']
            ]);
            return response()->json(['status' => true,'message'=>'registered successfull.'],200);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>'Something went wrong','errors'=>$e->getMessage()],400);
        }
        
    }
    public function login(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if($validator->fails()){
                return response()->json(['status'=>false,'message'=>'validation errors','errors'=>$validator->errors()],400);
            }
            $validated = $validator->safe()->only(['email','password']);

            if(Auth::attempt(['email' => $validated['email'] , 'password' => $validated['password']])){
                $user = Auth::user();
                if(Auth::user()->is_admin == 1){
                    $token = Auth()->user()->createToken('auth-token')->accessToken;
                }else{
                    $token = Auth()->user()->createToken('auth-token')->accessToken;
                }
                return response()->json([
                    'status'=>true,
                    'message'=>'Logged in successfull.',
                    'token'=>$token,
                    'user' => $user,
                ],200);
            }else{
                return response()->json(['status' => false,'message'=>'credentials are wrong'],400);
            }

        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>'Something went wrong','errors'=>$e->getMessage()],400);
        }
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(['status'=>true,'message'=>'Logged out successfull.'],200);
    }
}
