<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Helpers\PayPal\CaptureIntent\CreateOrder;
use \App\Helpers\PayPal\Client;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

use \App\User;

class PayPalController extends Controller{
    public function index(Request $request){

        $user_id = $request['user_id'];
        $password = $request['password'];

        $user = User::withTrashed()->where(['id' => $user_id, 'password' => $password])->first();

        if($user){
            $createdOrder = CreateOrder::createOrder()->result;
            $response = Client::client()->execute(new OrdersGetRequest($createdOrder->id));

            $user->update(['order_id' => $response->result->id]);
            return json_encode($response->result);
        }else{
            return json_encode([
                "error" => true,
                "msg" => "User not found"
            ]);
        }
        
    }
}
