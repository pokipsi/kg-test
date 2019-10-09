<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Helpers\PayPal\CaptureIntent\CreateOrder;
use \App\Helpers\PayPal\CaptureIntent\CaptureOrder;
use \App\Helpers\PayPal\Client;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use \App\Jobs\SendEmailJob;

use \App\User;

class PayPalController extends Controller{

    public function create(Request $request){
        $createdOrder = CreateOrder::createOrder()->result;
        $response = Client::client()->execute(new OrdersGetRequest($createdOrder->id));
        return json_encode($response->result);
    }

    public function capture(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'order_id' => 'required'
        ]);

        if ($validator->fails()) {
            return json_encode([
                'error' => true,
                'msg' => 'Validation fails',
                'errors' => $validator->errors()
            ]);
        }

        $email = $request['email'];
        $order_id = $request['order_id'];

        $user = User::withTrashed()->where(['email' => $email])->first();

        $capturedOrder = CaptureOrder::captureOrder($order_id);

        if($capturedOrder->result->status != 'COMPLETED'){
            return json_encode(['error' => true, 'msg' => 'Payment failed, order id: ' . $order_id]);
        }else{
            if($user){
                //user exists
                if($user->subscribed){
                    //user is subscribed
                    $ret = [
                        "error" => false,
                        "msg" => "Already subscribed",
                        "status" => 1
                    ];
                }else{
                    //user is not subscribed
                    $user->update(['subscribed' => true]);
                    if($user->trashed()){
                        $user->restore();
                    }
                    $ret = [
                        "error" => false,
                        "msg" => "User is subscribed",
                        "status" => 2
                    ];
                }
            }else{
                $user = User::create([
                    'email' => $email,
                    'password' => bcrypt('password'),
                    'subscribed' => true
                ]);

                $emailParams = [
                    'mailto' => $email,
                    'bodyData' => [
                        'unsubscribeUrl' => URL::signedRoute('unsubscribe', ['id'=>$user->id])
                    ],
                    'viewName' => 'welcome',
                    'subject' => 'Welcome'
                ];
                dispatch(new SendEmailJob($emailParams));

                $ret = [
                    "error" => false,
                    "msg" => "User is subscribed",
                    "status" => 2
                ];
            }
            return json_encode($ret);
        }
    }
}
