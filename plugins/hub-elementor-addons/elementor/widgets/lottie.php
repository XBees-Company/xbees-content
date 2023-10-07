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
class LD_Lottie extends Widget_Base {


    public function __construct($data = [], $args = null) {


		parent::__construct($data, $args);

		wp_enqueue_script( 'lottie',
			get_template_directory_uri() . '/assets/vendors/lottie/lottie.min.js',
			[ 'jquery' ],
			'5.9.6',
			false
		);

	 }

    /**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */

	 public function get_script_depends() {
		 return [ 'lottie' ];
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
		return 'ld_lottie';
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
		return __( 'Liquid Lottie', 'hub-elementor-addons' );
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
		return 'eicon-lottie lqd-element';
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
		return [ 'lottie', 'animation' ];
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
			[
				'label' => __( 'General', 'hub-elementor-addons' ),
			]
		);

        $this->add_control(
			'json_source',
			[
				'label' => esc_html__( 'Source', 'plugin-name' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'internal',
				'options' => [
					'internal'  => esc_html__( 'Media Library', 'plugin-name' ),
					'external' => esc_html__( 'External URL', 'plugin-name' ),
				],
			]
		);

        $this->add_control(
			'json_url',
			[
				'label' => esc_html__( 'External JSON URL', 'hub-elementor-addons' ),
                'placeholder' => esc_html__( 'Enter the JSON URL', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
                'condition' => [
					'json_source' => 'external',
				],
			]
		);

		$this->add_control(
			'json_file',
			[
				'label' => esc_html__( 'Upload JSON File', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'media_type' => 'application/json',
				'condition' => [
					'json_source' => 'internal',
				],
			]
		);

        $this->add_control( 'hr2', [
            'type' => Controls_Manager::DIVIDER,
        ] );

        $this->add_control(
			'render_type',
			[
				'label' => esc_html__( 'Render Type', 'plugin-name' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'svg',
				'options' => [
					'svg'  => esc_html__( 'SVG', 'plugin-name' ),
					'canvas' => esc_html__( 'Canvas', 'plugin-name' ),
				],
			]
		);

        $this->add_control(
			'direction',
			[
				'label' => esc_html__( 'Direction', 'plugin-name' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1'  => esc_html__( 'Forward', 'plugin-name' ),
					'-1' => esc_html__( 'Backward', 'plugin-name' ),
				],
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'player_bg',
				'label' => esc_html__( 'Background', 'plugin-name' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-lottie',
			]
		);

        $this->add_control( 'hr', [
            'type' => Controls_Manager::DIVIDER,
        ] );

        $this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'plugin-name' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                    'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-lottie' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'plugin-name' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                    'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-lottie' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'animation_speed',
			[
				'label' => esc_html__( 'Animation Speed (1x)', 'plugin-name' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 5,
						'step' => 0.1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
                'render_type' => 'template',
			]
		);

        $this->add_control( 'hr3', [
            'type' => Controls_Manager::DIVIDER,
        ] );

        $this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'plugin-name' ),
				'description' => esc_html__( 'Play animation on load.', 'plugin-name' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'your-plugin' ),
				'label_off' => esc_html__( 'Off', 'your-plugin' ),
				'return_value' => 'autoplay',
                'default' => 'autoplay',
			]
		);

        $this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Loop', 'plugin-name' ),
				'description' => esc_html__( 'Set to repeat animation.', 'plugin-name' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'your-plugin' ),
				'label_off' => esc_html__( 'Off', 'your-plugin' ),
				'return_value' => 'loop',
                'default' => 'loop',
			]
		);

		$this->add_control( 'hr4', [
            'type' => Controls_Manager::DIVIDER,
        ] );

		$this->add_control(
			'blend_mode',
			[
				'label' => esc_html__( 'Blend mode', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Normal', 'hub-elementor-addons' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'difference' => 'Difference',
					'exclusion' => 'Exclusion',
					'hue' => 'Hue',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-lottie, {{WRAPPER}}' => 'mix-blend-mode: {{VALUE}}',
				],
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
        extract( $settings );

        if ( $json_source === 'internal' ){
            $animation_src = isset( $settings['json_file']['url'] ) ? esc_url( $settings['json_file']['url'] ) : '';
        } else {
            $animation_src = isset( $settings['json_url']['url'] ) ? esc_url( $settings['json_url']['url'] ) : '';
        }

        if ( empty( $animation_src ) ){
            return;
        }

				$element_id = $this->get_id();

        $animation_id = esc_attr( 'lqd-lottie-' . $element_id );

        $animation_speed = $animation_speed['size'];
        $autoplay = $autoplay ? 'true' : 'false';
        $loop = $loop ? 'true' : 'false';

        ?>

        <div id="<?php echo esc_attr( $animation_id ); ?>" class="lqd-lottie"></div>

        <?php
        echo "
        <script>
            (() => {
                window.addEventListener('DOMContentLoaded', () => {
                    const wrapper_$element_id = document.getElementById( '$animation_id' );
                    const animItem_$element_id = bodymovin.loadAnimation({
                        wrapper: wrapper_$element_id,
                        animType: '$render_type',
                        name: '$animation_id',
                        autoplay: $autoplay,
                        loop: $loop,
                        path: '$animation_src',
                        rendererSettings: {
                            className: 'lqd-lottie',
                        }
                    });

                    lottie.setDirection($direction, '$animation_id');
                    lottie.setSpeed($animation_speed, '$animation_id');

                    lottie.pause('$animation_id');

                    new IntersectionObserver(([entry]) => {
                        if ( entry.isIntersecting ) {
                            lottie.play('$animation_id');
                        } else {
                            lottie.pause('$animation_id')
                        }
                    }).observe(wrapper_$element_id)
                })
            })();
        </script>
        ";

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Lottie() );