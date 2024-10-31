<?php


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


if ( ! function_exists ( 'oxsn_banner_customizer' ) ) {

	add_action( 'customize_register', 'oxsn_banner_customizer' );
	function oxsn_banner_customizer( $wp_customize ) {
	   
		$wp_customize->add_panel( 'oxsn_plugin_panel', array(
			'priority'       => '',
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => 'OXSN Plugins',
			'description'    => '',
		) );

		$wp_customize->add_section( 'oxsn_banner_section' , array(
			'priority'       => '',
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => 'Banner',
			'description'    => '',
			'panel'  => 'oxsn_plugin_panel',
		) );

		$wp_customize->add_setting( 'oxsn_banner_default_control', array(

		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'oxsn_banner_default_control', array(
			'label'    => 'Default Banner',
			'section'  => 'oxsn_banner_section',
			'settings' => 'oxsn_banner_default_control',
		) ) );

		$wp_customize->add_setting( 'oxsn_banner_blog_control', array(

		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'oxsn_banner_blog_control', array(
			'label'    => 'Blog Banner',
			'section'  => 'oxsn_banner_section',
			'settings' => 'oxsn_banner_default_control',
		) ) );

		$wp_customize->add_setting( 'oxsn_banner_search_control', array(

		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'oxsn_banner_search_control', array(
			'label'    => 'Search Banner',
			'section'  => 'oxsn_banner_section',
			'settings' => 'oxsn_banner_default_control',
		) ) );

		$wp_customize->add_setting( 'oxsn_banner_error_control', array(

		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'oxsn_banner_error_control', array(
			'label'    => '404 Banner',
			'section'  => 'oxsn_banner_section',
			'settings' => 'oxsn_banner_default_control',
		) ) );

	}

}


?>