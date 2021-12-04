<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	use ApiResponser;

    public function login(Request $request)
    {    
    	try{
	        $validator = \Validator::make($request->all(), [ 
				'email' => 'required|string|email|',
	            'password' => 'required|string'
			]);

			if ($validator->fails()) {
				return $this->error('Invalid input data',400);
			}

	        if (!Auth::attempt($validator->validated())) {
	        	return $this->error('Invalid credentials',401);
	        }
			return $this->success([
				'token' => auth()->user()->createToken('API Token')->plainTextToken
			]);
				
	    }catch(\Exception $e){
			return $this->error('An error has ocurred',500);
	    }
    }

    public function logout()
    {
    	try{
	        auth()->user()->tokens()->delete();
	        return $this->success();
	    }catch(\Exception $e){
			return $this->error('An error has ocurred',500);
	    }
    }
}
