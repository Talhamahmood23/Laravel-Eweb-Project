<html>
  <head>
    <center><h1>Please do not refresh this page...</h1></center>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    @php
    $paymentMethods = Cache::get('payment_methods');
    @endphp
   
    
      <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ $paymentMethods->midtrans_client_key }}"></script>
     
      
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
  </head>
 
  <body>
    <script type="text/javascript">
      // For example trigger on button clicked, or any time you need
     
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{ $token }}', {
          onSuccess: function(result){
            var orderId = '{{ $orderId }}';
            /* You may add your own implementation here */
            
            window.location.href = "{{ route('payment-midtrans-complete', $orderId ) }}?message=" + result.status_message + "&order_id=" + orderId + "&status_code=" + result.status_code + "&transaction_id=" + result.transaction_id + "&amount=" + result.gross_amount;
          },
          onPending: function(result){
            /* You may add your own implementation here */
            alert("wating your payment!"); console.log(result);
          },
          onError: function(result){
            /* You may add your own implementation here */
            alert("payment failed!"); console.log(result);
          },
          onClose: function(result){
              var orderId = '{{ $orderId }}';
            /* You may add your own implementation here */
            alert('you closed the popup without finishing the payment');
            window.location.href = "{{ route('payment-midtrans-cancel', 'cancel', $orderId ) }}?&order_id=" + orderId ;
            
          }
        })
     
    </script>
  </body>
</html>