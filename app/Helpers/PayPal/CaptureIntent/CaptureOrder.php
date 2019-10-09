<?php

namespace App\Helpers\PayPal\CaptureIntent;

use \App\Helpers\PayPal\Client as PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class CaptureOrder {

    /**
     * This function can be used to capture an order payment by passing the approved
     * order id as argument.
     * 
     * @param orderId
     * @param debug
     * @returns
     */
    public static function captureOrder($orderId) {
        $request = new OrdersCaptureRequest($orderId);
        $client = PayPalClient::client();
        $response = $client->execute($request);
        return $response;
    }
}