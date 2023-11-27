<?php
namespace Main\Includes;
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
        curl_setopt( $c_req, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec( $c_req );

        if ( empty( curl_error( $c_req ) ) && curl_getinfo( $c_req, CURLINFO_HTTP_CODE ) ) {
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
        curl_exec( $c_req );
        $response_code = curl_getinfo( $c_req, CURLINFO_HTTP_CODE );
        curl_close( $c_req );

        if ( $response_code == 200 ) {
            return true;
        } else {
            return false;
        }
    }

    public function create_customer( $customer_data ) {
        // TODO: Assign the necessary data from $customer_data to $customer
        // First check if customer already exists, if customer doesn't exist continue with function
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
        curl_exec( $c_req );
        curl_close( $c_req );
    }

    public function create_invoice( $order ) {
        // TODO: Get customer name from database as well
        $customer_data = array(
            'customer_id' => $order->customer_id,
            'billing' => $order->billing,
            'shipping' => $order->shipping
        );

        // Check if customer already exists or not, else create new customer first
         if ( $this->check_customer( $order->get_customer_id() ) == false ) {
            $this->create_customer( $customer_data );
        }

        // Invoice data
        $line_items = array();

        $invoice = array(
            'clientnr' => '',
            'reference' => array(
                'line1' => "",
                'line2' => "",
                'line3' => ""
            ),
            'lines' => '', // Array of arrays with item info
            'discount' => 0,
            'discounttype' => "",
            'action' => "send",
            'sendmethod' => "email"
        );

        $c_req = curl_init( "https://www.factuursturen.nl/api/v1/invoices" );
        curl_setopt( $c_req, CURLOPT_CUSTOMREQUEST, "POST" );
        curl_setopt( $c_req, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $c_req, CURLOPT_USERPWD, "$this->api_user:$this->api_key" );
        curl_setopt( $c_req, CURLOPT_POSTFIELDS, $invoice );
        $res = curl_exec( $c_req );

        curl_close( $c_req );
    }
}