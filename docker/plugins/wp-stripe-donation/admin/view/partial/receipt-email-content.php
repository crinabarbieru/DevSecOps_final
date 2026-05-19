<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wpsdEmailSettings );
foreach ( $wpsdEmailSettings as $option_name => $option_value ) {
    if ( isset( $wpsdEmailSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
<form name="wpsd-email-settings-form" role="form" class="form-horizontal" method="post" action="" id="wpsd-settings-form-id">
    <?php 
wp_nonce_field( 'wpsd_email_content_action', 'wpsd_email_content_nonce_field' );
?>
    <table class="wpsd-email-content-settings-table">
        <!-- Subject -->
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Subject', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <input type="text" name="wpsd_re_email_subject" class="regular-text" value="<?php 
esc_attr_e( $wpsd_re_email_subject );
?>" />
                <br>
                <code><?php 
_e( 'We received your payment', WPSD_TXT_DOMAIN );
?>!</code>
            </td>
        </tr>
        <!-- Heading -->
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Heading', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <input type="text" name="wpsd_re_email_heading" class="regular-text" value="<?php 
esc_attr_e( $wpsd_re_email_heading );
?>" />
                <br>
                <code><?php 
_e( 'Receipt from Your Orginazation Name', WPSD_TXT_DOMAIN );
?></code>
            </td>
        </tr>
        <!-- Greeting Message -->
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Greeting Message', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <textarea class="regular-text" readonly><?php 
esc_html_e( strip_tags( $wpsd_re_email_greeting ) );
?></textarea>
                    <br>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Upgrade to professional!', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
                    <?php 
?>
                <br>
                <code><?php 
_e( 'The message you want to say after donor name. e.g. Thank you for your payment.', WPSD_TXT_DOMAIN );
?></code>
                <br>
                <code><?php 
_e( 'To use donor name apply #donorName# in the content', 'jobwp' );
?>.</code>
                <br>
                <code><?php 
_e( 'To use amount apply #donationAmount# in the content', 'jobwp' );
?>.</code>
            </td>
        </tr>
        <!-- Hide Footnote -->
        <tr>
            <th scope="row">
                <label for="wpsd_hide_receipt_footnote"><?php 
_e( 'Hide Footnote', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <input type="checkbox" name="wpsd_hide_receipt_footnote" class="wpsd_hide_receipt_footnote" id="wpsd_hide_receipt_footnote" value="1" <?php 
checked( $wpsd_hide_receipt_footnote, 1 );
?> > 
            </td>
        </tr>
        <!-- Footnote -->
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Footnote', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <textarea name="wpsd_re_email_footnote" class="regular-text"><?php 
esc_html_e( $wpsd_re_email_footnote );
?></textarea>
                <br>
                <code><?php 
_e( 'If you have any question, please reply this email.', WPSD_TXT_DOMAIN );
?></code>
            </td>
        </tr>
        <!-- Plugin Receipt Email -->
        <tr>
            <th scope="row">
                <label for="wpsd_disable_receipt_email"><?php 
_e( 'Disable Plugin Receipt Email', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <input type="checkbox">
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- Stripe Receipt Email -->
        <tr>
            <th scope="row">
                <label for="wpsd_disable_stripe_receipt_email"><?php 
_e( 'Disable Stripe Receipt Email', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <input type="checkbox">
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- From Name -->
        <tr>
            <th scope="row">
                <label><?php 
_e( 'From Name', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <input type="text" class="regular-text" value="<?php 
esc_attr_e( $wpsd_re_from_name );
?>" readonly>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- From Email -->
        <tr>
            <th scope="row">
                <label><?php 
_e( 'From Email', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <input type="text" class="regular-text" value="<?php 
esc_attr_e( $wpsd_re_from_email );
?>" readonly>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- Display Logo -->
        <tr>
            <th scope="row">
                <label for="wpsd_display_receipt_logo"><?php 
_e( 'Display Receipt Logo', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <tr>
            <th scope="row"">
                <label><?php 
_e( 'Select Receipt Logo', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
    </table>
    <hr>
    <p class="submit">
        <button id="updateEmailSettings" name="updateEmailSettings" class="button button-primary wpsd-button">
            <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;<?php 
_e( 'Save Settings', WPSD_TXT_DOMAIN );
?>
        </button>
    </p>
</form>