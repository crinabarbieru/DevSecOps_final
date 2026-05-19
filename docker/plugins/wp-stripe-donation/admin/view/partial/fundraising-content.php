<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$wpsdContentSettings = $this->wpsd_get_fundraising_content_settings();
//print_r( $wpsdContentSettings );
foreach ( $wpsdContentSettings as $option_name => $option_value ) {
    if ( isset( $wpsdContentSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
    <span><?php 
echo '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Upgrade to Professional!', WPSD_TXT_DOMAIN ) . '</a>';
?></span>
    