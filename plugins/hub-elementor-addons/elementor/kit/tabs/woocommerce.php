<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Liquid_Global_WooCommerce
 *
 */
class Liquid_Global_WooCommerce extends Tab_Base {

	/**
	 * Liquid_Global_WooCommerce constructor.
	 *
	 * @param Kit::class $parent Kit class.
	 */
	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	/**
	 * Tab ID.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'liquid-woocommerce-style-kit';
	}

	/**
	 * Tab title.
	 *
	 * @return string|void
	 */
	public function get_title() {
		return __( 'WooCommerce', 'creative-hub' );
	}

	/**
	 * Tab Group.
	 *
	 * @return string
	 */
	public function get_group() {
		return 'theme-style';
	}

	/**
	 * Tab icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-woocommerce';
	}

	/**
	 * Tab help URL.
	 *
	 * @return string
	 */
	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	/**
	 * Tab controls.
	 *
	 * Tab controls are hooked mostly on `elementor/element/kit/section_buttons/after_section_end`.
	 */
	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_' . $this->get_id() . '_customize_shop',
			[
				'label' => esc_html__('Shop Page Customization', 'hub-elementor-addons'),
				'tab' => $this->get_id(),
			]
		);

		// body
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'liquid_wc_shop_page_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '.post-type-archive-product #lqd-site-content',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_shop_page_typo',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.post-type-archive-product #lqd-site-content',
			]
		);

		$this->add_control(
			'liquid_wc_shop_page_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.post-type-archive-product #lqd-site-content, .post-type-archive-product #lqd-site-content .ld-shop-topbar' => 'color: {{VALUE}}',
				],
			]
		);

		// title
		$this->add_control(
			'liquid_wc_shop_page_title_heading',
			[
				'label' => esc_html__( 'PRODUCT TITLE', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_shop_page_title_typography',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.post-type-archive-product .ld-sp-info h3 a',
			]
		);

		$this->add_control(
			'liquid_wc_shop_page_title_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.post-type-archive-product .ld-sp-info h3 a' => 'color: {{VALUE}}',
				],
			]
		);

		// price
		$this->add_control(
			'liquid_wc_shop_page_price_heading',
			[
				'label' => esc_html__( 'PRODUCT PRICE', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_shop_page_price_typography',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.post-type-archive-product .ld-sp-info .price',
			]
		);

		$this->add_control(
			'liquid_wc_shop_page_price_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.post-type-archive-product .ld-sp-info .price' => 'color: {{VALUE}}',
				],
			]
		);

		// category
		$this->add_control(
			'liquid_wc_shop_page_category_heading',
			[
				'label' => esc_html__( 'PRODUCT CATEGORY TEXT', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_shop_page_category_typography',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.post-type-archive-product .ld-sp-info .product-category',
			]
		);

		$this->add_control(
			'liquid_wc_shop_page_category_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.post-type-archive-product .ld-sp-info .product-category' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_shop_page_category_color_hover',
			[
				'label' => esc_html__( 'Hover Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.post-type-archive-product .product-category:hover' => 'color: {{VALUE}}',
				],
			]
		);

		// Add to cart 
		$this->add_control(
			'liquid_wc_shop_page_add_to_cart_heading',
			[
				'label' => esc_html__( 'ADD TO CART BUTTON', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_shop_page_product_button_typo',
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'selector' => '.post-type-archive-product .ld-sp-info .ld-sp-btn',
			]
		);

		// Button normal state
		$this->start_controls_tabs(
			'liquid_wc_shop_page_product_button_colors_tab'
		);

		$this->start_controls_tab(
			'liquid_wc_shop_page_product_button_colors_normal',
			[
				'label' => __( 'Normal', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'liquid_wc_shop_page_product_button_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.post-type-archive-product .ld-sp-info .ld-sp-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'liquid_wc_shop_page_product_button_bg',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '.post-type-archive-product .ld-sp-info .ld-sp-btn',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'liquid_wc_shop_page_product_button_border',
				'label' => __( 'Border', 'hub-elementor-addons' ),
				'selector' => '.post-type-archive-product .ld-sp-info .ld-sp-btn',
			]
		);

		$this->add_responsive_control(
			'liquid_wc_shop_page_product_button_border_radius',
			[
				'label' => __( 'Border radius', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'.post-type-archive-product .ld-sp-info .ld-sp-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'liquid_wc_shop_page_product_button_box_shadow',
				'label' => __( 'Box shadow', 'hub-elementor-addons' ),
				'selector' => '.post-type-archive-product .ld-sp-info .ld-sp-btn',
			]
		);

		$this->add_responsive_control(
			'liquid_wc_shop_page_product_button_padding',
			[
				'label' => __( 'Padding', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'.post-type-archive-product .ld-sp-info .ld-sp-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->start_controls_tab(
			'liquid_wc_shop_page_product_button_colors_hover',
			[
				'label' => __( 'Hover', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'liquid_wc_shop_page_product_button_color_hover',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.post-type-archive-product .ld-sp-info .ld-sp-btn:hover, .post-type-archive-product .ld-sp-info .ld-sp-btn:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'liquid_wc_shop_page_product_button_bg_hover',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '.post-type-archive-product .ld-sp-info .ld-sp-btn:hover, .post-type-archive-product .ld-sp-info .ld-sp-btn:focus',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'liquid_wc_shop_page_product_button_border_hover',
				'label' => __( 'Border', 'hub-elementor-addons' ),
				'selector' => '.post-type-archive-product .ld-sp-info .ld-sp-btn:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'liquid_wc_shop_page_product_button_box_shadow_hover',
				'label' => __( 'Box shadow', 'hub-elementor-addons' ),
				'selector' => '.post-type-archive-product .ld-sp-info .ld-sp-btn:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * 
		 * Customize Taxonomies
		 * 
		 */

		$this->start_controls_section(
			'section_' . $this->get_id() . '_customize_taxonomies',
			[
				'label' => esc_html__('Categories & Tags Pages Customization', 'hub-elementor-addons'),
				'tab' => $this->get_id(),
			]
		);

		// body
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'liquid_wc_tax_page_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '.tax-product_cat #lqd-site-content, .tax-product_tag #lqd-site-content',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_tax_page_typo',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.tax-product_cat #lqd-site-content, .tax-product_tag #lqd-site-content',
			]
		);

		$this->add_control(
			'liquid_wc_tax_page_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.tax-product_cat #lqd-site-content, .tax-product_cat #lqd-site-content .ld-shop-topbar, .tax-product_tag #lqd-site-content, .tax-product_tag #lqd-site-content .ld-shop-topbar' => 'color: {{VALUE}}',
				],
			]
		);

		// title
		$this->add_control(
			'liquid_wc_tax_page_title_heading',
			[
				'label' => esc_html__( 'PRODUCT TITLE', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_tax_page_title_typography',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.tax-product_cat .ld-sp-info h3 a, .tax-product_tag .ld-sp-info h3 a',
			]
		);

		$this->add_control(
			'liquid_wc_tax_page_title_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.tax-product_cat .ld-sp-info h3 a, .tax-product_tag .ld-sp-info h3 a' => 'color: {{VALUE}}',
				],
			]
		);

		// price
		$this->add_control(
			'liquid_wc_tax_page_price_heading',
			[
				'label' => esc_html__( 'PRODUCT PRICE', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_tax_page_price_typography',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.tax-product_cat .ld-sp-info .price, .tax-product_tag .ld-sp-info .price',
			]
		);

		$this->add_control(
			'liquid_wc_tax_page_price_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.tax-product_cat .ld-sp-info .price, .tax-product_tag .ld-sp-info .price' => 'color: {{VALUE}}',
				],
			]
		);

		// category
		$this->add_control(
			'liquid_wc_tax_page_category_heading',
			[
				'label' => esc_html__( 'PRODUCT CATEGORY TEXT', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_tax_page_category_typography',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.tax-product_cat .ld-sp-info .product-category, .tax-product_tag .ld-sp-info .product-category',
			]
		);

		$this->add_control(
			'liquid_wc_tax_page_category_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.tax-product_cat .ld-sp-info .product-category, .tax-product_tag .ld-sp-info .product-category' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_tax_page_category_color_hover',
			[
				'label' => esc_html__( 'Hover Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.tax-product_cat .product-category:hover, .tax-product_tag .product-category:hover' => 'color: {{VALUE}}',
				],
			]
		);

		// Add to cart
		$this->add_control(
			'liquid_wc_tax_page_add_to_cart_heading',
			[
				'label' => esc_html__( 'ADD TO CART BUTTON', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_tax_page_product_button_typo',
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'selector' => '.tax-product_cat .ld-sp-info .ld-sp-btn, .tax-product_tag .ld-sp-info .ld-sp-btn',
			]
		);

		// Button normal state
		$this->start_controls_tabs(
			'liquid_wc_tax_page_product_button_colors_tab'
		);

		$this->start_controls_tab(
			'liquid_wc_tax_page_product_button_colors_normal',
			[
				'label' => __( 'Normal', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'liquid_wc_tax_page_product_button_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.tax-product_cat .ld-sp-info .ld-sp-btn, .tax-product_tag .ld-sp-info .ld-sp-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'liquid_wc_tax_page_product_button_bg',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '.tax-product_cat .ld-sp-info .ld-sp-btn, .tax-product_tag .ld-sp-info .ld-sp-btn',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'liquid_wc_tax_page_product_button_border',
				'label' => __( 'Border', 'hub-elementor-addons' ),
				'selector' => '.tax-product_cat .ld-sp-info .ld-sp-btn, .tax-product_tag .ld-sp-info .ld-sp-btn',
			]
		);

		$this->add_responsive_control(
			'liquid_wc_tax_page_product_button_border_radius',
			[
				'label' => __( 'Border radius', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'.tax-product_cat .ld-sp-info .ld-sp-btn, .tax-product_tag .ld-sp-info .ld-sp-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'liquid_wc_tax_page_product_button_box_shadow',
				'label' => __( 'Box shadow', 'hub-elementor-addons' ),
				'selector' => '.tax-product_cat .ld-sp-info .ld-sp-btn, .tax-product_tag .ld-sp-info .ld-sp-btn',
			]
		);

		$this->add_responsive_control(
			'liquid_wc_tax_page_product_button_padding',
			[
				'label' => __( 'Padding', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'.tax-product_cat .ld-sp-info .ld-sp-btn, .tax-product_tag .ld-sp-info .ld-sp-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->start_controls_tab(
			'liquid_wc_tax_page_product_button_colors_hover',
			[
				'label' => __( 'Hover', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'liquid_wc_tax_page_product_button_color_hover',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.tax-product_cat .ld-sp-info .ld-sp-btn:hover, .tax-product_cat .ld-sp-info .ld-sp-btn:focus, .tax-product_tag .ld-sp-info .ld-sp-btn:hover, .tax-product_tag .ld-sp-info .ld-sp-btn:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'liquid_wc_tax_page_product_button_bg_hover',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '.tax-product_cat .ld-sp-info .ld-sp-btn:hover, .tax-product_cat .ld-sp-info .ld-sp-btn:focus, .tax-product_tag .ld-sp-info .ld-sp-btn:hover, .tax-product_tag .ld-sp-info .ld-sp-btn:focus',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'liquid_wc_tax_page_product_button_border_hover',
				'label' => __( 'Border', 'hub-elementor-addons' ),
				'selector' => '.tax-product_cat .ld-sp-info .ld-sp-btn:hover, .tax-product_tag .ld-sp-info .ld-sp-btn:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'liquid_wc_tax_page_product_button_box_shadow_hover',
				'label' => __( 'Box shadow', 'hub-elementor-addons' ),
				'selector' => '.tax-product_cat .ld-sp-info .ld-sp-btn:hover, .tax-product_tag .ld-sp-info .ld-sp-btn:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * 
		 * Customize Single Product
		 * 
		 */

		$this->start_controls_section(
			'section_' . $this->get_id() . '_customize_single_product',
			[
				'label' => esc_html__('Single Product Customization', 'hub-elementor-addons'),
				'tab' => $this->get_id(),
			]
		);

		// body
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'liquid_wc_single_product_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '.single-product #lqd-site-content',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_single_product_typo',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.single-product #lqd-site-content',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #lqd-site-content, .single-product #lqd-site-content .ld-shop-topbar' => 'color: {{VALUE}}',
				],
			]
		);

		// title
		$this->add_control(
			'liquid_wc_single_product_title_heading',
			[
				'label' => esc_html__( 'PRODUCT TITLE', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_single_product_title_typography',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.single-product .product_title',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_title_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product .product_title' => 'color: {{VALUE}}',
				],
			]
		);

		// price
		$this->add_control(
			'liquid_wc_single_product_price_heading',
			[
				'label' => esc_html__( 'PRODUCT PRICE', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_single_product_price_typography',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.single-product div.product p.price',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_price_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product p.price' => 'color: {{VALUE}}',
				],
			]
		);
		
		// short description
		$this->add_control(
			'liquid_wc_single_product_short_description_heading',
			[
				'label' => esc_html__( 'SHORT DESCRIPTION', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_single_product_short_description_typography',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.single-product .woocommerce-product-details__short-description',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_short_description_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product .woocommerce-product-details__short-description' => 'color: {{VALUE}}',
				],
			]
		);

		// meta
		$this->add_control(
			'liquid_wc_single_product_meta_heading',
			[
				'label' => esc_html__( 'PRODUCT META', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_single_product_meta_typography',
				'label' => esc_html__('Typography', 'hub-elementor-addons'),
				'selector' => '.single-product .product_meta',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_meta_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .product_meta' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_meta_link_color',
			[
				'label' => esc_html__( 'Link Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product .product_meta a, .single-product div.product .product_meta > span span' => 'color: {{VALUE}}',
				],
			]
		);

		// Add to cart
		$this->add_control(
			'liquid_wc_single_product_add_to_cart_heading',
			[
				'label' => esc_html__( 'ADD TO CART BUTTON', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_single_product_product_button_typo',
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'selector' => '.single-product div.product .btn',
			]
		);

		// Button normal state
		$this->start_controls_tabs(
			'liquid_wc_single_product_product_button_colors_tab'
		);

		$this->start_controls_tab(
			'liquid_wc_single_product_product_button_colors_normal',
			[
				'label' => __( 'Normal', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'liquid_wc_single_product_product_button_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product form.cart button.button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'liquid_wc_single_product_product_button_bg',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '.single-product div.product form.cart button.button',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'liquid_wc_single_product_product_button_border',
				'label' => __( 'Border', 'hub-elementor-addons' ),
				'selector' => '.single-product div.product form.cart button.button',
			]
		);

		$this->add_responsive_control(
			'liquid_wc_single_product_product_button_border_radius',
			[
				'label' => __( 'Border radius', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'.single-product div.product form.cart button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'liquid_wc_single_product_product_button_box_shadow',
				'label' => __( 'Box shadow', 'hub-elementor-addons' ),
				'selector' => '.single-product div.product form.cart button.button',
			]
		);

		$this->add_responsive_control(
			'liquid_wc_single_product_product_button_padding',
			[
				'label' => __( 'Padding', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'.single-product div.product form.cart button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->start_controls_tab(
			'liquid_wc_single_product_product_button_colors_hover',
			[
				'label' => __( 'Hover', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'liquid_wc_single_product_product_button_color_hover',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product form.cart button.button:hover, .single-product div.product form.cart button.button:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'liquid_wc_single_product_product_button_bg_hover',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '.single-product div.product form.cart button.button:hover, .single-product div.product form.cart button.button:focus',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'liquid_wc_single_product_product_button_border_hover',
				'label' => __( 'Border', 'hub-elementor-addons' ),
				'selector' => '.single-product div.product form.cart button.button:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'liquid_wc_single_product_product_button_box_shadow_hover',
				'label' => __( 'Box shadow', 'hub-elementor-addons' ),
				'selector' => '.single-product div.product form.cart button.button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Quantity
		$this->add_control(
			'liquid_wc_single_product_qty_heading',
			[
				'label' => esc_html__( 'QUANTITY', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_qty_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product div.quantity .ui-spinner, .single-product div.quantity .ui-button-icon' => 'color: {{VALUE}}',
				],
			]
		);
	
		// Extra
		$this->add_control(
			'liquid_wc_single_product_extra_heading',
			[
				'label' => esc_html__( 'EXTRA', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_pagination_color',
			[
				'label' => esc_html__( 'Pagination Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .lqd-woo-pagination a' => 'color: {{VALUE}}',
					'.single-product .lqd-view-grid:hover svg, .single-product div.product .lqd-woo-pagination .lqd-woo-pagination-all:hover svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_social_icons_color',
			[
				'label' => esc_html__( 'Social Media Icons Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .lqd-woo-summary-foot .social-icon a' => 'color: {{VALUE}}',
				],
			]
		);

		// Tabs
		$this->add_control(
			'liquid_wc_single_product_tabs_heading',
			[
				'label' => esc_html__( 'TABS', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_single_product_tabs_typo',
				'label' => __( 'Tab Title Typography', 'hub-elementor-addons' ),
				'selector' => '.single-product div.product .woocommerce-tabs ul.tabs li',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_tabs_color',
			[
				'label' => esc_html__( 'Tab Title Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .woocommerce-tabs ul.tabs li a' => 'color: {{VALUE}}',
					'.single-product div.product .woocommerce-tabs ul.wc-tabs' => 'border: none',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_tabs_active_color',
			[
				'label' => esc_html__( 'Tab Title Active Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .woocommerce-tabs ul.tabs li a:hover, .single-product div.product .woocommerce-tabs ul.tabs li.active a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_single_product_tabs_heading_typo',
				'label' => __( 'Tab Heading Typography', 'hub-elementor-addons' ),
				'selector' => '.single-product div.product .woocommerce-tabs .woocommerce-Tabs-panel h2, .single-product #reviews #comments h2',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_tabs_heading_color',
			[
				'label' => esc_html__( 'Tab Heading Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .woocommerce-tabs .woocommerce-Tabs-panel h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_single_product_tabs_content_typo',
				'label' => __( 'Tab Content Typography', 'hub-elementor-addons' ),
				'selector' => '.single-product div.product .woocommerce-tabs .woocommerce-Tabs-panel--description p',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_tabs_content_color',
			[
				'label' => esc_html__( 'Tab Content Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .woocommerce-tabs .woocommerce-Tabs-panel--description p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_tabs_table_label_color',
			[
				'label' => esc_html__( 'Addional Information Table Label Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .woocommerce-tabs .woocommerce-product-attributes-item__label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_tabs_table_value_color',
			[
				'label' => esc_html__( 'Addional Information Table Value Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .woocommerce-tabs .woocommerce-product-attributes-item__value p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_tabs_table_bg',
			[
				'label' => esc_html__( 'Addional Information Table BG', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .woocommerce-tabs table.shop_attributes th' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_tabs_table_bg2',
			[
				'label' => esc_html__( 'Addional Information Table BG 2', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .woocommerce-tabs table.shop_attributes tr:nth-child(2n) th' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_tabs_table_bg3',
			[
				'label' => esc_html__( 'Addional Information Table BG 3', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product div.product .woocommerce-tabs table.shop_attributes td' => 'background: {{VALUE}}!important',
				],
			]
		);

		// Reviews
		$this->add_control(
			'liquid_wc_single_product_reviews_heading',
			[
				'label' => esc_html__( 'REVIEWS', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_single_product_reviews_form_typo',
				'label' => __( 'Form Typography', 'hub-elementor-addons' ),
				'selector' => '.single-product #review_form form',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_form_wrapper_bg',
			[
				'label' => esc_html__( 'Form Wrapper Bg', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #review_form #respond' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_form_input_color',
			[
				'label' => esc_html__( 'Form Input Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #review_form #respond .comment-form p' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'liquid_wc_single_product_reviews_form_input_color_hover',
			[
				'label' => esc_html__( 'Form Input Hover/Active Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #review_form #respond .comment-form p.input-filled, .single-product #review_form #respond .comment-form p.input-focused' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'liquid_wc_single_product_reviews_form_input_border_color',
			[
				'label' => esc_html__( 'Form Input Border Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #review_form #respond .comment-form p::before' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'liquid_wc_single_product_reviews_form_input_border_color_hover',
			[
				'label' => esc_html__( 'Form Input Border Active Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #review_form #respond .comment-form p.input-filled::before, .single-product #review_form #respond .comment-form p.input-focused::before, .single-product #review_form #respond .comment-form p.input-filled::after, .single-product #review_form #respond .comment-form p.input-focused::after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_form_stars_color',
			[
				'label' => esc_html__( 'Stars Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #review_form #respond .comment-form .stars, .single-product div.product .star-rating' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'liquid_wc_single_product_reviews_form_stars_border_color',
			[
				'label' => esc_html__( 'Stars Border Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #review_form #respond .comment-form .comment-form-rating' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_review_bg',
			[
				'label' => esc_html__( 'Review Backgorund', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #reviews #comments ol.commentlist li' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_review_border_color',
			[
				'label' => esc_html__( 'Review Border Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #reviews #comments ol.commentlist li' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_review_text_color',
			[
				'label' => esc_html__( 'Review Text Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #reviews #comments ol.commentlist li' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_date_color',
			[
				'label' => esc_html__( 'Review Date Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #reviews #comments ol.commentlist li .comment-text .meta' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_author_color',
			[
				'label' => esc_html__( 'Review Author Color', 'hub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.single-product #reviews #comments ol.commentlist li .comment-text .woocommerce-review__author' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Global_WooCommerce( Kit::class );

/**
 * Fires on tabs registering.
 */
add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-woocommerce-style-kit', Liquid_Global_WooCommerce::class );
	}
);
