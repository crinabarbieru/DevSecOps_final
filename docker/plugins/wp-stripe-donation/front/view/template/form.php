<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form action="" method="POST" id="wpsd-donation-form-id" autocomplete="off">
    
    
    <?php 
if ( count( $wpsd_donation_values ) > 0 ) {
    ?>
        <div class="wpsd-amounts-wrapper">
            <?php 
    foreach ( $wpsd_donation_values as $amount ) {
        ?>
                <button type="button" onclick="wpsdSelectAmount(this,<?php 
        esc_attr_e( $amount );
        ?>);"><?php 
        echo esc_html( $currancy_symbol ) . esc_html( number_format( $amount ) );
        ?></button>
                <?php 
    }
    ?>
        </div>
        <?php 
}
?>

    <div class="wpsd_donate_amount_other_li">
        <?php 
esc_html_e( $currancy_symbol );
?>
        <input type="number" id="wpsd_donate_other_amount" class="wpsd_donate_other_amount" name="wpsd_donate_other_amount" placeholder="<?php 
esc_attr_e( $wpsd_donate_amount_label );
?>" 
            min="<?php 
esc_attr_e( $wpsd_minimum_amount );
?>" max="<?php 
esc_attr_e( $wpsd_max_amount );
?>" step="1" value="<?php 
esc_attr_e( $wpsd_amount );
?>" required />
        <span class="required-sign">*</span>
    </div>

    <?php 
// Donation/Payment For
if ( !$wpsd_hide_donation_for ) {
    if ( !$wpsd_hide_label ) {
        ?>
            <label for="wpsd_donation_for" class="wpsd-donation-form-label"><?php 
        esc_html_e( $wpsd_donation_for_label );
        ?></label>
            <?php 
    }
    ?>
        <select name="wpsd_donation_for" id="wpsd_donation_for" class="wpsd-text-field">
            <?php 
    $wpsd_donation_options = ( $wpsd_donation_options != '' ? explode( ',', $wpsd_donation_options ) : [] );
    if ( count( $wpsd_donation_options ) > 0 ) {
        foreach ( $wpsd_donation_options as $item ) {
            ?>
                <option value="<?php 
            esc_attr_e( trim( $item ) );
            ?>"><?php 
            esc_html_e( trim( $item ) );
            ?></option>
                <?php 
        }
    }
    ?>
        </select>
    <?php 
} else {
    ?>
        <input type="hidden" name="wpsd_donation_for" id="wpsd_donation_for" value="<?php 
    esc_attr_e( $wpsd_donation_options );
    ?>" >
        <?php 
}
// Full Name
if ( !$wpsd_hide_label ) {
    ?>
        <label for="wpsd_donator_name" class="wpsd-donation-form-label"><?php 
    esc_html_e( $wpsd_donator_name_label );
    ?>&nbsp;<span class="required-sign">*</span></label>
        <?php 
}
?>
    <input type="text" name="wpsd_donator_name" id="wpsd_donator_name" class="wpsd-text-field" placeholder="<?php 
esc_attr_e( $wpsd_donator_name_label );
?>" required>
    
    <!-- Email -->
    <?php 
if ( !$wpsd_hide_label ) {
    ?>
        <label for="wpsd_donator_email" class="wpsd-donation-form-label"><?php 
    esc_html_e( $wpsd_donator_email_label );
    ?>&nbsp;<span class="required-sign">*</span></label>
        <?php 
}
?>
    <input type="email" name="wpsd_donator_email" id="wpsd_donator_email" class="wpsd-text-field" placeholder="<?php 
esc_attr_e( $wpsd_donator_email_label );
?>" required>
    
    <?php 
// Phone
if ( $wpsd_display_phone ) {
    ?>
        <label for="wpsd_donator_phone" class="wpsd-donation-form-label"><?php 
    esc_html_e( $wpsd_donator_phone_label );
    ?></label>
        <input type="text" name="wpsd_donator_phone" id="wpsd_donator_phone" class="wpsd-text-field" placeholder="<?php 
    esc_attr_e( $wpsd_donator_phone_label );
    ?>">
        <?php 
}
?>

    <!-- Card --->
    <?php 
if ( !$wpsd_hide_label ) {
    ?>
        <label class="wpsd-donation-form-label"><?php 
    esc_html_e( $wpsd_card_element_label );
    ?>&nbsp;<span class="required-sign">*</span></label>
        <?php 
}
?>
    <div id="card-element"></div>
    <script src="https://js.stripe.com/v3/"></script>
    <!--- card end-->

    <?php 
if ( $wpsd_show_captcha ) {
    if ( !$wpsd_hide_label ) {
        ?>
            <label class="wpsd-donation-form-label wpsd-captcha-label"><?php 
        esc_html_e( $wpsd_captcha_label );
        ?>&nbsp;<span class="required-sign">*</span></label>
            <?php 
    }
    ?>
        <label class="wpsd-donation-form-label"><?php 
    echo __( 'What is', WPSD_TXT_DOMAIN ) . '&nbsp;' . esc_html( $wpsdCaptchaItem1 ) . '&nbsp;+&nbsp;' . esc_html( $wpsdCaptchaItem2 );
    ?>&nbsp;?</label>
        <input type="hidden" value="<?php 
    printf( '%d', $wpsdCaptchaItem1 + $wpsdCaptchaItem2 );
    ?>" name="wpsd_captcha_content_check" id="wpsd_captcha_content_check">
        <input type="number" min="2" max="40" name="wpsd_captcha_content" id="wpsd_captcha_content" class="wpsd-text-field">
        <?php 
}
?>
    <div id="card-errors" class="wpsd-alert" role="alert"></div>
    <input type="submit" name="wpsd-donate-button" class="wpsd-donate-button" value="<?php 
esc_attr_e( $wpsd_donate_button_text );
?>">
</form>
<script>
    function wpsdSelectAmount(btn, amount) {
        document.querySelectorAll('.wpsd-amounts-wrapper button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('wpsd_donate_other_amount').value = amount;
    }
</script>