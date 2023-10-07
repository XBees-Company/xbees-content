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
class LD_Testimonial_Carousel extends Widget_Base {

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
		return 'ld_testimonial_carousel';
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
		return __( 'Liquid Testimonial Carousel', 'hub-elementor-addons' );
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
		return 'eicon-testimonial-carousel lqd-element';
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
		return [ 'carousel', 'slider', 'testimonial' ];
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
			return [ 'flickity', 'flickity-fade' ];
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
			'columns_auto_width',
			[
				'label' => __( 'Auto Columns Width', 'hub-elementor-addons' ),
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
				'label' => __( 'Number of Columns', 'hub-elementor-addons' ),
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
				'label' => __( 'Item Spacing (px)', 'hub-elementor-addons' ),
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
				'tablet_default' => [
					'size' => 30,
				],
				'mobile_default' => [
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .carousel-item' => 'padding-inline-start: {{SIZE}}{{UNIT}}; padding-inline-end: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .carousel-items.row' => 'margin-inline-start: -{{SIZE}}{{UNIT}}; margin-inline-end: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'template',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style01',
				'options' => [
					'style01' => __( 'Style 1', 'hub-elementor-addons' ),
					'style02' => __( 'Style 2', 'hub-elementor-addons' ),
					'style03' => __( 'Style 3', 'hub-elementor-addons' ),
					'style04' => __( 'Style 4', 'hub-elementor-addons' ),
					'style05' => __( 'Style 5', 'hub-elementor-addons' ),
					'style06' => __( 'Style 6', 'hub-elementor-addons' ),
					'style07' => __( 'Style 7', 'hub-elementor-addons' ),
					'style08' => __( 'Style 8', 'hub-elementor-addons' ),
					'style09' => __( 'Style 9', 'hub-elementor-addons' ),
					'style10' => __( 'Style 10', 'hub-elementor-addons' ),
					'style11' => __( 'Style 11', 'hub-elementor-addons' ),
					'style12' => __( 'Style 12', 'hub-elementor-addons' ),
					'style13' => __( 'Style 13', 'hub-elementor-addons' ),
					'style14' => __( 'Style 14', 'hub-elementor-addons' ),
					'style15' => __( 'Style 15', 'hub-elementor-addons' ),
					'style16' => __( 'Style 16', 'hub-elementor-addons' ),
					'style17' => __( 'Style 17', 'hub-elementor-addons' ),
					'style18' => __( 'Style 18', 'hub-elementor-addons' ),
					'style19' => __( 'Style 19', 'hub-elementor-addons' ),
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Name', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'John Doe', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your name here', 'hub-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'position',
			[
				'label' => __( 'Position', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Developer', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your position here', 'hub-elementor-addons' ),
				'condition' => [
					'template!' => [ 'style04' ],
				],
			]
		);

		$repeater->add_control(
			'avatar',
			[
				'label' => __( 'Avatar', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'template!' => [ 'style19' ],
				],
			]
		);

	
		$repeater->add_control(
			'content',
			[
				'label' => __( 'Text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'placeholder' => __( 'Type your text here', 'hub-elementor-addons' ),
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'hub-elementor-addons' ),
			]
		);

		// Addional Section
		$repeater->add_control(
			'more_options',
			[
				'label' => __( 'Additional Options', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'template' => [ 'style02', 'style03', 'style04', 'style05', 'style07', 'style08', 'style09', 'style11', 'style16', 'style18', 'style19' ],
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Client Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'template' => [ 'style05', 'style16', 'style18', 'style19' ],
				],
			]
		);

		$repeater->add_control(
			'rating',
			[
				'label' => __( 'Rating/Stars', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition' => [
					'template' => [ 'style02', 'style04', 'style05', 'style09', 'style11', 'style18', 'style19' ],
				],
			]
		);

		$repeater->add_control(
			'date_time',
			[
				'label' => __( 'Data/Time', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Type your Data/Time here', 'hub-elementor-addons' ),
				'condition' => [
					'template' => 'style04',
				],
			]
		);

		$repeater->add_control(
			'network',
			[
				'label' => __( 'Network', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fa-amazon',
				'options' => [
					'fa-facebook' => __('Facebook', 'hub-elementor-addons'),
					'fa-twitter' => __('Twitter', 'hub-elementor-addons'),
					'fa-youtube' => __('Youtube', 'hub-elementor-addons'),
					'fa-instagram' => __('Instagram', 'hub-elementor-addons'),
					'fa-vimeo' => __('Vimeo', 'hub-elementor-addons'),
					'fa-linkedin' => __('Linkedin', 'hub-elementor-addons'),
					'fa-github' => __('Github', 'hub-elementor-addons'),
					'fa-dribbble' => __('Dribbble', 'hub-elementor-addons'),
					'fa-skype' => __('Skype', 'hub-elementor-addons'),
					'fa-medium' => __('Medium', 'hub-elementor-addons'),
					'fa-reddit' => __('Reddit', 'hub-elementor-addons'),
					'fa-slack' => __('Slack', 'hub-elementor-addons'),
					'fa-stack-overflow' => __('Stack Overflow', 'hub-elementor-addons'),
					'fa-telegram' => __('Telegram', 'hub-elementor-addons'),
					'fa-tiktok' => __('TikTok', 'hub-elementor-addons'),
					'fa-whatsapp' => __('Whatsapp', 'hub-elementor-addons'),
				],
				'condition' => [
					'template' => [ 'style03', 'style04', 'style08', 'style07' ],
				],
			]
		);

		$repeater->add_control(
			'item_bg_color',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi' => 'background: {{VALUE}} !important',
				],
				'condition' => [
					'template!' => [ 'style2', 'style15', 'style17' ],
				],
				'separator' => 'before'
			]
		);

		$repeater->add_control(
			'item_bg_color_style2',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi' => 'background: {{VALUE}} !important',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi:after' => 'border-top-color: {{VALUE}} !important',
				],
				'condition' => [
					'template' => [ 'style2' ],
				],
			]
		);

		$repeater->add_control(
			'item_bg_color_style15',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi .lqd-testi-inner' => 'background: {{VALUE}} !important',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi:after' => 'border-left-color: {{VALUE}} !important',
				],
				'condition' => [
					'template' => [ 'style15' ],
				],
			]
		);

		$repeater->add_control(
			'item_bg_color_style17',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi .lqd-testi-quote' => 'background: {{VALUE}} !important',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi .lqd-testi-quote:after' => 'border-top-color: {{VALUE}} !important',
				],
				'condition' => [
					'template' => [ 'style17' ],
				],
			]
		);

		$repeater->add_control(
			'item_border_color_',
			[
				'label' => __( 'Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi.lqd-testi-style-2:after' => 'border-top-color: {{VALUE}}',
				],
				'condition' => [
					'template' => [ 'style02', 'style09', 'style15' ],
				],
			]
		);

		$repeater->add_control(
			'item_border_color_style18',
			[
				'label' => __( 'Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi:before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'template' => [ 'style18' ],
				],
			]
		);

		$repeater->add_control(
			'item_secondary_color',
			[
				'label' => __( 'Secondary Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi-quote-icon path,{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi-quote-icon circle' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'template' => [ 'style10', 'style12', 'style16' ],
				],
			]
		);

		$repeater->add_control(
			'item_title_color',
			[
				'label' => __( 'Title Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi h3' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'item_pos_color',
			[
				'label' => __( 'Position Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi h4' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'item_text_color',
			[
				'label' => __( 'Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi-quote' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'item_star_color',
			[
				'label' => __( 'Star/Rating Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi .lqd-star-rating .active' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi .lqd-star-rating-fill:before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'template' => [ 'style02', 'style04', 'style05', 'style09', 'style11', 'style18', 'style19' ],
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'selector' => '{{WRAPPER}} .lqd-testi',
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'item_border_radius',
			[
				'label' => __( 'Border Radius', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow',
				'label' => __( 'Box shadow', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi',
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Testimonial Slides', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[],[],[]
				],
				'title_field' => '{{{ title }}}',
				'separator' => 'before'
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
		
		$this->add_control(
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
				'label' => __( 'Navigation style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prevnextbuttons' => 'yes'
				)
			)
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
			'nav_arrow_color_hover',
			[
				'label' => __( 'Hover color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button:hover svg' => 'stroke: {{VALUE}}',
					'{{WRAPPER}}.carousel-nav .flickity-button:hover svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}}.carousel-nav .flickity-button:hover' => 'color: {{VALUE}}',
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
			'nav_border_hcolor',
			[
				'label' => __( 'Border hover color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button:hover' => 'border-color: {{VALUE}}',
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

		$this->add_control(
			'nav_bg_hcolor',
			[
				'label' => __( 'Background hover', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.carousel-nav .flickity-button:hover' => 'background: {{VALUE}}',
				],
			]
		);
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

		$this->add_responsive_control(
			'carousel_item_border_radius',
			[
				'label' => __( 'Items border radius', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .carousel-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
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
			$settings['navhalign'],
			$settings['navsize'],
			$settings['navfill'],
			$settings['navshape'],
			$settings['navshadow'],
			$settings['navhalign'],
			$settings['navfloated'],
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
			$settings['custom_cursor'],			
		);

		$carousel_items_classes = array(
			$settings['fadesides'],
		);

		$template = new \LD_Testimonial_Template_Handler();

		$origin = is_rtl() || $settings['reverse'] === 'yes'  ? 'right' : 'left';
		$viewport_overflow = $settings['fullwidthside'] !== 'yes' ? 'overflow-hidden' : '';
		$align_items_center = $settings['middlealigncontent'] === 'yes' && $settings['equalheightcells'] === 'yes' && $settings['randomveroffset'] !== 'yes';
		$carousel_item_classname = array(
			'carousel-item',
			'd-flex',
			'flex-column',
			'justify-content-center',
			$align_items_center ? 'align-items-center' : '',
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

		<div class="<?php echo ld_helper()->sanitize_html_classes( $wrapper_classes ); ?>" id="<?php echo esc_attr( 'ld-testimonial-carousel-' . $this->get_ID() ); ?>" >

			<div class="carousel-items pos-rel <?php echo implode(' ', $carousel_items_classes); ?>" <?php self::get_options(); ?>>

				<?php if ( $settings['fullwidthside'] === 'yes' ): ?>
				<div class="flickity-viewport-wrap">
				<?php endif; ?>
					<div class="flickity-viewport pos-rel w-100 <?php echo $viewport_overflow; ?>">
						<div class="<?php echo ld_helper()->sanitize_html_classes( $slider_element_classnames ); ?>" style="<?php echo $origin ?>: 0; transform: translateX(0%);">
			
							<?php foreach (  $settings['list'] as $item ) : ?>
								<div class="<?php echo ld_helper()->sanitize_html_classes( $carousel_item_classname ); ?> elementor-repeater-item-<?php echo $item['_id']; ?>">
									<div class="carousel-item-inner pos-rel w-100">
										<div class="carousel-item-content pos-rel w-100">
											
											<?php 
												$template->testimonials_template(
													$item['template'],
													$item['content'],
													$item['avatar'],
													$item['title'],
													$item['position'],
													$item['rating'],
													$item['network'],
													$item['date_time'],
													$item['image']
												);
											?>

										</div>
									</div>
								</div>
							<?php endforeach; ?>

						</div>
					</div>
				<?php if ( $settings['fullwidthside'] === 'yes' ): ?>
				</div>
				<?php endif; ?>
			</div>

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

			'dots_type'						 => 'dotsIndicator',
			
			'dotsappend'           => 'dotsAppendTo',
			'dotsappend_id'        => 'dotsAppendTo',
			
			'prevnextbuttons'      => 'prevNextButtons',
			'navarrow'             => 'navArrow',
			'navslidernumberstoarrows' => 'addSlideNumbersToArrows',
			'fullwidthside'        => 'fullwidthSide',
			'navoffset'            => 'navOffsets',
			'randomveroffset'      => 'randomVerOffset',
			'controllingcarousels' => 'controllingCarousels',

			'reverse'			   			 => 'rightToLeft',
			'marquee_speed'        => 'marqueeTickerSpeed',
			
		);

		unset(
			$raw['__globals__'],
			$raw['bg_color'],
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
			$raw['custom_css'],

			$raw['navfloated'],
			$raw['navhalign'],
			$raw['navvalign'],
			$raw['navdirection'],
			$raw['dots_vertical_align'],
			$raw['navline'],
			$raw['navsize'],
			$raw['navfill'],
			$raw['navshape'],
			$raw['navshadow'],

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
			$raw['template'],
			$raw['title'],
			$raw['position'],
			$raw['avatar'],
			$raw['content'],
			$raw['more_options'],
			$raw['image'],
			$raw['rating'],
			$raw['date_time'],
			$raw['network'],


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
			$raw['lqd_ca_to_transformOriginZ'],

			$raw['_element_width']
			
		);

		$raw = array_filter( $raw );
		$custom_opts = $arr = $offset_value = array();

		foreach( $raw as $id => $val ) {

			// Casting
			if( 'yes' === $val ) {
				$val = true;
			}
			if( 'no' === $val || '' === $val ) {
				$val = false;
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
			elseif( 'navoffset' === $id ) {

				$offset_values = explode( ',', $val );

				foreach( $offset_values as $value ) {

					$arr = explode( ':', $value );
					$offset_value[ $arr[0] ] = $arr[1] ;

				}

				$opts[ $ids[ 'navoffset' ] ] = array( 'nav' => $offset_value);

			} 
			elseif( 'prevoffset' === $id )	 {
				if( !empty( $val ) ) {
					$opts[ $ids[ 'navoffset' ] ]['prev'] = $val;	
				}
			}
			elseif( 'nextoffset' === $id )	 {
				if( !empty( $val ) ) {
					$opts[ $ids[ 'navoffset' ] ]['next'] = $val;
				}
			}
			elseif ( 'navappend' === $id ) {

				if ( 'custom_id' === $val && !empty( $opts[ $ids[ 'navappend_id' ] ] ) ) {

					$opts[ $ids[ 'navappend' ] ] = $opts[ $ids[ 'navappend_id' ] ];

				} else {

					$opts[ $ids[ $id ] ] = $val;
					
				}

			}
			else{
				$opts[ $ids[ $id ] ] = $val;
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
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Testimonial_Carousel() );