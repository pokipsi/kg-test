<?php

namespace App\Helpers\PayPal;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class Client {

    public static function client(){
        return new PayPalHttpClient(self::environment());
    }

    private static function environment(){
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_SECRET');
        return new SandboxEnvironment($clientId, $clientSecret);
    }

}

