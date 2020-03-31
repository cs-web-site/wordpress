<?php
/**
 * Helper functions.
 *
 * @package X_Corporate
 */

if ( ! function_exists( 'x_corporate_get_global_layout_options' ) ) :

	/**
	 * Returns global layout options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function x_corporate_get_global_layout_options() {
		$choices = array(
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'x-corporate' ),
			'right-sidebar' => esc_html__( 'Right Sidebar', 'x-corporate' ),
			'three-columns' => esc_html__( 'Three Columns', 'x-corporate' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'x-corporate' ),
		);
		return $choices;
	}

endif;

if ( ! function_exists( 'x_corporate_get_breadcrumb_type_options' ) ) :

	/**
	 * Returns breadcrumb type options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function x_corporate_get_breadcrumb_type_options() {
		$choices = array(
			'disabled' => esc_html__( 'Disabled', 'x-corporate' ),
			'enabled'  => esc_html__( 'Enabled', 'x-corporate' ),
		);
		return $choices;
	}

endif;


if ( ! function_exists( 'x_corporate_get_archive_layout_options' ) ) :

	/**
	 * Returns archive layout options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function x_corporate_get_archive_layout_options() {
		$choices = array(
			'full'    => esc_html__( 'Full Post', 'x-corporate' ),
			'excerpt' => esc_html__( 'Post Excerpt', 'x-corporate' ),
		);
		return $choices;
	}

endif;

if ( ! function_exists( 'x_corporate_get_image_sizes_options' ) ) :

	/**
	 * Returns image sizes options.
	 *
	 * @since 1.0.0
	 *
	 * @param bool  $add_disable    True for adding No Image option.
	 * @param array $allowed        Allowed image size options.
	 * @param bool  $show_dimension True for showing dimension.
	 * @return array Image size options.
	 */
	function x_corporate_get_image_sizes_options( $add_disable = true, $allowed = array(), $show_dimension = true ) {

		global $_wp_additional_image_sizes;

		$choices = array();

		if ( true === $add_disable ) {
			$choices['disable'] = esc_html__( 'No Image', 'x-corporate' );
		}

		$choices['thumbnail'] = esc_html__( 'Thumbnail', 'x-corporate' );
		$choices['medium']    = esc_html__( 'Medium', 'x-corporate' );
		$choices['large']     = esc_html__( 'Large', 'x-corporate' );
		$choices['full']      = esc_html__( 'Full (original)', 'x-corporate' );

		if ( true === $show_dimension ) {
			foreach ( array( 'thumbnail', 'medium', 'large' ) as $key => $_size ) {
				$choices[ $_size ] = $choices[ $_size ] . ' (' . get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
			}
		}

		if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {
			foreach ( $_wp_additional_image_sizes as $key => $size ) {
				$choices[ $key ] = $key;
				if ( true === $show_dimension ) {
					$choices[ $key ] .= ' (' . $size['width'] . 'x' . $size['height'] . ')';
				}
			}
		}

		if ( ! empty( $allowed ) ) {
			foreach ( $choices as $key => $value ) {
				if ( ! in_array( $key, $allowed, true ) ) {
					unset( $choices[ $key ] );
				}
			}
		}

		return $choices;

	}

endif;

if ( ! function_exists( 'x_corporate_get_image_alignment_options' ) ) :

	/**
	 * Returns image options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function x_corporate_get_image_alignment_options() {
		$choices = array(
			'none'   => esc_html_x( 'None', 'alignment', 'x-corporate' ),
			'left'   => esc_html_x( 'Left', 'alignment', 'x-corporate' ),
			'center' => esc_html_x( 'Center', 'alignment', 'x-corporate' ),
			'right'  => esc_html_x( 'Right', 'alignment', 'x-corporate' ),
		);
		return $choices;
	}

endif;

if ( ! function_exists( 'x_corporate_get_featured_slider_transition_effects' ) ) :

	/**
	 * Returns the featured slider transition effects.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function x_corporate_get_featured_slider_transition_effects() {
		$choices = array(
			'fade'       => esc_html_x( 'fade', 'transition effect', 'x-corporate' ),
			'fadeout'    => esc_html_x( 'fadeout', 'transition effect', 'x-corporate' ),
			'none'       => esc_html_x( 'none', 'transition effect', 'x-corporate' ),
			'scrollHorz' => esc_html_x( 'scrollHorz', 'transition effect', 'x-corporate' ),
		);
		ksort( $choices );
		return $choices;
	}

endif;

if ( ! function_exists( 'x_corporate_get_hero_content_options' ) ) :

	/**
	 * Returns the hero content options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function x_corporate_get_hero_content_options() {
		$choices = array(
			'home-page' => esc_html__( 'Front Page', 'x-corporate' ),
			'disabled'  => esc_html__( 'Disabled', 'x-corporate' ),
		);
		return $choices;
	}

endif;

if ( ! function_exists( 'x_corporate_get_hero_type' ) ) :

	/**
	 * Returns the hero type.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function x_corporate_get_hero_type() {
		$choices = array(
			'banner' => esc_html__( 'Banner', 'x-corporate' ),
			'slider' => esc_html__( 'Slider', 'x-corporate' ),
		);
		return $choices;
	}

endif;

if ( ! function_exists( 'x_corporate_get_featured_slider_type' ) ) :

	/**
	 * Returns the featured slider type.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function x_corporate_get_featured_slider_type() {
		$choices = array(
			'featured-page' => esc_html__( 'Featured Pages', 'x-corporate' ),
		);
		return $choices;
	}

endif;
