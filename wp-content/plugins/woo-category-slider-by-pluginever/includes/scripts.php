<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action('wp_enqueue_scripts', 'register_woo_category_slider_scripts',10);
function register_woo_category_slider_scripts(){
	wp_enqueue_style('cat-slider-style', WOO_CAT_SLIDER_URL . '/css/style.min.css');
	wp_register_script('cat-slider-script-slick', WOO_CAT_SLIDER_URL . '/js/slick.js',array( 'jquery' ), NULL, false);
	wp_enqueue_script('cat-slider-script-slick');
}