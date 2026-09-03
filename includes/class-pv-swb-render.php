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
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="#ffffff" aria-hidden="true">
				<path d="M12.04 2c-5.46 0-9.9 4.44-9.9 9.9 0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39a9.87 9.87 0 0 0 4.75 1.21h.01c5.46 0 9.9-4.44 9.9-9.9 0-2.65-1.03-5.13-2.9-7-1.87-1.87-4.35-2.92-7-2.92zm0 18.1h-.01a8.2 8.2 0 0 1-4.18-1.14l-.3-.18-3.14.82.84-3.06-.2-.31a8.2 8.2 0 0 1-1.26-4.33c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.83 2.42a8.17 8.17 0 0 1 2.41 5.82c0 4.55-3.7 8.24-8.24 8.24zm4.52-6.17c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.25-.64.81-.78.97-.14.17-.29.19-.53.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.39-1.72-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.4-.42-.56-.42-.14-.01-.31-.01-.47-.01a.9.9 0 0 0-.66.31c-.23.25-.86.85-.86 2.07s.89 2.4 1.01 2.57c.12.17 1.75 2.67 4.24 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.11-.23-.17-.48-.29z"/>
			</svg>
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
				transition: transform 0.2s ease, box-shadow 0.2s ease;
			}

			.pv-swb-button:hover {
				transform: scale(1.08);
				box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4);
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