<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\URL;
use \App\Jobs\SendEmailJob;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withTrashed()->where('admin', false)->paginate(10);

        return UserResource::collection($users);
    }

    public function check(Request $request){
        $this->validate($request, [
            'email' => 'required|string|email|max:255'
        ]);

        $email = $request['email'];

        $user = User::withTrashed()->where('email', $email)->first();

        if($user){
            return $user;
        }else return [
            "status" => 0,
            "msg" => "User doesn't exist"
        ];
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

        $user = User::withTrashed()->where(['id' => $id])->first();

        if($user){

            if($user->trashed()){
                 
                $user->update(['required_reactivation' => true]);

                $emailParams = [
                    'mailto' => $user->email,
                    'bodyData' => [
                        'reactivateUrl' => URL::signedRoute('reactivate', ['id'=>$user->id])
                    ],
                    'viewName' => 'reactivate',
                    'subject' => 'Reactivate subscription'
                ];
                dispatch(new SendEmailJob($emailParams));

            }

        }
        
        return $user;
    }

    public function unsubscribe($id){

        $ret = User::where('id', $id)
          ->delete();

        return redirect('user/unsubscribed');

    }

    public function reactivate(Request $request, $id){

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

        return redirect('user/reactivated');
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
