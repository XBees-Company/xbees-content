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
class LD_Device_Gallery_Mobile extends Widget_Base {

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
		return 'ld_device_gallery_mobile';
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
		return __( 'Liquid Gallery Mobile', 'hub-elementor-addons' );
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
		return 'eicon-device-mobile lqd-element';
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
		return [ 'gallery', 'mobile', 'phone', 'device' ];
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
			return [ 'flickity' ];
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

		$this->add_control(
			'gallery_images',
			[
				'label' => __( 'Add Images', 'hub-elementor-addons' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->add_control(
			'shadow_type',
			[
				'label' => __( 'Shadow Type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'hub-elementor-addons' ),
					'float' => __( 'Float', 'hub-elementor-addons' ),
					'long' => __( 'Long', 'hub-elementor-addons' ),
					'medium' => __( 'Medium', 'hub-elementor-addons' ),
					'stand' => __( 'Stand', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_responsive_control(
			'autoplaytime',
			[
				'label' => __( 'Autoplay delay', 'hub-elementor-addons' ),
				'description' => __( 'Autoplay delay in miliseconds', 'hub-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

	}

	protected function get_shadow() {

		$settings = $this->get_settings_for_display();
		$shadow_type = $settings['shadow_type'];

		if ( '' === $shadow_type ) return;

		$out = '';

		$out .= '<div class="lqd-device-gallery-shadow lqd-device-gallery-shadow-' . $shadow_type . ' pos-abs z-index--1"></div>';

		return $out;

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

		$lazyload_enabled = 'on' === liquid_helper()->get_option( 'enable-lazy-load' );
		$is_elementor_edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();

		$img_attrs = [
			'class' => [
				'w-100'
			],
			'alt' => 'Phone base image'
		];

		$base_img_width = 900;
		$base_img_height = 1820;

		if ( $lazyload_enabled && ! $is_elementor_edit_mode ) {
			$img_attrs['class'][] = 'ld-lazyload';
			$img_attrs['src'] = 'data:image/svg+xml,%3Csvg%20xmlns=&#039;http://www.w3.org/2000/svg&#039;%20viewBox=&#039;0%200%20' . $base_img_width . '%20' . $base_img_height . '&#039;%3E%3C/svg%3E';
			$img_attrs['data-src'] = get_template_directory_uri() . '/assets/img/mockups/phone/mobile-mockup-1.png';
		} else {
			$img_attrs['src'] = get_template_directory_uri() . '/assets/img/mockups/phone/mobile-mockup-1.png';
		}

		$this->add_render_attribute( 'img_attrs', $img_attrs );

		?>

		<div class="lqd-gallery-device lqd-gallery-mobile lqd-gallery-mobile-1 pos-rel">

			<div class="lqd-gallery-mobile-base-img-wrap pos-rel z-index-3 pointer-events-none">
				<figure class="lqd-gallery-mobile-base-fig">
					<img <?php echo $this->get_render_attribute_string('img_attrs') ?> width="<?php echo esc_attr($base_img_width); ?>" height="<?php echo esc_attr($base_img_height); ?>" />
				</figure>
				<?php echo $this->get_shadow(); ?>
			</div>

			<div class="lqd-gallery-mobile-gallery-images w-100 pos-abs z-index-2">
				<div class="carousel-container w-100 h-100">
					<div
					class="carousel-items w-100 h-100"
					data-lqd-flickity='{ "groupCells": false, "cellAlign": "center", "wrapAround": true, "skipWrapItems": true, "pageDots": false, "autoPlay": <?php echo !empty($settings['autoplaytime']) ? $settings['autoplaytime'] : 'false'  ?> }'>

						<div class="flickity-viewport w-100 h-100 overflow-hidden">
							<div class="flickity-slider w-100 h-100">

								<?php foreach ( $settings['gallery_images'] as $image ) { ?>
								<div class="carousel-item w-100 h-100 overflow-hidden">
									<figure class="h-100">
										<?php echo wp_get_attachment_image( $image['id'], 'full', false, [ 'class' => 'w-100 h-100 objfit-cover objfit-center' ] ); ?>
									</figure>
								</div>
								<?php } ?>

							</div>
						</div>
					
					</div>
				</div>
			</div>

		</div>
		
		<?php
   
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Device_Gallery_Mobile() );