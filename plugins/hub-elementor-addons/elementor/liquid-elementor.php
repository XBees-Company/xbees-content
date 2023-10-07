<?php
namespace LiquidElementor;

/**
 * Class Liquid_Elementor
 *
 * Main Plugin class
 * @since 1.0
 */
class Liquid_Elementor {

	/**
	 * Instance
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 */
	public function __construct() {

		include LD_ELEMENTOR_PATH . 'elementor/hooks/global-controls-css.php';
		include LD_ELEMENTOR_PATH . 'elementor/hooks/icon-manager.php';
		include LD_ELEMENTOR_PATH . 'elementor/hooks/section-controls.php';
		include LD_ELEMENTOR_PATH . 'elementor/params/params.php';
		include LD_ELEMENTOR_PATH . 'classes/typekit.php';
		include LD_ELEMENTOR_PATH . 'classes/admin-menu.php';
		include LD_ELEMENTOR_PATH . 'elementor/hooks/hooks.php';
		
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 */
	public function register_widgets() {

		// Header Footer Widgets
		if ( !\Elementor\Plugin::$instance->editor->is_edit_mode() || 
		( \Elementor\Plugin::$instance->editor->is_edit_mode() && (get_post_type() === 'liquid-header') || get_post_type() === 'elementor_library') ) {
			require __DIR__ . '/widgets/header-dropdown.php';
			require __DIR__ . '/widgets/header-fullproj.php';
			require __DIR__ . '/widgets/header-image.php';
			require __DIR__ . '/widgets/header-menu.php';
			require __DIR__ . '/widgets/header-search.php';
			require __DIR__ . '/widgets/header-separator.php';
			require __DIR__ . '/widgets/header-scroll-indicator.php';
			require __DIR__ . '/widgets/header-iconbox.php';
			require __DIR__ . '/widgets/header-trigger.php';
			require __DIR__ . '/widgets/sidedrawer.php';
			require __DIR__ . '/widgets/fullscreen-nav.php';

			// Woocommerce
			if ( class_exists( 'woocommerce' ) ) {
				require __DIR__ . '/widgets/header-cart.php';
				require __DIR__ . '/widgets/header-woo-search.php';
			}
		}
		// Porfolio Widgets
		if ( !\Elementor\Plugin::$instance->editor->is_edit_mode() || 
		( \Elementor\Plugin::$instance->editor->is_edit_mode() && (get_post_type() === 'liquid-portfolio') || get_post_type() === 'elementor_library') ) {
			require __DIR__ . '/widgets/pf-single-cover.php';
			require __DIR__ . '/widgets/pf-single-meta.php';
			require __DIR__ . '/widgets/pf-single-nav.php';
			require __DIR__ . '/widgets/pf-single-related.php';
		}
		// General Widgets
		require __DIR__ . '/widgets/1button.php';
		require __DIR__ . '/widgets/accordion.php';
		require __DIR__ . '/widgets/animated-blob.php';
		require __DIR__ . '/widgets/animated-frame.php';
		require __DIR__ . '/widgets/asymmetric-slider.php';
		require __DIR__ . '/widgets/banner.php';
		require __DIR__ . '/widgets/banner-bananas.php';
		require __DIR__ . '/widgets/blog.php';
		require __DIR__ . '/widgets/breadcrumb.php';
		require __DIR__ . '/widgets/carousel-stack.php';
		require __DIR__ . '/widgets/carousel.php';
		require __DIR__ . '/widgets/countdown.php';
		require __DIR__ . '/widgets/counter.php';
		require __DIR__ . '/widgets/custom-menu.php';
		require __DIR__ . '/widgets/custom-list.php';
		require __DIR__ . '/widgets/draw-shape.php';
		require __DIR__ . '/widgets/fancy-heading.php';
		require __DIR__ . '/widgets/fancy-box.php';
		require __DIR__ . '/widgets/fancy-image.php';
		require __DIR__ . '/widgets/flipbox.php';
		require __DIR__ . '/widgets/gallery.php';
		require __DIR__ . '/widgets/icon-box-circle.php';
		require __DIR__ . '/widgets/icon-box.php';
		require __DIR__ . '/widgets/image-comparison.php';
		require __DIR__ . '/widgets/image-text-slider.php';
		require __DIR__ . '/widgets/instagram.php';
		require __DIR__ . '/widgets/lottie.php';
		require __DIR__ . '/widgets/masked-image.php';
		require __DIR__ . '/widgets/media-element.php';
		require __DIR__ . '/widgets/modal-window.php';
		require __DIR__ . '/widgets/milestone.php';
		require __DIR__ . '/widgets/newsletter.php';
		require __DIR__ . '/widgets/particles.php';
		require __DIR__ . '/widgets/google-map.php';
		require __DIR__ . '/widgets/hotspots.php';
		require __DIR__ . '/widgets/process-box.php';
		require __DIR__ . '/widgets/progressbar.php';
		require __DIR__ . '/widgets/progressbar-circle.php';
		require __DIR__ . '/widgets/promo.php';
		require __DIR__ . '/widgets/roadmap.php';
		require __DIR__ . '/widgets/section-flow.php';
		require __DIR__ . '/widgets/schedule-table.php';
		require __DIR__ . '/widgets/portfolio.php';
		require __DIR__ . '/widgets/price-table.php';
		require __DIR__ . '/widgets/slideshow-2.php';
		require __DIR__ . '/widgets/slideshow.php';
		require __DIR__ . '/widgets/team-member.php';
		require __DIR__ . '/widgets/table.php';
		require __DIR__ . '/widgets/tabs.php';
		require __DIR__ . '/widgets/text-reveal.php';
		require __DIR__ . '/widgets/testimonial-carousel-stack.php';
		require __DIR__ . '/widgets/testimonial-carousel.php';
		require __DIR__ . '/widgets/testimonial.php';
		require __DIR__ . '/widgets/throwable.php';
		require __DIR__ . '/widgets/typewriter.php';
		require __DIR__ . '/widgets/overlay-link.php';
		require __DIR__ . '/widgets/image-text-overlay.php';
		require __DIR__ . '/widgets/device-gallery-laptop.php';
		require __DIR__ . '/widgets/device-gallery-mobile.php';
		require __DIR__ . '/widgets/interactive-text-image.php';
		// Woocommerce Widgets
		if ( class_exists( 'woocommerce' ) ) {
			require __DIR__ . '/widgets/woo-checkout-params.php';
			require __DIR__ . '/widgets/woo-order-params.php';
			require __DIR__ . '/widgets/woo-product-add-to-cart.php';
			require __DIR__ . '/widgets/woo-product-description.php';
			require __DIR__ . '/widgets/woo-product-image.php';
			require __DIR__ . '/widgets/woo-product-meta.php';
			require __DIR__ . '/widgets/woo-product-price.php';
			require __DIR__ . '/widgets/woo-product-rating.php';
			require __DIR__ . '/widgets/woo-product-related.php';
			require __DIR__ . '/widgets/woo-product-sharing.php';
			require __DIR__ . '/widgets/woo-product-tabs.php';
			require __DIR__ . '/widgets/woo-product-title.php';
			require __DIR__ . '/widgets/woo-product-upsell.php';
			require __DIR__ . '/widgets/woo-products-list.php';
			require __DIR__ . '/widgets/woo-products.php';
		}

		if ( defined( 'WPCF7_PLUGIN' ) ) {
			require __DIR__ . '/widgets/contact-form.php';
		}
		
	}

}

// Instantiate Plugin Class
Liquid_Elementor::instance();