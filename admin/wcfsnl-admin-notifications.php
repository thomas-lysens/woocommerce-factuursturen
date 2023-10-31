<?php
/*
 * Admin notifications for the plugin
 * All notification functions can be found here
 */

// Connection success
function connection_success_notification() {
   $notification = "<div class=\"notice notice-success is-dismissible\">".
   "<p>Connection was successful!</p>".
   "</div>";
   echo $notification;
}

// Connection failure
function connection_fail_notification() {
   $notification = "<div class=\"notice notice-error is-dismissible\">".
   "<p>Connection was not established! Check if the credentials you entered are correct and try again. If this problem persists, contact the developer of this plugin.</p>".
   "</div>";
   echo $notification;
}