
<?php 
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wpsdSyleSettings );
foreach ( $wpsdSyleSettings as $option_name => $option_value ) {
    if ( isset( $wpsdSyleSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
<form name="wpsd-form-style-settings" role="form" class="form-horizontal" method="post" action="" id="wpsd-form-style-settings-id">
    <?php 
wp_nonce_field( 'wpsd_template_style_action', 'wpsd_template_style_nonce_field' );
?>
    <table class="wpsd-form-style-settings">
        <!-- Form Container -->
        <tr>
            <th scope="row" colspan="6" style="font-size: 15px;">
                <?php 
_e( 'Form Container', 'wp-stripe-donation' );
?>&nbsp;::
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Border Width', 'wp-stripe-donation' );
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
                <label><?php 
_e( 'Border Color', 'wp-stripe-donation' );
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
                <label><?php 
_e( 'Border Radius', 'wp-stripe-donation' );
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
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Padding', 'wp-stripe-donation' );
?></label>
            </th>
            <td colspan="5">
                <input type="number" min="0" max='50' step="1" name="wpsd_form_padding_top" value="<?php 
esc_attr_e( $wpsd_form_padding_top );
?>" style="width:60px;" >
                <code><?php 
_e( 'top', 'wp-stripe-donation' );
?></code>
                <input type="number" min="0" max='30' step="1" name="wpsd_form_padding_right" value="<?php 
esc_attr_e( $wpsd_form_padding_right );
?>" style="width:60px;" >
                <code><?php 
_e( 'right', 'wp-stripe-donation' );
?></code>
                <input type="number" min="0" max='50' step="1" name="wpsd_form_padding_bottom" value="<?php 
esc_attr_e( $wpsd_form_padding_bottom );
?>" style="width:60px;" >
                <code><?php 
_e( 'bottom', 'wp-stripe-donation' );
?></code>
                <input type="number" min="0" max='30' step="1" name="wpsd_form_padding_left" value="<?php 
esc_attr_e( $wpsd_form_padding_left );
?>" style="width:60px;" >
                <code><?php 
_e( 'left', 'wp-stripe-donation' );
?></code>
                <code>( <?php 
_e( 'px', 'wp-stripe-donation' );
?> )</code>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Background Color', 'wp-stripe-donation' );
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
                <label><?php 
_e( 'Font Color', 'wp-stripe-donation' );
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
        <!-- Amounts -->
        <tr>
            <th scope="row" colspan="6" style="font-size: 15px;">
                <?php 
_e( 'Amounts', 'wp-stripe-donation' );
?>&nbsp;::
            </th>
        </tr>
        <tr class="wpsd_form_amount_bg_color">
            <th scope="row">
                <label><?php 
_e( 'Background Color', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input class="wbg-wp-color" type="text" name="wpsd_form_amount_bg_color" id="wpsd_form_amount_bg_color" value="<?php 
esc_attr_e( $wpsd_form_amount_bg_color );
?>">
                <div id="colorpicker"></div>
            </td>
            <th scope="row">
                <label><?php 
_e( 'Border Color', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input class="wbg-wp-color" type="text" name="wpsd_form_amount_border_color" id="wpsd_form_amount_border_color" value="<?php 
esc_attr_e( $wpsd_form_amount_border_color );
?>">
                <div id="colorpicker"></div>
            </td>
            <th scope="row">
                <label><?php 
_e( 'Font Color', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input class="wbg-wp-color" type="text" name="wpsd_form_amount_font_color" id="wpsd_form_amount_font_color" value="<?php 
esc_attr_e( $wpsd_form_amount_font_color );
?>">
                <div id="colorpicker"></div>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Font Size', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input type="number" min="10" max='30' step="1" name="wpsd_form_amount_font_size" value="<?php 
esc_attr_e( $wpsd_form_amount_font_size );
?>" >
                <code><?php 
_e( 'px', 'wp-stripe-donation' );
?></code>
            </td>
            <th scope="row">
                <label><?php 
_e( 'Border Width', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input type="number" min="0" max='10' step="1" name="wpsd_form_amount_border_width" value="<?php 
esc_attr_e( $wpsd_form_amount_border_width );
?>" >
                <code><?php 
_e( 'px', 'wp-stripe-donation' );
?></code>
            </td>
            <th scope="row">
                <label><?php 
_e( 'Border Radius', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input type="number" min="0" max='30' step="1" name="wpsd_form_amount_border_radius" value="<?php 
esc_attr_e( $wpsd_form_amount_border_radius );
?>" >
                <code><?php 
_e( 'px', 'wp-stripe-donation' );
?></code>
            </td>
        </tr>
        <!-- Amounts Hover -->
        <tr>
            <th scope="row" colspan="6" style="font-size: 15px;">
                <?php 
_e( 'Amounts Hover', 'wp-stripe-donation' );
?>&nbsp;::
            </th>
        </tr>
        <tr class="wpsd_form_amount_bg_color">
            <th scope="row">
                <label><?php 
_e( 'Background Color', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input class="wbg-wp-color" type="text" name="wpsd_form_amount_bg_color_hvr" id="wpsd_form_amount_bg_color_hvr" value="<?php 
esc_attr_e( $wpsd_form_amount_bg_color_hvr );
?>">
                <div id="colorpicker"></div>
            </td>
            <th scope="row">
                <label><?php 
_e( 'Border Color', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input class="wbg-wp-color" type="text" name="wpsd_form_amount_border_color_hvr" id="wpsd_form_amount_border_color_hvr" value="<?php 
esc_attr_e( $wpsd_form_amount_border_color_hvr );
?>">
                <div id="colorpicker"></div>
            </td>
            <th scope="row">
                <label><?php 
_e( 'Font Color', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input class="wbg-wp-color" type="text" name="wpsd_form_amount_font_color_hvr" id="wpsd_form_amount_font_color_hvr" value="<?php 
esc_attr_e( $wpsd_form_amount_font_color_hvr );
?>">
                <div id="colorpicker"></div>
            </td>
        </tr>
        <!-- Input Fields -->
        <tr>
            <th scope="row" colspan="6" style="font-size: 15px;">
                <?php 
_e( 'Input Fields', 'wp-stripe-donation' );
?>&nbsp;::
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Border Width', 'wp-stripe-donation' );
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
                <label><?php 
_e( 'Border Color', 'wp-stripe-donation' );
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
                <label><?php 
_e( 'Border Radius', 'wp-stripe-donation' );
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
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Padding', 'wp-stripe-donation' );
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
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Background Color', 'wp-stripe-donation' );
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
                <label><?php 
_e( 'Font Color', 'wp-stripe-donation' );
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
                <label><?php 
_e( 'Font Size', 'wp-stripe-donation' );
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
        </tr>
        <!-- Submit Button -->
        <tr>
            <th scope="row" colspan="6" style="font-size: 15px;">
                <?php 
_e( 'Submit Button', 'wp-stripe-donation' );
?>&nbsp;::
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Background Color', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input class="wbg-wp-color" type="text" name="wpsd_button_bg_color" id="wpsd_button_bg_color" value="<?php 
esc_attr_e( $wpsd_button_bg_color );
?>">
                <div id="colorpicker"></div>
            </td>
            <th scope="row">
                <label><?php 
_e( 'Font Color', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input class="wbg-wp-color" type="text" name="wpsd_button_font_color" id="wpsd_button_font_color" value="<?php 
esc_attr_e( $wpsd_button_font_color );
?>">
                <div id="colorpicker"></div>
            </td>
            <th scope="row">
                <label><?php 
_e( 'Font Size', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input type="number" min="0" max='50' step="1" name="wpsd_form_btn_font_size" value="<?php 
esc_attr_e( $wpsd_form_btn_font_size );
?>" >
                <code>px</code>
            </td>
        </tr>
        <!-- Submit Button Hover -->
        <tr>
            <th scope="row" colspan="6" style="font-size: 15px;">
                <?php 
_e( 'Submit Button Hover', 'wp-stripe-donation' );
?>&nbsp;::
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Background Color', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input class="wbg-wp-color" type="text" name="wpsd_button_bg_color_hover" id="wpsd_button_bg_color_hover" value="<?php 
esc_attr_e( $wpsd_button_bg_color_hover );
?>">
                <div id="colorpicker"></div>
            </td>
            <th scope="row">
                <label><?php 
_e( 'Font Color', 'wp-stripe-donation' );
?></label>
            </th>
            <td>
                <input class="wbg-wp-color" type="text" name="wpsd_button_font_color_hover" id="wpsd_button_font_color_hover" value="<?php 
esc_attr_e( $wpsd_button_font_color_hover );
?>">
                <div id="colorpicker"></div>
            </td>
        </tr>
    </table>
    <hr>
    <p class="submit">
        <button id="updateStyle" name="updateStyle" class="button button-primary wpsd-button">
            <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;<?php 
_e( 'Save Settings', 'wp-stripe-donation' );
?>
        </button>
    </p>
</form>