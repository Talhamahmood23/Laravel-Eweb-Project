<!DOCTYPE html>
<html lang="en">
  <head>
    <title>{{ Cache::get('app_name', get('name')) }}</title>
    <script src="https://js.paystack.co/v1/inline.js"></script>
  </head>
  <body></body>
  <script>
  let handler = PaystackPop.setup({
    key: '{{ $paymentMethods->paystack_public_key }}',
    email: "{{ $loggedInUser['email'] }}",
    amount: {{ floatval($amount) }},
    ref: "{{ round(microtime(true) * 1000).'Ref' }}",
    onClose: function(){
      window.location.href = "{{ route('payment-paystack-complete', 'cancel') }}";;
    },
    callback: function(response){
      window.location.href = "{{ route('payment-paystack-complete', 'success') }}?message=" + response.message + "&reference=" + response.reference + "&status=" + response.status + "&trans=" + response.trans + "&trxref=" + response.trxref;
    }
  });
  handler.openIframe();
  </script>
</html>
