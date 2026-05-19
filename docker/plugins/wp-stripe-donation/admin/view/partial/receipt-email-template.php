<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wpsdEmailTempSettings );
foreach ( $wpsdEmailTempSettings as $option_name => $option_value ) {
    if ( isset( $wpsdEmailTempSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
<form name="wpsd-email-temp-settings-form" role="form" class="form-horizontal" method="post" action="" id="wpsd-email-temp-settings-form-id">
    <?php 
wp_nonce_field( 'wpsd_email_temp_action', 'wpsd_email_temp_nonce_field' );
?>
    <table class="wpsd-email-temp-form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label><?php 
_e( 'Email Template', WPSD_TXT_DOMAIN );
?></label>
                </th>
                <td>
                    <input type="radio" name="wpsd_email_temp_layout" id="wpsd_email_temp_layout_default" value="default" <?php 
if ( 'default' === $wpsd_email_temp_layout ) {
    echo 'checked';
}
?>>
                    <label for="wpsd_email_temp_layout_default">
                        <img src="<?php 
echo esc_url( WPSD_ASSETS . 'img/receipt-temp/default.jpg' );
?>" alt="<?php 
_e( 'Default', WPSD_TXT_DOMAIN );
?>" width="400px">
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php 
?>
                        <input type="radio">
                        <?php 
?>
                    <label for="wpsd_email_temp_layout_html">
                        <img src="<?php 
echo esc_url( WPSD_ASSETS . 'img/receipt-temp/html.jpg' );
?>" alt="<?php 
_e( 'HTML', WPSD_TXT_DOMAIN );
?>" width="400px">
                    </label>
                    <?php 
?>
                        <br>
                        <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
                        <?php 
?>
                </td>
            </tr>
            <tr>
                <th scope="row">&nbsp;</th>
                <td>
                    <?php 
?>
                    <label for="wpsd_email_temp_layout_custom">
                        <img src="<?php 
echo esc_url( WPSD_ASSETS . 'img/receipt-temp/custom.webp' );
?>" alt="<?php 
_e( 'Customized', WPSD_TXT_DOMAIN );
?>" width="400px">
                    </label>
                    <?php 
?>
                        <br>
                        <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
                        <?php 
?>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    <p class="submit">
        <button id="updateEmailTempSettings" name="updateEmailTempSettings" class="button button-primary wpsd-button">
            <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;<?php 
_e( 'Save Settings', WPSD_TXT_DOMAIN );
?>
        </button>
    </p>
</form>