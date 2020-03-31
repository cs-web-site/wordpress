<?php
/**
 * Plugin recommendation.
 *
 * @package X_Corporate
 */

// Load TGM library.
require_once trailingslashit( get_template_directory() ) . 'vendors/tgm/class-tgm-plugin-activation.php';

if ( ! function_exists( 'x_corporate_register_recommended_plugins' ) ) :

	/**
	 * Register recommended plugins.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_register_recommended_plugins() {

		$plugins = array(
			array(
				'name'     => esc_html__( 'Contact Form 7', 'x-corporate' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'One Click Demo Import', 'x-corporate' ),
				'slug'     => 'one-click-demo-import',
				'required' => false,
			),
		);

		$config = array();

		tgmpa( $plugins, $config );

	}

endif;

add_action( 'tgmpa_register', 'x_corporate_register_recommended_plugins' );
