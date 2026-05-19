<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<style type="text/css">
    /** Main Container */
    .wpsd-master-wrapper {
        width: <?php 
esc_html_e( $wpsd_form_width );
esc_html_e( $wpsd_form_width_type );
?> !important;
        padding: <?php 
esc_html_e( $wpsd_form_padding_top );
?>px <?php 
esc_html_e( $wpsd_form_padding_right );
?>px <?php 
esc_html_e( $wpsd_form_padding_bottom );
?>px <?php 
esc_html_e( $wpsd_form_padding_left );
?>px;
    }
    /** amount */
    .wpsd-amounts-wrapper button {
        background: <?php 
esc_html_e( $wpsd_form_amount_bg_color );
?>;
        border: <?php 
esc_html_e( $wpsd_form_amount_border_width );
?>px solid <?php 
esc_html_e( $wpsd_form_amount_border_color );
?>;
        color: <?php 
esc_html_e( $wpsd_form_amount_font_color );
?>;
        font-size: <?php 
esc_html_e( $wpsd_form_amount_font_size );
?>px;
        border-radius: <?php 
esc_html_e( $wpsd_form_amount_border_radius );
?>px;
    }
    .wpsd-amounts-wrapper button:hover,
    .wpsd-amounts-wrapper button.active {
        background: <?php 
esc_html_e( $wpsd_form_amount_bg_color_hvr );
?>;
        border-color: <?php 
esc_html_e( $wpsd_form_amount_border_color_hvr );
?>;
        color: <?php 
esc_html_e( $wpsd_form_amount_font_color_hvr );
?>;
    }
    /** Submit Button */
    .wpsd-master-wrapper .wpsd-wrapper-content .wpsd-donate-button {
        width: <?php 
esc_html_e( $wpsd_form_button_width );
esc_html_e( $wpsd_form_button_width_type );
?> !important;
        background-color: <?php 
esc_html_e( $wpsd_button_bg_color );
?> !important;
        color: <?php 
esc_html_e( $wpsd_button_font_color );
?>!important;
        font-size: <?php 
esc_html_e( $wpsd_form_btn_font_size );
?>px;
        line-height: <?php 
esc_html_e( $wpsd_form_btn_font_size + 10 );
?>px;
    }
    .wpsd-master-wrapper .wpsd-wrapper-content .wpsd-donate-button:hover {
        background: <?php 
esc_html_e( $wpsd_button_bg_color_hover );
?>!important;
        color: <?php 
esc_html_e( $wpsd_button_font_color_hover );
?>!important;
    }
</style>