<?php
/**
 * Theme Options related to hero
 *
 * @package X_Corporate
 */

$default = x_corporate_get_default_theme_options();

// Add Panel.
$wp_customize->add_panel( 'theme_hero_panel',
	array(
	'title'      => esc_html__( 'Hero Options', 'x-corporate' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);

// Hero Type Section.
$wp_customize->add_section( 'section_theme_hero_type',
	array(
	'title'      => esc_html__( 'Hero Type', 'x-corporate' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_hero_panel',
	)
);

// Setting hero_status.
$wp_customize->add_setting( 'theme_options[hero_status]',
	array(
	'default'           => $default['hero_status'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[hero_status]',
	array(
	'label'    => esc_html__( 'Enable Hero Section On', 'x-corporate' ),
	'section'  => 'section_theme_hero_type',
	'type'     => 'select',
	'priority' => 100,
	'choices'  => x_corporate_get_hero_content_options(),
	)
);

// Setting hero_type.
$wp_customize->add_setting( 'theme_options[hero_type]',
	array(
	'default'           => $default['hero_type'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[hero_type]',
	array(
	'label'           => esc_html__( 'Hero Type', 'x-corporate' ),
	'section'         => 'section_theme_hero_type',
	'type'            => 'select',
	'priority'        => 100,
	'choices'         => x_corporate_get_hero_type(),
	'active_callback' => 'x_corporate_is_hero_active',
	)
);

// Setting hero_banner_title.
$wp_customize->add_setting( 'theme_options[hero_banner_title]',
	array(
	'default'           => $default['hero_banner_title'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[hero_banner_title]',
	array(
	'label'           => esc_html__( 'Banner Title', 'x-corporate' ),
	'section'         => 'section_theme_hero_type',
	'type'            => 'text',
	'priority'        => 100,
	'active_callback' => 'x_corporate_is_hero_banner_active',
	)
);

// Setting hero_banner_subtitle.
$wp_customize->add_setting( 'theme_options[hero_banner_subtitle]',
	array(
	'default'           => $default['hero_banner_subtitle'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[hero_banner_subtitle]',
	array(
	'label'           => esc_html__( 'Banner Subtitle', 'x-corporate' ),
	'section'         => 'section_theme_hero_type',
	'type'            => 'text',
	'priority'        => 100,
	'active_callback' => 'x_corporate_is_hero_banner_active',
	)
);

// Setting hero_banner_button_label.
$wp_customize->add_setting( 'theme_options[hero_banner_button_label]',
	array(
	'default'           => $default['hero_banner_button_label'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[hero_banner_button_label]',
	array(
	'label'           => esc_html__( 'Button Label', 'x-corporate' ),
	'section'         => 'section_theme_hero_type',
	'type'            => 'text',
	'priority'        => 100,
	'active_callback' => 'x_corporate_is_hero_banner_active',
	)
);

// Setting hero_banner_button_url.
$wp_customize->add_setting( 'theme_options[hero_banner_button_url]',
	array(
	'default'           => $default['hero_banner_button_url'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[hero_banner_button_url]',
	array(
	'label'           => esc_html__( 'Button URL', 'x-corporate' ),
	'section'         => 'section_theme_hero_type',
	'type'            => 'text',
	'priority'        => 100,
	'active_callback' => 'x_corporate_is_hero_banner_active',
	)
);

// Setting featured_slider_type.
$wp_customize->add_setting( 'theme_options[featured_slider_type]',
	array(
	'default'           => $default['featured_slider_type'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[featured_slider_type]',
	array(
	'label'           => esc_html__( 'Select Slider Type', 'x-corporate' ),
	'section'         => 'section_theme_hero_type',
	'type'            => 'select',
	'priority'        => 100,
	'choices'         => x_corporate_get_featured_slider_type(),
	'active_callback' => 'x_corporate_is_hero_slider_active',
	)
);

// Setting featured_slider_number.
$wp_customize->add_setting( 'theme_options[featured_slider_number]',
	array(
	'default'           => $default['featured_slider_number'],
	'capability'        => 'edit_theme_options',
	'transport'         => 'postMessage',
	'sanitize_callback' => 'x_corporate_sanitize_number_range',
	)
);
$wp_customize->add_control( 'theme_options[featured_slider_number]',
	array(
	'label'           => esc_html__( 'No of Slides', 'x-corporate' ),
	'description'     => esc_html__( 'Enter number between 1 and 5. Save and refresh the page if No of Slides is changed.', 'x-corporate' ),
	'section'         => 'section_theme_hero_type',
	'type'            => 'number',
	'priority'        => 100,
	'active_callback' => 'x_corporate_is_hero_slider_active',
	'input_attrs'     => array( 'min' => 1, 'max' => 5, 'step' => 1, 'style' => 'width: 55px;' ),
	)
);

$featured_slider_number = absint( x_corporate_get_option( 'featured_slider_number' ) );

if ( $featured_slider_number > 0 ) {
	for ( $i = 1; $i <= $featured_slider_number; $i++ ) {
		$wp_customize->add_setting( "theme_options[featured_slider_page_$i]",
			array(
			'default'           => isset( $default[ 'featured_slider_page_' . $i ] ) ? $default[ 'featured_slider_page_' . $i ] : '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'x_corporate_sanitize_dropdown_pages',
			)
		);
		$wp_customize->add_control( "theme_options[featured_slider_page_$i]",
			array(
			'label'           => esc_html__( 'Featured Page', 'x-corporate' ) . ' - ' . $i,
			'section'         => 'section_theme_hero_type',
			'type'            => 'dropdown-pages',
			'priority'        => 100,
			'active_callback' => 'x_corporate_is_hero_page_slider_active',
			)
		);
	} // End for loop.
}

// Setting featured_slider_read_more_text.
$wp_customize->add_setting( 'theme_options[featured_slider_read_more_text]',
	array(
	'default'           => $default['featured_slider_read_more_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[featured_slider_read_more_text]',
	array(
	'label'           => esc_html__( 'Read More Text', 'x-corporate' ),
	'section'         => 'section_theme_hero_type',
	'type'            => 'text',
	'priority'        => 100,
	'active_callback' => 'x_corporate_is_hero_slider_active',
	)
);

// Slider Options Section.
$wp_customize->add_section( 'section_theme_slider_options',
	array(
	'title'      => esc_html__( 'Slider Options', 'x-corporate' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_hero_panel',
	)
);

// Setting featured_slider_transition_effect.
$wp_customize->add_setting( 'theme_options[featured_slider_transition_effect]',
	array(
	'default'           => $default['featured_slider_transition_effect'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[featured_slider_transition_effect]',
	array(
	'label'    => esc_html__( 'Transition Effect', 'x-corporate' ),
	'section'  => 'section_theme_slider_options',
	'type'     => 'select',
	'priority' => 100,
	'choices'  => x_corporate_get_featured_slider_transition_effects(),
	)
);

// Setting featured_slider_transition_delay.
$wp_customize->add_setting( 'theme_options[featured_slider_transition_delay]',
	array(
	'default'           => $default['featured_slider_transition_delay'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_number_range',
	)
);
$wp_customize->add_control( 'theme_options[featured_slider_transition_delay]',
	array(
	'label'       => esc_html__( 'Transition Delay', 'x-corporate' ),
	'description' => esc_html__( 'in seconds', 'x-corporate' ),
	'section'     => 'section_theme_slider_options',
	'type'        => 'number',
	'priority'    => 100,
	'input_attrs' => array( 'min' => 1, 'max' => 10, 'step' => 1, 'style' => 'width: 55px;' ),
	)
);
// Setting featured_slider_transition_duration.
$wp_customize->add_setting( 'theme_options[featured_slider_transition_duration]',
	array(
	'default'           => $default['featured_slider_transition_duration'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_number_range',
	)
);
$wp_customize->add_control( 'theme_options[featured_slider_transition_duration]',
	array(
	'label'       => esc_html__( 'Transition Duration', 'x-corporate' ),
	'description' => esc_html__( 'in seconds', 'x-corporate' ),
	'section'     => 'section_theme_slider_options',
	'type'        => 'number',
	'priority'    => 100,
	'input_attrs' => array( 'min' => 1, 'max' => 10, 'step' => 1, 'style' => 'width: 55px;' ),
	)
);
// Setting featured_slider_enable_caption.
$wp_customize->add_setting( 'theme_options[featured_slider_enable_caption]',
	array(
	'default'           => $default['featured_slider_enable_caption'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[featured_slider_enable_caption]',
	array(
	'label'    => esc_html__( 'Enable Caption', 'x-corporate' ),
	'section'  => 'section_theme_slider_options',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);
// Setting featured_slider_enable_arrow.
$wp_customize->add_setting( 'theme_options[featured_slider_enable_arrow]',
	array(
	'default'           => $default['featured_slider_enable_arrow'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[featured_slider_enable_arrow]',
	array(
	'label'    => esc_html__( 'Enable Arrow', 'x-corporate' ),
	'section'  => 'section_theme_slider_options',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);
// Setting featured_slider_enable_pager.
$wp_customize->add_setting( 'theme_options[featured_slider_enable_pager]',
	array(
	'default'           => $default['featured_slider_enable_pager'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[featured_slider_enable_pager]',
	array(
	'label'    => esc_html__( 'Enable Pager', 'x-corporate' ),
	'section'  => 'section_theme_slider_options',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);
// Setting featured_slider_enable_autoplay.
$wp_customize->add_setting( 'theme_options[featured_slider_enable_autoplay]',
	array(
	'default'           => $default['featured_slider_enable_autoplay'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[featured_slider_enable_autoplay]',
	array(
	'label'    => esc_html__( 'Enable Autoplay', 'x-corporate' ),
	'section'  => 'section_theme_slider_options',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);
// Setting featured_slider_enable_overlay.
$wp_customize->add_setting( 'theme_options[featured_slider_enable_overlay]',
	array(
	'default'           => $default['featured_slider_enable_overlay'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'x_corporate_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[featured_slider_enable_overlay]',
	array(
	'label'    => esc_html__( 'Enable Overlay', 'x-corporate' ),
	'section'  => 'section_theme_slider_options',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);
