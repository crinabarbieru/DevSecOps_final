<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Trait: Slide Settings
*/
trait Wpsd_Receipt_Email_Temp
{
    protected $temp;

    protected function get_receipt_email_temp( $template, $info ) {

		if ( 'html' === $template ) {
			return $this->get_receipt_email_temp_html( $info );
		} else if ( 'custom' === $template ) {
			return $this->get_receipt_email_temp_custom( $info );
		} else {
			return $this->get_receipt_email_temp_default( $info );
		}
	}

	protected function get_receipt_email_temp_html( $info ) {

        $this->temp = '<table style="background: #f1f1f1; width: 100%; text-align: center;">
		<tbody>
		<tr>
			<td>
				<table  border="0" style="font-size: 14px; color: #242424; width: 600px; text-align: center; margin: 80px auto; border: 1px solid #ddd; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;" cellpadding=0 cellspacing=0>
				<thead style="background-color: #000000;">';

		if ( 'On' == $info["displayLogo"] ) {

			$this->temp .= '<tr height="30">
							<td colspan="4" style="padding-top:20px;">
								<img src="' . esc_url( $info["logo"] ) . '" alt="AidWP Receipt Email Logo" style="height:60px; width: auto;">
							</td>
						</tr>';
		}
		
		$this->temp .= '<tr>
						<th colspan="4">
							<h1 style="font-size: 20px; font-weight: 600; color: #FFF; margin:0; padding: 20px 0; border-bottom: 4px solid #29abe1;">' . $info["header"] . '</h1>
						</th>
					</tr>
				</thead>
				<tbody style="background-color:#FFFFFF;">
					<tr height="20"><td colspan="4">&nbsp;</td></tr>
					<tr height="60">
						<td>&nbsp;</td>
						<td style="text-align:left;">Hi ' . esc_html( $info["name"] ) .  ',</td>
						<td style="text-align:right; font-size: 12px;">' . __("Date", WPSD_TXT_DOMAIN) . ' - ' . date("M d, Y") . '</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan="2" style="text-align:left;">' . wp_kses_post( $info["greeting"] ) . '</td>
						<td>&nbsp;</td>
					</tr>
					<tr height="40"><td colspan="4">&nbsp;</td></tr>
					<tr height="20">
						<td>&nbsp;</td>
						<td colspan="2" style="text-align:left;"><strong>' . __("SUMMARY", WPSD_TXT_DOMAIN) . '</strong></td>
						<td>&nbsp;</td>
					</tr>
					<tr height="60">
						<td style="width:10%">&nbsp;</td>
						<td style="width:55%; border-bottom:1px solid #ddd; text-align:left;">' . esc_html( $info['item'] ) . '</td>
						<td style="width:25%; border-bottom:1px solid #ddd; text-align:right;">' . esc_html( $info['amount'] ) . '&nbsp;' . esc_html( $info['currency'] ) . '</td>
						<td style="width:10%">&nbsp;</td>
					</tr>
					<tr height="60">
						<td>&nbsp;</td>
						<td style="text-align:left;"><strong>' . __("Amount Paid", WPSD_TXT_DOMAIN) . '</strong></td>
						<td  style="text-align:right;">' . esc_html( $info['amount'] ) . '&nbsp;' . esc_html( $info['currency'] ) . '</td>
						<td>&nbsp;</td>
					</tr>
			  	</tbody>';
		
		if ( 'On' != $info["hideFootnote"] ) {
			$this->temp .= '<tfoot style="background-color:#FFFFFF;">
					<tr height="100">
						<td>&nbsp;</td>
						<td colspan="2" style="border-top:1px solid #ddd;">
							<p style="font-size:14px; font-weight:400; line-height:24px;">' . $info['footer'] . '</p>
						</td>
						<td>&nbsp;</td>
					</tr>
				</tfoot>';
		}

		$this->temp .= '</table>
			</td>
		</tr>
		</tbody>
		</table>';

        return $this->temp;
    }

	protected function get_receipt_email_temp_custom( $info ) {

		if ( '' != $info["greeting"] ) {

			$email_body 		= wp_kses_post( $info["greeting"] );
			$can_phrase_before	= ["#donorName#", "#donationAmount#"];
			$can_phrase_after   = ["" . $info['name'] . "", "" . $info['amount'] . $info['currency'] . ""];
			$email_body 		= str_replace($can_phrase_before, $can_phrase_after, $email_body);
		}

		$this->temp = '<table style="background: #f1f1f1; width: 100%; text-align: center;">
		<tbody>
		<tr>
			<td>
				<table  border="0" style="background-color:#FFFFFF; font-size: 14px; color: #242424; width: 600px; padding: 20px; text-align: center; margin: 80px auto; border: 1px solid #ddd; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;" cellpadding=0 cellspacing=0>
				<tbody>';

		if ( 'On' == $info["displayLogo"] ) {

			$this->temp .= '<tr height="60">
							<td>	
								<img src="' . esc_url( $info["logo"] ) . '" alt="AidWP Receipt Email Logo" style="height:auto; width: 100%; border: 1px solid #ddd;">
							</td>
						</tr>';
		}

		$this->temp .= '<tr height="35"><td>&nbsp;</td></tr>
					<tr>
						<td>' . $email_body . '</td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
		</tbody>';

		if ( 'On' != $info["hideFootnote"] ) {

			$this->temp .= '<tfoot>
				<tr>
					<td>
						<p style="font-size:11px; font-weight:400; line-height:24px; color: #555555; width: 600px; padding: 20px; text-align: center; margin: 30px auto;">' . $info['footer'] . '</p>
					</td>
				</tr>
			</tfoot>';
		}

		$this->temp .= '</table>';

		return $this->temp;
	}

	protected function get_receipt_email_temp_default( $info ) {

		$this->temp = '<table style="width: 500px; font-size:14px;">
			<tr height="40">
				<td>' . $info['header'] . '</td>
			</tr>
			<tr height="40">
				<td>' . __('Hello', WPSD_TXT_DOMAIN) . '&nbsp;' . esc_html( $info['name'] ) . ',</td>
			</tr>
			<tr height="40">
				<td>' . __('Amount paid', WPSD_TXT_DOMAIN) . ':&nbsp;' . esc_html( $info['amount'] ) . esc_html( $info['currency'] ) . '</td>
			</tr>
			<tr height="40">
				<td>' . __('Item', WPSD_TXT_DOMAIN) . ':&nbsp;' . esc_html( $info['item'] ) . '</td>
			</tr>
			<tr height="40">
				<td>' . __('Date', WPSD_TXT_DOMAIN) . ':&nbsp;' . date('M d, Y') . '</td>
			</tr>
			<tr height="20"><td>&nbsp;</td></tr>';

		if ( 'On' != $info["hideFootnote"] ) {
			$this->temp .= '<tr>
				<td style="font-size:12px;">' . $info['footer'] . '</td>
			</tr>';
		}
		
		$this->temp .= '</table>';
				
		return $this->temp;
	}
}