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
use \Elementor\Controls_Manager_Hidden;
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
class LD_Carousel extends Widget_Base {

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
		return 'ld_carousel';
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
		return __( 'Liquid Carousel', 'hub-elementor-addons' );
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
		return 'eicon-slider-3d lqd-element';
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
		return [ 'carousel', 'slider' ];
	}

	/*
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script( 'script-handle', 'path/to/file.js', [ 'elementor-frontend' ], '1.0.0', true );
	}
	 */

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
			return ['flickity', 'flickity-fade' ];
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
			'general_section',
			array(
				'label' => __( 'Carousel', 'hub-elementor-addons' ),
			)
		);

		$this->add_control(
			'marquee',
			[
				'label' => __( 'Marquee?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'columns_auto_width',
			[
				'label' => __( 'Auto columns width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.5,
					],
				],
				'default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 2,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .carousel-item' => 'width: calc(100% / {{SIZE}}); flex: 0 0 auto;',
				],
				'condition' => [
					'columns_auto_width!' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'carousel_item_spacing',
			[
				'label' => __( 'Spacing (px)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .carousel-item' => 'padding-inline-start: {{SIZE}}{{UNIT}}; padding-inline-end: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .carousel-items' => 'margin-inline-start: -{{SIZE}}{{UNIT}}; margin-inline-end: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'carousel_items_custom_height',
			[
				'label' => __( 'Items custom height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 20,
						'step' => 0.1,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .carousel-item-inner' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'carousel_type',
			[
				'label' => esc_html__( 'Carousel Type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'content',
				'options' => [
					'content' => esc_html__( 'Content', 'hub-elementor-addons' ),
					'gallery'  => esc_html__( 'Image Gallery', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'carousel_gallery',
			[
				'label' => esc_html__( 'Add Images', 'hub-elementor-addons' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
				'condition' => [
					'carousel_type' => 'gallery'
				]
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'content_type',
			[
				'label' => __( 'Content type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tinymce',
				'label_block' => true,
				'options' => [
					'tinymce' => __( 'TinyMCE', 'hub-elementor-addons' ),
					'el_template' => __( 'Elementor Template', 'hub-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'templates',
			[
				'label' => __( 'Templates', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => $this->get_block_posts(),
				'default' => '0',
				'condition' => [
					'content_type' => 'el_template',
				]
			]
		);

		$repeater->add_control(
			'list_content', [
				'label' => __( 'Content', 'hub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'List Content' , 'hub-elementor-addons' ),
				'show_label' => false,
				'condition'=> [
					'content_type' => 'tinymce'
				],
			]
		);

		$repeater->add_responsive_control(
			'item_width',
			[
				'label' => __( 'Item width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}}; flex: 0 0 auto;',
				],
				'render_type' => 'template',
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'list_content_typography',
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .carousel-item-content',
				'condition'=> [
					'content_type' => 'tinymce'
				],
			]
		);

		$repeater->add_responsive_control(
			'list_content_alignment',
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
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .carousel-item-content' => 'text-align: {{VALUE}}',
				],
				'toggle' => true,
				'condition'=> [
					'content_type' => 'tinymce'
				],
			]
		);

		$repeater->add_control(
			'list_content_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .carousel-item-content' => 'color: {{VALUE}};',
				],
				'condition'=> [
					'content_type' => 'tinymce'
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Carousel slides', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'Slide #1', 'hub-elementor-addons' ),
						'list_content' => __( '<p>Item content. Click the edit button to change this text.</p>', 'hub-elementor-addons' ),
					],
					[
						'list_title' => __( 'Slide #2', 'hub-elementor-addons' ),
						'list_content' => __( '<p>Item content. Click the edit button to change this text.</p>', 'hub-elementor-addons' ),
					],
					[
						'list_title' => __( 'Slide #3', 'hub-elementor-addons' ),
						'list_content' => __( '<p>Item content. Click the edit button to change this text.</p>', 'hub-elementor-addons' ),
					],
				],
				'condition' => [
					'carousel_type' => 'content'
				],
			]
		);

		$this->add_responsive_control(
			'carousel_gallery_alignment',
			[
				'label' => __( 'Images alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'hub-elementor-addons' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'hub-elementor-addons' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'hub-elementor-addons' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .carousel-item-content' => 'justify-content: {{VALUE}}',
				],
				'toggle' => true,
				'condition' => [
					'carousel_type' => 'gallery'
				],
			]
		);

		$this->add_control(
			'carousel_controller_id',
			[
				'label' => __( 'Set carousel ID', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 2,
				'placeholder' => __( 'Do not use #. example: image-carousel', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'carousel_height',
			[
				'label' => esc_html__( 'Carousel Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HIDDEN
			]
		);

		$this->end_controls_section();

		// Section Carousel Options
		$this->start_controls_section(
		'carousel_options_section',
			array(
				'label' => __( 'Carousel Options', 'hub-elementor-addons' ),
			)
		);

		$this->add_control(
			'cellalign',
			[
				'label' => __( 'Cell align', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Left', 'hub-elementor-addons' ),
					'center' => __( 'Center', 'hub-elementor-addons' ),
					'right' => __( 'Right', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'fullwidthside',
			[
				'label' => __( 'Stretch carousel', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);


		$this->add_control(
			'fadesides',
			[
				'label' => __( 'Fade sides', 'hub-elementor-addons' ),
				'description' => __( 'Fade the carousel right and left sides of the viewport.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'lqd-fade-sides' => __( 'Enable', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'groupcells',
			[
				'label' => __( 'Group cells', 'hub-elementor-addons' ),
				'description' => __( 'Enable this option if you want the navigation being mapped to grouped cells, not individual cells.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'wraparound',
			[
				'label' => __( 'Carousel loop', 'hub-elementor-addons' ),
				'description' => __( 'Loop for infinite scrolling.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'adaptiveheight',
			[
				'label' => __( 'Adaptive height', 'hub-elementor-addons' ),
				'description' => __( 'Height of the carousel will change based on active slide', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'equalheightcells',
			[
				'label' => __( 'Equal height cells', 'hub-elementor-addons' ),
				'description' => __( 'Height of all carousel cells will be the same.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
			]
		);
		$this->add_control(
			'middlealigncontent',
			[
				'label' => __( 'Middle align content', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'equalheightcells' => 'yes'
				],
			]
		);

		$this->add_control(
			'fadeeffect',
			[
				'label' => __( 'Fade effect', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'draggable',
			[
				'label' => __( 'Draggable', 'hub-elementor-addons' ),
				'description' => __( 'Enable/Disable draggableity of the carousel. This option does not work in frontend editor.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'no' => __( 'Disable', 'hub-elementor-addons' ),
					'' => __( 'Enable', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'custom_cursor',
			[
				'label' => __( 'Custom cursor on hover', 'hub-elementor-addons' ),
				'description' => __( 'Enable/Disable custom cursor on hover. Only working when custom cursor is enabled from theme options', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'marquee_speed',
			[
				'label' => __( 'Marquee speed', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'ex. 2', 'hub-elementor-addons' ),
				'condition' => [
					'marquee' => 'yes'
				],
			]
		);

		$this->add_control(
			'marquee_pauseautoplayonhover',
			[
				'label' => __( 'Pause autoplay on hover', 'hub-elementor-addons' ),
				'description' => __( 'Pause the autoplay each time user hovers over the carousel.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee' => 'yes',
				]
			]
		);

		$this->add_control(
			'freescroll',
			[
				'label' => __( 'Free scroll', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes',
				]
			]
		);


		$this->add_control(
			'autoplaytime',
			[
				'label' => __( 'Autoplay delay', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'delay in milliseconds', 'hub-elementor-addons' ),
				'condition' => [
					'autoplay' => 'yes',
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'pauseautoplayonhover',
			[
				'label' => __( 'Pause autoplay on hover', 'hub-elementor-addons' ),
				'description' => __( 'Pause the autoplay each time user hovers over the carousel.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'autoplay' => 'yes',
					'marquee!' => 'yes'
				]
			]
		);

		$this->add_control(
			'randomveroffset',
			[
				'label' => __( 'Random vertical position', 'hub-elementor-addons' ),
				'description' => __( 'Randomly position carousel cells.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'reverse',
			[
				'label' => __( 'Reverse', 'hub-elementor-addons' ),
				'description' => __( 'Reverse direction.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'controllingcarousels',
			[
				'label' => __( 'Controlling carousels', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 3,
				'description' => __( 'Add IDs or classnames of the other carousels on this page for ex. #carousel-1, carousel-2 or .carousel-1, .carousel-2 (Note: divide by comma)', 'hub-elementor-addons' ),
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);
		$this->end_controls_section();

		// Navigation Section
		$this->start_controls_section(
		'navigation_section',
			array(
				'label' => __( 'Navigation', 'hub-elementor-addons' ),
			)
		);

		$this->add_control(
			'prevnextbuttons',
			[
				'label' => __( 'Navigation arrows', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'navarrow',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'hub-elementor-addons' ),
					'1' => __( 'Default', 'hub-elementor-addons' ),
					'2' => __( 'Style 2', 'hub-elementor-addons' ),
					'3' => __( 'Style 3', 'hub-elementor-addons' ),
					'4' => __( 'Style 4', 'hub-elementor-addons' ),
					'5' => __( 'Style 5', 'hub-elementor-addons' ),
					'6' => __( 'Style 6', 'hub-elementor-addons' ),
					'custom' => __( 'Custom', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'navappend',
			[
				'label' => __( 'Append navigation arrows to', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'self',
				'options' => [
					'self' => __( 'Carousel itself', 'hub-elementor-addons' ),
					'parent_row' => __( 'Parent Row', 'hub-elementor-addons' ),
					'custom_id' => __( 'Other Elements', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'navappend_id',
			[
				'label' => __( 'ID to Append navigation arrows', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Input the id of element to append the navigaion, for ex. #heading-id', 'hub-elementor-addons' ),
				'condition' => array(
					'navappend' => 'custom_id'
				)
			]
		);

		$this->add_control(
			'prev',
			[
				'label' => __( 'Previous button', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => __( 'Add here markup for previous button for ex <i class=\"fa fa-angle-left\"></i>', 'hub-elementor-addons' ),
				'condition' => array(
					'navarrow' => 'custom'
				)
			]
		);

		$this->add_control(
			'next',
			[
				'label' => __( 'Next button', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => __( 'Add here markup for previous button for ex <i class=\"fa fa-angle-left\"></i>', 'hub-elementor-addons' ),
				'condition' => array(
					'navarrow' => 'custom'
				)
			]
		);
		$this->add_control(
			'navfloated',
			[
				'label' => __( 'Floated', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Disable', 'hub-elementor-addons' ),
					'carousel-nav-floated' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'navvalign',
			[
				'label' => __( 'Vertical alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'carousel-nav-top' => __( 'Top', 'hub-elementor-addons' ),
					'carousel-nav-middle' => __( 'Middle', 'hub-elementor-addons' ),
					'carousel-nav-bottom' => __( 'Bottom', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'navdirection',
			[
				'label' => __( 'Direction', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'carousel-nav-vertical' => __( 'Vertical', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'navslidernumberstoarrows',
			[
				'label' => __( 'Numbers to arrows', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'No', 'hub-elementor-addons' ),
					'yes' => __( 'Yes', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'navline',
			[
				'label' => __( 'Separator', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'Disable', 'hub-elementor-addons' ),
					'carousel-nav-dot-between' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes',
					'navslidernumberstoarrows' => 'no'
				),
			]
		);

		$this->add_control(
			'navhalign',
			[
				'label' => __( 'Horizontal alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'carousel-nav-left',
				'options' => [
					'carousel-nav-left' => __( 'Left', 'hub-elementor-addons' ),
					'carousel-nav-center' => __( 'Center', 'hub-elementor-addons' ),
					'carousel-nav-right' => __( 'Right', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'carousel_nav_options_dep_warn',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( 'All below options are deprecated. Please use options in <b>Style</b> tab, <b>Navigation</b> section.', 'hub-elementor-addons' ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'navsize',
			[
				'label' => __( 'Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'carousel-nav-size-default' => __( 'Default', 'hub-elementor-addons' ),
					'carousel-nav-sm' => __( 'Small', 'hub-elementor-addons' ),
					'carousel-nav-md' => __( 'Medium', 'hub-elementor-addons' ),
					'carousel-nav-lg' => __( 'Large', 'hub-elementor-addons' ),
					'carousel-nav-xl' => __( 'Extra Large', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'navfill',
			[
				'label' => __( 'Fill color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'hub-elementor-addons' ),
					'carousel-nav-bordered' => __( 'Bordered', 'hub-elementor-addons' ),
					'carousel-nav-solid' => __( 'Solid', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'navshape',
			[
				'label' => __( 'Shape style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'hub-elementor-addons' ),
					'carousel-nav-square' => __( 'Square', 'hub-elementor-addons' ),
					'carousel-nav-circle' => __( 'Circle', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'navshadow',
			[
				'label' => __( 'Shadow styles', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'hub-elementor-addons' ),
					'carousel-nav-shadowed' => __( 'Shadow', 'hub-elementor-addons' ),
					'carousel-nav-shadowed-onhover' => __( 'Shadow on hover', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'navoffset',
			[
				'label' => __( 'Navigation offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 2,
				'placeholder' => __( 'ex. right: 22%; top: 25px;', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}}.carousel-nav' => '{{VALUE}}',
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'prevoffset',
			[
				'label' => __( 'Previous button offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'ex. 10px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button.previous' => 'left: {{VALUE}}',
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'nextoffset',
			[
				'label' => __( 'Next button offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'ex. 10px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button.next' => 'right: {{VALUE}}',
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'shapesize',
			[
				'label' => __( 'Shape size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'ex. 22px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button' => 'width: {{VALUE}}!important; height: {{VALUE}}!important;',
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'shapeheight',
			[
				'label' => __( 'Shape height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'ex. 22px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button' => 'height: {{VALUE}}!important;',
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);

		$this->add_control(
			'shapewidth',
			[
				'label' => __( 'Shape width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'ex. 22px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button' => 'width: {{VALUE}}!important;',
				],
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			]
		);
		$this->end_controls_section();

		// Pagination Dots
		$this->start_controls_section(
		'pagination_dots_section',
			array(
				'label' => __( 'Pagination dots', 'hub-elementor-addons' ),
			)
		);

		$this->add_control(
			'pagenationdots',
			[
				'label' => __( 'Pagination dots', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'Disable', 'hub-elementor-addons' ),
					'yes' => __( 'Enable', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'dots_type',
			[
				'label' => __( 'Pagination type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'dots',
				'options' => [
					'dots' => __( 'Dots', 'hub-elementor-addons' ),
					'numbers' => __( 'Numbers', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'pagenationdots' => 'yes'
				)
			]
		);

		$this->add_control(
			'number_style',
			[
				'label' => __( 'Number style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'line',
				'options' => [
					'circle' => __( 'Circle', 'hub-elementor-addons' ),
					'line' => __( 'Line', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'pagenationdots' => 'yes',
					'dots_type' => 'numbers'
				)
			]
		);

		$this->add_control(
			'dotsappend',
			[
				'label' => __( 'Append dots to', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'self',
				'options' => [
					'self' => __( 'Carousel itself', 'hub-elementor-addons' ),
					'parent_row' => __( 'Parent Row', 'hub-elementor-addons' ),
					'custom_id' => __( 'Other Elements', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'pagenationdots' => 'yes'
				)
			]
		);

		$this->add_control(
			'dotsappend_id',
			[
				'label' => __( 'Element ID to append dots', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex. #heading-id', 'hub-elementor-addons' ),
				'condition' => array(
					'pagenationdots' => 'yes',
					'dotsappend' => 'custom_id',
				)
			]
		);

		$this->add_control(
			'align_dots',
			[
				'label' => __( 'Alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'carousel-dots-left' => __( 'Left', 'hub-elementor-addons' ),
					'carousel-dots-right' => __( 'Right', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'pagenationdots' => 'yes'
				)
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => __( 'Position', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'carousel-dots-inside' => __( 'Inside', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'pagenationdots' => 'yes'
				)
			]
		);

		$this->add_control(
			'dots_orientation',
			[
				'label' => __( 'Orientation', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'carousel-dots-vertical' => __( 'Vertical', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'pagenationdots' => 'yes'
				)
			]
		);

		$this->add_control(
			'dots_vertical_align',
			[
				'label' => __( 'Vertical alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Bottom', 'hub-elementor-addons' ),
					'carousel-dots-middle' => __( 'Middle', 'hub-elementor-addons' ),
					'carousel-dots-top' => __( 'Top', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'pagenationdots' => 'yes',
					'dots_orientation' => 'carousel-dots-vertical'
				)
			]
		);

		$this->add_control(
			'dots_style',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'carousel-dots-style1',
				'options' => [
					'carousel-dots-style1' => __( 'Style 1', 'hub-elementor-addons' ),
					'carousel-dots-style2' => __( 'Style 2', 'hub-elementor-addons' ),
					'carousel-dots-style3' => __( 'Style 3', 'hub-elementor-addons' ),
					'carousel-dots-style4' => __( 'Style 4', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'pagenationdots' => 'yes',
					'dots_type' => 'dots'
				)
			]
		);

		$this->add_control(
			'size_dots',
			[
				'label' => __( 'Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'carousel-dots-sm' => __( 'Small', 'hub-elementor-addons' ),
					'carousel-dots-md' => __( 'Medium', 'hub-elementor-addons' ),
					'carousel-dots-lg' => __( 'Large', 'hub-elementor-addons' ),
					'carousel-dots-custom' => __( 'Custom', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'pagenationdots' => 'yes',
					'dots_type' => 'dots'
				)
			]
		);

		$this->add_control(
			'dotscustomsize',
			[
				'label' => __( 'Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '25px',
				'placeholder' => __( 'ex. 25px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .flickity-page-dots .dot' => 'width: {{VALUE}}',
				],
				'condition' => [
					'pagenationdots' => 'yes',
					'size_dots' => 'carousel-dots-custom',
				],
			]
		);

		$this->add_control(
			'dotscustomsize_height',
			[
				'label' => __( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '25px',
				'placeholder' => __( 'ex. 25px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .flickity-page-dots .dot' => 'height: {{VALUE}}',
				],
				'condition' => [
					'pagenationdots' => 'yes',
					'size_dots' => 'carousel-dots-custom',
				],
			]
		);

		$this->add_control(
			'dots_top_offset',
			[
				'label' => __( 'Top offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'auto', 'hub-elementor-addons' ),
				'placeholder' => __( 'auto', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}}.carousel-dots' => 'top: {{VALUE}}',
					'{{WRAPPER}}.carousel-dots:not(.carousel-dots-inside)' => 'position: relative;',
				],
				'condition' => array(
					'pagenationdots' => 'yes'
				)
			]
		);

		$this->add_control(
			'dots_right_offset',
			[
				'label' => __( 'Right offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'auto', 'hub-elementor-addons' ),
				'placeholder' => __( 'auto', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}}.carousel-dots' => 'right: {{VALUE}}',
					'{{WRAPPER}}.carousel-dots:not(.carousel-dots-inside)' => 'position: relative;',
				],
				'condition' => array(
					'pagenationdots' => 'yes'
				)
			]
		);

		$this->add_control(
			'dots_bottom_offset',
			[
				'label' => __( 'Bottom offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '-25px',
				'placeholder' => '-25px',
				'selectors' => [
					'{{WRAPPER}}.carousel-dots' => 'bottom: {{VALUE}}',
					'{{WRAPPER}}.carousel-dots:not(.carousel-dots-inside)' => 'position: relative;',
				],
				'condition' => array(
					'pagenationdots' => 'yes'
				)
			]
		);

		$this->add_control(
			'dots_left_offset',
			[
				'label' => __( 'Left offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'auto', 'hub-elementor-addons' ),
				'placeholder' => __( 'auto', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}}.carousel-dots' => 'left: {{VALUE}}',
					'{{WRAPPER}}.carousel-dots:not(.carousel-dots-inside)' => 'position: relative;',
				],
				'condition' => array(
					'pagenationdots' => 'yes'
				)
			]
		);

		$this->end_controls_section();


		// Section Mobile Pagination Dots
		$this->start_controls_section(
		'mobile_pagination_dots_section',
			array(
				'label' => __( 'Mobile Pagination Dots', 'hub-elementor-addons' ),
				'condition' => [
					'marquee!' => 'yes'
				],
			)
		);

		$this->add_control(
			'mobile_dots_position',
			[
				'label' => __( 'Position', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'carousel-dots-mobile-outside',
				'options' => [
					'carousel-dots-mobile-outside' => __( 'Outside', 'hub-elementor-addons' ),
					'carousel-dots-mobile-inside' => __( 'Inside', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'mobile_align_dots',
			[
				'label' => __( 'Alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'carousel-dots-mobile-center',
				'options' => [
					'carousel-dots-mobile-center' => __( 'Center', 'hub-elementor-addons' ),
					'carousel-dots-mobile-left' => __( 'Left', 'hub-elementor-addons' ),
					'carousel-dots-mobile-right' => __( 'Right', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'mobile_dots_bottom_offset',
			[
				'label' => __( 'Bottom offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '15px',
				'placeholder' => __( 'ex. 15px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .carousel-dots-mobile.carousel-dots-mobile-inside' => 'bottom: {{VALUE}}',
				],
				'condition' => [
					'mobile_dots_position' => 'carousel-dots-mobile-inside',
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'mobile_dots_bottom_offset_outside',
			[
				'label' => __( 'Bottom offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '1.5em',
				'placeholder' => __( 'ex. 15px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .carousel-dots-mobile.carousel-dots-mobile-outside .flickity-page-dots' => 'margin-top: {{VALUE}}',
				],
				'condition' => [
					'mobile_dots_position' => 'carousel-dots-mobile-outside',
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'mobile_dots_left_offset',
			[
				'label' => __( 'Left offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '15px',
				'placeholder' => __( 'ex. 15px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .carousel-dots-mobile.carousel-dots-mobile-inside' => 'left: {{VALUE}}',
				],
				'condition' => [
					'mobile_dots_position' => 'carousel-dots-mobile-inside',
					'mobile_align_dots' => 'carousel-dots-mobile-left',
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'mobile_dots_right_offset',
			[
				'label' => __( 'Right offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '15px',
				'placeholder' => __( 'ex. 15px', 'hub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .carousel-dots-mobile.carousel-dots-mobile-inside' => 'right: {{VALUE}}',
				],
				'condition' => [
					'mobile_dots_position' => 'carousel-dots-mobile-inside',
					'mobile_align_dots' => 'carousel-dots-mobile-right',
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'mobile_dots_bg_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-dots-mobile .flickity-page-dots .dot' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);

		$this->add_control(
			'mobile_dots_bg_hcolor',
			[
				'label' => __( 'Hover color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-dots-mobile .flickity-page-dots .dot.is-selected' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'marquee!' => 'yes'
				],
			]
		);
		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
		'styles_section',
			array(
				'label' => __( 'Navigation', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			)
		);

		$this->add_responsive_control(
			'nav_offset',
			[
				'label' => __( 'Navigation holder offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}.carousel-nav' => 'top: {{TOP}}{{UNIT}} !important; right: {{RIGHT}}{{UNIT}} !important; bottom: {{BOTTOM}}{{UNIT}} !important; left: {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'nav_width_slider',
			[
				'label' => __( 'Buttons width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_height_slider',
			[
				'label' => __( 'Buttons height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_icon_size_slider',
			[
				'label' => __( 'Icon size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.carousel-nav .flickity-button svg' => 'width: 1em;',
				],
			]
		);

		$this->add_responsive_control(
			'nav_prev_offset',
			[
				'label' => __( 'Previous button offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'allowed_dimensions' => ['top', 'left'],
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button.previous' => 'top: {{TOP}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_next_offset',
			[
				'label' => __( 'Next button offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'allowed_dimensions' => ['top', 'right'],
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button.next' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'carousel_navigation_tab'
		);

		// Nav normal state
		$this->start_controls_tab(
			'carousel_navigation_normal_tab',
			[
				'label' => __( 'Normal', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'nav_arrow_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button svg' => 'stroke: {{VALUE}}',
					'{{WRAPPER}}.carousel-nav .flickity-button svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}}.carousel-nav .flickity-button' => 'color: {{VALUE}}',
					'{{WRAPPER}}.carousel-nav .flickity-button.previous:after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'nav_arrow_numbers',
			[
				'label' => __( 'Numbers color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .lqd-carousel-slides' => 'color: {{VALUE}}',
				],
				'condition' => array(
					'navslidernumberstoarrows' => 'yes'
				)
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'nav_background_color',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}.carousel-nav .flickity-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'navigation_border',
				'label' => __( 'Border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}}.carousel-nav .flickity-button',
			]
		);

		$this->add_responsive_control(
			'nav_border_radius',
			[
				'label' => __( 'Border radius', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'label' => __( 'Box shadow', 'hub-elementor-addons' ),
				'name' => 'navigation_box_shadow',
				'selector' => '{{WRAPPER}}.carousel-nav .flickity-button',
			]
		);

		$this->add_control(
			'carousel_nav_styles_dep_warn',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( 'All below options are deprecated.', 'hub-elementor-addons' ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'nav_border_color',
			[
				'label' => __( 'Border color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button' => 'border-color: {{VALUE}}',
					'{{WRAPPER}}.carousel-nav .flickity-button.previous:after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'nav_bg_color',
			[
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Nav hover state
		$this->start_controls_tab(
			'carousel_navigation_hover_tab',
			[
				'label' => __( 'Hover', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'nav_arrow_color_hover',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button:hover svg' => 'stroke: {{VALUE}}',
					'{{WRAPPER}}.carousel-nav .flickity-button:hover svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}}.carousel-nav .flickity-button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'nav_hover_background_color',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}.carousel-nav .flickity-button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'navigation_hover_border',
				'label' => __( 'Border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}}.carousel-nav .flickity-button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'navigation_hover_box_shadow',
				'label' => __( 'Box shadow', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}}.carousel-nav .flickity-button:hover',
			]
		);

		$this->add_control(
			'carousel_nav_hstyles_dep_warn',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( 'All below options are deprecated.', 'hub-elementor-addons' ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'nav_border_hcolor',
			[
				'label' => __( 'Border color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'nav_bg_hcolor',
			[
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'dots_styling',
			[
				'label' => __( 'Paginations dots style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'pagenationdots' => 'yes',
				)
			]
		);

		$this->add_control(
			'dots_bg_color',
			[
				'label' => __( 'Dots color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .flickity-page-dots .dot' => 'color: {{VALUE}}',
					'{{WRAPPER}} .flickity-page-dots .dot' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .lqd-carousel-slides-numbers' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-carousel-slides-numbers svg' => 'stroke: {{VALUE}}',
					'{{WRAPPER}} .lqd-carousel-numbers-line path' => 'opacity: 1',
				],
				'condition' => array(
					'pagenationdots' => 'yes',
				)
			]
		);

		$this->add_control(
			'dots_bg_hcolor',
			[
				'label' => __( 'Dots active/hover color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .flickity-page-dots .dot.is-selected,{{WRAPPER}} .flickity-page-dots .dot:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .flickity-page-dots .dot.is-selected,{{WRAPPER}} .flickity-page-dots .dot:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .lqd-carousel-slides-numbers:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-carousel-slides-numbers:hover svg' => 'stroke: {{VALUE}}',
					'{{WRAPPER}} .lqd-carousel-numbers-line path:last-of-type' => 'stroke: {{VALUE}}',
					'{{WRAPPER}} .lqd-carousel-slides-current' => 'color: {{VALUE}}',
				],
				'condition' => array(
					'pagenationdots' => 'yes',
				)
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shadow',
			[
				'label' => __( 'Shadow', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'hub-elementor-addons' ),
					'carousel-shadow-active' => __( 'Active Item', 'hub-elementor-addons' ),
					'carousel-shadow-all' => __( 'All Items', 'hub-elementor-addons' ),
				],
				'condition' => [
					'marquee!' => 'yes'
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'carousel_item_bg_color',
			[
				'label' => __( 'Items background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-item-inner' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'carousel_item_box_shadow',
				'label' => __( 'Items box shadow', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .carousel-item-inner',
			]
		);

		$this->add_control(
			'carousel_item_overflow',
			[
				'label' => __( 'Items overflow', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'hidden' => __( 'Hidden', 'hub-elementor-addons' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .carousel-item-inner' => 'overflow: {{VALUE}}'
				],
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'carousel_item_border',
				'label' => __( 'Items border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .carousel-item-inner',
			]
		);

		$this->add_responsive_control(
			'carousel_item_border_radius',
			[
				'label' => __( 'Items border radius', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .carousel-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'carousel_item_inner_margin',
			[
				'label' => __( 'Items margin', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .carousel-item-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'carousel_item_inner_padding',
			[
				'label' => __( 'Items padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .carousel-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function get_block_posts() {
		$posts = get_posts( array(
			'post_type' => 'elementor_library',
			'posts_per_page' => -1,
			'meta_query'  => array(
                array(
                    'key' => '_elementor_template_type',
                    'value' => 'kit',
                    'compare' => '!=',
                ),
            ),
		) );

		$options = [ '0' => 'Select Template' ];

		foreach ( $posts as $post ) {
		  $options[ $post->ID ] = $post->post_title;
		}

		return $options;
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

		$wrapper_classes = array(
			'carousel-container',
			'pos-rel',
			$settings['navhalign'],
			$settings['navsize'],
			$settings['navfill'] !== '' ? 'carousel-nav-shaped' : '',
			$settings['navfill'],
			$settings['navshape'],
			$settings['navshadow'],
			$settings['navhalign'],
			$settings['navfloated'],
			$settings['navvalign'],
			$settings['navvalign'],
			$settings['navline'],
			$settings['align_dots'],
			$settings['dots_position'],
			$settings['dots_orientation'],
			$settings['dots_vertical_align'],
			$settings['dots_style'],
			$settings['size_dots'],
			$settings['mobile_dots_position'],
			$settings['mobile_align_dots'],
			$settings['shadow'],
			$settings['custom_cursor'],
		);

		$carousel_items_classes = array(
			$settings['fadesides'],
		);

		$origin = is_rtl() || $settings['reverse'] === 'yes'  ? 'right' : 'left';
		$viewport_overflow = $settings['fullwidthside'] !== 'yes' ? 'overflow-hidden' : '';
		$align_items_center = $settings['middlealigncontent'] === 'yes' && $settings['equalheightcells'] === 'yes' && $settings['randomveroffset'] !== 'yes';
		$carousel_item_classname = array(
			'carousel-item',
			'd-flex',
			'flex-column',
			'justify-content-center',
			$align_items_center ? 'align-items-center' : ''
		);
		$slider_element_classnames = array(
			'flickity-slider',
			'd-flex',
			'w-100',
			'h-100',
			'pos-rel',
			! $align_items_center ? 'align-items-start' : ''
		);
		$scroll_badge_container_classnames = array(
			'lqd-scroll-badge-container',
			$settings['mobile_align_dots'] === 'carousel-dots-mobile-center' ? 'justify-content-center' : '',
			$settings['mobile_align_dots'] === 'carousel-dots-mobile-right' ? 'justify-content-end' : '',
		);

		?>

		<div class="<?php echo ld_helper()->sanitize_html_classes( $wrapper_classes ); ?>" id="<?php echo esc_attr( $settings['carousel_controller_id'] ); ?>" >

			<div class="carousel-items pos-rel <?php echo implode(' ', $carousel_items_classes); ?>" <?php self::get_options(); ?>>

				<?php if ( $settings['fullwidthside'] === 'yes' ): ?>
				<div class="flickity-viewport-wrap">
				<?php endif; ?>
				<div class="flickity-viewport pos-rel w-100 <?php echo $viewport_overflow; ?>">
					<div class="<?php echo ld_helper()->sanitize_html_classes( $slider_element_classnames ); ?>" style="<?php echo $origin ?>: 0; transform: translateX(0%);">
						<?php
						if ( $settings['carousel_type'] === 'content' ){
                            foreach (  $settings['list'] as $item ) {
                                $item_classnames = $carousel_item_classname;

								if ( $item['content_type'] === 'el_template' ) {
									array_push($item_classnames, 'has-one-child');
								}

								if ( ! empty($item['item_width']['size'] ) ) {
									array_push($item_classnames, 'width-is-set');
								}

								array_push($item_classnames, 'elementor-repeater-item-'. $item['_id'] . '');
						?>
							<div class="<?php echo ld_helper()->sanitize_html_classes( $item_classnames ); ?>">
								<div class="carousel-item-inner pos-rel w-100">
									<div class="carousel-item-content pos-rel w-100">

										<?php
										if ($item['content_type'] === 'tinymce'){
											echo $item['list_content'];
										}else{
											echo \Elementor\Plugin::instance()->frontend->get_builder_content( $item['templates'], true );
										}
										?>
									</div>
								</div>
							</div>
						<?php }
						} else {
							foreach (  $settings['carousel_gallery'] as $item ) {
                                $item_classnames = $carousel_item_classname;

								if ( isset( $item['id'] ) ){
								?>
									<div class="<?php echo ld_helper()->sanitize_html_classes( $item_classnames ); ?>">
										<div class="carousel-item-inner pos-rel w-100">
											<div class="carousel-item-content pos-rel w-100">
												<?php echo wp_get_attachment_image( $item['id'], 'full' ); ?>
											</div>
										</div>
									</div>
								<?php
								}
							 }
						} ?>
					</div>
				</div>
			</div>
			<?php if ( $settings['fullwidthside'] === 'yes' ): ?>
			</div>
			<?php endif; ?>

			<?php if ( liquid_helper()->get_theme_option( 'disable_carousel_on_mobile' ) === 'on' && $settings['marquee'] !== 'yes' ) : ?>
				<div class="<?php echo ld_helper()->sanitize_html_classes( $scroll_badge_container_classnames ); ?>" style="margin-top: <?php echo $settings['mobile_dots_bottom_offset_outside'] ?>">
					<div class="lqd-scroll-badge">
						<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="height: 1em; vertical-align: middle; margin-inline-end: 0.35em;"><path fill="fillColor" d="M3.625 16l7.938 7.938c.562.562.562 1.562 0 2.125-.313.312-.688.437-1.063.437s-.75-.125-1.063-.438L.376 17c-.563-.563-.5-1.5.063-2.063l9-9c.562-.562 1.562-.562 2.124 0s.563 1.563 0 2.125z"></path></svg>
						<span class="lqd-scroll-badge-txt"><?php echo __('Scroll', 'hub-elementor-addons') ?></span>
						<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="height: 1em; vertical-align: middle; margin-inline-start: 0.35em;"><path fill="fillColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z"></path></svg>
					</div>
				</div>
			<?php endif; ?>

		</div>
		<?php

	}

	protected function get_options() {

		$opts = array();
		$raw = $this->get_settings_for_display();
		$ids = array(
			'cellalign'            => 'cellAlign',
			'groupcells'           => 'groupCells',
			'pagenationdots'       => 'pageDots',
			'number_style'         => 'numbersStyle',
			'marquee'              => 'marquee',
			'autoplay'             => 'autoPlay',
			'autoplaytime'         => 'autoPlay',
			'pauseautoplayonhover' => 'pauseAutoPlayOnHover',
			'marquee_pauseautoplayonhover' => 'pauseAutoPlayOnHover',
			'draggable'            => 'draggable',
			'freescroll'           => 'freeScroll',
			'fadeeffect'           => 'fade',
			'wraparound'           => 'wrapAround',
			'adaptiveheight'       => 'adaptiveHeight',
			'equalheightcells'     => 'equalHeightCells',
			'middlealigncontent'   => 'middleAlignContent',
			'navappend'            => 'buttonsAppendTo',
			'navappend_id'         => 'buttonsAppendTo',
			'columns_auto_width'   => 'columnsAutoWidth',
			'percentPosition'   => 'percentPosition',

			'dots_type' => 'dotsIndicator',

			'dotsappend'           => 'dotsAppendTo',
			'dotsappend_id'        => 'dotsAppendTo',

			'prevnextbuttons'      => 'prevNextButtons',
			'navarrow'             => 'navArrow',
			'navslidernumberstoarrows' => 'addSlideNumbersToArrows',
			'fullwidthside'        => 'fullwidthSide',
			'navoffset'            => 'navOffsets',
			'randomveroffset'      => 'randomVerOffset',
			'controllingcarousels' => 'controllingCarousels',

			'reverse'			   => 'rightToLeft',
			'marquee_speed'        => 'marqueeTickerSpeed',

		);

		unset(
			$raw['__globals__'],
			$raw['style'],
			$raw['columns'],
			$raw['paddings'],
			$raw['title'],
			$raw['content'],
			$raw['inactiv_opacity'],
			$raw['shadow'],
			$raw['fadesides'],
			$raw['custom_cursor'],

			$raw['list'],
			$raw['columns_tablet'],
			$raw['columns_tablet_extra'],
			$raw['columns_mobile'],
			$raw['columns_mobile_extra'],
			$raw['columns_widescreen'],
			$raw['columns_laptop'],
			$raw['_margin'],
			$raw['_margin_tablet'],
			$raw['_margin_mobile'],
			$raw['_margin_tablet_extra'],
			$raw['_margin_mobile_extra'],
			$raw['_margin_widescreen'],
			$raw['_margin_laptop'],
			$raw['_padding'],
			$raw['_padding_tablet'],
			$raw['_padding_mobile'],
			$raw['_padding_tablet_extra'],
			$raw['_padding_mobile_extra'],
			$raw['_padding_widescreen'],
			$raw['_padding_laptop'],
			$raw['_background_hover_transition'],
			$raw['_border_radius'],
			$raw['_border_radius_tablet'],
			$raw['_border_radius_mobile'],
			$raw['_border_radius_tablet_extra'],
			$raw['_border_radius_mobile_extra'],
			$raw['_border_radius_widescreen'],
			$raw['_border_radius_laptop'],
			$raw['_border_radius_hover'],
			$raw['_border_radius_hover_tablet'],
			$raw['_border_radius_hover_mobile'],
			$raw['_border_radius_hover_tablet_extra'],
			$raw['_border_radius_hover_mobile_extra'],
			$raw['_border_radius_hover_widescreen'],
			$raw['_border_radius_hover_laptop'],
			$raw['_border_hover_transition'],
			$raw['_transform_keep_proportions'],
			$raw['_transform_keep_proportions_hover'],
			$raw['_transform_transition_hover'],
			$raw['_element_custom_width'],
			$raw['hide_desktop'],
			$raw['hide_tablet'],
			$raw['hide_mobile'],

			$raw['navfloated'],
			$raw['navhalign'],
			$raw['navvalign'],
			$raw['navdirection'],
			$raw['dots_vertical_align'],
			$raw['navline'],
			$raw['navoffset'],
			$raw['prevoffset'],
			$raw['nextoffset'],
			$raw['navsize'],
			$raw['navfill'],
			$raw['navshape'],
			$raw['navshadow'],
			$raw['carousel_nav_options_dep_warn'],
			$raw['nav_offset'],
			$raw['nav_width_slider'],
			$raw['nav_height_slider'],
			$raw['nav_prev_offset'],
			$raw['nav_next_offset'],
			$raw['nav_background_color'],
			$raw['navigation_border'],
			$raw['nav_border_radius'],
			$raw['navigation_box_shadow'],
			$raw['carousel_nav_styles_dep_warn'],
			$raw['nav_hover_background_color'],
			$raw['navigation_hover_border'],
			$raw['navigation_hover_box_shadow'],
			$raw['carousel_nav_hstyles_dep_warn'],
			$raw['nav_border_hcolor'],

			$raw['nav_arrow_color'],
			$raw['nav_arrow_color_hover'],
			$raw['nav_arrow_numbers'],
			$raw['nav_border_color'],
			$raw['nav_border_hcolor'],
			$raw['nav_bg_color'],
			$raw['nav_bg_hcolor'],

			$raw['shapesize'],
			$raw['shapeheight'],
			$raw['shapewidth'],

			$raw['size_dots'],
			$raw['dotscustomsize'],
			$raw['dotscustomsize_height'],
			$raw['align_dots'],
			$raw['dots_style'],

			$raw['dots_bg_color'],
			$raw['dots_bg_hcolor'],

			$raw['dots_position'],
			$raw['mobile_dots_position'],
			$raw['mobile_align_dots'],
			$raw['mobile_dots_bottom_offset'],
			$raw['mobile_dots_bottom_offset_outside'],
			$raw['mobile_dots_left_offset'],
			$raw['mobile_dots_right_offset'],
			$raw['mobile_dots_bg_color'],
			$raw['mobile_dots_bg_hcolor'],
			$raw['dots_top_offset'],
			$raw['dots_right_offset'],
			$raw['dots_bottom_offset'],
			$raw['dots_left_offset'],
			$raw['_id'],
			$raw['_element_id'],
			$raw['carousel_controller_id'],
			$raw['el_id'],
			$raw['el_class'],

			$raw['carousel_item_bg_color'],
			$raw['carousel_item_box_shadow'],
			$raw['carousel_item_box_shadow_box_shadow'],
			$raw['carousel_item_box_shadow_box_shadow_position'],
			$raw['carousel_item_box_shadow_box_shadow_type'],
			$raw['carousel_item_border_radius'],
			$raw['carousel_item_border_radius_tablet'],
			$raw['carousel_item_border_radius_mobile'],
			$raw['carousel_item_border_radius_desktop'],
			$raw['carousel_item_border_radius_tablet_extra'],
			$raw['carousel_item_border_radius_mobile_extra'],
			$raw['carousel_item_border_radius_widescreen'],
			$raw['carousel_item_border_radius_laptop'],
			$raw['carousel_item_inner_padding'],
			$raw['carousel_item_inner_padding_tablet'],
			$raw['carousel_item_inner_padding_mobile'],
			$raw['carousel_item_inner_padding_desktop'],
			$raw['carousel_item_inner_padding_tablet_extra'],
			$raw['carousel_item_inner_padding_mobile_extra'],
			$raw['carousel_item_inner_padding_widescreen'],
			$raw['carousel_item_inner_padding_laptop'],
			$raw['carousel_item_inner_margin'],
			$raw['carousel_item_inner_margin_tablet'],
			$raw['carousel_item_inner_margin_mobile'],
			$raw['carousel_item_inner_margin_desktop'],
			$raw['carousel_item_inner_margin_tablet_extra'],
			$raw['carousel_item_inner_margin_mobile_extra'],
			$raw['carousel_item_inner_margins_widescreen'],
			$raw['carousel_item_inner_margins_laptop'],
			$raw['carousel_item_spacing'],
			$raw['carousel_item_spacing_tablet'],
			$raw['carousel_item_spacing_mobile'],
			$raw['carousel_item_spacing_desktop'],
			$raw['carousel_item_spacing_tablet_extra'],
			$raw['carousel_item_spacing_mobile_extra'],
			$raw['carousel_item_spacing_widescreen'],
			$raw['carousel_item_spacing_laptop'],
			$raw['content_type'],
			$raw['templates'],
			$raw['carousel_items_custom_height'],
			$raw['carousel_gallery_alignment'],
			$raw['carousel_item_border'],

			$raw['lqd_parallax'],
			$raw['lqd_parallax_settings_popover'],
			$raw['lqd_parallax_from_options'],
			$raw['lqd_parallax_to_options'],
			$raw['lqd_parallax_settings_ease'],
			$raw['lqd_parallax_settings_trigger'],
			$raw['lqd_parallax_settings_trigger_start'],
			$raw['lqd_parallax_settings_trigger_end'],
			$raw['lqd_parallax_settings_duration'],
			$raw['lqd_parallax_settings_perspective'],
			$raw['lqd_parallax_from_x'],
			$raw['lqd_parallax_from_y'],
			$raw['lqd_parallax_from_z'],
			$raw['lqd_parallax_from_scaleX'],
			$raw['lqd_parallax_from_scaleY'],
			$raw['lqd_parallax_from_rotationX'],
			$raw['lqd_parallax_from_rotationY'],
			$raw['lqd_parallax_from_rotationZ'],
			$raw['lqd_parallax_from_opacity'],
			$raw['lqd_parallax_from_transformOriginX'],
			$raw['lqd_parallax_from_transformOriginY'],
			$raw['lqd_parallax_from_transformOriginZ'],
			$raw['lqd_parallax_to_x'],
			$raw['lqd_parallax_to_y'],
			$raw['lqd_parallax_to_z'],
			$raw['lqd_parallax_to_scaleX'],
			$raw['lqd_parallax_to_scaleY'],
			$raw['lqd_parallax_to_rotationX'],
			$raw['lqd_parallax_to_rotationY'],
			$raw['lqd_parallax_to_rotationZ'],
			$raw['lqd_parallax_to_opacity'],
			$raw['lqd_parallax_to_transformOriginX'],
			$raw['lqd_parallax_to_transformOriginY'],
			$raw['lqd_parallax_to_transformOriginZ'],

			$raw['lqd_custom_animation'],
			$raw['lqd_ca_control_timeline_slider'],
			$raw['lqd_ca_settings_popover'],
			$raw['lqd_ca_from_popover'],
			$raw['lqd_ca_to_popover'],
			$raw['lqd_ca_preset'],
			$raw['lqd_ca_settings_ease'],
			$raw['lqd_ca_settings_direction'],
			$raw['lqd_ca_settings_duration'],
			$raw['lqd_ca_settings_stagger'],
			$raw['lqd_ca_settings_start_delay'],
			$raw['lqd_ca_from_x'],
			$raw['lqd_ca_from_y'],
			$raw['lqd_ca_from_z'],
			$raw['lqd_ca_from_scaleX'],
			$raw['lqd_ca_from_scaleY'],
			$raw['lqd_ca_from_rotationX'],
			$raw['lqd_ca_from_rotationY'],
			$raw['lqd_ca_from_rotationZ'],
			$raw['lqd_ca_from_opacity'],
			$raw['lqd_ca_from_transformOriginX'],
			$raw['lqd_ca_from_transformOriginY'],
			$raw['lqd_ca_from_transformOriginZ'],
			$raw['lqd_ca_to_x'],
			$raw['lqd_ca_to_y'],
			$raw['lqd_ca_to_z'],
			$raw['lqd_ca_to_scaleX'],
			$raw['lqd_ca_to_scaleY'],
			$raw['lqd_ca_to_rotationX'],
			$raw['lqd_ca_to_rotationY'],
			$raw['lqd_ca_to_rotationZ'],
			$raw['lqd_ca_to_opacity'],
			$raw['lqd_ca_to_transformOriginX'],
			$raw['lqd_ca_to_transformOriginY'],
			$raw['lqd_ca_to_transformOriginZ']

		);

		$raw = array_filter( $raw );
		$custom_opts = $arr = array();

		foreach( $raw as $id => $val ) {

			// Casting
			if( 'yes' === $val ) {
				$val = true;
			}
			if( 'no' === $val || '' === $val ) {
				$val = false;
			}
			if( in_array( $id, array( 'autoplaytime' ) ) ) {
				$val = intval( $val );
			}
			if( in_array( $id, array( 'columns_auto_width' ) ) ) {
				$opts[ $ids[ 'percentPosition' ] ] = false;
			}

			if( in_array( $id, array( 'prev', 'next', 'navarrow' ) ) ) {

				if( 'navarrow' === $id && 'custom' !== $val ){
					$opts[ $ids[ 'navarrow' ] ] = $val;
				}
				else {

					if( 'next' === $id ) {
						$val = !empty( $val ) ? esc_html( $val ) : '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"32\" viewBox=\"0 0 12 32\" style=\"height: 1em;\"><path fill=\"fillColor\" d=\"M3.625 16l7.938 7.938c.562.562.562 1.562 0 2.125-.313.312-.688.437-1.063.437s-.75-.125-1.063-.438L.376 17c-.563-.563-.5-1.5.063-2.063l9-9c.562-.562 1.562-.562 2.124 0s.563 1.563 0 2.125z\"></path></svg>';
						$custom_opts['next'] = $val;
					}
					if( 'prev' === $id ) {
						$val = !empty( $val ) ? esc_html( $val ) : '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"32\" viewBox=\"0 0 12 32\" style=\"height: 1em;\"><path fill=\"fillColor\" d=\"M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z\"></path></svg>';
						$custom_opts['prev'] = $val;
					}
					$opts[ $ids[ 'navarrow' ] ] = $custom_opts;
				}
			}
			elseif( 'controllingcarousels' === $id ) {

				$cc_values = explode( ',', $val );

				foreach( $cc_values as $value ) {
					$cc_value[] = $value ;
				}

				$opts[ $ids[ 'controllingcarousels' ] ] = $cc_value;

			}
			elseif ( 'navappend' === $id ) {

				if ( 'custom_id' === $val && !empty( $opts[ $ids[ 'navappend_id' ] ] ) ) {

					$opts[ $ids[ 'navappend' ] ] = $opts[ $ids[ 'navappend_id' ] ];

				} else {

					$opts[ $ids[ $id ] ] = $val;

				}

			}
			else{
				if ( isset( $ids[ $id ] ) ) {
					$opts[ $ids[ $id ] ] = $val;
				}
			}

		}

		if( !empty( $opts ) ) {
			echo " data-lqd-flickity='" . stripslashes( wp_json_encode( $opts ) ) ."'";
		}
		else {
			echo " data-lqd-flickity=true";
		}
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Carousel() );