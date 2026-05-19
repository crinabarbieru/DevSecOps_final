<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$wpsdFundRaisingStylesSettings = $this->wpsd_get_fund_raising_style_settings();
//print_r( $wpsdFundRaisingStylesSettings );
foreach ( $wpsdFundRaisingStylesSettings as $option_name => $option_value ) {
    if ( isset( $wpsdFundRaisingStylesSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Upgrade to Professional', 'wp-stripe-donation' ) . '</a>';
?></span>
    