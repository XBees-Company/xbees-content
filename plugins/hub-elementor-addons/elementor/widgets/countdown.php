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
 * @since 1.0.1
 */
class LD_Countdown extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_countdown';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Countdown', 'hub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-countdown lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.0.1
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
	 * @since 1.0.1
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'countdown', 'timer' ];
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {

		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'jquery-countdown' ];
		} else {
			return [''];
		}
		
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.1
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
			'due_date',
			[
				'label' => __( 'Due Date', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DATE_TIME,
				'picker_options' => [
					'enableTime' => false,
				]
			]
		);

		$this->add_control(
			'countdown_inline',
			[
				'label' => __( 'Inline?', 'hub-elementor-addons' ),
				'description' => __( 'Turn on to make counters and labels inline.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'countdown_align',
			[
				'label' => __( 'Alignment', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start'    => [
						'title' => __( 'Left', 'hub-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'hub-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'hub-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => __( 'Justified', 'hub-elementor-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .countdown .countdown-row' => 'justify-content: {{VALUE}};'
				],
				'default' => 'flex-start',
			]
		);

		$this->add_control(
			'labels_heading',
			[
				'label' => __( 'Labels', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'day_label',
			[
				'label' => __( 'Days', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( '"Days" - label to display on countdown', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'hours_label',
			[
				'label' => __( 'Hours', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( '"Hours" - label to display on countdown', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'min_label',
			[
				'label' => __( 'Minutes', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( '"Minutes" - label to display on countdown', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'sec_label',
			[
				'label' => __( 'Seconds', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( '"Seconds" - label to display on countdown', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'timezone',
			[
				'label' => __( 'Timezone', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Set timezone accordion to your country', 'hub-elementor-addons' ),
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'coundown_typography',
				'label' => __( 'Digits Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .countdown',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Labels Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .countdown .countdown-period',
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .countdown' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'digits_color',
			[
				'label' => __( 'Digits Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .countdown-amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sep_color',
			[
				'label' => __( 'Sepearator Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .countdown-sep' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function get_plugin_opts() {

		$due_date = strtotime( $this->get_settings( 'due_date' ) );

		$y = ! empty( date( 'Y', $due_date  )) ? date( 'Y', $due_date ) : '2024';
		$m = date( 'm', $due_date );
		$d = date( 'd', $due_date );

		$opts = array(
			'until' => "$y-$m-$d"
		);

		if( ! empty( $this->get_settings( 'day_label' ) ) ) {
			$opts['daysLabel'] = esc_attr( $this->get_settings( 'day_label' ) );
		}
		
		if( ! empty( $this->get_settings( 'hours_label' ) ) ) {
			$opts['hoursLabel'] = esc_attr( $this->get_settings( 'hours_label' ) );
		}
		
		if( ! empty( $this->get_settings( 'min_label' ) ) ) {
			$opts['minutesLabel'] = esc_attr( $this->get_settings( 'min_label' ) );
		}
		
		if( ! empty( $this->get_settings( 'sec_label' ) ) ) {
			$opts['secondsLabel'] = esc_attr( $this->get_settings( 'sec_label' ) );
		}
		
		if( ! empty( $this->get_settings( 'timezone' ) ) ) {
			$opts['timezone'] = esc_attr( $this->get_settings( 'timezone' ) );
		}

		return wp_json_encode( $opts );
	}
		

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.1
	 * @access protected
	 */
	protected function render() {
		
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'wrapper',
			[
				'id' => 'lqd-countdown-' . $this->get_id(),
				'class' => [ 'countdown', 'h3', 'mt-0', 'mb-0', $settings['countdown_inline'] ],
				'data-plugin-countdown' => 'true',
				'data-countdown-options' => $this->get_plugin_opts(),

			]
		);

		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>></div>

		<?php
		
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Countdown() );