<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withTrashed()->paginate(5);

        return new UserResource($users);
    }

    public function register(Request $request){

        $this->validate($request, [
            'email' => 'required|string|email|max:255'
        ]);

        $email = $request['email'];

        $user = User::withTrashed()->where('email', $email)->first();

        if($user){

            return $user;

        }else{

            return User::create([
                'email' => $request['email'],
                'password' => bcrypt('password')
            ]);

        }

    }

    public function subscribe(Request $request){

        $this->validate($request, [
            'email' => 'required|string|email|max:255'
        ]);

        $email = $request['email'];

        $user = User::withTrashed()->where('email', $email)->first();

        if ($user) {

            $user->update(['subscribed' => true]);

            if($user->trashed()){

                $user->restore();

            }

            return $user;

        }else{
            return [
                "error" => true,
                "msg" => "User not found"
            ];
        }

    }

    public function requireReactivation(Request $request){

        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        $id = $request['id'];

        $user = User::withTrashed()->where('id', $id)->first();

        if($user){

            if($user->trashed()){
                    
                $user->restore();
                 
                $user->update(['required_reactivation' => true]);

            }

        }        
        
        return $user;
    }

    public function unsubscribe(Request $request){

        $res = $this->validate($request, [
            'id'=> 'required',
            'p' => 'required'
        ]);

        $ret = User::where('id', $request['id'])
          ->where('password', $request['p'])
          ->delete();

        if($ret){
            $error = false;
            $msg = 'User unsubscribed.';
        }else{
            $error = true;
            $msg = 'User not unsubscribed. Something went wrong.';
        }

        return [
            "error" => $error,
            "msg" => $msg
        ];

    }

    public function activate(Request $request){
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        $id = $request['id'];

        $user = User::withTrashed()->where('id', $id)->first();

        if($user){

            $user->update(
                [
                    'subscribed' => true,
                    'required_reactivation' => false
                ]
            );

            if($user->trashed()){
                    
                $user->restore();    

            }

        }        
        
        return $user;
    }

    public function deactivate(Request $request){
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        $id = $request['id'];

        $user = User::withTrashed()->where('id', $id)->first();

        if($user){

            $user->update(
                [
                    'subscribed' => false,
                    'required_reactivation' => false
                ]
            );

            $ret = $user->delete();

            if($ret){
                $error = false;
                $msg = 'User unsubscribed.';
            }else{
                $error = true;
                $msg = 'User not unsubscribed. Something went wrong.';
            }

        }else{
            $error = true;
            $msg = 'User not found.';
        }

        return [
            "error" => $error,
            "msg" => $msg
        ];
    }
}
