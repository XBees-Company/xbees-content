<?php
namespace LiquidElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Schemes\Color;
use Elementor\Schemes\Typography;
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
 * @since 1.0.0
 */
class LD_Header_Trigger extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_header_trigger';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Header Trigger', 'hub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-menu-bar lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'hub-header' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'header', 'icon', 'box' ];
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		// General Section
		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'Trigger Button', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1' => __( 'Style 1', 'hub-elementor-addons' ),
					'style-2' => __( 'Style 2', 'hub-elementor-addons' ),
					'style-3' => __( 'Style 3', 'hub-elementor-addons' ),
					'style-4' => __( 'Style 4', 'hub-elementor-addons' ),
					'style-5' => __( 'Style 5', 'hub-elementor-addons' ),
					'style-6' => __( 'Style 6', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Menu', 'hub-elementor-addons' ),
				'placeholder' => __( 'Add text near the trigger', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'position',
			[
				'label' => __( 'Alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'txt-left' => [
						'title' => __( 'Left', 'hub-elementor-addons' ),
						'icon' => 'fa fa-align-left',
					],
					'txt-right' => [
						'title' => __( 'Right', 'hub-elementor-addons' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'txt-left',
				'toggle' => false,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .nav-trigger',
			]
		);

		$this->add_control(
			'trigger_fill',
			[
				'label' => __( 'Trigger Fill', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fill-none',
				'options' => [
					'fill-none' => __( 'None', 'hub-elementor-addons' ),
					'solid' => __( 'Solid', 'hub-elementor-addons' ),
					'bordered' => __( 'Bordered', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'trigger_shape',
			[
				'label' => __( 'Trigger Shape', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'hub-elementor-addons' ),
					'round' => __( 'Round', 'hub-elementor-addons' ),
					'circle' => __( 'Circle', 'hub-elementor-addons' ),
				],
				'condition' => [
					'trigger_fill!' => ['fill-none'],
				]
			]
		);

		$this->add_responsive_control(
			'trigger_size',
			[
				'label' => __( 'Trigger size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} button.nav-trigger span.bars' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; flex: 0 0 auto;',
				],
				'condition' => array(
					'trigger_fill' => array( 'solid', 'bordered' ),
					'trigger_shape' => array( 'round', 'circle' ),
				),
			]
		);

		$this->add_control(
			'target_id',
			[
				'label' => __( 'ID of the target', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Add id of the target for trigger button, for ex. target_id', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'orientation',
			[
				'label' => __( 'Orientation', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'rotate-90' => __( 'Vertical', 'hub-elementor-addons' ),
				],
			]
		);
		$this->end_controls_section();

		// Typography
		$this->start_controls_section(
			'tigger_typography_section',
			[
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'trigger_typography',
				'label' => __( 'Trigger Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .nav-trigger',
			]
		);

		$this->end_controls_section();

		// Colors
		$this->start_controls_section(
			'tigger_color_section',
			[
				'label' => __( 'Colors', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'trigger_color',
			[
				'label' => __( 'Trigger Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-trigger .bar, {{WRAPPER}} .nav-trigger.style-2 .bar:before, {{WRAPPER}} .nav-trigger.style-2 .bar:after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .nav-trigger' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'trigger_color_hover',
			[
				'label' => __( 'Trigger Hover Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-trigger:hover .bar, {{WRAPPER}} .nav-trigger.style-2:hover .bar:before, {{WRAPPER}} .nav-trigger.style-2:hover .bar:after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .nav-trigger:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'trigger_color_active',
			[
				'label' => __( 'Trigger Active Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-trigger.is-active .bar, {{WRAPPER}} .nav-trigger.is-active .bar:before, {{WRAPPER}} .nav-trigger.is-active .bar:after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .nav-trigger.is-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'trigger_text_color',
			[
				'label' => __( 'Trigger Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-trigger .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'trigger_text_color_hover',
			[
				'label' => __( 'Trigger Hover Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-trigger:hover .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'trigger_text_color_active',
			[
				'label' => __( 'Trigger Active Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-trigger.is-active .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shape_color',
			[
				'label' => __( 'Shape Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-trigger.solid .bars:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .nav-trigger.bordered .bars' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shape_hover_color',
			[
				'label' => __( 'Shape Hover Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-trigger.solid:hover .bars:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .nav-trigger.bordered:hover .bars' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shape_active_color',
			[
				'label' => __( 'Shape Active Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-trigger.solid.is-active .bars:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .nav-trigger.bordered.is-active .bars' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Sticky Colors
		$this->start_controls_section(
			'sticky_color_section',
			[
				'label' => __( 'Sticky Colors', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_trigger_color',
			[
				'label' => __( 'Trigger Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .nav-trigger .bar, .is-stuck {{WRAPPER}} .nav-trigger.style-2 .bar:before, .is-stuck {{WRAPPER}} .nav-trigger.style-2 .bar:after' => 'background: {{VALUE}}',
					'.is-stuck {{WRAPPER}} .nav-trigger' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_trigger_color_hover',
			[
				'label' => __( 'Trigger Hover Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .nav-trigger:hover .bar, .is-stuck {{WRAPPER}} .nav-trigger.style-2:hover .bar:before, .is-stuck {{WRAPPER}} .nav-trigger.style-2:hover .bar:after' => 'background: {{VALUE}}',
					'.is-stuck {{WRAPPER}} .nav-trigger:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_trigger_color_active',
			[
				'label' => __( 'Trigger Active Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .nav-trigger.is-active .bar:before, .is-stuck {{WRAPPER}} .nav-trigger.is-active .bar:after' => 'background: {{VALUE}}',
					'.is-stuck {{WRAPPER}} .nav-trigger.is-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_trigger_text_color',
			[
				'label' => __( 'Trigger Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .nav-trigger .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_trigger_text_color_hover',
			[
				'label' => __( 'Trigger Hover Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .nav-trigger:hover .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_trigger_text_color_active',
			[
				'label' => __( 'Trigger Active Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .nav-trigger.is-active .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_shape_color',
			[
				'label' => __( 'Shape Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .nav-trigger.solid .bars:before' => 'background-color: {{VALUE}}',
					'.is-stuck {{WRAPPER}} .nav-trigger.bordered .bars' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_shape_hover_color',
			[
				'label' => __( 'Shape Hover Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .nav-trigger.solid:hover .bars:before' => 'background-color: {{VALUE}}',
					'.is-stuck {{WRAPPER}} .nav-trigger.bordered:hover .bars' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_shape_active_color',
			[
				'label' => __( 'Shape Active Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .nav-trigger.solid.is-active .bars:before' => 'background-color: {{VALUE}}',
					'.is-stuck {{WRAPPER}} .nav-trigger.bordered.is-active .bars' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Colors Over Light Rows
		$this->start_controls_section(
			'sticky_light_section',
			[
				'label' => __( 'Colors Over Light Rows', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_light_trigger_color',
			[
				'label' => __( 'Trigger Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger .bar, {{WRAPPER}}.lqd-active-row-light .nav-trigger.style-2 .bar:before, {{WRAPPER}}.lqd-active-row-light .nav-trigger.style-2 .bar:after' => 'background: {{VALUE}}; color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'sticky_light_trigger_color_hover',
			[
				'label' => __( 'Trigger Hover Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger:hover .bar, {{WRAPPER}}.lqd-active-row-light .nav-trigger.style-2:hover .bar:before, {{WRAPPER}}.lqd-active-row-light .nav-trigger.style-2:hover .bar:after' => 'background: {{VALUE}}; color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_light_trigger_color_active',
			[
				'label' => __( 'Trigger Active Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger.is-active .bar, {{WRAPPER}}.lqd-active-row-light .nav-trigger.style-2.is-active .bar:before, {{WRAPPER}}.lqd-active-row-light .nav-trigger.style-2.is-active .bar:after' => 'background: {{VALUE}}; color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_light_trigger_text_color',
			[
				'label' => __( 'Trigger Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger > .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_light_trigger_text_color_hover',
			[
				'label' => __( 'Trigger Hover Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger:hover > .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_light_trigger_text_color_active',
			[
				'label' => __( 'Trigger Active Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger.is-active > .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_light_shape_color',
			[
				'label' => __( 'Shape Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger.solid .bars:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger.bordered .bars' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_light_shape_hover_color',
			[
				'label' => __( 'Shape Hover Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger.solid:hover .bars:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger.bordered:hover .bars' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_light_shape_active_color',
			[
				'label' => __( 'Shape Active Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger.solid.is-active .bars:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-light .nav-trigger.bordered.is-active .bars' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Colors Over Dark Rows
		$this->start_controls_section(
			'sticky_dark_section',
			[
				'label' => __( 'Colors Over Dark Rows', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_dark_trigger_color',
			[
				'label' => __( 'Trigger Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger .bar, {{WRAPPER}}.lqd-active-row-dark .nav-trigger.style-2 .bar:before, {{WRAPPER}}.lqd-active-row-dark .nav-trigger.style-2 .bar:after' => 'background: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sticky_dark_trigger_color_hover',
			[
				'label' => __( 'Trigger Hover Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger:hover .bar, {{WRAPPER}}.lqd-active-row-dark .nav-trigger.style-2:hover .bar:before, {{WRAPPER}}.lqd-active-row-dark .nav-trigger.style-2:hover .bar:after' => 'background: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sticky_dark_trigger_color_active',
			[
				'label' => __( 'Trigger Active Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger.is-active .bar, {{WRAPPER}}.lqd-active-row-dark .nav-trigger.style-2.is-active .bar:before, {{WRAPPER}}.lqd-active-row-dark .nav-trigger.style-2.is-active .bar:after' => 'background: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sticky_dark_trigger_text_color',
			[
				'label' => __( 'Trigger Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger > .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_dark_trigger_text_color_hover',
			[
				'label' => __( 'Trigger Hover Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger:hover > .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_dark_trigger_text_color_active',
			[
				'label' => __( 'Trigger Active Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger.is-active > .txt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_dark_shape_color',
			[
				'label' => __( 'Shape Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger.solid .bars:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger.bordered .bars' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_dark_shape_hover_color',
			[
				'label' => __( 'Shape Hover Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger.solid:hover .bars:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger.bordered:hover .bars' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_dark_shape_active_color',
			[
				'label' => __( 'Shape Active Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger.solid.is-active .bars:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-dark .nav-trigger.bordered.is-active .bars' => 'border-color: {{VALUE}}',
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
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$target_id = $settings['target_id'];
		$data_target = !empty( $target_id ) ? $target_id : 'main-header-collapse';

		$classes = array(
			'nav-trigger',
			'main-nav-trigger',
			'd-flex',
			'pos-rel',
			'align-items-center',
			'justify-content-center',
			'collapsed',
			$settings['style'],
			$settings['trigger_fill'],
			$settings['trigger_shape'],
			$settings['orientation'],
			$this->get_position(),
		);

		$classes = apply_filters( 'liquid_trigger_classes', $classes );

		$opts = array(
			'data-toggle="collapse"',
		);

		$opts = apply_filters( 'liquid_trigger_opts', $opts );

        $this->add_render_attribute('trigger', [
            'role' => 'button',
			'type' => 'button',
			'data-ld-toggle' => 'true',
			'data-target' => '#' . $data_target,
			'aria-expanded' => 'false',
			'aria-controls' => $data_target,
        ]);


	?>
		<button
			id="<?php echo $this->get_id(); ?>"
			class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>"
			<?php echo implode( ' ', $opts ); ?>
            <?php $this->print_render_attribute_string('trigger') ?>
			>
			<span class="bars d-inline-block pos-rel z-index-1">
				<span class="bars-inner d-flex flex-column w-100 h-100">
					<span class="bar d-inline-block pos-rel"></span>
					<span class="bar d-inline-block pos-rel"></span>
					<span class="bar d-inline-block pos-rel"></span>
					<?php if ( 'style-4' === $settings['style'] ) : ?>
					<svg width="36" height="20" viewBox="0 0 36 20" xmlns="http://www.w3.org/2000/svg">
						<path d="M6.234 4.72051C6.779 4.68151 7.013 4.56451 7.715 3.94151C8.94451 2.98969 10.2772 2.17926 11.688 1.52551C12.7607 1.02387 13.9329 0.770914 15.117 0.785509C15.8688 0.777464 16.6175 0.882642 17.338 1.09751C18.238 1.33151 18.238 1.33151 19.832 1.68151C21.0108 2.12438 22.029 2.91188 22.754 3.94151C24.4546 4.24932 26.1737 4.44441 27.9 4.52551C29.8552 4.57198 31.8063 4.72823 33.744 4.99351C35.26 5.30451 36 6.00651 36 7.09751C36.0012 7.35479 35.9419 7.60874 35.8269 7.83889C35.7119 8.06905 35.5444 8.26896 35.338 8.42251C34.438 9.12251 33.156 9.32251 29.65 9.32251L25.286 9.32251C25.6595 9.84601 25.8633 10.4715 25.87 11.1145C25.8777 11.4223 25.8241 11.7285 25.7122 12.0154C25.6003 12.3022 25.4324 12.5639 25.2183 12.7851C25.0042 13.0064 24.7482 13.1828 24.4652 13.3041C24.1822 13.4254 23.8779 13.4891 23.57 13.4915C23.6988 13.8289 23.7776 14.1833 23.804 14.5435C23.8059 15.1996 23.5567 15.8315 23.1074 16.3096C22.6581 16.7877 22.0429 17.0757 21.388 17.1145C21.0925 17.1052 20.8015 17.039 20.531 16.9195C20.5895 17.0816 20.6159 17.2534 20.609 17.4255C20.5314 17.9412 20.2654 18.4098 19.8624 18.7408C19.4593 19.0718 18.9479 19.2416 18.427 19.2175C17.7611 19.1667 17.1058 19.0213 16.481 18.7855C15.781 18.8245 15.156 18.8635 14.881 18.8635C13.05 18.8635 12.037 18.4735 8.686 16.4475C7.95678 15.9545 7.17204 15.549 6.348 15.2395C6.05113 15.5819 5.67721 15.8489 5.257 16.0185C4.54161 16.1833 3.80907 16.2618 3.075 16.2525C1.984 16.2525 1.517 16.0965 1.244 15.6295C0.429001 14.1855 4.80283e-07 11.7725 3.47444e-07 8.73351C1.94148e-07 5.22651 0.545 3.63351 1.831 3.47351C2.143 3.43451 3.431 3.35651 3.701 3.35651C4.714 3.35651 5.026 3.55151 6.234 4.72051ZM26.416 8.22751C31.481 8.22751 33.39 8.14951 34.052 7.95451C34.481 7.83751 34.909 7.44851 34.909 7.13651C34.909 6.43651 34.13 6.00651 32.727 5.88951C29.454 5.69451 25.208 5.34451 23.532 5.14951C24.077 6.04951 24.389 6.47451 24.389 6.54951C24.6408 7.07417 24.7866 7.64339 24.818 8.22451L26.416 8.22751ZM10.716 16.3705C11.9729 17.2122 13.4171 17.7324 14.922 17.8855C13.208 16.5215 12.467 15.4695 12.467 14.3785C12.449 14.1158 12.4849 13.8522 12.5724 13.6038C12.66 13.3555 12.7973 13.1276 12.9761 12.9342C13.1548 12.7409 13.3712 12.5861 13.612 12.4793C13.8527 12.3726 14.1127 12.3162 14.376 12.3135C14.3374 12.0945 14.3113 11.8735 14.298 11.6515C14.298 10.5995 15.038 9.89851 16.285 9.74251C16.1478 9.51543 16.0552 9.26428 16.012 9.00251C15.246 9.46723 14.4385 9.85992 13.6 10.1755C12.6391 10.3895 11.6614 10.52 10.678 10.5655C9.743 10.5655 9.078 10.2535 9.078 9.82551C9.078 9.55251 9.273 9.39651 9.584 9.39651L9.74 9.39651C10.87 9.51351 10.87 9.51351 10.987 9.51351C12.2754 9.59279 13.5563 9.26576 14.649 8.57851C15.7411 7.91251 16.7153 7.07009 17.532 6.08551C17.9847 6.20816 18.4277 6.3646 18.857 6.55351C19.557 6.78751 19.557 6.78751 19.831 7.21551C20.1124 7.6946 20.5094 8.09543 20.9859 8.38126C21.4623 8.66709 22.0029 8.82878 22.558 8.85151C23.258 8.85151 23.727 8.53951 23.727 8.07251C23.6202 7.49233 23.3806 6.94473 23.027 6.47251C22.3855 5.10613 21.3897 3.93658 20.143 3.08551C18.5218 2.4334 16.8166 2.01359 15.078 1.83851C14.2379 1.84269 13.4057 2.00133 12.623 2.30651C11.0725 3.02678 9.59844 3.90118 8.223 4.91651C7.6687 5.47155 6.9372 5.81447 6.156 5.88551C6.117 5.88551 6 5.84651 5.844 5.80751C5.60634 6.23975 5.4603 6.71633 5.415 7.20751C5.377 7.68551 5.3 9.51251 5.3 10.0195C5.3149 10.6471 5.38011 11.2724 5.495 11.8895C5.55231 12.6623 5.85224 13.3973 6.352 13.9895C7.014 14.3795 7.014 14.3795 8.884 15.3145L10.716 16.3705ZM24.039 9.55151C23.139 9.90251 23.139 9.90251 22.675 9.90251C22.0907 9.8901 21.5122 9.78478 20.961 9.59051C20.1895 9.26316 19.5273 8.72272 19.052 8.03251C18.701 7.52651 18.546 7.40951 18.234 7.40951C17.9291 7.44714 17.6441 7.58063 17.4199 7.79073C17.1958 8.00083 17.0442 8.27669 16.987 8.57851C17.0495 9.1113 17.3144 9.59966 17.727 9.94251C18.4241 10.4529 19.1677 10.8966 19.948 11.2675C20.4841 11.5985 21.0601 11.8603 21.662 12.0465C22.2093 12.28 22.786 12.4375 23.376 12.5145C23.7482 12.5046 24.103 12.3551 24.3701 12.0958C24.6372 11.8365 24.7971 11.4862 24.818 11.1145C24.7603 10.5152 24.4828 9.95839 24.039 9.55151V9.55151ZM15.312 11.8855C15.312 12.5855 16.012 13.2855 17.922 14.4175C19.675 15.4695 20.727 15.9365 21.39 15.9365C21.7259 15.9205 22.0438 15.7798 22.2815 15.5421C22.5193 15.3043 22.66 14.9864 22.676 14.6505C22.6538 14.277 22.4857 13.9272 22.208 13.6765C21.935 13.3645 21.935 13.3645 21.039 12.9365C20.455 12.7025 18.312 11.5725 17.844 11.3005C17.104 10.8325 16.87 10.7555 16.48 10.7555C16.1785 10.7612 15.8903 10.8809 15.6736 11.0906C15.4568 11.3003 15.3276 11.5843 15.312 11.8855V11.8855ZM13.519 14.3055C13.6805 15.128 14.1381 15.8627 14.805 16.3705C16.13 17.5785 17.26 18.2015 18.273 18.2015C18.973 18.2015 19.559 17.8115 19.559 17.3015C19.5501 17.1632 19.5105 17.0286 19.4431 16.9075C19.3756 16.7864 19.282 16.6818 19.169 16.6015C18.818 16.2115 18.779 16.2115 17.026 15.1595C16.3706 14.7837 15.7568 14.3396 15.195 13.8345C14.883 13.5225 14.727 13.4445 14.495 13.4445C14.3744 13.4369 14.2534 13.4532 14.1391 13.4923C14.0247 13.5315 13.9192 13.5928 13.8286 13.6728C13.738 13.7527 13.664 13.8498 13.6108 13.9583C13.5577 14.0669 13.5265 14.1849 13.519 14.3055V14.3055ZM4.87 4.99351C4.87 4.72051 4.402 4.44851 3.97 4.44851C3.80046 4.44489 3.63098 4.45795 3.464 4.48751L2.688 4.48751C1.87 4.48751 1.597 4.60451 1.402 5.07151C1.08471 6.34592 0.953347 7.65951 1.012 8.97151C0.934969 10.7426 1.18585 12.5126 1.752 14.1925C2.064 14.9715 2.181 15.0925 2.96 15.0925C4.791 15.0925 5.22 15.0145 5.22 14.6245C5.14531 14.2861 5.02734 13.9588 4.869 13.6505C4.37529 12.2641 4.15061 10.7962 4.207 9.32551C4.12285 7.96188 4.32168 6.59559 4.791 5.31251C4.83184 5.2103 4.85842 5.10296 4.87 4.99351V4.99351Z" />
					</svg>
					<?php endif; ?>
				</span>
			</span>
			<?php if( !empty( $settings['text'] ) ) { ?>
				<?php printf( '<span class="txt d-inline-block">%s</span>', esc_html( $settings['text'] ) ); ?>
			<?php } ?>
		</button>
	<?php



	}

	protected function get_position() {

		$settings = $this->get_settings_for_display();

		$position = $settings['position'];
		$text     = $settings['text'];

		if( empty( $text ) || empty( $position ) ) {
			return;
		}

		return $position;

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Header_Trigger() );