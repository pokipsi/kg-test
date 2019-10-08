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
                        id: 8,
                        password: "$2y$10$7D8tC0VhKLwNKL3gy/k7MOhliqbXH/4edE5TuquD8Q8sORInoPqCa"
                    }
                    paypal.Buttons({
                        createOrder: function() {
                            return fetch('/api/paypal/order/create', {
                                body: JSON.stringify({ 
                                    user_id: user.id,
                                    password: user.password
                                }),
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
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                                console.log(details);
                                alert('Transaction completed by ' + details.payer.name.given_name);
                                // Call your server to save the transaction
                            });
                        }
                    }).render('#paypal-button-container');
                </script>
            </div>
        </div>
    </body>
</html>
