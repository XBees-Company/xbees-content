<?php
namespace LiquidElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 2.1.3
 */
class LD_Breadcrumb extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_breadcrumb';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Breadcrumb', 'hub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-breadcrumbs lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'hub-core' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'breadcrumb', 'seo' ];
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'breadcrumb_typography',
				'selector' => '{{WRAPPER}} .lqd-breadcrumb-wrapper',
			]
		);

		$this->add_control(
			'breadcrumb_color',
			[
				'label' => __( 'Active item color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-breadcrumb-wrapper li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'breadcrumb_link_color',
			[
				'label' => __( 'Link item color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-breadcrumb-wrapper li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'breadcrumb_link_hover_color',
			[
				'label' => __( 'Link item hover color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-breadcrumb-wrapper li:hover a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'breadcrumb_separator_color',
			[
				'label' => __( 'Separator color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-breadcrumb-wrapper .breadcrumb>li:not(:last-child):after' => 'color: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function render() {
		
		$breadcrumb_args = array(
			'classes' => 'reset-ul inline-nav inline-ul comma-sep-li',
		);
		
		if ( class_exists('WooCommerce') ){
			$breadcrumb_args = array(
				'wrap_before' => '<div class="lqd-shop-topbar-breadcrumb"><nav class="woocommerce-breadcrumb mb-4 mb-md-0"><ul class="breadcrumb reset-ul inline-nav comma-sep-li">',
				'wrap_after'  => '</ul></nav></div>'
			);
		}

		?><div class="lqd-breadcrumb-wrapper"><?php

		if ( class_exists('WooCommerce') ){
			woocommerce_breadcrumb( $breadcrumb_args );
		} else {
			liquid_breadcrumb( $breadcrumb_args );
		}
		
		?></div><?php
   
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Breadcrumb() );