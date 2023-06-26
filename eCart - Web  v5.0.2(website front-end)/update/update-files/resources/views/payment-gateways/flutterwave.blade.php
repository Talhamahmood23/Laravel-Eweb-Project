<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ Cache::get('app_name', get('name')) }}</title>
        <script src="https://checkout.flutterwave.com/v3.js"></script>
    </head>
    <body>
    </body>
    <script>
        FlutterwaveCheckout({
            public_key: "{{ $paymentMethods->flutterwave_public_key }}",
            tx_ref: "{{ round(microtime(true) * 1000).'Ref' }}",
            amount: {{ floatval($amount) }},
            currency: "{{ $paymentMethods->flutterwave_currency_code }}",
            payment_options: "card, mobilemoneyghana, ussd",
            redirect_url: "{{ route('payment-flutterwave-complete', ['type' => 'success']) }}",
            customer: {
              email: "{{ $loggedInUser['email'] }}",
              phone_number: "{{ $loggedInUser['mobile'] }}",
              name: "{{ $loggedInUser['name'] }}",
            },
            callback: function (data) {
              console.log(data);
            },
            onclose: function() {
              window.location.href = "{{ route('payment-flutterwave-complete', 'cancel') }}"
            },
            customizations: {
              title: "{{ Cache::get('app_name', get('name')) }}",
              description: "Towards Purchase From {{ Cache::get('app_name', get('name')) }}",
              logo: "{{ _asset(Cache::get('logo')) }}",
            },
        });
    </script>
</html>
