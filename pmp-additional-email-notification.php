<?php
/*
Plugin Name: PMP Additional Email Notification
Description: Adds an optional field in the settings for an additional email address and sends notifications to this address.
Version: 1.0
Author: Strong Anchor Tech
*/

// Add settings field for additional email address
function pmp_additional_email_setting() {
    add_settings_field(
        'pmp_additional_email',
        'Additional Notification Email',
        'pmp_additional_email_field_callback',
        'pmpro',
        'pmpro_email'
    );
    register_setting('pmpro_email', 'pmp_additional_email');
}
add_action('admin_init', 'pmp_additional_email_setting');

function pmp_additional_email_field_callback() {
    $additional_email = get_option('pmp_additional_email', '');
    echo '<input type="email" id="pmp_additional_email" name="pmp_additional_email" value="' . esc_attr($additional_email) . '" class="regular-text" />';
    echo '<p class="description">Enter an additional email address to receive notification emails.</p>';
}

// Hook into PMP email function
function pmp_send_additional_email($email) {
    $additional_email = get_option('pmp_additional_email', '');

    if (!empty($additional_email)) {
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($additional_email, $email->subject, $email->body, $headers);
    }

    return $email;
}
add_filter('pmpro_email_filter', 'pmp_send_additional_email');

?>
