export default class PayPalIntegration{
    static render({
            container_id = "#paypal-button-container",
            onApprove = () => {},
            payload
        }){
        paypal.Buttons({
            createOrder: () => {
                return fetch('/api/paypal/order/create', {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    }
                }).then(function (res) {
                    return res.json();
                }).then(function (res) {
                    console.log(res);
                    if (res.error) {
                        console.log(res.msg);
                        return;
                    } else {
                        return res.id;
                    }
                });
            },
            onApprove: (data) => {
                return fetch('/api/paypal/order/capture', {
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        ...payload,
                        order_id: data.orderID
                    }),
                    method: 'post'
                }).then(res => res.json()).then(details => {
                    onApprove(details);
                });
                
            }
        }).render(container_id);
    }
}