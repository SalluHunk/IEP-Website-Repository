<?php
/**
 * CMS-003 — Global Settings Helper Functions
 *
 * Safe getters for reading Global Settings fields from templates/Elementor
 * dynamic content, without a template ever fataling if ACF or a field is
 * missing. Deploy via Code Snippets (recommended) or greenly-child/functions.php.
 * See IMPLEMENTATION-GUIDE.md.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'iep_get_global_setting' ) ) {
	/**
	 * Get a text/url/email/textarea Global Settings field value.
	 *
	 * @param string $field_name ACF field name (e.g. 'contact_email').
	 * @param string $default    Fallback if ACF is inactive or the field is empty.
	 * @return string
	 */
	function iep_get_global_setting( $field_name, $default = '' ) {
		if ( ! function_exists( 'get_field' ) ) {
			return $default;
		}

		$value = get_field( $field_name, 'option' );

		return ( $value !== null && $value !== '' ) ? $value : $default;
	}
}

if ( ! function_exists( 'iep_get_global_image_url' ) ) {
	/**
	 * Get a Global Settings image field as a URL.
	 *
	 * @param string $field_name ACF image field name (e.g. 'primary_logo').
	 * @param string $size       Registered image size to prefer, falls back to full URL.
	 * @return string Empty string if unset.
	 */
	function iep_get_global_image_url( $field_name, $size = 'full' ) {
		if ( ! function_exists( 'get_field' ) ) {
			return '';
		}

		$image = get_field( $field_name, 'option' );

		if ( is_array( $image ) && isset( $image['sizes'][ $size ] ) ) {
			return $image['sizes'][ $size ];
		}

		if ( is_array( $image ) && isset( $image['url'] ) ) {
			return $image['url'];
		}

		return '';
	}
}
