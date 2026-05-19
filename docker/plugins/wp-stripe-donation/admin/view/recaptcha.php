<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$wpsdNotice = false;
if ( isset( $_POST['saveSettings'] ) ) {
    if ( !isset( $_POST['wpsd_recaptcha_settings_nonce_field'] ) || !wp_verify_nonce( $_POST['wpsd_recaptcha_settings_nonce_field'], 'wpsd_recaptcha_settings_action' ) ) {
        print 'Sorry, your nonce did not verify.';
        exit;
    } else {
        $wpsd_recaptcha_Settings = array(
            'wpsd_enable_recaptcha'     => ( isset( $_POST['wpsd_enable_recaptcha'] ) ? sanitize_text_field( $_POST['wpsd_enable_recaptcha'] ) : 'off' ),
            'wpsd_recaptcha_site_key'   => ( isset( $_POST['wpsd_recaptcha_site_key'] ) ? sanitize_text_field( $_POST['wpsd_recaptcha_site_key'] ) : '' ),
            'wpsd_recaptcha_secret_key' => ( isset( $_POST['wpsd_recaptcha_secret_key'] ) ? sanitize_text_field( $_POST['wpsd_recaptcha_secret_key'] ) : '' ),
        );
        $wpsdKeyShowMessage = update_option( 'wpsd_recaptcha_Settings', $wpsd_recaptcha_Settings );
    }
}
$wpsdKeySettings = get_option( 'wpsd_recaptcha_Settings' );
$wpsd_enable_recaptcha = ( isset( $wpsdKeySettings['wpsd_enable_recaptcha'] ) ? esc_html( $wpsdKeySettings['wpsd_enable_recaptcha'] ) : 'off' );
$wpsd_recaptcha_site_key = ( isset( $wpsdKeySettings['wpsd_recaptcha_site_key'] ) ? esc_html( $wpsdKeySettings['wpsd_recaptcha_site_key'] ) : '' );
$wpsd_recaptcha_secret_key = ( isset( $wpsdKeySettings['wpsd_recaptcha_secret_key'] ) ? esc_html( $wpsdKeySettings['wpsd_recaptcha_secret_key'] ) : '' );
?>
<div id="wpsd-wrap-all" class="wrap wpsd-recaptcha-settings">

    <div class="settings-banner">
        <h2><i class="fa-solid fa-robot"></i>&nbsp;<?php 
_e( 'Google reCaptcha Settings', 'wp-stripe-donation' );
?></h2>
    </div>

    <?php 
if ( $wpsdNotice ) {
    $this->wpsd_display_notification( 'success', 'Your information updated successfully.' );
}
?>

    <div class="wpsd-wrap">

        <div class="wpsd_personal_wrap wpsd_personal_help" style="width: 75%; float: left;">

            <?php 
?>
                <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Upgrade to Professional!', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
                <?php 
?>
        </div>

        <?php 
$this->wpsd_admin_sidebar();
?>

    </div>
</div>