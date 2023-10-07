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
 * @since 1.0.0
 */
class LD_Text_Reveal extends Widget_Base {

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
		return 'ld_text_reveal';
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
		return __( 'Liquid Text Reveal', 'hub-elementor-addons' );
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
		return 'eicon-t-letter lqd-element';
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
		return [ 'hub-core' ];
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
		return [ 'text', 'reveal', 'animation' ];
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
				'label' => __( 'Text Reveal', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		ld_el_advanced_text( $this );

		$this->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 6,
				'default' => esc_html__( 'Add Your Text Here', 'hub-elementor-addons' ),
				'placeholder' => esc_html__( 'Add Your Text Here', 'hub-elementor-addons' ),
				'condition' => [
					'advanced_text_enable!' => 'yes',
				]
			]
		);

		$this->add_control(
			'tag',
			[
				'label' => esc_html__( 'HTML Tag', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'initialOpacity',
			[
				'label' => esc_html__( 'Initial opacity', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0.2,
				],
                'render_type' => 'template',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .lqd-text-reveal-el:not(.split-text-applied), {{WRAPPER}} .lqd-text-reveal-el figure, {{WRAPPER}} .lqd-text-reveal-el .lqd-chars' => 'opacity: {{SIZE}};',
				]
			]
		);

		$this->add_control(
			'finalOpacity',
			[
				'label' => esc_html__( 'Final opacity', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
                'render_type' => 'template',
			]
		);

		$this->add_control(
			'startTrigger',
			[
				'label' => esc_html__( 'Start trigger', 'hub-elementor-addons' ),
				'description' => __( 'Default is <b>top 70%</b> which means when top of the element hits <b>70% down</b> from <b>top</b> of the viewport.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'top 70%', 'hub-elementor-addons' ),
				'placeholder' => esc_html__( 'top 70%', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'endTrigger',
			[
				'label' => esc_html__( 'End trigger', 'hub-elementor-addons' ),
				'description' => __( 'Default is <b>bottom bottom</b> which means when <b>bottom</b> of the element hits the <b>bottom</b> of the viewport.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'bottom bottom', 'hub-elementor-addons' ),
				'placeholder' => esc_html__( 'bottom bottom', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'startFrom',
			[
				'label' => esc_html__( 'Start from', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'start',
				'options' => [
					'start' => esc_html__( 'Start', 'hub-elementor-addons' ),
					'end' => esc_html__( 'End', 'hub-elementor-addons' ),
					'center' => esc_html__( 'Center', 'hub-elementor-addons' ),
					'edges' => esc_html__( 'Edges', 'hub-elementor-addons' ),
					'random' => esc_html__( 'Random', 'hub-elementor-addons' ),
				],
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .lqd-text-reveal-el',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-text-reveal-el' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'hub-elementor-addons' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'hub-elementor-addons' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'hub-elementor-addons' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justify', 'hub-elementor-addons' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-text-reveal-el' => 'text-align: {{VALUE}}',
				],
				'toggle' => true,
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

		$tag = Utils::validate_html_tag( $settings['tag'] );
		$initialOpacity = $settings['initialOpacity']['size'];
		$finalOpacity = $settings['finalOpacity']['size'];
		$startTrigger = $settings['startTrigger'] ? $settings['startTrigger'] : "top 70%";
		$endTrigger = $settings['endTrigger'] ? $settings['endTrigger'] : "bottom bottom";
		$startFrom = $settings['startFrom'];

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => 'lqd-text-reveal-el mt-0 mb-0',
				'data-split-text' => 'true',
				'data-split-options' => wp_json_encode( array( 'type' => 'words, chars' ) ),
				'data-parallax' => 'true',
				'data-parallax-options' =>  wp_json_encode( array( 'disableOnMobile' => false, 'parallaxTargets' => '.lqd-chars, figure', 'start' => $startTrigger, 'end' => $endTrigger, 'scrub' => 3, 'skipWillChange' => true ) ),
				'data-parallax-from' => wp_json_encode( array( 'opacity' => $initialOpacity ) ),
				'data-parallax-to' => wp_json_encode( array( 'opacity' => $finalOpacity, 'stagger' => array( 'from' => $startFrom, 'each' => 1 ) ) ),
			]
		);

		printf( '<%1$s %2$s>%3$s</%1$s>', $tag, $this->get_render_attribute_string( 'wrapper' ), $settings['advanced_text_enable'] === 'yes' ? ld_el_get_advanced_text( $this ) : esc_html( $settings['text'] ) );

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Text_Reveal() );