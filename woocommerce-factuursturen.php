<?php
/**
* Plugin Name: WooCommerce Factuursturen
* Plugin URI: https://github.com/thomas-lysens/woocommerce-factuursturen
* Description: A WooCommerce plugin to connect with Factuursturen.nl
* Version: 0.1.0
* Author: Thomas Lysens
* Author URI: https://github.com/thomas-lysens
* Developer: Thomas Lysens
* Developer URI: https://github.com/thomas-lysens
* Text Domain: woocommerce-extension
* Domain Path: /languages
*
* WC requires at least: 2.2
* WC tested up to: 2.3
*
* License: GNU General Public License v3.0
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/
// Plugin activation
function wcfsnl_activate() {

}

register_activation_hook( __FILE__, 'wcfsnl_activate' );

// Plugin deactivation
function wcfsnl_deactivate() {

}
register_deactivation_hook( __FILE__, 'wcfsnl_deactivate' );