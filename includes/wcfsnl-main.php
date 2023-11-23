<?php
// TODO: Write a function to create an invoice
// Necessary for notifications
include plugin_dir_path( __DIR__ ) . 'admin/wcfsnl-admin-notifications.php';

class WCFSNL_MAIN {
    private $api_key = "";
    private $api_user = "";
    private $encoded_auth = "";

    public function __construct( $api_key, $api_user ) {
        $this->api_key = $api_key;
        $this->api_user = $api_user;
    }

    public function connection_test() {
        $c_req = curl_init( "https://www.factuursturen.nl/api/v1/clients" );
        curl_setopt( $c_req, CURLOPT_CUSTOMREQUEST, "GET" );
        curl_setopt( $c_req, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $c_req, CURLOPT_USERPWD, "$this->api_user:$this->api_key" );
        $res = curl_exec( $c_req );

        if ( empty( curl_error( $c_req ) ) ) {
            add_action( 'admin_notices', 'connection_success_notification' );
        } else {
            add_action( 'admin_notices', 'connection_fail_notification' );
        }

        curl_close( $c_req );
    }

    public function check_customer( $customer_id ) { 
        $c_req = curl_init( "https://www.factuursturen.nl/api/v1/clients/$customer_id" );
        curl_setopt( $c_req, CURLOPT_HEADER, true ); 
        curl_setopt( $c_req, CURLOPT_CUSTOMREQUEST, "GET" );
        curl_setopt( $c_req, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $c_req, CURLOPT_USERPWD, "$this->api_user:$this->api_key" );
        curl_setopt( $c_req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $c_req, CURLOPT_HTTPHEADER, array (
            "Accept: application/json"
        ));
        $res = curl_exec( $c_req );
        $response_code = curl_getinfo( $c_req, CURLINFO_HTTP_CODE );
        curl_close( $c_req );

        if ( $response_code == 200 ) {
            return true;
        } else {
            return false;
        }
    }

    public function create_customer( $customer_data ) {
        // First check if customer already exists, if customer doesn't exist continue with function
        if ( $this->check_customer( $customer_data['id'] ) == false ) {
            $customer = array(
                'contact' => "",
                'showcontact' => true,
                'company' => "",
                'address' => "",
                'zipcode' => "",
                'city' => "",
                'country' => 0,
                'phone' => "",
                'mobile' => "",
                'email' => "",
                'bankcode' => "",
                'biccode' => "",
                'taxnumber' => "",
                'tax_shifted' => false,
                'sendmethod' => "email",
                'paymentmethod' => "",
                'top' => 0,
                'stddiscount' => 0,
                'mailintro' => "",
                'reference' => array(
                    'line1' => "",
                    'line2' => "",
                    'line3' => ""
                ),
                'notes' => "",
                'notes_on_invoice' => false,
                'active' => true,
                'default_doclang' => "nl",
                'email_reminder' => "",
                'currency' => 'USD',
                'tax_type' => ""
            );
    
            $c_req = curl_init( "https://www.factuursturen.nl/api/v1/clients" );
            curl_setopt( $c_req, CURLOPT_CUSTOMREQUEST, "POST" );
            curl_setopt( $c_req, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
            curl_setopt( $c_req, CURLOPT_USERPWD, "$this->api_user:$this->api_key" );
            curl_setopt( $c_req, CURLOPT_POSTFIELDS, $customer );
            $res = curl_exec( $c_req );
            curl_close( $c_req );
        }
    }
}
$wcfsnl = "";
if ( class_exists( 'WCFSNL_MAIN' ) ) {
    $api_key = get_option( 'wcfsnl_api_key' );
    $api_user = get_option( 'wcfsnl_api_user' );
    $wcfsnl = new WCFSNL_MAIN( $api_key, $api_user );
}