<?php
/**
 * Functions hooked to custom hook.
 *
 * @package X_Corporate
 */

if ( ! function_exists( 'x_corporate_skip_to_content' ) ) :

	/**
	 * Add skip to content.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_skip_to_content() {
		?><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'x-corporate' ); ?></a><?php
	}
endif;

add_action( 'x_corporate_action_before', 'x_corporate_skip_to_content', 15 );

if ( ! function_exists( 'x_corporate_site_branding' ) ) :

	/**
	 * Site branding.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_site_branding() {
		?>
		<div class="site-branding">

			<?php x_corporate_the_custom_logo(); ?>

			<?php $show_title = x_corporate_get_option( 'show_title' ); ?>
			<?php $show_tagline = x_corporate_get_option( 'show_tagline' ); ?>

			<?php if ( true === $show_title || true === $show_tagline ) : ?>
				<div id="site-identity">
					<?php if ( true === $show_title ) : ?>
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( true === $show_tagline ) : ?>
						<p class="site-description"><?php bloginfo( 'description' ); ?></p>
					<?php endif; ?>
				</div><!-- #site-identity -->
			<?php endif; ?>
		</div><!-- .site-branding -->
	<?php
	}

endif;

add_action( 'x_corporate_action_header', 'x_corporate_site_branding' );

if ( ! function_exists( 'x_corporate_mobile_navigation' ) ) :

	/**
	 * Mobile navigation.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_mobile_navigation() {
		?>
		<div class="mobile-nav-wrap">
			<a id="mobile-trigger" href="#mob-menu"><i class="fa fa-list-ul" aria-hidden="true"></i><span><?php esc_html_e( 'Main Menu', 'x-corporate' ); ?><span></a>
			<div id="mob-menu">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => '',
					'fallback_cb'    => 'x_corporate_primary_navigation_fallback',
				) );
				?>
			</div><!-- #mob-menu -->
		</div><!-- .mobile-nav-wrap -->
		<?php
	}

endif;

add_action( 'x_corporate_action_before', 'x_corporate_mobile_navigation', 20 );

if ( ! function_exists( 'x_corporate_add_top_head_content' ) ) :

	/**
	 * Add top head section.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_add_top_head_content() {

		// Check if top head content is disabled.
		$status = apply_filters( 'x_corporate_filter_top_head_status', false );

		if ( true !== $status ) {
			return;
		}
		?>
		<div id="tophead">
			<div class="container">
				<?php x_corporate_render_quick_contact(); ?>

				<?php $show_search_in_header = x_corporate_get_option( 'show_search_in_header' ); ?>
				<?php if ( true === $show_search_in_header ) : ?>
					<div class="header-search-box">
						<a href="#" class="search-icon"><i class="fa fa-search"></i></a>
						<div class="search-box-wrap">
							<?php get_search_form(); ?>
						</div>
					</div><!-- .header-search-box -->
				<?php endif; ?>
				<?php if ( true === x_corporate_get_option( 'show_social_in_header' ) && has_nav_menu( 'social' ) ) : ?>
					<div id="header-social">
						<?php the_widget( 'X_Corporate_Social_Widget' ); ?>
					</div><!-- #header-social -->
				<?php endif; ?>


			</div><!-- .container -->
		</div><!-- #tophead -->
		<?php
	}

endif;

add_action( 'x_corporate_action_before_header', 'x_corporate_add_top_head_content', 5 );

if ( ! function_exists( 'x_corporate_check_top_head_status' ) ) :

	/**
	 * Top head status.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $status Active status.
	 * @return bool Modified status.
	 */
	function x_corporate_check_top_head_status( $status ) {

		$social_status = ( ! ( false === has_nav_menu( 'social' ) || false === x_corporate_get_option( 'show_social_in_header' ) ) ) ? true : false;

		$show_search_in_header = x_corporate_get_option( 'show_search_in_header' );

		$contact_number  = x_corporate_get_option( 'contact_number' );
		$contact_email   = x_corporate_get_option( 'contact_email' );
		$contact_address = x_corporate_get_option( 'contact_address' );

		$address_status = ( ! empty( $contact_number ) || ! empty( $contact_email ) || ! empty( $contact_address ) ) ? true : false;

		if ( true === $social_status || true === $address_status || true === $show_search_in_header ) {
			$status = true;
		}

		return $status;

	}

endif;

add_filter( 'x_corporate_filter_top_head_status', 'x_corporate_check_top_head_status' );

if ( ! function_exists( 'x_corporate_footer_copyright' ) ) :

	/**
	 * Footer copyright.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_footer_copyright() {

		// Check if footer is disabled.
		$footer_status = apply_filters( 'x_corporate_filter_footer_status', true );
		if ( true !== $footer_status ) {
			return;
		}

		// Copyright content.
		$copyright_text = x_corporate_get_option( 'copyright_text' );
		$copyright_text = apply_filters( 'x_corporate_filter_copyright_text', $copyright_text );
		?>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<?php
			$footer_menu_content = wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => 'div',
				'container_id'   => 'footer-navigation',
				'depth'          => 1,
				'fallback_cb'    => false,
			) );
			?>
		<?php endif; ?>
		<?php if ( ! empty( $copyright_text ) ) : ?>
			<div class="copyright">
				<?php echo wp_kses_post( $copyright_text ); ?>
			</div>
		<?php endif; ?>
		<div class="site-info">
			<?php echo esc_html__( 'X Corporate by', 'x-corporate' ) . ' <a target="_blank" rel="nofollow" href="https://axlethemes.com/">Axle Themes</a>'; ?>
		</div>
		<?php
	}

endif;

add_action( 'x_corporate_action_footer', 'x_corporate_footer_copyright', 10 );

if ( ! function_exists( 'x_corporate_add_sidebar' ) ) :

	/**
	 * Add sidebar.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_add_sidebar() {

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

		// Include primary sidebar.
		if ( 'no-sidebar' !== $global_layout ) {
			get_sidebar();
		}

		// Include secondary sidebar.
		switch ( $global_layout ) {
			case 'three-columns':
				get_sidebar( 'secondary' );
				break;

			default:
				break;
		}

	}

endif;

add_action( 'x_corporate_action_sidebar', 'x_corporate_add_sidebar' );

if ( ! function_exists( 'x_corporate_custom_posts_navigation' ) ) :

	/**
	 * Posts navigation.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_custom_posts_navigation() {

		the_posts_pagination();

	}
endif;

add_action( 'x_corporate_action_posts_navigation', 'x_corporate_custom_posts_navigation' );

if ( ! function_exists( 'x_corporate_add_image_in_single_display' ) ) :

	/**
	 * Add image in single template.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_add_image_in_single_display() {

		if ( has_post_thumbnail() ) {
			$args = array(
				'class' => 'x-corporate-post-thumb aligncenter',
			);
			the_post_thumbnail( 'large', $args );
		}

	}

endif;

add_action( 'x_corporate_single_image', 'x_corporate_add_image_in_single_display' );

if ( ! function_exists( 'x_corporate_footer_goto_top' ) ) :

	/**
	 * Go to top.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_footer_goto_top() {
		$go_to_top_status = x_corporate_get_option( 'go_to_top_status' );
		if ( true === $go_to_top_status ) {
			echo '<a href="#page" class="scrollup" id="btn-scrollup"><i class="fa fa-angle-up"></i></a>';
		}
	}

endif;

add_action( 'x_corporate_action_after', 'x_corporate_footer_goto_top', 20 );

if ( ! function_exists( 'x_corporate_add_front_page_widget_area' ) ) :

	/**
	 * Add front page widget area.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_add_front_page_widget_area() {

		if ( is_page_template( 'templates/front.php' ) ) {
			if ( is_active_sidebar( 'sidebar-front-page-widget-area' ) ) {
				echo '<div id="sidebar-front-page-widget-area" class="widget-area">';
				dynamic_sidebar( 'sidebar-front-page-widget-area' );
				echo '</div><!-- #sidebar-front-page-widget-area -->';
			} else {
				if ( current_user_can( 'edit_theme_options' ) ) {
					echo '<div id="sidebar-front-page-widget-area" class="widget-area">';
					x_corporate_message_front_page_widget_area();
					echo '</div><!-- #sidebar-front-page-widget-area -->';
				}
			}
		}

	}
endif;

add_action( 'x_corporate_action_before_content', 'x_corporate_add_front_page_widget_area', 7 );

if ( ! function_exists( 'x_corporate_add_footer_widgets' ) ) :

	/**
	 * Add footer widgets.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_add_footer_widgets() {

		get_template_part( 'template-parts/footer-widgets' );

	}
endif;

add_action( 'x_corporate_action_before_footer', 'x_corporate_add_footer_widgets', 5 );

if ( ! function_exists( 'x_corporate_add_custom_header' ) ) :

	/**
	 * Add custom header.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_add_custom_header() {

		if ( is_front_page() || is_home() || is_page_template('elementor_header_footer') ) {
			return;
		}
		?>
		<div id="custom-header">
			<?php
			/**
			 * Hook - x_corporate_single_image.
			 *
			 * @hooked x_corporate_add_image_in_single_display - 10
			 */
			do_action( 'x_corporate_single_image' );
			?>
			<div class="custom-header-wrapper">
					<?php do_action( 'x_corporate_action_custom_header_title' ); ?>
			</div>
		</div>
		<?php do_action( 'x_corporate_add_breadcrumb' ); ?>
		<?php
	}

endif;

add_action( 'x_corporate_action_before_content', 'x_corporate_add_custom_header', 6 );

if ( ! function_exists( 'x_corporate_add_title_in_custom_header' ) ) :

	/**
	 * Add title in custom header.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_add_title_in_custom_header() {

		echo '<h1 class="page-title">';

		if ( is_home() ) {
			echo esc_html( x_corporate_get_option( 'blog_page_title' ) );
		} elseif ( is_singular() ) {
			echo single_post_title( '', false );
		} elseif ( is_archive() ) {
			the_archive_title();
		} elseif ( is_search() ) {
			printf( esc_html__( 'Search Results for: %s', 'x-corporate' ),  get_search_query() );
		} elseif ( is_404() ) {
			esc_html_e( '404 Error', 'x-corporate' );
		}

		echo '</h1>';

	}

endif;

add_action( 'x_corporate_action_custom_header_title', 'x_corporate_add_title_in_custom_header' );

if ( ! function_exists( 'x_corporate_add_breadcrumb' ) ) :

	/**
	 * Add breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_add_breadcrumb() {

		// Bail if home page.
		if ( is_front_page() || is_home() ) {
			return;
		}

		echo'<div id="breadcrumb">';
		x_corporate_breadcrumb();
		echo '</div>';

	}

endif;

add_action( 'x_corporate_add_breadcrumb', 'x_corporate_add_breadcrumb', 10 );
