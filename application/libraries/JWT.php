<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class JWT_lib {

    private $secret_key = "YOUR_SECRET_KEY";  // Set your secret key

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Generate a JWT token
     *
     * @param array $data
     * @return string
     */
    public function generate_token($data) {
        $token = array(
            "iss" => "impactmindz.in",
            "aud" => "impactmindz.in",
            "iat" => time(),
            "nbf" => time(),
            "data" => $data
        );

        return JWT::encode($token, $this->secret_key);
    }

    /**
     * Decode a JWT token
     *
     * @param string $token
     * @return object
     */
    public function decode_token($token) {
        return JWT::decode($token, $this->secret_key, array('HS256'));
    }

    /**
     * Validate the JWT token from the Authorization header
     *
     * @return array
     */
    public function validate_token() {
        $authHeader = $this->CI->input->get_request_header('Authorization');

        if ($authHeader) {
            $arr = explode(" ", $authHeader);
            $token = $arr[1];

            try {
                $decoded = $this->decode_token($token);
                return array(
                    "status" => true,
                    "data" => $decoded
                );
            } catch (Exception $e) {
                return array(
                    "status" => false,
                    "message" => "Token is invalid",
                    "error" => $e->getMessage()
                );
            }
        } else {
            return array(
                "status" => false,
                "message" => "Authorization header not found"
            );
        }
    }
}
