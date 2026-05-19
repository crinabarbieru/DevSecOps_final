<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$wpsdGeneralSettings = $this->wpsd_get_general_settings();
$wpsdFundraisingContentSettings = $this->wpsd_get_fundraising_content_settings();
$wpsdFundRaisingStylesSettings = $this->wpsd_get_fund_raising_style_settings();
$wpsdFormSettings = $this->wpsd_get_form_content_settings();
$wpsdFormSyleSettings = $this->wpsd_get_form_style_settings();
$wpsd_donation_today = $this->wpsd_get_total_donation_today();
// General Settings
foreach ( $wpsdGeneralSettings as $gs_name => $gs_value ) {
    if ( isset( $wpsdGeneralSettings[$gs_name] ) ) {
        ${"" . $gs_name} = $gs_value;
    }
}
// Fundraising Content Settings
foreach ( $wpsdFundraisingContentSettings as $fr_name => $fr_value ) {
    if ( isset( $wpsdFundraisingContentSettings[$fr_name] ) ) {
        ${"" . $fr_name} = $fr_value;
    }
}
// Fundraising Style Settings
foreach ( $wpsdFundRaisingStylesSettings as $frs_option_name => $frs_option_value ) {
    if ( isset( $wpsdFundRaisingStylesSettings[$frs_option_name] ) ) {
        ${"" . $frs_option_name} = $frs_option_value;
    }
}
// Form Settings
foreach ( $wpsdFormSettings as $form_name => $form_value ) {
    if ( isset( $wpsdFormSettings[$form_name] ) ) {
        ${"" . $form_name} = $form_value;
    }
}
// Form Styles Settings
foreach ( $wpsdFormSyleSettings as $fs_name => $fs_value ) {
    if ( isset( $wpsdFormSyleSettings[$fs_name] ) ) {
        ${"" . $fs_name} = $fs_value;
    }
}
// reCaptcha Settings
$wpsdKeySettings = get_option( 'wpsd_recaptcha_Settings' );
$wpsd_enable_recaptcha = ( isset( $wpsdKeySettings['wpsd_enable_recaptcha'] ) ? esc_html( $wpsdKeySettings['wpsd_enable_recaptcha'] ) : 'off' );
$wpsd_recaptcha_site_key = ( isset( $wpsdKeySettings['wpsd_recaptcha_site_key'] ) ? esc_html( $wpsdKeySettings['wpsd_recaptcha_site_key'] ) : '' );
$wpsd_amount = null;
if ( 'tdb' === $wpsd_form_header_type ) {
    $form_header_type = ['title', 'description', 'banner'];
} else {
    if ( 'btd' === $wpsd_form_header_type ) {
        $form_header_type = ['banner', 'title', 'description'];
    } else {
        $form_header_type = ['title', 'banner', 'description'];
    }
}
$wpsdCaptchaItem1 = rand( 1, 20 );
$wpsdCaptchaItem2 = rand( 1, 20 );
$currancy_symbol = $this->hm_get_currency_symbol( $wpsd_donate_currency );
$wpsd_donation_values = ( $wpsd_donation_values != '' ? explode( ',', rtrim( $wpsd_donation_values, ',' ) ) : [] );
// Loading Template
$template = get_option( 'hmls_form_temp_settings', 'classic' );
$template = ( isset( $attr['template'] ) ? $attr['template'] : $template );
include WPSD_PATH . 'assets/css/wpsd-front.php';