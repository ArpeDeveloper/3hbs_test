<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
//use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {    
    	try{
    		$jsonResponse=[];
    		$code=401;
	        $validator = \Validator::make($request->all(), [ 
				'email' => 'required|string|email|',
	            'password' => 'required|string'
			]);

			if ($validator->fails()) {
				$jsonResponse = [
					'ok' => false,
					'message' => 'Invalid input data'
				];
				$code = 400;
			}else{
		        if (!Auth::attempt($validator->validated())) {
		        	$jsonResponse = [
						'ok' => false,
						'message' => 'Invalid Credentials'
					];
		        }else{
					$code = 200;
					$jsonResponse = [
						'ok' => true,
						'message' => '',
						'data' => [
				            'token' => auth()->user()->createToken('API Token')->plainTextToken
				        ]
					];
				}
			}
	    }catch(\Exception $e){
	    	$code = 500;
			$jsonResponse = [
				'ok' => false,
				'message' => 'an error has ocurred'
			];
	    }
	    return response()->json($jsonResponse, $code);

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
