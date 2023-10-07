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
class LD_Header_Search extends Widget_Base {

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
		return 'ld_header_search';
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
		return __( 'Liquid Header Search', 'hub-elementor-addons' );
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
		return 'eicon-search lqd-element';
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
		return [ 'hub-header' ];
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
		return [ 'header', 'search' ];
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
				'label' => __( 'Header search', 'hub-elementor-addons' ),
			)
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'hub-elementor-addons' ),
					'frame' => __( 'Frame', 'hub-elementor-addons' ),
					'slide-top' => __( 'Slide Top', 'hub-elementor-addons' ),
					'zoom-out' => __( 'Zoom Out', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'search_type',
			[
				'label' => __( 'Search by', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => [
					'all'  => __( 'All', 'hub-elementor-addons' ),
					'post'  => __( 'Post', 'hub-elementor-addons' ),
					'product' => __( 'Product', 'hub-elementor-addons' ),
					'custom' => __( 'Custom', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'custom_search_type',
			[
				'label' => __( 'Custom post type', 'hub-elementor-addons' ),
				'description' => __( 'Enter the custom post type slug', 'hub-elementor-addons' ),
				'placeholder' => 'my-post-type-slug',
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'search_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'show_icon',
			[
				'label' => __( 'Show icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'lqd-module-show-icon' => __( 'Yes', 'hub-elementor-addons' ),
				'lqd-module-hide-icon' => __( 'No', 'hub-elementor-addons' ),
				'return_value' => 'lqd-module-show-icon',
				'default' => 'lqd-module-show-icon',
				'separator' => 'before',
			]
		);

		$current_header_id = liquid_get_custom_header_id(); 
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $current_header_id );

		if ( $page_settings_model->get_settings( 'enable_mobile_header_builder' ) === 'yes' ){
			$hide_for_mhb = array('lqd_hide' => 'true');
		} else {
			$hide_for_mhb = '';
		}

		$this->add_control(
			'show_on_mobile',
			[
				'label' => __( 'Show on mobile', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'hub-elementor-addons' ),
				'label_off' => __( 'No', 'hub-elementor-addons' ),
				'return_value' => 'lqd-show-on-mobile',
				'default' => '',
				'condition' => $hide_for_mhb
			]
		);

		$this->add_control(
			'icon_style',
			[
				'label' => __( 'Icon style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-module-icon-plain',
				'options' => [
					'lqd-module-icon-plain' => __( 'Plain', 'hub-elementor-addons' ),
					'lqd-module-icon-outline' => __( 'Outlined', 'hub-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_text',
			[
				'label' => __( 'Search icon text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 4,
				'description' => __( 'The text will be shown next to the search icon.', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'icon_text_align',
			[
				'label' => __( 'Icon text alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-module-trigger-txt-left',
				'options' => [
					'lqd-module-trigger-txt-left' => __( 'Left', 'hub-elementor-addons' ),
					'lqd-module-trigger-txt-right' => __( 'Right', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'scheme',
			[
				'label' => __( 'Color scheme', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Light', 'hub-elementor-addons' ),
					'lqd-module-search-dark' => __( 'Dark', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'style' => 'slide-top',
				)
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Type and hit enter', 'hub-elementor-addons' ),
				'placeholder' => __( 'Description under serchform', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'suggestions_title',
			[
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'May We Suggest?', 'hub-elementor-addons' ),
				'placeholder' => __( 'Add title for suggestions', 'hub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);

		$this->add_control(
			'suggestions',
			[
				'label' => __( 'Suggestion text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( '#drone #funny #catgif #broken #lost', 'hub-elementor-addons' ),
				'placeholder' => __( 'Add text for suggestions. for ex. #drone #funny #catgif #broken #lost', 'hub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);

		$this->add_control(
			'suggestions_title2',
			[
				'label' => __( 'Title 2', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Is It This?', 'hub-elementor-addons' ),
				'placeholder' => __( 'Add title for suggestions', 'hub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);

		$this->add_control(
			'suggestions2',
			[
				'label' => __( 'Suggestion text 2', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( '#drone #funny #catgif #broken #lost', 'hub-elementor-addons' ),
				'placeholder' => __( 'Add text for suggestions. for ex. #drone #funny #catgif #broken #lost', 'hub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);

		$this->add_control(
			'suggestions_title3',
			[
				'label' => __( 'Title 3', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Needle, Where Art Thou?', 'hub-elementor-addons' ),
				'placeholder' => __( 'Add title for suggestions', 'hub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);

		$this->add_control(
			'suggestions3',
			[
				'label' => __( 'Suggestion text 3', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( '#drone #funny #catgif #broken #lost', 'hub-elementor-addons' ),
				'placeholder' => __( 'Add text for suggestions. for ex. #drone #funny #catgif #broken #lost', 'hub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);

		$this->add_control(
			'i_type',
			[
				'label' => __( 'Icon library', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fontawesome',
				'options' => [
					'fontawesome'  => __( 'Icon Library', 'hub-elementor-addons' ),
					'image' => __( 'Image', 'hub-elementor-addons' ),
				],
			]
		);

        $this->add_control(
			'i_icon_fontawesome',
			[
				'label' => __( 'Icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'lqd-icn-ess icon-ld-search',
					'library' => 'lqd-essentials',
				],
                'condition' => array(
                    'i_type' => 'fontawesome',
                ),
			]
		);

		$this->add_control(
			'i_icon_image',
			[
				'label' => __( 'Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
                    'i_type' => 'image',
                ),
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors' => [
					'{{WRAPPER}} .ld-module-search .ld-module-trigger-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'i_type' => 'fontawesome',
				),
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_shape_width',
			[
				'label' => __( 'Icon shape width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => 5,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ld-module-search .ld-module-trigger-icon' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_style!' => 'lqd-module-icon-plain'
				]
			]
		);

		$this->add_control(
			'icon_shape_height',
			[
				'label' => __( 'Icon shape height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => 5,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ld-module-search .ld-module-trigger-icon' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_style!' => 'lqd-module-icon-plain'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Label typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .ld-module-trigger-txt',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-module-search .ld-module-trigger' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'primary_sticky_color',
			[
				'label' => __( 'Primary color on sticky header', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .ld-module-search .ld-module-trigger' => 'color: {{VALUE}}',
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
		
		$atts = $this->get_settings_for_display();

		$style = isset( $atts['style'] ) ? $atts['style'] : 'default';
		$icon_render = $atts['i_icon_fontawesome']['value'];
		$search_type = $atts['search_type'];

		if ( $search_type == 'custom' && empty( $atts['custom_search_type'] ) ) {
			$search_type = 'all';
		} else if ( $search_type == 'custom' && !empty( $atts['custom_search_type'] ) ) {
			$search_type = $atts['custom_search_type'];
		}

		// check
		$located = locate_template( "templates/header/header-search-$style.php" );

		if ( !file_exists( $located ) ) {
			$located = locate_template( 'templates/header/header-search.php' );
		}

		?>		
			<div class="d-flex <?php echo $atts['show_on_mobile'] ?>">
				<?php include $located; ?>
			</div>
		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Header_Search() );