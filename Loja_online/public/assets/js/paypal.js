paypal.Buttons({
    createOrder: function(data, actions) {
        const total = document.getElementById('total').innerText.replace(' Kz', '');
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: (total / 900).toFixed(2) // conversão Kz → USD
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            alert('Pagamento PayPal concluído por ' + details.payer.name.given_name);
            localStorage.removeItem('carrinho');
            window.location.href = 'sucesso.php';
        });
    }
}).render('#paypal-button-container');
