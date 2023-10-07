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
class LD_Custom_Menu extends Widget_Base {

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
		return 'ld_custom_menu';
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
		return __( 'Liquid Custom Menu', 'hub-elementor-addons' );
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
		return 'eicon-menu-toggle lqd-element';
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

    private function get_available_menus() {
		$menus = wp_get_nav_menus();
		$options = [];
		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}
		return $options;
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
		return [ 'header', 'menu' ];
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
			array(
				'label' => __( 'General', 'hub-elementor-addons' ),
			)
		);

		$this->add_control(
			'source',
			[
				'label' => __( 'Data source', 'hub-elementor-addons' ),
				'description' => __( 'Select Data source of the custom menu, it can be an existent wp menu or custom menu items added here the Items option.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wp_menus',
				'options' => [
					'wp_menus' => __( 'WP Menus', 'hub-elementor-addons' ),
					'custom' => __( 'Custom', 'hub-elementor-addons' ),
				],
			]
		);

        $menus = $this->get_available_menus();
	
		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu_slug',
				[
					'label' => __( 'Menu', 'hub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'save_default' => true,
					'separator' => 'after',
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'hub-elementor-addons' ), admin_url( 'nav-menus.php' ) ),
					'condition' => [
						'source' => 'wp_menus'
					],
 				]
			);
		} else {
			$this->add_control(
				'menu_slug',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'hub-elementor-addons' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition' => [
						'source' => 'wp_menus'
					],
				]
			);
		}

		$this->add_control(
			'localscroll',
			[
				'label' => __( 'Local scroll?', 'hub-elementor-addons' ),
				'description' => __( 'Enable to use localscroll feature for the menu items on the page', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'label', [
				'label' => __( 'Label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'url', [
				'label' => __( 'URL (link)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '#',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'target',
			[
				'label' => esc_html__( 'Open in new window', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'hub-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'label_on' => __( 'Yes', 'hub-elementor-addons' ),
				'label_off' => __( 'No', 'hub-elementor-addons' ),
				'default' => '',
			]
		);

		$repeater->add_control(
			'badge', [
				'label' => __( 'Badge', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'badge_color',
			[
				'label' => __( 'Badge color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					//'{{WRAPPER}} .title' => 'color: {{VALUE}}',
				],
			]
		);

		
		$repeater->add_control(
			'icon_alignment',
			[
				'label' => __( 'Icon alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left-icon' => [
						'title' => __( 'Left', 'hub-elementor-addons' ),
						'icon' => 'fa fa-align-left',
					],
					'right-icon' => [
						'title' => __( 'Right', 'hub-elementor-addons' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left-icon',
				'toggle' => false,
			]
		);

		$repeater->add_control(
			'icon_classname',
			[
				'label' => __( 'Icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'condition' => [
					'source' => 'custom'
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'menu_alignment',
			[
				'label' => __( 'Menu alignment', 'hub-elementor-addons' ),
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
					'{{WRAPPER}}' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .reset-ul li a' => 'justify-content: {{VALUE}}',
				],
				'toggle' => true,
				'condition' => [
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_control(
			'icon_pos',
			[
				'label' => __( 'Icon position', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'icon-next-to-label',
				'options' => [
					'icon-next-to-label' => __( 'Next to menu label', 'hub-elementor-addons' ),
					'icon-push-to-edge' => __( 'Push to the edge', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'cm_sticky',
			[
				'label' => __( 'Sticky?', 'hub-elementor-addons' ),
				'type' => defined( 'ELEMENTOR_PRO_VERSION' ) ? Controls_Manager::SWITCHER : Controls_Manager::HIDDEN,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'cm_sticky_force',
			[
				'label' => __( 'Force the sticky menu options', 'hub-elementor-addons' ),
				'description' => __( 'You see this option you are using elementor pro. If some features are not working as expected, enable it.', 'hub-elementor-addons' ),
				'type' => defined( 'ELEMENTOR_PRO_VERSION' ) ? Controls_Manager::SWITCHER : Controls_Manager::HIDDEN,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'sticky',
			[
				'label' => __( 'Sticky?', 'hub-elementor-addons' ),
				'type' => ! defined( 'ELEMENTOR_PRO_VERSION' ) ? Controls_Manager::SWITCHER : Controls_Manager::HIDDEN,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'cm_sticky' => ''
				]
			]
		);

		$this->add_control(
			'cm_sticky_type',
			[
				'label' => __( 'Sticky type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-sticky-menu-default',
				'options' => [
					'lqd-sticky-menu-default' => __( 'Default', 'hub-elementor-addons' ),
					'lqd-sticky-menu-floating' => __( 'Floating', 'hub-elementor-addons' ),
					'lqd-sticky-menu-floating-vertical' => __( 'Floating vertical', 'hub-elementor-addons' ),
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'sticky',
							'operator' => '==',
							'value' => 'yes'
						],
						[
							'name' => 'cm_sticky',
							'operator' => '==',
							'value' => 'yes'
						]
					],
				],
			]
		);

		$this->add_responsive_control(
			'cm_sticky_vertical_pos',
			[
				'label' => __( 'Menu alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'hub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'hub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'right',
				'toggle' => false,
				'condition' => [
					'sticky' => 'yes',
					'cm_sticky_type' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_responsive_control(
			'cm_sticky_vertical_offset_right',
			[
				'label' => __( 'Offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 60,
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-sticky-menu' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				],
				'condition' => [
					'sticky' => 'yes',
					'cm_sticky_type' => 'lqd-sticky-menu-floating-vertical',
					'cm_sticky_vertical_pos' => 'right'
				],
			]
		);

		$this->add_responsive_control(
			'cm_sticky_vertical_offset_left',
			[
				'label' => __( 'Offset', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 60,
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-sticky-menu' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				],
				'condition' => [
					'sticky' => 'yes',
					'cm_sticky_type' => 'lqd-sticky-menu-floating-vertical',
					'cm_sticky_vertical_pos' => 'left'
				],
			]
		);

		$this->add_control(
			'inline',
			[
				'label' => __( 'Inline?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'sticky',
							'operator' => '!=',
							'value' => 'yes'
						],
						[
							'name' => 'cm_sticky',
							'operator' => '!=',
							'value' => 'yes'
						]
					],
				],
			]
		);

		$this->add_control(
			'auto_expand_items',
			[
				'label' => __( 'Auto expand items?', 'hub-elementor-addons' ),
				'description' => __( 'Expand items to fill the container', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'inline-nav',
				'default' => '',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'sticky',
							'operator' => '==',
							'value' => 'yes'
						],
						[
							'name' => 'cm_sticky',
							'operator' => '==',
							'value' => 'yes'
						],
						[
							'name' => 'cm_sticky_type',
							'operator' => '!=',
							'value' => 'lqd-sticky-menu-floating-vertical'
						],
					],
				],
			]
		);

		$this->add_control(
			'add_separator',
			[
				'label' => __( 'Add separator?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'inline' => 'inline-nav',
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_control(
			'separator',
			[
				'label' => __( 'Separator', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Add separator', 'hub-elementor-addons' ),
				'condition' => [
					'add_separator' => 'yes',
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_responsive_control(
			'spacing',
			[
				'label' => __( 'Links space bottom', 'hub-elementor-addons' ),
				'description' => __( 'Space between items. Does not work if "Auto Expand Items?" is enabled.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-custom-menu > .reset-ul > li:not(:last-child), {{WRAPPER}} .lqd-custom-menu-btn-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'spacing2',
			[
				'label' => __( 'Links space between', 'hub-elementor-addons' ),
				'description' => __( 'Space between items. Does not work if "Auto Expand Items?" is enabled.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-custom-menu > .reset-ul > li:not(:last-child)' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lqd-custom-menu-btn-wrap' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'inline' => 'yes',
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				]
			]
		);

		$this->add_responsive_control(
			'links_padding',
			[
				'label' => __( 'Links padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-custom-menu > ul > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				]
			]
		);

		$this->add_control(
				'links_border_radius',
				[
					'label' => __( 'Links border radius', 'hub-elementor-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .lqd-custom-menu > ul > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
					]
				]
			);

		$this->add_control(
			'add_toggle',
			[
				'label' => __( 'Add toggle button?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'sticky',
							'operator' => '==',
							'value' => ''
						],
						[
							'name' => 'cm_sticky',
							'operator' => '==',
							'value' => ''
						]
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dropdown_collapsed',
			[
				'label' => __( 'Collapsed?', 'hub-elementor-addons' ),
				'description' => __( 'Enable if you want the dropdown collapsed by default.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);

		$this->add_control(
			'mobile_add_toggle',
			[
				'label' => __( 'Collapsible on mobile?', 'hub-elementor-addons' ),
				'description' => __( 'Enable this option if you want to make the menu collapsible on mobile', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_control(
			'toggle_button_text',
			[
				'label' => __( 'Toggle text', 'hub-elementor-addons' ),
				'description' => __( 'Add text for toggle button', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Add separator', 'hub-elementor-addons' ),
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);

		$this->add_control(
			'mobile_toggle_button_text',
			[
				'label' => __( 'Mobile toggle text', 'hub-elementor-addons' ),
				'description' => __( 'Add text for mobile toggle button', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Add separator', 'hub-elementor-addons' ),
				'condition' => [
					'mobile_add_toggle' => 'yes'
				],
			]
		);

		$this->add_control(
			'toggle_shape',
			[
				'label' => __( 'Toggle shape', 'hub-elementor-addons' ),
				'description' => __( 'Select a shape for the toggle button', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Sharp', 'hub-elementor-addons' ),
					'round' => __( 'Round', 'hub-elementor-addons' ),
					'circle' => __( 'Circle', 'hub-elementor-addons' ),
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);

		$this->add_control(
			'toggle_icon',
			[
				'label' => __( 'Toggle icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-bars',
					'library' => 'solid',
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'add_scroll_indicator',
			[
				'label' => __( 'Scroll indicator?', 'hub-elementor-addons' ),
				'description' => __( 'Add scroll indicator to each menu item.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'sticky',
							'operator' => '==',
							'value' => 'yes'
						],
						[
							'name' => 'cm_sticky',
							'operator' => '==',
							'value' => 'yes'
						],
						[
							'name' => 'cm_sticky_type!',
							'operator' => '!=',
							'value' => 'lqd-sticky-menu-floating-vertical'
						],
					],
				],
			]
		);

		$this->add_control(
			'magnetic_items',
			[
				'label' => __( 'Magnetic items?', 'hub-elementor-addons' ),
				'description' => __( 'Enables magnetic menu items, If custom cursor is enabled from Theme Options.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				]
			]
		);

		$this->add_control(
			'items_decoration',
			[
				'label' => __( 'Border style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-menu-td-none',
				'options' => [
					'lqd-menu-td-none' => __( 'None', 'hub-elementor-addons' ),
					'lqd-menu-td-underline' => __( 'Underline', 'hub-elementor-addons' ),
				],
				'condition' => [
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				]
			]
		);
        $this->end_controls_section();

		// Element Tags
		$this->start_controls_section(
			'element_tags_section',
			[
				'label' => __( 'HTML elements', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'nav_collapse',
			[
				'label' => esc_html__( 'Navbar Container', 'plugin-name' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'div',
				'options' => [
					'div' => 'div',
					'header' => 'header',
					'footer' => 'footer',
					'main' => 'main',
					'article' => 'article',
					'section' => 'section',
					'aside' => 'aside',
					'nav' => 'nav',
					'ul' => 'ul',
				],
			]
		);

		$this->add_control(
			'nav',
			[
				'label' => esc_html__( 'Navbar', 'plugin-name' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ul',
				'options' => [
					'div' => 'div',
					'header' => 'header',
					'footer' => 'footer',
					'main' => 'main',
					'article' => 'article',
					'section' => 'section',
					'aside' => 'aside',
					'nav' => 'nav',
					'ul' => 'ul',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'tyopgraphys_section',
			[
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typographys',
				'label' => __( 'Menu typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .reset-ul > li > a',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typographys',
				'label' => __( 'Badges typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .link-badge',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_icon_typography',
				'label' => __( 'Icons typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-fancy-menu > ul > li > a > .link-icon',
			]
		);
		$this->end_controls_section();

		// Navigation Container Styling
		$this->start_controls_section(
			'container_section',
			[
				'label' => __( 'Navigation container styling', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bgcolor',
			[
				'label' => __( 'Navigation background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu' => 'background: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'container_border_color',
			[
				'label' => __( 'Navigation border color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu' => 'border-bottom:1px solid {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Menu Items Styling
		$this->start_controls_section(
			'menu_items_section',
			[
				'label' => __( 'Menu items styling', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Links color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > .reset-ul > li > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'hcolor',
			[
				'label' => __( 'Links hover/active color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > .reset-ul > li > a:hover, {{WRAPPER}} .lqd-fancy-menu li.is-active > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'bg_color',
			[
				'label' => __( 'Link background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > .reset-ul > li > a' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'bg_hcolor',
			[
				'label' => __( 'Hover link background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > .reset-ul > li > a:hover, {{WRAPPER}} .lqd-fancy-menu li.is-active > a' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'border_color',
			[
				'label' => __( 'Links border color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > .reset-ul > li > a' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'border_hcolor',
			[
				'label' => __( 'Links hover border color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > .reset-ul > li > a:hover, {{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > .reset-ul > li.is-active > a' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > .reset-ul > li .link-icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'icon_hcolor',
			[
				'label' => __( 'Hover icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > .reset-ul > li > a:hover .link-icon, {{WRAPPER}} .lqd-fancy-menu li.is-active .link-icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'toggle_color',
			[
				'label' => __( 'Toggle color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-custom-menu-dropdown-btn' => 'color: {{VALUE}}',
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);
		$this->add_control(
			'toggle_active_color',
			[
				'label' => __( 'Toggle active color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-custom-menu-dropdown-btn.is-active' => 'color: {{VALUE}}',
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);
		$this->add_control(
			'toggle_bg_color',
			[
				'label' => __( 'Toggle bg color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-custom-menu-dropdown-btn' => 'background: {{VALUE}}',
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);
		$this->add_control(
			'toggle_active_bg_color',
			[
				'label' => __( 'Toggle active bg color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-custom-menu-dropdown-btn.is-active' => 'background: {{VALUE}}',
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);
		$this->add_control(
			'scroll_indicator_bg',
			[
				'label' => __( 'Scroll indicator bg', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-scrl-indc .lqd-scrl-indc-line' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'scroll_indicator_progress',
			[
				'label' => __( 'Scroll indicator progress', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-scrl-indc .lqd-scrl-indc-el' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Sticky Colors
		$this->start_controls_section(
			'sticky_colors_section',
			[
				'label' => __( 'Sticky colors', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_bgcolor',
			[
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > .reset-ul > li > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_hcolor',
			[
				'label' => __( 'Hover color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > .reset-ul > li > a:hover, .is-stuck .lqd-fancy-menu li.is-active > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_bg_color',
			[
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > .reset-ul > li > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_bg_hcolor',
			[
				'label' => __( 'Hover background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > .reset-ul > li > a:hover, .is-stuck .lqd-fancy-menu li.is-active > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_border_color',
			[
				'label' => __( 'Links border color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > .reset-ul > li > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_border_hcolor',
			[
				'label' => __( 'Links hover border color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > .reset-ul > li > a:hover, .is-stuck {{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > .reset-ul > li.is-active > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_icon_color',
			[
				'label' => __( 'Icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > .reset-ul > li .link-icon' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_icon_hcolor',
			[
				'label' => __( 'Hover icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > .reset-ul > li > a:hover .link-icon, .is-stuck .lqd-fancy-menu li.is-active .link-icon' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->end_controls_section();

		// Colors Over Light Rows
		$this->start_controls_section(
			'sticky_light_section',
			[
				'label' => __( 'Colors over light rows', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_light_bgcolor',
			[
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > .reset-ul > li > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_hcolor',
			[
				'label' => __( 'Hover color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > .reset-ul > li > a:hover, {{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu li.is-active > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_bg_color',
			[
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > .reset-ul > li > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_bg_hcolor',
			[
				'label' => __( 'Hover background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > .reset-ul > li > a:hover, {{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu li.is-active > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_border_color',
			[
				'label' => __( 'Border color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu.menu-items-has-border > .reset-ul > li > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_border_hcolor',
			[
				'label' => __( 'Hover border color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu.menu-items-has-border > .reset-ul > li > a:hover, {{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu.menu-items-has-border > .reset-ul > li.is-active > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_icon_color',
			[
				'label' => __( 'Icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > .reset-ul > li .link-icon' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_icon_hcolor',
			[
				'label' => __( 'Hover icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > .reset-ul > li > a:hover .link-icon, {{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu li.is-active .link-icon' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->end_controls_section();

		// Colors Over Light Rows
		$this->start_controls_section(
			'sticky_dark_section',
			[
				'label' => __( 'Colors over dark rows', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_dark_bgcolor',
			[
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > .reset-ul > li > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_hcolor',
			[
				'label' => __( 'Hover color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > .reset-ul > li > a:hover, {{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu li.is-active > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_bg_color',
			[
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > .reset-ul > li > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_bg_hcolor',
			[
				'label' => __( 'Hover background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > .reset-ul > li > a:hover, {{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu li.is-active > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_border_color',
			[
				'label' => __( 'Border color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu.menu-items-has-border > .reset-ul > li > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_border_hcolor',
			[
				'label' => __( 'Hover border color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu.menu-items-has-border > .reset-ul > li > a:hover, {{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu.menu-items-has-border > .reset-ul > li.is-active > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_icon_color',
			[
				'label' => __( 'Icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > .reset-ul > li .link-icon' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_icon_hcolor',
			[
				'label' => __( 'Hover icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > .reset-ul > li > a:hover .link-icon, {{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu li.is-active .link-icon' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->end_controls_section();

		ld_el_btn($this, 'ib_');

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

		extract( $settings );

		$menu_slug = (isset($settings['menu_slug'] )? $settings['menu_slug'] : '' );

		if ( !$cm_sticky_force ){
			$sticky = ( defined( 'ELEMENTOR_PRO_VERSION' ) && ($cm_sticky == 'yes' || !$sticky) ) ? $cm_sticky : $sticky;
		} else {
			$sticky = $cm_sticky;
		}

		$menu_fill =
		$bg_color || $bg_hcolor ||
		$sticky_bg_color || $sticky_bg_hcolor ||
		$sticky_light_bg_color || $sticky_light_bg_hcolor ||
		$sticky_dark_bg_color || $sticky_dark_bg_hcolor ? 'menu-items-has-fill' : '';
		
		$toggle_fill = ( $add_toggle && ( $toggle_bg_color || $toggle_active_bg_color ) ) ? 'toggle-has-fill' : '';
		
		$items_border = $border_color || $border_hcolor ? 'menu-items-has-border' : '';

		$pos_classname = 'pos-rel';

		if ( $sticky ) {
			if ( $cm_sticky_type === 'lqd-custom-menu-floating-vertical' ) {
				$pos_classname = 'pos-fix';
			} else {
				$pos_classname = 'pos-abs';
			}
		}
		
		$classes = array(
			'lqd-fancy-menu',
			'lqd-custom-menu',
			$pos_classname,
			$menu_fill,
			$items_border,
			$toggle_fill,
			$menu_alignment,
			$items_decoration,
			$sticky ? 'lqd-sticky-menu' : '',
			$sticky && $cm_sticky_type ? $cm_sticky_type : '',
			$sticky && $cm_sticky_type === 'lqd-custom-menu-floating-vertical' ? $cm_sticky_vertical_pos : '',
			$sticky && $cm_sticky_type === 'lqd-custom-menu-floating-vertical' ? 'ws-nowrap' : '',
			$mobile_add_toggle === 'yes' ? 'lqd-custom-menu-mobile-collapsible' : '',
			$magnetic_items === 'yes' ? 'lqd-magnetic-items' : '',
			$auto_expand_items === 'inline-nav' ? 'lqd-custom-menu-expand-items' : '',
			$show_button === 'yes' ? 'lqd-custom-menu-has-btn' : '',
			$show_button === 'yes' && ($inline || $sticky) ? 'd-flex align-items-center' : '',
		);
		
		$ul_classes = array(
			'reset-ul',
			($inline || $sticky) ? 'inline-ul' : '',
			$add_toggle === 'yes' && $settings['dropdown_collapsed'] !== 'yes' ? 'in is-active' : '',
			$add_toggle ? 'collapse lqd-custom-menu-dropdown w-100' : ''
		);
		
		$toggle_classes = array(
			'lqd-custom-menu-dropdown-btn',
			'd-flex',
			'align-items-center',
			$toggle_shape === 'round' ? 'border-radius-4' ? 'circle' : 'border-radius-circle' : '',
			$add_toggle === 'yes' && $settings['dropdown_collapsed'] !== 'yes' ? 'is-active' : ''
		);

		$scroll_ind = '';
		$scroll_data = array();
		if ( 'yes' === $localscroll ) { 
			$scroll_data['data-localscroll'] = true;
			$scroll_data['data-localscroll-options'] = wp_json_encode( array(
				"itemsSelector" => "> li > a",
				"trackWindowScroll" => true,
				"includeParentAsOffset" => $sticky ? true : false,
				"offsetElements" => "[data-sticky-header] .lqd-head-sec-wrap:not(.lqd-hide-onstuck), #wpadminbar, body.elementor-page .main-header[data-sticky-header] > .elementor > .elementor-section-wrap > .elementor-section:not(.lqd-hide-onstuck):not(.lqd-stickybar-wrap), body.elementor-page .main-header[data-sticky-header] > .elementor > .elementor-section:not(.lqd-hide-onstuck):not(.lqd-stickybar-wrap)"
			));
		}

		$is_sticky_default = $sticky && $cm_sticky_type === 'lqd-sticky-menu-default';
		$is_sticky_floating = $sticky && $cm_sticky_type === 'lqd-sticky-menu-floating';
		$is_floating_vertical = $sticky && $cm_sticky_type === 'lqd-sticky-menu-floating-vertical';

		?>

			<<?php echo $settings['nav_collapse']; ?>  
				class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>"
				<?php if( $is_sticky_default ) { ?>
					data-pin="true" 
					data-pin-options='{ "start": "top+=1 top", "offset": "[data-sticky-header] .lqd-head-sec-wrap:not(.lqd-hide-onstuck), [data-sticky-header] .lqd-mobile-sec, #wpadminbar, body.elementor-page .main-header[data-sticky-header] > .elementor > .elementor-section-wrap > .elementor-section:not(.lqd-hide-onstuck):not(.lqd-stickybar-wrap), body.elementor-page .main-header[data-sticky-header] > .elementor > .elementor-section:not(.lqd-hide-onstuck):not(.lqd-stickybar-wrap)", "duration": "last-link" }' 
					data-move-element='{ "target": ".vc_row" }'
				<?php } else if ( $is_sticky_floating ) { ?>
					data-inview="true"
					data-inview-options='{ "toggleBehavior": "toggleInView" }'
				<?php } else if ( $is_floating_vertical ) { ?>
					data-move-element='{ "target": ".vc_row" }'
				<?php }  ?>
			>
			<?php if( 'yes' === $add_toggle || 'yes' === $mobile_add_toggle ) { ?>
			<span class="<?php echo ld_helper()->sanitize_html_classes( $toggle_classes ) ?>" data-target="#<?php echo $this->get_id() ?>" data-toggle="collapse" data-ld-toggle="true" data-toggle-options='{ "closeOnOutsideClick": {"ifNotIn": "#lqd-site-content"} }'>

				<?php if ( 'yes' === $add_toggle ) { ?>
				<span class="d-inline-flex me-3">
					<?php Icons_Manager::render_icon( $settings['toggle_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</span>
				<?php } ?>
				
				<?php if( !empty( $toggle_button_text ) || ! empty($mobile_toggle_button_text) ) { ?>
					<span class="toggle-label">
						<?php if( !empty( $toggle_button_text ) ) { ?>
							<?php echo wp_kses_post( do_shortcode( $toggle_button_text ) )?>
						<?php } else if ( ! empty($mobile_toggle_button_text) ) { ?>
							<?php echo wp_kses_post( do_shortcode( $mobile_toggle_button_text ) )?>
						<?php } ?>
					</span>
				<?php } ?>

				<span class="expander-icon ms-auto d-inline-flex">
					<i class="lqd-icn-ess icon-ion-ios-arrow-down"></i>
				</span>
			</span>
			<?php } ?>

			<?php if( 'wp_menus' === $source ) : ?>
			<?php

				if ( 'yes' === $add_scroll_indicator ) {
					$scroll_ind = '<span class="lqd-scrl-indc lqd-scrl-indc-h lqd-scrl-indc-scale d-flex w-100 ws-nowrap" data-lqd-scroll-indicator="true" data-scrl-indc-options=\'{ "scrollingTarget": "siblingsHref", "dir": "x", "scale": true, "start": "top bottom", "end": "top top-=99.65%", "waitForElementMove": '. $is_sticky_default .' }\'>
						<span class="lqd-scrl-indc-inner d-flex align-items-center w-100 h-100 overflow-hidden">
							<span class="lqd-scrl-indc-line flex-grow-1 pos-rel">
								<span class="lqd-scrl-indc-el d-inline-block"></span>
							</span>
						</span>
					</span>';
				}

				if( is_nav_menu( $menu_slug ) ) {
					wp_nav_menu( array(
						'menu'           => $menu_slug,
						'container'      => 'ul',
						'container_id'   => '',
						'menu_id'        => $this->get_id(),
						'before'         => false,
						'after'          => $scroll_ind,
						'menu_class'     => esc_attr( implode( ' ', $ul_classes ) ),
						'items_wrap'     => '<' . $settings["nav"] . ' id="%1$s" class="%2$s" itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope"' . ld_helper()->html_attributes( $scroll_data ) . '>%3$s</' . $settings["nav"] . '>',
						'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new \Liquid_Mega_Menu_Walker : '',
					) );
				}
				else {
					wp_nav_menu( array(
						'container'   => 'ul',
						'container_id'   => '',
						'menu_id'        => $this->get_id(),
						'before'      => false,
						'after'       => $scroll_ind,
						'menu_class'     => esc_attr( implode( ' ', $ul_classes ) ),
						'items_wrap'     => '<' . $settings["nav"] . ' id="%1$s" class="%2$s" itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope"' . ld_helper()->html_attributes( $scroll_data ) . '>%3$s</' . $settings["nav"] . '>',
						'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new \Liquid_Mega_Menu_Walker : '',
					));

				};
			?>
			<?php else: ?>
				<ul class="<?php echo ld_helper()->sanitize_html_classes( $ul_classes ) ?>" id="<?php echo $this->get_id() ?>" <?php echo ld_helper()->html_attributes( $scroll_data ); ?>>
				<?php
					foreach ( $items as $item ) {
						if ( empty( $item['url'] ) ) {
							continue;
						}

						$badge = $badge_color = '';
						
						$attr = array( 
							'href' => esc_url( $item['url'] ), 
							'target' => esc_attr( $item['target'] === 'yes' ? '_blank' : '_self' )
						);

						if ( 'yes' === $add_scroll_indicator ) {
							$scroll_ind = '<span class="lqd-scrl-indc lqd-scrl-indc-h lqd-scrl-indc-scale d-flex w-100 ws-nowrap" data-lqd-scroll-indicator="true" data-scrl-indc-options=\'{ "scrollingTarget": "' . $attr['href'] . '", "dir": "x", "scale": true, "start": "top bottom", "end": "top top-=99.65%", "waitForElementMove": '. $is_sticky_default .' }\'>
								<span class="lqd-scrl-indc-inner d-flex align-items-center w-100 h-100 overflow-hidden">
									<span class="lqd-scrl-indc-line flex-grow-1 pos-rel">
										<span class="lqd-scrl-indc-el d-inline-block"></span>
									</span>
								</span>
							</span>';
						}
						
						if( !empty( $item['badge'] ) ) {
							if( !empty( $item['badge_color'] ) ) {
								$badge_color = 'style="--badge-color: ' . $item['badge_color'] . ';"';	
							}
							$badge = '<span class="link-badge" ' . $badge_color . '>' . $item['badge'] . '</span>';
						}
						?>

						<li>
							<a <?php echo ld_helper()->html_attributes( $attr ); ?> > 

								<?php if( isset( $item['icon_classname']['value'] ) ) : ?>
									<span class="link-icon d-inline-flex hide-if-empty <?php echo esc_attr( $item['icon_alignment'] . ' ' . $icon_pos ); ?>"><?php Icons_Manager::render_icon( $item['icon_classname'], [ 'aria-hidden' => 'true' ] ); ?></span>	
								<?php endif; ?>

								<?php if ( $sticky && 'lqd-sticky-menu-floating-vertical' === $cm_sticky_type ) : ?>
								<span class="link-txt">
								<?php endif; ?>
									<?php echo do_shortcode( $item['label'] ); ?>  
								<?php if ( $sticky && 'lqd-sticky-menu-floating-vertical' === $cm_sticky_type ) : ?>
								</span>
								<?php endif; ?>
								<?php echo $badge ?>
							</a>
							<?php echo $scroll_ind ?>
						</li>

						<?php
						
					}
				?>
				</ul>
			<?php endif; ?>
			<?php if ( $show_button === 'yes' ) : ?>
				<div class="lqd-custom-menu-btn-wrap">
				<?php
					$button = new \LQD_Elementor_Render_Button;
					$button->get_button( $this, 'ib_' ); 
				?>
				</div>
			<?php endif; ?>
			</<?php echo $settings['nav_collapse']; ?>>
		<?php
		
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Custom_Menu() );