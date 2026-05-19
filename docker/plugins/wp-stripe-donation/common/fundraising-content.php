<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Trait: Fundraising Content Settings
*/
trait Wpsd_Fundraising_Content_Settings
{
    protected $fields, $settings, $options;
    
    protected function wpsd_set_fundraising_content_settings( $post ) {

        $this->fields   = $this->wpsd_fundraising_content_option_fileds();

        $this->options  = $this->wpsd_build_set_settings_options( $this->fields, $post );

        $this->settings = apply_filters( 'wpsd_fundraising_settings', $this->options, $post );

        return update_option( 'wpsd_fundraising_settings', $this->settings );

    }

    protected function wpsd_get_fundraising_content_settings() {

        $this->fields   = $this->wpsd_fundraising_content_option_fileds();
		$this->settings = get_option('wpsd_fundraising_settings');
        
        return $this->wpsd_build_get_settings_options( $this->fields, $this->settings );
	}

    protected function wpsd_fundraising_content_option_fileds() {

        return [
            [
                'name'      => 'wpsd_enable_fundraising',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wpsd_fundraising_amount',
                'type'      => 'number',
                'default'   => 0,
            ],
            [
                'name'      => 'wpsd_fundraising_start_date',
                'type'      => 'text',
                'default'   => '',
            ],
            [
                'name'      => 'wpsd_fundraising_end_date',
                'type'      => 'text',
                'default'   => '',
            ],
            [
                'name'      => 'wpsd_fundraising_goal_lbl_txt',
                'type'      => 'text',
                'default'   => 'Goal',
            ],
            [
                'name'      => 'wpsd_fundraising_raised_lbl_txt',
                'type'      => 'text',
                'default'   => 'Raised',
            ],
            [
                'name'      => 'wpsd_fundraising_donation_lbl_txt',
                'type'      => 'text',
                'default'   => 'Donations',
            ],
        ];
    }
}