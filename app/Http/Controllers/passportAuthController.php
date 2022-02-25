<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Sanctum\NewAccessToken;
use Validator;
use Symfony\Component\HttpFoundation\Response;



class passportAuthController extends Controller
{
    public function registerUserExample(Request $request){
         $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8',
        ]);
          if ($validator->fails()) {
            return response()->json(['status' => false, 'response' => new \stdClass(), 'message' => $validator->errors()->first(), 'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_OK);
        }

        $user= User::create([
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);
            
        $access_token_example = $user->createToken($request->email)->accessToken;
        return response()->json(['status' => true, 'response' => ['token' => $access_token_example], 'message' => $validator->errors()->first(), 'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_OK);
        // return response()->json(['token'=>$access_token_example],200);
    }

    /**
     * login user to our application
     */
    public function loginUserExample(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required|min:8',
        ]);
          if ($validator->fails()) {
            return response()->json(['status' => false, 'response' => new \stdClass(), 'message' => $validator->errors()->first(), 'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_OK);
        }

        $login_credentials=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(auth()->attempt($login_credentials)){
            
            $user_login_token= auth()->user()->createToken($request->email)->accessToken;
            
            return response()->json(['token' => $user_login_token], 200);
        }
        else{
            
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }

    /**
     * This method returns authenticated user details
     */
    public function authenticatedUserDetails(){   
       
        return auth()->user();
    }

    public function authenticatedUpdate(Request $request){
        
        $user = auth()->user();
        return $user;
    } 
    public function nextUpdate(Request $request, User $user){
        
        $user=auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
        return $user;
    }  
}