<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ Cache::get('app_name', get('name')) }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >
        {{-- <script src="{{ theme('js/jquery-3.5.1.min.js') }}"></script>
        <script id="bolt" src="{{ $data['payment_url'] }}" bolt-color="e34524" bolt-logo="{{ asset('images/headerlogo.png') }}"></script> --}}
    </head>
    <body>
        <form action="https://test.payu.in/_payment" method="POST">
            <input type="hidden" name="key" id="key" value="{{ $data['key'] ?? '' }}">
            <input type="hidden" name="txnid" id="txnid" value="{{ $data['txnid'] ?? '' }}">
            <input type="hidden" name="hash" id="hash" value="{{ $data['hash'] ?? '' }}">
            <input type="hidden" name="amount" id="amount" value="{{ $data['amount'] ?? '' }}">
            <input type="hidden" name="firstname" id="fname" value="{{ $data['firstname'] ?? '' }}">
            <input type="hidden" name="email" id="email" value="{{ $data['email'] ?? '' }}">
            <input type="hidden" name="phone" id="phone" value="{{ $data['phone'] ?? '' }}">
            <input type="hidden" name="productinfo" id="pinfo" value="{{ $data['productinfo'] ?? '' }}">
            <input type="hidden" name="surl" id="surl" value="{{ $data['surl'] ?? '' }}">
            <input type="hidden" name="furl" id="furl" value="{{ $data['furl'] ?? ''}}">
            <script>
                "use strict";
            window.onload = function(){
                document.forms[0].submit();
            }
            </script>
        </form>
    </body>
    {{-- <script src="{{ asset('js/payment-gateway-payumoney.js') }}"></script> --}}
</html>