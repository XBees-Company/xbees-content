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
class LD_Draw_Shape extends Widget_Base {

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
		return 'ld_draw_shape';
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
		return __( 'Draw Shape', 'hub-elementor-addons' );
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
		return 'eicon-lottie lqd-element';
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
		return [ 'draw', 'shape', 'animate', 'icon' ];
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
			return [ 'liquid-draw-shape' ];
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
			'svg_file',
			[
				'label' => __( 'Upload SVG File', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'media_type' => 'svg',
			]
		);

		$this->add_control(
			'shape_width',
			[
				'label' => __( 'Shape width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;'
				]
			]
		);

		$this->add_control(
			'shape_height',
			[
				'label' => __( 'Shape height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} svg' => 'height: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->add_control(
			'draw_from',
			[
				'label' => __( 'Draw from', 'hub-elementor-addons' ),
				'description' => __( 'Enter values you want to draw shape from', 'hub-elementor-addons' ),
				'default' => '0% 0%',
				'type' => Controls_Manager::TEXT,
				'render_type' => 'template',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'stagger',
			[
				'label' => __( 'Stagger', 'hub-elementor-addons' ),
				'description' => __( 'Delay between each animated object inside svg', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => '0'
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
			'start',
			[
				'label' => __( 'Start', 'hub-elementor-addons' ),
				'description' => __( 'Define when you want to start the animation. "top bottom" means when the "top" of the element hits the "bottom" of the viewport. You can also use percentage values. For example "0% 100%".', 'hub-elementor-addons' ),
				'default' => 'top bottom',
				'placeholder' => __( 'Default: top bottom', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'end',
			[
				'label' => __( 'End', 'hub-elementor-addons' ),
				'description' => __( 'Define when you want to end the animation. "center center" means when the "center" of the element hits the "center" of the viewport. You can also use percentage values. For example "50% 50%".', 'hub-elementor-addons' ),
				'default' => 'center center',
				'placeholder' => __( 'Default: center center', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'scrub',
			[
				'label' => __( 'scrub', 'hub-elementor-addons' ),
				'description' => __( 'Define the time the animation catches the scroll position.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'ease',
			[
				'label' => __( 'Easing', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => [ 'linear' ],
				'options' => [
					'linear' => 'linear',
					'power1.in' => 'power1.in',
					'power2.in' => 'power2.in',
					'power3.in' => 'power3.in',
					'power4.in' => 'power4.in',
					'sine.in' => 'sine.in',
					'expo.in' => 'expo.in',
					'circ.in' => 'circ.in',
					'back.in' => 'back.in',
					'bounce.in' => 'bounce.in',
					'elastic.in(1,0.2)' => 'elastic.in(1,0.2)',
					'power1.out' => 'power1.out',
					'power2.out' => 'power2.out',
					'power3.out' => 'power3.out',
					'power4.out' => 'power4.out',
					'sine.out' => 'sine.out',
					'expo.out' => 'expo.out',
					'circ.out' => 'circ.out',
					'back.out' => 'back.out',
					'bounce.out' => 'bounce.out',
					'elastic.out(1,0.2)' => 'elastic.out(1,0.2)',
					'power1.inOut' => 'power1.inOut',
					'power2.inOut' => 'power2.inOut',
					'power3.inOut' => 'power3.inOut',
					'power4.inOut' => 'power4.inOut',
					'sine.inOut' => 'sine.inOut',
					'expo.inOut' => 'expo.inOut',
					'circ.inOut' => 'circ.inOut',
					'back.inOut' => 'back.inOut',
					'bounce.inOut' => 'bounce.inOut',
					'elastic.inOut(1,0.2)' => 'elastic.inOut(1,0.2)',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

	}

	protected function get_draw_data_options() {
		
		$settings = $this->get_settings_for_display();
		
		$opts = array(
			'drawSVG' => !empty($settings['draw_from']) ? $settings['draw_from'] : '0% 0%',
			'stagger' => $settings['stagger']['size'] ? (float)$settings['stagger']['size'] : 0,
			'start' => !empty($settings['start']) ? $settings['start'] : 'top bottom',
			'end' => !empty($settings['end']) ? $settings['end'] : 'center center',
			'scrub' =>  $settings['scrub'] ? (float)$settings['scrub'] : true,
			'ease' =>  $settings['ease'],
		);

		return wp_json_encode( $opts );
		
	}

	protected function get_svg_options() {

		$svg = $this->get_settings_for_display( 'svg_file' );

		if ( !isset( $svg['url'] ) ){
			return;
		}

		$val = [
			'value' => [
				'url' => $svg['url'],
				'id' => $svg['id']
			],
			'library' => 'svg',
			'url' => $svg['url'],
			'id' => $svg['id'],
			'alt' => '',
			'source' => 'library'
		];

		return $val;

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

		$this->add_render_attribute(
			'wrapper',
			[
				'id' => 'lqd-draw-shape-' . $this->get_ID(),
				'class' => [ 
					'lqd-draw-shape',
				 ],
				 'data-lqd-draw-shape' => 'true',
				 'data-draw-shape-options' => $this->get_draw_data_options(),
			]
		);

		?>

		<figure <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php 
				Icons_Manager::render_icon( $this->get_svg_options(), [ 'aria-hidden' => 'true' ] ); 
			?>
		</figure>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Draw_Shape() );