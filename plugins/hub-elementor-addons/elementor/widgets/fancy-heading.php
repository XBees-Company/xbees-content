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
class LD_Fancy_Heading extends Widget_Base {

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
		return 'hub_fancy_heading';
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
		return __( 'Liquid Text', 'elementor' );
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
		return [ 'heading', 'title', 'text' ];
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
			return [ 'splittext' ];
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

		$this->start_controls_section(
			'section_section_title',
			array(
				'label' => __( 'Title', 'hub-elementor-elementor' ),
			)
		);

		ld_el_advanced_text( $this );
		
		$this->add_control(
			'content',
			[
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => array(
					'active' => true,
				),
				'rows' => '6',
				'default' => 'Add Your Heading Text Here',
				'condition' => [
					'advanced_text_enable!' => 'yes', 
				]
			]
		);

		$this->add_control(
			'content_description',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( '<div style="font-style:normal">If you want to use highlighted text use shortcode. Example:<br/><br/> <span style="font-weight:bold">[ld_highlight]</span> Your Text <span style="font-weight:bold">[/ld_highlight]</span></div>', 'hub-elementor-addons' ) ),
				'separator' => 'after',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'tag',
			[
				'label' => esc_html__( 'Element Tag', 'hub-elementor-addons' ),
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
					'{{WRAPPER}} .ld-fancy-heading' => 'text-align: {{VALUE}}',
				],
				'toggle' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_format_section',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'color',
			array(
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ld-fh-element, {{WRAPPER}} .ld-fh-element a' => 'color:{{VALUE}}',
				],
				'separator' => 'before',
				'condition' => [
					'add_gradient' => ''
				]
			)
		);

		$this->add_control(
			'color_hover',
			array(
				'label' => __( 'Hover color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ld-fancy-heading:hover .ld-fh-element, {{WRAPPER}} .ld-fancy-heading:hover .ld-fh-element a' => 'color:{{VALUE}}',
				],
				'condition' => [
					'add_gradient' => ''
				]
			)
		);

		$this->add_control(
			'add_gradient',
			[
				'label' => __( 'Gradient And Mask Image?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => ''	
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'color2',
				'label' => __( 'Fancy Heading Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],	
				'selector' => '{{WRAPPER}} .ld-fh-element',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => array(
					'add_gradient' => 'yes',
				)
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .ld-fh-element',
			]
		);

		$this->add_control(
			'use_inheritance',
			[
				'label' => __( 'Inherit font styles?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'true',
				'default' => 'false',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tag_to_inherite',
			array(
				'label' => esc_html__( 'Element Tag', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'default' => 'h1',
				'condition' => array(
					'use_inheritance' => 'true',
				),

			)
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'URL (Link)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'hub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Animation Section
		$this->start_controls_section(
			'animation_section',
			[
				'label' => __( 'Effects', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_split',
			[
				'label' => __( 'Enable text split?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'true',
				'default' => '',
				'separator' => 'before',
				'frontend_available' => true
			]
		);

		$this->add_control(
			'split_type',
			[
				'label' => __( 'Splitting type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lines',
				'options' => [
					'lines'  => __( 'Lines', 'hub-elementor-addons' ),
					'words' => __( 'Words', 'hub-elementor-addons' ),
					'chars, words' => __( 'Characters', 'hub-elementor-addons' ),
				],
				'condition' => [
					'enable_split' => 'true',
				],
				'frontend_available' => true
			]
		);

		$this->add_control(
			'use_mask',
			[
				'label' => __( 'Enabled mask?', 'hub-elementor-addons' ),
				'description' => __('Check to enable mask on title to use it in animation', 'hub-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'true',
				'default' => '',
				'condition' => [
					'enable_split' => 'true',
				],
			]
		);

		$this->add_control(
			'enable_txt_rotator',
			[
				'label' => __( 'Enable text rotator?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'rotator_type',
			[
				'label' => __( 'Animation type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'Slide', 'hub-elementor-addons' ),
					'basic' => __( 'Basic', 'hub-elementor-addons' ),
					'list' => __( 'List', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'enable_txt_rotator' => 'yes',
				),
			]
		);

		$this->add_responsive_control(
			'rotator_visible_words',
			[
				'label' => esc_html__( 'Visible words', 'elementor' ),
				'description' => esc_html__( 'For best results, set an odd number if your words count is even, and vice versa.', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => '3'
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .txt-rotate-keywords' => '--visible-words: {{SIZE}};',
				],
				'render_type' => 'template',
				'condition' => array(
					'enable_txt_rotator' => 'yes',
					'rotator_type' => 'list',
				),
			]
		);

		$this->add_control(
			'rotator_delay', [
				'label' => __( 'Words stay time', 'hub-elementor-addons' ),
				'description' => __( 'Stay time for each word in seconds. Default is 2 seconds', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => array(
					'enable_txt_rotator' => 'yes',
				),
			]
		);

		$this->add_control(
			'word_colors',
			[
				'label' => __( 'Words color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'enable_txt_rotator' => 'yes',
				),
				'selectors' => [
					'{{WRAPPER}} .txt-rotate-keywords' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rotator_list_active_word_color_start',
			[
				'label' => __( 'Active color start', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'enable_txt_rotator' => 'yes',
					'rotator_type' => 'list',
				),
				'selectors' => [
					'{{WRAPPER}} .txt-rotate-keywords-inner' => '--color-start: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rotator_list_active_word_color_stop',
			[
				'label' => __( 'Active color stop', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'enable_txt_rotator' => 'yes',
					'rotator_type' => 'list',
				),
				'selectors' => [
					'{{WRAPPER}} .txt-rotate-keywords-inner' => '--color-stop: {{VALUE}}',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'word', [
				'label' => __( 'Title word', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'word_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __( 'Text rotator words', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ word }}}',
				'condition' => array(
					'enable_txt_rotator' => 'yes',
				),
			]
		);

		$this->end_controls_section();

		// White Space Section
		$this->start_controls_section(
			'white_space_section',
			[
				'label' => __( 'White Space', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'whitespace',
			[
				'label' => __( 'Whitespace', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'Normal', 'hub-elementor-addons' ),
					'ws-nowrap' => __( 'Nowrap', 'hub-elementor-addons' ),
				]
			]
		);
		
		$this->end_controls_section();

		// Highlight Section
		$this->start_controls_section(
			'highlight_section',
			[
				'label' => __( 'Highlight', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'highlight_type',
			[
				'label' => __( 'Type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-highlight-underline',
				'options' => [
					''  => __( 'None', 'hub-elementor-addons' ),
					'lqd-highlight-underline'  => __( 'Classic', 'hub-elementor-addons' ),
					'lqd-highlight-custom-underline' => __( 'Custom 1', 'hub-elementor-addons' ),
					'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt' => __( 'Custom 2', 'hub-elementor-addons' ),
					'lqd-highlight-custom lqd-highlight-custom-3' => __( 'Custom 3', 'hub-elementor-addons' ),
					'lqd-highlight-custom lqd-highlight-custom-4' => __( 'Custom 4', 'hub-elementor-addons' ),
					'lqd-highlight-custom lqd-highlight-custom-5' => __( 'Custom 5', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'highlight_animation',
			[
				'label' => __( 'Animation', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-highlight-grow-left',
				'options' => [
					'lqd-highlight-grow-left'  => __( 'Grow From Left', 'hub-elementor-addons' ),
					'lqd-highlight-grow-bottom' => __( 'Grow From Bottom', 'hub-elementor-addons' ),
					'lqd-highlight-fadein' => __( 'Fade In', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'highlight_type' => 'lqd-highlight-underline',
				),
			]
		);

		$this->add_control(
			'highlight_reset_onhover',
			[
				'label' => __( 'Fill Text On Hover?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => array(
					'highlight_type' => 'lqd-highlight-underline',
				),
			]
		);

		$this->add_control(
			'highlight_color',
			[
				'label' => __( 'Highlight Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'highlight_type' => 'lqd-highlight-underline',
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner' => 'background: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'highlight_alt_color',
			[
				'label' => __( 'Highlight Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'highlight_type' => 'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner .lqd-highlight-brush-svg-2' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'highlight_color_brush',
			[
				'label' => __( 'Highlight Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'highlight_type' => [
						'lqd-highlight-custom-underline',
						'lqd-highlight-custom lqd-highlight-custom-3',
						'lqd-highlight-custom lqd-highlight-custom-4',
						'lqd-highlight-custom lqd-highlight-custom-5',
					]
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner .lqd-highlight-brush-svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'highlight_width',
			[
				'label' => __( 'Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => array(
					'highlight_type' => array(
						'lqd-highlight-underline',
						'lqd-highlight-custom-underline',
						'lqd-highlight-custom lqd-highlight-custom-3',
						'lqd-highlight-custom lqd-highlight-custom-4',
						'lqd-highlight-custom lqd-highlight-custom-5',
					),
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner .lqd-highlight-brush-svg' => 'width: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'highlight_height',
			[
				'label' => __( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => array(
					'highlight_type' => array(
						'lqd-highlight-underline',
						'lqd-highlight-custom-underline',
						'lqd-highlight-custom lqd-highlight-custom-3',
						'lqd-highlight-custom lqd-highlight-custom-4',
						'lqd-highlight-custom lqd-highlight-custom-5',
					),
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner, {{WRAPPER}} .lqd-highlight-inner .lqd-highlight-brush-svg' => 'height: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'highlight_offset',
			[
				'label' => __( 'Bottom Offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '0em',
				'placeholder' => __( 'Add line bottom offset, for ex -10px', 'hub-elementor-addons' ),
				'condition' => array(
					'highlight_type!' => '',
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner' => 'bottom: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'highlight_offset_left',
			[
				'label' => __( 'Left Offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '0em',
				'placeholder' => __( 'Add line left offset, for ex -10px', 'hub-elementor-addons' ),
				'condition' => array(
					'highlight_type!' => '',
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner' => 'left: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'highlight_roudness',
			[
				'label' => __( 'Roundness', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Add line roudness in px, for ex 5px', 'hub-elementor-addons' ),
				'condition' => array(
					'highlight_type' => 'lqd-highlight-underline',
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner' => 'border-radius: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Outline Section
		$this->start_controls_section(
			'outline_section',
			[
				'label' => __( 'Outline', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'hover_text_outline',
			[
				'label' => __( 'Outline Text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'ld-fh-outline',
				'default' => '',
			]
		);

		$this->add_control(
			'outline_appearance',
			[
				'label' => __( 'Appearance', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'None', 'hub-elementor-addons' ),
					'ld-fh-outline-static' => __( 'Default', 'hub-elementor-addons' ),
					'ld-fh-outline' => __( 'On Hover', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'hover_text_outline' => 'ld-fh-outline',
				),
			]
		);

		$this->add_control(
			'hover_text_outline_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-fh-txt-outline' => '-webkit-text-stroke-color: {{VALUE}}', 
				],
				'condition' => array(
					'hover_text_outline' => 'ld-fh-outline',
				),
			]
		);

		$this->add_control(
			'hover_text_outline_width',
			[
				'label' => __( 'Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '2px',
				'placeholder' => __( 'Set hover text outline width in px. for ex. 5px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .ld-fh-txt-outline' => '-webkit-text-stroke-width: {{VALUE}}', 
				],
				'condition' => array(
					'hover_text_outline' => 'ld-fh-outline',
				),
			]
		);

		$this->end_controls_section();


		// Vertical Text Section
		$this->start_controls_section(
			'vertical_txt_section',
			[
				'label' => __( 'Vertical Text', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'vertical_txt',
			[
				'label' => __( 'Vertical Text?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
		$this->end_controls_section();


		// Style Tab
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ld_inner_margin',
			[
				'label' => __( 'Heading Margin', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'bottom' => '0.5',
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .ld-fh-element' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'ld_inner_padding',
			[
				'label' => __( 'Heading Padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ld-fh-element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$color_sections_hide = get_post_type() === 'liquid-header' ? '' : '_hide';

		// Sticky Header
		$this->start_controls_section(
			'sticky_colors' . $color_sections_hide,
			[
				'label' => __( 'Sticky Color', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_color',
			array(
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.is-stuck {{WRAPPER}} .ld-fh-element, .is-stuck {{WRAPPER}} .ld-fh-element span' => 'color:{{VALUE}} !important;',
				],
				'condition' => [
					'add_gradient' => ''
				]
			)
		);

		$this->end_controls_section();

		// Colors Over Light Rows
		$this->start_controls_section(
			'sticky_light_colors' . $color_sections_hide,
			[
				'label' => __( 'Colors Over Light Rows', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_light_color',
			array(
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .ld-fh-element, {{WRAPPER}}.lqd-active-row-light .ld-fh-element span, {{WRAPPER}}.lqd-active-row-light .ld-fh-element a' => 'color:{{VALUE}} !important;',
				],
				'condition' => [
					'add_gradient' => ''
				]
			)
		);

		$this->end_controls_section();

		// Colors Over Dark Rows
		$this->start_controls_section(
			'sticky_dark_colors' . $color_sections_hide,
			[
				'label' => __( 'Colors Over Dark Rows', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_dark_color',
			array(
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .ld-fh-element, {{WRAPPER}}.lqd-active-row-dark .ld-fh-element span, {{WRAPPER}}.lqd-active-row-dark .ld-fh-element a' => 'color:{{VALUE}} !important;',
				],
				'condition' => [
					'add_gradient' => ''
				]
			)
		);

		$this->end_controls_section();
		
		$this->end_controls_tab();

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();

		$settings = $this->get_settings();

		$classnames = [];

		if ( $settings['enable_split'] !== '' ) {
			array_push($classnames, 'lqd-el-has-inner-anim');
		}

		$this->add_render_attribute( '_wrapper', 'class', $classnames );
		
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
		$this->add_inline_editing_attributes( 'content', 'basic' );

		$classes = array( 
			'ld-fancy-heading',
			'pos-rel',
			($settings['use_mask'] === 'true' ? 'mask-text' : ''),
			$settings['hover_text_outline'],
			$settings['outline_appearance'],
		);

		$id = uniqid("ld-fancy-heading-");

		?>

		<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>">
			<?php $this->fancy_title(); ?>
		</div>

		<?php
	}

	protected function content_template() {

		?>
		<#

		const wrapperClassnames = [
			settings.use_mask === 'true' ? 'mask-text' : '',
			settings.hover_text_outline,
			settings.outline_appearance,
		].filter(classname => classname !== '');

		const highlightType = settings.highlight_type;
		let highlightClassname = highlightType;

		if ( highlightType === 'lqd-highlight-underline' ) {
			highlightClassname = 'lqd-highlight-classic';
		} else if ( highlightType === 'lqd-highlight-custom-underline' ) {
			highlightClassname = 'lqd-highlight-custom lqd-highlight-custom-1';
		} else if ( highlightType === 'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt' ) {
			highlightClassname = 'lqd-highlight-custom lqd-highlight-custom-2';
		}

		const titleClassnames = [
			settings.add_gradient === 'yes' && settings.color2 !== '' ? 'ld-gradient-heading' : '',
			settings.whitespace,
			highlightClassname,
			settings.highlight_animation,
			settings.highlight_reset_onhover === 'yes' ? 'lqd-highlight-reset-onhover' : '',
			settings.vertical_txt === 'true' ? 'text-vertical' : '',
			settings.enable_split === 'true' ? getSplitClassnames() : '',
			settings.use_inheritance === 'true' ? settings.tag_to_inherite : settings.tag,
			settings.tag !== 'p' && settings.tag !== 'div' && settings.tag !== 'span' ? 'elementor-heading-title' : ''
		].filter(classname => classname !== '');

		const link = settings.link.url;

		const wrapperAttrs = {
			'class': ['ld-fancy-heading', 'pos-rel', wrapperClassnames.join(' ')],
			'id': view.model.get('id')
		};

		const titleAttrs = {
			'class': [
				'ld-fh-element',
				'd-inline-block',
				'pos-rel',
				titleClassnames.join(' '),
				'elementor-inline-editing',
				settings.enable_txt_rotator === 'yes' && settings.rotator_type !== '' ? 'txt-rotator-' + settings.rotator_type : ''
			],
			'data-elementor-setting-key': 'content',
			'data-elementor-inline-editing-toolbar': 'basic'
		};

		function getAdvancedText() {

			const items = settings.advanced_text_content;
			let content = '';

			console.log(items)

			if ( items.length >= 1 ){
        items.forEach(item => {
            content += `<span class="lqd-adv-txt-item elementor-repeater-item-${item._id}">`;
            if ( item.image?.url !== '' ){
							const render_image = {
								id: item.image.id,
								url: item.image.url,
								size: item.thumbnail_size,
								dimension: item.thumbnail_custom_dimension,
								model: view.getEditModel()
							};
							const render_image_url = elementor.imagesManager.getImageUrl( render_image );
							const img_html = `<figure class="lqd-adv-txt-fig pos-rel d-inline-flex"><img src="${render_image_url}" /></figure>`;
							content = item.image_align === 'left' ? content + img_html + item.text : content + item.text + img_html; 
            } else {
							content += item.text;
            }
            content += "</span>";
				})
			}

			return content;
			
		}

		function getSplitClassnames() {
			const {split_type} = settings;
			let classname = 'lqd-split-';

			if ( split_type === 'chars, words' ) {
				classname += `${classname}chars`;
			} else {
				classname += `${classname}${split_type}`;
			}
			return classname;
		}

		function getTextRotatorWords() {

			if (settings.enable_txt_rotator !== 'yes'){
				return '';
			}

			const words = settings.items;
			let out = '';
			let style_word = '';

			out += ' <span class="txt-rotate-keywords">';
			if ( settings.rotator_type === 'list' ) {
				out += ' <span class="txt-rotate-keywords-inner d-block h-100">';
			}
			if ( words ) {
				_.each( words, function( word, i ) {
					var active = ( i === 0 ) ? ' active' : '';
					style_word = ( word.word_color ) ? 'style="color:' + word.word_color + '"' : '';					
					out += '<span class="txt-rotate-keyword" ' + style_word + '><span>' + word.word + '</span></span>';
				} );
			}
			
			if ( settings.rotator_type === 'list' ) {
				out += ' </span>';
			}
			out += '</span>';
			return out;
		}

		const getRotatorOpts = (() => {

			if( settings.enable_txt_rotator !== 'yes' ) {
				return '';
			}

			titleAttrs['data-text-rotator'] = true;
			const options = {};

			if ( settings.rotator_type !== '' ) options['animationType'] = settings.rotator_type;
			if ( settings.rotator_delay !== '' ) {
				options['delay'] = settings.rotator_delay;
			}

			if ( options ) {
				titleAttrs['data-text-rotator-options'] = JSON.stringify( options );
			}

		})();

		const getHighlightOpts = (() => {

			if ( ! settings.content.includes("ld_highlight") ){
				return;
			}

			titleAttrs['data-inview'] = true;
			titleAttrs['data-transition-delay'] = true;
			titleAttrs['data-delay-options'] = JSON.stringify({ "elements": ".lqd-highlight-inner", "delayType": "transition" });

		})();
		
		// Split Animation
		const getSplitOptions = (() => {

			if( settings.enable_split === '' ) {
				return;
			}

			titleAttrs['data-split-text'] = true;
			titleAttrs['data-split-options'] = JSON.stringify( { "type": settings.split_type } );
			
		})();

		function getSVGHighlight() {

			let svg = '';

			if ( settings.highlight_type === 'lqd-highlight-custom-underline' ) {
				svg = '<svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-1" xmlns="http://www.w3.org/2000/svg" width="235.509" height="13.504" viewBox="0 0 235.509 13.504" aria-hidden="true" preserveAspectRatio="none"><path d="M163,.383a13.044,13.044,0,0,1,1.517-.072,3.528,3.528,0,0,1,1.237-.134q.618.044,1.237.044a.249.249,0,0,1-.1.178.337.337,0,0,0-.1.266q3.092.088,6.184-.044T178.953.4l-.206-.088a12,12,0,0,0,4.123,0,13.467,13.467,0,0,1,5.772,0q1.443-.178,2.68-.266A5.978,5.978,0,0,1,193.8.4,16.707,16.707,0,0,1,198.01.045q2.164.088,4.844.088-.618.088-.824.134L201.412.4a3.893,3.893,0,0,0,2.061,0,5.413,5.413,0,0,1,1.649-.356q.618.088,1.134.178a9.762,9.762,0,0,0,1.544.09,17,17,0,0,1,3.092-.266q1.649,0,3.5.178,2.886.088,5.875.044t5.875-.222q0,.088.206.088h.412a21.975,21.975,0,0,0,2.577.889A12.458,12.458,0,0,1,232.12,2.18a3.962,3.962,0,0,1,1.031.622A3.349,3.349,0,0,1,234.8,3.825a5.079,5.079,0,0,1,.618,1.111q.412.534-1.031.98-1.031.444-.618.98a2.09,2.09,0,0,1,.206.889q0,.444.825.889.618.8-.206,1.245l-1.237.534q-1.443-.088-2.68-.134a17.255,17.255,0,0,1-2.267-.222,3.128,3.128,0,0,0-.928-.044,3.129,3.129,0,0,1-.928-.044q-2.267-.178-4.432-.266T217.7,9.476q-1.649-.088-2.886-.088a17.343,17.343,0,0,1-2.474-.178q-3.916,0-7.73-.088t-7.73-.266l-12.471-.178q-6.287-.088-12.883-.088h-1.958q-.928,0-1.958.088h-2.061q-1.031,0-2.061-.088-2.68-.088-5.256-.134t-5.256.044h-5.462q-2.577,0-5.462.088-4.535.088-8.76.178t-8.554.088q-2.886.088-5.875.088t-5.875.088q-1.443.088-2.886.134t-3.092.044q-4.741.178-9.791.312t-9.791.312q-2.267.088-4.329.088T78.77,10.1q-4.329.266-8.863.49t-9.276.49q-1.237.088-2.68.134a24.356,24.356,0,0,0-2.683.224q-2.68.178-5.462.312t-5.668.4q-2.474.266-4.741.312t-4.741.044q-1.031-.088-1.958-.134a9.684,9.684,0,0,1-1.958-.312,12.5,12.5,0,0,0-1.443-.312q-.825-.134-1.856-.31-2.886.356-6.39.666t-6.8.845a26.709,26.709,0,0,1-2.886.356,20.758,20.758,0,0,1-9.482-.889Q.232,11.962.026,11.25T1.263,9.917q0-.266.825-.266a13.039,13.039,0,0,0,2.886-.444A17.187,17.187,0,0,1,7.86,8.672q3.092-.266,6.184-.8,1.649-.178,3.3-.312t3.5-.312q4.123-.354,8.039-.712t8.039-.622q9.478-.8,18.758-1.338,2.68-.178,5.153-.356t4.741-.356q2.474-.178,5.05-.356T75.88,3.24h1.34a4.829,4.829,0,0,0,1.34-.178q2.267-.178,4.329-.222t4.329-.134a7.256,7.256,0,0,1,2.267,0,3.459,3.459,0,0,0,1.031-.088,6.009,6.009,0,0,1,2.37-.266,14.745,14.745,0,0,0,2.783-.088q1.649,0,2.474.088a1.308,1.308,0,0,1,.185.011,1.226,1.226,0,0,1,.33-.1,3.656,3.656,0,0,0,.515-.088,4.433,4.433,0,0,1,2.886.266q.412-.088,1.031-.178l1.237-.178q.412,0,1.031.044a5.761,5.761,0,0,0,1.237-.044q2.886-.088,5.772-.044a53.829,53.829,0,0,0,5.772-.222,9.505,9.505,0,0,1,1.34-.088h1.34a4.428,4.428,0,0,1,.821-.258l.825-.178a15.178,15.178,0,0,1,1.855.444,3.028,3.028,0,0,1,1.031-.534,4.039,4.039,0,0,1,1.443-.178,6.158,6.158,0,0,1,1.649.178,5.05,5.05,0,0,0,2.267.268q1.855-.088,3.813-.134T138.13,1.2q1.031,0,2.164-.044t2.37-.044q-.206-.088.412-.534h3.092q.412,0,.309.266t.928,0a5.845,5.845,0,0,1,1.443,0,31.833,31.833,0,0,0,5.359.088,21.471,21.471,0,0,1,6.8.178,5.236,5.236,0,0,0,1.031-.4q.412-.222.825-.4a.694.694,0,0,1,.137.07Z" transform="translate(0 0.002)"/></svg>';
			} else if ( settings.highlight_type === 'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt' ) {
				svg = '<svg class="lqd-highlight-pen" width="51" height="51" viewBox="0 0 51 51" xmlns="http://www.w3.org/2000/svg"><path d="M36.204 1.044C32.02 2.814 5.66 31.155 4.514 35.116c-.632 2.182-1.75 5.516-2.483 7.409-3.024 7.805-1.54 9.29 6.265 6.265 1.893-.733 5.227-1.848 7.41-2.477 3.834-1.105 4.473-1.647 19.175-16.27 0 0 10.63-10.546 15.21-15.125C53 8.997 42.021-1.418 36.203 1.044Zm7.263 5.369c3.56 3.28 4.114 4.749 2.643 6.995l-1.115 1.7-4.586-4.543-4.585-4.544 1.42-1.157C39.311 3.18 40.2 3.4 43.467 6.413ZM37.863 13.3l4.266 4.304-11.547 11.561-11.547 11.561-4.48-4.446-4.481-4.447 11.404-11.418c6.273-6.28 11.566-11.42 11.762-11.42.197 0 2.277 1.938 4.623 4.305ZM12.016 39.03l3.54 3.584-3.562 1.098-5.316 1.641c-1.665.516-1.727.455-1.211-1.21l1.614-5.226c1.289-4.177.685-4.191 4.935.113Z"/></svg><svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-2" width="233" height="13" viewBox="0 0 233 13" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="none"><path d="m.624 9.414-.312-2.48C0 4.454.001 4.454.002 4.454l.035-.005.102-.013.398-.047c.351-.042.872-.102 1.557-.179 1.37-.152 3.401-.368 6.05-.622C13.44 3.081 21.212 2.42 31.13 1.804 50.966.572 79.394-.48 113.797.24c34.387.717 63.927 2.663 84.874 4.429a1048.61 1048.61 0 0 1 24.513 2.34 641.605 641.605 0 0 1 8.243.944l.432.054.149.02-.318 2.479-.319 2.48-.137-.018c-.094-.012-.234-.03-.421-.052a634.593 634.593 0 0 0-8.167-.936 1043.26 1043.26 0 0 0-24.395-2.329c-20.864-1.76-50.296-3.697-84.558-4.413-34.246-.714-62.535.332-82.253 1.556-9.859.612-17.574 1.269-22.82 1.772-2.622.251-4.627.464-5.973.614a213.493 213.493 0 0 0-1.901.22l-.094.01-.028.004Z"/></svg>';
			} else if ( settings.highlight_type === 'lqd-highlight-custom lqd-highlight-custom-3' ) {
				svg = '<svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-3" aria-hidden="true" preserveAspectRatio="none" width="198" height="73" viewBox="0 0 198 73" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M2.01552 34.4474C2.47578 34.6889 2.50693 34.5903 2.16023 34.1233C1.43556 33.1192 0.0859359 27.4895 0.559288 27.3889C0.774448 27.3431 0.83309 27.0373 0.700676 26.679C0.568262 26.3208 0.771476 26.0506 1.1747 26.0528C1.57327 26.0764 1.82588 25.8366 1.75995 25.5266C1.69401 25.2165 1.47155 25.0165 1.25248 25.0631C1.0334 25.1097 0.834346 24.9475 0.775482 24.6708C0.716618 24.394 1.10706 24.1678 1.6498 24.1291C2.63867 24.0731 3.05732 22.7635 2.17693 22.4836C1.9012 22.4032 2.06656 22.229 2.5556 22.0964C3.11954 21.9458 3.42557 22.1158 3.39771 22.5664C3.36736 23.0053 3.65609 23.2526 4.12825 23.1992C5.29377 23.075 5.61444 23.5782 4.906 24.424C4.65184 24.7544 4.34369 25.0394 3.99456 25.267C3.82555 25.3183 3.74367 25.5677 3.77733 25.8846C3.7977 26.3381 3.734 26.7915 3.58945 27.2218C3.42894 27.8231 3.39405 28.4509 3.48696 29.0663C3.58253 29.63 3.48825 30.2095 3.21892 30.7139C2.9406 31.0971 2.94306 31.2673 3.24428 31.2032C3.70688 31.1048 4.72117 32.9132 4.80429 33.9913C4.82912 34.3724 5.00368 34.6645 5.16505 34.6302C5.32642 34.5958 5.7821 34.9937 6.1968 35.5689C6.62228 36.1276 6.74531 36.4561 6.50306 36.3216C6.2608 36.187 6.25164 36.5141 6.48173 37.0672C6.71182 37.6204 7.07155 37.8843 7.30909 37.6794C7.54663 37.4745 8.00577 37.6243 8.37519 38.0394C8.7446 38.4546 8.90305 38.7767 8.72016 38.8156C8.55879 38.8499 8.88485 39.1669 9.42779 39.4992C9.9588 39.8151 10.37 40.2982 10.597 40.8728C10.6664 41.0876 10.8047 41.2735 10.9906 41.4017C11.1764 41.5298 11.3994 41.593 11.6248 41.5814C11.9474 41.6377 12.2542 41.7625 12.5244 41.9475C12.7946 42.1326 13.0219 42.3734 13.191 42.6539C13.5597 43.2246 13.9597 43.5719 14.0402 43.3688C14.1348 43.179 14.9022 43.5095 15.7511 44.1171C16.9235 45.0576 18.2163 45.8374 19.5951 46.4358C20.3026 46.7484 20.8941 47.2564 20.9139 47.5609C20.9306 47.8507 21.6753 48.2331 22.5899 48.4096C23.6677 48.6128 24.2941 49.0204 24.4166 49.5964C24.5863 50.3944 24.5433 50.4036 24.0652 49.7948C23.5733 49.1737 23.5264 49.1836 23.6961 49.9817C23.9193 51.0311 24.3702 51.0895 24.8044 50.117C24.9078 49.9458 25.0668 49.8152 25.255 49.7471C25.4431 49.679 25.6489 49.6775 25.838 49.7429C26.531 49.9348 26.5361 50.0115 25.8602 50.5876C25.4219 50.9589 25.2635 51.4301 25.4904 51.7325C25.7644 52.1219 25.9195 52.0583 26.086 51.4668C26.2694 50.887 26.4001 50.8285 26.6297 51.2734C26.8764 51.7464 27.0593 51.7075 27.5656 51.0744C27.9725 50.5554 28.3213 50.4506 28.5763 50.7511C28.8312 51.0297 29.176 51.2096 29.5503 51.2595C30.3668 51.482 31.147 51.8207 31.867 52.2654C32.4737 52.6661 33.1345 52.9782 33.8295 53.1922C35.8327 53.7636 37.7963 54.4657 39.7076 55.294C40.0627 55.4539 40.4483 55.5351 40.8377 55.532C41.5926 55.6364 42.3308 55.8378 43.0342 56.1311C46.6557 57.3817 50.3413 58.4388 54.0752 59.2979C54.2796 59.2544 54.7311 59.4978 55.1775 59.8812C55.624 60.2647 56.0582 60.3737 56.2249 60.1532C56.3917 59.9327 56.8596 60.0183 57.2878 60.3443C57.7159 60.6703 58.1392 60.8583 58.259 60.7868C58.6639 60.7479 59.0724 60.8038 59.4519 60.9502C59.9257 61.1043 60.4246 61.1658 60.9216 61.1314C61.6531 60.9758 63.7635 61.9632 63.5808 62.3731C63.4862 62.5629 63.7368 62.525 64.1249 62.2881C64.967 61.7532 67.7859 62.2659 67.937 62.9759C67.9967 63.2566 68.2276 63.2852 68.4126 63.0445C68.6525 62.7307 68.7594 62.8777 68.721 63.49C68.692 64.2526 68.7769 64.2816 69.2401 63.6576C69.6699 63.0878 70.4171 63.0056 72.5246 63.3455C74.0148 63.5847 75.2012 63.9815 75.1437 64.24C75.1329 64.2982 75.1361 64.3581 75.153 64.4147C75.1699 64.4714 75.2001 64.5232 75.2411 64.5659C75.282 64.6085 75.3326 64.6408 75.3885 64.66C75.4444 64.6792 75.5041 64.6848 75.5626 64.6764C75.8409 64.6632 76.5085 64.6296 77.0577 64.6211C77.6068 64.6127 78.3066 64.5722 78.6356 64.5329C79.2789 64.524 79.9212 64.5841 80.5516 64.7122C81.4985 64.8819 81.8566 65.1911 81.8242 65.8318C81.7854 66.4421 81.889 66.5591 82.1444 66.2268C82.6475 65.579 85.959 64.9371 86.3656 65.4067C86.4511 65.5152 86.5584 65.6046 86.6806 65.6691C86.8027 65.7336 86.9371 65.7718 87.0749 65.7813C87.2995 65.7795 88.1796 65.7937 89.0563 65.7922C89.9727 65.823 90.8557 66.1434 91.5786 66.7074C92.5226 67.6035 93.1018 67.789 92.5291 67C92.3234 66.7197 92.6558 66.4323 93.3443 66.2859C93.9898 66.1486 94.5534 66.2608 94.6131 66.5415C94.6697 66.8075 95.2086 66.9096 95.7723 66.758C97.0616 66.4225 101.054 66.793 101.151 67.2497C101.195 67.457 102.013 67.4987 103.012 67.3477C104.01 67.1967 104.966 67.2867 105.158 67.5555C105.336 67.8111 106.016 67.8844 106.665 67.7135C107.258 67.5487 107.887 67.5713 108.467 67.7781C108.909 67.9854 109.397 68.0782 109.885 68.0479C112.431 67.6694 115.008 67.5507 117.578 67.6935C118.601 67.8213 119.632 67.8601 120.662 67.8096C121.483 67.7586 122.81 67.7084 123.566 67.7174C125.899 67.7465 133.92 67.4462 136.632 67.2406C138.042 67.145 139.624 67.0366 140.173 67.0281C140.723 67.0197 142.563 66.8439 144.276 66.6503C145.989 66.4567 148.72 66.1837 150.331 66.0423C152.472 65.8364 154.601 65.5229 156.71 65.1028C158.02 64.7423 159.384 64.6198 160.737 64.7411C160.898 64.8286 161.086 64.8501 161.263 64.8012C161.439 64.7522 161.589 64.6366 161.682 64.4788C161.873 64.1601 164.294 63.3825 167.074 62.7606C168.909 62.433 170.706 61.9213 172.439 61.2332C172.616 61.0104 172.834 61.2421 172.944 61.7595C173.123 62.6015 173.166 62.5924 173.43 61.7175C173.642 61.0232 174.531 60.4949 176.437 59.8891C177.459 59.6281 178.446 59.2466 179.378 58.7526C180.024 58.3283 180.724 57.9924 181.459 57.7538C182.508 57.3607 183.504 56.8374 184.422 56.1964C185.283 55.535 185.702 55.4458 186.242 55.8707C186.815 56.2896 186.884 56.2453 186.58 55.6599C186.147 54.8411 187.679 53.586 188.529 54.04C188.797 54.1876 188.852 54.0796 188.654 53.7814C188.338 53.3538 189.823 52.0342 190.545 52.0974C190.716 52.1071 190.785 51.9072 190.72 51.5972C190.704 51.5274 190.703 51.4552 190.716 51.385C190.729 51.3148 190.757 51.2481 190.797 51.1889C190.837 51.1297 190.889 51.0793 190.949 51.0409C191.009 51.0025 191.077 50.9768 191.147 50.9654C191.825 50.8213 193.319 47.4297 193.648 45.2744C194.298 41.1199 191.318 36.5943 184.205 30.9084C183.488 30.3353 182.994 29.6522 183.105 29.3812C183.223 29.0932 183.182 29.058 182.982 29.2836C182.809 29.4748 180.918 28.6718 178.837 27.5073C177.591 26.9064 176.421 26.1602 175.351 25.2843C175.546 25.2427 174.36 24.6455 172.691 23.9343C171.411 23.4152 170.17 22.8068 168.975 22.1137C168.651 21.8497 168.256 21.685 167.84 21.6396C167.398 21.6959 166.95 21.6014 166.569 21.3714C166.187 21.1415 165.894 20.7895 165.738 20.3725C165.625 19.8404 165.339 19.7157 164.882 19.9983C164.674 20.1102 164.435 20.1493 164.202 20.1093C163.97 20.0693 163.757 19.9525 163.598 19.7776C163.263 19.4165 162.887 19.3156 162.704 19.5355C162.52 19.7554 162.007 19.5907 161.467 19.1648C160.926 18.739 160.564 18.5687 160.608 18.776C160.65 18.9716 160.222 18.9193 159.696 18.6633C159.161 18.4214 158.56 18.2916 158.402 18.3977C158.245 18.5037 157.921 18.1443 157.691 17.5911C157.437 16.9806 157.084 16.747 156.796 16.978C156.226 17.4703 152.17 16.5869 152.032 15.9365C151.978 15.6852 151.665 15.536 151.321 15.6093C150.686 15.7443 145.726 14.5748 143.393 13.7574C142.191 13.382 140.965 13.0906 139.722 12.8852C138.15 12.6327 137.289 12.2292 137.179 11.7119C137.054 11.1251 136.882 11.0593 136.496 11.5176C135.922 12.1806 125.958 10.3446 124.792 9.35764C124.009 8.69001 123.626 8.6786 124.102 9.33486C124.307 9.61514 124.176 9.73617 123.794 9.63237C123.412 9.52856 123.181 9.23721 123.239 8.97864C123.289 8.73583 123.026 8.71727 122.666 8.93069C122.068 9.28997 118.527 8.97692 116.534 8.38166C116.135 8.26348 115.721 8.20578 115.305 8.21049C112.808 8.30931 99.8959 6.49821 99.4183 5.99767C99.0798 5.62193 98.7673 5.58005 98.7055 5.87123C98.5979 6.32652 96.1061 6.28505 86.0379 5.63053C84.7716 5.54513 73.6532 5.50444 65.8819 5.5462C65.2189 5.54818 63.1165 5.65592 61.1525 5.77923C59.1884 5.90254 57.2121 5.96815 56.718 5.91886C54.6288 6.04988 52.5476 6.28778 50.4827 6.63164C47.5472 7.05152 44.7804 7.36599 44.3334 7.32613C42.6128 7.16663 25.8045 11.1431 21.4751 12.7284C17.1146 14.3355 16.9521 14.3548 16.565 13.4333C16.2509 12.6966 15.9689 12.5869 15.2898 12.9889C15.1696 13.0774 15.0325 13.14 14.8869 13.1728C14.7414 13.2057 14.5906 13.208 14.4441 13.1798C14.2976 13.1515 14.1585 13.0932 14.0357 13.0085C13.9128 12.9238 13.8088 12.8147 13.7302 12.6878C13.1443 11.9947 13.1347 11.9497 13.7167 12.4127C14.274 12.8656 14.4722 12.7927 14.8686 12.0133C15.8626 10.0252 27.7222 5.72632 35.0839 4.68607C35.3453 4.64583 35.7251 5.16304 35.8796 5.78341C36.1539 6.91494 36.1647 6.91265 36.1848 5.57948C36.2104 4.43116 36.2654 4.37244 36.5225 5.24493C36.7851 6.16226 36.8152 6.14052 36.8037 4.98069C36.7979 4.26635 36.9261 3.81178 37.0821 3.96363C39.3031 3.87683 41.5125 3.59814 43.6855 3.13067C51.0682 1.83856 50.1603 1.95804 55.2788 1.54516C64.3348 0.824345 67.6766 0.622705 68.271 0.774321C69.3049 0.830904 70.3419 0.781627 71.3658 0.627257C72.3124 0.457587 73.2785 0.424245 74.2346 0.528242C74.8495 0.681042 75.4868 0.723424 76.1165 0.653413C76.8783 0.599373 77.6427 0.591449 78.4054 0.629692C78.864 0.67118 80.3191 0.639758 81.6972 0.563382C82.764 0.419993 83.8496 0.578682 84.8307 1.02142C85.1644 1.32152 85.5938 1.38455 85.7295 1.12364C85.8652 0.862742 88.0846 0.777115 90.6421 0.958983C93.1867 1.13336 97.0388 1.37518 99.1675 1.49696C104.25 1.7603 116.16 3.1986 117.539 3.70681C118.165 3.93644 118.826 4.05696 119.493 4.06311C121.269 4.00934 125.365 4.86887 125.462 5.32657C125.522 5.60726 125.678 5.65185 125.844 5.43038C126.144 5.04256 130.388 5.69987 130.845 6.20694C131.06 6.39529 131.333 6.5057 131.62 6.5205C135.384 6.77084 136.141 6.94911 137.095 7.75017C137.682 8.23859 138.068 8.36098 137.999 8.03628C137.93 7.71158 138.115 7.57911 138.43 7.74001C138.739 7.90538 139.078 8.00708 139.427 8.0391C142.822 8.63915 146.171 9.47525 149.45 10.5413C149.618 10.6652 149.81 10.7534 150.013 10.8005C150.216 10.8476 150.427 10.8526 150.633 10.8152C151.265 10.8411 151.864 11.1057 152.308 11.5557C152.84 12.0448 153.237 12.2229 153.181 11.9569C153.124 11.6909 153.791 11.8118 154.637 12.2493C155.331 12.5278 155.924 13.0106 156.337 13.6337C156.419 14.018 156.523 13.9805 156.626 13.5109C156.756 12.9579 157.229 12.981 158.762 13.6128C159.589 13.975 160.445 14.2682 161.321 14.4895C161.485 14.5127 161.643 14.5695 161.785 14.6564C161.926 14.7432 162.048 14.8582 162.144 14.9942C162.225 15.123 162.344 15.2236 162.484 15.2823C162.625 15.341 162.78 15.3548 162.929 15.322C163.23 15.2579 163.428 15.4479 163.374 15.7221C163.312 16.0133 163.578 16.0497 163.97 15.8274C164.361 15.6052 164.73 15.6503 164.793 15.9457C164.856 16.241 165.15 16.3022 165.42 16.0904C165.687 15.864 165.984 15.9398 166.05 16.2499C166.119 16.5746 165.989 16.8648 165.774 16.9106C165.559 16.9563 165.52 17.1966 165.715 17.4792C165.91 17.7618 166.282 17.7133 166.611 17.3663C166.752 17.2127 166.926 17.0923 167.119 17.0137C167.312 16.9351 167.521 16.9003 167.729 16.9119C168.105 16.9864 168.046 17.2922 167.564 17.8272C167.153 18.275 166.888 18.8377 166.805 19.4401C166.79 20.0567 166.895 20.023 167.232 19.2257C167.982 17.5214 169.644 17.2447 171.053 18.5827C171.532 19.0369 172.096 19.2564 172.247 19.0698C172.417 18.864 172.607 18.9627 172.673 19.2727C172.739 19.5827 172.939 19.6791 173.121 19.4555C173.29 19.2497 173.488 19.3314 173.554 19.6414C173.62 19.9515 173.802 20.0671 173.942 19.8828C174.086 19.7132 174.644 19.9033 175.135 20.309C176.869 21.7322 178.975 22.8748 179.599 22.7421C179.806 22.729 180.012 22.7806 180.188 22.8896C180.365 22.9986 180.503 23.1597 180.583 23.3506C180.79 23.7391 181.095 23.9062 181.254 23.7027C181.432 23.4799 181.737 23.7543 182.001 24.3615C182.252 24.9574 182.561 25.2464 182.738 25.0227C182.896 24.8041 184.546 25.7504 186.386 27.109C189.931 29.7531 192.963 33.0231 195.332 36.7578C196.413 38.7216 197.581 42.3658 197.258 42.8045C197.147 43.3124 197.208 43.8429 197.433 44.312C197.981 45.831 196.722 50.8582 195.754 51.0641C195.558 51.1232 195.391 51.2541 195.287 51.4309C195.182 51.6077 195.149 51.8173 195.192 52.0178C195.194 52.3304 195.129 52.6399 195.002 52.9254C194.875 53.211 194.688 53.466 194.454 53.6734C193.941 54.17 193.501 54.7367 193.148 55.3568C193.079 55.5519 192.948 55.7194 192.776 55.834C192.603 55.9486 192.399 56.0042 192.192 55.9924C191.895 55.9166 191.663 56.0436 191.71 56.2646C191.908 57.1957 186.504 60.8629 184.002 61.4726C183.438 61.6232 183.099 61.8813 183.243 62.0817C183.387 62.2822 182.909 62.57 182.177 62.7256C181.445 62.8811 180.752 62.8437 180.608 62.6423C180.477 62.4532 180.491 62.6212 180.634 62.9761C180.841 63.4727 180.607 63.6461 179.72 63.6499C179.046 63.6542 178.573 63.8631 178.627 64.1144C178.677 64.3511 177.863 64.6479 176.776 64.7707C175.689 64.8936 174.77 65.2279 174.698 65.5195C174.625 65.811 172.575 66.4821 170.135 67.0151C167.696 67.5482 164.58 68.2274 163.217 68.5326C160.09 69.2129 147.087 71.3138 144.715 71.5251C143.754 71.6058 141.962 71.6935 140.769 71.7153C139.584 71.7504 138.236 71.8216 137.813 71.8808C135.225 72.2461 131.702 72.1765 131.617 71.7775C131.61 71.7182 131.592 71.661 131.562 71.6092C131.532 71.5574 131.492 71.5121 131.445 71.476C131.397 71.4399 131.343 71.4138 131.285 71.3992C131.227 71.3846 131.167 71.3819 131.108 71.3911C130.893 71.4369 130.885 71.7166 131.101 71.9946C131.352 72.3277 131.202 72.468 130.712 72.3841C128.928 72.2122 127.133 72.1908 125.346 72.3201C123.371 72.513 121.386 72.574 119.403 72.5026C118 72.3744 116.592 72.318 115.184 72.3337C113.631 72.3574 112.079 72.2693 110.54 72.0701C109.719 71.785 108.853 71.6549 107.984 71.6865C106.732 71.6134 106.408 71.3573 106.184 70.3079C106.039 69.6233 105.778 69.1892 105.627 69.3768C105.557 69.6038 105.533 69.8424 105.557 70.0787C105.58 70.315 105.65 70.5443 105.762 70.7535C106.255 71.9622 105.716 72.2312 104.797 71.2369C104.642 71.0569 104.447 70.915 104.229 70.8222C104.01 70.7294 103.773 70.6881 103.536 70.7016C103.069 70.8316 103.126 70.9431 103.769 71.1631C104.759 71.4933 104.118 71.8452 103.055 71.5623C102.504 71.4015 102.428 71.201 102.672 70.5009C102.917 69.8008 102.824 69.7734 102.105 70.374C101.534 70.819 100.846 71.0889 100.124 71.1512C99.4919 71.1926 98.5118 71.2896 97.8929 71.3936C96.9335 71.5353 96.7807 71.3981 96.6925 70.2434C96.6447 69.538 96.4688 69.0857 96.325 69.2553C96.1625 69.5675 96.1193 69.928 96.2033 70.2697C96.2851 70.6541 95.9696 70.9685 95.459 70.9994C94.9913 71.0212 94.3486 71.0659 94.0873 71.1061C93.8121 71.134 93.5775 70.9825 93.5659 70.7693C93.4503 69.697 93.163 69.4034 92.99 70.1762C92.8271 70.8907 92.7088 70.9158 91.9522 70.3192C91.645 70.113 91.2937 69.9815 90.9266 69.9353C90.5594 69.8892 90.1866 69.9296 89.8379 70.0534C88.9093 70.2705 87.9397 70.2368 87.0284 69.9557C86.5318 69.7631 86.0131 69.633 85.4843 69.5686C85.5315 69.7906 82.311 69.6107 81.4559 69.3438C80.986 69.1964 79.4771 68.8692 78.1084 68.6195C76.9935 68.4719 75.9244 68.0825 74.9758 67.4784C74.6297 67.1196 74.3862 67.0324 74.4459 67.3131C74.6032 68.0524 71.088 68.0732 69.3771 67.3249C68.6343 67.0045 67.9836 66.9057 67.8853 67.1311C67.7908 67.3209 67.641 67.1984 67.5755 66.8903C67.5031 66.5499 67.027 66.3732 66.4891 66.4876C65.2734 66.7461 59.976 65.6637 59.6604 65.098C59.5455 64.8751 58.9776 64.7955 58.3644 64.9259C57.7512 65.0563 57.1394 64.982 56.9685 64.7598C56.556 64.4569 56.0609 64.2872 55.5494 64.2734C54.7385 64.183 53.937 64.0228 53.1537 63.7944C52.5841 63.6127 52.0019 63.4731 51.4119 63.3767C50.4041 63.1392 49.4105 62.845 48.4358 62.4957C47.0694 62.0452 44.321 61.1771 42.4093 60.5952C40.49 60.0302 38.8518 59.3595 38.8015 59.1228C38.7543 58.9008 38.4553 58.764 38.1434 58.8304C38.0032 58.8645 37.8552 58.8441 37.7295 58.7733C37.6038 58.7025 37.5097 58.5865 37.4663 58.449C37.4066 58.1683 37.1586 58.1126 36.8812 58.3413C36.3478 58.7942 34.0011 57.5943 34.1413 56.9317C34.1857 56.7178 33.8571 56.6528 33.4038 56.7952C32.5514 57.0695 28.3664 55.5798 27.9772 54.8601C27.8484 54.6248 27.6607 54.588 27.5123 54.7893C27.3792 54.9566 27.224 54.5439 27.1668 53.9049C27.1096 53.2659 27.0257 52.9771 26.9843 53.311C26.8668 54.2008 24.7161 53.8547 24.4934 52.9136C24.3992 52.4705 23.9928 52.3045 23.5146 52.488C22.9633 52.6982 22.6302 52.5064 22.4768 51.8909C22.322 51.3217 22.217 51.251 22.1898 51.7046C22.1647 52.221 21.7035 52.1146 20.5844 51.3662C20.0155 50.9235 19.3702 50.5888 18.6806 50.3788C18.4977 50.4177 17.7986 49.9326 17.1914 49.3513C16.5843 48.77 15.9211 48.4009 15.7849 48.5536C15.6487 48.7062 14.8855 48.1315 14.1222 47.2389C13.363 46.3658 12.5382 45.6601 12.2984 45.6957C11.6207 45.8399 9.5306 44.2604 9.36732 43.4927C9.33933 43.3219 9.24905 43.1675 9.11391 43.0594C8.97877 42.9512 8.80837 42.897 8.63559 42.9072C8.28822 42.9657 8.00778 42.5459 7.91701 41.8548C7.80054 40.937 7.61992 40.7751 7.03751 41.084C6.64 41.2769 6.35291 41.2296 6.417 40.9686C6.48188 40.6921 6.01007 40.1126 5.35729 39.634C4.27596 38.8755 3.55542 37.8235 4.43209 38.2974C4.62174 38.3961 4.73138 38.1714 4.65296 37.8027C4.64231 37.7179 4.61364 37.6363 4.56887 37.5634C4.5241 37.4906 4.46428 37.4281 4.39341 37.3803C4.32254 37.3324 4.24225 37.3003 4.15794 37.286C4.07363 37.2717 3.98724 37.2756 3.90456 37.2974C3.56654 37.4 3.22542 37.1178 3.12495 36.6454C2.93378 36.0218 2.60824 35.4476 2.17123 34.9633C1.5425 34.2853 1.5097 34.184 2.01552 34.4474ZM125.821 7.86924C125.713 7.89212 125.599 8.14845 125.536 8.48593C125.469 8.80678 125.582 9.01701 125.818 8.96668C126.055 8.91634 126.169 8.66002 126.106 8.36466C126.04 8.05464 125.929 7.84636 125.821 7.86924ZM157.795 15.2342C156.991 14.8184 156.969 14.8385 157.415 15.6706C157.625 16.0738 157.949 16.2217 158.112 15.9856C158.309 15.7271 158.2 15.4568 157.795 15.2342ZM158.43 14.0954C158.204 14.1434 158.072 14.2644 158.104 14.4121C158.207 14.6215 158.382 14.7871 158.596 14.8787C158.849 15.01 158.989 14.873 158.923 14.562C158.856 14.251 158.643 14.05 158.428 14.0958L158.43 14.0954ZM160.296 15.6601C160.212 15.7807 160.155 15.9176 160.127 16.0619C160.1 16.2061 160.103 16.3546 160.137 16.4975C160.199 16.7909 160.37 16.959 160.563 16.9178C160.757 16.8767 160.825 16.5066 160.737 16.0929C160.649 15.6792 160.442 15.4748 160.29 15.6614L160.296 15.6601ZM177.025 22.5749C176.328 21.7808 175.984 21.5912 176.082 22.0499C176.305 22.368 176.596 22.6332 176.933 22.8267C177.663 23.3347 177.668 23.3031 177.019 22.5764L177.025 22.5749ZM107.077 70.755C107.34 70.884 107.484 70.7461 107.418 70.4351C107.348 70.1094 107.137 69.9081 106.907 69.957C106.677 70.0058 106.553 70.1407 106.581 70.2737C106.679 70.4896 106.853 70.6616 107.07 70.7565L107.077 70.755ZM74.7299 66.1732C74.8445 66.2437 74.9798 66.2728 75.1133 66.2556C75.2468 66.2383 75.3703 66.1759 75.4632 66.0786C75.7407 65.8499 75.6294 65.7498 75.1713 65.8166C74.7719 65.8709 74.5604 66.0395 74.7241 66.1744L74.7299 66.1732ZM35.5765 57.5853C36.0094 58.4051 36.4087 57.9031 36.3754 56.5353C36.3589 55.6116 36.2689 55.5541 35.7971 56.1952C35.6433 56.3881 35.5421 56.6175 35.5034 56.8612C35.4648 57.1048 35.4899 57.3543 35.5765 57.5853V57.5853ZM17.3373 46.2689C17.7043 45.7738 17.6284 45.6815 16.937 45.8286C16.4744 45.927 16.1267 46.2483 16.1864 46.529C16.3237 47.1601 16.7432 47.0709 17.3373 46.2689ZM12.3394 44.9224C12.4999 45.0426 12.6554 44.7162 12.6714 44.1567C12.713 43.3914 12.6522 43.3266 12.3857 43.924C12.1946 44.347 12.175 44.7836 12.3386 44.9185L12.3394 44.9224ZM1.48174 28.2895C1.61974 28.238 1.74129 28.1502 1.83362 28.0354C1.92595 27.9206 1.98565 27.783 2.00643 27.6372C2.07321 27.453 2.18575 27.2889 2.33345 27.1602C2.48115 27.0315 2.65917 26.9425 2.85074 26.9015C3.34561 26.7963 3.45664 26.5253 3.17921 26.0139C2.67944 25.0386 2.41866 25.1871 1.71094 26.8823C1.35902 27.7125 1.26658 28.3353 1.48174 28.2895ZM14.9726 14.5304C14.9067 14.2204 13.0512 14.5373 11.6191 15.1046C11.3488 15.2081 11.2308 15.682 11.3563 16.195C11.5633 17.0628 11.5848 17.0583 11.7696 16.0765C11.9276 15.2864 12.1162 15.1686 12.6331 15.5371C13.1534 15.9212 13.2576 15.8827 13.1445 15.3506C13.0344 14.8333 13.126 14.7831 13.542 15.1577C14.0991 15.6577 15.1172 15.2101 14.9724 14.5295L14.9726 14.5304ZM10.0679 17.1642C9.83777 16.611 9.58648 16.1697 9.50042 16.188C9.41435 16.2063 9.45048 16.6934 9.57299 17.2694C9.6955 17.8455 9.94367 18.2721 10.1373 18.2309C10.331 18.1897 10.3028 17.7163 10.0679 17.1642V17.1642ZM90.653 70.387C90.7562 70.5965 90.9311 70.762 91.1458 70.8536C91.3986 70.9849 91.5382 70.8479 91.472 70.5369C91.4059 70.2259 91.1944 70.0245 90.9792 70.0703C90.764 70.116 90.6234 70.243 90.6538 70.3858L90.653 70.387Z"/> </svg>';
			} else if ( settings.highlight_type === 'lqd-highlight-custom lqd-highlight-custom-4' ) {
				svg = '<svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-4" aria-hidden="true" preserveAspectRatio="none" width="136" height="16" viewBox="0 0 136 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M36.937 3.319C37.8108 3.27525 38.6865 3.35706 39.5371 3.56198C40.3102 3.74109 40.9877 4.20428 41.4352 4.85965C41.8828 5.51502 42.0676 6.31472 41.9531 7.10001C41.8869 7.83996 41.7186 8.5672 41.4531 9.26102C41.2001 9.91102 41.439 10.016 42.028 9.94901C44.594 9.65601 47.1281 9.19202 49.6721 8.74002C60.1611 6.87302 70.715 5.464 81.29 4.189C93.69 2.689 106.155 1.81201 118.596 0.71701C123.274 0.30501 127.959 0.0339836 132.656 0.00198364C133.231 0.00198364 133.807 0.0539822 134.383 0.0879822C134.76 0.110982 135.136 0.197999 135.154 0.654999C135.171 1.065 134.813 1.17902 134.487 1.26102C132.487 1.76102 130.459 2.09401 128.428 2.42001C121.567 3.52001 114.645 4.10298 107.745 4.87698C100.078 5.73765 92.4117 6.58869 84.7451 7.43002C76.6701 8.33002 68.6071 9.32999 60.5681 10.507C55.4091 11.264 50.2611 12.097 45.1061 12.884C43.7246 13.1186 42.3224 13.2104 40.9221 13.158C40.4991 13.1938 40.074 13.123 39.6855 12.9521C39.297 12.7811 38.9574 12.5154 38.6982 12.1793C38.4389 11.8432 38.2681 11.4475 38.2014 11.0284C38.1346 10.6092 38.1741 10.18 38.3161 9.78C38.4911 8.948 38.644 8.108 38.882 7.293C39.12 6.478 38.7271 6.26602 38.0331 6.21902C36.5228 6.14716 35.0092 6.26201 33.527 6.561C24.1073 8.16425 14.8703 10.6997 5.95209 14.13C4.73009 14.613 3.5521 15.206 2.3581 15.762C1.9581 15.948 1.57112 16.081 1.23212 15.7C1.08506 15.5325 1.00071 15.3192 0.993593 15.0965C0.986479 14.8737 1.05698 14.6555 1.19306 14.479C1.54614 13.9517 2.0137 13.5111 2.56098 13.19C5.02189 11.6317 7.67039 10.3915 10.4431 9.49899C18.455 6.70599 26.7164 4.68875 35.114 3.47501C35.743 3.38201 36.377 3.366 36.937 3.319Z"/> </svg>';
			} else if ( settings.highlight_type === 'lqd-highlight-custom lqd-highlight-custom-5' ) {
				svg = '<svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-5" aria-hidden="true" preserveAspectRatio="none" width="102" height="11" viewBox="0 0 102 11" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M38.449 3.99298C39.7937 3.40715 41.2115 3.00645 42.6639 2.80194C46.4444 2.35238 50.2637 2.332 54.0489 2.74102C62.1929 3.42202 70.2009 5.00203 78.2239 6.47003C84.3759 7.59603 90.505 8.84394 96.647 10.0259C97.7084 10.2479 98.7895 10.3603 99.8738 10.361C100.182 10.3521 100.49 10.3216 100.794 10.27C101.069 10.227 101.32 10.1009 101.361 9.79693C101.407 9.45493 101.061 9.53194 100.894 9.45294C98.5 8.47686 96.0235 7.71756 93.494 7.18402C86.604 5.25302 79.533 4.21597 72.512 2.93097C67.533 2.01997 62.543 1.15894 57.512 0.608945C52.7749 -0.0377262 47.98 -0.149748 43.2178 0.27496C40.4234 0.479879 37.7365 1.43634 35.441 3.04303C35.3299 3.1135 35.2049 3.15894 35.0745 3.17621C34.9441 3.19347 34.8114 3.18213 34.6859 3.143C28.2142 2.15437 21.669 1.72974 15.1238 1.87396C10.9846 1.95518 6.87755 2.61973 2.92389 3.84796C2.08151 4.11969 1.27843 4.50066 0.534978 4.98101C0.215978 5.19001 -0.139946 5.42504 0.0630542 5.88104C0.266054 6.33704 0.69899 6.32296 1.09699 6.19696C3.03281 5.57759 5.00733 5.08686 7.00788 4.72796C12.0709 3.87671 17.2154 3.61326 22.3389 3.94293C25.9819 4.14293 29.615 4.44296 33.233 4.92596C33.825 5.00496 34.212 5.105 34.223 5.862C34.2578 6.25207 34.3855 6.62811 34.5955 6.95868C34.8055 7.28924 35.0917 7.56473 35.43 7.76202C36.7813 8.75095 38.4314 9.24515 40.1038 9.16192C40.4951 9.18625 40.8845 9.09155 41.2208 8.89019C41.5571 8.68884 41.8245 8.39033 41.9879 8.03399C42.1247 7.66786 42.1526 7.26994 42.0679 6.88836C41.9833 6.50679 41.7899 6.1579 41.5111 5.88397C40.9197 5.22115 40.1802 4.70723 39.3528 4.38397C39.1078 4.27197 38.868 4.17198 38.449 3.99298ZM39.5699 6.95099C38.422 6.93626 37.3262 6.46903 36.5208 5.65094C37.636 5.79826 38.6898 6.24786 39.5679 6.95099H39.5699Z"/> </svg>';
			}
			return svg;
		}

		view.addRenderAttribute( 'wrapperAttributes', wrapperAttrs);

		view.addRenderAttribute( 'titleAttributes', titleAttrs);

		let content = settings.advanced_text_enable === 'yes' ? getAdvancedText() : settings.content;

		content = content.replace('/<p>/g', '');
		content = content.replace('/</p>/g', '');

		#>
			<div {{{ view.getRenderAttributeString('wrapperAttributes') }}}>
				<{{{ settings.tag }}} {{{ view.getRenderAttributeString('titleAttributes') }}} >
					<# if( settings.hover_text_outline === 'ld-fh-outline' ) { #>
						<span class="ld-fh-txt-outline">{{{content}}}</span>
					<# } #>
					<# if ( content.includes("[ld_highlight]") && content.includes("[/ld_highlight]") ) {
						content = content.replace('[ld_highlight]', '<mark class="lqd-highlight"><span class="lqd-highlight-txt">');
						content = content.replace('[/ld_highlight]', '</span><span class="lqd-highlight-inner">'+ getSVGHighlight() + '</span></mark>');
						#> {{{content + getTextRotatorWords()}}} <#
					} else { #>
						{{{ content + getTextRotatorWords() }}}
					<# } #>
				</{{{ settings.tag }}}>
			</div>
		<?php

	}

	protected function fancy_title() {

		$settings = $this->get_settings_for_display();
		
		$tag = $settings['tag'];
		
		$classnames = $outline_title = '';
		$classnames_arr = array(
			'ld-fh-element',
			'd-inline-block',
			'pos-rel',
			$settings['enable_txt_rotator'] === 'yes' && $settings['rotator_type'] !== '' ? 'txt-rotator-' . $settings['rotator_type'] : ''
		);

		if ( $tag !== 'p' && $tag !== 'div' && $tag !== 'span' ) {
			array_push($classnames_arr, 'elementor-heading-title');
		}

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$classnames_arr[] = 'elementor-inline-editing';
			$inline_edit_attr = 'data-elementor-setting-key="content" data-elementor-inline-editing-toolbar="basic"';
		} else {
			$inline_edit_attr = '';
		}
		
		if( !empty( $settings['add_gradient'] ) ) {
			$classnames_arr[] = 'ld-gradient-heading';
		}

		if( !empty( $settings['whitespace'] ) ) {
			$classnames_arr[] = $settings['whitespace'];
		}
		if( !empty( $settings['highlight_type'] ) ) {
			$highlight_type = $settings['highlight_type'];
			$highlight_classname = $highlight_type;
			if ( $highlight_type === 'lqd-highlight-underline' ) {
				$highlight_classname = 'lqd-highlight-classic';
			} else if ( $highlight_type === 'lqd-highlight-custom-underline' ) {
				$highlight_classname = 'lqd-highlight-custom lqd-highlight-custom-1';
			} else if ( $highlight_type === 'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt' ) {
				$highlight_classname = 'lqd-highlight-custom lqd-highlight-custom-2';
			}

			$classnames_arr[] = $highlight_classname;
		}
		if( !empty( $settings['highlight_animation'] ) ) {
			$classnames_arr[] = $settings['highlight_animation'];
		}
		if( !empty( $settings['highlight_reset_onhover'] ) && $settings['highlight_reset_onhover'] === 'yes' ) {
			$classnames_arr[] = 'lqd-highlight-reset-onhover';
		}

		if( $settings['vertical_txt'] === 'true' ) {
			$classnames_arr[] = 'text-vertical';
		}

		if ( $settings['enable_split'] ) {
			$classnames_arr[] = $this->get_split_classname();
		}

		$title = $settings['advanced_text_enable'] === 'yes' ? ld_el_get_advanced_text( $this ) : $settings['content'];
		$title = preg_replace('/^<p[^>]*>(.*)<\/p[^>]*>/', '$1', $title);
		$title = do_shortcode( wp_kses_post( $title ) ) . $this->get_title_words();
		$tag_inherit = '';
		if( $settings['use_inheritance'] === 'true' ){
			$classnames_arr[] = $settings['tag_to_inherite'];
		} else {
			$classnames_arr[] = $tag;
		}
		
		if( !empty( $classnames_arr ) ) {
			$classnames = 'class="' . join( ' ', $classnames_arr ) . '"';
		}
		
		if( 'ld-fh-outline' === $settings['hover_text_outline'] ) {
			$outline_title = '<span class="ld-fh-txt-outline">' .  ld_helper()->do_the_content( $title, false ) . '</span>';
		}
		
		// Title
		if( $title ) {
			if ( ! empty( $settings['link']['url'] ) ) {
				$this->add_link_attributes( 'fancy_heading_link', $settings['link'] );
				printf( '<%1$s %3$s %4$s><a %5$s %7$s'. $this->get_split_options() .'>%6$s %2$s</a></%1$s>', !empty( $tag ) ? $tag : 'h2', ld_helper()->do_the_content( $title, false ), $classnames, $this->get_data_opts(), $this->get_render_attribute_string( 'fancy_heading_link' ), $outline_title, $inline_edit_attr);
			}
			else {
				printf( '<%1$s %3$s %4$s %6$s'. $this->get_split_options() .'>%5$s %2$s</%1$s>', !empty( $tag ) ? $tag : 'h2', ld_helper()->do_the_content( $title, false ), $classnames, $this->get_data_opts(), $outline_title, $inline_edit_attr);
			}
			
		}
		
	}
	
	protected function get_text_rotator_options() {

		$settings = $this->get_settings_for_display();
		
		if( $settings['enable_txt_rotator'] !== 'yes' ) {
			return;
		}

		$attrs = array(
			'data-text-rotator' => true,
		);
		$options = array();

		if ( $settings['rotator_type'] !== '' ) $options['animationType'] = $settings['rotator_type'];

		if ( ! empty( $settings['rotator_delay'] ) ) {
			$options['delay'] = (float) $settings['rotator_delay'];
		}

		if ( ! empty( $options ) ) {
			$attrs['data-text-rotator-options'] = wp_json_encode( $options );
		}
		
		return $attrs;
		
	}

	protected function get_data_opts() {

		
		$opts = array();
		$rotator_opts = $this->get_text_rotator_options();
		$highlight_opts = $this->get_highlight_opts();
		
		if( is_array( $rotator_opts ) && ! empty( $rotator_opts ) ) {
			$opts = array_merge( $opts, $rotator_opts );
		}
		if( is_array( $highlight_opts ) && ! empty( $highlight_opts ) ) {
			$opts = array_merge( $opts, $highlight_opts );
		}
		
		return ld_helper()->html_attributes( $opts );
		
	}

	protected function get_highlight_opts() {

		$settings = $this->get_settings_for_display();
		
		if( !has_shortcode( $settings['content'], 'ld_highlight' )  ) {
			return;
		}
		
		$opts = array(
			'data-inview' => true,
			'data-transition-delay' => true,
			'data-delay-options' => wp_json_encode(
				array(
					'elements' => '.lqd-highlight-inner',
					'delayType' => 'transition'
				)
			)
		);
		
		return $opts;
	
	}

	protected function get_split_classname() {

		$settings = $this->get_settings_for_display();

		$classname = '';
		$prefix = 'lqd-split-';
		$split_type = $settings['split_type'];

		if ( ! $settings['enable_split'] ) {
			return $classname;
		};

		if ( $split_type === 'chars, words' ) {
			$classname = $prefix . 'chars';
		} else {
			$classname = $prefix . $split_type;
		}

		return $classname;

	}

	protected function get_title_words() {

		$settings = $this->get_settings_for_display();
		
		if( $settings['enable_txt_rotator'] !== 'yes' ) {
			return;
		}

		if( empty( $settings['items'] ) ) {
			return;
		}

		$words = $settings['items'] ;

		if( empty( $words ) ) {
			return;
		}
		
		$out = $style_word = '';
		
		$out .= ' <span class="txt-rotate-keywords">';
		if ( $settings['rotator_type'] === 'list' ) {
			$out .= ' <span class="txt-rotate-keywords-inner d-block h-100">';
		}
		$i = 1;
		foreach ( $words as $word ) {
			$active = ( $i == 1 ) ? ' active' : '';
			$style_word = !empty( $word['word_color'] ) ? 'style="color:' . esc_attr( $word['word_color'] ) . '"' : '';
			
			$out .= '<span class="txt-rotate-keyword' . $active . '" ' . $style_word . '><span>' . esc_html( $word['word'] ) . '</span></span>';
			$i++;
		}
		if ( $settings['rotator_type'] === 'list' ) {
			$out .= ' </span>';
		}
		$out .= '</span>';

		return $out;
		
	}

	protected function get_split_options() {

		extract( $this->get_settings_for_display() );

		if( !$enable_split ) {
			return;
		}
		
		$opts = $split_opts = array();
		$split_opts['type'] = $split_type;
		$opts[] = 'data-split-text="true"';
		$opts[] = 'data-split-options=\'' . wp_json_encode( $split_opts ) . '\'';

		return join( ' ', $opts );

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Fancy_Heading() );