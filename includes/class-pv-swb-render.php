<?php
/**
 * Renders the floating WhatsApp button on the front-end.
 *
 * @package PV_Simple_WhatsApp_Button
 */

declare(strict_types=1);

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Outputs the floating WhatsApp button in the site footer.
 */
class PV_SWB_Render {

	/**
	 * Registers WordPress hooks.
	 */
	public function init(): void {
		add_action( 'wp_footer', array( $this, 'render_button' ) );
	}

	/**
	 * Builds the wa.me URL from the stored phone number and message.
	 *
	 * @param string $phone_number Digits-only phone number.
	 * @param string $message      Pre-filled message text.
	 * @return string Fully-formed wa.me URL.
	 */
	private function build_whatsapp_url( string $phone_number, string $message ): string {
		$url = "https://wa.me/{$phone_number}";

		if ( '' !== $message ) {
			$url .= '?text=' . rawurlencode( $message );
		}

		return $url;
	}

	/**
	 * Outputs the button markup, if a phone number is configured.
	 */
	public function render_button(): void {
		$settings = PV_SWB_Settings::get_settings();

		if ( '' === $settings['phone_number'] ) {
			return;
		}

		$whatsapp_url   = $this->build_whatsapp_url( $settings['phone_number'], $settings['message'] );
		$position_class = 'left' === $settings['position'] ? 'pv-swb-button--left' : 'pv-swb-button--right';
		?>
		<a
			href="<?php echo esc_url( $whatsapp_url ); ?>"
			class="pv-swb-button <?php echo esc_attr( $position_class ); ?>"
			target="_blank"
			rel="noopener noreferrer"
			aria-label="<?php esc_attr_e( 'Contact us on WhatsApp', 'pv-simple-whatsapp-button' ); ?>"
		>
			...
		</a>
		<style>
			.pv-swb-button {
				position: fixed;
				bottom: 20px;
				width: 56px;
				height: 56px;
				background-color: #25d366;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
				z-index: 9999;
				text-decoration: none;
			}

			.pv-swb-button--right {
				right: 20px;
			}

			.pv-swb-button--left {
				left: 20px;
			}
		</style>
		<?php
	}
}