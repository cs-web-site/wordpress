<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package X_Corporate
 */

?><?php
	/**
	 * Hook - x_corporate_action_doctype.
	 *
	 * @hooked x_corporate_doctype - 10
	 */
	do_action( 'x_corporate_action_doctype' );
?>
<head>
	<?php
	/**
	 * Hook - x_corporate_action_head.
	 *
	 * @hooked x_corporate_head - 10
	 */
	do_action( 'x_corporate_action_head' );
	?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	/**
	 * Hook - x_corporate_action_before.
	 *
	 * @hooked x_corporate_page_start - 10
	 * @hooked x_corporate_skip_to_content - 15
	 */
	do_action( 'x_corporate_action_before' );
	?>

	<?php
	  /**
	   * Hook - x_corporate_action_before_header.
	   *
	   * @hooked x_corporate_header_start - 10
	   */
	  do_action( 'x_corporate_action_before_header' );
	?>
		<?php
		/**
		 * Hook - x_corporate_action_header.
		 *
		 * @hooked x_corporate_site_branding - 10
		 */
		do_action( 'x_corporate_action_header' );
		?>
	<?php
	  /**
	   * Hook - x_corporate_action_after_header.
	   *
	   * @hooked x_corporate_header_end - 10
	   * @hooked x_corporate_add_primary_navigation - 20
	   */
	  do_action( 'x_corporate_action_after_header' );
	?>

	<?php
	/**
	 * Hook - x_corporate_action_before_content.
	 *
	 * @hooked x_corporate_add_hero_section - 5
	 * @hooked x_corporate_content_start - 10
	 */
	do_action( 'x_corporate_action_before_content' );
	?>
	<?php
	  /**
	   * Hook - x_corporate_action_content.
	   */
	  do_action( 'x_corporate_action_content' );
