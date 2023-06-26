<?php
include_once('../includes/crud.php');
include_once('../library/jwt.php');

function generate_token()
{
    $jwt = new JWT();
    $payload = [
        'iat' => time(),
        /* issued at time */
        'iss' => 'eKart',
        'exp' => time() + (30 * 60),
        /* expires after 1 minute */
        'sub' => 'eKart Authentication',
        'web' => '29260418',
        'cust' => '22015911',
        'admin' => '30288442'
    ];
    $token = $jwt::encode($payload, JWT_SECRET_KEY);
    return $token;
}
// generate_token();
// $token = generate_token();
// print_r($token);

function verify_token()
{
	return true;
}