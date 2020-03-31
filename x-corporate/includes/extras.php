<?php
/**
 * Functions hooked to core hooks.
 *
 * @package X_Corporate
 */

if ( ! function_exists( 'x_corporate_customize_search_form' ) ) :

	/**
	 * Customize search form.
	 *
	 * @since 1.0.0
	 *
	 * @return string The search form HTML output.
	 */
	function x_corporate_customize_search_form() {

		$form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
			<label>
			<span class="screen-reader-text">' . _x( 'Search for:', 'label', 'x-corporate' ) . '</span>
			<input type="search" class="search-field" placeholder="' . esc_attr__( 'Search&hellip;', 'x-corporate' ) . '" value="' . get_search_query() . '" name="s" title="' . esc_attr_x( 'Search for:', 'label', 'x-corporate' ) . '" />
			</label>
			<input type="submit" class="search-submit" value="&#xf002;" /></form>';

		return $form;

	}

endif;

add_filter( 'get_search_form', 'x_corporate_customize_search_form', 15 );

if ( ! function_exists( 'x_corporate_add_primary_navigation' ) ) :

	/**
	 * Add primary navigation.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_add_primary_navigation() {
		?>
		<div id="main-nav" class="clear-fix">
			<div class="container">
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<div class="wrap-menu-content">
						<?php
						wp_nav_menu(
							array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'fallback_cb'    => 'x_corporate_primary_navigation_fallback',
							)
						);
						?>
					</div><!-- .wrap-menu-content -->
				</nav><!-- #site-navigation -->
			</div> <!-- .container -->
		</div><!-- #main-nav -->
		<?php
	}

endif;

add_filter( 'x_corporate_action_after_header', 'x_corporate_add_primary_navigation', 20 );

if ( ! function_exists( 'x_corporate_exclude_category_in_blog_page' ) ) :

	/**
	 * Exclude category in blog page.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Query $query WP_Query instance.
	 * @return WP_Query Modified instance.
	 */
	function x_corporate_exclude_category_in_blog_page( $query ) {

		if ( $query->is_home() && $query->is_main_query() ) {
			$exclude_categories = x_corporate_get_option( 'exclude_categories' );
			if ( ! empty( $exclude_categories ) ) {
				$categories_raw = explode( ',', $exclude_categories );
				$cats = array();
				if ( ! empty( $categories_raw ) ) {
					foreach ( $categories_raw as $c ) {
						if ( absint( $c ) > 0 ) {
							$cats[] = absint( $c );
						}
					}
					if ( ! empty( $cats ) ) {
						$exclude_text = '';
						$exclude_text = '-' . implode( ',-', $cats );
						$query->set( 'cat', $exclude_text );
					}
				}
			}
		}

		return $query;
	}

endif;

add_filter( 'pre_get_posts', 'x_corporate_exclude_category_in_blog_page' );

if ( ! function_exists( 'x_corporate_implement_excerpt_length' ) ) :

	/**
	 * Implement excerpt length.
	 *
	 * @since 1.0.0
	 *
	 * @param int $length The number of words.
	 * @return int Excerpt length.
	 */
	function x_corporate_implement_excerpt_length( $length ) {

		if ( is_admin() ) {
			return $length;
		}

		$excerpt_length = x_corporate_get_option( 'excerpt_length' );
		$excerpt_length = apply_filters( 'x_corporate_filter_excerpt_length', $excerpt_length );

		if ( absint( $excerpt_length ) > 0 ) {
			$length = absint( $excerpt_length );
		}

		return $length;

	}

endif;

add_filter( 'excerpt_length', 'x_corporate_implement_excerpt_length', 999 );

if ( ! function_exists( 'x_corporate_implement_read_more' ) ) :

	/**
	 * Implement read more in excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The excerpt.
	 */
	function x_corporate_implement_read_more( $more ) {

		if ( is_admin() ) {
			return $more;
		}

		$read_more_text = x_corporate_get_option( 'read_more_text' );
		$more_link = '&hellip;&nbsp;<a href="' . esc_url( get_permalink() ) . '" class="more-link">' . esc_html( $read_more_text ) . '</a>';
		return $more_link;

	}

endif;

add_filter( 'excerpt_more', 'x_corporate_implement_read_more' );

if ( ! function_exists( 'x_corporate_content_more_link' ) ) :

	/**
	 * Implement read more in content.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more_link Read More link element.
	 * @param string $more_link_text Read More text.
	 * @return string Link.
	 */
	function x_corporate_content_more_link( $more_link, $more_link_text ) {

		$read_more_text = x_corporate_get_option( 'read_more_text' );

		if ( ! empty( $read_more_text ) ) {
			$more_link = str_replace( $more_link_text, esc_html( $read_more_text ), $more_link );
		}

		return $more_link;

	}

endif;

add_filter( 'the_content_more_link', 'x_corporate_content_more_link', 10, 2 );

if ( ! function_exists( 'x_corporate_custom_body_class' ) ) :

	/**
	 * Custom body class.
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $input One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function x_corporate_custom_body_class( $input ) {

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$input[] = 'group-blog';
		}

		// Global layout.
		global $post;
		$global_layout = x_corporate_get_option( 'global_layout' );
		$global_layout = apply_filters( 'x_corporate_filter_theme_global_layout', $global_layout );

		// Check if single template.
		if ( $post && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'x_corporate_settings', true );
			if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
				$global_layout = $post_options['post_layout'];
			}
		}

		$input[] = 'global-layout-' . esc_attr( $global_layout );

		// Common class for three columns.
		switch ( $global_layout ) {
			case 'three-columns':
				$input[] = 'three-columns-enabled';
			break;

			default:
			break;
		}

		return $input;
	}
endif;

add_filter( 'body_class', 'x_corporate_custom_body_class' );

if ( ! function_exists( 'x_corporate_featured_image_instruction' ) ) :

	/**
	 * Message to show in the Featured Image Meta box.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content Admin post thumbnail HTML markup.
	 * @param int    $post_id Post ID.
	 * @return string HTML.
	 */
	function x_corporate_featured_image_instruction( $content, $post_id ) {

		if ( in_array( get_post_type( $post_id ), array( 'post', 'page' ), true ) ) {
			$content .= '<strong>' . esc_html__( 'Recommended Image Sizes', 'x-corporate' ) . '</strong><br/>';
			$content .= esc_html__( 'Slider Image:', 'x-corporate' ) . ' 1920px X 850px';
		}

		return $content;

	}

endif;

add_filter( 'admin_post_thumbnail_html', 'x_corporate_featured_image_instruction', 10, 2 );

if ( ! function_exists( 'x_corporate_custom_content_width' ) ) :

	/**
	 * Custom content width.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_custom_content_width() {

		global $post, $wp_query, $content_width;

		$global_layout = x_corporate_get_option( 'global_layout' );
		$global_layout = apply_filters( 'x_corporate_filter_theme_global_layout', $global_layout );

		// Check if single template.
		if ( $post  && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'x_corporate_settings', true );
			if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
				$global_layout = $post_options['post_layout'];
			}
		}
		switch ( $global_layout ) {

			case 'no-sidebar':
				$content_width = 1220;
				break;

			case 'three-columns':
				$content_width = 570;
				break;

			case 'left-sidebar':
			case 'right-sidebar':
				$content_width = 895;
				break;

			default:
				break;
		}

	}
endif;

add_filter( 'template_redirect', 'x_corporate_custom_content_width' );
