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
class LD_Promo extends Widget_Base {

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
		return 'ld_promo';
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
		return __( 'Liquid Promo', 'hub-elementor-addons' );
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
		return 'eicon-single-page lqd-element';
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
		return [ 'fancy', 'promo', 'banner' ];
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
			'title',
			[
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Heading', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title Element Tag', 'hub-elementor-addons' ),
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
			]
		);

		$this->add_control(
			'use_inheritance',
			[
				'label' => __( 'Inherit font styles?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'tag_to_inherite',
			[
				'label' => esc_html__( 'Element Tag', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p' => 'p',
				],
				'default' => 'h1',
				'condition' => [
					'use_inheritance' => 'true',
				],
			]
		);

		$this->add_control(
			'label',
			[
				'label' => __( 'Label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Type your label', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your label here', 'hub-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.​', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your text here', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'content_placement',
			[
				'label' => __( 'Content Placement', 'hub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'lqd-promo-reverse' => [
						'title' => __( 'Left', 'hub-elementor-addons' ),
						'icon' => 'eicon-arrow-left',
					],
					'lqd-promo-default' => [
						'title' => __( 'Right', 'hub-elementor-addons' ),
						'icon' => 'eicon-arrow-right',
					],
				],
				'default' => 'lqd-promo-default',
				'toggle' => false,
			]
		);

		$this->add_control(
			'show_dynamic_shape',
			[
				'label' => __( 'Show Dynamic Shape', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'URL (Link)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'hub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
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
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-promo-title',
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Title Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-promo-title' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __( 'Text Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} p',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} p' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label' => __( 'Overlay Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					//'{{WRAPPER}} .title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dynamic_shape_bg',
			[
				'label' => __( 'Dynamic Shape Background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0, 0, 0, 0.05)',
				'selectors' => [
					'{{WRAPPER}} .lqd-promo-dynamic-shape svg' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'show_dynamic_shape' => 'yes',
				],
			]
		);
		$this->end_controls_section();

		ld_el_btn($this, 'ib_'); // load button
	}

	protected function ld_get_dynamic_shape() {

		if( !$this->get_settings_for_display('show_dynamic_shape') ) {
			return;
		}
		
		echo '<div class="lqd-promo-dynamic-shape d-block pos-abs z-index-0" data-dynamic-shape="true">
				<svg class="scene" width="100%" height="100%" viewbox="0 0 650 650">
				<path
					d="M717.349,515.468 C693.326,625.562 595.298,708.000 478.000,708.000 C351.735,708.000 247.793,612.479 234.460,489.760 C104.042,484.237 -0.000,376.777 -0.000,245.000 C-0.000,109.690 109.690,-0.000 245.000,-0.000 C330.697,-0.000 406.103,44.009 449.889,110.648 C481.742,95.493 517.376,87.000 555.000,87.000 C690.310,87.000 800.000,196.690 800.000,332.000 C800.000,405.029 768.036,470.582 717.349,515.468 Z"
					pathdata:id="
					M565.540,489.760 C552.207,612.479 448.265,708.000 322.000,708.000 C204.702,708.000 106.675,625.562 82.651,515.468 C31.964,470.582 -0.000,405.029 -0.000,332.000 C-0.000,196.690 109.690,87.000 245.000,87.000 C282.624,87.000 318.258,95.493 350.111,110.649 C393.897,44.009 469.303,0.000 555.000,0.000 C690.310,0.000 800.000,109.690 800.000,245.000 C800.000,376.777 695.958,484.238 565.540,489.760 Z"
				/>
				</svg>
			</div>';

	}

	protected function ld_get_label() {

		if ( empty( $this->get_settings_for_display('label') ) ) {
			return;
		}
		
		printf( '<div class="lqd-promo-cat d-flex flex-wrap justify-content-center text-uppercase ltrsp-2"><ul class="reset-ul"><li>%s</li></ul></div>', esc_html( $this->get_settings_for_display('label') ) );
		
	}

	protected function ld_get_image() {

		// check value
		if( empty( $this->get_settings_for_display('image') ) ) {
			return;
		}

		$img_src = $image = '';
		$alt  = $this->get_settings_for_display('title');
		
		if( preg_match( '/^\d+$/', $this->get_settings_for_display('image')['id'] ) ) {
			$html = wp_get_attachment_image( $this->get_settings_for_display('image')['id'], 'full', false, array( 'class' => 'w-100', 'alt' => esc_html( $alt ) ) );
		} 
		else {
			$img_src  = $this->get_settings_for_display('image')['url'];
				$html = '<img src="' . esc_url( $img_src ) . '" alt="' . esc_html( $alt ) . '" />';
		}
		
		printf( '<figure>%s</figure>', $html );

	}

	protected function ld_get_link() {
		
		$link = isset($this->get_settings_for_display('link')['url']) ? esc_url($this->get_settings_for_display('link')['url']) : '';
		if( empty( $link ) ) {
			return;
		}
		$target = $this->get_settings_for_display('link')['is_external'] ? esc_html( "target=_blank" ) : '';
		
		printf( '<a href="%s" %s class="liquid-overlay-link"></a>', $link, $target );

	}

	protected function ld_get_title() {

		// check
		if( empty( $this->get_settings_for_display('title') ) ) {
			return '';
		}
		
		if( 'lqd-promo-reverse' === $this->get_settings_for_display('content_placement') ) {
			printf( '<%1$s
				class="lqd-promo-title %2$s"
				data-split-text="true"
				data-split-options=\'{ "type": "chars, words" }\'
				data-custom-animations="true"
				data-ca-options=\'{ "triggerHandler": "inview", "animationTarget": ".lqd-chars .split-inner", "direction": "backward", "duration": 800, "startDelay": 800, "delay": 70, "initValues": { "x": -70, "rotationY": -65, "opacity": 0 }, "animations": { "x": 0, "rotationY": 0, "opacity": 1 } }\'
			>%3$s</%1$s>',$this->get_settings_for_display('title_tag'), $this->get_settings_for_display('use_inheritance') === 'true' ? $this->get_settings_for_display('tag_to_inherite') : '', esc_html( $this->get_settings_for_display('title') ) );
		} else {
			printf( '<%1$s
				class="lqd-promo-title %2$s"
				data-split-text="true"
				data-split-options=\'{ "type": "chars, words" }\'
				data-custom-animations="true"
				data-ca-options=\'{ "triggerHandler": "inview", "animationTarget": ".lqd-chars .split-inner", "duration": 800, "startDelay": 800, "delay": 70, "initValues": { "x": 70, "rotationY": 65, "opacity": 0 }, "animations": { "x": 0, "rotationY": 0, "opacity": 1 } }\'
			>%3$s</%1$s>',$this->get_settings_for_display('title_tag'), $this->get_settings_for_display('use_inheritance') === 'true' ? $this->get_settings_for_display('tag_to_inherite') : '', esc_html( $this->get_settings_for_display('title') ) );
		}

	}

	protected function ld_get_content() {
		
		// check
		if( empty( $this->get_settings_for_display('content') ) ) {
			return '';
		}

		$content = ld_helper()->do_the_content( $this->get_settings_for_display('content') );
		
		printf( '<p
				data-split-text="true"
				data-split-options=\'{ "type": "lines" }\'
				data-custom-animations="true"
				data-ca-options=\'{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 800, "startDelay": 1000, "delay": 120, "initValues": { "translateY": 50, "opacity": 0 }, "animations": { "translateY": 0, "opacity": 1 } }\'
			>%s</p>', $this->get_settings_for_display('content') );
		
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

		$this->add_render_attribute(
			'wrapper',
			[
				'id' => 'lqd-promo-' . $this->get_id(),
				'class' => [ 'lqd-promo-wrap', 'pos-rel', $settings['content_placement'] ],
			]
		);
		
		$bg_color = !empty( $settings['overlay_color'] ) ? $settings['overlay_color'] : '#FE055E';
		
		?>
		
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div class="lqd-promo-inner d-flex pos-rel">
		
				<?php $this->ld_get_dynamic_shape(); ?>			
				<?php $this->ld_get_label(); ?>
		
				<div class="lqd-promo-img d-flex flex-column justify-content-center">
					<div class="lqd-promo-img-inner overflow-hidden" data-reveal="true" data-reveal-options='{ "direction": "rl", "bgcolor": "<?php echo esc_attr( $bg_color ); ?>", "revealSettings": { "onCoverAnimations": [ {"scale": 2}, {"scale": 1} ] } }'>
						<?php $this->ld_get_image(); ?>
						<?php $this->ld_get_link() ?>
					</div>
				</div>
		
				<div class="lqd-promo-content d-flex flex-column align-items-start justify-content-center"
					data-custom-animations="true"
					data-ca-options='{ "triggerHandler": "inview", "animationTarget": ".btn", "duration": 800, "startDelay": 1300, "initValues": { "y": 70, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'
				>
					<?php $this->ld_get_title(); ?>
					<?php $this->ld_get_content(); ?>
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
		
				</div>
		
			</div>
		</div>
		<?php
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Promo() );