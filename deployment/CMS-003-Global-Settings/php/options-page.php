<?php
/**
 * CMS-003 — Global Settings Options Page
 *
 * Registers the ACF Pro Options Page that group_global_settings.json attaches to.
 * Deploy via Code Snippets (recommended — no file access required) or by pasting
 * into greenly-child/functions.php. See IMPLEMENTATION-GUIDE.md.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page( array(
		'page_title' => 'Global Settings',
		'menu_title' => 'Global Settings',
		'menu_slug'  => 'global-settings',
		'capability' => 'manage_options',
		'redirect'   => false,
		'icon_url'   => 'dashicons-admin-generic',
		'position'   => 80,
	) );
}
