<?php

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
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

defined( 'ABSPATH' ) || die();

function ld_el_btn($pf, $pf2, $condition = ''){
    // Button Section
		$pf->start_controls_section(
			'button_section2',
			[
				'label' => __( 'Button', 'hub-elementor-addons' ),
				'condition' => $condition
			]
		);

		$pf->add_control(
			'show_button',
			[
				'label' => __( 'Show Button', 'hub-elementor-addons' ),
				'type' => ($pf2 === 'ib_' ? Controls_Manager::SWITCHER : Controls_Manager::HIDDEN),
				'label_on' => __( 'Show', 'hub-elementor-addons' ),
				'label_off' => __( 'Hide', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => ($pf2 === 'ib_' ? '' : 'yes'),
			]
		);

		$pf->add_control(
			$pf2.'style',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'btn-solid',
				'options' => [
					'btn-solid' => __( 'Solid', 'hub-elementor-addons' ),
					'btn-naked' => __( 'Plain', 'hub-elementor-addons' ),
					'btn-underlined' => __( 'Underline', 'hub-elementor-addons' ),
				],
				'condition' => [
					'show_button' => 'yes',
				]
			]
		);

		$pf->add_control(
			$pf2.'title',
			[
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Button', 'hub-elementor-addons' ),
				'placeholder' => __( 'Enter Text', 'hub-elementor-addons' ),
				'condition' => [
					'show_button' => 'yes',
				]
			]
		);

		if ($pf2 !== 'ib_' ){
			$pf->add_responsive_control(
				$pf2.'align',
				[
					'label' => __( 'Alignment', 'hub-elementor-addons' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left'    => [
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
						'justify' => [
							'title' => __( 'Justified', 'hub-elementor-addons' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'prefix_class' => 'elementor%s-align-',
					'default' => '',
					'condition' => [
						'show_button' => 'yes',
					],
				]
			);
		}


		$pf->add_control(
			$pf2.'link_type',
			[
				'label' => __( 'Link Type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'Simple Click', 'hub-elementor-addons' ),
					'lightbox' => __( 'Lightbox', 'hub-elementor-addons' ),
					'modal_window' => __( 'Modal Window', 'hub-elementor-addons' ),
					'local_scroll' => __( 'Local Scroll', 'hub-elementor-addons' ),
					'scroll_to_section' => __( 'Scroll to Section Bellow', 'hub-elementor-addons' ),
				],
				'separator' => 'before',
				'condition' => [
					'show_button' => 'yes',
				]
			]
		);

		$pf->add_control(
			$pf2.'image_caption',
			[
				'label' => __( 'Image Caption', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Image Caption', 'hub-elementor-addons' ),
				'condition' => array(
					$pf2.'link_type' => 'lightbox',
					'show_button' => 'yes',
				),
			]
		);

		$pf->add_control(
			$pf2.'scroll_speed',
			[
				'label' => __( 'Scroll Speed', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Add scroll speed in milliseconds', 'hub-elementor-addons' ),
				'condition' => array(
					$pf2.'link_type' => array('local_scroll', 'scroll_to_section'),
					'show_button' => 'yes',
				),
				]
		);

		$pf->add_control(
			$pf2.'anchor_id',
			[
				'label' => __( 'Element ID', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Input the ID of the element to scroll, for ex. #Element_ID', 'hub-elementor-addons' ),
				'condition' => array(
					$pf2.'link_type' => array( 'modal_window', 'local_scroll'),
					'show_button' => 'yes',
				),
			]
		);

		$pf->add_control(
			$pf2.'link',
			[
				'label' => __( 'Link', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'hub-elementor-addons' ),
				'show_external' => true,
				'dynamic' => array(
					'active' => true,
				),
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
				'condition' => array(
					$pf2.'link_type' => array('', 'lightbox'),
					'show_button' => 'yes',
				),
			]
		);

		$pf->end_controls_section();

		// Styling Section
		$pf->start_controls_section(
			$pf2.'button_styling_section',
			array(
				'label' => __( 'Button Styling', 'hub-elementor-addons' ),
				'condition' => [
					'show_button' => 'yes',
				]
			)
		);

		$pf->add_control(
			$pf2.'size',
			[
				'label' => __( 'Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'btn-xsm' => __( 'Extra Small', 'hub-elementor-addons' ),
					'btn-sm' => __( 'Small', 'hub-elementor-addons' ),
					// 'btn-md' => __( 'Medium', 'hub-elementor-addons' ),
					'btn-lg' => __( 'Large', 'hub-elementor-addons' ),
					'btn-xlg' => __( 'Extra Large', 'hub-elementor-addons' ),
					'btn-custom-size' => __( 'Custom', 'hub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'style' => array( 'btn-solid' ),
				),
			]
		);

		$pf->add_control(
			$pf2.'width',
			[
				'label' => __( 'Button Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Normal', 'hub-elementor-addons' ),
					'btn-block' => __( 'Fullwidth', 'hub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'style' => array( 'btn-solid' ),
					$pf2.'size!' => array( 'btn-custom-size' ),
					// 'lqd_deprecated' => 'yes',
				),
			]
		);

		$pf->add_responsive_control(
			$pf2.'custom_w',
			[
				'label' => __( 'Button Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					$pf2.'style' => array( 'btn-solid' ),
					$pf2.'size' => array( 'btn-custom-size' ),
				),
			]
		);

		$pf->add_responsive_control(
			$pf2.'custom_h',
			[
				'label' => __( 'Button Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					$pf2.'style' => array( 'btn-solid' ),
					$pf2.'size' => array( 'btn-custom-size' ),
				),
			]
		);

		$pf->add_control(
			$pf2.'border_w',
			[
				'label' => __( 'Border Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'border-thin',
				'options' => [
					'border-thin' => __( '1px', 'hub-elementor-addons' ),
					'border-thick' => __( '2px', 'hub-elementor-addons' ),
					'border-thicker' => __( '3px', 'hub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'style' => array( 'btn-underlined' ),
				),
			]
		);

		$pf->add_control(
			$pf2.'hover_txt_effect',
			[
				'label' => __( 'Hover Text Effect', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'hub-elementor-addons' ),
					'btn-hover-txt-liquid-x' => __( 'Hover Liquid X', 'hub-elementor-addons' ),
					'btn-hover-txt-liquid-x-alt' => __( 'Hover Liquid X Alt', 'hub-elementor-addons' ),
					'btn-hover-txt-liquid-y' => __( 'Hover Liquid Y', 'hub-elementor-addons' ),
					'btn-hover-txt-liquid-y-alt' => __( 'Hover Liquid Y Alt', 'hub-elementor-addons' ),
					'btn-hover-txt-switch btn-hover-txt-switch-x' => __( 'Hover Switch X', 'hub-elementor-addons' ),
					'btn-hover-txt-switch btn-hover-txt-switch-y' => __( 'Hover Switch Y', 'hub-elementor-addons' ),
					'btn-hover-txt-marquee btn-hover-txt-marquee-x' => __( 'Hover Marquee X', 'hub-elementor-addons' ),
					'btn-hover-txt-marquee btn-hover-txt-marquee-y' => __( 'Hover Marquee Y', 'hub-elementor-addons' ),
					'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y' => __( 'Hover Change Text', 'hub-elementor-addons' ),
				],
			]
		);

		$pf->add_control(
			$pf2.'title_secondary',
			[
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Button', 'hub-elementor-addons' ),
				'placeholder' => __( 'Enter Text', 'hub-elementor-addons' ),
				'condition' => [
					'show_button' => 'yes',
					$pf2.'hover_txt_effect' => 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y',
				]
			]
		);

		$pf->end_controls_section();

		// Icon Section
		$pf->start_controls_section(
			'icon_section',
			array(
				'label' => __( 'Button Icon', 'hub-elementor-addons' ),
				'condition' => [
					'show_button' => 'yes',
				]
			)
		);


		$pf->add_control(
			$pf2.'i_add_icon',
			[
				'label' => __( 'Add Icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);

		$pf->add_control(
			$pf2.'icon',
			[
				'label' => __( 'Icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-star',
					'library' => 'solid',
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_size',
			[
				'label' => __( 'Icon Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
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
					'{{WRAPPER}} .btn' => '--icon-font-size: {{SIZE}}{{UNIT}};'
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_position',
			[
				'label' => __( 'Icon Position', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'btn-icon-left' => [
						'title' => __( 'Left', 'hub-elementor-addons' ),
						'icon' => 'eicon-arrow-left',
					],
					'btn-icon-right' => [
						'title' => __( 'Right', 'hub-elementor-addons' ),
						'icon' => 'eicon-arrow-right',
					],
					'btn-icon-block btn-icon-top' => [
						'title' => __( 'Top', 'hub-elementor-addons' ),
						'icon' => 'eicon-arrow-up',
					],
					'btn-icon-block' => [
						'title' => __( 'Bottom', 'hub-elementor-addons' ),
						'icon' => 'eicon-arrow-down',
					],
				],
				'default' => 'btn-icon-right',
				'toggle' => false,
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_shape_style',
			[
				'label' => __( 'Icon shape style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'btn-icon-solid' => __( 'Solid', 'hub-elementor-addons' ),
					'btn-icon-bordered' => __( 'Outline', 'hub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_shape',
			[
				'label' => __( 'Icon Shape', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'hub-elementor-addons' ),
					'btn-icon-square' => __( 'Square', 'hub-elementor-addons' ),
					'btn-icon-semi-round' => __( 'Semi Round', 'hub-elementor-addons' ),
					'btn-icon-round' => __( 'Round', 'hub-elementor-addons' ),
					'btn-icon-circle' => __( 'Circle', 'hub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
					$pf2.'i_shape_style!' => '',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_shape_bw',
			[
				'label' => __( 'Border Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default - 1px', 'hub-elementor-addons' ),
					'btn-icon-border-thick' => __( '2px', 'hub-elementor-addons' ),
					'btn-icon-border-thicker' => __( '3px', 'hub-elementor-addons' ),
					'btn-icon-border-thickest' => __( '4px', 'hub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'i_shape_style' => 'btn-icon-bordered',
					$pf2.'i_add_icon' => 'true',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_shape_size',
			[
				'label' => __( 'Icon Shape size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'btn-icon-md',
				'options' => [
					'btn-icon-xsm' => __( 'Extra Small', 'hub-elementor-addons' ),
					'btn-icon-sm' => __( 'Small', 'hub-elementor-addons' ),
					'btn-icon-md' => __( 'Medium', 'hub-elementor-addons' ),
					'btn-icon-lg' => __( 'Large', 'hub-elementor-addons' ),
					'btn-icon-xlg' => __( 'Extra Large', 'hub-elementor-addons' ),
					'btn-icon-custom-size' => __( 'Custom Size', 'hub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
					$pf2.'i_shape!' => '',
					$pf2.'i_shape_style!' => '',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_shape_custom_size',
			[
				'label' => __( 'Icon Shape Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn .btn-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$pf2.'i_add_icon' => 'true',
					$pf2.'i_shape!' => '',
					$pf2.'i_shape_style!' => '',
					$pf2.'i_shape_size' => 'btn-icon-custom-size',
				],
			]
		);

		$pf->add_control(
			$pf2.'i_hover_reveal',
			[
				'label' => __( 'Hover Effect', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'btn-hover-reveal' => __( 'Reveal', 'hub-elementor-addons' ),
					'btn-hover-swp' => __( 'Switch Position', 'hub-elementor-addons' )
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
					$pf2.'i_position' => [ 'btn-icon-left', 'btn-icon-right' ],
					// $pf2.'i_shape!' => '',
					// $pf2.'i_shape_style!' => '',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_ripple',
			[
				'label' => __( 'Icon Ripple Effect', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'No', 'hub-elementor-addons' ),
					'btn-icon-ripple' => __( 'Yes', 'hub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'i_shape!' => '',
					$pf2.'i_shape_style!' => '',
					$pf2.'i_add_icon' => 'true',
				),
			]
		);


		$pf->add_control(
			$pf2.'i_separator',
			[
				'label' => __( 'Add Separator', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'No', 'hub-elementor-addons' ),
					'btn-icon-sep' => __( 'Yes', 'hub-elementor-addons' ),
				],
				'condition' => [
					$pf2.'i_add_icon' => 'true',
					$pf2.'i_position' => [ 'btn-icon-left', 'btn-icon-right' ],
					$pf2.'i_ripple' => ''
				],
			]
		);

		$pf->add_responsive_control(
			$pf2.'i_margin',
			[
				'label' => __( 'Icon Margin', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .btn' => '--icon-mt: {{TOP}}{{UNIT}}; --icon-me: {{RIGHT}}{{UNIT}}; --icon-mb: {{BOTTOM}}{{UNIT}}; --icon-ms: {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					$pf2.'i_add_icon' => 'true',
				],
			]
		);

		$pf->end_controls_section();

		// Style Section
		$pf->start_controls_section(
			$pf2.'button_style_section',
			[
				'label' => __( 'Button Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => 'yes',
				]
			]
		);

		$pf->add_control(
			$pf2.'ld_btn_margin',
			[
				'label' => esc_html__( 'Margin', 'hub-elementor-addons' ),
				'type' => ($pf2 === 'ib_' ? Controls_Manager::DIMENSIONS : Controls_Manager::HIDDEN),
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$pf->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $pf2.'_content_typography',
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .btn',
			]
		);

			$pf->start_controls_tabs(
				'button_style_tabs'
			);

			// Normal state
			$pf->start_controls_tab(
				'button_style_normal_tab',
				[
					'label' => __( 'Normal', 'hub-elementor-addons' ),
				]
			);

			$pf->add_control(
				$pf2.'text_color',
				[
					'label' => __( 'Text Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn' => 'color: {{VALUE}}; fill: {{VALUE}}',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => $pf2.'background',
					'label' => __( 'Background', 'hub-elementor-addons' ),
					'types' => [ 'classic', 'gradient', 'image' ],
					'selector' => '{{WRAPPER}} .btn',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				$pf2.'b_color',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:before' => 'background: {{VALUE}}',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				$pf2.'i_color',
				[
					'label' => __( 'Icon Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-icon' => 'color: {{VALUE}}; fill: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				$pf2.'i_fill_color',
				[
					'label' => __( 'Icon Fill Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-icon' => 'background: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-solid',
					),
				]
			);

			$pf->add_control(
				$pf2.'i_border_color',
				[
					'label' => __( 'Icon Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-icon' => 'border-color: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-bordered',
					),
				]
			);

			$pf->add_control(
				$pf2.'i_sep_color',
				[
					'label' => __( 'Icon Separator Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-icon:before' => 'background: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_separator' => 'btn-icon-sep',
					),
				]
			);

			$pf->add_control(
				$pf2.'ripple_color',
				[
					'label' => __( 'Icon Ripple Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-icon:before' => 'border-color: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => $pf2.'border',
					'selector' => '{{WRAPPER}} .btn',
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => $pf2.'button_box_shadow',
					'selector' => '{{WRAPPER}} .btn',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();

			// Hover state
			$pf->start_controls_tab(
				$pf2.'button_style_hover_tab',
				[
					'label' => __( 'Hover', 'hub-elementor-addons' ),
				]
			);

			$pf->add_control(
				$pf2.'htext_color',
				[
					'label' => __( 'Text Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus' => 'color: {{VALUE}}',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => $pf2.'button_background_hover',
					'label' => __( 'Background', 'hub-elementor-addons' ),
					'types' => [ 'classic', 'gradient', 'image' ],
					'selector' => '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				$pf2.'h_b_color',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:after' => 'background: {{VALUE}}',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				$pf2.'i_hcolor',
				[
					'label' => __( 'Icon Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover .btn-icon, {{WRAPPER}} .btn:focus .btn-icon' => 'color: {{VALUE}}; fill: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				$pf2.'i_fill_hcolor',
				[
					'label' => __( 'Icon Fill Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover .btn-icon, {{WRAPPER}} .btn:focus .btn-icon' => 'background: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape_style' => array('btn-icon-solid', 'btn-icon-bordered'),
					),
				]
			);

			$pf->add_control(
				$pf2.'i_border_hcolor',
				[
					'label' => __( 'Icon Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover .btn-icon, {{WRAPPER}} .btn:focus .btn-icon' => 'border-color: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-bordered',
					),
				]
			);

			$pf->add_control(
				$pf2.'h_i_sep_color',
				[
					'label' => __( 'Icon Separator Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover .btn-icon:before, {{WRAPPER}} .btn:focus .btn-icon:before' => 'background: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_separator' => 'btn-icon-sep',
					),
				]
			);

			$pf->add_control(
				$pf2.'h_ripple_color',
				[
					'label' => __( 'Icon Ripple Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover .btn-icon:before, {{WRAPPER}} .btn:focus .btn-icon:before' => 'border-color: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => $pf2.'h_border',
					'selector' => '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus',
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => $pf2.'h_button_box_shadow',
					'selector' => '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();
			$pf->end_controls_tabs();

			$pf->add_control(
				$pf2.'border_radius',
				[
					'label' => __( 'Border Radius', 'hub-elementor-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_responsive_control(
				$pf2.'text_padding',
				[
					'label' => __( 'Text Padding', 'hub-elementor-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .btn' => '--btn-pt: {{TOP}}{{UNIT}}; --btn-pe: {{RIGHT}}{{UNIT}}; --btn-pb: {{BOTTOM}}{{UNIT}}; --btn-ps: {{LEFT}}{{UNIT}}; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

		$pf->end_controls_section();

		$color_sections_hide = get_post_type() === 'liquid-header' ? '' : '_hide';

		// Sticky Header
		$pf->start_controls_section(
			$pf2.'sticky_button_style_section' . $color_sections_hide,
			[
				'label' => __( 'Sticky Color', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => ($pf2 === 'ib_' ? 'hidden' : 'yes'),
				]
			]
		);

			$pf->start_controls_tabs(
				'sticky_button_style_tabs'
			);

			// Normal state
			$pf->start_controls_tab(
				'sticky_button_style_normal_tab',
				[
					'label' => __( 'Normal', 'hub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'text_color',
				[
					'label' => __( 'Text Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_' . $pf2 . 'background',
					'label' => __( 'Background', 'hub-elementor-addons' ),
					'types' => [ 'classic', 'gradient', 'image' ],
					'selector' => '.is-stuck {{WRAPPER}} .btn',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'b_color_solid',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'b_color',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:before' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_'. $pf2 . 'i_color',
				[
					'label' => __( 'Icon Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'i_fill_color',
				[
					'label' => __( 'Icon Fill Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-solid',
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'ripple_color',
				[
					'label' => __( 'Icon Ripple Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_' . $pf2 . 'button_box_shadow',
					'selector' => '.is-stuck {{WRAPPER}} .btn',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();

			// Hover state
			$pf->start_controls_tab(
				'sticky_' . $pf2 . 'button_style_hover_tab',
				[
					'label' => __( 'Hover', 'hub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'htext_color',
				[
					'label' => __( 'Text Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:hover, .is-stuck {{WRAPPER}} .btn:focus' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_' . $pf2 . 'button_background_hover',
					'label' => __( 'Background', 'hub-elementor-addons' ),
					'types' => [ 'classic', 'gradient', 'image' ],
					'selector' => '.is-stuck {{WRAPPER}} .btn:hover, .is-stuck {{WRAPPER}} .btn:focus',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'h_b_color_solid',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:hover, .is-stuck {{WRAPPER}} .btn:focus' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'h_b_color',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:after' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'i_hcolor',
				[
					'label' => __( 'Icon Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:hover .btn-icon, .is-stuck {{WRAPPER}} .btn:focus .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'i_fill_hcolor',
				[
					'label' => __( 'Icon Fill Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:hover .btn-icon, .is-stuck {{WRAPPER}} .btn:focus .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => array('btn-icon-solid', 'btn-icon-bordered'),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'h_ripple_color',
				[
					'label' => __( 'Icon Ripple Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:hover .btn-icon:before, .is-stuck {{WRAPPER}} .btn:focus .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_' . $pf2 . 'h_button_box_shadow',
					'selector' => '.is-stuck {{WRAPPER}} .btn:hover, .is-stuck {{WRAPPER}} .btn:focus',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();
			$pf->end_controls_tabs();

		$pf->end_controls_section();

		// Colors Over Light Rows
		$pf->start_controls_section(
			$pf2.'sticky_light_button_style_section' . $color_sections_hide,
			[
				'label' => __( 'Colors Over Light Rows', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => ($pf2 === 'ib_' ? 'hidden' : 'yes'),
				]
			]
		);

			$pf->start_controls_tabs(
				'sticky_light_button_style_tabs'
			);

			// Normal state
			$pf->start_controls_tab(
				'sticky_light_button_style_normal_tab',
				[
					'label' => __( 'Normal', 'hub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'text_color',
				[
					'label' => __( 'Text Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_light_' . $pf2 . 'background',
					'label' => __( 'Background', 'hub-elementor-addons' ),
					'types' => [ 'classic', 'gradient', 'image' ],
					'selector' => '{{WRAPPER}}.lqd-active-row-light .btn',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'b_color_solid',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'b_color',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:before' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_'. $pf2 . 'i_color',
				[
					'label' => __( 'Icon Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'i_fill_color',
				[
					'label' => __( 'Icon Fill Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-solid',
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'ripple_color',
				[
					'label' => __( 'Icon Ripple Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_light_' . $pf2 . 'button_box_shadow',
					'selector' => '{{WRAPPER}}.lqd-active-row-light .btn',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();

			// Hover state
			$pf->start_controls_tab(
				'sticky_light_' . $pf2 . 'button_style_hover_tab',
				[
					'label' => __( 'Hover', 'hub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'htext_color',
				[
					'label' => __( 'Text Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:hover, {{WRAPPER}}.lqd-active-row-light .btn:focus' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_light_' . $pf2 . 'button_background_hover',
					'label' => __( 'Background', 'hub-elementor-addons' ),
					'types' => [ 'classic', 'gradient', 'image' ],
					'selector' => '{{WRAPPER}}.lqd-active-row-light .btn:hover, {{WRAPPER}}.lqd-active-row-light .btn:focus',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'h_b_color_solid',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:hover, {{WRAPPER}}.lqd-active-row-light .btn:focus' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'h_b_color',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:after' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'i_hcolor',
				[
					'label' => __( 'Icon Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:hover .btn-icon, {{WRAPPER}}.lqd-active-row-light .btn:focus .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'i_fill_hcolor',
				[
					'label' => __( 'Icon Fill Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:hover .btn-icon, {{WRAPPER}}.lqd-active-row-light .btn:focus .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => array('btn-icon-solid', 'btn-icon-bordered'),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'h_ripple_color',
				[
					'label' => __( 'Icon Ripple Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:hover .btn-icon:before, {{WRAPPER}}.lqd-active-row-light .btn:focus .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_light_' . $pf2 . 'h_button_box_shadow',
					'selector' => '{{WRAPPER}}.lqd-active-row-light .btn:hover, {{WRAPPER}}.lqd-active-row-light .btn:focus',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();
			$pf->end_controls_tabs();

		$pf->end_controls_section();

		// Colors Over Dark Rows
		$pf->start_controls_section(
			$pf2.'sticky_dark_button_style_section' . $color_sections_hide,
			[
				'label' => __( 'Colors Over Dark Rows', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => ($pf2 === 'ib_' ? 'hidden' : 'yes'),
				]
			]
		);

			$pf->start_controls_tabs(
				'sticky_dark_button_style_tabs'
			);

			// Normal state
			$pf->start_controls_tab(
				'sticky_dark_button_style_normal_tab',
				[
					'label' => __( 'Normal', 'hub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'text_color',
				[
					'label' => __( 'Text Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_dark_' . $pf2 . 'background',
					'label' => __( 'Background', 'hub-elementor-addons' ),
					'types' => [ 'classic', 'gradient', 'image' ],
					'selector' => '{{WRAPPER}}.lqd-active-row-dark .btn',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'b_color_solid',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'b_color',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:before' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_'. $pf2 . 'i_color',
				[
					'label' => __( 'Icon Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'i_fill_color',
				[
					'label' => __( 'Icon Fill Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-solid',
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'ripple_color',
				[
					'label' => __( 'Icon Ripple Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_dark_' . $pf2 . 'button_box_shadow',
					'selector' => '{{WRAPPER}}.lqd-active-row-dark .btn',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();

			// Hover state
			$pf->start_controls_tab(
				'sticky_dark_' . $pf2 . 'button_style_hover_tab',
				[
					'label' => __( 'Hover', 'hub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'htext_color',
				[
					'label' => __( 'Text Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:hover, {{WRAPPER}}.lqd-active-row-dark .btn:focus' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_dark_' . $pf2 . 'button_background_hover',
					'label' => __( 'Background', 'hub-elementor-addons' ),
					'types' => [ 'classic', 'gradient', 'image' ],
					'selector' => '{{WRAPPER}}.lqd-active-row-dark .btn:hover, {{WRAPPER}}.lqd-active-row-dark .btn:focus',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'h_b_color_solid',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:hover, {{WRAPPER}}.lqd-active-row-dark .btn:focus' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'h_b_color',
				[
					'label' => __( 'Border Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:after' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'i_hcolor',
				[
					'label' => __( 'Icon Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:hover .btn-icon, {{WRAPPER}}.lqd-active-row-dark .btn:focus .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'i_fill_hcolor',
				[
					'label' => __( 'Icon Fill Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:hover .btn-icon, {{WRAPPER}}.lqd-active-row-dark .btn:focus .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => array('btn-icon-solid', 'btn-icon-bordered'),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'h_ripple_color',
				[
					'label' => __( 'Icon Ripple Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:hover .btn-icon:before, {{WRAPPER}}.lqd-active-row-dark .btn:focus .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_dark_' . $pf2 . 'h_button_box_shadow',
					'selector' => '{{WRAPPER}}.lqd-active-row-dark .btn:hover, {{WRAPPER}}.lqd-active-row-dark .btn:focus',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();
			$pf->end_controls_tabs();

		$pf->end_controls_section();

}

class LQD_Elementor_Render_Button {

	// Button Functions
	function get_button( $widget, $prefix = '' ) {

		$settings = $widget->get_settings_for_display();

		if ( $settings['show_button'] === 'yes' ){

			$attributes = $inner_attributes = array();

			// wrapper attr
			// define classes
			$class = array(
				'elementor-button',
				'btn',
				$settings[$prefix.'style'],
				$settings[$prefix.'i_separator'],
				$settings[$prefix.'hover_txt_effect'],
				$settings[$prefix.'size'],
				$settings[$prefix.'border_w'],
				$this->get_width( $settings[$prefix.'style'], $settings[$prefix.'width'] ),

				($settings[$prefix.'link_type'] === 'lightbox') ? 'fresco' : '',

				//Icon Classes
				$settings[$prefix.'i_position'],
				$settings[$prefix.'i_shape'],
				$settings[$prefix.'i_shape'] !== '' && $settings[$prefix.'i_shape_style'] !== '' ? $settings[$prefix.'i_shape_size'] : '',
				$settings[$prefix.'i_shape'] !== '' && $settings[$prefix.'i_shape_style'] !== '' ? 'btn-icon-shaped' : '',
				$settings[$prefix.'i_shape_style'],
				$settings[$prefix.'i_shape_bw'],
				$settings[$prefix.'i_ripple'],
				$settings[$prefix.'i_add_icon'] === 'true' && ($settings[$prefix.'i_position'] === 'btn-icon-left' || $settings[$prefix.'i_position'] === 'btn-icon-right') ? $settings[$prefix.'i_hover_reveal'] : '',
				!empty( $settings[$prefix.'title'] ) ? 'btn-has-label' : 'btn-no-label',
			);

			$attributes['class'] = array_filter($class);

			if ( ! empty( $settings[$prefix.'link']['url'] ) ) {
				$widget->add_link_attributes( $prefix.'link', $settings[$prefix.'link'] );
			}

			if ( !empty( $settings[$prefix.'image_caption'] ) ) {
				$attributes['data-fresco-caption'] = $settings[$prefix.'image_caption'];
			}

			if ( 'modal_window' === $settings[$prefix.'link_type'] ) {
				$attributes['data-lity'] = isset( $settings[$prefix.'anchor_id'] ) ? esc_url( $settings[$prefix.'anchor_id'] ) : '#modal-box';
				$attributes['href'] = isset( $settings[$prefix.'anchor_id'] ) ? esc_url( $settings[$prefix.'anchor_id'] ) : '#modal-box';
			} elseif( 'local_scroll' === $settings[$prefix.'link_type'] ) {
				$attributes['data-localscroll'] = true;
				$attributes['href'] = isset( $settings[$prefix.'anchor_id'] ) ? esc_url( $settings[$prefix.'anchor_id'] ) : '#';
				if( !empty( $settings[$prefix.'scroll_speed'] ) ) {
					$attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollSpeed' => $settings[$prefix.'scroll_speed'] ) );
				}
			} elseif( 'scroll_to_section' === $settings[$prefix.'link_type'] ) {
				$attributes['data-localscroll'] = true;
				if( !empty( $settings[$prefix.'scroll_speed'] ) ) {
					$attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollBelowSection' => true, 'scrollSpeed' => $settings[$prefix.'scroll_speed'] ) );
				} else {
					$attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollBelowSection' => true ) );
				}
				$attributes['href'] = '#';
			}

			$widget->add_render_attribute( 'btn_wrapper', $attributes );

			// inner attr
            $data_text = !empty( $settings[$prefix.'title_secondary'] ) ? $settings[$prefix.'title_secondary'] : $settings[$prefix.'title'];
			$inner_attributes['data-text'] = esc_attr( $data_text );
			if ( empty( $prefix ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ){
				$inner_attributes['class'] = 'btn-txt elementor-inline-editing';
				$inner_attributes['data-elementor-setting-key'] = 'title';
				$inner_attributes['data-elementor-inline-editing-toolbar'] = 'basic';
			} else {
				$inner_attributes['class'] = 'btn-txt';
			}

			// merge inner attrs
			$inner_attributes = array_merge( $inner_attributes, $this->get_hover_text_opts( $settings[$prefix.'hover_txt_effect'] ) );
			$widget->add_render_attribute( 'inner', $inner_attributes );

			?>

			<a
				<?php
					$widget->print_render_attribute_string( $prefix.'link' );
					$widget->print_render_attribute_string( 'btn_wrapper' );
				?>
			>
				<?php if( !empty( $settings[$prefix.'title'] ) ) { ?>
					<span <?php $widget->print_render_attribute_string( 'inner' ); ?>>
						<?php echo wp_kses_post( do_shortcode( $settings[$prefix.'title'] ) ); ?>
					</span>
				<?php } ?>
				<?php
					if( isset( $settings[$prefix.'icon']['value']) ) {
						?>
						<span class="btn-icon">
							<?php Icons_Manager::render_icon( $settings[$prefix.'icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</span>
						<?php
					}
					if( 'btn-hover-swp' === $settings[$prefix.'i_hover_reveal'] ) {
						?>
						<span class="btn-icon">
							<?php Icons_Manager::render_icon( $settings[$prefix.'icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</span>
						<?php
					}
				?>
			</a>
			<?php

		}

	}

	function get_width( $style, $width ) {

		if( 'btn-naked' === $style || 'btn-underlined' === $style ) {
			return;
		}

		return "$width";

	}

	function get_hover_text_opts( $effect ) {

		if( empty( $effect ) ) {
			return array();
		}

		$start_delay = 0;
		$out = array();

		switch( $effect ) {

			case 'btn-hover-txt-liquid-x':
			default:
				$out['data-transition-delay'] = 'true';
				$out['data-delay-options'] = '{"elements": ".lqd-chars", "delayType": "animation", "startDelay": ' . $start_delay . ', "delayBetween": 32.5}';
				$out['data-split-text'] = 'true';
				$out['data-split-options'] = '{"type": "chars, words"}';
			break;

			case 'btn-hover-txt-liquid-x-alt':
				$out['data-transition-delay'] = 'true';
				$out['data-delay-options'] = '{"elements": ".lqd-chars", "delayType": "animation", "startDelay": ' . $start_delay . ', "delayBetween": 32.5, "reverse": true}';
				$out['data-split-text'] = 'true';
				$out['data-split-options'] = '{"type": "chars, words"}';
			break;

			case 'btn-hover-txt-liquid-y':
				$out['data-transition-delay'] = 'true';
				$out['data-delay-options'] = '{"elements": ".lqd-chars", "delayType": "animation", "startDelay": ' . $start_delay . ', "delayBetween": 32.5}';
				$out['data-split-text'] = 'true';
				$out['data-split-options'] = '{"type": "chars, words"}';
			break;

			case 'btn-hover-txt-liquid-y-alt':
				$out['data-transition-delay'] = 'true';
				$out['data-delay-options'] = '{"elements": ".lqd-chars", "delayType": "animation", "startDelay": ' . $start_delay . ', "delayBetween": 32.5}';
				$out['data-split-text'] = 'true';
				$out['data-split-options'] = '{"type": "chars, words"}';
			break;

		}

		return $out;

	}

}