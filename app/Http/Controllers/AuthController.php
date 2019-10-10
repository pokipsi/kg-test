<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function login(Request $req){

        $email = $req->email;
        $password = $req->password;
        $user = User::where(['email'=>$email, 'admin'=>true])->first();

        if($user){

            try{
                $req->request->add([
                    'grant_type' => 'password',
                    'client_id' => env('PASSPORT_CLIENT_ID'),
                    'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                    'username' => $email,
                    'password' => $password
                ]);

                $tokenRequest = $req->create(
                    env('PASSPORT_LOGIN_ENDPOINT'),
                    'post'
                );

                $instance = \Route::dispatch($tokenRequest);

                return $instance->getContent();
            }
            catch(Exception $e){
                return [
                    'error' => true,
                    'msg' => $e->getMessage()
                ];
            }


        }else{
            return [
                'error' => true,
                'msg' => 'No user'
            ];
        }

        

    }
}
