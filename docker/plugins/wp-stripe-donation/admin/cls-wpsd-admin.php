<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 *	Master Class: Admin
 */
class Wpsd_Admin {
    use 
        HM_Currency,
        Wpsd_Common,
        Wpsd_General_Settings,
        Wpsd_Email_Settings,
        Wpsd_Email_Temp_Settings,
        Wpsd_Form_Settings,
        Wpsd_Form_Style_Settings,
        Wpsd_Donations,
        Wpsd_Fundraising_Content_Settings,
        Wpsd_Fundraising_Styles_Settings
    ;
    private $wpsd_version;

    private $wpsd_option_group;

    private $wpsd_assets_prefix;

    public function __construct( $version ) {
        $this->wpsd_version = $version;
        $this->wpsd_option_group = WPSD_PRFX . 'options_group';
        $this->wpsd_assets_prefix = substr( WPSD_PRFX, 0, -1 ) . '-';
    }

    /**
     *	Loading admin panel assets
     */
    function wpsd_admin_assets() {
        // You need styling for the datepicker. For simplicity I've linked to Google's hosted jQuery UI CSS.
        wp_register_style( 'jquery-ui', '//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' );
        wp_enqueue_style(
            $this->wpsd_assets_prefix . 'font-awesome',
            WPSD_ASSETS . 'css/fontawesome/css/all.min.css',
            array(),
            $this->wpsd_version,
            FALSE
        );
        wp_enqueue_style(
            $this->wpsd_assets_prefix . 'admin',
            WPSD_ASSETS . 'css/' . $this->wpsd_assets_prefix . 'admin.css',
            array(),
            $this->wpsd_version,
            FALSE
        );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_media();
        if ( !wp_script_is( 'jquery' ) ) {
            wp_enqueue_script( 'jquery' );
        }
        // Load the datepicker script (pre-registered in WordPress).
        wp_enqueue_script( 'jquery-ui-datepicker' );
        if ( !did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
        wp_register_script(
            'wsd-table-to-excel',
            'https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js',
            '',
            '',
            true
        );
        wp_enqueue_script( 'wsd-table-to-excel' );
        wp_enqueue_script(
            $this->wpsd_assets_prefix . 'admin',
            WPSD_ASSETS . 'js/' . $this->wpsd_assets_prefix . 'admin.js',
            array('jquery'),
            $this->wpsd_version,
            TRUE
        );
        //$wpsd_settings = get_option('wpsd_settings');
        $wpsdAdminArray = array(
            'wpsdIdsOfColorPicker' => array(),
        );
        wp_localize_script( $this->wpsd_assets_prefix . 'admin-script', 'wpsdAdminScript', $wpsdAdminArray );
    }

    /**
     *	Loading the admin menu
     */
    public function wpsd_admin_menu() {
        add_menu_page(
            __( 'WP Stripe Donation', WPSD_TXT_DOMAIN ),
            __( 'WP Stripe Donation', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-admin-settings',
            array($this, WPSD_PRFX . 'key_settings'),
            'dashicons-money-alt',
            100
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Key Settings', WPSD_TXT_DOMAIN ),
            __( 'Key Settings', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-key-settings',
            array($this, WPSD_PRFX . 'key_settings')
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'General Settings', WPSD_TXT_DOMAIN ),
            __( 'General Settings', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-general-settings',
            array($this, WPSD_PRFX . 'general_settings')
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Form Settings', WPSD_TXT_DOMAIN ),
            __( 'Form Settings', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-template-settings',
            array($this, WPSD_PRFX . 'form_settings')
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Fundraising', WPSD_TXT_DOMAIN ),
            __( 'Fundraising', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-fundraising-settings',
            array($this, WPSD_PRFX . 'fundraising_settings')
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Google reCaptcha', WPSD_TXT_DOMAIN ),
            __( 'Google reCaptcha', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-recaptcha-settings',
            array($this, WPSD_PRFX . 'recaptcha_settings')
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Donation List', WPSD_TXT_DOMAIN ),
            __( 'Donation List', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-all-donations',
            array($this, WPSD_PRFX . 'all_donations')
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Receipt Email', WPSD_TXT_DOMAIN ),
            __( 'Receipt Email', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-email-settings',
            array($this, 'wpsd_email_settings')
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Usage & Tutorial', WPSD_TXT_DOMAIN ),
            __( 'Usage & Tutorial', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-get-help',
            array($this, WPSD_PRFX . 'get_help')
        );
    }

    /**
     *	Loading admin panel view/forms
     */
    function wpsd_key_settings() {
        require_once WPSD_PATH . 'admin/view/key-settings.php';
    }

    function wpsd_general_settings() {
        $wpsdGeneralShowMessage = false;
        if ( isset( $_POST['updateGeneralSettings'] ) ) {
            if ( !isset( $_POST['wpsd_general_nonce_field'] ) || !wp_verify_nonce( $_POST['wpsd_general_nonce_field'], 'wpsd_general_action' ) ) {
                print 'Sorry, your nonce did not verify.';
                exit;
            } else {
                $wpsdGeneralShowMessage = $this->wpsd_set_general_settings( $_POST );
            }
        }
        $wpsdGeneralSettings = $this->wpsd_get_general_settings();
        require_once WPSD_PATH . 'admin/view/general.php';
    }

    function wpsd_form_settings() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
        $tab = ( isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : null );
        $wpsdNotice = false;
        if ( isset( $_POST['updateContent'] ) ) {
            if ( !isset( $_POST['wpsd_template_content_nonce_field'] ) || !wp_verify_nonce( $_POST['wpsd_template_content_nonce_field'], 'wpsd_template_content_action' ) ) {
                print 'Sorry, your nonce did not verify.';
                exit;
            } else {
                $wpsdNotice = $this->wpsd_set_form_content_settings( $_POST );
            }
        }
        if ( isset( $_POST['updateStyle'] ) ) {
            if ( !isset( $_POST['wpsd_template_style_nonce_field'] ) || !wp_verify_nonce( $_POST['wpsd_template_style_nonce_field'], 'wpsd_template_style_action' ) ) {
                print 'Sorry, your nonce did not verify.';
                exit;
            } else {
                $wpsdNotice = $this->wpsd_set_form_style_settings( $_POST );
            }
        }
        $wpsdContentSettings = $this->wpsd_get_form_content_settings();
        $wpsdSyleSettings = $this->wpsd_get_form_style_settings();
        require_once WPSD_PATH . 'admin/view/form.php';
    }

    /*
     * Fundraising Settings
     */
    function wpsd_fundraising_settings() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
        $tab = ( isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : null );
        $wpsdNotice = false;
        if ( isset( $_POST['updateContent'] ) ) {
            if ( !isset( $_POST['wpsd_fundraising_content_nonce_field'] ) || !wp_verify_nonce( $_POST['wpsd_fundraising_content_nonce_field'], 'wpsd_fundraising_content_action' ) ) {
                print 'Sorry, your nonce did not verify.';
                exit;
            } else {
                $wpsdNotice = $this->wpsd_set_fundraising_content_settings( $_POST );
            }
        }
        if ( isset( $_POST['updateFundRaisingStyles'] ) ) {
            if ( !isset( $_POST['wpsd_fund_raising_style_nonce_field'] ) || !wp_verify_nonce( $_POST['wpsd_fund_raising_style_nonce_field'], 'wpsd_fund_raising_style_action' ) ) {
                print 'Sorry, your nonce did not verify.';
                exit;
            } else {
                $wpsdNotice = $this->wpsd_set_fund_raising_style_settings( $_POST );
            }
        }
        require_once WPSD_PATH . 'admin/view/fundraising.php';
    }

    /*
     * Google reCaptcha Settings
     */
    function wpsd_recaptcha_settings() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
        require_once WPSD_PATH . 'admin/view/recaptcha.php';
    }

    function wpsd_email_settings() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
        $tab = ( isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : null );
        $wpsdEmailShowMessage = false;
        if ( isset( $_POST['updateEmailSettings'] ) ) {
            if ( !isset( $_POST['wpsd_email_content_nonce_field'] ) || !wp_verify_nonce( $_POST['wpsd_email_content_nonce_field'], 'wpsd_email_content_action' ) ) {
                print 'Sorry, your nonce did not verify.';
                exit;
            } else {
                $wpsdEmailShowMessage = $this->wpsd_set_email_content_settings( $_POST );
            }
        }
        $wpsdEmailSettings = $this->wpsd_get_email_content_settings();
        if ( isset( $_POST['updateEmailTempSettings'] ) ) {
            if ( !isset( $_POST['wpsd_email_temp_nonce_field'] ) || !wp_verify_nonce( $_POST['wpsd_email_temp_nonce_field'], 'wpsd_email_temp_action' ) ) {
                print 'Sorry, your nonce did not verify.';
                exit;
            } else {
                $wpsdEmailShowMessage = $this->wpsd_set_email_temp_settings( $_POST );
            }
        }
        $wpsdEmailTempSettings = $this->wpsd_get_email_temp_settings();
        require_once WPSD_PATH . 'admin/view/receipt-email.php';
    }

    function wpsd_all_donations() {
        $wpsdColumns = array(
            'wpsd_donated_amount'    => __( 'Amount', WPSD_TXT_DOMAIN ),
            'wpsd_donation_for'      => __( 'Donation For', WPSD_TXT_DOMAIN ),
            'wpsd_donator_name'      => __( 'Name', WPSD_TXT_DOMAIN ),
            'wpsd_donator_email'     => __( 'Email', WPSD_TXT_DOMAIN ),
            'wpsd_donation_datetime' => __( 'Date', WPSD_TXT_DOMAIN ),
        );
        register_column_headers( 'wpsd-column-table', $wpsdColumns );
        $wpsdDonations = $this->wpsd_get_all_donations();
        require_once WPSD_PATH . 'admin/view/donations.php';
    }

    protected function wpsd_display_notification( $type, $msg ) {
        ?>
		<div class="wpsd-alert <?php 
        esc_attr_e( $type );
        ?>">
			<span class="wpsd-closebtn">&times;</span>
			<strong><?php 
        esc_html_e( ucfirst( $type ) );
        ?>!</strong> <?php 
        esc_html_e( $msg );
        ?>
		</div>
		<?php 
    }

    function wpsd_get_image() {
        if ( !current_user_can( 'manage_options' ) ) {
            exit;
        }
        if ( isset( $_GET['id'] ) ) {
            $image = wp_get_attachment_image(
                filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ),
                esc_html( $_GET['img_type'] ),
                false,
                array(
                    'id' => esc_html( $_GET['prev_id'] ),
                )
            );
            $data = array(
                'image' => $image,
            );
            wp_send_json_success( $data );
        } else {
            wp_send_json_error();
        }
    }

    function wpsd_get_help() {
        require_once WPSD_PATH . 'admin/view/help-usage.php';
    }

    function wpsd_export_donations_to_csv() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
    }

}
