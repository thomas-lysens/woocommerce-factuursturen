<?php
class WCFSNL_ACTIVATION {
    public function __construct() {
        $this->db_register_option();
    }

    private function db_register_option() {
        // Create records in {prefix}_options to use for connection later
        if ( !get_option( 'wcfsnl_api_key' ) ) {
            add_option( 'wcfsnl_api_key', "" );
        }
        if ( !get_option( 'wcfsnl_api_user' ) ) {
            add_option( 'wcfsnl_api_user', "" );
        }
    }

}

if ( class_exists( 'WCFSNL_ACTIVATION' ) ) {
    new WCFSNL_ACTIVATION;
}