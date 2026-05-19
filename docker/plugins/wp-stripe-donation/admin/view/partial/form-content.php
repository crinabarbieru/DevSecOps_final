
<?php 
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wpsdContentSettings );
foreach ( $wpsdContentSettings as $option_name => $option_value ) {
    if ( isset( $wpsdContentSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
<form name="wpsd-temp-settings-form" role="form" class="form-horizontal" method="post" action="" id="wpsd-temp-settings-form-id">
    <?php 
wp_nonce_field( 'wpsd_template_content_action', 'wpsd_template_content_nonce_field' );
?>
    <table class="wpsd-form-content-settings">
        <!-- Template Color -->
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Template Color', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="5">
                <div class="wpsd-template-selector">
                    <?php 
for ($i = 0; $i < 5; $i++) {
    ?>
                    <div class="wpsd-template-item">
                        <input type="radio" name="wpsd_select_template" id="<?php 
    printf( 'wpsd_select_template_%d', $i );
    ?>" value="<?php 
    printf( '%d', $i );
    ?>"
                            <?php 
    if ( $wpsd_select_template == $i ) {
        echo 'checked';
    }
    ?>>
                        <label for="<?php 
    printf( 'wpsd_select_template_%d', $i );
    ?>" class="wpsd-template-<?php 
    printf( '%d', $i );
    ?>"></label>
                    </div>
                    <?php 
}
?>
                </div>
            </td>
        </tr>
        <!-- Display Banner -->
        <tr>
            <th scope="row">
                <label for="wpsd_display_banner"><?php 
_e( 'Display Banner', 'wp-stripe-donation' );
?></label>
                <span class="dashicons dashicons-info-outline wpsd-admin-icon"></span>
                <img src="<?php 
echo esc_attr( WPSD_ASSETS . 'img/wpsd-display-banner.webp' );
?>" class="wpsd-admin-help-img">
            </th>
            <td>
                <input type="checkbox" name="wpsd_display_banner" class="wpsd_display_banner" id="wpsd_display_banner" value="1" <?php 
echo ( $wpsd_display_banner ? 'checked' : '' );
?> >
            </td>
            <th scope="row" style="text-align: right;">
                <label><?php 
_e( 'Banner', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="3">
                <input type="hidden" name="wpsd_form_banner" id="wpsd_form_banner" value="<?php 
esc_attr_e( $wpsd_form_banner );
?>" class="regular-text" />
                <input type='button' class="button-primary" value="<?php 
esc_attr_e( 'Select a banner', 'wp-stripe-donation' );
?>" id="wpsd_media_manager" data-image-type="full" />
                <?php 
$wpsdFormBannerImage = '';
if ( intval( $wpsd_form_banner ) > 0 ) {
    $wpsdFormBannerImage = wp_get_attachment_image(
        $wpsd_form_banner,
        'full',
        false,
        array(
            'id' => 'wpsd-form-banner-preview-image',
        )
    );
}
?>
                <div id="wpsd-form-banner-preview-image">
                    <?php 
echo $wpsdFormBannerImage;
?>
                </div>
            </td>
        </tr>
        <!-- Hide All Form Label -->
        <tr>
            <th scope="row">
                <label for="wpsd_hide_label"><?php 
_e( 'Hide All Form Label', 'wp-stripe-donation' );
?></label>
                <span class="dashicons dashicons-info-outline wpsd-admin-icon"></span>
                <img src="<?php 
echo esc_attr( WPSD_ASSETS . 'img/wpsd-form-label.webp' );
?>" class="wpsd-admin-help-img">
            </th>
            <td colspan="5">
                <input type="checkbox" name="wpsd_hide_label" id="wpsd_hide_label" value="1" <?php 
echo ( $wpsd_hide_label ? 'checked' : '' );
?> >
            </td>
        </tr>
        <!-- Hide Donation For -->
        <tr>
            <th scope="row">
                <label for="wpsd_hide_donation_for"><?php 
_e( 'Hide Donation For', 'wp-stripe-donation' );
?></label>
                <span class="dashicons dashicons-info-outline wpsd-admin-icon"></span>
                <img src="<?php 
echo esc_attr( WPSD_ASSETS . 'img/wpsd-donation-for-options.webp' );
?>" class="wpsd-admin-help-img">
                <br>
                <small><?php 
_e( 'If you hide this, please make sure you must have only one donation for available in general settings.', 'wp-stripe-donation' );
?></small>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
            <th scope="row" style="text-align: right;">
                <label><?php 
_e( 'Donate/Payment For Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="3">
                <input type="text" name="wpsd_donation_for_label" class="medium-text" placeholder="<?php 
esc_attr_e( 'Donation/Payment For', 'wp-stripe-donation' );
?>"
                    value="<?php 
esc_attr_e( $wpsd_donation_for_label );
?>">
            </td>
        </tr>
        <!-- Name/Email Label -->
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Name Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input type="text" name="wpsd_donator_name_label" class="medium-text" placeholder="<?php 
esc_attr_e( 'Full Name', 'wp-stripe-donation' );
?>"
                    value="<?php 
esc_attr_e( $wpsd_donator_name_label );
?>">
            </td>
            <th scope="row" style="text-align: right;">
                <label><?php 
_e( 'Email Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="3">
                <input type="text" name="wpsd_donator_email_label" class="medium-text" placeholder="<?php 
esc_attr_e( 'Email', 'wp-stripe-donation' );
?>"
                    value="<?php 
esc_attr_e( $wpsd_donator_email_label );
?>">
            </td>
        </tr>
        <!-- Display Address -->
        <tr>
            <th scope="row">
                <label for="wpsd_display_address"><?php 
_e( 'Display Address', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
            <th scope="row" style="text-align: right;">
                <label for="wpsd_address_required"><?php 
_e( 'Required', 'wp-stripe-donation' );
?>* ?</label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- Address Street Label -->
        <tr>
            <th scope="row">
                <label for="wpsd_show_captcha"><?php 
_e( 'Address Street Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
            <th scope="row" style="text-align: right;">
                <label for="wpsd_show_captcha"><?php 
_e( 'Address Line-2 Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- Address City Label -->
        <tr>
            <th scope="row">
                <label for="wpsd_show_captcha"><?php 
_e( 'Address City Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
            <th scope="row" style="text-align: right;">
                <label for="wpsd_show_captcha"><?php 
_e( 'Address State Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- Postal Code Label -->
        <tr>
            <th scope="row">
                <label for="wpsd_show_captcha"><?php 
_e( 'Postal Code Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="5">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- Country Label -->
        <tr>
            <th scope="row">
                <label for="wpsd_show_captcha"><?php 
_e( 'Country Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="5">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <tr class="wpsd_show_comments">
            <th scope="row">
                <label for="wpsd_show_comments"><?php 
_e( 'Show Comments', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
            <th scope="row" style="text-align: right;">
                <label><?php 
_e( 'Comments Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
            <th scope="row" style="text-align: right;">
                <label for="wpsd_comments_required"><?php 
_e( 'Required', 'wp-stripe-donation' );
?>* ?</label>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- Show Number Captcha -->
        <tr class="wpsd_show_captcha">
            <th scope="row">
                <label for="wpsd_show_captcha"><?php 
_e( 'Show Number Captcha', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                 <input type="checkbox" name="wpsd_show_captcha" id="wpsd_show_captcha" value="1" <?php 
echo ( $wpsd_show_captcha ? 'checked' : '' );
?>>
            </td>
            <th scope="row" style="text-align: right;">
                <label><?php 
_e( 'Captcha Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="3">
                <input type="text" name="wpsd_captcha_label" class="medium-text" placeholder="<?php 
esc_attr_e( $wpsd_captcha_label );
?>" value="<?php 
esc_attr_e( $wpsd_captcha_label );
?>">
            </td>
        </tr>
        <!-- Amount Label -->
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Amount Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="5">
                <input type="text" name="wpsd_donate_amount_label" class="medium-text" placeholder="<?php 
esc_attr_e( 'Amount', 'wp-stripe-donation' );
?>"
                    value="<?php 
esc_attr_e( $wpsd_donate_amount_label );
?>">
            </td>
        </tr>
        <!-- Other Amount Text -->
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Other Amount Text', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="5">
                <input type="text" name="wpsd_other_amount_text" class="medium-text" placeholder="<?php 
esc_attr_e( 'Other Amount', 'wp-stripe-donation' );
?>"
                    value="<?php 
esc_attr_e( $wpsd_other_amount_text );
?>">
            </td>
        </tr>
        <!-- Card Element Label -->
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Card Element Label', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="5">
                <input type="text" name="wpsd_card_element_label" class="medium-text" placeholder="<?php 
esc_attr_e( $wpsd_card_element_label );
?>"
                    value="<?php 
esc_attr_e( $wpsd_card_element_label );
?>">
            </td>
        </tr>
        <!-- Form Width -->
        <tr>
            <th scope="row">
                <label for="wpsd_form_width"><?php 
_e( 'Form Width', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="5">
                <input type="number" min="1" max="1000" step="1" name="wpsd_form_width" value="<?php 
esc_attr_e( $wpsd_form_width );
?>">
                <select name="wpsd_form_width_type" class="medium-text">
                    <option value="px" <?php 
echo ( 'ps' === $wpsd_form_width_type ? 'selected' : '' );
?> ><?php 
echo 'px';
?></option>
                    <option value="%" <?php 
echo ( '%' === $wpsd_form_width_type ? 'selected' : '' );
?> ><?php 
echo '%';
?></option>
                </select>
            </td>
        </tr>
        <!-- Form Header Type -->
        <tr>
            <th scope="row">
                <label for="wpsd_form_header_type"><?php 
_e( 'Form Header Type', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="5">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- Form Button Width -->
        <tr>
            <th scope="row">
                <label for="wpsd_form_button_width"><?php 
_e( 'Form Button Width', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="5">
                <input type="number" min="1" max="1000" step="1" name="wpsd_form_button_width" value="<?php 
esc_attr_e( $wpsd_form_button_width );
?>">
                <select name="wpsd_form_button_width_type" class="medium-text">
                    <option value="px" <?php 
echo ( 'ps' === $wpsd_form_button_width_type ? 'selected' : '' );
?> ><?php 
echo 'px';
?></option>
                    <option value="%" <?php 
echo ( '%' === $wpsd_form_button_width_type ? 'selected' : '' );
?> ><?php 
echo '%';
?></option>
                </select>
            </td>
        </tr>
        <!-- Display Total Donation Today -->
        <tr>
            <th scope="row">
                <label for="wpsd_display_total_donation"><?php 
_e( 'Display Total Donation Today', 'wp-stripe-donation' );
?></label>
                <span class="dashicons dashicons-info-outline wpsd-admin-icon"></span>
                <img src="<?php 
echo esc_attr( WPSD_ASSETS . 'img/wpsd-total-donation.webp' );
?>" class="wpsd-admin-help-img">
            </th>
            <td colspan="5">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- Display Condition 1 -->
        <tr>
            <th scope="row">
                <label for="wpsd_display_condition_one"><?php 
_e( 'Display Condition 1', 'wp-stripe-donation' );
?></label>
                <span class="dashicons dashicons-info-outline wpsd-admin-icon"></span>
                <img src="<?php 
echo esc_attr( WPSD_ASSETS . 'img/wpsd-condition-one.webp' );
?>" class="wpsd-admin-help-img">
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
            <th scope="row" style="text-align: right;">
                <label for="wpsd_condiiton_one_required"><?php 
_e( 'Required', 'wp-stripe-donation' );
?>* ?</label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Condition 1 Text', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="5">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <!-- Gift Aid -->
        <tr>
            <th scope="row">
                <label for="wpsd_display_gift_aid"><?php 
_e( 'Enable Gift Aid', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
            <th scope="row">
                <label for="wpsd_gift_aid_required"><?php 
_e( 'Required', 'wp-stripe-donation' );
?>* ?</label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wpsd_gift_aid_label_text"><?php 
_e( 'Gift Aid Text', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Available in Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
                    <?php 
?>
            </td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    <hr>
    <p class="submit">
        <button id="updateContent" name="updateContent" class="button button-primary wpsd-button">
            <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;<?php 
_e( 'Save Settings', 'wp-stripe-donation' );
?>
        </button>
    </p>
</form>