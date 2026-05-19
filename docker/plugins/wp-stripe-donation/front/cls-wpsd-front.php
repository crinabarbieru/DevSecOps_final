<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once WPSD_PATH . 'common/receipt-email-temp.php';
/** 
 * Master Class: Front
*/
class Wpsd_Front {
    use 
        HM_Currency,
        Wpsd_Common,
        Wpsd_General_Settings,
        Wpsd_Form_Settings,
        Wpsd_Form_Style_Settings,
        Wpsd_Email_Settings,
        Wpsd_Donations,
        Wpsd_Receipt_Email_Temp,
        Wpsd_Fundraising_Content_Settings,
        Wpsd_Fundraising_Styles_Settings
    ;
    private $wpsd_version;

    function __construct( $version ) {
        $this->wpsd_version = $version;
        $this->wpsd_assets_prefix = substr( WPSD_PRFX, 0, -1 ) . '-';
    }

    function wpsd_front_assets() {
        wp_enqueue_style(
            'wpsd-selectize',
            WPSD_ASSETS . 'css/selectize.bootstrap3.min.css',
            array(),
            $this->wpsd_version,
            FALSE
        );
        wp_enqueue_style(
            $this->wpsd_assets_prefix . 'front',
            WPSD_ASSETS . 'css/' . $this->wpsd_assets_prefix . 'front.css',
            array(),
            $this->wpsd_version,
            FALSE
        );
        if ( !wp_script_is( 'jquery' ) ) {
            wp_enqueue_script( 'jquery' );
        }
        wp_enqueue_script(
            $this->wpsd_assets_prefix . 'front',
            WPSD_ASSETS . 'js/' . $this->wpsd_assets_prefix . 'front.js',
            array('jquery'),
            $this->wpsd_version,
            TRUE
        );
        wp_enqueue_script(
            'wbg-selectize',
            WPSD_ASSETS . 'js/selectize.min.js',
            null,
            $this->wpsd_version,
            false
        );
        $wpsdKeySettings = stripslashes_deep( unserialize( get_option( 'wpsd_key_settings' ) ) );
        $wpsdPrimaryKey = ( isset( $wpsdKeySettings['wpsd_private_key'] ) ? $wpsdKeySettings['wpsd_private_key'] : 'pk_test_12345' );
        $wpsdGeneralSettings = stripslashes_deep( unserialize( get_option( 'wpsd_general_settings' ) ) );
        $wpsdDonateCurrency = ( isset( $wpsdGeneralSettings['wpsd_donate_currency'] ) ? $wpsdGeneralSettings['wpsd_donate_currency'] : 'USD' );
        $wpsd_thankyou_page = ( isset( $wpsdGeneralSettings['wpsd_thankyou_page'] ) ? $wpsdGeneralSettings['wpsd_thankyou_page'] : 'wpsd-thank-you' );
        $wpsd_exclude_stripe_sdk = ( isset( $wpsdGeneralSettings['wpsd_exclude_stripe_sdk'] ) ? $wpsdGeneralSettings['wpsd_exclude_stripe_sdk'] : false );
        $wpsd_exclude_security_token = ( isset( $wpsdGeneralSettings['wpsd_exclude_security_token'] ) ? $wpsdGeneralSettings['wpsd_exclude_security_token'] : false );
        $wpsd_minimum_amount = ( isset( $wpsdGeneralSettings['wpsd_minimum_amount'] ) ? $wpsdGeneralSettings['wpsd_minimum_amount'] : 1 );
        $wpsd_max_amount = ( isset( $wpsdGeneralSettings['wpsd_max_amount'] ) ? $wpsdGeneralSettings['wpsd_max_amount'] : 1 );
        $wpsdFormStyleSettings = stripslashes_deep( unserialize( get_option( 'wpsd_form_style_settings' ) ) );
        $wpsd_form_input_font_color = ( isset( $wpsdFormStyleSettings['wpsd_form_input_font_color'] ) ? $wpsdFormStyleSettings['wpsd_form_input_font_color'] : '#242424' );
        $wpsdAdminArray = array(
            'stripePKey'         => $wpsdPrimaryKey,
            'ajaxurl'            => admin_url( 'admin-ajax.php' ),
            'currency'           => $wpsdDonateCurrency,
            'successUrl'         => get_site_url() . '/' . $wpsd_thankyou_page,
            'idempotency'        => $this->wpsd_rand_string( 8 ),
            'security'           => wp_create_nonce( 'acme-security-nonce' ),
            'stripe_sdk'         => $wpsd_exclude_stripe_sdk,
            'card_element_color' => $wpsd_form_input_font_color,
            'minimum_amount'     => $wpsd_minimum_amount,
            'max_amount'         => $wpsd_max_amount,
            'security_token'     => $wpsd_exclude_security_token,
        );
        wp_localize_script( $this->wpsd_assets_prefix . 'front', 'wpsdAdminScriptObj', $wpsdAdminArray );
    }

    function wpsd_load_shortcode() {
        add_shortcode( 'wp_stripe_donation', array($this, 'wpsd_load_shortcode_view') );
    }

    function wpsd_load_shortcode_view( $attr ) {
        $output = '';
        ob_start();
        include plugin_dir_path( __FILE__ ) . '/view/payment-form.php';
        $output .= ob_get_clean();
        return $output;
    }

    function wpsd_load_donors_panel( $attr ) {
        $output = '';
        ob_start();
        include plugin_dir_path( __FILE__ ) . '/view/donors.php';
        $output .= ob_get_clean();
        return $output;
    }

    function wpsd_donation_handler() {
        $security_token = ( isset( $_POST['security_token'] ) && filter_var( $_POST['security_token'], FILTER_SANITIZE_NUMBER_INT ) ? $_POST['security_token'] : false );
        if ( !$security_token ) {
            if ( !check_ajax_referer( 'acme-security-nonce', 'security', false ) ) {
                wp_send_json_success( array(
                    'status'  => 'error',
                    'message' => __( 'Invalid security token sent', 'wp-stripe-donation' ),
                ) );
            }
        }
        // If amount missing
        if ( empty( $_POST['amount'] ) ) {
            wp_send_json_success( array(
                'status'  => 'error',
                'message' => __( 'Amount Missing!', 'wp-stripe-donation' ),
            ) );
        }
        // If donation_for missing
        if ( empty( $_POST['donation_for'] ) ) {
            wp_send_json_success( array(
                'status'  => 'error',
                'message' => __( 'Please specify donation for', 'wp-stripe-donation' ),
            ) );
        }
        if ( !empty( $_POST['name'] ) && !empty( $_POST['email'] ) && !empty( $_POST['amount'] ) && !empty( $_POST['donation_for'] ) ) {
            $wpsdDonationFor = ( isset( $_POST['donation_for'] ) ? sanitize_text_field( $_POST['donation_for'] ) : '' );
            $name = ( isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '' );
            $wpsdEmail = ( isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '' );
            $wpsdAmount = ( isset( $_POST['amount'] ) ? filter_var( $_POST['amount'], FILTER_SANITIZE_STRING ) : null );
            $wpsdCurrency = ( isset( $_POST['currency'] ) ? sanitize_text_field( $_POST['currency'] ) : null );
            //$idempotency 		= $wpsd_hide_idempotency_key ? $this->wpsd_rand_string() : preg_replace('/[^a-z\d]/im', '', $_POST['idempotency']);
            $stripe_sdk = ( isset( $_POST['stripeSdk'] ) && filter_var( $_POST['stripeSdk'], FILTER_SANITIZE_NUMBER_INT ) ? $_POST['stripeSdk'] : false );
            $wpsdKeySettings = stripslashes_deep( unserialize( get_option( 'wpsd_key_settings' ) ) );
            $wpsdStripeKey = ( isset( $wpsdKeySettings['wpsd_secret_key'] ) ? $wpsdKeySettings['wpsd_secret_key'] : '' );
            $address_street = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_street'] ) : '' );
            $address_line2 = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_line2'] ) : '' );
            $address_city = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_city'] ) : '' );
            $address_state = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_state'] ) : '' );
            $address_postal = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_postal'] ) : '' );
            $address_country = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_country'] ) : '' );
            $wpsdEmailSettings = stripslashes_deep( unserialize( get_option( 'wpsd_receipt_email_settings' ) ) );
            $wpsdDisableStripeEmail = ( isset( $wpsdEmailSettings['wpsd_disable_stripe_receipt_email'] ) ? $wpsdEmailSettings['wpsd_disable_stripe_receipt_email'] : true );
            $receiptEmail = ( $wpsdDisableStripeEmail ? null : $wpsdEmail );
            $amount = $this->wpsd_multiplying_currencies( $wpsdAmount, $wpsdCurrency );
            $gift_aid = ( isset( $_POST['gift_aid'] ) && filter_var( $_POST['gift_aid'], FILTER_SANITIZE_STRING ) ? $_POST['gift_aid'] : null );
            // Checking Stripe allready called once
            //if ( ! $stripe_sdk ) {
            if ( !class_exists( '\\Stripe\\Stripe' ) ) {
                include WPSD_PATH . 'stripe/init.php';
            }
            $google_response = true;
            if ( $google_response ) {
                try {
                    \Stripe\Stripe::setApiKey( base64_decode( $wpsdStripeKey ) );
                    $paymentIntent = \Stripe\PaymentIntent::create( [
                        'amount'        => $amount,
                        'currency'      => $wpsdCurrency,
                        'description'   => $wpsdDonationFor,
                        'receipt_email' => $receiptEmail,
                        'metadata'      => [
                            'integration_check' => 'accept_a_payment',
                            'gift_aid'          => $gift_aid,
                        ],
                        'shipping'      => [
                            'name'    => $name,
                            'address' => [
                                'line1'       => $address_street . ' ' . $address_line2,
                                'postal_code' => $address_postal,
                                'city'        => $address_city,
                                'state'       => $address_state,
                                'country'     => $address_country,
                            ],
                        ],
                    ] );
                    if ( '' !== $paymentIntent->client_secret ) {
                        wp_send_json_success( array(
                            'status'        => 'success',
                            'client_secret' => $paymentIntent->client_secret,
                        ) );
                    } else {
                        wp_send_json_success( array(
                            'status'  => 'error',
                            'message' => __( 'Something went wrong!', WPSD_TXT_DOMAIN ),
                        ) );
                    }
                } catch ( \Stripe\Exception\CardException $e ) {
                    wp_send_json_success( array(
                        'status'  => 'error',
                        'message' => $e->getMessage(),
                    ) );
                } catch ( \Stripe\Exception\RateLimitException $e ) {
                    // Too many requests made to the API too quickly
                    wp_send_json_success( array(
                        'status'  => 'error',
                        'message' => $e->getMessage(),
                    ) );
                } catch ( \Stripe\Exception\InvalidRequestException $e ) {
                    // Invalid parameters were supplied to Stripe's API
                    wp_send_json_success( array(
                        'status'  => 'error',
                        'message' => $e->getMessage(),
                    ) );
                } catch ( \Stripe\Exception\AuthenticationException $e ) {
                    // Authentication with Stripe's API failed
                    // (maybe you changed API keys recently)
                    wp_send_json_success( array(
                        'status'  => 'error',
                        'message' => $e->getMessage(),
                    ) );
                } catch ( \Stripe\Exception\ApiConnectionException $e ) {
                    // Network communication with Stripe failed
                    wp_send_json_success( array(
                        'status'  => 'error',
                        'message' => $e->getMessage(),
                    ) );
                } catch ( \Stripe\Exception\ApiErrorException $e ) {
                    // Display a very generic error to the user, and maybe send
                    // yourself an email
                    //
                    wp_send_json_success( array(
                        'status'  => 'error',
                        'message' => $e->getMessage(),
                    ) );
                } catch ( \Stripe\Exception\IdempotencyException $e ) {
                    // Idempotency Duplicate Issue
                    wp_send_json_success( array(
                        'status'  => 'error',
                        'message' => $e->getMessage(),
                    ) );
                } catch ( Exception $e ) {
                    // Something else happened, completely unrelated to Stripe
                    wp_send_json_success( array(
                        'status'  => 'error',
                        'message' => $e->getMessage(),
                    ) );
                }
            } else {
                wp_send_json_success( array(
                    'status'  => 'error',
                    'message' => __( 'reCaptcha verification failed!', WPSD_TXT_DOMAIN ),
                ) );
            }
        }
    }

    function wpsd_donation_handler_success() {
        if ( !empty( $_POST['email'] ) && !empty( $_POST['amount'] ) && !empty( $_POST['name'] ) && !empty( $_POST['donation_for'] ) ) {
            $wpsdDonationFor = ( isset( $_POST['donation_for'] ) ? sanitize_text_field( $_POST['donation_for'] ) : '' );
            $wpsdName = ( isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '' );
            $wpsdEmail = ( isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '' );
            $wpsdAmount = ( isset( $_POST['amount'] ) ? filter_var( $_POST['amount'], FILTER_SANITIZE_STRING ) : null );
            $wpsdCurrency = ( isset( $_POST['currency'] ) ? sanitize_text_field( $_POST['currency'] ) : null );
            $comments = ( isset( $_POST['comments'] ) ? sanitize_text_field( $_POST['comments'] ) : '' );
            $wpsdGeneralSettings = stripslashes_deep( unserialize( get_option( 'wpsd_general_settings' ) ) );
            $wpsdDonationEmail = ( isset( $wpsdGeneralSettings['wpsd_donation_email'] ) ? $wpsdGeneralSettings['wpsd_donation_email'] : '' );
            $wpsd_disable_donation_email = ( isset( $wpsdGeneralSettings['wpsd_disable_donation_email'] ) ? $wpsdGeneralSettings['wpsd_disable_donation_email'] : '' );
            $gift_aid = ( isset( $_POST['gift_aid'] ) && filter_var( $_POST['gift_aid'], FILTER_SANITIZE_STRING ) ? $_POST['gift_aid'] : null );
            // Send email to admin
            if ( '' !== $wpsdDonationEmail ) {
                if ( !$wpsd_disable_donation_email ) {
                    $this->wpsd_email_to_admin(
                        $wpsdDonationEmail,
                        $wpsdName,
                        $wpsdAmount,
                        $wpsdCurrency,
                        $wpsdDonationFor,
                        $wpsdEmail,
                        $gift_aid
                    );
                }
            }
            // Send email to client
            if ( '' !== $wpsdEmail ) {
                $this->wpsd_email_to_client(
                    $wpsdEmail,
                    $wpsdName,
                    $wpsdAmount,
                    $wpsdCurrency,
                    $wpsdDonationFor
                );
            }
            // Save data to database
            $post_addr = ( isset( $_POST['address'] ) ? $_POST['address'] : [] );
            $this->wpsd_save_donation_info(
                $wpsdDonationFor,
                $wpsdName,
                $wpsdEmail,
                $wpsdAmount,
                $wpsdCurrency,
                $comments,
                $post_addr,
                $_POST['con_one'],
                $gift_aid
            );
            // Upon Successful transaction, reply an Success message
            die( json_encode( array(
                'status' => 'success',
            ) ) );
        }
    }

    function wpsd_save_donation_info(
        $wpsdDonationFor,
        $wpsdName,
        $wpsdEmail,
        $wpsdAmount,
        $wpsdCurrency,
        $comments,
        $gift_aid
    ) {
        global $wpdb;
        $address_street = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_street'] ) : '' );
        $address_line2 = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_line2'] ) : '' );
        $address_city = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_city'] ) : '' );
        $address_state = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_state'] ) : '' );
        $address_postal = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_postal'] ) : '' );
        $address_country = ( isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'][0]['address_country'] ) : '' );
        $con_one = sanitize_text_field( $_POST['con_one'] );
        $gift_aid = sanitize_text_field( $_POST['gift_aid'] );
        $wpsdFundraisingContentSettings = $this->wpsd_get_fundraising_content_settings();
        foreach ( $wpsdFundraisingContentSettings as $fr_name => $fr_value ) {
            if ( isset( $wpsdFundraisingContentSettings[$fr_name] ) ) {
                ${"" . $fr_name} = $fr_value;
            }
        }
        $wpsd_enable_fundraising = null;
        $wpsd_fundraising_amount = null;
        $wpsd_fundraising_start_date = null;
        $wpsd_fundraising_end_date = null;
        return $wpdb->query( $wpdb->prepare( "INSERT INTO " . WPSD_TABLE . "\r\n\t\t\t\t( wpsd_donation_for,\r\n\t\t\t\twpsd_donator_name,\r\n\t\t\t\twpsd_donator_email,\r\n\t\t\t\twpsd_donator_phone,\r\n\t\t\t\twpsd_donated_amount,\r\n\t\t\t\twpsd_donation_datetime,\r\n\t\t\t\twpsd_comments,\r\n\t\t\t\twpsd_address,\r\n\t\t\t\twpsd_city,\r\n\t\t\t\twpsd_state,\r\n\t\t\t\twpsd_postcode,\r\n\t\t\t\twpsd_country,\r\n\t\t\t\twpsd_condition_one,\r\n\t\t\t\tfundraising,\r\n\t\t\t\tfundraising_amount,\r\n\t\t\t\tfundraising_start_date,\r\n\t\t\t\tfundraising_end_date,\r\n\t\t\t\tgift_aid )\r\n\t\t\t\tVALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", array(
            $wpsdDonationFor,
            $wpsdName,
            $wpsdEmail,
            $wpsdCurrency,
            $wpsdAmount,
            date( 'Y-m-d h:i:s' ),
            $comments,
            $address_street . " " . $address_line2,
            $address_city,
            $address_state,
            $address_postal,
            $address_country,
            $con_one,
            $wpsd_enable_fundraising,
            $wpsd_fundraising_amount,
            $wpsd_fundraising_start_date,
            $wpsd_fundraising_end_date,
            $gift_aid
        ) ) );
    }

    function wpsd_email_to_admin(
        $wpsdDonationEmail,
        $wpsdName,
        $wpsdAmount,
        $wpsdCurrency,
        $wpsdDonationFor,
        $wpsdEmail,
        $gift_aid
    ) {
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $wpsdEmailSubject = __( 'New Donation Received!', 'wp-stripe-donation' );
        $wpsdEmailMessage = __( 'Name: ' ) . $wpsdName;
        $wpsdEmailMessage .= '<br>' . __( 'Email: ', 'wp-stripe-donation' ) . $wpsdEmail;
        $wpsdEmailMessage .= '<br>' . __( 'Amount: ', 'wp-stripe-donation' ) . $wpsdAmount . $wpsdCurrency;
        $wpsdEmailMessage .= '<br>' . __( 'For: ', 'wp-stripe-donation' ) . $wpsdDonationFor;
        if ( '' != $gift_aid ) {
            $wpsdEmailMessage .= '<br>' . __( 'Gift Aid: ', 'wp-stripe-donation' ) . ucfirst( $gift_aid );
        }
        return wp_mail(
            $wpsdDonationEmail,
            $wpsdEmailSubject,
            $wpsdEmailMessage,
            $headers
        );
    }

    function wpsd_email_to_client(
        $wpsdEmail,
        $wpsdName,
        $wpsdAmount,
        $wpsdCurrency,
        $wpsdDonationFor
    ) {
        $wpsdEmailSettings = $this->wpsd_get_email_content_settings();
        foreach ( $wpsdEmailSettings as $option_name => $option_value ) {
            if ( isset( $wpsdEmailSettings[$option_name] ) ) {
                ${"" . $option_name} = $option_value;
            }
        }
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $donorEmailSubject = esc_html( $wpsd_re_email_subject );
        $wsd_email_arr = [
            'header'   => esc_html( $wpsd_re_email_heading ),
            'name'     => $wpsdName,
            'greeting' => $wpsd_re_email_greeting,
            'item'     => $wpsdDonationFor,
            'amount'   => $wpsdAmount,
            'currency' => $wpsdCurrency,
            'footer'   => esc_html( $wpsd_re_email_footnote ),
        ];
        if ( $wpsd_display_receipt_logo ) {
            if ( intval( $wpsd_receipt_logo ) > 0 ) {
                $logo = wp_get_attachment_image_url(
                    $wpsd_receipt_logo,
                    'full',
                    false,
                    array(
                        'class' => 'wpsd-form-banner',
                    )
                );
            }
            $wsd_email_arr['displayLogo'] = 'On';
            $wsd_email_arr['logo'] = $logo;
        }
        if ( $wpsd_hide_receipt_footnote ) {
            $wsd_email_arr['hideFootnote'] = 'On';
        }
        $wpsdEmailTempSettings = get_option( 'wpsd_receipt_email_temp_settings' );
        $wpsd_email_temp_layout = ( isset( $wpsdEmailTempSettings['wpsd_email_temp_layout'] ) ? $wpsdEmailTempSettings['wpsd_email_temp_layout'] : 'default' );
        $donorEmailMessage = $this->get_receipt_email_temp( $wpsd_email_temp_layout, $wsd_email_arr );
        if ( !$wpsd_disable_receipt_email ) {
            return wp_mail(
                $wpsdEmail,
                $donorEmailSubject,
                $donorEmailMessage,
                $headers
            );
        } else {
            return true;
        }
    }

    function wpsd_rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr( str_shuffle( $chars ), 0, $length );
    }

    function wpsd_get_total_donation_today() {
        global $wpdb;
        $table_name = WPSD_TABLE;
        $val = $wpdb->get_var( "SELECT sum(wpsd_donated_amount) FROM {$table_name} WHERE CAST(wpsd_donation_datetime AS DATE) =  CURDATE()" );
        if ( $val > 0 ) {
            return $val;
        }
        return 0;
    }

    function wpsd_multiplying_currencies( $amount, $currency ) {
        $zero_decimal_currencies = [
            'BIF',
            'CLP',
            'DJF',
            'GNF',
            'JPY',
            'KMF',
            'KRW',
            'MGA',
            'PYG',
            'RWF',
            'UGX',
            'VND',
            'VUV',
            'XAF',
            'XOF',
            'XPF'
        ];
        if ( !in_array( $currency, $zero_decimal_currencies ) ) {
            return $amount * 100;
        }
        return $amount;
    }

    function get_fundraising_amount() {
        global $wpdb;
        $table_name = WPSD_TABLE;
        $val = $wpdb->get_row( "SELECT SUM(wpsd_donated_amount) AS Total_Amount, COUNT(*) AS Total_Donation FROM wp_wpsd_stripe_donation WHERE fundraising = 'on' AND ( CURDATE() BETWEEN CAST(fundraising_start_date AS DATE) AND CAST(fundraising_end_date AS DATE))" );
        if ( $val->Total_Amount > 0 ) {
            return [
                'amounts'   => $val->Total_Amount,
                'donations' => $val->Total_Donation,
            ];
        }
        return [
            'amounts'   => 0,
            'donations' => 0,
        ];
    }

    function wpsd_verify_google_captcha( $key, $res ) {
        $url = "https://www.google.com/recaptcha/api/siteverify?secret={$key}&response={$res}";
        $response = wp_remote_get( $url, array(
            'timeout'    => 20,
            'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:20.0) Gecko/20100101 Firefox/20.0',
        ) );
        $respKey = json_decode( wp_remote_retrieve_body( $response ) );
        if ( $respKey->success ) {
            return $respKey->success;
        }
        return false;
    }

}
