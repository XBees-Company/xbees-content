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
class LD_Schedule_Table extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
  
		wp_register_script( 'liquid-table-vendors', str_replace('/elementor/widgets', '', plugins_url( '/assets/js/widgets', __FILE__ )) . '/liquidEventsTable-vendors.min.js', [ 'jquery' ], LD_ELEMENTOR_VERSION, true );
		wp_register_script( 'liquid-table', str_replace('/elementor/widgets', '', plugins_url( '/assets/js/widgets', __FILE__ )) . '/liquidEventsTable.min.js', [ 'jquery' ], LD_ELEMENTOR_VERSION, true );
		wp_register_style( 'liquid-schedule-table', str_replace('/elementor/widgets', '', plugins_url( '/assets/css/widgets', __FILE__ )) . '/liquid-events-table.min.css', [], LD_ELEMENTOR_VERSION );
	 
	}

	 /**
	 * Retrieve the list of style the counter widget depended on.
	 *
	 * Used to set style dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_style_depends() {

		return [ 'liquid-schedule-table' ];

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

		return [ 'liquid-table-vendors', 'liquid-table' ];

	}

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
		return 'ld_schedule_table';
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
		return __( 'Liquid Schedule Table', 'hub-elementor-addons' );
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
		return 'eicon-calendar lqd-element';
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
		return [ 'calendar', 'events', 'schedule', 'table' ];
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
			[
				'label' => __( 'General', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		// Title
		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Schedule', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'title_tag',
			array(
				'label' => esc_html__( 'Title HTML Tag', 'hub-elementor-addons' ),
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
			)
		);

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your description here', 'hub-elementor-addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'info', [
				'label' => esc_html__( 'Info', 'hub-elementor-addons' ),
				'description' => esc_html__( 'Add name/couch/trainer/teacher', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'category', [
				'label' => esc_html__( 'Category', 'hub-elementor-addons' ),
				'description' => esc_html__( 'Add category for this cell', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'content', [
				'label' => esc_html__( 'Content', 'hub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
			]
		);

		$repeater->add_control(
			'day',
			[
				'label' => __( 'Day of the Week', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'Monday',
				'options' => [
					'Sunday' => __( 'Sunday', 'hub-elementor-addons' ),
					'Monday' => __( 'Monday', 'hub-elementor-addons' ),
					'Tuesday' => __( 'Tuesday', 'hub-elementor-addons' ),
					'Wednesday' => __( 'Wednesday', 'hub-elementor-addons' ),
					'Thursday' => __( 'Thursday', 'hub-elementor-addons' ),
					'Friday' => __( 'Friday', 'hub-elementor-addons' ),
					'Saturday' => __( 'Saturday', 'hub-elementor-addons' ),
				],
			]
		);

		$repeater->add_control(
			'from_time', [
				'label' => esc_html__( 'From Time', 'hub-elementor-addons' ),
				'description' => esc_html__( 'Add From time for ex. 08:00', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'to_time', [
				'label' => esc_html__( 'To Time', 'hub-elementor-addons' ),
				'description' => esc_html__( 'Add To time for ex. 10:00', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'btn_label', [
				'label' => esc_html__( 'Button Label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'URL (Link)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'hub-elementor-addons' ),
				'default' => [
					'url' => '',
				],
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Cells', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => 'Body Union',
						'info' => 'Jesse Willis',
						'category' => 'Meet',
						'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
						'day' => 'Monday',
						'from_time' => '08:00',
						'to_time' => '10:00',
						'btn_label' => 'Join Now',
						'link' => '#'
					],
					[
						'title' => 'Meditation',
						'info' => 'Katharine Barnes',
						'category' => 'Meet',
						'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
						'day' => 'Tuesday',
						'from_time' => '10:00',
						'to_time' => '12:00',
						'btn_label' => 'Join Now',
						'link' => '#'
					],
				],
				'title_field' => '{{{ title }}}',
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

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .section-title-title',				
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Content color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title-content' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .section-title-content',
			]
		);

		$this->add_control(
			'table_heading_row_heading',
			[
				'label' => __( 'Table heading row', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_heading_row',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'selector' => '{{WRAPPER}} .liquid-st-day',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_row_typography',
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-st-row-days .liquid-st-cell-inner',
			]
		);

		$this->add_control(
			'table_heading_row_text_color',
			[
				'label' => __( 'Text color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-st-row-days .liquid-st-cell-inner' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'cell_border',
				'label' => esc_html__( 'Cell border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-st-cell',
				'separator' => 'before',
			]
		);


		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'cells_style_section',
			[
				'label' => __( 'Cells Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cells_title_color',
			[
				'label' => __( 'Title color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-st-cell strong,{{WRAPPER}} .liquid-st-cell-details .btn' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'cells_hover_title_color',
			[
				'label' => __( 'Cells hover texts color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-st-cell:hover:not(.liquid-st-day):not(.liquid-st-time) .liquid-st-cell-inner strong,{{WRAPPER}} .liquid-st-cell:hover span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cells_title_typo',
				'label' => __( 'Cells title typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-st-cell .liquid-st-cell-inner',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'gr_color_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'gr_color_heading',
			[
				'label' => __( 'Cell backgorund color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'gr_color',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'selector' => '{{WRAPPER}} .liquid-st-cell',
			]
		);

		$this->add_control(
			'gr_color_hover_heading',
			[
				'label' => __( 'Cell hover backgorund color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'gr_hover_color',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'selector' => '{{WRAPPER}} .liquid-st-cell:before',
			]
		);

		$this->add_control(
			'cells_time_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'cells_time_color',
			[
				'label' => __( 'Cells time color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-st-time .liquid-st-cell-inner' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cells_time_typography',
				'label' => __( 'Cells time typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-st-time .liquid-st-cell-inner',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'cells_details_style_section',
			[
				'label' => __( 'Cells Details Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'cells_details_width',
			[
				'label' => esc_html__( 'Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .liquid-st-cell-details' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'cells_details_height',
			[
				'label' => esc_html__( 'Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .liquid-st-cell-details' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cells_details_padding',
			[
				'label' => esc_html__( 'Padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .liquid-st-cell-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'cells_details_border',
				'label' => esc_html__( 'Border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-st-cell-details',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'cells_details_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .liquid-st-cell-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'cells_details_bg_heading',
			[
				'label' => __( 'Cell details backgorund', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'cells_details_bg',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'selector' => '{{WRAPPER}} .liquid-st-cell-details',
			]
		);

		$this->add_control(
			'cells_details_title_color',
			[
				'label' => __( 'Title color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-st-cell-details h5' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cells_details_title_typo',
				'label' => __( 'Title typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-st-cell-details h5',
			]
		);

		$this->add_control(
			'cells_details_info_color',
			[
				'label' => __( 'Info color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-st-cell-details .cell-details-head span' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cells_details_info_typo',
				'label' => __( 'Info typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-st-cell-details .cell-details-head span',
			]
		);

		$this->add_control(
			'cells_details_content_color',
			[
				'label' => __( 'Content color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-st-cell-details p' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cells_details_content_typo',
				'label' => __( 'Content typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-st-cell-details p',
			]
		);

		$this->add_control(
			'cells_details_btn_color',
			[
				'label' => __( 'Button color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-st-cell-details .btn-txt' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'cells_details_btn_h_color',
			[
				'label' => __( 'Button hover color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-st-cell-details .btn-txt:hover' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cells_details_btn_typo',
				'label' => __( 'Button typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-st-cell-details .btn-txt',
			]
		);

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'categories_style_section',
			[
				'label' => __( 'Categories Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'categories_bg',
			[
				'label' => __( 'Dropdown backgorund color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-st .ui-selectmenu-button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'categories_text_color',
			[
				'label' => __( 'Dropdown text color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-st .ui-selectmenu-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'categories_text_typo',
				'label' => __( 'Dropdown text typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-st .ui-selectmenu-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'categories_text_border',
				'label' => esc_html__( 'Border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-st .ui-selectmenu-button',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'categories_text_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .liquid-st .ui-selectmenu-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function get_filter_cats( $id, $items ) {

		if ( ! $items ) {
			return;
		}
		
		$cells = array();
		foreach( $items as $i => $cell ) {
			$cells[] = $cell['category'];
		}
		$cells = array_unique( $cells );
		echo '<select class="liquid-schedule-filter" name="' . $id . '" id="' . $id . '">';
			echo '<option value="*">'. esc_html__( 'All Classes', 'liquid-events' ) . '</option>';
			foreach( $cells as $i => $cell ) {
				echo '<option value="' . esc_attr( sanitize_title( $cell ) ) . '">' . esc_html( $cell ) . '</option>';
			}
		echo '</select>';
		
	}

	protected function get_opts( $item ) {

		if ( ! $item ) {
			return;
		}
		
		extract( $item );
		
		$opts = array();
		$opts['day'] = $day;
		$opts['time'] = $from_time . ' - ' . $to_time;
		if( !empty( $title ) ) {
			$opts['name'] = esc_html( $title );
		}
		if( !empty( $info ) ) {
			$opts['info'] = esc_html( $info );
		}
		if( !empty( $content ) ) {
			$opts['description'] = $content;
		}
		if( !empty( $btn_label ) ) {
			$opts['buttonText'] = esc_html( $btn_label );
		}
	    // Link
	    if ( isset( $link['url'] )  ) {
		    $opts['buttonLink'] = esc_url( $link['url'] );
	    }
		if( !empty( $category ) ) {
			$opts['category'] = esc_html( sanitize_title( $category ) );
		}

		echo 'data-st-cell=\'' . wp_json_encode( $opts ) . '\'';

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
		$filter_id = uniqid( 'liquid-st-' );	

		?> 

		<div id="<?php echo esc_attr( 'liquid-st-' . $this->get_id() ); ?>" class="liquid-st">
			
			<form action="#" class="row liquid-st-header">
				
				<div class="col-md-9">
					<header class="section-title">
						<?php 
							if ( ! empty( $settings['title'] ) ) {
								printf( '<%1$s class="section-title-title">%2$s</%1$s>', $settings['title_tag'], esc_html( $settings['title'] ) ); 
							}
							if ( ! empty( $settings['description'] ) ) {
								printf( '<p class="section-title-content">%s</p>', wp_kses_post( $settings['description'] ) );
							}
						?>
					</header>
				</div>
				
				<div class="col-md-3 text-right">
					<?php $this->get_filter_cats( $filter_id, $settings['items'] ); ?>
				</div>
				
			</form>
			
			<div class="liquid-st-container">
				<div class="liquid-st-inner" data-liquid-schedule-table="true" data-radial-reaction="true" data-filterable-table="true" data-filterable-table-options='{ "filterID": "#<?php echo esc_attr( $filter_id ) ?>" }'>
					<?php foreach ( $settings['items'] as $item ) : ?>
						<div class="liquid-st-cell" <?php $this->get_opts( $item ); ?>></div>
					<?php endforeach; ?>
				</div>
			</div>
			
		</div>

		<?php
		
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Schedule_Table() );