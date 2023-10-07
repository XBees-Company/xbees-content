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
class LD_Images_Text_Overlay extends Widget_Base {

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
		return 'ld_image_text_overlay';
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
		return __( 'Liquid Image Text Overlay', 'hub-elementor-addons' );
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
		return 'eicon-image-rollover lqd-element';
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
		return [ 'image', 'rgb', 'text', 'overlay' ];
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

		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'imagesloaded', 'threejs', 'gsap' ];
		} else {
			return [''];
		}
		
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
				'label' => __( 'Image text overlay', 'hub-elementor-addons' ),
			)
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
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
			'title',
			[
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Japay', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => __( 'Subtitle', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Japay App', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your subtitle here', 'hub-elementor-addons' ),
			]
		);


		$this->add_control(
			'category',
			[
				'label' => __( 'Category', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Mobile app', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your category here', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __('We help our clients succeed by creating brand identities, digital experiences, and print materials.'),
				'placeholder' => __( 'Type your text here', 'hub-elementor-addons' ),
			]
		);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'image_style_section',
			[
				'label' => __( 'Image style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => __( 'Image max width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1170,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-iot-img-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'title_style_section',
			[
				'label' => __( 'Title style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} h2',
			]
		);

		$this->add_control(
			'title_fill_color',
			[
				'label' => __( 'Title fill color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-iot h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'title_stroke_size',
			[
				'label' => __( 'Title stroke size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-iot h2' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}}; text-stroke-width: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'title_stroke_color',
			[
				'label' => __( 'Title stroke color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-iot h2' => '-webkit-text-stroke-color: {{VALUE}}; text-stroke-color: {{VALUE}};',
				],
			]
		);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_style_section',
			[
				'label' => __( 'Subtitle style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => __( 'Subtitle typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-iot-subtitle h3',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => __( 'Subtitle color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-iot-subtitle h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_space',
			[
				'label' => __( 'Text space', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-iot-content' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'ui',
			]
		);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'category_style_section',
			[
				'label' => __( 'Category style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography',
				'label' => __( 'Category typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-iot-cat',
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => __( 'Category color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-iot-cat' => 'color: {{VALUE}}',
				],
			]
		);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'content_style_section',
			[
				'label' => __( 'Content style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-iot-content',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Content color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-iot-content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		ld_el_btn($this, 'ib_'); // load button

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

			?>

			<div 
				id="<?php echo esc_attr( 'lqd-iot-' . $this->get_id() ) ?>" 
				class="lqd-iot pos-rel" 
				data-inview="true" 
				data-hover3d="true" 
				data-inview-options='{ "onImagesLoaded": true }'
				>
				<div class="lqd-iot-inner align-items-end justify-content-center perspective">
					
					<div class="lqd-iot-img-wrap pos-rel transform-style-3d" data-stacking-factor="0.5">
						
						<div class="lqd-iot-img pos-rel overflow-hidden z-index-2" data-webglhover="true">
							<div class="lqd-iot-img-inner" data-hoverme>
								<figure class="w-100">
									<?php echo wp_get_attachment_image( $settings['image']['id'], 'full', false, array( 'class' => 'w-100 invisible', 'alt' => esc_attr( $alt = !empty( $settings['title'] ) ? $settings['title'] : '' ) ) ); ?>
									<?php // echo '<img class="w-100 invisible" src="' . esc_url($settings['image']['url']) . '" />'; ?>
								</figure>
								<?php if( $settings['img_link']['url'] ) { $this->add_link_attributes( 'img_link', $settings['img_link'] ); ?>
									<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay z-index-2"></a>
								<?php } ?>
							</div>
						</div>
						
						<?php if( !empty( $settings['title'] ) ) { ?>
						<div class="lqd-iot-overlay-txt lqd-overlay d-flex align-items-center justify-content-center overflow-hidden pointer-events-none z-index-3">
							<div class="lqd-iot-overlay-txt-inner lqd-overlay d-flex align-items-center justify-content-center overflow-hidden text-center">
								<h2 class="mt-0 mb-0"><?php esc_html_e( $settings['title'] ); ?></h2>
							</div>
						</div>
						<?php } ?>

						<?php if( 'yes' === $settings['show_button'] ) { ?>
						<div class="lqd-iot-overlay-btn pos-abs pos-tr justify-content-end z-index-2">
							<?php
								$button = new \LQD_Elementor_Render_Button;
								$button->get_button( $this, 'ib_' ); 
							?>
						</div>
						<?php } ?>

					</div>

					<?php if( !empty( $settings['subtitle'] ) || !empty( $settings['category'] ) ) { ?>
					<div class="lqd-iot-content lqd-iot-content-left">
						<div class="lqd-iot-content-inner d-flex align-items-center">
							<?php if( !empty( $settings['subtitle'] ) ) { ?>
							<div class="lqd-iot-subtitle">
								<h3 class="h6"><?php esc_html_e( $settings['subtitle'] ); ?></h3>
							</div>
							<?php } ?>
							
							<?php if( !empty( $settings['category'] ) ) { ?>
							<div class="lqd-iot-cat">
								<ul class="reset-ul inline-ul">
									<li><?php esc_html_e( $settings['category'] ); ?></li>
								</ul>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>

					<?php if( !empty( $settings['content'] ) ) { ?>
					<div class="lqd-iot-content lqd-iot-content-right w-100">
						<div class="lqd-iot-content-inner">
							<p class="m-0">
								<?php echo $settings['content']; ?>
							</p>
						</div>
					</div>
					<?php } ?>

				</div>

			</div>
                        
			<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Images_Text_Overlay() );