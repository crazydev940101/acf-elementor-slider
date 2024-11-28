<?php
/**
 * Plugin Name: ACF Image Slider for Elementor
 * Description: A custom Elementor widget to display an ACF Image array field in a slider.
 * Version: 1.0.1
 * Author: Maia Internet Consulting.
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}



// Register the widget
function register_acf_elementor_widget( $widgets_manager ) {

    require_once( __DIR__ . '/widgets/acf-image-slider.php' );

    $widgets_manager->register( new \Elementor_ACF_Image_Slider_Widget() );

}

add_action( 'elementor/widgets/register', 'register_acf_elementor_widget' );



// Enqueue Slick Slider styles and scripts, as well as custom styles and scripts
function enqueue_acf_elementor_slider_assets() {
        
    // Custom styles for the slider
    wp_enqueue_style( 'acf-elementor-slider-css', plugin_dir_url( __FILE__ ) . 'assets/style.css' );

    // Custom script for the slider
    wp_enqueue_script( 'acf-elementor-slider-js', plugin_dir_url( __FILE__ ) . 'assets/script.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_acf_elementor_slider_assets' );

