<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <script
                    src="https://www.paypal.com/sdk/js?client-id=sb">
                </script>
                <div id="paypal-button-container"></div>
                <script>
                    //fetch user data from server
                    let user = {
                        email: "user123@gmail.com"
                    }
                    paypal.Buttons({
                        createOrder: function() {
                            return fetch('/api/paypal/order/create', {
                                method: 'post',
                                headers: {
                                    'content-type': 'application/json'
                                }
                            }).then(function(res) {
                                return res.json();
                            }).then(function(res){
                                console.log(res);
                                if(res.error){
                                    console.log(res.msg);
                                    return;
                                }else{
                                    return res.id;
                                }
                            });
                        },
                        onApprove: function(data) {
                            return fetch('/api/paypal/order/capture', {
                                headers: {
                                    'content-type': 'application/json'
                                },
                                body: JSON.stringify({
                                    email: user.email,
                                    order_id: data.orderID
                                }),
                                method: 'post'
                            }).then(function(res) {
                                return res.json();
                            }).then(function(details) {
                                console.log(details);
                            })
                        }
                    }).render('#paypal-button-container');
                </script>
            </div>
        </div>
    </body>
</html>

