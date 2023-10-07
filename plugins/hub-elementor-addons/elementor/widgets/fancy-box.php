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
class LD_Content_Box extends Widget_Base {

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
		return 'ld_content_box';
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
		return __( 'Liquid Box', 'hub-elementor-addons' );
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
		return 'eicon-info-box lqd-element';
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
		return [ 'box', 'image'  ];
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
		return array();
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
			'template',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 's01',
				'options' => [
					's01' => __( 'Style 1', 'hub-elementor-addons' ),
					's01a' => __( 'Style 1 A', 'hub-elementor-addons' ),
					's01b' => __( 'Style 1 B', 'hub-elementor-addons' ),
					's02' => __( 'Style 2', 'hub-elementor-addons' ),
					's03' => __( 'Style 3', 'hub-elementor-addons' ),
					's04' => __( 'Style 4', 'hub-elementor-addons' ),
					's05' => __( 'Style 5', 'hub-elementor-addons' ),
					's06' => __( 'Style 6', 'hub-elementor-addons' ),
					's07' => __( 'Style 7', 'hub-elementor-addons' ),
					's08' => __( 'Style 8', 'hub-elementor-addons' ),
					's09' => __( 'Style 9', 'hub-elementor-addons' ),
					's10' => __( 'Style 10', 'hub-elementor-addons' ),
					's11' => __( 'Style 11', 'hub-elementor-addons' ),
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
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-fb-content .lqd-fb__title',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title Element Tag', 'hub-elementor-addons' ),
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
			'use_inheritance',
			[
				'label' => __( 'Inherit font styles?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'tag_to_inherite',
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
					'p' => 'p',
				],
				'default' => 'h1',
				'condition' => [
					'use_inheritance' => 'true',
				],
			]
		);

		$this->add_control(
			'title_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => __( 'Subtitle', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Subtitle', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your subtitle here', 'hub-elementor-addons' ),
				'condition' => [
					'template' => 's06'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => __( 'Subtitle Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} h6',
				'condition' => [
					'template' => 's06'
				]
			]
		);

		$this->add_control(
			'content_alignment',
			[
				'label' => __( 'Content Alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'lqd-fb-content-br' => __( 'Bottom Right', 'hub-elementor-addons' ),
					'lqd-fb-content-bc' => __( 'Bottom Center', 'hub-elementor-addons' ),
					'lqd-fb-content-mid' => __( 'Middle', 'hub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's08'
				]
			]
		);

		$this->add_control(
			'ct_width',
			[
				'label' => __( 'Content Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'w-60',
				'options' => [
					'w-50' => __( '50%', 'hub-elementor-addons' ),
					'w-60' => __( '60%', 'hub-elementor-addons' ),
					'w-70' => __( '70%', 'hub-elementor-addons' ),
					'w-80' => __( '80%', 'hub-elementor-addons' ),
					'w-90' => __( '90%', 'hub-elementor-addons' ),
					'w-100' => __( '100%', 'hub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's08'
				],
			]
		);

		$this->add_control(
			'ct_alignment',
			[
				'label' => __( 'Content Alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'text-center',
				'options' => [
					'text-center' => __( 'Default', 'hub-elementor-addons' ),
					'text-left' => __( 'Left', 'hub-elementor-addons' ),
					'text-right' => __( 'Right', 'hub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's09'
				]
			]
		);

		$this->add_control(
			'box_height',
			[
				'label' => __( 'Box Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h-pt-50',
				'options' => [
					'h-pt-50' => __( '50%', 'hub-elementor-addons' ),
					'h-pt-60' => __( '60%', 'hub-elementor-addons' ),
					'h-pt-70' => __( '70%', 'hub-elementor-addons' ),
					'h-pt-80' => __( '80%', 'hub-elementor-addons' ),
					'h-pt-90' => __( '90%', 'hub-elementor-addons' ),
					'h-pt-100' => __( '100%', 'hub-elementor-addons' ),
					'h-custom' => __( 'Custom', 'hub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's01'
				]
			]
		);

		$this->add_responsive_control(
			'box_height_custom',
			[
				'label' => __( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'condition' => [
					'box_height' => 'h-custom',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-fb' => 'height: {{SIZE}}{{UNIT}}; padding: 0 !important;',
				]
			]
		);

		$this->add_control(
			'box_height_a',
			[
				'label' => __( 'Box Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h-pt-100',
				'options' => [
					'h-pt-50' => __( '50%', 'hub-elementor-addons' ),
					'h-pt-60' => __( '60%', 'hub-elementor-addons' ),
					'h-pt-70' => __( '70%', 'hub-elementor-addons' ),
					'h-pt-80' => __( '80%', 'hub-elementor-addons' ),
					'h-pt-100' => __( '100%', 'hub-elementor-addons' ),
					'h-custom' => __( 'Custom', 'hub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's01a'
				]
			]
		);

		$this->add_responsive_control(
			'box_height_custom_a',
			[
				'label' => __( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'condition' => [
					'box_height_a' => 'h-custom',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-fb' => 'height: {{SIZE}}{{UNIT}}; padding: 0 !important;',
				]
			]
		);

		$this->add_control(
			'box_height_b',
			[
				'label' => __( 'Box Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h-pt-80',
				'options' => [
					'h-pt-50' => __( '50%', 'hub-elementor-addons' ),
					'h-pt-60' => __( '60%', 'hub-elementor-addons' ),
					'h-pt-70' => __( '70%', 'hub-elementor-addons' ),
					'h-pt-80' => __( '80%', 'hub-elementor-addons' ),
					'h-pt-100' => __( '100%', 'hub-elementor-addons' ),
					'h-custom' => __( 'Custom', 'hub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's01b'
				]
			]
		);

		$this->add_responsive_control(
			'box_height_custom_b',
			[
				'label' => __( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'condition' => [
					'box_height_b' => 'h-custom',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-fb' => 'height: {{SIZE}}{{UNIT}}; padding: 0 !important;',
				]
			]
		);

		$this->add_control(
			'box_height_6',
			[
				'label' => __( 'Box Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h-pt-125',
				'options' => [
					'h-pt-50' => __( '50%', 'hub-elementor-addons' ),
					'h-pt-60' => __( '60%', 'hub-elementor-addons' ),
					'h-pt-70' => __( '70%', 'hub-elementor-addons' ),
					'h-pt-80' => __( '80%', 'hub-elementor-addons' ),
					'h-pt-90' => __( '90%', 'hub-elementor-addons' ),
					'h-pt-100' => __( '100%', 'hub-elementor-addons' ),
					'h-pt-125' => __( '125%', 'hub-elementor-addons' ),
					'h-custom' => __( 'Custom', 'hub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's06'
				]
			]
		);

		$this->add_responsive_control(
			'box_height_custom_6',
			[
				'label' => __( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'condition' => [
					'box_height_6' => 'h-custom',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-fb' => 'height: {{SIZE}}{{UNIT}}; padding: 0 !important;',
				]
			]
		);

		$this->add_control(
			'label',
			[
				'label' => __( 'Label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Label', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your label here', 'hub-elementor-addons' ),
				'condition' => [
					'template' => [
						's01', 's01b', 's03'
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Label Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-fb-content h6',
				'condition' => [
					'template' => [
						's01', 's01b', 's03'
					]
				]
			]
		);

		$this->add_responsive_control(
			'label_padding',
			[
				'label' => __( 'Label Padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content h6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => array(
					'template' => [
						's01', 's01b', 's03'
					]
				),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'template!' => ['s10']
				],
			]
		);


		$this->add_control(
			'img_link',
			[
				'label' => __( 'Link', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'text_hr',
			[
				'type' => Controls_Manager::DIVIDER,
				'condition' => [
					'template' => [
						's01', 's01a', 's01b', 's02', 's04', 's05', 's06', 's10'
					]
				]
			]
		);

		$this->add_control(
			'content2',
			[
				'label' => __( 'Text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Type your text here', 'hub-elementor-addons' ),
				'condition' => [
					'template' => [
						's01', 's01a', 's01b', 's02', 's04', 's05', 's06', 's10'
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} p',
				'condition' => [
					'template' => [
						's01', 's01a', 's01b', 's02', 's04', 's05', 's06', 's10'
					]
				]
			]
		);

		$this->add_control(
			'i_type',
			[
				'label' => __( 'Icon Library', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fontawesome',
				'options' => [
					'fontawesome'  => __( 'Icon Library', 'hub-elementor-addons' ),
					//'image' => __( 'Image', 'hub-elementor-addons' ),
				],
				'condition' => [
					'template' => [ 's06', 's08' ],
				],
			]
		);

		$this->add_control(
			'i_icon_fontawesome',
			[
				'label' => __( 'Icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-star',
					'library' => 'solid',
				],
				'condition' => [
					'template' => [ 's06', 's08' ],
				],
			]
		);
		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style Section', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_color_heading',
			[
				'label' => __( 'Overlay color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'template!' => [
						's04', 's05', 's07', 's08', 's10'
					]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_color',
				'label' => __( 'Hover image overlay color', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-fb-bg',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'template!' => [
						's04', 's05', 's07', 's08', 's10', 's11'
					]
				],
			]
		);


		$this->add_control(
			'overlay_hcolor_heading',
			[
				'label' => __( 'Hover image overlay color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'template!' => [
						's04', 's05', 's07', 's08', 's10'
					]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_hcolor',
				'label' => __( 'Hover image overlay color', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-fb-hover-overlay',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'template!' => [
						's08', 's10'
					]
				],
			]
		);

		$this->add_control(
			'content_bg',
			[
				'label' => __( 'Content background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content' => 'background: {{VALUE}}',
				],
				'condition' => [
					'template!' => [
						's10'
					]
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'revealer_color',
			[
				'label' => __( 'Revealer color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-revealer__element' => 'background: {{VALUE}}',
				],
				'condition' => [
					'template!' => [
						's02', 's03', 's08'
					]
				]
			]
		);

		$this->add_control(
			'hover_revealer_color',
			[
				'label' => __( 'Hover revealer color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-revealer__element:before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'template' => [
						's08'
					]
				]
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Heading color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content .lqd-fb__title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-fb__title i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_hcolor',
			[
				'label' => __( 'Hover heading color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb:hover .lqd-fb-content .lqd-fb__title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-fb:hover .lqd-fb__title i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Content color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => __( 'Subtitle color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-style-6 h6' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => [
						's06'
					]
				]
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => [
						's08'
					]
				]
			]
		);

		$this->add_control(
			'hover_icon_color',
			[
				'label' => __( 'Hover icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb:hover .lqd-fb-content i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => [
						's08'
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'label_bg',
				'label' => __( 'Hover image overlay color', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-fb-content h6',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'template' => [
						's01', 's01b', 's03'
					]
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Label color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content h6' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => [
						's01', 's01b', 's03'
					]
				]
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => __( 'Content padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} div.lqd-fb-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => array(
					'template!' => array( 's06', 's09', 's10', 's11' ),
				),
			]
		);

		$this->add_responsive_control(
			'content_padding2',
			[
				'label' => __( 'Content padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} div.lqd-fb-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => array(
					'template' => array( 's06', 's09' ),
				),
			]
		);

		$this->end_controls_section();

		ld_el_btn($this, 'ib_', $condition = ['template' => ['s01', 's01a', 's01b', 's02', 's04', 's05', 's06', 's10']]); // load button
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

		$attributes = [
			'class' => [ 'lqd-fb', 'pos-rel' ]
		];


		switch($settings['template']){
			case 's01':
				array_push($attributes['class'], 'lqd-fb-style-1', 'lqd-fb-style-1-1', 'lqd-fb-content-overlay', 'lqd-fb-zoom-img-onhover', 'border-radius-4', 'overflow-hidden', $settings['box_height']);
				$attributes['data-inview'] = 'true';
			break;
			case 's01a':
				array_push($attributes['class'], 'lqd-fb-style-1', 'lqd-fb-style-1-2', 'lqd-fb-content-overlay', 'lqd-fb-zoom-img-onhover', 'border-radius-4', 'overflow-hidden', $settings['box_height_a']);
				$attributes['data-inview'] = 'true';
			break;
			case 's01b':
				array_push($attributes['class'], 'lqd-fb-style-1', 'lqd-fb-style-1-3', 'lqd-fb-content-overlay', 'lqd-fb-zoom-img-onhover', 'border-radius-4', 'overflow-hidden', $settings['box_height_b']);
				$attributes['data-inview'] = 'true';
			break;
			case 's02':
				array_push($attributes['class'], 'lqd-fb-style-2', 'lqd-fb-content-overlay');
			break;
			case 's03':
				array_push($attributes['class'], 'lqd-fb-style-3', 'lqd-fb-zoom-img-onhover');
			break;
			case 's04':
				array_push($attributes['class'], 'lqd-fb-style-4', 'lqd-fb-zoom-img-onhover');
			break;
			case 's05':
				array_push($attributes['class'], 'lqd-fb-style-5', 'overflow-hidden');
			break;
			case 's06':
				array_push($attributes['class'], 'lqd-fb-style-6', 'border-radius-4', $settings['box_height_6']);
				$attributes['data-lqd-zindex'] = 'true';
			break;
			case 's07':
				array_push($attributes['class'], 'lqd-fb-style-7', 'border-radius-4', 'overflow-hidden');
			break;
			case 's08':
				array_push($attributes['class'], 'lqd-fb-style-8' , $settings['content_alignment'] );
			break;
			case 's09':
				array_push($attributes['class'], 'lqd-fb-style-9', 'border-radius-10', 'text-center', 'overflow-hidden', $settings['ct_alignment']);
			break;
			case 's10':
				array_push($attributes['class'], 'lqd-fb-style-10');
			break;
			case 's11':
				array_push($attributes['class'], 'lqd-fb-style-11', 'text-center');
			break;
		}

		$this->add_render_attribute( 'wrapper', $attributes );

		if ( ! empty( $settings['img_link']['url'] ) ) {
			$this->add_link_attributes( 'img_link', $settings['img_link'] );
		}

		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
		<?php

		switch($settings['template']){
			case 's01':
			?>

			<div class="lqd-fb-inner lqd-overlay" data-slideelement-onhover="true" data-slideelement-options='{ "visibleElement": "h6, <?php echo esc_attr($settings['title_tag'] ); ?>", "hiddenElement": ".lqd-fb-txt", "disableOnMobile": true }'>

				<div class="overflow-hidden lqd-fb-img lqd-overlay">

					<figure class="w-100 h-100">
						<?php echo '<img class="w-100 h-100 objfit-cover objfit-center" src="' . esc_url($settings['image']['url']) . '">'; ?>
					</figure>

				</div>

				<div class="lqd-fb-content lqd-overlay d-flex align-items-end">
					<div class="lqd-fb-bg lqd-overlay"></div>
					<div
					class="lqd-fb-content-inner pos-rel w-100"
					data-custom-animations="true"
					data-ca-options='{ "triggerHandler": "inview", "animationTarget": "h6, <?php echo esc_attr($settings['title_tag'] ); ?>, .lqd-fb-txt", "duration": 1200, "delay": 120,  "startDelay": 250, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>

						<?php if( !empty( $settings['label'] ) ) { ?>
						<h6 class="mt-0 mb-4">
							<?php echo $settings['label']; ?>
						</h6>
						<?php } ?>

						<?php
							if( !empty( $settings['title'] ) ) {
								printf( '<%1$s class="mt-0 mb-0 lqd-fb__title %2$s">%3$s</%1$s>', $settings['title_tag'], $settings['use_inheritance'] === 'true' ? $settings['tag_to_inherite'] : '', $settings['title'] );
							}
						?>

						<?php if( !empty( $settings['content2'] ) || 'yes' === $settings['show_button'] ) { ?>
							<div class="lqd-fb-txt">
							<?php if( !empty( $settings['content2'] ) ) { ?>
								<p class="mt-0 mb-3"><?php echo $settings['content2']; ?></p>
							<?php }
							if( 'yes' === $settings['show_button'] ) {
								$button = new \LQD_Elementor_Render_Button;
								$button->get_button( $this, 'ib_' );
							} ?>
							</div>
						<?php } ?>

						<?php if( $settings['img_link']['url'] ): ?>
							<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
						<?php endif; ?>

					</div>
				</div>

			</div>

			<?php
			break;
			case 's01a':
			?>
			<div class="lqd-fb-inner lqd-overlay">

				<div class="overflow-hidden lqd-fb-img lqd-overlay">

					<figure class="w-100 h-100">
						<?php echo '<img class="w-100 h-100 objfit-cover objpos-center" src="' . esc_url($settings['image']['url']) . '">'; ?>
					</figure>

				</div>

				<div class="lqd-fb-content lqd-overlay d-flex align-items-end">
					<div class="lqd-fb-bg lqd-overlay"></div>
					<div class="lqd-fb-hover-overlay lqd-overlay"></div>
					<div class="flex-wrap pt-5 pb-5 lqd-fb-content-inner d-flex align-items-center pos-rel ps-2 pe-2 w-100">
						<?php if( 'yes' === $settings['show_button'] ) { ?>
						<div
						class="w-20 text-center lqd-fb-content-holder lqd-fb-content-left ps-2 pe-2"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1000, "delay": 120,  "startDelay": 250, "initValues": { "scale": 1.2, "opacity": 0 }, "animations": { "scale": 1, "opacity": 1 } }'>
						<?php
							$button = new \LQD_Elementor_Render_Button;
							$button->get_button( $this, 'ib_' );
						?>
						</div>
						<?php } ?>

						<?php if( !empty( $settings['title'] ) ) { ?>
						<div
						class="lqd-fb-content-holder lqd-fb-content-right w-80 ps-2 pe-2"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1000, "delay": 120,  "startDelay": 250, "initValues": { "y": 20, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
							<?php printf( '<%1$s class="lqd-fb__title mt-0 mb-0 %2$s" data-split-text="true" data-split-options=\'{ "type": "lines" }\'>%3$s</%1$s>', $settings['title_tag'], $settings['tag_to_inherite'], $settings['title'] ); ?>
						</div>
						<?php } ?>

						<?php if( $settings['img_link']['url'] ): ?>
							<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
						<?php endif; ?>

					</div>
				</div>

			</div>
			<?php
			break;
			case 's01b':
			?>
			<div class="lqd-fb-inner lqd-overlay">

				<div class="overflow-hidden lqd-fb-img lqd-overlay">

					<figure class="w-100 h-100">
						<?php echo '<img class="w-100 h-100 objfit-cover objpos-center" src="' . esc_url($settings['image']['url']) . '">'; ?>
					</figure>

				</div>

				<div class="lqd-fb-content lqd-overlay d-flex align-items-end">
					<div class="lqd-fb-bg lqd-overlay"></div>
					<div class="lqd-fb-hover-overlay lqd-overlay"></div>
					<div class="lqd-fb-content-inner d-flex flex-column <?php echo empty( $settings['label'] ) ? 'justify-content-end' : 'justify-content-between' ?> pos-rel h-100 w-100 p-4">

						<?php if( !empty( $settings['label'] ) ) { ?>
						<div class="lqd-fb-content-top">
							<h6 class="mt-0 mb-0"><?php echo $settings['label']; ?></h6>
						</div>
						<?php } ?>

						<div class="lqd-fb-content-bottom">

							<?php
								if( !empty( $settings['title'] ) ) {
									printf( '<%1$s class="lqd-fb__title mt-0 mb-2 %2$s">%3$s</%1$s>', $settings['title_tag'], $settings['tag_to_inherite'], $settings['title'] );
								}
							?>

							<?php if( !empty( $settings['content2'] ) ) { ?>
							<p class="mt-0 mb-3"><?php echo $settings['content2']; ?></p>
							<?php }
								$button = new \LQD_Elementor_Render_Button;
								$button->get_button( $this, 'ib_' );
							?>

						</div>

						<?php if( $settings['img_link']['url'] ): ?>
							<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
						<?php endif; ?>

					</div>
				</div>

				</div>
			<?php
			break;
			case 's02':
			?>
			<div class="lqd-fb-inner lqd-overlay">

				<div class="overflow-hidden lqd-fb-img lqd-overlay">

					<figure class="w-100 h-100">
						<?php echo '<img class="w-100 h-100 objfit-cover objpos-center" src="' . esc_url($settings['image']['url']) . '">'; ?>
					</figure>

					<?php if( $settings['img_link']['url'] ): ?>
						<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
					<?php endif; ?>

				</div>

				<div class="lqd-fb-content lqd-overlay d-flex align-items-end">
					<div class="flex-wrap pt-4 pb-4 lqd-fb-content-inner d-flex align-items-center pos-rel ps-3 pe-3 w-100">
						<div class="lqd-overlay" data-reveal="true" data-reveal-options='{ "direction": "bt", "bgcolor": "#000", "delay": 150, "duration": 500 }'>
							<div class="lqd-fb-bg lqd-overlay"></div>
							<div class="lqd-fb-hover-overlay lqd-overlay"></div>
						</div>

						<?php if( !empty( $settings['title'] ) ) { ?>
						<div
						class="lqd-fb-content-holder lqd-fb-content-left w-60 pos-rel"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1200, "delay": 120,  "startDelay": 800, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
						<?php printf( '<%1$s class="lqd-fb__title mt-0 mb-0 %2$s" data-split-text="true" data-split-options=\'{ "type": "lines" }\'>%3$s</%1$s>', $settings['title_tag'], $settings['tag_to_inherite'], $settings['title'] ); ?>


						</div>
						<?php } ?>

						<div
						class="w-40 lqd-fb-content-holder lqd-fb-content-right pos-rel"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1200, "delay": 120,  "startDelay": 950, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
						<?php
							$button = new \LQD_Elementor_Render_Button;
							$button->get_button( $this, 'ib_' );
						?>
						</div>
					</div>
				</div>

				</div>
			<?php
			break;
			case 's03':
			?>

			<div class="lqd-fb-inner" data-reveal="true" data-reveal-options='{ "direction": "bt", "bgcolor": "#000", "duration": 500 }'>

				<div class="overflow-hidden lqd-fb-img">

					<figure class="w-100">
						<?php echo '<img class="w-100" src="' . esc_url($settings['image']['url']) . '">'; ?>
					</figure>

					<?php if( $settings['img_link']['url'] ): ?>
						<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
					<?php endif; ?>

				</div>

				<div class="lqd-fb-content pos-rel">
					<div class="lqd-fb-bg lqd-overlay"></div>
					<div class="lqd-fb-hover-overlay lqd-overlay"></div>
					<div
					class="pt-4 pb-4 lqd-fb-content-inner d-flex flex-column pos-rel ps-6 pe-6"
					data-custom-animations="true"
					data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1200, "delay": 120,  "startDelay": 500, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
						<?php
							if( !empty( $settings['title'] ) ) {
								printf( '<%1$s class="lqd-fb__title mt-0 mb-2 %2$s" data-split-text="true" data-split-options=\'{ "type": "lines" }\'>%3$s</%1$s>', $settings['title_tag'], $settings['tag_to_inherite'], $settings['title'] );
							}
						?>
						<?php if( !empty( $settings['label'] ) ) { ?>
						<h6
						class="mt-0 mb-0"
						data-split-text="true" data-split-options='{ "type": "lines" }'><?php echo $settings['label']; ?></h6>
						<?php } ?>
					</div>
				</div>

			</div>

			<?php
			break;
			case 's04':
			?>
			<div class="lqd-fb-inner">

				<div class="overflow-hidden lqd-fb-img pos-rel">

					<figure class="w-100">
						<?php echo '<img class="w-100" src="' . esc_url($settings['image']['url']) . '">'; ?>
					</figure>

					<?php if( $settings['img_link']['url'] ): ?>
						<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
					<?php endif; ?>

				</div>

				<div class="lqd-fb-content pos-rel">
					<div class="lqd-fb-bg lqd-overlay"></div>
					<div class="lqd-fb-hover-overlay lqd-overlay"></div>
					<div class="p-5 text-center lqd-fb-content-inner pos-rel">

						<?php
							if( !empty( $settings['title'] ) ) {
								printf( '<%1$s class="lqd-fb__title mt-0 mb-3 font-weight-normal %2$s">%3$s</%1$s>', $settings['title_tag'], $settings['tag_to_inherite'], $settings['title'] );
							}
						?>

						<?php if( !empty( $settings['content2'] ) ) { ?>
						<p class="mt-0 mb-0"> <?php echo $settings['content2']; ?></p>
						<?php } ?>

					</div>


					<?php if( 'yes' === $settings['show_button'] ) { ?>
					<div class="p-3 text-center lqd-fb-footer">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' );
					?>
					</div>
					<?php } ?>

				</div>

			</div>
			<?php
			break;
			case 's05':
			?>
			<div class="flex-wrap lqd-fb-inner d-flex align-items-center">

				<div class="w-20 lqd-fb-content-holder lqd-fb-content-left">
					<div class="lqd-fb-img">
						<figure class="overflow-hidden w-100 border-radius-circle">

							<?php echo '<img class="w-100 h-100 objfit-cover objpos-center border-radius-circle" src="' . esc_url($settings['image']['url']) . '">'; ?>

							<?php if( $settings['img_link']['url'] ): ?>
								<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
							<?php endif; ?>

						</figure>
					</div>
				</div>

				<div class="lqd-fb-content-holder lqd-fb-content-right w-70 ms-auto">
					<div class="lqd-fb-content pos-rel">
						<div class="lqd-fb-bg lqd-overlay"></div>
						<div class="lqd-fb-hover-overlay lqd-overlay"></div>
						<div class="pt-6 pb-6 lqd-fb-content-inner pos-rel ps-4 pe-4">

							<?php
								if( !empty( $settings['title'] ) ) {
									printf( '<%1$s class="lqd-fb__title mt-0 mb-3 font-weight-bold %2$s">%3$s</%1$s>', $settings['title_tag'], $settings['tag_to_inherite'], $settings['title'] );
								}
							?>

							<?php if( !empty( $settings['content2'] ) ) { ?>
							<p class="mt-0 mb-3"><?php echo $settings['content2']; ?></p>
							<?php } ?>

							<?php
								$button = new \LQD_Elementor_Render_Button;
								$button->get_button( $this, 'ib_' );
							?>
						</div>
					</div>
				</div>

			</div>
			<?php
			break;
			case 's06':
			?>

			<div class="lqd-fb-shadow"></div>

			<div class="flex-wrap d-flex align-items-center lqd-overlay" data-hover3d="true">

				<div class="lqd-fb-content-wrap lqd-overlay flex-column align-items-end transform-style-3d backface-hidden will-change-transform" data-stacking-factor="0.5">

					<div class="overflow-hidden lqd-fb-img lqd-overlay border-radius-4 backface-hidden">
						<figure class="w-100 h-100">
							<?php echo '<img class="w-100 h-100 objfit-cover objfit-center" src="' . esc_url($settings['image']['url']) . '">'; ?>
						</figure>
						<div class="lqd-fb-bg lqd-overlay"></div>
						<div class="lqd-fb-hover-overlay lqd-overlay"></div>
					</div>

					<div class="p-4 lqd-fb-content d-flex flex-column justify-content-end lqd-overlay backface-hidden">

						<span class="mb-5 lqd-fb-icon d-flex">
							<?php \Elementor\Icons_Manager::render_icon( $settings['i_icon_fontawesome'], [ 'aria-hidden' => 'true' ] ); ?>
						</span>

						<?php if( !empty( $settings['subtitle'] ) ) { ?>
						<h6 class="mt-0 mb-3 font-weight-bold"><?php echo $settings['subtitle']; ?></h6>
						<?php }

							if( !empty( $settings['title'] ) ) {
								printf( '<%1$s class="lqd-fb__title mt-0 mb-3 font-weight-bold %2$s">%3$s</%1$s>', $settings['title_tag'], $settings['tag_to_inherite'], $settings['title'] );
							}

							$button = new \LQD_Elementor_Render_Button;
							$button->get_button( $this, 'ib_' );

						 ?>

					</div>

				</div>

				<?php if( $settings['img_link']['url'] ): ?>
					<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
				<?php endif; ?>

			</div>

			<?php
			break;
			case 's07':
			?>
			<div class="flex-wrap lqd-fb-inner d-flex">

				<div class="w-40 h-pt-50 pos-rel">
					<div class="lqd-fb-img lqd-overlay">
						<figure class="w-100 h-100 pos-rel">
							<?php echo '<img class="objfit-cover objpos-center lqd-overlay" src="' . esc_url($settings['image']['url']) . '">'; ?>
							<?php if( $settings['img_link']['url'] ): ?>
								<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
							<?php endif; ?>
						</figure>
					</div>
				</div>

				<div class="w-60">
					<div class="lqd-fb-content pos-rel">
						<div class="lqd-fb-bg lqd-overlay"></div>
						<div class="lqd-fb-hover-overlay lqd-overlay"></div>
						<div class="pt-6 pb-6 lqd-fb-content-inner pos-rel ps-5 pe-5">

							<?php
								if( !empty( $settings['title'] ) ) {
									printf( '<%1$s class="lqd-fb__title mt-0 mb-3 font-weight-semibold %2$s">%3$s</%1$s>', $settings['title_tag'], $settings['tag_to_inherite'], $settings['title'] );
								}
							?>

							<?php if( !empty( $settings['content2'] ) ) { ?>
							<p class="mt-0 mb-3"><?php echo $settings['content2']; ?></p>
							<?php } ?>

						</div>
					</div>
				</div>

			</div>

			<?php
			break;
			case 's08':
			?>
			<div class="lqd-fb-inner">

				<div
				class="overflow-hidden lqd-fb-img border-radius-4"
				data-custom-animations="true"
				data-ca-options='{ "triggerHandler": "inview", "animationTarget": "figure", "duration": 1200, "initValues": { "scale": 1.075, "opacity": 0 }, "animations": { "scale": 1, "opacity": 1 } }'>
					<figure class="w-100">
							<?php echo '<img class="w-100" src="' . esc_url($settings['image']['url']) . '">'; ?>
							<?php if( $settings['img_link']['url'] ): ?>
								<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
							<?php endif; ?>
					</figure>
				</div>

				<div class="lqd-fb-content border-radius-4 pos-rel <?php echo $settings['ct_width']; ?>">
					<div class="flex-wrap pt-4 pb-4 lqd-fb-content-inner d-flex align-items-center justify-content-between pos-rel border-radius-4 ps-5 pe-5">
						<div class="lqd-overlay" data-reveal="true" data-reveal-options='{ "direction": "bt", "delay": 150, "duration": 500, "coverArea": 100 }'>
							<div class="lqd-fb-bg lqd-overlay"></div>
						</div>
						<?php if( !empty( $settings['title'] ) ) { ?>
						<div
						class="lqd-fb-content-holder lqd-fb-content-left w-70 pos-rel"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1200, "delay": 120,  "startDelay": 800, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
							<?php printf( '<%1$s class="lqd-fb__title mt-0 mb-0 %2$s" data-split-text="true" data-split-options=\'{ "type": "lines" }\'>%3$s</%1$s>', $settings['title_tag'], $settings['tag_to_inherite'], $settings['title'] ); ?>
						</div>
						<?php } ?>
						<div
						class="w-20 lqd-fb-content-holder lqd-fb-content-right d-flex justify-content-end pos-rel"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1100, "delay": 120,  "startDelay": 950, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
							<?php \Elementor\Icons_Manager::render_icon( $settings['i_icon_fontawesome'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					</div>

					<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
				</div>

				<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>

			</div>
			<?php
			break;
			case 's09':
			?>
			<div class="lqd-fb-inner">

				<div
				class="overflow-hidden lqd-fb-img"
				data-custom-animations="true"
				data-ca-options='{ "triggerHandler": "inview", "animationTarget": "figure", "duration": 1200, "initValues": { "scale": 1.15, "opacity": 0 }, "animations": { "scale": 1, "opacity": 1 } }'>
					<figure class="w-100">
						<?php echo '<img class="w-100" src="' . esc_url($settings['image']['url']) . '">'; ?>
					</figure>
				</div>

				<div class="pt-4 pb-4 lqd-fb-content pos-rel ps-3 pe-3 d-flex flex-column">
					<div class="lqd-fb-content-inner pos-rel">
						<?php
							if( !empty( $settings['title'] ) ) {
								printf( '<%1$s class="lqd-fb__title mt-0 %2$s">%3$s</%1$s>', $settings['title_tag'], $settings['tag_to_inherite'] ? $settings['tag_to_inherite'] : 'h4', $settings['title'] );
							}
						?>
						<?php if( !empty( $settings['content2'] ) ) { ?>
						<p><?php echo $settings['conten2']; ?></p>
						<?php } ?>
					</div>
				</div>

				<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>

			</div>
			<?php
			break;
			case 's10':
			?>
			<div class="lqd-fb-inner">

				<div class="lqd-fb-content">
					<div class="lqd-fb-content-inner">

						<?php
							if( !empty( $settings['title'] ) ) {
								printf('<div class="mb-2 lqd-fb-title"><%1$s class="lqd-fb__title mt-0 mb-0 %2$s">%3$s<i class="lqd-icn-ess icon-ion-ios-arrow-forward"></i></%1$s></div>', $settings['title_tag'], $settings['tag_to_inherite'], $settings['title'] );
							}
						?>

						<?php if( !empty( $settings['content2'] ) ) { ?>
						<p class="mt-0 mb-3"><?php echo $settings['content2']; ?></p>
						<?php }
							$button = new \LQD_Elementor_Render_Button;
							$button->get_button( $this, 'ib_' );
						?>
					</div>
				</div>

			</div>
			<?php
			break;
			case 's11':
				?>
				<div class="lqd-fb-inner">

					<div class="lqd-fb-img">
						<figure class="overflow-hidden border-radius-circle">
							<?php echo '<img src="' . esc_url($settings['image']['url']) . '">'; ?>
						</figure>
						<span class="lqd-fb-icn">
							<i class="lqd-icn-ess icon-ion-ios-arrow-forward"></i>
						</span>
					</div>

					<div class="lqd-fb-content">
						<?php
						if( !empty( $settings['title'] ) ) {
							printf( '<%1$s class="lqd-fb__title mt-0 mb-0 %2$s">%3$s</%1$s>', $settings['title_tag'], $settings['tag_to_inherite'], $settings['title'] );
						}
						?>

					</div>

					<a <?php $this->print_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>

				</div>
				<?php
				break;
		}
		?>
		</div>
		<?php


	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Content_Box() );