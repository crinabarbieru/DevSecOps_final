<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="wpsd-master-wrapper wpsd-template-<?php 
printf( '%d', $wpsd_select_template );
?>" id="wpsd-wrap-all">

    <div id="wpsd-pageloader">
        <img src="<?php 
echo esc_attr( WPSD_ASSETS . 'img/loader.gif' );
?>" alt="<?php 
_e( 'Processing', WPSD_TXT_DOMAIN );
?>" />
    </div>
    
    <?php 
$fht = 0;
foreach ( $form_header_type as $type ) {
    if ( 'title' === $type ) {
        if ( '' !== $wpsd_payment_title ) {
            ?>
                <h3 class="wpsd-form-title"><?php 
            esc_html_e( $wpsd_payment_title );
            ?></h3>
                <div class="wpsd-form-title-border"></div>
                <?php 
        }
    }
    if ( 'description' === $type ) {
        if ( '' !== $wpsd_form_description ) {
            ?>
                <div class="wpsd-form-description"><?php 
            echo wp_kses_post( $wpsd_form_description );
            ?></div>
                <?php 
        }
    }
    if ( 'banner' === $type ) {
        if ( $wpsd_display_banner ) {
            if ( intval( $wpsd_form_banner ) > 0 ) {
                echo wp_get_attachment_image(
                    $wpsd_form_banner,
                    'full',
                    false,
                    array(
                        'class' => 'wpsd-form-banner',
                    )
                );
            }
        }
    }
    $fht++;
}
?>

    <!-- Main Form -->
    <div class="wpsd-wrapper-content">

        <?php 
// Including Payment Form
include 'form.php';
?>
    </div>
</div>