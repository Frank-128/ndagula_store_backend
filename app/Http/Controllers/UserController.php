<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function login(Request $request){

        $validator = Validator::make($request->all(),[
            'email_or_username'=>'required|string',
            'password'=>'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],422);
        }
        $field = $this->getField($request->input('email_or_username'));
        $credentials = [
            $field => $request->input('email_or_username'),
            'password' => $request->input('password')
        ];
        if(Auth::attempt($credentials)){
            $user = auth()->user();
           $token = $user->createToken('auth_token')->plainTextToken;

           
            return response()->json(['token'=>$token,'user'=>$user],200);
        }else{
            return response()->json(['message'=>'Incorrect Credentials'],401);
        }

    }

    private function getField($value){
        $fieldType = filter_var($value,FILTER_VALIDATE_EMAIL)?'email':'username';
        return $fieldType;
    }


    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'string|required',
            'email'=>'email|required',
            'username'=>'string|required',
            'password_confirmation'=>'string|required',
            'password'=>'string|required|confirmed'
        ]);

        if($validator->fails()){
            return response()->json(['error',$validator->errors()],422);
        }
      try{  $pass= Hash::make($request->input('password'));
         $user = User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'username'=>$request->input('username'),
            'password'=>$pass,

        ]);

        return response()->json(['message'=>'user created successfully','user'=>$user],200);}
        catch(Exception $err ){
            return response()->json(['err'=>$err]);
        }
    }
    public function orders(){
        return $this->hasOne(Order::class);
    }
}
