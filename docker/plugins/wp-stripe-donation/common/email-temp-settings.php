<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Trait: Email Template Settings
*/
trait Wpsd_Email_Temp_Settings
{
    protected $fields, $settings, $options;
    
    protected function wpsd_set_email_temp_settings( $post ) {

        $this->fields   = $this->wpsd_email_temp_option_fileds();

        $this->options  = $this->wpsd_build_set_settings_options( $this->fields, $post );

       $this->settings = apply_filters( 'wpsd_receipt_email_temp_settings', $this->options, $post );

        return update_option( 'wpsd_receipt_email_temp_settings', $this->settings );

    }

    protected function wpsd_get_email_temp_settings() {

        $this->fields   = $this->wpsd_email_temp_option_fileds();
		$this->settings = get_option('wpsd_receipt_email_temp_settings');
        
        return $this->wpsd_build_get_settings_options( $this->fields, $this->settings );
	}

    protected function wpsd_email_temp_option_fileds() {

        return [
            [
                'name'      => 'wpsd_email_temp_layout',
                'type'      => 'string',
                'default'   => 'default',
            ],
        ];
    }
}