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
 * @since 2.0.0
 */
class LD_Animated_Blob extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_animated_blob';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Animated Blob', 'hub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-shape lqd-element';
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
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'shape', 'animate', 'svg', 'blob' ];
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'liquid-animated-blob' ];
		} else {
			return [''];
		}
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.0.0
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

		$this->add_control(
			'width',
			[
				'label' => __( 'Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => '512'
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'height',
			[
				'label' => __( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => '512'
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'radius',
			[
				'label' => __( 'Shape radius', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => '120'
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => __( 'Speed', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => '1'
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'amplitude',
			[
				'label' => __( 'Amplitude', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => '2'
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'anchor_points',
			[
				'label' => __( 'Anchor points', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => '4'
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'gradient_type',
			[
				'label' => esc_html__( 'Gradient type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'linear' => 'Linear',
					'radial' => 'Radial',
				],
				'default' => 'linear',
				'render_type' => 'template'
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'scolors',
			[
				'label' => __( 'Colors', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'colors',
			[
				'label' => __( 'Colors', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ scolors }}}',
				'render_type' => 'template'
			]
		);

		$this->end_controls_section();

	}

	protected function get_blob_data_options() {
		
		$settings = $this->get_settings_for_display();

		$colors = array();
		$color_arr = $settings['colors'];
		foreach ( $color_arr as $color ) {
			$colors[] = $color['scolors'];
		}
		
		$opts = array(
			'id' => 'lqd-animated-blob-' . $this->get_ID(),
			'width' => $settings['width']['size'] ? (int)$settings['width']['size'] : 512,
			'height' => $settings['height']['size'] ? (int)$settings['height']['size'] : 512,
			'radius' => $settings['radius']['size'] ? (int)$settings['radius']['size'] : 120,
			'speed' => $settings['speed']['size'] ? (int)$settings['speed']['size'] : 1,
			'amplitude' => $settings['amplitude']['size'] ? (int)$settings['amplitude']['size'] : 2,
			'anchorPoints' => $settings['anchor_points']['size'] ? (int)$settings['anchor_points']['size'] : 4,
			'gradientType' => $settings['gradient_type'] ? $settings['gradient_type'] : 'linear',
		);

		if ( count($colors) > 0 ) {
			$opts['colors'] = $colors;
		}

		return wp_json_encode( $opts );
		
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 2.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$width = $settings['width']['size'] ? (int)$settings['width']['size'] : 512;
		$height = $settings['height']['size'] ? (int)$settings['height']['size'] : 512;

		$this->add_render_attribute(
			'wrapper',
			[
				'id' => 'lqd-animated-blob-' . $this->get_ID(),
				'class' => [ 
					'lqd-animated-blob',
				 ],
				 'data-lqd-animated-blob' => 'true',
				 'data-blob-options' => $this->get_blob_data_options(),
			]
		);
	
		$this->add_render_attribute(
			'svg_wrapper',
			[
				'viewBox' => '0 0 ' . $width . ' ' . $height,
				'width' => $width,
				'height' => $height

			]
		);

		?>

		<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<svg <?php $this->print_render_attribute_string( 'svg_wrapper' ); ?>>
			</svg>
		</figure>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Animated_Blob() );