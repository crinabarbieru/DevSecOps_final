<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( 'on' === $wpsd_enable_fundraising ) {

    $currentDate            = strtotime( date("Y-m-d") );
    $fundraisingDateBegin   = strtotime( $wpsd_fundraising_start_date );
    $fundraisingDateEnd     = strtotime( $wpsd_fundraising_end_date );

    if ( $wpsd_fundraising_amount > 0 ) {

        $fundraisingAmount  = $this->get_fundraising_amount();
        $wpsd_data_progress = ( ( $fundraisingAmount['amounts'] * 100 ) / $wpsd_fundraising_amount );

        if ( ( $currentDate >= $fundraisingDateBegin ) && ( $currentDate <= $fundraisingDateEnd ) ) {
            ?>
            <div class="wpsd-animated-progress progress-green" id="wpsd-animated-progress">
                <span data-progress="<?php esc_attr_e( $wpsd_data_progress ); ?>"></span>
            </div>
            <table width="100%" class="wpsd-fundraising-table">
                <tr>
                    <th width="33%"><label class="wpsd-fr-rasied-volume"><?php echo esc_html( $currancy_symbol ) . esc_html( number_format( $fundraisingAmount['amounts'] ) ); ?></label></th>
                    <th width="33%"><label class="wpsd-fr-donation-volume"><?php esc_html_e( $fundraisingAmount['donations'] ); ?></label></th>
                    <th width="33%"><label class="wpsd-fr-goal-volume"><?php echo esc_html( $currancy_symbol ) . esc_html( number_format( $wpsd_fundraising_amount ) ); ?></label></th>
                </tr>
                <tr>
                    <td><label class="wpsd-fr-rasied-label"><?php esc_html_e( $wpsd_fundraising_raised_lbl_txt ); ?></label></td>
                    <td><label class="wpsd-fr-donation-label"><?php esc_html_e( $wpsd_fundraising_donation_lbl_txt ); ?></label></td>
                    <td><label class="wpsd-fr-goal-label"><?php esc_html_e( $wpsd_fundraising_goal_lbl_txt ); ?></label></td>
                </tr>
            </table>
            <hr>
            <?php
        }
    }
}
?>