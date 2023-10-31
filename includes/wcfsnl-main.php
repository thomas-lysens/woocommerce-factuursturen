<?php
class WCFSNL_MAIN {
    private $api_key = "";
    private $api_user = "";
    private $encoded_auth = "";

    public function __construct( $api_key, $api_user ) {
        $this->api_key = $api_key;
        $this->api_user = $api_user;
        $this->encoded_auth = base64_encode( "$this->api_user:$this->api_key" );
    }

    public function connection_test() {
        $c_req = curl_init();
        curl_setopt( $c_req, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $c_req, CURLOPT_USERPWD, $this->encoded_auth);
        $res = curl_exec( $c_req );
        curl_close( $c_req );

        if ( !empty( $res ) ) {
            echo "<h1>Success!</h1>";
        }
    }
}

if ( class_exists( 'WCFSNL_MAIN' ) ) {
    $api_key = get_option( 'wcfsnl_api_key' );
    $api_user = get_option( 'wcfsnl_api_user' );
    $connect = new WCFSNL_MAIN( $api_key, $api_user );
}