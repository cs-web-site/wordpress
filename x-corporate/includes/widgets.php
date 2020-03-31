<?php
/**
 * Custom Theme widgets.
 *
 * @package X_Corporate
 */

// Load widget helper.
require_once get_template_directory() . '/vendors/widget-helper/widget-helper.php';

if ( ! function_exists( 'x_corporate_register_widgets' ) ) :

	/**
	 * Register widgets.
	 *
	 * @since 1.0.0
	 */
	function x_corporate_register_widgets() {

		// Social widget.
		register_widget( 'X_Corporate_Social_Widget' );

		// Featured Page widget.
		register_widget( 'X_Corporate_Featured_Page_Widget' );

		// Pages Blocks widget.
		register_widget( 'X_Corporate_Pages_Blocks_Widget' );

		// Call To Action widget.
		register_widget( 'X_Corporate_Call_To_Action_Widget' );

		// Advanced Recent Posts widget.
		register_widget( 'X_Corporate_Advanced_Recent_Posts_Widget' );

		// Latest News widget.
		register_widget( 'X_Corporate_Latest_News_Widget' );

		// Services widget.
		register_widget( 'X_Corporate_Services_Widget' );
	}

endif;

add_action( 'widgets_init', 'x_corporate_register_widgets' );

if ( ! class_exists( 'X_Corporate_Social_Widget' ) ) :

	/**
	 * Social widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Corporate_Social_Widget extends X_Corporate_Widget_Helper {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$args['id']    = 'x-corporate-social';
			$args['label'] = esc_html__( 'XC: Social', 'x-corporate' );

			$args['widget'] = array(
				'classname'                   => 'x_corporate_widget_social',
				'description'                 => esc_html__( 'Social Icons Widget', 'x-corporate' ),
				'customize_selective_refresh' => true,
			);

			$args['fields'] = array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'x-corporate' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				);

			parent::create_widget( $args );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$values = $this->get_field_values( $instance );
			$values['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo $args['before_widget'];

			// Render widget title.
			if ( ! empty( $values['title'] ) ) {
				echo $args['before_title'] . esc_html( $values['title'] ) . $args['after_title'];
			}

			if ( has_nav_menu( 'social' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'social',
					'container'      => false,
					'depth'          => 1,
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>',
				) );
			}

			echo $args['after_widget'];

		}

	}

endif;

if ( ! class_exists( 'X_Corporate_Featured_Page_Widget' ) ) :

	/**
	 * Featured page widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Corporate_Featured_Page_Widget extends X_Corporate_Widget_Helper {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$args['id']    = 'x-corporate-featured-page';
			$args['label'] = esc_html__( 'XC: Featured Page', 'x-corporate' );

			$args['widget'] = array(
				'classname'                   => 'x_corporate_widget_featured_page',
				'description'                 => esc_html__( 'Displays single featured Page', 'x-corporate' ),
				'customize_selective_refresh' => true,
			);

			$args['fields'] = array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'x-corporate' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'featured_page' => array(
					'label'            => esc_html__( 'Select Page:', 'x-corporate' ),
					'type'             => 'dropdown-pages',
					'show_option_none' => esc_html__( '&mdash; Select &mdash;', 'x-corporate' ),
					),
				'content_type' => array(
					'label'   => esc_html__( 'Show Content:', 'x-corporate' ),
					'type'    => 'select',
					'default' => 'full',
					'choices' => array(
						'short' => esc_html__( 'Short', 'x-corporate' ),
						'full'  => esc_html__( 'Full', 'x-corporate' ),
						),
					),
				'excerpt_length' => array(
					'label'       => esc_html__( 'Excerpt Length:', 'x-corporate' ),
					'description' => esc_html__( 'Applies when Short is selected in Show Content.', 'x-corporate' ),
					'type'        => 'number',
					'default'     => 40,
					'min'         => 1,
					'max'         => 100,
					'style'       => 'max-width:60px;',
					),
				'featured_image' => array(
					'label'   => esc_html__( 'Select Image:', 'x-corporate' ),
					'type'    => 'select',
					'default' => 'medium',
					'choices' => x_corporate_get_image_sizes_options(),
					),
				'featured_image_alignment' => array(
					'label'   => esc_html__( 'Select Image Alignment:', 'x-corporate' ),
					'type'    => 'select',
					'default' => 'left',
					'choices' => x_corporate_get_image_alignment_options(),
					),
				);

			parent::create_widget( $args );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$values = $this->get_field_values( $instance );
			$values['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo $args['before_widget'];

			if ( absint( $values['featured_page'] ) > 0 ) {

				$qargs = array(
					'p'             => absint( $values['featured_page'] ),
					'post_type'     => 'page',
					'no_found_rows' => true,
					);

				$the_query = new WP_Query( $qargs );

				if ( $the_query->have_posts() ) {

					while ( $the_query->have_posts() ) {
						$the_query->the_post();

						// Display featured image.
						if ( 'disable' !== $values['featured_image'] && has_post_thumbnail() ) {
							the_post_thumbnail( esc_attr( $values['featured_image'] ), array( 'class' => 'align' . esc_attr( $values['featured_image_alignment'] ) ) );
						}

						echo '<div class="featured-page-widget">';

						// Render widget title.
						if ( ! empty( $values['title'] ) ) {
							echo $args['before_title'] . esc_html( $values['title'] ) . $args['after_title'];
						}

						if ( 'short' === $values['content_type'] ) {
							if ( absint( $values['excerpt_length'] ) > 0 ) {
								$excerpt = x_corporate_get_the_excerpt( absint( $values['excerpt_length'] ) );
								echo wp_kses_post( wpautop( $excerpt ) );
								echo '<a href="' . esc_url( get_permalink() ) . '" class="custom-button">' . esc_html__( 'Read more', 'x-corporate' ) . '</a>';
							}
						} else {
							the_content();
						}

						echo '</div><!-- .featured-page-widget -->';

					} // End while.

					// Reset.
					wp_reset_postdata();

				} // End if.
			}

			echo $args['after_widget'];

		}

	}

endif;

if ( ! class_exists( 'X_Corporate_Pages_Blocks_Widget' ) ) :

	/**
	 * Pages Blocks widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Corporate_Pages_Blocks_Widget extends X_Corporate_Widget_Helper {

		/**
		 * Block count.
		 *
		 * @since 1.0.0
		 *
		 * @var int Block count.
		 */
		protected $block_count;

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$this->block_count = 8;

			$args['id']    = 'x-corporate-pages-blocks';
			$args['label'] = esc_html__( 'XC: Pages Blocks', 'x-corporate' );

			$args['widget'] = array(
				'classname'                   => 'x_corporate_widget_pages_blocks',
				'description'                 => esc_html__( 'Displays pages blocks.', 'x-corporate' ),
				'customize_selective_refresh' => true,
			);

			$args['fields'] = array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'x-corporate' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => esc_html__( 'Subtitle:', 'x-corporate' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'featured_image' => array(
					'label'   => esc_html__( 'Featured Image:', 'x-corporate' ),
					'type'    => 'select',
					'default' => 'medium',
					'choices' => x_corporate_get_image_sizes_options(),
					),
				'post_column' => array(
					'label'   => esc_html__( 'No of Columns:', 'x-corporate' ),
					'type'    => 'select',
					'default' => 3,
					'choices' => x_corporate_get_numbers_dropdown_options( 2, 4 ),
					'style'   => 'min-width:40px;',
					),
				'excerpt_length' => array(
					'label'       => esc_html__( 'Excerpt Length:', 'x-corporate' ),
					'description' => esc_html__( 'Number of words. Enter 0 to disable.', 'x-corporate' ),
					'type'        => 'number',
					'default'     => 10,
					'min'         => 0,
					'max'         => 500,
					'style'       => 'max-width:60px;',
					),
				'more_text' => array(
					'label'   => esc_html__( 'Read More Text:', 'x-corporate' ),
					'class'   => 'widefat',
					'type'    => 'text',
					'default' => esc_html__( 'Read more', 'x-corporate' ),
					),
				'pages_blocks_separator' => array(
					'label' => '',
					'type'  => 'separator',
					),
				);

			for ( $i = 1; $i <= $this->block_count ; $i++ ) {
				$block_fields[ 'block_page_' . $i ] = array(
						'label'            => sprintf( esc_html__( 'Page - %d:', 'x-corporate' ), $i ),
						'type'             => 'dropdown-pages',
						'show_option_none' => esc_html__( '&mdash; Select &mdash;', 'x-corporate' ),
					);

				$args['fields'] = array_merge( $args['fields'], $block_fields );
			}

			parent::create_widget( $args );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$values = $this->get_field_values( $instance );
			$values['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo $args['before_widget'];

			// Render widget title.
			if ( ! empty( $values['title'] ) ) {
				echo $args['before_title'] . esc_html( $values['title'] ) . $args['after_title'];
			}

			// Render widget subtitle.
			if ( ! empty( $values['subtitle'] ) ) {
				echo '<h3 class="subtitle">' . esc_html( $values['subtitle'] ) . '</h3>';
			}

			$pages_array = array();
			for ( $i = 1; $i <= $this->block_count; $i++ ) {
				$page = 0;

				if ( ! empty( $values[ 'block_page_' . $i ] ) && absint( $values[ 'block_page_' . $i ] ) > 0 ) {
					$page = absint( $values[ 'block_page_' . $i ] );
				}

				if ( $page > 0 ) {
					$pages_array[] = absint( $values[ 'block_page_' . $i ] );
				}

				if ( ! empty( $pages_array ) ) {
					$pages_array = array_unique( $pages_array );
				}
			}

			// Render content.
			if ( ! empty( $pages_array ) ) {
				$extra_args = array(
					'featured_image' => $values['featured_image'],
					'post_column'    => $values['post_column'],
					'excerpt_length' => $values['excerpt_length'],
					'more_text'      => $values['more_text'],
				);
				$this->render_widget_content( $pages_array, $extra_args );
			}

			echo $args['after_widget'];

		}

		/**
		 * Render content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $pages Pages.
		 * @param array $args  Arguments.
		 */
		function render_widget_content( $pages, $args ) {

			$qargs = array(
				'no_found_rows'  => true,
				'orderby'        => 'post__in',
				'post__in'       => $pages,
				'post_type'      => 'page',
				'posts_per_page' => count( $pages ),
			);

			$the_query = new WP_Query( $qargs );
			?>

			<?php if ( $the_query->have_posts() ) : ?>

				<div class="pages-blocks pages-blocks-column-<?php echo absint( $args['post_column'] ); ?>">
					<div class="inner-wrapper">
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
							<div class="block-item">
								<div class="block-item-inner">
									<?php if ( 'disable' !== $args['featured_image'] && has_post_thumbnail() ) : ?>
										<div class="block-item-thumb">
											<a href="<?php the_permalink(); ?>">
												<?php
												$img_attributes = array( 'class' => 'aligncenter' );
												the_post_thumbnail( esc_attr( $args['featured_image'] ), $img_attributes );
												?>
											</a>
										</div><!-- .block-item-thumb -->
									<?php endif; ?>
									<div class="block-content-wrap">
										<h3 class="block-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<?php if ( absint( $args['excerpt_length'] ) > 0 ) : ?>
											<div class="block-content-summary">
												<?php
												$excerpt = x_corporate_get_the_excerpt( absint( $args['excerpt_length'] ) );
												echo wp_kses_post( wpautop( $excerpt ) );
												?>
											</div><!-- .block-content-summary -->
										<?php endif; ?>

										<?php if ( ! empty( $args['more_text'] ) ) : ?>
											<a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html( $args['more_text'] ); ?></a>
										<?php endif; ?>
									</div><!-- .block-content-wrap -->
								</div><!-- .block-item-inner -->
							</div><!-- .block-item -->
						<?php endwhile; ?>

						<?php wp_reset_postdata(); ?>

					</div><!-- .inner-wrapper -->
				</div><!-- .pages-blocks -->

			<?php endif; ?>
			<?php
		}

	}

endif;

if ( ! class_exists( 'X_Corporate_Call_To_Action_Widget' ) ) :

	/**
	 * Call To Action widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Corporate_Call_To_Action_Widget extends X_Corporate_Widget_Helper {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$args['id']    = 'x-corporate-call-to-action';
			$args['label'] = esc_html__( 'XC: Call To Action', 'x-corporate' );

			$args['widget'] = array(
				'classname'                   => 'x_corporate_widget_call_to_action',
				'description'                 => esc_html__( 'Call To Action Widget', 'x-corporate' ),
				'customize_selective_refresh' => true,
			);

			$args['fields'] = array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'x-corporate' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'text' => array(
					'label' => esc_html__( 'Text:', 'x-corporate' ),
					'type'  => 'textarea',
					'class' => 'widefat',
					),
				'primary_button_text' => array(
					'label'   => esc_html__( 'Primary Button Text:', 'x-corporate' ),
					'default' => esc_html__( 'Learn more', 'x-corporate' ),
					'type'    => 'text',
					'class'   => 'widefat',
					),
				'primary_button_url' => array(
					'label'   => esc_html__( 'Primary Button URL:', 'x-corporate' ),
					'type'    => 'url',
					'default' => home_url( '/' ),
					'class'   => 'widefat',
					),
				'secondary_button_text' => array(
					'label'   => esc_html__( 'Secondary Button Text:', 'x-corporate' ),
					'default' => '',
					'type'    => 'text',
					'class'   => 'widefat',
					),
				'secondary_button_url' => array(
					'label' => esc_html__( 'Secondary Button URL:', 'x-corporate' ),
					'type'  => 'url',
					'class' => 'widefat',
					),
				'background_image' => array(
					'label'       => esc_html__( 'Background Image:', 'x-corporate' ),
					'description' => sprintf( esc_html__( 'Recommended image size: %1$dpx X %2$dpx', 'x-corporate' ), 1920, 600 ),
					'type'        => 'image',
					),
				);

			parent::create_widget( $args );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$values = $this->get_field_values( $instance );
			$values['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			// Add background image.
			if ( ! empty( $values['background_image'] ) ) {
				$background_style = '';
				$background_style .= ' style="background-image:url(' . esc_url( $values['background_image'] ) . ');" ';
				$args['before_widget'] = implode( $background_style . ' class="', explode( 'class="', $args['before_widget'], 2 ) );
			}

			echo $args['before_widget'];

			echo '<div class="cta-content">';

			// Render widget title.
			if ( ! empty( $values['title'] ) ) {
				echo $args['before_title'] . esc_html( $values['title'] ) . $args['after_title'];
			}

			if ( ! empty( $values['text'] ) ) {
				echo wp_kses_post( wpautop( $values['text'] ) );
			}

			echo '</div>';
			?>
			<?php if ( ( ! empty( $values['primary_button_text'] ) && ! empty( $values['primary_button_url'] ) ) || ( ! empty( $values['secondary_button_text'] ) && ! empty( $values['secondary_button_url'] ) ) ) : ?>
				<div class="call-to-action-buttons">
					<?php if ( ! empty( $values['primary_button_url'] ) && ! empty( $values['primary_button_text'] ) ) : ?>
						<a href="<?php echo esc_url( $values['primary_button_url'] ); ?>" class="button custom-button button-primary"><?php echo esc_attr( $values['primary_button_text'] ); ?></a>
					<?php endif; ?>
					<?php if ( ! empty( $values['secondary_button_url'] ) && ! empty( $values['secondary_button_text'] ) ) : ?>
						<a href="<?php echo esc_url( $values['secondary_button_url'] ); ?>" class="button custom-button button-secondary"><?php echo esc_attr( $values['secondary_button_text'] ); ?></a>
					<?php endif; ?>
				</div><!-- .call-to-action-buttons -->
			<?php endif;

			echo $args['after_widget'];

		}

	}

endif;

if ( ! class_exists( 'X_Corporate_Advanced_Recent_Posts_Widget' ) ) :

	/**
	 * Advanced recent posts widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Corporate_Advanced_Recent_Posts_Widget extends X_Corporate_Widget_Helper {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$args['id']    = 'x-corporate-advanced-recent-posts';
			$args['label'] = esc_html__( 'XC: Advanced Recent Posts', 'x-corporate' );

			$args['widget'] = array(
				'classname'                   => 'x_corporate_widget_advanced_recent_posts',
				'description'                 => esc_html__( 'Advanced Recent Posts Widget. Displays recent posts with thumbnail.', 'x-corporate' ),
				'customize_selective_refresh' => true,
			);

			$args['fields'] = array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'x-corporate' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'post_category' => array(
					'label'           => esc_html__( 'Select Category:', 'x-corporate' ),
					'type'            => 'dropdown-taxonomies',
					'show_option_all' => esc_html__( 'All Categories', 'x-corporate' ),
					),
				'featured_image' => array(
					'label'   => esc_html__( 'Featured Image:', 'x-corporate' ),
					'type'    => 'select',
					'default' => 'thumbnail',
					'choices' => x_corporate_get_image_sizes_options( true, array( 'disable', 'thumbnail' ), false ),
					),
				'image_width' => array(
					'label'       => esc_html__( 'Image Width:', 'x-corporate' ),
					'description' => esc_html__( 'px', 'x-corporate' ),
					'type'        => 'number',
					'default'     => 90,
					'min'         => 1,
					'max'         => 150,
					'style'       => 'max-width:60px;',
					'newline'     => false,
					),
				'post_number' => array(
					'label'   => esc_html__( 'No of Posts:', 'x-corporate' ),
					'type'    => 'number',
					'default' => 4,
					'min'     => 1,
					'max'     => 50,
					'style'   => 'max-width:60px;',
					),
				'excerpt_length' => array(
					'label'       => esc_html__( 'Excerpt Length:', 'x-corporate' ),
					'description' => esc_html__( 'Number of words. Enter 0 to disable.', 'x-corporate' ),
					'type'        => 'number',
					'default'     => 10,
					'min'         => 0,
					'max'         => 100,
					'style'       => 'max-width:60px;',
					),
				'disable_date' => array(
					'label'   => esc_html__( 'Disable Date', 'x-corporate' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				);

			parent::create_widget( $args );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$values = $this->get_field_values( $instance );
			$values['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo $args['before_widget'];

			// Render widget title.
			if ( ! empty( $values['title'] ) ) {
				echo $args['before_title'] . esc_html( $values['title'] ) . $args['after_title'];
			}

			?>
			<?php
			$qargs = array(
				'posts_per_page'      => absint( $values['post_number'] ),
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
				);

			if ( absint( $values['post_category'] ) > 0 ) {
				$qargs['cat'] = $values['post_category'];
			}

			$the_query = new WP_Query( $qargs );
			?>
			<?php if ( $the_query->have_posts() ) : ?>

				<div class="advanced-recent-posts-widget">

					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<div class="advanced-recent-posts-item">

							<?php if ( 'disable' !== $values['featured_image'] && has_post_thumbnail() ) : ?>
								<div class="advanced-recent-posts-thumb">
									<a href="<?php the_permalink(); ?>">
										<?php
										$img_attributes = array(
											'class' => 'alignleft',
											'style' => 'max-width:' . esc_attr( $values['image_width'] ) . 'px;',
											);
										the_post_thumbnail( esc_attr( $values['featured_image'] ), $img_attributes );
										?>
									</a>
								</div>
							<?php endif; ?>
							<div class="advanced-recent-posts-text-wrap">
								<h3 class="advanced-recent-posts-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>

								<?php if ( false === $values['disable_date'] ) : ?>
									<div class="advanced-recent-posts-meta">
										<span class="advanced-recent-posts-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
									</div>
								<?php endif; ?>

								<?php if ( absint( $values['excerpt_length'] ) > 0 ) : ?>
									<div class="advanced-recent-posts-summary">
									<?php
									$excerpt = x_corporate_get_the_excerpt( absint( $values['excerpt_length'] ) );
									echo wp_kses_post( wpautop( $excerpt ) );
									?>
									</div>
								<?php endif; ?>
							</div><!-- .advanced-recent-posts-text-wrap -->

						</div><!-- .advanced-recent-posts-item -->
					<?php endwhile; ?>

				</div><!-- .advanced-recent-posts-widget -->

				<?php wp_reset_postdata(); ?>

			<?php endif; ?>

			<?php

			echo $args['after_widget'];

		}

	}

endif;

if ( ! class_exists( 'X_Corporate_Latest_News_Widget' ) ) :

	/**
	 * Latest news widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Corporate_Latest_News_Widget extends X_Corporate_Widget_Helper {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$args['id']    = 'x-corporate-latest-news';
			$args['label'] = esc_html__( 'XC: Latest News', 'x-corporate' );

			$args['widget'] = array(
				'classname'                   => 'x_corporate_widget_latest_news',
				'description'                 => esc_html__( 'Latest News Widget. Displays latest posts in grid.', 'x-corporate' ),
				'customize_selective_refresh' => true,
			);

			$args['fields'] = array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'x-corporate' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => esc_html__( 'Subtitle:', 'x-corporate' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'post_category' => array(
					'label'           => esc_html__( 'Select Category:', 'x-corporate' ),
					'type'            => 'dropdown-taxonomies',
					'show_option_all' => esc_html__( 'All Categories', 'x-corporate' ),
					),
				'post_column' => array(
					'label'   => esc_html__( 'No of Columns:', 'x-corporate' ),
					'type'    => 'select',
					'default' => 3,
					'choices' => x_corporate_get_numbers_dropdown_options( 1, 4 ),
					'style'   => 'min-width:40px;',
					),
				'featured_image' => array(
					'label'   => esc_html__( 'Featured Image:', 'x-corporate' ),
					'type'    => 'select',
					'default' => 'x-corporate-thumb',
					'choices' => x_corporate_get_image_sizes_options(),
					),
				'post_number' => array(
					'label'   => esc_html__( 'No of Posts:', 'x-corporate' ),
					'type'    => 'number',
					'default' => 3,
					'min'     => 1,
					'max'     => 100,
					'style'   => 'max-width:60px;',
					),
				'excerpt_length' => array(
					'label'       => esc_html__( 'Excerpt Length:', 'x-corporate' ),
					'description' => esc_html__( 'Number of words. Enter 0 to disable.', 'x-corporate' ),
					'type'        => 'number',
					'default'     => 20,
					'min'         => 0,
					'max'         => 300,
					'style'       => 'max-width:60px;',
					),
				'more_text' => array(
					'label'   => esc_html__( 'Read More Text:', 'x-corporate' ),
					'type'    => 'text',
					'class'   => 'widefat',
					'default' => esc_html__( 'Read more', 'x-corporate' ),
					),
				);

			parent::create_widget( $args );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$values = $this->get_field_values( $instance );
			$values['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo $args['before_widget'];

			// Render widget title.
			if ( ! empty( $values['title'] ) ) {
				echo $args['before_title'] . esc_html( $values['title'] ) . $args['after_title'];
			}

			// Render widget subtitle.
			if ( ! empty( $values['subtitle'] ) ) {
				echo '<h3 class="subtitle">' . esc_html( $values['subtitle'] ) . '</h3>';
			}

			$qargs = array(
				'posts_per_page'      => absint( $values['post_number'] ),
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			);

			if ( absint( $values['post_category'] ) > 0 ) {
				$qargs['cat'] = absint( $values['post_category'] );
			}

			$the_query = new WP_Query( $qargs );
			?>
			<?php if ( $the_query->have_posts() ) : ?>

				<div class="latest-news-widget latest-news-col-<?php echo esc_attr( $values['post_column'] ); ?>">

					<div class="inner-wrapper">

						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

							<div class="latest-news-item">
								<div class="latest-news-wrapper">
									<?php if ( 'disable' !== $values['featured_image'] && has_post_thumbnail() ) : ?>
										<div class="latest-news-thumb">
											<a href="<?php the_permalink(); ?>">
												<?php
												$img_attributes = array( 'class' => 'aligncenter' );
												the_post_thumbnail( esc_attr( $values['featured_image'] ), $img_attributes );
												?>
											</a>
										</div><!-- .latest-news-thumb -->
									<?php endif; ?>
									<div class="latest-news-text-wrap">
										<h3 class="latest-news-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
										<div class="latest-news-meta">
											<span class="posted-on"><?php the_time( get_option( 'date_format' ) ); ?></span>
											<?php
											if ( comments_open( get_the_ID() ) ) {
												echo '<span class="comments-link">';
												comments_popup_link( '<span class="leave-reply">' . esc_html__( '0 Comment', 'x-corporate' ) . '</span>', esc_html__( '1 Comment', 'x-corporate' ), esc_html__( '% Comments', 'x-corporate' ) );
												echo '</span>';
											}
											?>
										</div><!-- .latest-news-meta -->

										<?php if ( absint( $values['excerpt_length'] ) > 0 ) : ?>
											<div class="latest-news-summary">
												<?php
												$excerpt = x_corporate_get_the_excerpt( absint( $values['excerpt_length'] ) );
												echo wp_kses_post( wpautop( $excerpt ) );
												?>
											</div><!-- .latest-news-summary -->
										<?php endif; ?>
										<?php if ( ! empty( $values['more_text'] ) ) : ?>
											<div class="latest-news-read-more">
												<a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html( $values['more_text'] ); ?></a>
											</div>
										<?php endif; ?>
									</div><!-- .latest-news-text-wrap -->
								</div><!-- .latest-news-wrapper -->
							</div><!-- .latest-news-item -->

						<?php endwhile; ?>

					</div><!-- .inner-wrapper -->
				</div><!-- .latest-news-widget -->

				<?php wp_reset_postdata(); ?>

			<?php endif; ?>

			<?php

			echo $args['after_widget'];

		}

	}

endif;

if ( ! class_exists( 'X_Corporate_Services_Widget' ) ) :

	/**
	 * Services widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Corporate_Services_Widget extends X_Corporate_Widget_Helper {

		/**
		 * Block count.
		 *
		 * @since 1.0.0
		 *
		 * @var int Block count.
		 */
		protected $block_count;

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$this->block_count = 6;

			$args['id']    = 'x-corporate-services';
			$args['label'] = esc_html__( 'XC: Services', 'x-corporate' );

			$args['widget'] = array(
				'classname'                   => 'x_corporate_widget_services',
				'description'                 => esc_html__( 'Displays services pages with icon and read more link.', 'x-corporate' ),
				'customize_selective_refresh' => true,
			);

			$args['fields'] = array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'x-corporate' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => esc_html__( 'Subtitle:', 'x-corporate' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'excerpt_length' => array(
					'label'       => esc_html__( 'Excerpt Length:', 'x-corporate' ),
					'description' => esc_html__( 'Number of words. Enter 0 to disable.', 'x-corporate' ),
					'type'        => 'number',
					'default'     => 15,
					'min'         => 0,
					'max'         => 400,
					'style'       => 'max-width:60px;',
					),
				'more_text' => array(
					'label'   => esc_html__( 'Read More Text:', 'x-corporate' ),
					'type'    => 'text',
					'default' => esc_html__( 'Read more', 'x-corporate' ),
					'class'   => 'widefat',
					),
				'post_column' => array(
					'label'   => esc_html__( 'No of Columns:', 'x-corporate' ),
					'type'    => 'select',
					'default' => 3,
					'choices' => x_corporate_get_numbers_dropdown_options( 3, 4 ),
					'style'   => 'min-width:40px;',
					),
				'layout' => array(
					'label'   => esc_html__( 'Select Layout:', 'x-corporate' ),
					'type'    => 'select',
					'default' => 1,
					'choices' => x_corporate_get_numbers_dropdown_options( 1, 2, esc_html__( 'Layout', 'x-corporate' ) . ' ' ),
					),
				);

			for ( $i = 1; $i <= $this->block_count ; $i++ ) {
				$block_fields[ 'heading_' . $i ] = array(
						'label' => sprintf( esc_html__( 'Block %d', 'x-corporate' ), $i ),
						'type'  => 'heading',
					);
				$block_fields[ 'block_page_' . $i ] = array(
						'label'            => esc_html__( 'Page:', 'x-corporate' ),
						'type'             => 'dropdown-pages',
						'show_option_none' => esc_html__( '&mdash; Select &mdash;', 'x-corporate' ),
					);
				$block_fields[ 'block_icon_' . $i ] = array(
						'label'       => esc_html__( 'Icon:', 'x-corporate' ),
						'type'        => 'text',
						'default'     => 'fa-cogs',
						'placeholder' => esc_html__( 'eg: fa-cogs', 'x-corporate' ),
					);

				if ( 1 === $i ) {
					$block_fields[ 'message_' . $i ] = array(
							'label' => '<a href="http://fontawesome.io/cheatsheet/" target="_blank">' . esc_html__( 'View Font Awesome Reference', 'x-corporate' ) . '</a>',
							'type'  => 'message',
						);
				}

				$args['fields'] = array_merge( $args['fields'], $block_fields );
			}

			parent::create_widget( $args );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$values = $this->get_field_values( $instance );
			$values['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			// Add layout class.
			$layout_class = 'services-layout-' . absint( $values['layout'] );
			$args['before_widget'] = implode( 'class="' . $layout_class . ' ', explode( 'class="', $args['before_widget'], 2 ) );

			echo $args['before_widget'];

			// Render widget title.
			if ( ! empty( $values['title'] ) ) {
				echo $args['before_title'] . esc_html( $values['title'] ) . $args['after_title'];
			}

			// Render widget subtitle.
			if ( ! empty( $values['subtitle'] ) ) {
				echo '<h3 class="subtitle">' . esc_html( $values['subtitle'] ) . '</h3>';
			}

			$services_array = array();
			for ( $i = 1; $i <= $this->block_count; $i++ ) {
				$page = 0;
				if ( ! empty( $values[ 'block_page_' . $i ] ) && absint( $values[ 'block_page_' . $i ] ) > 0 ) {
					$page = absint( $values[ 'block_page_' . $i ] );
				}
				if ( $page > 0 ) {
					$sitem = array();
					$sitem['page'] = $page;
					$sitem['icon'] = '';

					if ( ! empty( $values[ 'block_icon_' . $i ] ) ) {
						$sitem['icon'] = $values[ 'block_icon_' . $i ];
					}

					$services_array[] = $sitem;
				}
			}

			// Render content.
			if ( ! empty( $services_array ) ) {
				$extra_args = array(
					'post_column'    => $values['post_column'],
					'excerpt_length' => $values['excerpt_length'],
					'more_text'      => $values['more_text'],
				);
				$this->render_widget_content( $services_array, $extra_args );
			}

			echo $args['after_widget'];

		}

		/**
		 * Render services.
		 *
		 * @since 1.0.0
		 *
		 * @param array $services Services details.
		 * @param array $args     Arguments.
		 */
		function render_widget_content( $services, $args = array() ) {

			global $post;

			$ids = wp_list_pluck( $services, 'page' );

			$qargs = array(
				'post_type'           => 'page',
				'no_found_rows'       => true,
				'post__in'            => $ids,
				'posts_per_page'      => count( $ids ),
				'orderby'             => 'post__in',
				'ignore_sticky_posts' => true,
			);

			$the_query = new WP_Query( $qargs );

			if ( ! $the_query->have_posts() ) {
				return;
			}
			?>
			<div class="service-block-list service-col-<?php echo esc_attr( $args['post_column'] ); ?>">
				<div class="inner-wrapper">

					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<?php
							$icon_item = wp_filter_object_list( $services, array( 'page' => get_the_ID() ), 'and', 'icon' );
							$icon = array_shift( $icon_item );
						?>

						<div class="service-block-item">
							<div class="service-block-inner">
								<?php if ( ! empty( $icon ) ) : ?>
									<a class="services-icon" href="<?php the_permalink(); ?>">
										<i class="<?php echo esc_attr( 'fa ' . $icon ); ?>"></i>
									</a>
								<?php endif; ?>
								<div class="service-block-inner-content">
									<h3 class="service-item-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<?php if ( absint( $args['excerpt_length'] ) > 0 ) : ?>
										<div class="service-block-item-excerpt">
											<?php
												$excerpt = x_corporate_get_the_excerpt( absint( $args['excerpt_length'] ) );
												echo wp_kses_post( wpautop( $excerpt ) );
											?>
										</div><!-- .service-block-item-excerpt -->
									<?php endif; ?>

									<?php if ( ! empty( $args['more_text'] ) ) : ?>
										<a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html( $args['more_text'] ); ?></a>
									<?php endif; ?>
								</div><!-- .service-block-inner-content -->
							</div><!-- .service-block-inner -->
						</div><!-- .service-block-item -->

						<?php wp_reset_postdata(); ?>

					<?php endwhile; ?>

				</div><!-- .inner-wrapper -->
			</div><!-- .service-block-list -->
			<?php
		}

	}

endif;
