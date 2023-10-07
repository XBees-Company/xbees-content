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
class LD_Throwable extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
  
		wp_register_script( 'matter', get_template_directory_uri() . '/assets/vendors/matter/matter.min.js', [], LD_ELEMENTOR_VERSION, true );
		wp_register_script( 'liquid-throwable', get_template_directory_uri() . '/assets/js/throwable/liquidThrowable.min.js', [], LD_ELEMENTOR_VERSION, true );
	 
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

		return [ 'matter', 'liquid-throwable' ];

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
		return 'ld_throwable';
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
		return __( 'Liquid Throwable', 'hub-elementor-addons' );
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
		return 'eicon-form-vertical lqd-element';
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
		return [ 'throwable', 'animation' ];
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
				'label' => __( 'Throwable', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
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
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'vh',
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-throwable-scene' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tag',
			[
				'label' => esc_html__( 'HTML Tag', 'elementor-pro' ),
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
				'default' => 'p',
			]
		);

		$this->add_control(
			'roundness',
			[
				'label' => esc_html__( 'Roundness', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '7em',
				'options' => [
					'0'  => esc_html__( 'Sharp', 'hub-elementor-addons' ),
					'7em' => esc_html__( 'Circle', 'hub-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-throwable-element-rot' => 'border-radius: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'scroll_gravity',
			[
				'label' => esc_html__( 'Scroll gravity', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0.25',
					'right' => '1.5',
					'bottom' => '0.25',
					'left' => '1.5',
					'unit' => 'em',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-throwable-element-rot' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'items_typography',
				'selector' => '{{WRAPPER}} .lqd-throwable-element-rot',
			]
		);


		$repeater = new Repeater();
		$repeater->add_control(
			'label', [
				'label' => esc_html__( 'Label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Label' , 'hub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tag',
			[
				'label' => esc_html__( 'HTML Tag', 'elementor-pro' ),
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
					'default' => 'Default'
				],
				'default' => 'default',
			]
		);

		$repeater->add_control(
			'itembgColor',
			[
				'label' => esc_html__( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-throwable-element-rot' => 'background-color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'textColor',
			[
				'label' => esc_html__( 'Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-throwable-element-rot' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-throwable-element-rot' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
						'label' => 'Awesome',
						'itembgColor' => '#a7ff9f',
						'textColor' => '#000',
					],
					[
						'label' => 'Accelerate',
						'itembgColor' => '#ffe3d3',
						'textColor' => '#000',
					],
					[
						'label' => 'Amazing',
						'itembgColor' => '#dbefe8',
						'textColor' => '#000',
					],
					[
						'label' => 'Quickly',
						'itembgColor' => '#d8c0ff',
						'textColor' => '#000',
					],
					[
						'label' => 'Increase response',
						'itembgColor' => '#8330c2',
						'textColor' => '#fff',
					],
					[
						'label' => 'Easily integrate',
						'itembgColor' => '#eaeaea',
						'textColor' => '#000',
					],
					[
						'label' => 'Personalized',
						'itembgColor' => '#ffc29f',
						'textColor' => '#000',
					],
					[
						'label' => 'Fantastic',
						'itembgColor' => '#c3f2d1',
						'textColor' => '#000',
					],
	
				],
				'title_field' => '{{{ label }}}',
			]
		);

		

		$this->end_controls_section();

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();

		$settings = $this->get_settings();

		$classnames = [];

		if ( ! \Elementor\Plugin::instance()->editor->is_edit_mode() ){
			array_push($classnames, 'pointer-events-none');
		}

		$this->add_render_attribute( '_wrapper', 'class', $classnames );
		
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

		$throwable_opts = [ 'roundness' => $settings['roundness'] ];

		if ( !empty( $settings['scroll_gravity'] ) ) {
			$throwable_opts['scrollGravity'] = true;
		}

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => [ 'lqd-throwable-scene', 'pos-rel', 'pointer-events-none', 'overflow-hidden' ], 
				'data-lqd-throwable-scene' => 'true',
				'data-throwable-options' => wp_json_encode( $throwable_opts ),
			]
		);

		if ( $settings['items'] ){
		?>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<?php
					foreach( $settings['items'] as $item ) {
						$tag = $settings['tag'];
						$tag = $item['tag'] !== 'default' ? $item['tag'] : $tag;
						printf( '<%1$s class="lqd-throwable-element d-inline-block pos-abs pos-tl ws-nowrap m-0 pointer-events-auto user-select-none elementor-repeater-item-%3$s" data-lqd-throwable-el style="opacity: 0;">
						<span class="lqd-throwable-element-rot d-inline-block">%2$s</span>
						</%1$s>', Utils::validate_html_tag( $tag ), $item['label'], esc_attr( $item['_id'] ) );
					}
				?>
			</div>
		<?php
		}

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Throwable() );