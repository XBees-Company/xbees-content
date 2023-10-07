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
class LD_Testimonial_Carousel_Stack extends Widget_Base {

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
		return 'ld_testimonial_carousel_stack';
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
		return __( 'Liquid Testimonial Carousel Stack', 'hub-elementor-addons' );
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
		return 'eicon-testimonial-carousel lqd-element';
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
		return [ 'stack', 'slider', 'carousel', 'testimonial' ];
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
			'template',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style01',
				'options' => [
					'style01' => __( 'Style 1', 'hub-elementor-addons' ),
					'style02' => __( 'Style 2', 'hub-elementor-addons' ),
					'style03' => __( 'Style 3', 'hub-elementor-addons' ),
					'style04' => __( 'Style 4', 'hub-elementor-addons' ),
					'style05' => __( 'Style 5', 'hub-elementor-addons' ),
					'style06' => __( 'Style 6', 'hub-elementor-addons' ),
					'style07' => __( 'Style 7', 'hub-elementor-addons' ),
					'style08' => __( 'Style 8', 'hub-elementor-addons' ),
					'style09' => __( 'Style 9', 'hub-elementor-addons' ),
					'style10' => __( 'Style 10', 'hub-elementor-addons' ),
					'style11' => __( 'Style 11', 'hub-elementor-addons' ),
					'style12' => __( 'Style 12', 'hub-elementor-addons' ),
					'style13' => __( 'Style 13', 'hub-elementor-addons' ),
					'style14' => __( 'Style 14', 'hub-elementor-addons' ),
					'style15' => __( 'Style 15', 'hub-elementor-addons' ),
					'style16' => __( 'Style 16', 'hub-elementor-addons' ),
					'style17' => __( 'Style 17', 'hub-elementor-addons' ),
					'style18' => __( 'Style 18', 'hub-elementor-addons' ),
					'style19' => __( 'Style 19', 'hub-elementor-addons' ),
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Name', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'John Doe', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your name here', 'hub-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'position',
			[
				'label' => __( 'Position', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Developer', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your position here', 'hub-elementor-addons' ),
				'condition' => [
					'template!' => [ 'style04' ],
				],
			]
		);

		$repeater->add_control(
			'avatar',
			[
				'label' => __( 'Avatar', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'template!' => [ 'style19' ],
				],
			]
		);

	
		$repeater->add_control(
			'content',
			[
				'label' => __( 'Text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'placeholder' => __( 'Type your text here', 'hub-elementor-addons' ),
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'hub-elementor-addons' ),
			]
		);

		// Addional Section
		$repeater->add_control(
			'more_options',
			[
				'label' => __( 'Additional Options', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'template' => [ 'style02', 'style03', 'style04', 'style05', 'style07', 'style08', 'style09', 'style11', 'style16', 'style18', 'style19' ],
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Client Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'template' => [ 'style05', 'style16', 'style18', 'style19' ],
				],
			]
		);

		$repeater->add_control(
			'rating',
			[
				'label' => __( 'Rating/Stars', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition' => [
					'template' => [ 'style02', 'style04', 'style05', 'style09', 'style11', 'style18', 'style19' ],
				],
			]
		);

		$repeater->add_control(
			'date_time',
			[
				'label' => __( 'Data/Time', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Type your Data/Time here', 'hub-elementor-addons' ),
				'condition' => [
					'template' => 'style04',
				],
			]
		);

		$repeater->add_control(
			'network',
			[
				'label' => __( 'Network', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fa-amazon',
				'options' => [
					'fa-facebook' => __('Facebook', 'hub-elementor-addons'),
					'fa-twitter' => __('Twitter', 'hub-elementor-addons'),
					'fa-youtube' => __('Youtube', 'hub-elementor-addons'),
					'fa-instagram' => __('Instagram', 'hub-elementor-addons'),
					'fa-vimeo' => __('Vimeo', 'hub-elementor-addons'),
					'fa-linkedin' => __('Linkedin', 'hub-elementor-addons'),
					'fa-github' => __('Github', 'hub-elementor-addons'),
					'fa-dribbble' => __('Dribbble', 'hub-elementor-addons'),
					'fa-skype' => __('Skype', 'hub-elementor-addons'),
					'fa-medium' => __('Medium', 'hub-elementor-addons'),
					'fa-reddit' => __('Reddit', 'hub-elementor-addons'),
					'fa-slack' => __('Slack', 'hub-elementor-addons'),
					'fa-stack-overflow' => __('Stack Overflow', 'hub-elementor-addons'),
					'fa-telegram' => __('Telegram', 'hub-elementor-addons'),
					'fa-tiktok' => __('TikTok', 'hub-elementor-addons'),
					'fa-whatsapp' => __('Whatsapp', 'hub-elementor-addons'),
				],
				'condition' => [
					'template' => [ 'style03', 'style04', 'style08', 'style07' ],
				],
			]
		);

		$repeater->add_control(
			'item_bg_color',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi' => 'background: {{VALUE}} !important',
				],
				'condition' => [
					'template!' => [ 'style2', 'style15', 'style17' ],
				],
				'separator' => 'before'
			]
		);

		$repeater->add_control(
			'item_bg_color_style2',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi' => 'background: {{VALUE}} !important',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi:after' => 'border-top-color: {{VALUE}} !important',
				],
				'condition' => [
					'template' => [ 'style2' ],
				],
			]
		);

		$repeater->add_control(
			'item_bg_color_style15',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi .lqd-testi-inner' => 'background: {{VALUE}} !important',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi:after' => 'border-left-color: {{VALUE}} !important',
				],
				'condition' => [
					'template' => [ 'style15' ],
				],
			]
		);

		$repeater->add_control(
			'item_bg_color_style17',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi .lqd-testi-quote' => 'background: {{VALUE}} !important',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi .lqd-testi-quote:after' => 'border-top-color: {{VALUE}} !important',
				],
				'condition' => [
					'template' => [ 'style17' ],
				],
			]
		);

		$repeater->add_control(
			'item_border_color_',
			[
				'label' => __( 'Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi.lqd-testi-style-2:after' => 'border-top-color: {{VALUE}}',
				],
				'condition' => [
					'template' => [ 'style02', 'style09', 'style15' ],
				],
			]
		);

		$repeater->add_control(
			'item_border_color_style18',
			[
				'label' => __( 'Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi:before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'template' => [ 'style18' ],
				],
			]
		);

		$repeater->add_control(
			'item_secondary_color',
			[
				'label' => __( 'Secondary Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi-quote-icon path,{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi-quote-icon circle' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'template' => [ 'style10', 'style12', 'style16' ],
				],
			]
		);

		$repeater->add_control(
			'item_title_color',
			[
				'label' => __( 'Title Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi h3' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'item_pos_color',
			[
				'label' => __( 'Position Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi h4' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'item_text_color',
			[
				'label' => __( 'Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi-quote' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'item_star_color',
			[
				'label' => __( 'Star/Rating Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi .lqd-star-rating .active' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-testi .lqd-star-rating-fill:before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'template' => [ 'style02', 'style04', 'style05', 'style09', 'style11', 'style18', 'style19' ],
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'selector' => '{{WRAPPER}} .lqd-testi',
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'item_border_radius',
			[
				'label' => __( 'Border Radius', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-testi' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Testimonial Slides', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[],[],[]
				],
				'title_field' => '{{{ title }}}',
				'separator' => 'before'
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

		$template = new \LD_Testimonial_Template_Handler();
		?>
		<div id="<?php echo esc_attr( 'lqd-carousel-stack-' . $this->get_id() ); ?>" class="carousel-container lqd-carousel-stack">
			
			<div class="carousel-items" data-lqd-flickity='{ "watchCSS": true }'>
				<?php
					//$this->get_content();
					
					if ( $settings['list'] ) {
						foreach (  $settings['list'] as $item ) {
							echo '<div class="carousel-item w-100 elementor-repeater-item-'. $item['_id'] .'"><span class="lqd-carousel-handle"></span>'; 
							$template->testimonials_template(
								$item['template'],
								$item['content'],
								$item['avatar'],
								$item['title'],
								$item['position'],
								$item['rating'],
								$item['network'],
								$item['date_time'],
								$item['image']
							);
							echo '</div>';
								
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
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Testimonial_Carousel_Stack() );