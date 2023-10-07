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
class LD_Progressbar_Circle extends Widget_Base {

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
		return 'ld_progressbar_circle';
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
		return __( 'Liquid Progress Bar Circle', 'hub-elementor-addons' );
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
		return 'eicon-counter-circle lqd-element';
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
		return [ 'progressbar', 'skill', 'bar', 'circle' ];
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
		return [ 'circle-progress' ];
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
				'label' => esc_html__( 'Content', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'My skill', 'hub-elementor-addons' ),
				'placeholder' => esc_html__( 'My skill', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'hide_percentage',
			[
				'label' => esc_html__( 'Hide percentage', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'hub-elementor-addons' ),
				'label_off' => esc_html__( 'No', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'percentage',
			[
				'label' => esc_html__( 'Percentage', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 75,
				],
			]
		);
		
		$this->add_control(
			'prefix',
			[
				'label' => esc_html__( 'Prefix', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'hide_percentage' => '',
				],
			]
		);
		
		$this->add_control(
			'suffix',
			[
				'label' => esc_html__( 'Suffix', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '%', 'hub-elementor-addons' ),
				'condition' => [
					'hide_percentage' => '',
				],
			]
		);

		$this->add_responsive_control(
			'circular_shape_size',
			[
				'label' => esc_html__( 'Shape size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ld-prgbr-circle-container, {{WRAPPER}} .ld-prgbr-circle-container canvas' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'circular_thickness',
			[
				'label' => esc_html__( 'Thickness', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 30,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'separator' => 'before',
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __( 'Title margin', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .liquid-progressbar-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-progressbar-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'percentage_typography',
				'label' => __( 'Percentage typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-progressbar-percentage',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Label Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-progressbar-title' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'percentage_color',
			[
				'label' => esc_html__( 'Percentage Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-progressbar-value,{{WRAPPER}} .liquid-progressbar-suffix,{{WRAPPER}} .liquid-progressbar-prefix' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'empty_color',
			[
				'label' => esc_html__( 'Empty bar Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'circular_color',
			[
				'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'circular_color2',
			[
				'label' => esc_html__( 'Color 2', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

	}

	protected function get_progressbar_data_options() {
		
		$opts   = array(
			'skipCreateMarkup' => true,
		);
		$percentage  = $this->get_settings_for_display()['percentage']['size'];

		if( !empty( $percentage ) ) {
			$opts['value'] = intval( $percentage );
		}

		$opts['orientation'] = 'circle';

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

		$this->add_render_attribute(
			'wrapper',
			[
				'id' => 'lqd-progressbar-circle-' . $this->get_ID(),
				'class' => [ 
					'lqd-progressbar',
					'ld-prgbr-circle',
					'pos-rel'
				 ],
				 'data-progressbar' => 'true',
				 'data-progressbar-options' => $this->get_progressbar_data_options(),
			]
		);

		$this->add_render_attribute(
			'label',
			[
				'class' => [ 
					'lqd-progressbar-title',
					'ws-nowrap',
				 ],
			]
		);

		$this->add_render_attribute(
			'details',
			[
				'class' => [ 
					'lqd-progressbar-details',
					'd-flex',
					'align-items-center',
					'justify-content-center',
					'z-index-3',
				],
			]
		);

		$this->add_render_attribute(
			'inner_details',
			[
				'class' => [ 
					'lqd-progressbar-details',
					'd-flex',
					'align-items-center',
					'justify-content-between',
					'lqd-overlay',
					'z-index-3',
				],
			]
		);

		$data_fill = (!empty($settings['circular_color']) && !empty($settings['circular_color2'])) ? 'data-fill=' . wp_json_encode( array( 'gradient' => array( $settings['circular_color'], $settings['circular_color2'] ) ) )  : '';
		$data_empty_fill = !empty($settings['empty_color']) ? $settings['empty_color'] : '#e6e6e6';

		$this->add_render_attribute(
			'circle_container',
			[
				'data-empty-fill' => $data_empty_fill,
				'data-thickness' => $settings['circular_thickness']['size'],
			]

		);

		?>
		
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?> >

			<div class="liquid-progressbar-inner">
				<span class="liquid-progressbar-bar">
					
				<?php if ( 'yes' !== $settings['hide_percentage'] ) : ?>
					<span class="liquid-progressbar-percentage">

						<?php if( ! empty( $settings['prefix'] ) ) : ?>
						<span class="liquid-progressbar-prefix"><?php echo esc_html( $settings['prefix'] ); ?></span>
						<?php endif; ?>

						<span class="liquid-progressbar-value"></span>
						
						<?php if( ! empty( $settings['suffix'] ) ) : ?>
						<span class="liquid-progressbar-suffix"><?php echo esc_html( $settings['suffix'] ); ?></span>
						<?php endif; ?>

					</span>
				<?php endif; ?>
				</span>
				
				<div class="ld-prgbr-circle-container" <?php echo esc_attr($data_fill);?> <?php echo $this->get_render_attribute_string( 'circle_container' ); ?>></div>
			</div>

			<?php if( $settings['label'] ) { ?>
				<div <?php $this->print_render_attribute_string( 'details' ); ?>>
					<h3 class="liquid-progressbar-title"><?php echo esc_html( $settings['label'] ); ?></h3>
				</div>
			<?php } ?>

		</div>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Progressbar_Circle() );