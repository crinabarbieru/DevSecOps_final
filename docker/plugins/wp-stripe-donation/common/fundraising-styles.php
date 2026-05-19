<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Trait: Fundraising Content Settings
*/
trait Wpsd_Fundraising_Styles_Settings
{
    protected $fields, $settings, $options;
    
    protected function wpsd_set_fund_raising_style_settings( $post ) {

        $this->fields   = $this->wpsd_fundraising_style_option_fileds();

        $this->options  = $this->wpsd_build_set_settings_options( $this->fields, $post );

        $this->settings = apply_filters( 'wpsd_fundraising_style_settings', $this->options, $post );

        return update_option( 'wpsd_fundraising_style_settings', $this->settings );

    }

    protected function wpsd_get_fund_raising_style_settings() {

        $this->fields   = $this->wpsd_fundraising_style_option_fileds();
		$this->settings = get_option('wpsd_fundraising_style_settings');
        
        return $this->wpsd_build_get_settings_options( $this->fields, $this->settings );
	}

    protected function wpsd_fundraising_style_option_fileds() {

        return [
            [
                'name'      => 'wpsd_fund_raising_progress_color',
                'type'      => 'text',
                'default'   => '#48B553',
            ],
            [
                'name'      => 'wpsd_fund_raising_progress_bg_color',
                'type'      => 'text',
                'default'   => '#EAEAEA',
            ],
            [
                'name'      => 'wpsd_fundraising_raised_label_color',
                'type'      => 'text',
                'default'   => '#222222',
            ],
            [
                'name'      => 'wpsd_fundraising_raised_vol_color',
                'type'      => 'text',
                'default'   => '#222222',
            ],
            [
                'name'      => 'wpsd_fundraising_goal_label_color',
                'type'      => 'text',
                'default'   => '#222222',
            ],
            [
                'name'      => 'wpsd_fundraising_goal_vol_color',
                'type'      => 'text',
                'default'   => '#222222',
            ],
            [
                'name'      => 'wpsd_fundraising_donations_label_color',
                'type'      => 'text',
                'default'   => '#222222',
            ],
            [
                'name'      => 'wpsd_fundraising_donations_vol_color',
                'type'      => 'text',
                'default'   => '#222222',
            ],
            [
                'name'      => 'wpsd_fr_lvl_font_size',
                'type'      => 'number',
                'default'   => '16',
            ],
            [
                'name'      => 'wpsd_fr_number_font_size',
                'type'      => 'number',
                'default'   => '16',
            ],
            [
                'name'      => 'wpsd_fr_pb_border_radius',
                'type'      => 'number',
                'default'   => '0',
            ],
            [
                'name'      => 'wpsd_fr_pb_progress_border_radius',
                'type'      => 'number',
                'default'   => '0',
            ],
        ];
    }
}