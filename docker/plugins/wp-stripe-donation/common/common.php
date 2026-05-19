<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 *	Trait: Common
 */
trait Wpsd_Common
{
    protected $data;

    protected function wpsd_admin_sidebar() {
        ?>
		<div class="wpsd-admin-sidebar" style="width: 20%; float: left;">
			<div class="postbox pro-features">
				<h3 class="hndle"><span>Pro Features</span></h3>
				<div class="inside centered">
					<ul>
						<li>&#10003; Can Be Use For Fundraising</li>
						<li>&#10003; Export Donation List to CSV</li>
						<li>&#10003; Export Donation List to Excel</li>
						<li>&#10003; Google reCaptcha Integrated</li>
						<li>&#10003; Number Matching Captcha to Prevent Bot Attack</li>
						<li>&#10003; Customized Thank You Page</li>
						<li>&#10003; Display Donor List With Shortcode</li>
						<li>&#10003; Delete Data From Donation List Panel</li>
						<li>&#10003; Donor Address Fields In The Form</li>
						<li>&#10003; More Settings / Customization Options Available</li>
						<li>&#10003; Full Styling Options Available</li>
						<li>&#10003; HTML Template For Receipt Email</li>
						<li>&#10003; Some Custom Options to the Receipt Email</li>
						<li>&#10003; Apply a Condition to the Donors</li>
						<li>&#10003; Multi Panel Donation Form For Better View</li>
					</ul>
					<?php 
        ?>
						<p style="margin-bottom: 1px! important;"><a href="https://aidwp.com/" target="_blank" class="button button-primary wpsd-button" style="background: #F5653E;">Upgrade Now!</a></p>
						<?php 
        ?>
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle"><span>Support / Bug / Customization</span></h3>
				<div class="inside centered">
					<p>Please feel free to let us know if you have any bugs to report. Your report / suggestion can make the plugin awesome!</p>
					<p style="margin-bottom: 1px! important;"><a href="https://aidwp.com/" target="_blank" class="button button-primary wpsd-button">Get Support</a></p>
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle"><span>Join HM Plugin</span></h3>
                <div class="inside centered">
                    <p style="margin-bottom: 1px! important;"><a href='https://wwww.facebook.com/hmplugin' class="button button-info" target="_blank">Join HM Plugin<span class="dashicons dashicons-facebook" style="position: relative; top: 3px; margin-left: 3px; color: #0fb9da;"></span></a></p>
                </div>
				<div class="inside centered">
					<a href="https://twitter.com/hmplugin" target="_blank" class="button button-secondary">Follow @hmplugin<span class="dashicons dashicons-twitter" style="position: relative; top: 3px; margin-left: 3px; color: #0fb9da;"></span></a>
				</div>
				<div class="inside centered">
					<a href="https://www.youtube.com/@hmplugin" target="_blank" class="button button-secondary">Subscribe HM Plugin<span class="dashicons dashicons-youtube" style="position: relative; top: 3px; margin-left: 3px; color: #CC0000;"></span></a>
				</div>
			</div>
		</div> 
		<?php 
    }

    protected function wpsd_build_set_settings_options( $fields, $post ) {
        $this->data = [];
        $i = 0;
        foreach ( $fields as $field => $value ) {
            if ( 'string' === $fields[$i]['type'] ) {
                $this->data[$fields[$i]['name']] = ( isset( $post[$fields[$i]['name']] ) && filter_var( $post[$fields[$i]['name']], FILTER_SANITIZE_STRING ) ? $post[$fields[$i]['name']] : $fields[$i]['default'] );
            }
            if ( 'number' === $fields[$i]['type'] ) {
                $this->data[$fields[$i]['name']] = ( isset( $post[$fields[$i]['name']] ) && filter_var( $post[$fields[$i]['name']], FILTER_SANITIZE_NUMBER_INT ) ? $post[$fields[$i]['name']] : $fields[$i]['default'] );
            }
            if ( 'boolean' === $fields[$i]['type'] ) {
                $this->data[$fields[$i]['name']] = ( isset( $post[$fields[$i]['name']] ) ? $post[$fields[$i]['name']] : $fields[$i]['default'] );
            }
            if ( 'text' === $this->fields[$i]['type'] ) {
                $this->data[$this->fields[$i]['name']] = ( isset( $post[$this->fields[$i]['name']] ) ? sanitize_text_field( $post[$this->fields[$i]['name']] ) : $this->fields[$i]['default'] );
            }
            if ( 'textarea' === $this->fields[$i]['type'] ) {
                $this->data[$this->fields[$i]['name']] = ( isset( $post[$this->fields[$i]['name']] ) ? sanitize_textarea_field( $post[$this->fields[$i]['name']] ) : $this->fields[$i]['default'] );
            }
            if ( 'editor' === $this->fields[$i]['type'] ) {
                $this->data[$this->fields[$i]['name']] = ( isset( $post[$this->fields[$i]['name']] ) ? wp_kses_post( $post[$this->fields[$i]['name']] ) : $this->fields[$i]['default'] );
            }
            if ( 'email' === $this->fields[$i]['type'] ) {
                $this->data[$this->fields[$i]['name']] = ( isset( $post[$this->fields[$i]['name']] ) ? sanitize_email( $post[$this->fields[$i]['name']] ) : $this->fields[$i]['default'] );
            }
            $i++;
        }
        return $this->data;
    }

    protected function wpsd_build_get_settings_options( $fields, $settings ) {
        $this->data = [];
        $i = 0;
        foreach ( $fields as $option => $value ) {
            $this->data[$fields[$i]['name']] = ( isset( $settings[$fields[$i]['name']] ) ? $settings[$fields[$i]['name']] : $fields[$i]['default'] );
            $i++;
        }
        return $this->data;
    }

}