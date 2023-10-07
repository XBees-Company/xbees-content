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
class LD_Carousel_Stack extends Widget_Base {

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
		return 'ld_carousel_stack';
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
		return __( 'Liquid Carousel Stack', 'hub-elementor-addons' );
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
		return 'eicon-slider-album lqd-element';
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
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'stack', 'slider', 'carousel' ];
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
			return [ 'flickity', 'draggabilly' ];
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
				'default' => __( 'Tab', 'hub-elementor-addons' ),
				'label_block' => true,
			]
		);
		/*
		$repeater->add_control(
			'tab_ids', [
				'label' => __( 'Section ID', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => uniqid('lqd-'),
				'label_block' => true,
			]
		);
		*/

		$repeater->add_control(
			'content_type',
			[
				'label' => __( 'Content Type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tinymce',
				'label_block' => true,
				'options' => [
					'tinymce' => __( 'TinyMCE', 'hub-elementor-addons' ),
					'el_template' => __( 'Elementor Template', 'hub-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'list_content', [
				'label' => __( 'Content', 'hub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.' , 'hub-elementor-addons' ),
				'show_label' => false,
				'condition'=> [
					'content_type' => 'tinymce'
				],
			]
		);

		$repeater->add_control(
			'templates',
			[
				'label' => __( 'Templates', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => $this->get_block_posts(),
				'default' => '0',
				'condition' => [
					'content_type' => 'el_template',
				]
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Items', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[],[]
				],
				'title_field' => '{{{ title }}}',
			]
		);

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__( 'Autoplay delay', 'hub-elementor-addons' ),
                'description' => esc_html__( 'Autoplay time in milliseconds', 'hub-elementor-addons' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 700,
                'step' => 500,
            ]
        );

		$this->end_controls_section();

		// Start style tab
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'button_style_tabs'
		);

		// Normal state
		$this->start_controls_tab(
			'button_style_normal_tab',
			[
				'label' => __( 'Normal', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => __( 'Button Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} button.lqd-carousel-stack-btn' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hover state
		$this->start_controls_tab(
			'button_style_hover_tab',
			[
				'label' => __( 'Hover', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'hover_button_color',
			[
				'label' => __( 'Button Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} button.lqd-carousel-stack-btn' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// End style tab
		$this->end_controls_section();

	}

	protected function get_block_posts() {
		$posts = get_posts( array(
			'post_type' => 'elementor_library',
			'posts_per_page' => -1,
			'meta_query'  => array(
                array(
                    'key' => '_elementor_template_type',
                    'value' => 'kit',
                    'compare' => '!=',
                ),
            ),
		) );

		$options = [ '0' => 'Select Template' ];

		foreach ( $posts as $post ) {
		  $options[ $post->ID ] = $post->post_title;
		}

		return $options;
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
            'id' => esc_attr( 'lqd-carousel-stack-' . $this->get_id() ),
            'class' => ['carousel-container', 'lqd-carousel-stack', 'pos-rel'],
        ];
        $autoplay = $settings['autoplay'];

        $opts = '';

        if ( !empty( $autoplay ) && $autoplay > 0 ) {
            $opts = 'data-carousel-options=\'' . wp_json_encode([
                'autoplay' => $autoplay
            ]) . '\'';
        }

        $this->add_render_attribute('wrapper', $wrapper_attrs);

		?>
		<div <?php $this->print_render_attribute_string('wrapper'); echo $opts ?>>

			<div class="carousel-items" data-lqd-flickity='{ "watchCSS": true }'>
				<?php
					//$this->get_content();

					if ( $settings['list'] ) {
						foreach (  $settings['list'] as $item ) {
							printf( '<div class="carousel-item w-100 elementor-repeater-item-%1$s"><span class="lqd-carousel-handle"></span>%2$s</div>', $item['_id'],
							$item['content_type'] === 'tinymce' ? $item['list_content'] : \Elementor\Plugin::instance()->frontend->get_builder_content( $item['templates'], true ) );

						}
					}
				?>
			</div>

			<div class="lqd-carousel-stack-nav">
				<button class="lqd-carousel-stack-btn lqd-carousel-stack-prev">
					<svg width="6" height="10" viewBox="0 0 6 10" xmlns="http://www.w3.org/2000/svg">
						<path d="M5.863 8.387L4.75 9.5L0 4.75L4.75 0L5.863 1.113L2.229 4.75L5.863 8.387Z"/>
					</svg>
				</button>
				<button class="lqd-carousel-stack-btn lqd-carousel-stack-next">
					<svg width="6" height="10" viewBox="0 0 6 10" xmlns="http://www.w3.org/2000/svg">
						<path d="M-2.43187e-05 8.387L1.11298 9.5L5.86298 4.75L1.11298 0L-2.43187e-05 1.113L3.63398 4.75L-2.43187e-05 8.387Z" />
					</svg>
				</button>
			</div>

		</div>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Carousel_Stack() );