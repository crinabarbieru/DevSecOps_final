<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<style type="text/css">
    .wpsd-modern-wrapper {
        width: 100%;
        min-height: 100px;
        display: grid;
        column-gap: 20px;
        grid-template-columns: 50% auto;
        padding: 10px;
    }

    .wpsd-modern-wrapper > .modern-left,
    .wpsd-modern-wrapper > .modern-right {
        min-height: 100px;
        display: block;
        border-radius: <?php esc_attr_e( $wpsd_form_radius ); ?>px;
        overflow: hidden;
        background: <?php esc_attr_e( $wpsd_form_bg_color ); ?>;
        border: 1px solid <?php esc_attr_e( $wpsd_form_border_color ); ?>;
        box-shadow: 0px 2px 2px rgba(47, 47, 55, 0.25);
        color: <?php esc_attr_e( $wpsd_form_font_color ); ?>;
    }
    .wpsd-modern-wrapper > .modern-left .img-container {
        min-height: 100px;
        height: 250px;
        max-height: 250px;
        display: block;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        width: 100%;
    }

    .wpsd-modern-wrapper > .modern-left .img-container img {
        width: 100%;
        height: 100%;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        top: 0;
        left: 0;
        -webkit-transition: all .5s;
        -moz-transition: all .5s;
        -o-transition: all .5s;
        transition: all .5s;
    }

    .wpsd-modern-wrapper > .modern-left .img-container:hover img {
        -ms-transform: scale(1.2);
        -moz-transform: scale(1.2);
        -webkit-transform: scale(1.2);
        -o-transform: scale(1.2);
        transform: scale(1.2);
    }

    .wpsd-modern-wrapper > .modern-left .info-container {
        min-height: 10px;
        display: block;
        width: 100%;
        padding: 15px 25px;
    }
    .wpsd-modern-wrapper > .modern-left .info-container .form-title {
        margin: 0;
        padding: 0;
        font-size: 20px;
        line-height: 30px;
        color: <?php esc_attr_e( $wpsd_form_font_color ); ?>;
    }
    .wpsd-modern-wrapper > .modern-left .info-container .form-title-border {
        height: 4px;
        width: 150px;
        margin: 10px 0 20px 0;
        background-color: #24B47E;
        border-radius: 4px;
    }
    .wpsd-modern-wrapper > .modern-left .info-container .form-description,
    .wpsd-modern-wrapper > .modern-left .info-container .form-description p {
        margin: 0;
        padding: 0;
        font-size: 16px;
        line-height: 26px;
    }

    .wpsd-modern-wrapper > .modern-right {
        padding: 30px;
        position: relative;
        text-align: center;
    }

    /** amount label */
    .wpsd-modern-wrapper > .modern-right ul#wpsd_donate_amount li.amount,
    .wpsd-modern-wrapper > .modern-right ul#wpsd_donate_amount li.wpsd_donate_amount_other_li,
    .wpsd-address-country .selectize-input {
        border: <?php esc_html_e( $wpsd_form_input_border_width ); ?>px solid <?php esc_html_e( $wpsd_form_input_border_color ); ?>;
        background-color: <?php esc_html_e( $wpsd_form_input_bg_color ); ?>;
        color: <?php esc_html_e( $wpsd_form_input_font_color ); ?>;
    }
    .wpsd-modern-wrapper > .modern-right #wpsd-donation-form-id #wpsd_donate_other_amount {
        background-color: <?php esc_html_e( $wpsd_form_input_bg_color ); ?>;
    }
    .wpsd-modern-wrapper > .modern-right ul#wpsd_donate_amount li.amount:hover label,
    .wpsd-modern-wrapper > .modern-right ul#wpsd_donate_amount li.amount.active label {
        background: <?php esc_html_e( $wpsd_form_input_font_color ); ?>;
        color: <?php esc_html_e( $wpsd_form_input_bg_color ); ?>;
    }
    .wpsd-modern-wrapper > .modern-right ul#wpsd_donate_amount li.amount label {
        color: <?php esc_html_e( $wpsd_form_input_font_color ); ?>;
    }

    .wpsd-modern-wrapper > .modern-right .wpsd-text-field,
    #card-element {
        background-color: <?php esc_html_e( $wpsd_form_input_bg_color ); ?>;
        border: <?php esc_html_e( $wpsd_form_input_border_width ); ?>px solid <?php esc_html_e( $wpsd_form_input_border_color ); ?>;
        border-radius: <?php esc_html_e( $wpsd_form_input_border_radius ); ?>px;
        padding: <?php esc_html_e( $wpsd_form_input_padding_top ); ?>px <?php esc_html_e( $wpsd_form_input_padding_right ); ?>px <?php esc_html_e( $wpsd_form_input_padding_bottom ); ?>px <?php esc_html_e( $wpsd_form_input_padding_left ); ?>px;
        color: <?php esc_html_e( $wpsd_form_input_font_color ); ?>;
        font-size: <?php esc_html_e( $wpsd_form_input_font_size ); ?>px;
    }
    .ElementsApp input {
        font-size: <?php esc_html_e( $wpsd_form_input_font_size ); ?>px!important;
    }
    .wpsd-modern-wrapper > .modern-right .wpsd-text-field::placeholder,
    .wpsd-modern-wrapper > .modern-right .wpsd_donate_other_amount::placeholder,
    .selectize-dropdown [data-selectable].option,
    .selectize-input > input { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: <?php esc_html_e( $wpsd_form_input_font_color ); ?>!important;
        opacity: 1; /* Firefox */
    }
    .wpsd-modern-wrapper > .modern-right .wpsd-donate-button {
        width: <?php esc_html_e( $wpsd_form_button_width ); ?><?php esc_html_e( $wpsd_form_button_width_type ); ?> !important;
        background-color: <?php esc_html_e( $wpsd_button_bg_color ); ?> !important;
        color: <?php esc_html_e( $wpsd_button_font_color ); ?>!important;
        font-size: <?php esc_html_e( $wpsd_form_btn_font_size ); ?>px;
        line-height: <?php esc_html_e( $wpsd_form_btn_font_size + 10 ); ?>px;
    }
    .wpsd-modern-wrapper > .modern-right .wpsd-donate-button:hover {
        background: <?php esc_html_e( $wpsd_button_bg_color_hover ); ?>!important;
        color: <?php esc_html_e( $wpsd_button_font_color_hover ); ?>!important;
    }

    @media(max-width:767px) {
        .wpsd-modern-wrapper {
            display: block!important;
            padding: 0;
        }
        .wpsd-modern-wrapper > .modern-left .info-container,
        .wpsd-modern-wrapper > .modern-right {
            padding: 15px;
        }
        .wpsd-modern-wrapper > .modern-right {
            margin-top: 10px;
        }
    }
</style>