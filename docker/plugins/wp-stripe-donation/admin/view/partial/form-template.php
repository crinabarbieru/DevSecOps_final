<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form name="wpsd_form_template_form" role="form" class="form-horizontal" method="post" action="" id="wpsd-form-template-form">
<?php 
wp_nonce_field( 'wpsd_form_temp_settings_action', 'wpsd_form_temp_settings_nonce_field' );
?>
    <table class="wpsd-form-template-settings-table">
        <tr>
            <th scope="row" colspan="3">
                <span><?php 
_e( 'Select a Template', WPSD_TXT_DOMAIN );
?> :</span>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label for="wpsd_form_temp_classic"><?php 
_e( 'Classic', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td style="width: 50px;">
                <input type="radio" name="wpsd_form_template" id="wpsd_form_temp_classic" value="classic" <?php 
if ( 'classic' === $wpsd_form_template ) {
    echo 'checked';
}
?>>
            </td>
            <td style="background: #999;">
                <label for="wpsd_form_temp_classic" class="wpsd_form_temp_classic">
                    <img src="<?php 
echo esc_url( WPSD_ASSETS );
?>img/aidwp-temp-classic.webp" alt="<?php 
_e( 'Classic', WPSD_TXT_DOMAIN );
?>" height="300px">
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wpsd_form_temp_modern"><?php 
_e( 'Modern', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td style="width: 50px;">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Upgrade to Professional!', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
                    <?php 
?>
            </td>
            <td style="background: #999;">
                <label for="wpsd_form_temp_modern" class="wpsd_form_temp_modern">
                    <img src="<?php 
echo esc_url( WPSD_ASSETS );
?>img/aidwp-temp-modern.webp" alt="<?php 
_e( 'Modern', WPSD_TXT_DOMAIN );
?>" height="300px">
                </label>
            </td>
        </tr>
    </table>
    <p class="submit"><button id="updateFormTemplate" name="updateFormTemplate" class="button wpsd-button button-primary"><?php 
_e( 'Save Settings', WPSD_TXT_DOMAIN );
?></button></p>
</form>