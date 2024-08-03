<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

function generate_jwt($data) {
    $CI =& get_instance();
    $CI->load->config('jwt'); // Load config file
    $key = $CI->config->item('jwt_key'); // Retrieve secret key from config
    $issuer = $CI->config->item('jwt_issuer'); // Retrieve issuer from config
    $audience = $CI->config->item('jwt_audience'); // Retrieve audience from config

    $payload = array(
        "iss" => $issuer,
        "aud" => $audience,
        "iat" => time(),
        "nbf" => time() + 10,
        "data" => $data
    );

    $jwt = JWT::encode($payload, $key);
    return $jwt;
}

function validate_jwt($jwt) {
    $CI =& get_instance();
    $CI->load->config('jwt'); // Load config file
    $key = $CI->config->item('jwt_key'); // Retrieve secret key from config

    try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        return (array) $decoded->data;
    } catch (Exception $e) {
        return false;
    }
}
