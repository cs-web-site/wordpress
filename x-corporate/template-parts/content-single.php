<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package X_Corporate
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Hook - x_corporate_single_image.
	 *
	 * @hooked x_corporate_add_image_in_single_display - 10
	 */
	do_action( 'x_corporate_single_image' );
	?>
	<header class="entry-header">
		<div class="entry-meta">
			<?php x_corporate_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'x-corporate' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php x_corporate_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

