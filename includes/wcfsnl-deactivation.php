<?php
class WCFSNL_DEACTIVATION {
    public function __construct() {
        $this->db_delete_option();
    }

    private function db_delete_option() {
        // Delete records in {prefix}_options, no use on keeping after deactivation
        delete_option( 'wcfsnl_api_key');
        delete_option( 'wcfsnl_api_user');
    }

}

if ( class_exists( 'WCFSNL_DEACTIVATION' ) ) {
    new WCFSNL_DEACTIVATION;
}