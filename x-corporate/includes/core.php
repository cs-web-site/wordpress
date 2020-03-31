<?php
/**
 * Core functions.
 *
 * @package X_Corporate
 */

if ( ! function_exists( 'x_corporate_get_option' ) ) :

	/**
	 * Get theme option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function x_corporate_get_option( $key ) {

		$x_corporate_default_options = x_corporate_get_default_theme_options();

		if ( empty( $key ) ) {
			return;
		}

		$default = ( isset( $x_corporate_default_options[ $key ] ) ) ? $x_corporate_default_options[ $key ] : '';
		$theme_options = get_theme_mod( 'theme_options', $x_corporate_default_options );
		$theme_options = array_merge( $x_corporate_default_options, $theme_options );
		$value = '';

		if ( isset( $theme_options[ $key ] ) ) {
			$value = $theme_options[ $key ];
		}

		return $value;

	}

endif;

if ( ! function_exists( 'x_corporate_get_options' ) ) :

	/**
	 * Get all theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Theme options.
	 */
	function x_corporate_get_options() {

		$value = array();
		$value = get_theme_mod( 'theme_options' );
		return $value;

	}

endif;

if ( ! function_exists( 'x_corporate_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function x_corporate_get_default_theme_options() {

		$defaults = array();

		// Header.
		$defaults['show_title']            = true;
		$defaults['show_tagline']          = true;
		$defaults['contact_number']        = '';
		$defaults['contact_email']         = '';
		$defaults['contact_address']       = '';
		$defaults['show_social_in_header'] = false;
		$defaults['show_search_in_header'] = true;

		// Snowflakes.
		$defaults['show_snowflakes'] = true;

		// Layout.
		$defaults['global_layout']  = 'right-sidebar';
		$defaults['archive_layout'] = 'excerpt';

		// Footer.
		$defaults['copyright_text']   = esc_html__( 'Copyright &copy; All rights reserved.', 'x-corporate' );
		$defaults['go_to_top_status'] = true;

		// Blog.
		$defaults['excerpt_length']     = 40;
		$defaults['read_more_text']     = esc_html__( 'Read More', 'x-corporate' );
		$defaults['exclude_categories'] = '';

		// Breadcrumb.
		$defaults['breadcrumb_type'] = 'enabled';

		// Hero.
		$defaults['hero_type']                           = 'banner';
		$defaults['hero_status']                         = 'home-page';
		$defaults['hero_banner_title']                   = esc_html__( 'Happy Holidays', 'x-corporate' );
		$defaults['hero_banner_subtitle']                = '';
		$defaults['hero_banner_button_label']            = esc_html__( 'Learn More', 'x-corporate' );
		$defaults['hero_banner_button_url']              = home_url( '/' );
		$defaults['featured_slider_status']              = 'home-page';
		$defaults['featured_slider_transition_effect']   = 'fadeout';
		$defaults['featured_slider_transition_delay']    = 3;
		$defaults['featured_slider_transition_duration'] = 1;
		$defaults['featured_slider_enable_caption']      = true;
		$defaults['featured_slider_enable_arrow']        = true;
		$defaults['featured_slider_enable_pager']        = true;
		$defaults['featured_slider_enable_autoplay']     = true;
		$defaults['featured_slider_enable_overlay']      = true;
		$defaults['featured_slider_type']                = 'featured-page';
		$defaults['featured_slider_number']              = 3;
		$defaults['featured_slider_read_more_text']      = esc_html__( 'Read More', 'x-corporate' );

		return apply_filters( 'x_corporate_filter_default_theme_options', $defaults );
	}

endif;
