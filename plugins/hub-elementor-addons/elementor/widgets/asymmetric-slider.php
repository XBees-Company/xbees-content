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
class LD_Asymmetric_Slider extends Widget_Base {

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
		return 'ld_asymmetric_slider';
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
		return __( 'Liquid Asymmetric Slider', 'hub-elementor-addons' );
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
		return 'eicon-slider-video lqd-element';
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
		return [ 'frame', 'image', 'slider' ];
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

		$repeater = new Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title' , 'hub-elementor-addons' ),
				'label_block' => true,
			]
		);
	
		$repeater->add_control(
			'subtitle', [
				'label' => __( 'Subtitle', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Subtitle' , 'hub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description', [
				'label' => __( 'Text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Text' , 'hub-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'btn_label', [
				'label' => __( 'Button Label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Button Label' , 'hub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'url',
			[
				'label' => __( 'URL (Link)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'hub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'identities',
			[
				'label' => __( 'Items', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Title', 'hub-elementor-addons' ),
						'subtitle' => __( 'Subtitle', 'hub-elementor-addons' ),
						'description' => __( 'Text', 'hub-elementor-addons' ),
						'image' => Utils::get_placeholder_image_src(),
						'btn_label' => __( 'Button Label', 'hub-elementor-addons' ),
						'url' => __( '#', 'hub-elementor-addons' ),
					],
					[
						'title' => __( 'Title 2', 'hub-elementor-addons' ),
						'subtitle' => __( 'Subtitle 2', 'hub-elementor-addons' ),
						'description' => __( 'Text 2', 'hub-elementor-addons' ),
						'image' => Utils::get_placeholder_image_src(),
						'btn_label' => __( 'Button Label 2', 'hub-elementor-addons' ),
						'url' => __( '#', 'hub-elementor-addons' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'title_tag',
			array(
				'label' => esc_html__( 'Title HTML Tag', 'hub-elementor-addons' ),
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
				'separator' => 'before',
			)
		);

		$this->add_control(
			'subtitle_tag',
			array(
				'label' => esc_html__( 'Subtitle HTML Tag', 'hub-elementor-addons' ),
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
				'default' => 'h4',
			)
		);

		$this->add_control(
			'description_tag',
			array(
				'label' => esc_html__( 'Description HTML Tag', 'hub-elementor-addons' ),
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
			)
		);

		$this->add_control(
		 'autoplay',
		 [
		   'label'   => esc_html__( 'Autoplay time', 'archub-elementor-addons' ),
		   'type'    => Controls_Manager::NUMBER,
		   'separator' => 'before'
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-asym-slider-content .lqd-asym-slider-title-element',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => __( 'Subtitle Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-asym-slider-content .lqd-asym-slider-subtitle-element',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __( 'Text Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-asym-slider-content .lqd-asym-slider-description-element',
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Title Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .lqd-asym-slider-content .lqd-asym-slider-title-element' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => __( 'Subtitle Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-asym-slider-content .lqd-asym-slider-subtitle-element' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-asym-slider-content .lqd-asym-slider-description-element' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'stroke_color',
			[
				'label' => __( 'Stroke Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-asym-slider-content hr' => 'color: {{VALUE}}',
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
		$wrapper_attrs = [
			'id' => 'lqd-asym-slider-' . $this->get_id(),
			'class' => "lqd-asym-slider",
			'data-asym-slider' => true,
		];
		$autoplay = $settings['autoplay'];

		if ( !empty( $autoplay ) ) {
			$wrapper_attrs['data-asym-options'] = wp_json_encode([
				'autoplay' => $autoplay
			]);
		}

		$this->add_render_attribute('wrapper', $wrapper_attrs);

		?>

		<div <?php $this->print_render_attribute_string('wrapper') ?>>
			<div class="lqd-asym-slider-inner">

				<div class="lqd-asym-slider-t pos-rel z-index-3">
					<div class="lqd-asym-slider-content d-flex flex-column align-items-center">
						<div class="lqd-asym-slider-title-wrap d-flex w-100 pos-rel">

							<?php $i = 0; foreach ( $settings['identities'] as $item ) {   
								if( !empty( $item['title'] ) ) { 
							?>
								<div class="lqd-asym-slider-title w-100 <?php echo $i; echo $i === 0 ? ' active' : ''; ?>">
									<<?php echo $settings['title_tag']; ?> class="lqd-asym-slider-title-element mt-0 mb-0 h1" data-fittext="true" data-fittext-options='{"compressor": 0.4, "maxFontSize": "currentFontSize"}'>
										<span class="d-block" data-split-text="true" data-split-options='{ "type": "chars, words" }'><?php echo $item['title'] ?></span>
									</<?php echo $settings['title_tag']; ?>>
								</div>
							<?php } $i++; } ?>

						</div>
						<div class="lqd-asym-slider-info-wrap d-flex w-100 pos-rel">

							<?php $i = 0; foreach ( $settings['identities'] as $item ) { ?>
								<div class="lqd-asym-slider-info w-100 <?php echo $i === 0 ? 'active' : ''; ?>">
									<?php if( isset( $item['subtitle'] ) ) { ?>
									<<?php echo $settings['subtitle_tag']; ?> class="lqd-asym-slider-subtitle-element mt-0 mb-0"><?php echo $item['subtitle'] ?></<?php echo $settings['subtitle_tag']; ?>>
									<hr class="mt-3 mb-3">
									<?php } ?>
									<?php if( isset( $item['description'] ) ) { ?>
									<<?php echo $settings['description_tag']; ?> class="lqd-asym-slider-description-element h4 mt-0 mb-0"><?php echo $item['description'] ?></<?php echo $settings['description_tag']; ?>>
									<?php } ?>
								</div>
							<?php $i++; 
								} ?>

						</div>
					</div>
				</div>

				<div class="lqd-asym-slider-b pos-rel">
					<div class="lqd-asym-slider-img-wrap d-flex pos-rel overflow-hidden">

						<?php $i = 0; foreach ( $settings['identities'] as $item ) { ?>
							<div class="lqd-asym-slider-img d-flex w-100 h-100 pos-rel overflow-hidden <?php echo $i === 0 ? 'active' : ''; ?>">
								<div class="lqd-asym-slider-img-inner w-100 overflow-hidden">
									<?php if( !empty( $item['image']['id'] ) ) { ?>
									<figure class="mt-0 mb-0 w-100 h-100">
										<?php echo wp_get_attachment_image( $item['image']['id'], 'full', false, array( 'class' => 'w-100 h-100 objfit-cover objpos-center', 'alt' => esc_attr( $alt = !empty( $item['title'] ) ? $item['title'] : '' ) ) ); ?>
									</figure>
									<?php } ?>
								</div>
								<div class="lqd-asym-slider-btn-wrap d-inline-flex pos-abs pos-bl z-index-2 overflow-hidden">
									<div class="lqd-asym-slider-btn">
										<?php
											$button = new \LQD_Elementor_Render_Button;
											$button->get_button( $this, 'ib_' ); 
										?>
									</div>
								</div>
							</div>
						<?php $i++; } ?>

					</div>

					<div class="lqd-asym-slider-arrows d-flex pos-abs z-index-3">
						<button class="lqd-asym-slider-arrow lqd-asym-slider-prev pos-rel">
							<svg class="pos-rel" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path d="M26.688 14.664H10.456l7.481-7.481L16 5.313 5.312 16 16 26.688l1.87-1.87-7.414-7.482h16.232v-2.672z" fill="currentColor"></path></svg>
						</button>
						<button class="lqd-asym-slider-arrow lqd-asym-slider-next pos-rel">
							<svg class="pos-rel" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path d="M5.313 17.336h16.231l-7.481 7.481L16 26.687 26.688 16 16 5.312l-1.87 1.87 7.414 7.482H5.312v2.672z" fill="currentColor"></path></svg>
						</button>
					</div>

				</div>

			</div>
		</div>

		<?php
		
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Asymmetric_Slider() );