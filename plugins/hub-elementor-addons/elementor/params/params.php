<?php 

defined( 'ABSPATH' ) || die();

include LD_ELEMENTOR_PATH . 'elementor/params/advanced-text.php';
include LD_ELEMENTOR_PATH . 'elementor/params/button.php';
include LD_ELEMENTOR_PATH . 'elementor/params/parallax.php';
include LD_ELEMENTOR_PATH . 'elementor/params/animations.php';
include LD_ELEMENTOR_PATH . 'elementor/params/testimonials.php';
if ( class_exists( 'WooCommerce' ) ) {
    include LD_ELEMENTOR_PATH . 'classes/woo-ajax-search.php'; 
}
if( function_exists('liquid_helper') && !empty( liquid_helper()->get_theme_option( 'mailchimp-api-key' ) ) ) {
    include LD_ELEMENTOR_PATH . 'elementor/params/newsletter.php'; 
}