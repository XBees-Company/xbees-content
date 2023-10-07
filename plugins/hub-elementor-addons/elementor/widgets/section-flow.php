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
use Elementor\Plugin;

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
class LD_Section_Flow extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script( 'liquid-section-flow', get_template_directory_uri() . '/assets/js/section-flow/liquidSectionFlow.min.js', [], LD_ELEMENTOR_VERSION, true );

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

		return [ 'liquid-section-flow' ];

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
		return 'ld_section_flow';
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
		return __( 'Liquid Section Flow', 'hub-elementor-addons' );
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
		return 'eicon-posts-group lqd-element';
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
		return [ 'section', 'flow' ];
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
				'label' => __( 'Section Flow', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'left_heading',
			[
				'label' => esc_html__( 'Left side', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$repeater->add_control(
			'left_content',
			[
				'label' => esc_html__( 'Content type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'image'  => esc_html__( 'Image', 'hub-elementor-addons' ),
					'text' => esc_html__( 'Text', 'hub-elementor-addons' ),
					'template' => esc_html__( 'Template', 'hub-elementor-addons' ),
				],
			]
		);

		$repeater->add_control(
			'left_image',
			[
				'label' => esc_html__( 'Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'left_content' => 'image'
				]
			]
		);

		$repeater->add_responsive_control(
			'left_image_height',
			[
				'label' => esc_html__( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
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
					'{{WRAPPER}} .lqd-section-flow-panel-start {{CURRENT_ITEM}} .lqd-section-flow-item-inner' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lqd-section-flow-panel-start {{CURRENT_ITEM}} img' => 'height: 100%;',
				],
				'condition' => [
					'left_content' => 'image'
				]
			]
		);

		$repeater->add_responsive_control(
			'left_image_object-fit',
			[
				'label' => esc_html__( 'Object Fit', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'hub-elementor-addons' ),
					'fill' => esc_html__( 'Fill', 'hub-elementor-addons' ),
					'cover' => esc_html__( 'Cover', 'hub-elementor-addons' ),
					'contain' => esc_html__( 'Contain', 'hub-elementor-addons' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-section-flow-panel-start {{CURRENT_ITEM}} img' => 'object-fit: {{VALUE}};',
				],
				'condition' => [
					'left_content' => 'image',
					'left_image_height[size]!' => '',
				]
			]
		);

		$repeater->add_control(
			'left_image_link',
			[
				'label' => esc_html__( 'Image external link', 'textdomain' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'textdomain' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'label_block' => true,
				'condition' => [
					'left_content' => 'image'
				]
			]
		);

		$repeater->add_control(
			'left_title', [
				'label' => esc_html__( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Title' , 'hub-elementor-addons' ),
				'label_block' => true,
				'condition' => [
					'left_content' => 'text'
				]
			]
		);

		$repeater->add_control(
			'left_subtitle', [
				'label' => esc_html__( 'Subtitle', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 2,
				'default' => esc_html__( 'Subtitle' , 'hub-elementor-addons' ),
				'label_block' => true,
				'condition' => [
					'left_content' => 'text'
				]
			]
		);

		$repeater->add_control(
			'left_template',
			[
				'label' => __( 'Select Template', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $this->get_block_posts(),
				'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Elementor Templates</a> to manage your elements.', 'hub-elementor-addons' ), admin_url( 'edit.php?post_type=elementor_library&tabs_group=library' ) ),
				'condition' => [
					'left_content' => 'template'
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'left_title_typography',
				'label' => esc_html__( 'Title typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-section-flow-panel-start {{CURRENT_ITEM}} .lqd-section-flow-title',
				'condition' => [
					'left_content' => 'text'
				]
			]
		);

		$repeater->add_control(
			'left_title_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-section-flow-panel-start {{CURRENT_ITEM}} .lqd-section-flow-title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'left_content' => 'text'
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'left_subtitle_typography',
				'label' => esc_html__( 'Subtitle typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-section-flow-panel-start {{CURRENT_ITEM}} .lqd-section-flow-subtitle',
				'condition' => [
					'left_content' => 'text'
				]
			]
		);

		$repeater->add_control(
			'left_subtitle_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-section-flow-panel-start {{CURRENT_ITEM}} .lqd-section-flow-subtitle' => 'color: {{VALUE}}',
				],
				'condition' => [
					'left_content' => 'text'
				]
			]
		);

		$repeater->add_responsive_control(
			'left_padding',
			[
				'label' => esc_html__( 'Padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-section-flow-panel-start {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'left_content!' => 'template'
				]
			]
		);

		// right
		$repeater->add_control(
			'right_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$repeater->add_control(
			'right_heading',
			[
				'label' => esc_html__( 'Right side', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$repeater->add_control(
			'right_content',
			[
				'label' => esc_html__( 'Content type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'text',
				'options' => [
					'image'  => esc_html__( 'Image', 'hub-elementor-addons' ),
					'text' => esc_html__( 'Text', 'hub-elementor-addons' ),
					'template' => esc_html__( 'Template', 'hub-elementor-addons' ),
				],
			]
		);

		$repeater->add_control(
			'right_image',
			[
				'label' => esc_html__( 'Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'right_content' => 'image'
				]
			]
		);

		$repeater->add_responsive_control(
			'right_image_height',
			[
				'label' => esc_html__( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
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
					'{{WRAPPER}} .lqd-section-flow-panel-end {{CURRENT_ITEM}} .lqd-section-flow-item-inner' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lqd-section-flow-panel-end {{CURRENT_ITEM}} img' => 'height: 100%;',
				],
				'condition' => [
					'right_content' => 'image'
				]
			]
		);

		$repeater->add_responsive_control(
			'right_image_object-fit',
			[
				'label' => esc_html__( 'Object Fit', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'hub-elementor-addons' ),
					'fill' => esc_html__( 'Fill', 'hub-elementor-addons' ),
					'cover' => esc_html__( 'Cover', 'hub-elementor-addons' ),
					'contain' => esc_html__( 'Contain', 'hub-elementor-addons' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-section-flow-panel-end {{CURRENT_ITEM}} img' => 'object-fit: {{VALUE}};',
				],
				'condition' => [
					'right_content' => 'image',
					'right_image_height[size]!' => '',
				]
			]
		);

		$repeater->add_control(
			'right_image_link',
			[
				'label' => esc_html__( 'Image external link', 'textdomain' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'textdomain' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'label_block' => true,
				'condition' => [
					'right_content' => 'image'
				]
			]
		);

		$repeater->add_control(
			'right_title', [
				'label' => esc_html__( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Title' , 'hub-elementor-addons' ),
				'label_block' => true,
				'condition' => [
					'right_content' => 'text'
				]
			]
		);

		$repeater->add_control(
			'right_subtitle', [
				'label' => esc_html__( 'Subtitle', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 2,
				'default' => esc_html__( 'Subtitle' , 'hub-elementor-addons' ),
				'label_block' => true,
				'condition' => [
					'right_content' => 'text'
				]
			]
		);

		$repeater->add_control(
			'right_template',
			[
				'label' => __( 'Select Template', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $this->get_block_posts(),
				'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Elementor Templates</a> to manage your elements.', 'hub-elementor-addons' ), admin_url( 'edit.php?post_type=elementor_library&tabs_group=library' ) ),
				'condition' => [
					'right_content' => 'template'
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'right_title_typography',
				'label' => esc_html__( 'Title typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-section-flow-panel-end {{CURRENT_ITEM}} .lqd-section-flow-title',
				'condition' => [
					'right_content' => 'text'
				]
			]
		);

		$repeater->add_control(
			'right_title_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-section-flow-panel-end {{CURRENT_ITEM}} .lqd-section-flow-title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'right_content' => 'text'
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'right_subtitle_typography',
				'label' => esc_html__( 'Subtitle typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-section-flow-panel-end {{CURRENT_ITEM}} .lqd-section-flow-subtitle',
				'condition' => [
					'right_content' => 'text'
				]
			]
		);

		$repeater->add_control(
			'right_subtitle_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-section-flow-panel-end {{CURRENT_ITEM}} .lqd-section-flow-subtitle' => 'color: {{VALUE}}',
				],
				'condition' => [
					'right_content' => 'text'
				]
			]
		);

		$repeater->add_responsive_control(
			'right_padding',
			[
				'label' => esc_html__( 'Padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-section-flow-panel-end {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'right_content!' => 'template'
				]
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'left_image' => Utils::get_placeholder_image_src(),
						'right_title' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur ad, ratione odit fugit doloremque!', 'hub-elementor-addons' ),
						'right_subtitle' => esc_html__( '- Apple taste test participant', 'hub-elementor-addons' ),
					],
					[
						'left_image' => Utils::get_placeholder_image_src(),
						'right_title' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur ad, ratione odit fugit doloremque!', 'hub-elementor-addons' ),
						'right_subtitle' => esc_html__( '- Apple taste test participant', 'hub-elementor-addons' ),
					],
				],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'elementor-pro' ),
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
				'separator' => 'before',
			]
		);

		$this->add_control(
			'subtitle_tag',
			[
				'label' => esc_html__( 'Subtitle HTML Tag', 'elementor-pro' ),
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
				'default' => 'h6',
			]
		);

		$this->end_controls_section();

		// Style
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'flow_heading',
			[
				'label' => esc_html__( 'General Styles', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-section-flow-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Subtitle Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-section-flow-subtitle',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'flow_background',
				'label' => esc_html__( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-section-flow',
			]
		);

		$this->add_control(
			'flow_start_heading',
			[
				'label' => esc_html__( 'Flow Left Styles', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'flow_start_padding',
			[
				'label' => esc_html__( 'Padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-section-flow-panel-start' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'flow_start_border',
				'label' => esc_html__( 'Border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-section-flow-panel-end',
			]
		);

		$this->add_control(
			'flow_end_heading',
			[
				'label' => esc_html__( 'Flow Right Styles', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'flow_end_padding',
			[
				'label' => esc_html__( 'Padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-section-flow-panel-end' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'flow_end_border',
				'label' => esc_html__( 'Border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-section-flow-panel-end',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Get elementor templates
	 */
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
	 * Get content by repeater item
	 */
	protected function get_flow_section_content( $item, $col ) {

		$title_tag = Utils::validate_html_tag( $this->get_settings_for_display( 'title_tag') );
		$subtitle_tag = Utils::validate_html_tag( $this->get_settings_for_display( 'subtitle_tag') );

		if ( $item[ $col . '_content' ] === 'image' ){
			$this->add_render_attribute(  $col . '_image', 'alt', Control_Media::get_image_alt( $item[ $col . '_image' ] ) );
			$this->add_render_attribute(  $col . '_image', 'title', Control_Media::get_image_title( $item[ $col . '_image' ] ) );
			$this->add_render_attribute(  $col . '_image', 'class', 'w-100' );

			if ( ! empty( $item[ $col . '_image_link']['url'] ) ) {
				$this->add_link_attributes( $item['_id'] . '_link', $item[ $col . '_image_link'] );
				printf( '<a %s>', $this->get_render_attribute_string( $item['_id'] . '_link' ) );
			}

			echo Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail',  $col . '_image' );

			if ( ! empty( $item[ $col . '_image_link']['url'] ) ) {
				echo '</a>';
			}

		} elseif ( $item[ $col . '_content' ] === 'text' ){
			if ( $item[ $col . '_title' ] ){
				printf( '<%1$s class="lqd-section-flow-title">%2$s</%1$s>', $title_tag, $item[ $col . '_title' ] );
			}
			if ( $item[ $col . '_subtitle' ] ){
				printf( '<%1$s class="lqd-section-flow-subtitle">%2$s</%1$s>', $subtitle_tag, $item[ $col . '_subtitle' ] );
			}
		} else {
			echo Plugin::instance()->frontend->get_builder_content( $item[ $col . '_template' ], true );
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

		if ( $settings['items'] ){
		?>

		<div class="lqd-section-flow flex-wrap" data-lqd-section-flow="true">
			<div class="lqd-section-flow-panel lqd-section-flow-panel-start col-lg-6 ps-0 pe-0">
				<div class="lqd-section-flow-panel-start-inner pos-sticky pos-tl">
					<?php foreach( $settings['items'] as $item ) : ?>
					<div class="lqd-section-flow-item pos-abs pos-tl w-100 overflow-hidden <?php echo esc_attr( 'elementor-repeater-item-' . $item['_id'] ) ?>">
						<div class="lqd-section-flow-item-inner">
						<?php $this->get_flow_section_content( $item, 'left' ); ?>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="lqd-section-flow-panel lqd-section-flow-panel-end col-lg-6 ps-0 pe-0">
				<?php foreach( $settings['items'] as $item ) : ?>
				<div class="lqd-section-flow-item d-flex align-items-center <?php echo esc_attr( 'elementor-repeater-item-' . $item['_id'] ) ?>">
					<div class="lqd-section-flow-item-inner">
						<div class="lqd-section-flow-content-mobile">
							<?php $this->get_flow_section_content( $item, 'left' ); ?>
						</div>
					<?php $this->get_flow_section_content( $item, 'right' ); ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>

		<?php
		}

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Section_Flow() );