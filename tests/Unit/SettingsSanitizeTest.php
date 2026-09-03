<?php
/**
 * Tests for PV_SWB_Settings::sanitize_settings().
 *
 * @package PV_Simple_WhatsApp_Button
 */

declare(strict_types=1);

use Brain\Monkey;
use PHPUnit\Framework\TestCase;

/**
 * @covers PV_SWB_Settings
 */
final class SettingsSanitizeTest extends TestCase {

	/**
	 * Sets up Brain Monkey before each test.
	 */
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();

		Monkey\Functions\when( 'sanitize_text_field' )->returnArg();
	}

	/**
	 * Tears down Brain Monkey after each test.
	 */
	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

	/**
	 * Non-digit characters must be stripped from the phone number.
	 */
	public function test_strips_non_digit_characters_from_phone_number(): void {
		$settings = new PV_SWB_Settings();

		$result = $settings->sanitize_settings(
			array(
				'phone_number' => '+55 (51) 99999-9999',
				'message'      => 'Hello',
			)
		);

		$this->assertSame( '5551999999999', $result['phone_number'] );
	}

	/**
	 * The phone number must be truncated to the E.164 maximum length.
	 */
	public function test_truncates_phone_number_to_max_length(): void {
		$settings = new PV_SWB_Settings();

		$result = $settings->sanitize_settings(
			array(
				'phone_number' => '1234567890123456789',
				'message'      => '',
			)
		);

		$this->assertSame( 15, strlen( $result['phone_number'] ) );
	}

	/**
	 * A non-array input must not cause a fatal error.
	 */
	public function test_handles_non_array_input_gracefully(): void {
		$settings = new PV_SWB_Settings();

		$result = $settings->sanitize_settings( 'not-an-array' );

		$this->assertSame( '', $result['phone_number'] );
		$this->assertSame( '', $result['message'] );
	}

	/**
	 * An invalid position value must fall back to the default.
	 */
	public function test_invalid_position_falls_back_to_default(): void {
		$settings = new PV_SWB_Settings();

		$result = $settings->sanitize_settings(
			array(
				'phone_number' => '5551999999999',
				'position'     => 'somewhere-invalid',
			)
		);

		$this->assertSame( 'right', $result['position'] );
	}

	/**
	 * The "left" position must be accepted as-is.
	 */
	public function test_accepts_left_position(): void {
		$settings = new PV_SWB_Settings();

		$result = $settings->sanitize_settings(
			array(
				'phone_number' => '5551999999999',
				'position'     => 'left',
			)
		);

		$this->assertSame( 'left', $result['position'] );
	}
}
