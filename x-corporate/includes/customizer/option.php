<?php
/**
 * Theme Options.
 *
 * @package X_Corporate
 */

$default = x_corporate_get_default_theme_options();

// Add theme options panel.
$wp_customize->add_panel( 'theme_option_panel',
	array(
	'title'      => esc_html__( 'Theme Options', 'x-corporate' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);

// Header Section.
$wp_customize->add_section( 'section_header',
	array(
	'title'      => esc_html__( 'Header Options', 'x-corporate' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting show_title.
$wp_customize->add_setting( 'theme_options[show_title]',
	array(
	'default'           => $default['show_title'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[show_title]',
	array(
	'label'    => esc_html__( 'Show Site Title', 'x-corporate' ),
	'section'  => 'section_header',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting show_tagline.
$wp_customize->add_setting( 'theme_options[show_tagline]',
	array(
	'default'           => $default['show_tagline'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[show_tagline]',
	array(
	'label'    => esc_html__( 'Show Tagline', 'x-corporate' ),
	'section'  => 'section_header',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[contact_number]',
	array(
	'default'           => $default['contact_number'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[contact_number]',
	array(
	'label'    => esc_html__( 'Contact Number', 'x-corporate' ),
	'section'  => 'section_header',
	'type'     => 'text',
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[contact_email]',
	array(
	'default'           => $default['contact_email'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_email',
	)
);
$wp_customize->add_control( 'theme_options[contact_email]',
	array(
	'label'    => esc_html__( 'Contact Email', 'x-corporate' ),
	'section'  => 'section_header',
	'type'     => 'text',
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[contact_address]',
	array(
	'default'           => $default['contact_address'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[contact_address]',
	array(
	'label'    => esc_html__( 'Contact Address', 'x-corporate' ),
	'section'  => 'section_header',
	'type'     => 'text',
	'priority' => 100,
	)
);

// Setting show_social_in_header.
$wp_customize->add_setting( 'theme_options[show_social_in_header]',
	array(
		'default'           => $default['show_social_in_header'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'x_corporate_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[show_social_in_header]',
	array(
		'label'    => esc_html__( 'Enable Social Icons', 'x-corporate' ),
		'section'  => 'section_header',
		'type'     => 'checkbox',
		'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[show_search_in_header]',
	array(
		'default'           => $default['show_search_in_header'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'x_corporate_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[show_search_in_header]',
	array(
		'label'    => esc_html__( 'Enable Search Form', 'x-corporate' ),
		'section'  => 'section_header',
		'type'     => 'checkbox',
		'priority' => 100,
	)
);

// Snowflakes Section.
$wp_customize->add_section( 'section_snowflakes',
	array(
	'title'      => esc_html__( 'Snowflakes Options', 'x-corporate' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting show_snowflakes.
$wp_customize->add_setting( 'theme_options[show_snowflakes]',
	array(
	'default'           => $default['show_snowflakes'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[show_snowflakes]',
	array(
		'label'           => esc_html__( 'Show Snowflakes', 'x-corporate' ),
		'section'         => 'section_snowflakes',
		'type'            => 'checkbox',
		'priority'        => 100,
	)
);

// Layout Section.
$wp_customize->add_section( 'section_layout',
	array(
	'title'      => esc_html__( 'Layout Options', 'x-corporate' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting global_layout.
$wp_customize->add_setting( 'theme_options[global_layout]',
	array(
	'default'           => $default['global_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[global_layout]',
	array(
	'label'    => esc_html__( 'Global Layout', 'x-corporate' ),
	'section'  => 'section_layout',
	'type'     => 'select',
	'choices'  => x_corporate_get_global_layout_options(),
	'priority' => 100,
	)
);
// Setting archive_layout.
$wp_customize->add_setting( 'theme_options[archive_layout]',
	array(
	'default'           => $default['archive_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[archive_layout]',
	array(
	'label'    => esc_html__( 'Archive Layout', 'x-corporate' ),
	'section'  => 'section_layout',
	'type'     => 'select',
	'choices'  => x_corporate_get_archive_layout_options(),
	'priority' => 100,
	)
);

// Footer Section.
$wp_customize->add_section( 'section_footer',
	array(
	'title'      => esc_html__( 'Footer Options', 'x-corporate' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting copyright_text.
$wp_customize->add_setting( 'theme_options[copyright_text]',
	array(
	'default'           => $default['copyright_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[copyright_text]',
	array(
	'label'    => esc_html__( 'Copyright Text', 'x-corporate' ),
	'section'  => 'section_footer',
	'type'     => 'text',
	'priority' => 100,
	)
);

// Setting go_to_top_status.
$wp_customize->add_setting( 'theme_options[go_to_top_status]',
	array(
		'default'           => $default['go_to_top_status'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'x_corporate_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[go_to_top_status]',
	array(
		'label'       => esc_html__( 'Enable Go To Top', 'x-corporate' ),
		'section'     => 'section_footer',
		'type'        => 'checkbox',
		'priority'    => 100,
	)
);

// Blog Section.
$wp_customize->add_section( 'section_blog',
	array(
	'title'      => esc_html__( 'Blog Options', 'x-corporate' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting excerpt_length.
$wp_customize->add_setting( 'theme_options[excerpt_length]',
	array(
	'default'           => $default['excerpt_length'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_positive_integer',
	)
);
$wp_customize->add_control( 'theme_options[excerpt_length]',
	array(
	'label'       => esc_html__( 'Excerpt Length', 'x-corporate' ),
	'description' => esc_html__( 'in words', 'x-corporate' ),
	'section'     => 'section_blog',
	'type'        => 'number',
	'priority'    => 100,
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 55px;' ),
	)
);
// Setting read_more_text.
$wp_customize->add_setting( 'theme_options[read_more_text]',
	array(
	'default'           => $default['read_more_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[read_more_text]',
	array(
	'label'    => esc_html__( 'Read More Text', 'x-corporate' ),
	'section'  => 'section_blog',
	'type'     => 'text',
	'priority' => 100,
	)
);

// Setting exclude_categories.
$wp_customize->add_setting( 'theme_options[exclude_categories]',
	array(
	'default'           => $default['exclude_categories'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[exclude_categories]',
	array(
	'label'       => esc_html__( 'Exclude Categories in Blog', 'x-corporate' ),
	'description' => esc_html__( 'Enter category ID to exclude in Blog Page. Separate with comma if more than one.', 'x-corporate' ),
	'section'     => 'section_blog',
	'type'        => 'text',
	'priority'    => 100,
	)
);

// Breadcrumb Section.
$wp_customize->add_section( 'section_breadcrumb',
	array(
	'title'      => esc_html__( 'Breadcrumb Options', 'x-corporate' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting breadcrumb_type.
$wp_customize->add_setting( 'theme_options[breadcrumb_type]',
	array(
	'default'           => $default['breadcrumb_type'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[breadcrumb_type]',
	array(
	'label'       => esc_html__( 'Breadcrumb Type', 'x-corporate' ),
	'section'     => 'section_breadcrumb',
	'type'        => 'select',
	'choices'     => x_corporate_get_breadcrumb_type_options(),
	'priority'    => 100,
	)
);
