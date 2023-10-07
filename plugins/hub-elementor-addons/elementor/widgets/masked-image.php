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
class LD_Masked_Image extends Widget_Base {

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
		return 'ld_masked_image';
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
		return __( 'Liquid Masked Image', 'hub-elementor-addons' );
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
		return 'eicon-image lqd-element';
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
		return [ 'image', 'animation', 'mask' ];
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
		$this->start_controls_section(
			'general_section',
			array(
				'label' => __( 'Masked Image', 'hub-elementor-addons' ),
			)
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'bg_pos_x',
			[
				'label' => __( 'Background Position X', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '50%',
				'description' => __( 'Add Background position on axe X with px, for ex. 24px', 'hub-elementor-addons' ),
			]
		);
		
		$this->add_control(
			'bg_pos_y',
			[
				'label' => __( 'Background Position Y', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '50%',
				'description' => __( 'Add Background position on axe Y with px, for ex. 24px', 'hub-elementor-addons' ),
			]
		);
		$this->end_controls_section();
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

		$svg_id = uniqid('svg-');
		$wrapper_id = uniqid('ld_masked_image-');
		?>

		<style>
			<?php echo '#'.$wrapper_id ?> .clip-svg {
				clip-path: url(<?php echo '#' . $svg_id ?>);
				-webkit-clip-path: url(<?php echo '#' . $svg_id ?>);
				background-size: cover;
				background-position-x: <?php echo $settings['bg_pos_x'] ?>;
				background-position-y: <?php echo $settings['bg_pos_y'] ?>;
			}
		</style>

		<div class="ld-masked-image" id="<?php echo esc_attr( $wrapper_id ); ?>" data-dynamic-shape="true">
			<svg class="scene lqd-overlay" viewBox="140 140 140 140">
				<defs>
					<clipPath id="<?php echo $svg_id ?>" clipPathUnits="objectBoundingBox" transform="scale(0.00158)">
						<path
							vector-effect="non-scaling-stroke"
							fill="black"
							d="M212.625,0.091 C319.112,-2.992 719.225,71.583 615.507,328.179 C511.789,584.775 250.263,624.292 112.94,568.057 C-24.383,511.822 -12.023,229.89 23.583,138.127 C59.189,46.364 106.138,3.174 212.625,0.091 Z"
							pathdata:id="M362.5,4 C487,4 631,-44 631,201.5 C631,447 538,623.5 310.5,581.5 C83,539.5 -29.917,266.627 7,156.5 C43.917,46.373 238,4 362.5,4 Z;M370,18 C494.5,18 627,-56.5 627,189 C627,434.5 405.5,573.5 155.5,581 C-94.5,588.5 23.083,175.127 60,65 C96.917,-45.127 245.5,18 370,18 Z"
						/>
					</clipPath>
				</defs>
			</svg>

			<figure class="clip-svg" data-responsive-bg="true" style='background-image: url("<?php echo esc_url($settings['image']['url']) ?>");' >
				<?php echo wp_get_attachment_image( $settings['image']['id'], 'full', false, array('class' => 'w-100 invisible') ); ?>
			</figure>
		</div>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Masked_Image() );