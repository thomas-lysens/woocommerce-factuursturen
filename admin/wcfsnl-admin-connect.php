<?php
/* 
 * WooCommerce Factuursturen.nl connect page
 * This page contains the form (and functionality) to store the login credentials for the factuursturen API
 */
// Required files
require plugin_dir_path( __DIR__ ) . 'includes/wcfsnl-main.php';

if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
    $api_key = "";
    $api_user = "";

    if ( !empty( $_POST['api-key'] ) ) {
        $api_key = htmlspecialchars($_POST['api-key'], ENT_QUOTES );
        if ( !empty( $_POST['api-user'] ) ) {
            $api_user = htmlspecialchars( $_POST['api-user'], ENT_QUOTES);

            update_option( 'wcfsnl_api_key', $api_key);
            update_option( 'wcfsnl_api_user', $api_user);
        }
    }

    $wcfsnl->connection_test();
}

$placeholder_a = "";
$placeholder_b = "";

if ( get_option( 'wcfsnl_api_key' ) != "" && get_option( 'wcfsnl_api_user' ) != "" ) {
    $placeholder_a = get_option( 'wcfsnl_api_key' );
    $placeholder_b = get_option( 'wcfsnl_api_user' );
} 
?>
<div class="wrap">
    <h1>WooCommerce - Factuursturen.nl | Connect</h1>
    <div class="form-region">
        <form method="POST" action="#">
            <div class="fields">
                <div class="field-block">
                    <label for="api-key">API KEY</label>
                    <br/>
                    <input type="text" id="api-key" name="api-key" placeholder="<?php echo $placeholder_a; ?>">
                </div>
                <div class="field-block">
                    <label for="api-user">USER</label>
                    <br/>
                    <input type="text" id="api-user" name="api-user" placeholder="<?php echo $placeholder_b; ?>">
                </div>
                <div class="field-block">
                    <input type="submit" id="submit" value="Connect">
                </div>
            </div>
        </form>
    </div>
</div>