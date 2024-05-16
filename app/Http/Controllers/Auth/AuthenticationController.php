<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Auth;
class AuthenticationController extends Controller
{
    public function registerProcess(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'email' => 'required|email',
            'contact' => 'required|max:12',
            'password' => 'required|min:6',
        ]);
 
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message'=>'validation errors','errors'=>$validator->errors()],400);
        }
        
    }
    public function loginProcess(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if(Auth::attempt(['email' => $request->email , 'password' => $request->password])){
            $request->session()->regenerate();
            return redirect('/')->with(['success'=>'Logged in successful']);
        }else{
            return redirect()->back()->with(['error'=>'Invalid credentials']);
        }
    }
    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/')->with('success','Logged out succesfully.');
    }
    public function login(Request $request){
        return view('auth.login');
    }
    // public function register(Request $request){
    //     return view('auth.register');
    // }
}
