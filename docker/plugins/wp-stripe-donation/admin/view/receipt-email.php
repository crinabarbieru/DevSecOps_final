<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="wpsd-wrap-all" class="wrap wpsd-email-settings">

    <div class="settings-banner">
        <h2><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;<?php _e('Receipt Email Settings', WPSD_TXT_DOMAIN); ?></h2>
    </div>

    <?php 
        if ( $wpsdEmailShowMessage ) {
            $this->wpsd_display_notification('success', 'Your information updated successfully.'); 
        } 
    ?>

    <div class="wpsd-wrap">

        <nav class="nav-tab-wrapper">
            <a href="?page=wpsd-email-settings&tab=settings" class="nav-tab wsd-tab <?php if ( $tab != 'template' ) { ?>nav-tab-active<?php } ?>"><?php _e('Content', WPSD_TXT_DOMAIN); ?></a>
            <a href="?page=wpsd-email-settings&tab=template" class="nav-tab wsd-tab <?php if ( $tab === 'template' ) { ?>nav-tab-active<?php } ?>"><?php _e('Template', WPSD_TXT_DOMAIN); ?></a>
        </nav>

        <div class="wpsd_personal_wrap wpsd_personal_help" style="width: 75%; float: left;">

            <div class="tab-content">
                <?php 
                switch ( $tab ) {
                    case 'template':
                        include WPSD_PATH . 'admin/view/partial/receipt-email-template.php';
                        break;
                    default:
                        include WPSD_PATH . 'admin/view/partial/receipt-email-content.php';
                        break;
                } 
                ?>
            </div>

        </div>

        <?php $this->wpsd_admin_sidebar(); ?>

    </div>

</div>