<?php

namespace App\Helpers\PayPal\CaptureIntent;

use App\Helpers\PayPal\Client as PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Illuminate\Support\Facades\URL;

class CreateOrder
{
    
    /**
     * Setting up the JSON request body for creating the Order. The Intent in the
     * request body should be set as "CAPTURE" for capture intent flow.
     * 
     */
    private static function buildRequestBody() {

        $returnUrl = URL::signedRoute('paypal-return');
        $cancelUrl = URL::signedRoute('paypal-cancel');

        $amount = 0.01;

        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => $returnUrl,
                    'cancel_url' => $cancelUrl,
                    'brand_name' => 'KG Studio',
                    'locale' => 'en-US',
                    'landing_page' => 'BILLING',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                ),
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'reference_id' => 'PUHF',
                            'description' => 'Subscription',
                            'amount' =>
                                array(
                                    'currency_code' => 'USD',
                                    'value' => $amount,
                                    'breakdown' =>
                                        array(
                                            'item_total' =>
                                                array(
                                                    'currency_code' => 'USD',
                                                    'value' => $amount,
                                                )
                                        ),
                                ),
                            'items' =>
                                array(
                                    0 =>
                                        array(
                                            'name' => 'Subscription',
                                            'description' => 'Subscription to the quotes',
                                            'unit_amount' =>
                                                array(
                                                    'currency_code' => 'USD',
                                                    'value' => $amount,
                                                ),
                                            'quantity' => '1'
                                        ),
                                )
                        ),
                ),
        );
    }

    /**
     * This is the sample function which can be sued to create an order. It uses the
     * JSON body returned by buildRequestBody() to create an new Order.
     */
    public static function createOrder()
    {
        $request = new OrdersCreateRequest();
        $request->headers["prefer"] = "return=representation";
        $request->body = self::buildRequestBody();

        $client = PayPalClient::client();
        $response = $client->execute($request);

        return $response;
    }
}



