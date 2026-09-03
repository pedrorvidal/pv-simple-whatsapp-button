<?php
/**
 * Tests for PV_SWB_Render::build_whatsapp_url().
 *
 * @package PV_Simple_WhatsApp_Button
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Tests for the wa.me URL builder.
 *
 * @covers PV_SWB_Render
 */
final class RenderBuildUrlTest extends TestCase {

	/**
	 * Calls the private build_whatsapp_url() method via Reflection.
	 *
	 * @param string $phone_number Phone number to pass in.
	 * @param string $message      Message to pass in.
	 * @return string The built URL.
	 */
	private function call_build_whatsapp_url( string $phone_number, string $message ): string {
		$render = new PV_SWB_Render();

		$reflection = new ReflectionMethod( $render, 'build_whatsapp_url' );
		$reflection->setAccessible( true );

		/** @var string $url */
		$url = $reflection->invoke( $render, $phone_number, $message );

		return $url;
	}

	/**
	 * A phone number with no message must produce a URL without the text parameter.
	 */
	public function test_url_without_message_has_no_text_param(): void {
		$url = $this->call_build_whatsapp_url( '5551999999999', '' );

		$this->assertSame( 'https://wa.me/5551999999999', $url );
	}

	/**
	 * A message must be appended as a URL-encoded text parameter.
	 */
	public function test_url_with_message_includes_encoded_text_param(): void {
		$url = $this->call_build_whatsapp_url( '5551999999999', 'Hello there' );

		$this->assertSame( 'https://wa.me/5551999999999?text=Hello%20there', $url );
	}

	/**
	 * Special characters in the message must be properly URL-encoded.
	 */
	public function test_url_encodes_special_characters(): void {
		$url = $this->call_build_whatsapp_url( '5551999999999', 'Preço & desconto?' );

		$this->assertStringContainsString( 'text=', $url );
		$this->assertStringNotContainsString( ' ', $url );
		$this->assertStringNotContainsString( '&desconto', $url );
	}
}