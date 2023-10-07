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
use Elementor\Group_Control_Css_Filter;
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
class LD_Fancy_Image extends Widget_Base {

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
		return 'ld_fancy_image';
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
		return __( 'Liquid Image', 'hub-elementor-addons' );
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
		return 'eicon-image lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
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
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'image', 'fancy', 'gallery'  ];
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {

		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'jquery-fresco', 'fresco' ];
		} else {
			return [''];
		}
		
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_style_depends() {

		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'fresco' ];
		} else {
			return [''];
		}

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
				'label' => __( 'General', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 
					'liquid-style1-lb',
					'liquid-style3-lb',
					'liquid-style4-lb',
					'liquid-style5-lb',
					'liquid-style6-lb',
					'liquid-style6-alt-lb',
					'liquid-style7-lb',
					'liquid-style9-lb',
					'liquid-style13-lb',
					'liquid-style16-lb',
					'liquid-style18-lb',
					'liquid-style19-lb',
					'liquid-style20-lb',
					'liquid-style21-lb',
					'liquid-style3-sp',
					'liquid-style3-pf',
					'liquid-style4-pf',
					'liquid-style6-pf',
					'liquid-portfolio',
					'liquid-portfolio-sq',
					'liquid-portfolio-big-sq',
					'liquid-portfolio-portrait',
					'liquid-portfolio-wide',
					'liquid-packery-wide',
					'liquid-packery-portrait',
				 ],
				'include' => [],
				'default' => 'full',
			]
		);

		$this->add_responsive_control(
			'fi_width',
			[
				'label' => esc_html__( 'Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'fi_space',
			[
				'label' => esc_html__( 'Max Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'fi_height',
			[
				'label' => esc_html__( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'fi_object-fit',
			[
				'label' => esc_html__( 'Object Fit', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'fi_height[size]!' => '',
				],
				'options' => [
					'' => esc_html__( 'Default', 'hub-elementor-addons' ),
					'fill' => esc_html__( 'Fill', 'hub-elementor-addons' ),
					'cover' => esc_html__( 'Cover', 'hub-elementor-addons' ),
					'contain' => esc_html__( 'Contain', 'hub-elementor-addons' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'fi_css_filters',
				'selector' => '{{WRAPPER}} img',
			]
		);

		$this->add_responsive_control(
			'custom_image_size',
			[
				'label' => __( 'Percentage image size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'placeholder' => __( 'ex: 50', 'hub-elementor-addons' ),
				'description' => __( 'Choose the image size based on its container.', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}}' => 'width: auto',
					'{{WRAPPER}} .lqd-imggrp-img-container' => 'width: {{VALUE}}%',
				]
			]
		);

		$this->add_responsive_control(
			'image_align',
			[
				'label' => __( 'Alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'hub-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'hub-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'hub-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'img_link',
			[
				'label' => __( 'Link', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'hub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->end_controls_section();
		
		// Opacity
		$this->start_controls_section(
			'opacity_section',
			[
				'label' => __( 'Opacity', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'fi_opacity',
			[
				'label' => __( 'Opacity', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single' => 'opacity: {{SIZE}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'fi_hover_opacity',
			[
				'label' => __( 'Hover opacity', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single:hover' => 'opacity: {{SIZE}}',
				],
			]
		);

		$this->end_controls_section();
		
		// Lightbox
		$this->start_controls_section(
			'lightbox_section',
			[
				'label' => __( 'Lightbox', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_lightbox',
			[
				'label' => __( 'Enable lightbox', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'lightbox_group_id',
			[
				'label' => __( 'Lightbox groupd id', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter a lightbox group id', 'hub-elementor-addons' ),
				'condition' => [
					'enable_lightbox' => 'yes'
				]
			]
		);

		$this->end_controls_section();
		
		// Roundness
		$this->start_controls_section(
			'roundness_section',
			[
				'label' => __( 'Roundness', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_roudness',
			[
				'label' => __( 'Add roundness?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'image_roudness',
			[
				'label' => __( 'Border radius', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2px',
				'options' => [
					'2px' => __( '2px', 'hub-elementor-addons' ),
					'4px' => __( '4px', 'hub-elementor-addons' ),
					'6px' => __( '6px', 'hub-elementor-addons' ),
					'8px' => __( '8px', 'hub-elementor-addons' ),
					'50em' => __( '50em (Circle)', 'hub-elementor-addons' ),
					'custom' => __( 'Custom', 'hub-elementor-addons' ),
				],
				'condition' => [
					'enable_roudness' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} figure, {{WRAPPER}} figure img' => 'border-radius: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'custom_roundness',
			[
				'label' => __( 'Custom roundness', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'image_roudness' => 'custom'
				],
				'selectors' => [
					'{{WRAPPER}} figure, {{WRAPPER}} figure img' => 'border-radius: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Shadow
		$this->start_controls_section(
			'shadow_section',
			[
				'label' => __( 'Shadow', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_image_shadow',
			[
				'label' => __( 'Add shadow?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'shadow_style',
			[
				'label' => __( 'Shadow', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => __( 'Shadow Depth 1', 'hub-elementor-addons' ),
					'2' => __( 'Shadow Depth 2', 'hub-elementor-addons' ),
					'3' => __( 'Shadow Depth 3', 'hub-elementor-addons' ),
					'4' => __( 'Shadow Depth 4', 'hub-elementor-addons' ),
					'custom' => __( 'Custom', 'hub-elementor-addons' ),
				],
				'condition' => [
					'enable_image_shadow' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'custom_box_shadow',
				'label' => __( 'Box shadow', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-imggrp-single:not([data-animate-shadow=true]) figure, {{WRAPPER}} .lqd-imggrp-single[data-animate-shadow=true].is-in-view figure',
				'condition' => [
					'enable_image_shadow' => 'yes',
					'shadow_style' => 'custom'
				]
			]
		);

		$this->add_control(
			'enable_animated_shadow',
			[
				'label' => __( 'Animate shadow?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'enable_image_shadow' => 'yes'
				]
			]
		);

		$this->add_control(
			'shadow_delay',
			[
				'label' => __( 'Delay in (ms)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'enable_animated_shadow' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		// Reveal effect
		$this->start_controls_section(
			'reveal_effect_section',
			[
				'label' => __( 'Reveal effect', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_reveal',
			[
				'label' => __( 'Reveal effect', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'reveal_color',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .block-revealer__element',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'enable_reveal' => 'yes'
				]
			]
		);

		$this->add_control(
			'reveal_direction',
			[
				'label' => __( 'Direction', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lr',
				'options' => [
					'lr' => __( 'Left - Right', 'hub-elementor-addons' ),
					'tb' => __( 'Top - Bottom', 'hub-elementor-addons' ),
					'rl' => __( 'Right - Left', 'hub-elementor-addons' ),
					'bt' => __( 'Bottom - Top', 'hub-elementor-addons' ),
				],
				'condition' => [
					'enable_reveal' => 'yes'
				]
			]
		);

		$this->add_control(
			'reveal_delay',
			[
				'label' => __( 'Dellay in (ms)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'enable_reveal' => 'yes'
				]
			]
		);

		$this->end_controls_section();
		
		// Floating effect
		$this->start_controls_section(
			'floating_section',
			[
				'label' => __( 'Floating effect', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_float_effect',
			[
				'label' => __( 'Floating effect?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'float_animate_from',
			[
				'label' => __( 'Float animate from', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '0%',
				'condition' => [
					'enable_float_effect' => 'yes'
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single[data-float]' => '--float-animate-from: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'float_animate_to',
			[
				'label' => __( 'Float animate to', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '3%',
				'condition' => [
					'enable_float_effect' => 'yes'
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single[data-float]' => '--float-animate-to: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'float_delay',
			[
				'label' => __( 'Float delay', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '0s',
				'condition' => [
					'enable_float_effect' => 'yes'
				],
				'render_type' => 'template',
				'description' => __( 'Float starting delay. value can be in seconds or milliseconds. e.g. 0.5s or 500ms.', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single[data-float]' => '--float-delay: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'float_easing',
			[
				'label' => __( 'Float easing', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ease',
				'options' => [
					'ease' => __( 'Ease', 'hub-elementor-addons' ),
					'ease-in' => __( 'Ease In', 'hub-elementor-addons' ),
					'ease-out' => __( 'Ease Out', 'hub-elementor-addons' ),
					'ease-in-out' => __( 'Ease In Out', 'hub-elementor-addons' ),
					'custom_ease' => __( 'Custom Ease', 'hub-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single[data-float]' => '--float-animation-ease: {{VALUE}}'
				],
				'condition' => [
					'enable_float_effect' => 'yes'
				]
			]
		);

		$this->add_control(
			'float_custom_ease',
			[
				'label' => __( 'Custom float easing', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single[data-float]' => '--float-animation-ease: {{VALUE}}'
				],
				'condition' => [
					'float_easing' => 'custom_ease'
				]
			]
		);

		$this->end_controls_section();
		
		// Hover 3D
		$this->start_controls_section(
			'hover3d_section',
			[
				'label' => __( 'Hover 3d', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_hover3d',
			[
				'label' => __( 'Enable hover 3d?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'hover3d_stacking_factor',
			[
				'label' => __( 'Stacking factor, use integer number', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '1',
				'condition' => [
					'enable_hover3d' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		// Overlay Lines
		$this->start_controls_section(
			'oberlay_lines_section',
			[
				'label' => __( 'Overlay lines', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_lines',
			[
				'label' => __( 'Add lines', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'lines_count',
			[
				'label' => __( 'Side label', 'hub-elementor-addons' ),
				'default' => '3',
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'enable_lines' => 'yes'
				]
			]
		);

		$this->add_control(
			'lines_color',
			[
				'label' => __( 'Lines color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-v-line div' => 'background: {{VALUE}}',
				],
				'condition' => [
					'enable_lines' => 'yes'
				]
			]
		);
		$this->end_controls_section();

		// Overlay Background
		$this->start_controls_section(
			'oberlay_bg_section',
			[
				'label' => __( 'Overlay background', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_overlay_bg',
			[
				'label' => __( 'Add overlay background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_bg',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-imggrp-overlay-bg',
				'condition' => [
					'enable_overlay_bg' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		// Side Label
		$this->start_controls_section(
			'sidelabel_section',
			[
				'label' => __( 'Side label', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_side_label',
			[
				'label' => __( 'Add side label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		

		$this->add_control(
			'label',
			[
				'label' => __( 'Side label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'condition' => [
					'enable_side_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'label_side',
			[
				'label' => __( 'Content alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'lqd-imggrp-content-fixed-left' => [
						'title' => __( 'Left', 'hub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'lqd-imggrp-content-fixed-right' => [
						'title' => __( 'Right', 'hub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'lqd-imggrp-content-fixed-left',
				'toggle' => false,
				'condition' => [
					'enable_side_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'label_pos',
			[
				'label' => __( 'Content alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Start', 'hub-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'hub-elementor-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'end' => [
						'title' => __( 'End', 'hub-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'condition' => [
					'enable_side_label' => 'yes',
					'enable_side_label_overlay' => '',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-imggrp-content',
				'condition' => [
					'enable_side_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_side_label_overlay',
			[
				'label' => __( 'Side label overlay', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'lqd-imggrp-content-fixed-in',
				'default' => '',
				'condition' => [
					'enable_side_label' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'label_color',
			[
				'label' => __( 'Label color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-content-fixed-left,{{WRAPPER}} .lqd-imggrp-content-fixed-right' => 'color: {{VALUE}}',
				],
				'condition' => [
					'enable_side_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'label_overlay_bgcolor',
			[
				'label' => __( 'Overlay background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-content-fixed-in' => 'background: {{VALUE}}',
				],
				'condition' => [
					'enable_side_label' => 'yes',
					'enable_side_label_overlay!' => ''
				]
			]
		);


		$this->end_controls_section();

	}

	protected function get_data_options() {

		$settings = $this->get_settings_for_display();
		
		$shadow = $this->get_settings_for_display('enable_image_shadow');
		$shadow_style = $this->get_settings_for_display('shadow_style');
		$shadow_delay = $this->get_settings_for_display('shadow_delay');
		$hover3d = $this->get_settings_for_display('enable_hover3d');
		$enable_animated_shadow = $this->get_settings_for_display('enable_animated_shadow');

		if ( $this->get_settings_for_display('enable_image_shadow') ) {
			$this->add_render_attribute( 'wrapper', 'data-shadow-style', $shadow_style );
		}

		if ( $enable_animated_shadow ) {
			$this->add_render_attribute( 'wrapper', 'data-inview', 'true' );
			if ( ! empty( $shadow_delay ) && isset( $shadow_delay ) ) {
				$this->add_render_attribute( 'wrapper', 'data-inview-options', wp_json_encode( array( 'delayTime' => (int)$shadow_delay ) ) );
			}
			$this->add_render_attribute( 'wrapper', 'data-animate-shadow', 'true' );
		}
		
		if ( $hover3d ) {
			$this->add_render_attribute( 'wrapper', 'data-hover3d', 'true' );
		}
		
	}

	protected function get_data_float_effect() {
		
		$enable_float_effect = $this->get_settings_for_display('enable_float_effect');
		$float_easing = $this->get_settings_for_display('float_easing');
		$float_custom_ease = $this->get_settings_for_display('float_custom_ease');
		
		$easing = $float_easing;
		
		if( $float_easing === 'custom_ease' && ! empty($float_custom_ease) ) {
			$easing = $float_custom_ease;
		}

		if ( $enable_float_effect ) {
			$this->add_render_attribute( 'wrapper', 'data-float', $easing );
		}
		
	}

	protected function get_data_stacking_factor() {
		
		$hover3d = $this->get_settings_for_display('enable_hover3d');
		$hover3d_stacking_factor = $this->get_settings_for_display('hover3d_stacking_factor');
		
		if( $hover3d === 'yes' ) {
			$this->add_render_attribute( 'figure', 'data-stacking-factor', $hover3d_stacking_factor );
		}
		
	}

	protected function get_reveal_data() {
		
		$reveal = $this->get_settings_for_display('enable_reveal');

		if( $reveal ) {

			$reveal_opts = array( 'direction' => $this->get_settings_for_display('reveal_direction') );

			$reveal_delay = $this->get_settings_for_display('reveal_delay');
			
			if ( isset( $reveal_delay ) && ! empty( $reveal_delay ) ) {
				$reveal_opts['delay'] = $reveal_delay;
			}

			$this->add_render_attribute( 'figure', 'data-reveal', 'true' );
			$this->add_render_attribute( 'figure', 'data-reveal-options', wp_json_encode( $reveal_opts ) );

		}

	}

	protected function get_label($pos) {
		
		$settings = $this->get_settings_for_display();

		if (
			(
				$pos === 'before' &&
				$settings['enable_side_label_overlay'] === 'lqd-imggrp-content-fixed-in'
			) ||
			(
				$pos === 'inside' &&
				$settings['enable_side_label_overlay'] !== 'lqd-imggrp-content-fixed-in'
			)
		) {
			return;
		}
		
		$label = $settings['label'];
		$side = $settings['label_side'];
		$side_overlay = 'lqd-imggrp-content-fixed ' . $settings['enable_side_label_overlay'];
		if( empty( $label ) ) {
			return;
		}
		
		printf( '<div class="lqd-imggrp-content %s %s"><div class="lqd-imggrp-content-inner"><p class="m-0">%s</p></div></div>', esc_attr( $side ), $side_overlay, wp_kses_post( $label ) );		

	}
	
	protected function get_lines() {
		$settings = $this->get_settings_for_display();
		
		if( !$settings['enable_lines'] ) {
			return '';
		}
		
		$out = '';
		
		$lines = $settings['lines_count'];
		
		$out = '<div class="lqd-v-lines lqd-overlay d-flex justify-content-center">';
		$out .= '<div class="lqd-v-line d-inline-flex justify-content-start flex-grow-1 invisible"><div class="h-100"></div></div>';
		for( $i = 1; $i <= $lines; $i++ ) {
			$out .= '<div class="lqd-v-line d-inline-flex justify-content-start flex-grow-1"><div class="h-100"></div></div>';
		}
		$out .= '</div>';

		echo $out;
		
	}

	protected function get_overlay_bg() {
		$settings = $this->get_settings_for_display();
		
		if( !$settings['enable_overlay_bg'] ) {
			return '';
		}

		echo '<span class="lqd-overlay lqd-imggrp-overlay-bg"></span>';
		
	}

	protected function get_overlay_link() {
		$settings = $this->get_settings_for_display();

		if ( !empty( $settings['img_link']['url'] ) && empty($settings['enable_lightbox']) ) {
			$this->add_link_attributes( 'overlay_link', $settings['img_link'] );
			?>
				<a <?php echo $this->get_render_attribute_string( 'overlay_link' ); ?> class="lqd-overlay lqd-fi-overlay-link lqd-cc-label-trigger"></a>
			<?php
		}
		
	}

	protected function get_lightbox_link() {
		$settings = $this->get_settings_for_display();
		
		$link['href'] =  $settings['img_link']['url'];

		if ( ! empty($settings['enable_lightbox']) && empty( $link['href'] ) ) {
			printf( '<a href="%s" class="lqd-overlay lqd-fi-overlay-link lqd-cc-label-trigger fresco" data-fresco-group="%s"></a>', wp_get_attachment_image_url( $settings['image']['id'], 'full', false ), $settings['lightbox_group_id'] );
		} else if ( ! empty($settings['enable_lightbox']) && ! empty( $link['href'] ) ) {
			printf( '<a%s class="lqd-overlay lqd-fi-overlay-link lqd-cc-label-trigger fresco" data-fresco-group="%s"></a>', ld_helper()->html_attributes( $link ), $settings['lightbox_group_id'] );
		}
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

		// wrapper
		$this->add_render_attribute(
			'wrapper', [
				'class' => [ 
					'lqd-imggrp-single',
					'd-block',
					'pos-rel',
					$settings['enable_hover3d'] === 'yes' ? 'perspective' : '',
				 ],
			]
		);
		$this->get_data_options();
		$this->get_data_float_effect();

		// inner_wrapper
		$this->add_render_attribute(
			'inner_wrapper', [
				'class' => [ 
					'lqd-imggrp-img-container',
					'd-inline-flex',
					'pos-rel',
					'align-items-' . ($settings['label_pos'] ? $settings['label_pos'] : 'center'),
					'justify-content-center',
					$settings['enable_hover3d'] === 'yes' ? 'transform-style-3d' : '',
				 ],
			]
		);
	
		// figure
		$this->add_render_attribute(
			'figure', [
				'class' => [ 'w-100', 'pos-rel' ],
			]
		);
		$this->get_data_stacking_factor(); 
		$this->get_reveal_data();

		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div <?php $this->print_render_attribute_string( 'inner_wrapper' ); ?>>
				<?php $this->get_label('before') ?>
				<figure <?php $this->print_render_attribute_string( 'figure' ); ?>>
					<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ); ?>
					<?php $this->get_overlay_bg(); ?>
					<?php $this->get_label('inside') ?>
					<?php $this->get_lines(); ?>
					<?php $this->get_overlay_link(); ?>
					<?php $this->get_lightbox_link(); ?>
				</figure>
			</div>
		</div>

	<?php

	}

	protected function content_template() {
		?>
		<# 

		function get_data_options() {
			
			var opts = [];
			
			var shadow = settings.enable_image_shadow;
			var shadow_style = settings.shadow_style;
			var shadow_delay = settings.shadow_delay;
			var hover3d = settings.enable_hover3d;
			var enable_animated_shadow = settings.enable_animated_shadow;

			if( settings.enable_image_shadow ) { opts.push('data-shadow-style="' + shadow_style + '"');}
	
			if( enable_animated_shadow ) {
				opts.push('data-inview="true"');
				if( shadow_delay !== '' ) {
					opts.push(`data-inview-options='${JSON.stringify( {"delayTime": shadow_delay} )}'`);
				}
				opts.push('data-animate-shadow="true"');	
			}
		
			if( hover3d ) { opts.push('data-hover3d="true"');}
			if( !opts ) { return '';}
			
			return opts.join(' ');	
			
		}

		function get_data_float_effect() {
			
			var enable_float_effect = settings.enable_float_effect;
			var float_easing = settings.float_easing;
			var float_custom_ease = settings.float_custom_ease;
			
			var easing = float_easing;
			
			if( float_easing === 'custom_ease' && float_custom_ease !== '' ) {
				easing = float_custom_ease;
			}

			if ( enable_float_effect ) {
				return 'data-float="' + easing + '"';
			}
			
		}

		function get_data_stacking_factor() {
			
			var hover3d = settings.enable_hover3d;
			var hover3d_stacking_factor = settings.hover3d_stacking_factor;
			
			if( hover3d === 'yes' ) {
				return 'data-stacking-factor="' + hover3d_stacking_factor + '"';
			}
			
		}

		function get_reveal_data() {

			var data = [];

			var reveal = settings.enable_reveal;
			var reveal_opts = {
				direction: settings.reveal_direction
			}

			if ( settings.reveal_delay && settings.reveal_delay !== '' ) {
				reveal_opts['delay'] = settings.reveal_delay;
			}

			if ( reveal === 'yes' ) {
				data.push('data-reveal="true"');
				data.push(`data-reveal-options='${JSON.stringify( reveal_opts )}'`);
			}

			if ( !data  ) { return ''; }

			return data.join(' ');

		}

		function get_label(pos) {

			if (
				(
					pos === 'before' &&
					settings.enable_side_label_overlay === 'lqd-imggrp-content-fixed-in'
				) ||
				(
					pos === 'inside' &&
					settings.enable_side_label_overlay !== 'lqd-imggrp-content-fixed-in'
				)
			) {
				return;
			}
			
			var label = settings.label;
			var side = settings.label_side;
			var side_overlay = `lqd-imggrp-content-fixed ${settings.enable_side_label_overlay}`;
			if( label === '' || !settings.enable_side_label) {
				return '';
			}

			return `<div class="lqd-imggrp-content ${side} ${side_overlay}"><div class="lqd-imggrp-content-inner"><p class="m-0">${label}</p></div></div>`;	

		}

		function get_lines() {
			
			if( !settings.enable_lines ) { return ''; }
			
			var out = '';
			var lines = settings.lines_count;
			
			out = '<div class="lqd-v-lines lqd-overlay d-flex justify-content-center">';
			out += '<div class="lqd-v-line d-inline-flex justify-content-start flex-grow-1 invisible"><div class="h-100"></div></div>';
			for( let i = 1; i <= lines; i++ ) {
				out += '<div class="lqd-v-line d-inline-flex justify-content-start flex-grow-1"><div class="h-100"></div></div>';
			}
			out += '</div>';

			return out;
			
		}

		function get_overlay_bg() {
			
			if( !settings.enable_overlay_bg ) { return ''; }

			return '<span class="lqd-overlay lqd-imggrp-overlay-bg"></span>';
			
		}

		function get_overlay_link() {

			if ( settings.img_link.url && !settings.enable_lightbox ) {
				return '<a href="' + settings.img_link.url + '" class="lqd-overlay lqd-fi-overlay-link lqd-cc-label-trigger"></a>';
			}

		}

		function get_lightbox_link() {

			if ( settings.enable_lightbox && !settings.img_link.url ) {
				return '<a href="' + settings.img_link.url + '" class="lqd-overlay lqd-fi-overlay-link lqd-cc-label-trigger fresco" data-fresco-group="' + settings.lightbox_group_id + '"></a>';
			} else if ( settings.enable_lightbox && !settings.img_link.url ) {
				return '<a href="' + settings.img_link.url + '" class="lqd-overlay lqd-fi-overlay-link lqd-cc-label-trigger fresco" data-fresco-group="' + settings.lightbox_group_id + '"></a>';
			}

		}

		var render_image = {
			id: settings.image.id,
			url: settings.image.url,
			size: settings.thumbnail_size,
			dimension: settings.thumbnail_custom_dimension,
			model: view.getEditModel()
		};
		var render_image_url = elementor.imagesManager.getImageUrl( render_image );

		#>

		<div class="lqd-imggrp-single d-block pos-rel {{ settings.enable_hover3d === 'yes' ? 'perspective' : '' }}"
		{{{ get_data_options() }}}
		{{{ get_data_float_effect() }}}
		>
		<div class="lqd-imggrp-img-container d-inline-flex pos-rel align-items-{{ settings.label_pos ? settings.label_pos : 'center'}} justify-content-center {{ settings.enable_hover3d === 'yes' ? 'transform-style-3d' : '' }}">
			{{{ get_label('before') }}}
			<figure class="w-100 pos-rel" {{{ get_data_stacking_factor() }}} {{{ get_reveal_data() }}}>
				<img src="{{ render_image_url }}">
				{{{ get_overlay_bg() }}}
				{{{ get_label('inside') }}}
				{{{ get_lines() }}}
				{{{ get_overlay_link() }}}
				{{{ get_lightbox_link() }}}
			</figure>
		</div>

	</div>
	<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Fancy_Image() );