<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="wpsd-wrap-all" class="wrap wpsd-fundraising-settings">

    <div class="settings-banner">
        <h2><i class="fa-solid fa-hand-holding-dollar"></i>&nbsp;<?php _e('Fundraising Settings', 'wp-stripe-donation'); ?></h2>
    </div>

    <?php 
        if ( $wpsdNotice ) {
            $this->wpsd_display_notification('success', 'Your information updated successfully.'); 
        } 
    ?>

    <div class="wpsd-wrap">

        <nav class="nav-tab-wrapper">
            <a href="?page=wpsd-fundraising-settings&tab=settings" class="nav-tab wsd-tab <?php if ( $tab != 'styles' ) { ?>nav-tab-active<?php } ?>">
                <i class="fa fa-cog" aria-hidden="true">&nbsp;</i><?php _e('Content', 'wp-stripe-donation'); ?>
            </a>
            <a href="?page=wpsd-fundraising-settings&tab=styles" class="nav-tab wsd-tab <?php if ( $tab === 'styles' ) { ?>nav-tab-active<?php } ?>">
                <i class="fa fa-paint-brush" aria-hidden="true"></i>&nbsp;<?php _e('Styles', 'wp-stripe-donation'); ?>
            </a>
        </nav>

        <div class="wpsd_personal_wrap wpsd_personal_help" style="width: 75%; float: left;">

            <div class="tab-content">
                <?php 
                switch ( $tab ) {
                    case 'styles':
                        include WPSD_PATH . 'admin/view/partial/fundraising-styles.php';
                        break;
                    default:
                        include WPSD_PATH . 'admin/view/partial/fundraising-content.php';
                        break;
                } 
                ?>
            </div>

        </div>

        <?php $this->wpsd_admin_sidebar(); ?>

    </div>

</div>