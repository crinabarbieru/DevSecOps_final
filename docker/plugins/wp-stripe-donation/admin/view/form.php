<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_POST['updateFormTemplate'] ) ) {

    if ( ! isset( $_POST['wpsd_form_temp_settings_nonce_field'] ) 
        || ! wp_verify_nonce( $_POST['wpsd_form_temp_settings_nonce_field'], 'wpsd_form_temp_settings_action' ) ) {
        print 'Sorry, your nonce did not verify.';
        exit;
    } else {
        $wpsd_form_template = isset( $_POST['wpsd_form_template'] ) ? sanitize_text_field( $_POST['wpsd_form_template'] ) : 'classic';
        $wpsdNotice = update_option( 'hmls_form_temp_settings', $wpsd_form_template );
    }
}

$wpsd_form_template = get_option('hmls_form_temp_settings', 'classic');
?>
<div id="wpsd-wrap-all" class="wrap wpsd-template-settings">

    <div class="settings-banner">
        <h2><i class="fab fa-wpforms" aria-hidden="true"></i>&nbsp;<?php _e('Form Settings', WPSD_TXT_DOMAIN); ?></h2>
    </div>

    <?php 
        if ( $wpsdNotice ) {
            $this->wpsd_display_notification('success', 'Your information updated successfully.'); 
        } 
    ?>

    <div class="wpsd-wrap">

        <nav class="nav-tab-wrapper">
            <a href="?page=wpsd-template-settings&tab=content" class="nav-tab wsd-tab <?php if ( ( $tab === 'content' ) || ( $tab == '' ) ) { ?>nav-tab-active<?php } ?>">
                <i class="fa fa-cog" aria-hidden="true">&nbsp;</i><?php _e('Content', WPSD_TXT_DOMAIN); ?>
            </a>
            <a href="?page=wpsd-template-settings&tab=styles" class="nav-tab wsd-tab <?php if ( $tab === 'styles' ) { ?>nav-tab-active<?php } ?>">
                <i class="fa fa-paint-brush" aria-hidden="true"></i>&nbsp;<?php _e('Styles', WPSD_TXT_DOMAIN); ?>
            </a>
            <a href="?page=wpsd-template-settings&tab=template" class="nav-tab wsd-tab <?php if ( $tab === 'template' ) { ?>nav-tab-active<?php } ?>">
            <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php _e('Template', WPSD_TXT_DOMAIN); ?>
            </a>
        </nav>

        <div class="wpsd_personal_wrap wpsd_personal_help" style="width: 75%; float: left;">

            <div class="tab-content">
                <?php 
                switch ( $tab ) {
                    case 'styles':
                        include WPSD_PATH . 'admin/view/partial/form-styles.php';
                        break;
                    case 'template':
                        include WPSD_PATH . 'admin/view/partial/form-template.php';
                        break;
                    default:
                        include WPSD_PATH . 'admin/view/partial/form-content.php';
                        break;
                } 
                ?>
            </div>

        </div>

        <?php $this->wpsd_admin_sidebar(); ?>

    </div>

</div>