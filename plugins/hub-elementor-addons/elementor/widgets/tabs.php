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
use Elementor\Icons_Manager;

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
class LD_Tabs extends Widget_Base {

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
		return 'ld_tabs';
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
		return __( 'Liquid Tabs', 'hub-elementor-addons' );
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
		return 'eicon-tabs lqd-element';
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
		return [ 'tab', 'swipe' ];
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
			return [ 'liquid-sc-tabs' ];
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
			'content_section',
			[
				'label' => __( 'Content', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
			'templates', [
				'label' => __( 'Select template', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => $this->get_block_posts(),
				'default' => '0',
				'condition' => [
					'content_type' => 'el_template'
				],
			]
		);
		
		$repeater->add_control(
			'item_title', [
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title' , 'hub-elementor-addons' ),
				'label_block' => true,
				'seperator' => 'before',
			]
		);

		$repeater->add_control(
			'item_description', [
				'label' => __( 'Short description', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Description' , 'hub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_content', [
				'label' => __( 'Content', 'hub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Content' , 'hub-elementor-addons' ),
				'condition' => [
					'content_type' => 'tinymce'
				],
			]
		);
		
		$repeater->add_control(
			'item_icon',
			[
				'label' => __( 'Icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-arrow-left',
					'library' => 'solid',
				],
			]
		);

		$repeater->add_control(
			'item_icon_color',
			[
				'label' => __( 'Icon color', 'hub-elementor-addons' ),
				'description' => __( 'If you use this option it will override the widget color settings.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-tabs-nav-icon-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'item_icon_bg_color',
			[
				'label' => __( 'Icon background color', 'hub-elementor-addons' ),
				'description' => __( 'If you use this option it will override the widget color settings.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-tabs-nav-icon-icon' => 'background: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'item_custom_id', [
				'label' => __( 'Set custom id', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => 'my-custom-id',
				'description' => __( 'Set a custom ID. Leave blank if you want it to be defined automatically. Each tab must have a different ID. And don\'t use "#".' , 'hub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_title' => __( 'Title #1', 'hub-elementor-addons' ),
						'item_content' => __( 'Item 1 content. Click the edit button to change this text.', 'hub-elementor-addons' ),
					],
					[
						'item_title' => __( 'Title #2', 'hub-elementor-addons' ),
						'item_content' => __( 'Item 2 content. Click the edit button to change this text.', 'hub-elementor-addons' ),
					],
					[
						'item_title' => __( 'Title #3', 'hub-elementor-addons' ),
						'item_content' => __( 'Item 3 content. Click the edit button to change this text.', 'hub-elementor-addons' ),
					],
				],
				'title_field' => '{{{ item_title }}}',
			]
		);

		$this->add_control(
			'active_tab',
			[
				'label' => __( 'Active tab', 'hub-elementor-addons' ),
				'description' => __( 'Enter active tab integer value. Example: 2', 'hub-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 15,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'options_section',
			[
				'label' => __( 'Options', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'style',
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
					'style09' => __( 'Style 9 A', 'hub-elementor-addons' ),
					'style09b' => __( 'Style 9 B', 'hub-elementor-addons' ),
					'style09c' => __( 'Style 9 C', 'hub-elementor-addons' ),
					'style10' => __( 'Style 10', 'hub-elementor-addons' ),
					'style11' => __( 'Style 11', 'hub-elementor-addons' ),
					'style12' => __( 'Style 12', 'hub-elementor-addons' ),
					'style13' => __( 'Style 13', 'hub-elementor-addons' ),
					'style14' => __( 'Style 14', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'nav_alignment',
			[
				'label' => __( 'Nav alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'justify-content-between' => [
						'title' => __( 'Space Between', 'hub-elementor-addons' ),
						'icon' => 'eicon-navigation-horizontal',
					],
					'justify-content-start' => [
						'title' => __( 'Start', 'hub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'justify-content-center' => [
						'title' => __( 'Center', 'hub-elementor-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'justify-content-end' => [
						'title' => __( 'End', 'hub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'justify-content-between',
				'toggle' => false,
				'condition' => [
					'style' => [ 'style03', 'style10', 'style11', 'style12' ],
				],
			]
		);

		$this->add_control(
			'nav_expand',
			[
				'label' => __( 'Expand nav items', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'style' => [ 'style09', 'style09b', 'style09c' ],
				],
			]
		);

		$this->add_control(
			'nav_alignment_style9',
			[
				'label' => __( 'Nav alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'justify-content-start' => [
						'title' => __( 'Start', 'hub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'justify-content-center' => [
						'title' => __( 'Center', 'hub-elementor-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'justify-content-end' => [
						'title' => __( 'End', 'hub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'justify-content-center',
				'toggle' => false,
				'condition' => [
					'nav_expand!' => 'yes',
					'style' => [ 'style09', 'style09b', 'style09c' ]
				],
			]
		);

		$this->add_control(
			'reverse_direction',
			[
				'label' => __( 'Reverse direction', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'style' => [ 'style01', 'style02', 'style05', 'style06', 'style08', 'style09', 'style09b', 'style09c', 'style11', 'style12', 'style13' ],
				],
			]
		);

		$this->add_control(
			'tab_trigger',
			[
				'label' => __( 'Trigger', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'click',
				'options' => [
					'click' => __( 'Click', 'hub-elementor-addons' ),
					'hover' => __( 'Hover', 'hub-elementor-addons' ),
				],
				'condition' => [
					'style!' => [ 'style14' ],
				],
			]
		);

		$this->add_control(
			'nav_underline_width',
			[
				'label' => __( 'Nav underline width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'hub-elementor-addons' ),
					'fw' => __( 'Fullwidth', 'hub-elementor-addons' ),
				],
				'condition' => [
					'style' => [ 'style12' ],
				],
			]
		);

		$this->add_control(
			'enable_deeplinks',
			[
				'label' => __( 'Enable deeplinks?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'enable_sticky_nav',
			[
				'label' => __( 'Enable sticky nav?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'lqd-css-sticky',
				'default' => '',
				'condition' => [
					'style' => [ 'style06', 'style08' ],
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'hub-elementor-addons' ),
				'condition' => [
					'style' => [ 'style06' ],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'general_style_section',
			[
				'label' => __( 'General', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nav_typography',
				'label' => __( 'Nav typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-tabs-nav > li > a, {{WRAPPER}} .lqd-tabs-nav .h3,{{WRAPPER}} .lqd-tabs-nav > li > a .lqd-tabs-nav-txt',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nav_desc_typography',
				'label' => __( 'Nav description typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-desc',
				'condition' => 	[
					'style' => [ 'style01', 'style02', 'style05' ],
				]
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nav_ext_desc_typography',
				'label' => __( 'Nav description typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-ext',
				'condition' => 	[
					'style' => [ 'style13', 'style14' ]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_content_typography',
				'label' => __( 'Content typography', 'hub-elementor-addons' ),
				'selector' => '.lqd-tabs-content',
			]
		);


		$this->add_responsive_control(
			'padding',
			[
				'label' => __( 'Content padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_nav_width',
			[
				'label' => __( 'Navigation width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs' => '--tab-nav-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'style' => [ 'style05', 'style06', 'style08', 'style13' ]
				]
			]
		);

		$this->add_responsive_control(
			'tabs_icon_size',
			[
				'label' => __( 'Icon size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'em',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs-nav' => '--icon-size: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Colors
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Colors', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'style_tabs'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => __( 'Normal', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav a' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style!' => [ 'style14' ]
				)
			]
		);
		
		$this->add_control(
			'title_color_style14_heading',
			[
				'label' => __( 'Title color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'style' => [ 'style14' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_color_style14',
				'label' => __( 'Title color', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav > li .lqd-tabs-nav-txt span',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style14' ]
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => __( 'Description color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-desc' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style' => [ 'style01', 'style02', 'style05' ]
				)
			]
		);

		$this->add_control(
			'ext_color',
			[
				'label' => __( 'Description color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-ext' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style' => [ 'style13', 'style14' ]
				)
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color',
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav a, {{WRAPPER}} .lqd-tabs-style-5 .lqd-tabs-nav a:after',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style05', 'style06', 'style07', 'style09', 'style09b', 'style13' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color_style09c',
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style09c' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color_style10',
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav a:after',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style10' ]
				],
			]
		);

		$border_colors = [
			'style01' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li:before' => 'background: {{VALUE}}',
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li:after' => 'border-top-color: {{VALUE}}',
			),
			'style02' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-progress' => 'background: {{VALUE}}'
			),
			'style03' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav' => 'border-color: {{VALUE}}'
			),
			'style04' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav:before' => 'background: {{VALUE}}',
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .h3:after' => 'background: {{VALUE}}',
			),
			'style09' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav a' => 'border-color: {{VALUE}}'
			),
			'style09b' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav a' => 'border-color: {{VALUE}}'
			),
			'style12' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav a:after' => 'background: {{VALUE}}'
			)
		];
		
		foreach ($border_colors as $key => $style) {

			$this->add_control(
				'border_color_'.$key,
				[
					'label' => __( 'Border color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'condition' => [
						'style' => [ $key ],
					],
					'selectors' => $border_colors[$key]
				]
			);
			
		};

		$this->add_control(
			'icon_bg_heading',
			[
				'label' => __( 'Icon background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'style' => [ 'style01', 'style02', 'style06', 'style07' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_bg',
				'label' => __( 'Icon background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-icon-icon',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style01', 'style02' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_bg_alt',
				'label' => __( 'Icon background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-icon',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style06', 'style07' ]
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-icon-icon' => 'color: {{VALUE}}'
				],
				'condition' => [
					'style' => [ 'style01', 'style02', 'style03', 'style04', 'style05' ],
				],
			]
		);

		$this->add_control(
			'icon_color_alt',
			[
				'label' => __( 'Icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-icon-icon' => 'color: {{VALUE}}'
				],
				'condition' => [
					'style' => [ 'style06', 'style07' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_active_tab',
			[
				'label' => __( 'Active', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'active_title_color',
			[
				'label' => __( 'Title color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active a' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style!' => [ 'style14' ]
				)
			]
		);

		$this->add_control(
			'active_title_color_style14_heading',
			[
				'label' => __( 'Title color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'style' => [ 'style14' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'active_title_color_style14',
				'label' => __( 'Title color', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs-style-14 .lqd-tabs-nav > li .lqd-tabs-nav-txt::before',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style14' ]
				],
			]
		);

		$this->add_control(
			'active_desc_color',
			[
				'label' => __( 'Description color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-desc' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style' => [ 'style01', 'style02', 'style05' ]
				)
			]
		);

		$this->add_control(
			'active_ext_color',
			[
				'label' => __( 'Description color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-ext' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style' => [ 'style13', 'style14' ]
				)
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'active_bg_color',
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active a, {{WRAPPER}} .lqd-tabs-style-5 .lqd-tabs-nav a:after',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style05', 'style06', 'style07', 'style09', 'style09b', 'style13' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'active_bg_color_style09c',
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active a',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style09c' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'active_bg_color_style10',
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav a:before',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style10' ]
				],
			]
		);

		$active_border_colors = [
			'style01' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active:before' => 'background: {{VALUE}}',
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active:after' => 'border-top-color: {{VALUE}}',
			),
			'style02' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-progress-inner' => 'background: {{VALUE}}'
			),
			'style03' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li:after' => 'background: {{VALUE}}'
			),
			'style04' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .h3:after' => 'background: {{VALUE}}',
			),
			'style08' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active a:before' => 'background: {{VALUE}}',
			),
			'style09' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active a' => 'border-color: {{VALUE}}'
			),
			'style09b' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active a' => 'border-color: {{VALUE}}'
			),
			'style12' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active a:after' => 'background: {{VALUE}}'
			)
		];
		
		foreach ($active_border_colors as $key => $style) {

			$this->add_control(
				'active_border_color_'.$key,
				[
					'label' => __( 'Border color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'condition' => [
						'style' => [ $key ],
					],
					'selectors' => $active_border_colors[$key]
				]
			);
			
		};

		$this->add_control(
			'active_icon_bg_heading',
			[
				'label' => __( 'Icon background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'style' => [ 'style01', 'style02' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'active_icon_bg',
				'label' => __( 'Icon background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-icon-icon',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style01', 'style02', 'style06', 'style07'  ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'active_icon_bg_alt',
				'label' => __( 'Icon background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-icon-icon',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style06', 'style07' ]
				],
			]
		);

		$this->add_control(
			'active_icon_color',
			[
				'label' => __( 'Icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-icon-icon' => 'color: {{VALUE}}'
				],
				'condition' => [
					'style' => [ 'style01', 'style02', 'style03', 'style04', 'style05' ],
				],
			]
		);

		$this->add_control(
			'active_icon_color_alt',
			[
				'label' => __( 'Icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-icon-icon' => 'color: {{VALUE}}'
				],
				'condition' => [
					'style' => [ 'style06', 'style07' ],
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		ld_el_btn($this, 'ib_', $condition = ['style' => ['style05', 'style06', 'style08', 'style11', 'style12', 'style13']]);

	}

	protected function get_active_tab( $i ) {
		
		$val = $this->get_settings_for_display( 'active_tab' );
		$items = $this->get_settings_for_display( 'items' );
		$val = empty( $val ) || $val > count( $items ) ? 1 : $val;

		if ( $val === $i ) {
			return true;
		}

		return false;

	}

	protected function get_class( $style ) {

		$hash = array(
			'style01'  => 'lqd-tabs lqd-tabs-style-1 lqd-tabs-nav-iconbox d-flex',
			'style02'  => 'lqd-tabs lqd-tabs-style-2 lqd-tabs-nav-iconbox d-flex',
			'style03'  => 'lqd-tabs lqd-tabs-style-3 lqd-tabs-nav-iconbox',
			'style04'  => 'lqd-tabs lqd-tabs-style-4 lqd-tabs-nav-iconbox',
			'style05'  => 'lqd-tabs lqd-tabs-style-5 lqd-tabs-nav-iconbox d-flex flex-wrap',
			'style06'  => 'lqd-tabs lqd-tabs-style-6 lqd-tabs-nav-iconbox lqd-tabs-nav-icon-inline d-flex flex-wrap',
			'style07'  => 'lqd-tabs lqd-tabs-style-7 lqd-tabs-nav-iconbox lqd-tabs-nav-icon-inline',
			'style08'  => 'lqd-tabs lqd-tabs-style-8 d-flex flex-wrap',
			'style09'  => 'lqd-tabs lqd-tabs-style-9 d-flex',
			'style09b' => 'lqd-tabs lqd-tabs-style-9 lqd-tabs-style-9-alt d-flex',
			'style09c' => 'lqd-tabs lqd-tabs-style-9 lqd-tabs-style-9-alt2 d-flex',
			'style10'  => 'lqd-tabs lqd-tabs-style-10',
			'style11'  => 'lqd-tabs lqd-tabs-style-11 lqd-tabs-nav-plain d-flex',
			'style12'  => 'lqd-tabs lqd-tabs-style-12 lqd-tabs-nav-plain d-flex',
			'style13'  => 'lqd-tabs lqd-tabs-style-13 d-flex',
			'style14'  => 'lqd-tabs lqd-tabs-style-14 lqd-tabs-has-nav-arrows d-flex',
		);

		return $hash[ $style ];

	}

	protected function get_nav_expand() {

		$nav_expand = $this->get_settings_for_display('nav_expand');

		if ( $nav_expand === 'yes' ) {
			return;
		}

		return 'lqd-tabs-nav-items-not-expanded';

	}

	protected function get_reverse_direction() {

		$settings = $this->get_settings_for_display();

		$style = $settings['style'];
		$reverse = $settings['reverse_direction'];
		$isInRow = 'style05' === $style || 'style06' === $style || 'style08' === $style || 'style13' === $style;
		$isInColumn = 'style01' === $style || 'style02' === $style || 'style09' === $style || 'style09b' === $style || 'style09c' === $style || 'style11' === $style || 'style12' === $style || 'style14' === $style;

		if ( ! $isInRow && ! $isInColumn ) {
			return;
		}

		if ( $isInRow && $reverse ) {
			return 'flex-row-reverse';
		} else if ( $isInColumn && $reverse ) {
			return 'flex-column-reverse';
		} else if ( $isInColumn && ! $reverse ) {
			return 'flex-column';
		}
		
	}

	protected function get_tabs_opts() {

		$settings = $this->get_settings_for_display();
		
		$opts = array();
		
		if( !empty( $settings['enable_deeplinks'] ) ) {
			$opts['deepLink'] = true;
		}
		
		if( !empty( $settings['tab_trigger'] ) ) {
			$opts['trigger'] = $settings['tab_trigger'];
		}

		if ( 'style14' === $settings['style'] ) {
			$opts['translateNav'] = true;
		}

		return wp_json_encode( $opts );;

	}

	protected function get_nav_wrap_classnames() {

		$settings = $this->get_settings_for_display();

		$classname_arr = array('lqd-tabs-nav-wrap');
		$style = $settings['style'] ? $settings['style'] : 'style01';
		
		if ( !empty( $settings['show_button'] ) ) {
			$classname_arr[] = 'lqd-tabs-nav-has-btn';
		}

		switch ($style) {

			case 'style03':
			case 'style04':
			case 'style11':
				$classname_arr[] = 'mb-5';
				break;

			case 'style07':
			case 'style09':
			case 'style09b':
			case 'style10':
			case 'style12':
				$classname_arr[] = 'mb-6';
				break;

			case 'style09c':
				$classname_arr[] = 'mb-6 pb-2';
				break;

			case 'style14':
				$classname_arr[] = 'mb-3';
				break;

		}

		if ( $settings['reverse_direction'] ) {

			if (
				$style === 'style07' ||
				$style === 'style09' ||
				$style === 'style09b' ||
				$style === 'style09c' ||
				$style === 'style11'
			) {
				array_pop($classname_arr);
			}

			switch ($style) {
	
				case 'style07':
				case 'style09':
				case 'style09b':
				case 'style12':
					$classname_arr[] = 'mt-6';
					break;
	
				case 'style09c':
					$classname_arr[] = 'mt-6 pt-2';
					break;
	
				case 'style11':
					$classname_arr[] = 'mt-5';
					break;
	
			}

		}

		return $classname_arr;

	}

	protected function get_nav_icons( $icons, $tab_style ){
		if ( $icons[ 'value' ] ) {

			$icon_classname = 'lqd-tabs-nav-icon-icon d-inline-flex align-items-center justify-content-center me-5 border-radius-circle';
			
			if ( $tab_style === 'style03' ) {
				$icon_classname = 'lqd-tabs-nav-icon-icon d-block';
			}
			if ( $tab_style === 'style04' ) {
				$icon_classname = 'lqd-tabs-nav-icon-icon d-flex justify-content-center';
			}
			if ( $tab_style === 'style05' ) {
				$icon_classname = 'lqd-tabs-nav-icon-icon d-flex flex-wrap me-5';
			}

			echo '<span class="' . $icon_classname . '">';
			Icons_Manager::render_icon( $icons, [ 'aria-hidden' => 'true' ] );
			echo '</span>';
			
		}
	}

	protected function get_nav() {

		$settings = $this->get_settings_for_display();

		$out = $nav_align = '';
		$style = $settings['style'] ? $settings['style'] : 'style01';
		$nav_align = $settings['nav_alignment'];
		$nav_align_style9 = $settings['nav_alignment_style9'];
		$sticky = $settings['enable_sticky_nav'];
		
		if( 'style01' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center justify-content-between flex-wrap pos-rel" role="tablist">';
		}
		elseif( 'style03' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center ' . $nav_align . ' pos-rel" role="tablist">';
		}
		elseif( 'style04' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap justify-content-between pos-rel" role="tablist">';
		}
		elseif( 'style05' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex flex-column justify-content-center pos-rel" role="tablist">';
		}
		elseif( 'style06' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex flex-column ' . $sticky .' pos-rel" role="tablist">';
		}
		elseif( 'style07' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap justify-content-center pos-rel" role="tablist">';
		}
		elseif( 'style08' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex flex-column ' . $sticky .' pos-rel" role="tablist">';
		}
		elseif( 'style09' === $style || 'style09b' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap ' . $nav_align_style9 . ' pos-rel" role="tablist">';
		}
		elseif ( 'style09c' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap ' . $nav_align_style9 . ' pos-rel" role="tablist">';
		}
		elseif( 'style10' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex flex-wrap align-items-end ' . $nav_align . ' pos-rel" role="tablist">';
		}
		elseif( 'style11' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap ' . $nav_align . ' pos-rel" role="tablist">';
		}
		elseif( 'style12' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap ' . $nav_align . ' pos-rel" role="tablist">';
		}
		elseif( 'style13' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex flex-column pos-rel" role="tablist">';
		}
		elseif( 'style14' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center mb-6 pos-rel" role="tablist">';
		}
		else {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center justify-content-between flex-wrap pos-rel" role="tablist">';
		}

		if ( $settings['items'] ) {
			foreach ( $settings[ 'items' ] as $i => $tab ) {
				$id_int = $this->tab_get_id_int();
				$tab_count = $i + 1;
				$tab_ids = $id_int . $tab_count;

				if ( ! empty( $tab['item_custom_id'] ) ){
					$tab_ids = $tab['item_custom_id'];
				}

				$classes = array();

				$classes[] = 'elementor-repeater-item-' . $tab['_id'];

				if ( $this->get_active_tab( $tab_count ) ) {
					$classes[] = 'active';
				}

				if ( 'style01' === $style ) {
					if ( ! $settings[ 'reverse_direction' ] ) {
						$classes[] = 'mb-5';
					} else {
						$classes[] = 'mt-5';
					}
				} elseif ( 'style02' === $style ) {
					if ( ! $settings[ 'reverse_direction' ] ) {
						$classes[] = 'mb-5';
					} else {
						$classes[] = 'mt-5';
					}
				} elseif ( 'style03' === $style || 'style04' === $style ) {
					$classes[] = 'text-center';
				} elseif ( 'style06' === $style || 'style09b' === $style || 'style10' === $style ) {
					$classes[] = 'font-weight-medium';
				} elseif ( 'style07' === $style ) {
					$classes[] = 'font-weight-semibold';
				} elseif ( 'style12' === $style ) {
					$classes[] = 'mb-3';
				}

				$classes = ! empty( $classes ) ? ' class="' . join( ' ', $classes ) . '"' : '';

				// Tab title
				$title = wp_kses_data( do_shortcode( $tab[ 'item_title' ] ) );

				// Nav
				if ( 'style01' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-icon d-flex flex-wrap">';
						$this->get_nav_icons( $tab['item_icon'], $style );
					echo '<span class="lqd-tabs-nav-content d-block"><span class="d-block h3 mt-0 mb-3">' . $title . '</span>';
					if ( ! empty( $tab[ 'item_description' ] ) ) {
						echo '<span class="lqd-tabs-nav-desc d-block">' . $tab[ 'item_description' ] . '</span>';
					};
					echo '</span></span></a></li>';
				} elseif ( 'style02' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-icon d-flex align-items-center">';
						$this->get_nav_icons( $tab['item_icon'], $style );
					echo '<span class="lqd-tabs-nav-content d-block"><span class="d-block h3 mt-0 mb-2">' . $title . '</span>';
					if ( ! empty( $tab[ 'item_description' ] ) ) {
						echo '<span class="lqd-tabs-nav-desc d-block">' . $tab[ 'item_description' ] . '</span>';
					};
					echo '</span></span><span class="lqd-tabs-nav-progress"><span class="lqd-tabs-nav-progress-inner"></span></span></a></li>';
				} elseif ( 'style03' === $style || 'style04' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-icon d-block">';
						$this->get_nav_icons( $tab['item_icon'], $style );
					echo '<span class="lqd-tabs-nav-content d-block"><span class="d-block pos-rel h3 mt-0 mb-0">' . $title . '</span>';
					echo '</span></span><span class="lqd-tabs-nav-progress"><span class="lqd-tabs-nav-progress-inner"></span></span></a></li>';
				} elseif ( 'style05' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block p-5 border-radius-7" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-icon d-flex">';
						$this->get_nav_icons( $tab['item_icon'], $style );
					echo '<span class="lqd-tabs-nav-content d-block"><span class="d-block h3 mt-0 mb-3">' . $title . '</span>';
					if ( ! empty( $tab[ 'item_description' ] ) ) {
						echo '<span class="lqd-tabs-nav-desc d-block">' . $tab[ 'item_description' ] . '</span>';
					};
					echo '</span></span></a></li>';
				} elseif ( 'style06' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block pt-3 pb-3 border-radius-4" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
						$this->get_nav_icons( $tab['item_icon'], $style );
					echo '<span class="lqd-tabs-nav-txt">' . $title . '</span></a></li>';
				} elseif ( 'style07' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block pt-3 pb-3 ps-6 pe-6 border-radius-circle" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
						$this->get_nav_icons( $tab['item_icon'], $style );
					echo '<span class="lqd-tabs-nav-txt">' . $title . '</span></a></li>';
				} elseif ( 'style08' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-flex align-items-center pt-1 pb-1 mb-2" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-txt">' . $title . '</span></a></li>';
				} elseif ( 'style10' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-flex align-items-center" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-txt">' . $title . '</span></a></li>';
				} elseif ( 'style12' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-flex align-items-center" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-txt">' . $title . '</span></a></li>';
				} elseif ( 'style13' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block mb-2" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-txt">' . $title . '</span>';
					if ( ! empty( $tab[ 'item_description' ] ) ) {
						echo '<span class="lqd-tabs-nav-ext">' . $tab[ 'item_description' ] . '</span>';
					};
					$this->get_nav_icons( $tab['item_icon'], $style );
					echo '</a></li>';
				} elseif ( 'style14' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-inline-flex align-items-center border-radius-circle" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-txt" data-txt="' . $title . '"><span>' . $title . '<span></span></a>';
					if ( ! empty( $tab[ 'item_description' ] ) ) {
						echo '<span class="lqd-tabs-nav-ext">' . $tab[ 'item_description' ] . '</span>';
					};
					echo '</li>';
				} else {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-txt">' . $title . '</span></a></li>';
				}

			}
		}

		echo '</ul>';
	}

	protected function get_content() {

		$settings = $this->get_settings_for_display();

		$out = '';
		$style = $settings['style'];
		
		if( 'style01' === $style ) {
			if ( ! $settings['reverse_direction'] ) {
				$out .= '<div class="lqd-tabs-content pos-rel">';
			} else {
				$out .= '<div class="lqd-tabs-content pos-rel">';
			}
		}
		elseif( 
			'style02' === $style && $settings['reverse_direction']
		) {
			$out .= '<div class="lqd-tabs-content pos-rel">';
		}
		elseif( 
			'style02' === $style || 
			'style03' === $style || 
			'style04' === $style 
		) {
			$out .= '<div class="lqd-tabs-content pos-rel">';
		}
		elseif( 
			'style05' === $style || 
			'style06' === $style 
		) {
			if ( $settings['reverse_direction'] ) {
				$out .= '<div class="lqd-tabs-content pe-5 pos-rel">';
			} else {
				$out .= '<div class="lqd-tabs-content ps-5 pos-rel">';
			}
		}
		elseif( 
			'style08' === $style || 'style13' === $style
		) {
			if ( $settings['reverse_direction'] ) {
				$out .= '<div class="lqd-tabs-content pe-6 pos-rel">';
			} else {
				$out .= '<div class="lqd-tabs-content ps-6 pos-rel">';
			}
		}		
		else {
			$out .= '<div class="lqd-tabs-content pos-rel">';
		}

		if ( $settings['items'] ) {
			foreach ( $settings[ 'items' ] as $i => $tab ) {
				$tab_count = $i + 1;
				$id_int = $this->tab_get_id_int();
				$tab_ids = $id_int . $tab_count;

				if ( ! empty( $tab['item_custom_id'] ) ){
					$tab_ids = $tab['item_custom_id'];
				}

				$out .= sprintf( '<div id="%1$s" role="tabpanel" class="lqd-tabs-pane fade%3$s">%2$s %4$s</div>', $tab_ids, ($tab['content_type'] === 'tinymce' ? $tab[ 'item_content' ] : \Elementor\Plugin::instance()->frontend->get_builder_content( $tab[ 'templates' ], true )), ( $this->get_active_tab( $tab_count ) ? ' active in' : '' ), ($tab['content_type'] === 'tinymce' ? '' : $this->edit_btn($tab[ 'templates' ])) );
				
			}
		} else {
			$out .= vc_container_anchor();
		}

		if ( 'style14' === $style ) {
			$out .= '<div class="lqd-tabs-nav-arrows">
				<button class="lqd-tabs-nav-arrow lqd-tabs-nav-prev d-inline-flex align-items-center justify-content-center border-radius-circle pos-abs">
					<i class="lqd-icn-ess icon-md-arrow-back"></i>
				</button>
				<button class="lqd-tabs-nav-arrow lqd-tabs-nav-next d-inline-flex align-items-center justify-content-center border-radius-circle pos-abs">
					<i class="lqd-icn-ess icon-md-arrow-forward"></i>
				</button>
			</div>';
		}

		$out .= '</div>';

		echo $out;
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

	protected function edit_btn( $template_id = false ){
		return; // disabled because collections broken.
		if ( ! $template_id || !\Elementor\Plugin::$instance->editor->is_edit_mode()){
			return;
		}

		$out = '<a data-href="' . esc_url(\Elementor\Plugin::$instance->documents->get( $template_id )->get_edit_url()) . '" onclick=" window.open(this.dataset.href, \'_blank\') " class="elementor-button ws-nowrap btn btn-solid btn-xsm btn-icon-right btn-has-label btn-block">
					<span class="btn-txt" data-text="Edit this Template">Edit Content Template</span>
					<span class="btn-icon"><i class="fa fa-external-link-alt"></i></span>
				</a>';
		return $out;
	}

	protected function tab_get_id_int() {

		$id_int = substr( $this->get_id_int(), 0, 3 );

		return 'lqd-tab-'.$id_int;

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

		extract($settings);

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => [ 
					$this->get_class( $style ),
					$this->get_nav_expand(),
					$this->get_reverse_direction(),
					$this->get_id(),
					'lqd-nav-underline-' . $nav_underline_width
				],
				'data-tabs-options' => $this->get_tabs_opts(),
			]
		);

		$this->add_render_attribute(
			'nav',
			[
				'class' => $this->get_nav_wrap_classnames(),
			]
		);
		
		
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
		
			<nav <?php $this->print_render_attribute_string( 'nav' ); ?>>
				<?php $this->get_nav(); ?>
				<?php
					$button = new \LQD_Elementor_Render_Button;
					$button->get_button( $this, 'ib_' ); 
				?>
			</nav>
		
			<?php $this->get_content() ?>
		
		</div>
	<?php		

	}

	protected function content_template() {
	?>
		<#

		function get_active_tab( i ) {

			var val = settings.active_tab,
				items = settings.items;
			val = ( val === '' ) || val > items.length ? 1 : val;

			if ( val === i ) {
				return true;
			}

			return false;

		}

		function get_class( style ) {

			const hash = []
			hash['style01'] = 'lqd-tabs lqd-tabs-style-1 lqd-tabs-nav-iconbox d-flex';
			hash['style02'] = 'lqd-tabs lqd-tabs-style-2 lqd-tabs-nav-iconbox d-flex';
			hash['style03'] = 'lqd-tabs lqd-tabs-style-3 lqd-tabs-nav-iconbox';
			hash['style04'] = 'lqd-tabs lqd-tabs-style-4 lqd-tabs-nav-iconbox';
			hash['style05'] = 'lqd-tabs lqd-tabs-style-5 lqd-tabs-nav-iconbox d-flex flex-wrap';
			hash['style06'] = 'lqd-tabs lqd-tabs-style-6 lqd-tabs-nav-iconbox lqd-tabs-nav-icon-inline d-flex flex-wrap';
			hash['style07'] = 'lqd-tabs lqd-tabs-style-7 lqd-tabs-nav-iconbox lqd-tabs-nav-icon-inline';
			hash['style08'] = 'lqd-tabs lqd-tabs-style-8 d-flex flex-wrap';
			hash['style09'] = 'lqd-tabs lqd-tabs-style-9 d-flex';
			hash['style09b'] = 'lqd-tabs lqd-tabs-style-9 d-flex lqd-tabs-style-9-alt';
			hash['style09c'] = 'lqd-tabs lqd-tabs-style-9 d-flex lqd-tabs-style-9-alt2';
			hash['style10'] = 'lqd-tabs lqd-tabs-style-10';
			hash['style11'] = 'lqd-tabs lqd-tabs-style-11 lqd-tabs-nav-plain d-flex';
			hash['style12'] = 'lqd-tabs lqd-tabs-style-12 lqd-tabs-nav-plain d-flex';
			hash['style13'] = 'lqd-tabs lqd-tabs-style-13 d-flex';
			hash['style14'] = 'lqd-tabs lqd-tabs-style-14 lqd-tabs-has-nav-arrows d-flex';
			
			return hash[ style ];
		}

		function get_reverse_direction() {

			var style = settings.style,
				reverse = settings.reverse_direction,
				isInRow = 'style05' === style || 'style06' === style || 'style08' === style || 'style13' === style,
				isInColumn = 'style01' === style || 'style02' === style || 'style09' === style || 'style09b' === style || 'style09c' === style || 'style11' === style || 'style12' === style || 'style14' === style;

			if ( !isInRow && !isInColumn ) { return ''; }

			if ( isInRow && reverse ) {
				return 'flex-row-reverse';
			} else if ( isInColumn && reverse ) {
				return 'flex-column-reverse';
			} else if ( isInColumn && !reverse ) {
				return 'flex-column';
			}

		}

		function get_tabs_opts() {

			var opts = {};

			if( settings.enable_deeplinks ) {
				opts['deepLink'] = 'true';
			}

			if( settings.tab_trigger ) {
				opts['trigger'] = settings.tab_trigger;
			}

			if ( 'style14' === settings.style ) {
				opts['translateNav'] = 'true';
			}

			return JSON.stringify( opts );

		}

		function get_nav_wrap_classnames() {
			var classname_arr = [],
				style = settings.style ? settings.style : 'style01';

			classname_arr.push('lqd-tabs-nav-wrap');

			if ( settings.show_button ) {
				classname_arr.push('lqd-tabs-nav-has-btn');
			}

			switch (style) {

				case 'style03':
				case 'style04':
				case 'style11':
					classname_arr.push('mb-5');
					break;

				case 'style07':
				case 'style09':
				case 'style09b':
				case 'style10':
					classname_arr.push('mb-6');
					break;

				case 'style09c':
					classname_arr.push('mb-6 pb-2');
					break;
				
				case 'style12':
					classname_arr.push('mb-6');
					break;

			}

			if ( settings.reverse_direction ) {

				if (
					style === 'style07'
					|| style === 'style09'
					|| style === 'style09b'
					|| style === 'style09c'
					|| style === 'style11'
				) {
					classname_arr.pop();
				}

				switch (style) {

					case 'style07':
					case 'style09':
					case 'style09b':
					case 'style12':
						classname_arr.push('mt-6');
						break;

					case 'style09c':
						classname_arr.push('mt-6 pt-2');
						break;

					case 'style11':
						classname_arr.push('mt-5');
						break;

				}

			}

			return classname_arr.join(' ');

		}

		function get_nav_icon(item) {

			const iconHTML = elementor.helpers.renderIcon( view, item.item_icon, {}, 'i' , 'object' );
			const migrated = elementor.helpers.isIconMigrated( item, 'item_icon' );
			let iconMarkup = '';

			if ( iconHTML && ( ! item.item_icon || migrated ) ) {
				iconMarkup = iconHTML.value;
			} else {
				iconMarkup = '<i class="elementor-accordion-icon-closed ' + item.item_icon.value + '"></i>';
			}

			return iconMarkup;

		}

		function get_nav() {

			var out = nav_align = '', 
				style = settings.style ? settings.style : 'style01',
				nav_align = settings.nav_alignment,
				nav_align_style9 = settings.nav_alignment_style9,
				sticky = settings.enable_sticky_nav;

			if( 'style03' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center ' + nav_align + ' pos-rel" role="tablist">';
			}
			else if( 'style04' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap justify-content-between pos-rel" role="tablist">';
			}
			else if( 'style05' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex flex-column justify-content-center pos-rel" role="tablist">';
			}
			else if( 'style06' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex flex-column ' + sticky + ' pos-rel" role="tablist">';
			}
			else if( 'style07' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap justify-content-center pos-rel" role="tablist">';
			}
			else if( 'style08' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex flex-column ' + sticky + ' pos-rel" role="tablist">';
			}
			else if( 'style09' === style || 'style09b' === style || 'style09c' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap ' + nav_align_style9 + ' pos-rel" role="tablist">';
			}
			else if( 'style10' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex flex-wrap align-items-end ' + nav_align + ' pos-rel" role="tablist">';
			}
			else if( 'style11' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap ' + nav_align + ' pos-rel" role="tablist">';
			}
			else if( 'style12' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap ' + nav_align + ' pos-rel" role="tablist">';
			}
			else if( 'style13' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex flex-column pos-rel" role="tablist">';
			}
			else if( 'style14' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center mb-6 pos-rel" role="tablist">';
			}
			else {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap pos-rel" role="tablist">';
			}

			if ( settings.items ) {
				var tabindex = 'lqd-tab-' + view.getIDInt().toString().substr( 0, 3 );
				_.each( settings.items, function( tab, i ) {

					var tabCount = i + 1;

					var classes = [`elementor-repeater-item-${tab._id}`];
					
					classes.push(tabindex + tabCount);

					if ( get_active_tab(tabCount) ) {
						classes.push('active');
					}

					if ( 'style01' === style ) {
						if ( !settings.reverse_direction ) {
							classes.push('mb-5');
						} else {
							classes.push('mt-5');
						}
					} else if ( 'style02' === style ) {
						if ( !settings.reverse_direction ) {
							classes.push('mb-5');
						} else {
							classes.push('mt-5');
						}
					} else if ( 'style03' === style || 'style04' === style ) {
						classes.push('text-center');
					} else if ( 'style06' === style || 'style09b' === style || 'style10' === style ) {
						classes.push('font-weight-medium');
					} else if ( 'style07' === style ) {
						classes.push('font-weight-semibold');
					} else if ( 'style12' === style ) {
						classes.push('mb-3');
					}

					classes = classes ? ' class="' + classes.join(' ') + '"' : '';

					// Tab title
					title = tab.item_title;

					// Nav
					if ( 'style01' === style ) {

						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';

						out += '<span class="lqd-tabs-nav-icon d-flex flex-wrap">';
						if ( tab.item_icon.value ) {
							out += '<span class="lqd-tabs-nav-icon-icon d-flex align-items-center justify-content-center me-5 border-radius-circle">' + get_nav_icon(tab) + '</span>';
						}
						out += '<span class="lqd-tabs-nav-content d-block"><span class="d-block h3 mt-0 mb-3">' + title + '</span>';
						if ( tab.item_description ) {
							out += '<span class="lqd-tabs-nav-desc d-block">' + tab.item_description + '</span>';
						}
						out += '</span></span>';
						out += '</a></li>';

					} else if ( 'style02' === style ) {

						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';

						out += '<span class="lqd-tabs-nav-icon d-flex align-items-center">';
						if ( tab.item_icon.value ) {
							out += '<span class="lqd-tabs-nav-icon-icon d-flex align-items-center justify-content-center me-5 border-radius-circle">' + get_nav_icon(tab) + '</span>';
						}
						out += '<span class="lqd-tabs-nav-content d-block"><span class="d-block h3 mt-0 mb-2">' + title + '</span>';
						if ( tab.item_description ) {
							out += '<span class="lqd-tabs-nav-desc d-block">' + tab.item_description + '</span>';
						}
						out += '</span></span>';
						out += '<span class="lqd-tabs-nav-progress"><span class="lqd-tabs-nav-progress-inner"></span></span>';
						out += '</a></li>';
					} else if ( 'style03' === style || 'style04' === style ) {

						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';

						out += '<span class="lqd-tabs-nav-icon d-block">';
						if ( tab.item_icon.value ) {
							out += '<span class="lqd-tabs-nav-icon-icon border-radius-circle">' + get_nav_icon(tab) + '</span>';
						}
						out += '<span class="lqd-tabs-nav-content d-block"><span class="d-block pos-rel h3 mt-0 mb-0">' + title + '</span>';
						out += '</span></span>';
						out += '<span class="lqd-tabs-nav-progress"><span class="lqd-tabs-nav-progress-inner"></span></span>';
						out += '</a></li>';
					} else if ( 'style05' === style ) {

						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block p-5 border-radius-7" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';

						out += '<span class="lqd-tabs-nav-icon d-flex flex-wrap mb-0">';
						if ( tab.item_icon.value ) {
							out += '<span class="lqd-tabs-nav-icon-icon me-5">' + get_nav_icon(tab) + '</span>';
						}
						out += '<span class="lqd-tabs-nav-content d-block"><span class="d-block h3 mt-0 mb-3">' + title + '</span>';
						if ( tab.item_description ) {
							out += '<span class="lqd-tabs-nav-desc d-block">' + tab.item_description + '</span>';
						}
						out += '</span></span>';

						out += '</a></li>';
					} else if ( 'style06' === style ) {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block pt-3 pb-3 border-radius-4" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						if ( tab.item_icon.value ) {
							out += '<span class="lqd-tabs-nav-icon">' + get_nav_icon(tab) + '</span>';
						}
						out += '<span class="lqd-tabs-nav-txt">' + title + '</span>';
						out += '</a></li>';
					}  else if ( 'style07' === style ) {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block pt-3 pb-3 ps-6 pe-6 border-radius-circle" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						if ( tab.item_icon.value ) {
							out += '<span class="lqd-tabs-nav-icon">' + get_nav_icon(tab) + '</span>';
						}
						out += '<span class="lqd-tabs-nav-txt">' + title + '</span>';
						out += '</a></li>';
					} else if ( 'style08' === style ) {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-flex align-items-center py-1 mb-2" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						out += '<span class="lqd-tabs-nav-txt">' + title + '</span>';
						out += '</a></li>';
					} else if ( 'style10' === style ) {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-flex align-items-center" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						out += '<span class="lqd-tabs-nav-txt">' + title + '</span>';
						out += '</a></li>';
					} else if ( 'style12' === style ) {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-flex align-items-center" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						out += '<span class="lqd-tabs-nav-txt">' + title + '</span>';
						out += '</a></li>';
					} else if ( 'style13' === style ) {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block mb-2" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						out += '<span class="lqd-tabs-nav-txt">' + title + '</span>';
						if ( tab.item_description ) {
							out += '<span class="lqd-tabs-nav-ext">' + tab.item_description + '</span>';
						}
						if ( tab.item_icon.value ) {
							out += '<span class="lqd-tabs-nav-icon">' + get_nav_icon(tab) + '</span>';
						}
						out += '</a></li>';
					} else if ( 'style14' === style ) {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-inline-flex align-items-center border-radius-circle" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						out += '<span class="lqd-tabs-nav-txt" data-txt="' + title + '"><span>' + title + '<span></span>';
						out += '</a>';
						if ( tab.item_description ) {
							out += '<span class="lqd-tabs-nav-ext">' + tab.item_description + '</span>';
						}
						out += '</li>';
					} else {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block" href="#' + tab._id + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						out += '<span class="lqd-tabs-nav-txt">' + title + '</span>';
						out += '</a></li>';
					}

				} );
			}

			out += '</ul>';
			return out;
		}

		function get_content() {

			var out = '',
				style = settings.style;

			if( 'style01' === style ) {
				if ( !settings.reverse_direction ) {
					out += '<div class="lqd-tabs-content pos-rel">';
				} else {
					out += '<div class="lqd-tabs-content pos-rel">';
				}
			} else if( 'style02' === style && settings.reverse_direction ) {
				out += '<div class="lqd-tabs-content pos-rel">';
			} else if( 'style02' === style || 'style03' === style || 'style04' === style ) {
				out += '<div class="lqd-tabs-content pos-rel">';
			} else if( 'style05' === style || 'style06' === style ) {
				if ( settings.reverse_direction ) {
					out += '<div class="lqd-tabs-content pe-5 pos-rel">';
				} else {
					out += '<div class="lqd-tabs-content ps-5 pos-rel">';
				}
			} else if( 'style08' === style || 'style13' === style) {
				if ( settings.reverse_direction ) {
					out += '<div class="lqd-tabs-content pe-6 pos-rel">';
				} else {
					out += '<div class="lqd-tabs-content ps-6 pos-rel">';
				}
			} else {
				out += '<div class="lqd-tabs-content pos-rel">';
			}

			
			if ( settings.items ) {
				var tabindex = 'lqd-tab-' + view.getIDInt().toString().substr( 0, 3 );
				_.each( settings.items, function( tab, i ) {
						var tabCount = i + 1;
						out += '<div id="' + tabindex + tabCount + '" role="tabpanel" class="lqd-tabs-pane fade' + ( get_active_tab(tabCount) && ' active in' ) + '">' + (tab.content_type === 'tinymce' ? tab.item_content : "Template " + tab.templates + " will be display here!" ) + '</div>';
				} );
			} 

			if ( 'style14' === style ) {
				out += '<div class="lqd-tabs-nav-arrows"><button class="lqd-tabs-nav-arrow lqd-tabs-nav-prev d-inline-flex align-items-center justify-content-center border-radius-circle pos-abs"><i class="lqd-icn-ess icon-md-arrow-back"></i></button><button class="lqd-tabs-nav-arrow lqd-tabs-nav-next d-inline-flex align-items-center justify-content-center border-radius-circle pos-abs"><i class="lqd-icn-ess icon-md-arrow-forward"></i></button></div>';
			}

			out += '</div>';
			return out;
		}

		const navExpanded = settings.nav_expand === 'yes' && (settings.style === 'style09' || settings.style === 'style09b' || settings.style === 'style09c');
		const navExpandClassname = ! navExpanded ? 'lqd-tabs-nav-items-not-expanded' : '';

		view.addRenderAttribute( 'wrapperAttributes', {
			'class': [ get_class( settings.style ), navExpandClassname, get_reverse_direction(), `lqd-nav-underline-${settings.nav_underline_width}` ],
			'data-tabs-options': get_tabs_opts(),
		} );

		view.addRenderAttribute( 'navAttributes', {
			'class': [ get_nav_wrap_classnames() ],
		} );

		// Button
		const ib_classes = [
			settings.ib_style,
			settings.ib_i_separator,
			settings.ib_hover_txt_effect,
			settings.ib_size,
			settings.ib_style !== 'btn-plain' && settings.style !== 'btn-underlined' ? settings.width : '',

			settings.ib_link_type === 'lightbox' ? 'fresco' : '',
			
			//Icon classnames
			settings.ib_i_position,
			settings.ib_i_shape,
			settings.ib_i_shape !== '' && settings.ib_i_shape_style !== '' ? settings.ib_i_shape_size : '',
			settings.ib_i_shape !== '' && settings.ib_i_shape_style !== '' ? 'btn-icon-shaped' : '',
			settings.ib_i_shape_style,
			settings.ib_i_shape_bw,	
			settings.ib_i_ripple,
			settings.ib_border_w,
			settings.ib_i_add_icon === 'true' && settings.i_hover_reveal,
			settings.ib_title != '' ? 'btn-has-label' : 'btn-no-label',
		].filter(ib_class => ib_class !== '');

		view.addRenderAttribute( 'buttonAttrs', {
			'class' : [ 'btn', 'elementor-button', ib_classes.join(' ') ],
		});

		const {ib_link_type} = settings;
		let link = settings.ib_link.url;
		let linkAttrs = ``;
		let anchorId = settings.ib_anchor_id === '' ? '#' : settings.ib_anchor_id;

		if ( ib_link_type === 'modal_window' || ib_link_type === 'local_scroll' ) {
			link = anchorId;
		}
		if ( ib_link_type === 'local_scroll' || ib_link_type === 'scroll_to_section' ) {
			linkAttrs += ` data-localscroll="true"`;
		}

		if ( ib_link_type === 'modal_window' ) {
			linkAttrs += ` data-lity="${anchorId}"`;
		} else if ( ib_link_type === 'local_scroll' )  {
			linkAttrs += ` data-localscroll="true"`;
			if ( settings.scroll_speed !== '' ) {
				linkAttrs += ` data-localscroll-options='{"scrollSpeed": ${settings.ib_scroll_speed}}'`
			}
		} else if ( ib_link_type === 'scroll_to_section' ) {
			linkAttrs += ` data-localscroll-options='{"scrollBelowSection": true}'`
		}

		const {ib_hover_txt_effect} = settings;
		let hoverEffectAttrs = ``;
		
		switch( ib_hover_txt_effect ) {
			case 'btn-hover-txt-liquid-x':
				hoverEffectAttrs += `data-transition-delay="true" data-delay-options='{"elements": ".lqd-chars", "delayType": "animation", "delayBetween": 32.5}' data-split-text="true" data-split-options='{"type": "chars, words"}'`;
			break;
			
			case 'btn-hover-txt-liquid-x-alt':
				hoverEffectAttrs += `data-transition-delay="true" data-delay-options='{"elements": ".lqd-chars", "delayType": "animation", "delayBetween": 32.5, "reverse": true}' data-split-text="true" data-split-options='{"type": "chars, words"}'`;
			break;
			
			case 'btn-hover-txt-liquid-y':
				hoverEffectAttrs += `data-transition-delay="true" data-delay-options='{"elements": ".lqd-chars", "delayType": "animation", "delayBetween": 32.5}' data-split-text="true" data-split-options='{"type": "chars, words"}'`;
			break;

			case 'btn-hover-txt-liquid-y-alt':
				hoverEffectAttrs += `data-transition-delay="true" data-delay-options='{"elements": ".lqd-chars", "delayType": "animation", "delayBetween": 32.5}' data-split-text="true" data-split-options='{"type": "chars, words"}'`;
			break;
			default:
				'';
			break;
		}

		function get_button(){

			if( settings.show_button === 'yes' &&  ( settings.style === 'style05' || settings.style === 'style06' || settings.style === 'style08' || settings.style === 'style11' || settings.style === 'style12' || settings.style === 'style13') ){
			var out = `<div class="lqd-tabs-nav-btn-wrap">
				<a 
				href="${link.trim()}"
				${view.getRenderAttributeString('buttonAttrs')}
				data-fresco-caption="${settings.ib_image_caption}"
				${linkAttrs}
				>`;
					if ( settings.ib_title ) {
						out += `<span class="btn-txt" data-text="${settings.ib_title}" ${hoverEffectAttrs} > ${settings.ib_title} </span>`;
					}

					if ( settings.ib_i_add_icon ) {
						out += `<span class="btn-icon"><i class="${settings.ib_icon.value}"></i></span>`;
					}

					if ( 'btn-hover-swp' === settings.ib_i_hover_reveal && settings.ib_i_add_icon ) {
						out += `<span class="btn-icon"><i class="${settings.ib_icon.value}"></i></span>`;
					}
				out += `</a>
			</div>`;
			return out;
			}
		}
		
		#>

		<div {{{ view.getRenderAttributeString( 'wrapperAttributes' ) }}}>
			<nav {{{ view.getRenderAttributeString( 'navAttributes' ) }}}>
				{{{ get_nav() }}}
				{{{ get_button() }}}
			</nav>
			{{{ get_content() }}}
		</div>
	<?php
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Tabs() );