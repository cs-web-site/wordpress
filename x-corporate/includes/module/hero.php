<?php
/**
 * Hero implementation
 *
 * @package X_Corporate
 */

if ( ! function_exists( 'x_corporate_add_hero_section' ) ) :

	/**
	 * Add hero section.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_add_hero_section() {

		$flag_hero = apply_filters( 'x_corporate_filter_hero_status', true );

		if ( true !== $flag_hero ) {
			return;
		}

		$hero_type = x_corporate_get_option( 'hero_type' );

		switch ( $hero_type ) {
			case 'banner':
				// Render banner.
				x_corporate_render_hero_banner();
				break;

			case 'slider':
				// Render slider.
				x_corporate_render_hero_slider();
				break;

			default:
				break;
		}
	}

endif;

add_action( 'x_corporate_action_before_content', 'x_corporate_add_hero_section', 5 );

if ( ! function_exists( 'x_corporate_check_hero_status' ) ) :

	/**
	 * Check status of hero.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $input Hero status.
	 */
	function x_corporate_check_hero_status( $input ) {

		$input = false;

		$hero_status = x_corporate_get_option( 'hero_status' );

		switch ( $hero_status ) {
			case 'home-page':
				if ( is_front_page() ) {
					$input = true;
				}
				break;

			case 'disabled':
				$input = false;
				break;

			default:
				break;
		}

		return $input;

	}

endif;

add_filter( 'x_corporate_filter_hero_status', 'x_corporate_check_hero_status' );


if ( ! function_exists( 'x_corporate_render_hero_banner' ) ) :

	/**
	 * Render hero banner.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_render_hero_banner() {

		$hero_banner_image        = get_header_image();
		$hero_banner_title        = x_corporate_get_option( 'hero_banner_title' );
		$hero_banner_subtitle     = x_corporate_get_option( 'hero_banner_subtitle' );
		$hero_banner_button_label = x_corporate_get_option( 'hero_banner_button_label' );
		$hero_banner_button_url   = x_corporate_get_option( 'hero_banner_button_url' );
		?>
		<div id="hero-banner">
			<?php if ( false !== $hero_banner_image ) : ?>
				<img src="<?php echo esc_url( $hero_banner_image ); ?>" alt="<?php echo esc_attr( $hero_banner_title ); ?>" />
			<?php endif; ?>
			<div class="hero-caption">
				<div class="container">
					<?php if ( ! empty( $hero_banner_title ) ) : ?>
						<h3 class="hero-title"><?php echo esc_html( $hero_banner_title ); ?></h3>
					<?php endif; ?>
					<?php if ( ! empty( $hero_banner_subtitle ) ) : ?>
						<div class="hero-subtitle"><?php echo esc_html( $hero_banner_subtitle ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $hero_banner_button_label ) && ! empty( $hero_banner_button_url ) ) : ?>
						<a href="<?php echo esc_url( $hero_banner_button_url ); ?>" class="button hero-button"><?php echo esc_html( $hero_banner_button_label ); ?></a>
					<?php endif; ?>
				</div><!-- .container -->
			</div><!-- .hero-caption -->

			<!-- NEWS 最新情報  -->
			<?php if ( have_posts() ) : ?>
				<div class="hero-container">
					<div class="hero-container__title">
						<p>NEWS -最新情報-</p>
						<a href="#">ニュース一覧</a>
					</div>
					<div>
						<ul class="hero-news">
							<?php $i = 0; while ( have_posts() && $i < 3 ) : the_post(); ?>
								<?php get_template_part('template-parts/content-news', 'none'); $i++?>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		</div><!-- #hero-banner -->
		<?php
	}

endif;

if ( ! function_exists( 'x_corporate_render_hero_slider' ) ) :

	/**
	 * Render hero slider.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_render_hero_slider() {

		$slider_details = array();
		$slider_details = apply_filters( 'x_corporate_filter_slider_details', $slider_details );

		if ( empty( $slider_details ) ) {
			return;
		}

		x_corporate_render_featured_slider( $slider_details );
	}

endif;

if ( ! function_exists( 'x_corporate_get_slider_details' ) ) :

	/**
	 * Slider details.
	 *
	 * @since 1.0.0
	 *
	 * @param array $input Slider details.
	 */
	function x_corporate_get_slider_details( $input ) {

		$featured_slider_type           = x_corporate_get_option( 'featured_slider_type' );
		$featured_slider_number         = x_corporate_get_option( 'featured_slider_number' );
		$featured_slider_read_more_text = x_corporate_get_option( 'featured_slider_read_more_text' );

		switch ( $featured_slider_type ) {

			case 'featured-page':

				$ids = array();

				for ( $i = 1; $i <= $featured_slider_number ; $i++ ) {
					$id = x_corporate_get_option( 'featured_slider_page_' . $i );
					if ( ! empty( $id ) ) {
						$ids[] = absint( $id );
					}
				}

				// Bail if no valid ids.
				if ( empty( $ids ) ) {
					return $input;
				}

				$qargs = array(
					'posts_per_page'   => esc_attr( $featured_slider_number ),
					'no_found_rows'    => true,
					'orderby'          => 'post__in',
					'post_type'        => 'page',
					'post__in'         => $ids,
					'suppress_filters' => false,
					'meta_query'       => array(
						array( 'key' => '_thumbnail_id' ),
					),
				);

				// Fetch posts.
				$all_posts = get_posts( $qargs );
				$slides = array();

				if ( ! empty( $all_posts ) ) {

					$cnt = 0;
					foreach ( $all_posts as $key => $post ) {

						if ( has_post_thumbnail( $post->ID ) ) {
							$image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
							$slides[ $cnt ]['images']  = $image_array;
							$slides[ $cnt ]['title']   = $post->post_title;
							$slides[ $cnt ]['url']     = get_permalink( $post->ID );
							$slides[ $cnt ]['excerpt'] = x_corporate_get_the_excerpt( apply_filters( 'x_corporate_filter_slider_caption_length', 30 ), $post );

							if ( ! empty( $featured_slider_read_more_text ) ) {
								$slides[ $cnt ]['primary_button_text'] = $featured_slider_read_more_text;
								$slides[ $cnt ]['primary_button_url']  = $slides[ $cnt ]['url'];
							}

							$cnt++;
						}
					}
				}

				if ( ! empty( $slides ) ) {
					$input = $slides;
				}

			break;

			default:
			break;
		}

		return $input;
	}

endif;

add_filter( 'x_corporate_filter_slider_details', 'x_corporate_get_slider_details' );

if ( ! function_exists( 'x_corporate_render_featured_slider' ) ) :

	/**
	 * Render featured slider.
	 *
	 * @since 1.0.0
	 *
	 * @param array $slider_details Details of slider content.
	 */
	function x_corporate_render_featured_slider( $slider_details = array() ) {

		if ( empty( $slider_details ) ) {
			return;
		}

		$featured_slider_transition_effect   = x_corporate_get_option( 'featured_slider_transition_effect' );
		$featured_slider_enable_caption      = x_corporate_get_option( 'featured_slider_enable_caption' );
		$featured_slider_enable_arrow        = x_corporate_get_option( 'featured_slider_enable_arrow' );
		$featured_slider_enable_pager        = x_corporate_get_option( 'featured_slider_enable_pager' );
		$featured_slider_enable_autoplay     = x_corporate_get_option( 'featured_slider_enable_autoplay' );
		$featured_slider_enable_overlay      = x_corporate_get_option( 'featured_slider_enable_overlay' );
		$featured_slider_transition_duration = x_corporate_get_option( 'featured_slider_transition_duration' );
		$featured_slider_transition_delay    = x_corporate_get_option( 'featured_slider_transition_delay' );

		// Cycle data.
		$slide_data = array(
			'fx'             => esc_attr( $featured_slider_transition_effect ),
			'speed'          => absint( $featured_slider_transition_duration ) * 1000,
			'pause-on-hover' => 'true',
			'loader'         => 'true',
			'log'            => 'false',
			'swipe'          => 'true',
			'auto-height'    => 'container',
			'slides'         => 'article',
		);

		if ( $featured_slider_enable_pager ) {
			$slide_data['pager-template'] = '<span class="pager-box"></span>';
		}

		if ( $featured_slider_enable_autoplay ) {
			$slide_data['timeout'] = absint( $featured_slider_transition_delay ) * 1000;
		} else {
			$slide_data['timeout'] = 0;
		}

		$slide_attributes_text = '';

		foreach ( $slide_data as $key => $item ) {
			$slide_attributes_text .= ' ';
			$slide_attributes_text .= ' data-cycle-' . esc_attr( $key );
			$slide_attributes_text .= '="' . esc_attr( $item ) . '"';
		}

		$extra_slider_classes = ( true === $featured_slider_enable_overlay ) ? 'slider-overlay-enabled' : 'slider-overlay-disabled' ;
	?>
	<div id="featured-slider">

		<div class="cycle-slideshow <?php echo esc_attr( $extra_slider_classes ); ?>" id="main-slider" <?php echo $slide_attributes_text; ?>>

			<?php if ( $featured_slider_enable_arrow ) : ?>
				<div class="cycle-prev"><i aria-hidden="true" class="fa fa-angle-left"></i></div>
				<div class="cycle-next"><i aria-hidden="true" class="fa fa-angle-right"></i></div>
			<?php endif; ?>

			<?php $cnt = 1; ?>

			<?php foreach ( $slider_details as $key => $slide ) : ?>

				<?php
				$url = '';

				if ( ! empty( $slide['url'] ) ) {
					$url = $slide['url'];
				}

				$class_text = ( 1 === $cnt ) ? 'first' : '';

				// Buttons markup.
				$buttons_markup = '';
				$primary_button_text   = ! empty( $slide['primary_button_text'] ) ? $slide['primary_button_text'] : '';
				$primary_button_url    = ! empty( $slide['primary_button_url'] ) ? $slide['primary_button_url'] : '';
				$secondary_button_text = ! empty( $slide['secondary_button_text'] ) ? $slide['secondary_button_text'] : '';
				$secondary_button_url  = ! empty( $slide['secondary_button_url'] ) ? $slide['secondary_button_url'] : '';

				if ( ! empty( $primary_button_text ) || ! empty( $secondary_button_text ) ) {
					$buttons_markup .= '<div class="slider-buttons">';

					if ( ! empty( $primary_button_text ) ) {
						$buttons_markup .= '<a href="' . esc_url( $primary_button_url ) . '" class="custom-button slider-button button-primary">' . esc_html( $primary_button_text ) . '</a>';
					}

					if ( ! empty( $secondary_button_text ) ) {
						$buttons_markup .= '<a href="' . esc_url( $secondary_button_url ) . '" class="custom-button slider-button button-secondary">' . esc_html( $secondary_button_text ) . '</a>';
					}

					$buttons_markup .= '</div>';
				}
				?>
				<article class="<?php echo esc_attr( $class_text ); ?>"
					data-cycle-title="<?php echo esc_attr( $slide['title'] ); ?>"
					data-cycle-url="<?php echo esc_url( $url ); ?>"
					data-cycle-excerpt="<?php echo esc_attr( $slide['excerpt'] ); ?>"
					data-cycle-buttons="<?php echo esc_attr( $buttons_markup ); ?>" >
						<?php if ( ! empty( $slide['url'] ) ) : ?>
						<a href="<?php echo esc_url( $slide['url'] ); ?>">
						<?php endif; ?>
						<img src="<?php echo esc_url( $slide['images'][0] ); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>" />
						<?php if ( ! empty( $slide['url'] ) ) : ?>
						</a>
						<?php endif; ?>

						<?php if ( $featured_slider_enable_caption ) : ?>
							<div class="cycle-caption">
								<div class="caption-wrap">
									<h3><a href="<?php echo esc_url( $slide['url'] ); ?>"><?php echo esc_attr( $slide['title'] ); ?></a></h3>
									<p><?php echo esc_attr( $slide['excerpt'] ); ?></p>
									<?php echo wp_kses_post( $buttons_markup ); ?>
								</div><!-- .cycle-wrap -->
							</div><!-- .cycle-caption -->
						<?php endif; ?>

				</article>

				<?php $cnt++; ?>

			<?php endforeach; ?>

			<?php if ( $featured_slider_enable_pager ) : ?>
				<div class="cycle-pager"></div>
			<?php endif ?>

		</div> <!-- #main-slider -->

	</div><!-- #featured-slider -->

	<?php

	}

endif;
