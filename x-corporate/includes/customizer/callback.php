<?php
/**
 * Callback functions for active_callback.
 *
 * @package X_Corporate
 */

if ( ! function_exists( 'x_corporate_is_hero_active' ) ) :

	/**
	 * Check if hero is active.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function x_corporate_is_hero_active( $control ) {

		if ( 'disabled' !== $control->manager->get_setting( 'theme_options[hero_status]' )->value() ) {
			return true;
		} else {
			return false;
		}

	}

endif;

if ( ! function_exists( 'x_corporate_is_hero_banner_active' ) ) :

	/**
	 * Check if hero banner is active.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function x_corporate_is_hero_banner_active( $control ) {

		if ( 'disabled' !== $control->manager->get_setting( 'theme_options[hero_status]' )->value() && 'banner' === $control->manager->get_setting( 'theme_options[hero_type]' )->value() ) {
			return true;
		} else {
			return false;
		}

	}

endif;

if ( ! function_exists( 'x_corporate_is_hero_slider_active' ) ) :

	/**
	 * Check if hero slider is active.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function x_corporate_is_hero_slider_active( $control ) {

		if ( 'disabled' !== $control->manager->get_setting( 'theme_options[hero_status]' )->value() && 'slider' === $control->manager->get_setting( 'theme_options[hero_type]' )->value() ) {
			return true;
		} else {
			return false;
		}

	}

endif;

if ( ! function_exists( 'x_corporate_is_featured_slider_active' ) ) :

	/**
	 * Check if featured slider is active.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function x_corporate_is_featured_slider_active( $control ) {

		if ( 'disabled' !== $control->manager->get_setting( 'theme_options[featured_slider_status]' )->value() ) {
			return true;
		} else {
			return false;
		}

	}

endif;

if ( ! function_exists( 'x_corporate_is_hero_page_slider_active' ) ) :

	/**
	 * Check if hero page slider is active.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function x_corporate_is_hero_page_slider_active( $control ) {

		if (
		'featured-page' === $control->manager->get_setting( 'theme_options[featured_slider_type]' )->value()
		&& 'disabled' !== $control->manager->get_setting( 'theme_options[hero_status]' )->value()
		&& 'slider' === $control->manager->get_setting( 'theme_options[hero_type]' )->value()
		) {
			return true;
		} else {
			return false;
		}

	}

endif;
