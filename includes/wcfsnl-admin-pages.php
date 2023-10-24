<?php
/*
 * Load in all necessary admin pages
 */
function wcfsnl_admin_main_page() {
    $page = fn() => include plugin_dir_path( __DIR__ ) . 'admin/wcfsnl-admin-main.php';

    add_menu_page( 
        "WooCommerce Factuursturen.nl",
        "Factuursturen", 
        "manage_options",
        "wc-fsnl",
        $page, 
        "dashicons-media-default",
        58 
    );
}

add_action( 'admin_menu', 'wcfsnl_admin_main_page' );

function wcfsnl_admin_connect_page() {
    $page = fn() => include plugin_dir_path( __DIR__ ) . 'admin/wcfsnl-admin-connect.php';

    add_submenu_page( 
        "wc-fsnl", 
        "Connect", 
        "Connect",
        "manage_options",
        "wc-fsnl-connect",
        $page,
        1
    );
}

add_action( 'admin_menu', 'wcfsnl_admin_connect_page' );