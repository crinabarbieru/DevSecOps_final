<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once WPSD_PATH . 'common/common.php';
require_once WPSD_PATH . 'inc/cls-hm-currency.php';
require_once WPSD_PATH . 'common/general-settings.php';
require_once WPSD_PATH . 'common/email-settings.php';
require_once WPSD_PATH . 'common/email-temp-settings.php';
require_once WPSD_PATH . 'common/form-content.php';
require_once WPSD_PATH . 'common/form-styles.php';
require_once WPSD_PATH . 'common/donations.php';
require_once WPSD_PATH . 'common/fundraising-content.php';
require_once WPSD_PATH . 'common/fundraising-styles.php';
/**
 * Master Class: Plugin
 */
class Wpsd_Master {
    protected $wpsd_loader;

    protected $wpsd_version;

    /**
     * Class Constructor
     */
    public function __construct() {
        $this->wpsd_version = WPSD_VERSION;
        add_action( 'init', array($this, 'wpsd_load_plugin_textdomain') );
        $this->wpsd_load_dependencies();
        $this->wpsd_trigger_admin_hooks();
        $this->wpsd_trigger_front_hooks();
    }

    function wpsd_load_plugin_textdomain() {
        /*
        $wbgLangPath = WPSD_TXT_DOMAIN;
        
        if ( wsd_fs()->is_plan__premium_only('basic') ) {
        	$wbgLangPath = WPSD_TXT_DOMAIN . '-premium';
        }
        
        load_plugin_textdomain(WPSD_TXT_DOMAIN, FALSE, $wbgLangPath . '/languages/' );
        */
        $this->wpsd_upgrade_donation_table();
    }

    private function wpsd_load_dependencies() {
        require_once WPSD_PATH . 'admin/' . WPSD_CLS_PRFX . 'admin.php';
        require_once WPSD_PATH . 'front/' . WPSD_CLS_PRFX . 'front.php';
        require_once WPSD_PATH . 'inc/' . WPSD_CLS_PRFX . 'loader.php';
        $this->wpsd_loader = new Wpsd_Loader();
    }

    private function wpsd_trigger_admin_hooks() {
        $wpsd_admin = new Wpsd_Admin($this->wpsd_version());
        $this->wpsd_loader->add_action( 'admin_menu', $wpsd_admin, WPSD_PRFX . 'admin_menu' );
        $this->wpsd_loader->add_action( 'admin_enqueue_scripts', $wpsd_admin, WPSD_PRFX . 'admin_assets' );
        $this->wpsd_loader->add_action( 'wp_ajax_wpsd_get_image', $wpsd_admin, 'wpsd_get_image' );
        $this->wpsd_loader->add_action( 'wp_ajax_nopriv_wpsd_get_image', $wpsd_admin, 'wpsd_get_image' );
    }

    private function wpsd_trigger_front_hooks() {
        $wpsd_front = new Wpsd_Front($this->wpsd_version());
        $this->wpsd_loader->add_action( 'wp_enqueue_scripts', $wpsd_front, WPSD_PRFX . 'front_assets' );
        $this->wpsd_loader->add_action( 'wp_ajax_wpsd_donation', $wpsd_front, 'wpsd_donation_handler' );
        $this->wpsd_loader->add_action( 'wp_ajax_nopriv_wpsd_donation', $wpsd_front, 'wpsd_donation_handler' );
        $this->wpsd_loader->add_action( 'wp_ajax_wpsd_donation_success', $wpsd_front, 'wpsd_donation_handler_success' );
        $this->wpsd_loader->add_action( 'wp_ajax_nopriv_wpsd_donation_success', $wpsd_front, 'wpsd_donation_handler_success' );
        $wpsd_front->wpsd_load_shortcode();
    }

    function wpsd_run() {
        $this->wpsd_loader->wpsd_run();
    }

    function wpsd_version() {
        return $this->wpsd_version;
    }

    function wpsd_install_table() {
        global $wpdb;
        $table_name = WPSD_TABLE;
        if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name ) {
            //table not in database. Create new table
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE {$table_name} (\r\n\t\t\t\t\twpsd_id INT(11) NOT NULL AUTO_INCREMENT,\r\n\t\t\t\t\twpsd_donation_for VARCHAR(255),\r\n\t\t\t\t\twpsd_donator_name VARCHAR(155),\r\n\t\t\t\t\twpsd_donator_email VARCHAR(155),\r\n\t\t\t\t\twpsd_donator_phone VARCHAR(55),\r\n\t\t\t\t\twpsd_donated_amount DECIMAL(10,2),\r\n\t\t\t\t\twpsd_donation_datetime DATETIME,\r\n\t\t\t\t\tPRIMARY KEY (`wpsd_id`)\r\n\t\t\t) {$charset_collate};";
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta( $sql );
        }
    }

    function wpsd_upgrade_donation_table() {
        global $wpdb;
        $table_name = WPSD_TABLE;
        if ( 2.9 < WPSD_VERSION ) {
            if ( $wpdb->get_var( "SHOW COLUMNS FROM {$table_name} LIKE 'wpsd_address'" ) != 'wpsd_address' ) {
                $wpdb->query( "ALTER TABLE {$table_name} ADD wpsd_address VARCHAR(155) NULL DEFAULT NULL" );
                $wpdb->query( "ALTER TABLE {$table_name} ADD wpsd_city VARCHAR(100) NULL DEFAULT NULL" );
                $wpdb->query( "ALTER TABLE {$table_name} ADD wpsd_state VARCHAR(100) NULL DEFAULT NULL" );
                $wpdb->query( "ALTER TABLE {$table_name} ADD wpsd_postcode VARCHAR(55) NULL DEFAULT NULL" );
                $wpdb->query( "ALTER TABLE {$table_name} ADD wpsd_country VARCHAR(100) NULL DEFAULT NULL" );
            }
        }
        if ( $wpdb->get_var( "SHOW COLUMNS FROM {$table_name} LIKE 'wpsd_comments'" ) != 'wpsd_comments' ) {
            $wpdb->query( "ALTER TABLE {$table_name} ADD wpsd_comments TEXT" );
        }
        if ( 3.0 < WPSD_VERSION ) {
            if ( $wpdb->get_var( "SHOW COLUMNS FROM {$table_name} LIKE 'wpsd_condition_one'" ) != 'wpsd_condition_one' ) {
                $wpdb->query( "ALTER TABLE {$table_name} ADD wpsd_condition_one VARCHAR(5) NULL DEFAULT NULL" );
            }
        }
        if ( 3.2 <= WPSD_VERSION ) {
            if ( $wpdb->get_var( "SHOW COLUMNS FROM {$table_name} LIKE 'fundraising'" ) != 'fundraising' ) {
                $wpdb->query( "ALTER TABLE {$table_name} ADD fundraising VARCHAR(5) NULL DEFAULT NULL" );
                $wpdb->query( "ALTER TABLE {$table_name} ADD fundraising_amount DECIMAL(10,2) NULL DEFAULT NULL" );
                $wpdb->query( "ALTER TABLE {$table_name} ADD fundraising_start_date DATETIME NULL DEFAULT NULL" );
                $wpdb->query( "ALTER TABLE {$table_name} ADD fundraising_end_date DATETIME NULL DEFAULT NULL" );
            }
            if ( $wpdb->get_var( "SHOW COLUMNS FROM {$table_name} LIKE 'gift_aid'" ) != 'gift_aid' ) {
                $wpdb->query( "ALTER TABLE {$table_name} ADD gift_aid VARCHAR(5) NULL DEFAULT NULL" );
            }
        }
    }

}
