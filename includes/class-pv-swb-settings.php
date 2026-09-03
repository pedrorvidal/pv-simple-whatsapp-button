<?php
/**
 * Handles the plugin's settings page.
 *
 * @package PV_Simple_WhatsApp_Button
 */

declare(strict_types=1);

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers and renders the plugin's settings page.
 *
 * @phpstan-type SettingsData array{
 *     phone_number: string,
 *     message: string,
 * }
 */
class PV_SWB_Settings {

	/**
	 * Name of the option stored in the database.
	 *
	 * @var string
	 */
	private const OPTION_NAME        = 'pv_swb_settings';
	private const MAX_MESSAGE_LENGTH = 200;

	/**
	 * Registers WordPress hooks.
	 */
	public function init(): void {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Adds the settings page under the Settings menu.
	 */
	public function add_settings_page(): void {
		add_options_page(
			__( 'WhatsApp Button', 'pv-simple-whatsapp-button' ),
			__( 'WhatsApp Button', 'pv-simple-whatsapp-button' ),
			'manage_options',
			'pv-swb-settings',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Registers the option and its sanitization callback.
	 */
	public function register_settings(): void {
		register_setting(
			'pv_swb_settings_group',
			self::OPTION_NAME,
			array( $this, 'sanitize_settings' )
		);
	}

	/**
	 * Sanitizes form data before saving.
	 *
	 * @param mixed $input Raw form data (array shape not guaranteed by WordPress).
	 * @return SettingsData Sanitized data.
	 */
	public function sanitize_settings( $input ): array {
		$input = is_array( $input ) ? $input : array();

		return array(
			'phone_number' => isset( $input['phone_number'] ) ? preg_replace( '/[^0-9]/', '', (string) $input['phone_number'] ) : '',
			'message'      => isset( $input['message'] ) ? mb_substr( sanitize_text_field( (string) $input['message'] ), 0, self::MAX_MESSAGE_LENGTH ) : '',
		);
	}

	/**
	 * Returns the plugin's saved settings, merged with defaults.
	 *
	 * @return SettingsData
	 */
	public static function get_settings(): array {
		$defaults = array(
			'phone_number' => '',
			'message'      => '',
		);

		/**
		 * Merged settings.
		 *
		 * @var SettingsData $settings
		 */
		$settings = wp_parse_args( get_option( self::OPTION_NAME, array() ), $defaults );

		return $settings;
	}

	/**
	 * Renders the settings page markup.
	 */
	public function render_settings_page(): void {
		$settings = self::get_settings();
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'WhatsApp Button - Settings', 'pv-simple-whatsapp-button' ); ?></h1>
			<form method="post" action="options.php">
				<?php settings_fields( 'pv_swb_settings_group' ); ?>
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="pv_swb_phone_number"><?php esc_html_e( 'WhatsApp number', 'pv-simple-whatsapp-button' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								id="pv_swb_phone_number"
								name="<?php echo esc_attr( self::OPTION_NAME ); ?>[phone_number]"
								value="<?php echo esc_attr( $settings['phone_number'] ); ?>"
								class="regular-text"
								placeholder="5551999999999"
							/>
							<p class="description"><?php esc_html_e( 'Digits only, including country and area code (e.g. 5551999999999).', 'pv-simple-whatsapp-button' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="pv_swb_message"><?php esc_html_e( 'Default message', 'pv-simple-whatsapp-button' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								id="pv_swb_message"
								name="<?php echo esc_attr( self::OPTION_NAME ); ?>[message]"
								value="<?php echo esc_attr( $settings['message'] ); ?>"
								class="regular-text"
								maxlength="<?php echo esc_attr( (string) self::MAX_MESSAGE_LENGTH ); ?>"
							/>
							<p class="description"><?php esc_html_e( 'Max length: 200 characters.', 'pv-simple-whatsapp-button' ); ?></p>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}