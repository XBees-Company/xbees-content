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
class LD_Team_Member extends Widget_Base {

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
		return 'ld_team_member';
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
		return __( 'Liquid Team Member', 'hub-elementor-addons' );
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
		return 'eicon-person lqd-element';
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
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'team', 'user', 'member'  ];
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
			return [ 'gsap' ];
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
			'template',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-tm-style-1',
				'options' => [
					'lqd-tm-style-1' => __( 'Style 1', 'hub-elementor-addons' ),
					'lqd-tm-style-2' => __( 'Style 2', 'hub-elementor-addons' ),
					'lqd-tm-style-3' => __( 'Style 3', 'hub-elementor-addons' ),
					'lqd-tm-style-4' => __( 'Style 4', 'hub-elementor-addons' ),
					'lqd-tm-style-5' => __( 'Style 5', 'hub-elementor-addons' ),
					'lqd-tm-style-6' => __( 'Style 6', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Team Member Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'name',
			[
				'label' => __( 'Name', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'John Doe', 'hub-elementor-addons' ),
				'placeholder' => __( 'Name', 'hub-elementor-addons' ),
			]
		);
		
		$this->add_control(
			'position',
			[
				'label' => __( 'Position', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Developer', 'hub-elementor-addons' ),
				'placeholder' => __( 'Position', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link (URL)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://twitter.com', 'hub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link (URL)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://twitter.com', 'hub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Social Profile', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'accent_color',
			[
				'label' => __( 'Accent Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tm-style-1 .block-revealer__element' => 'background: {{VALUE}}',
					'{{WRAPPER}} .lqd-tm-style-3 .lqd-tm-socials' => 'background: {{VALUE}}',
					'{{WRAPPER}} .lqd-tm-style-3 .block-revealer__element' => 'background: {{VALUE}}',
					'{{WRAPPER}} .lqd-tm-style-4 .lqd-tm-details, {{WRAPPER}} .lqd-tm-style-5 .lqd-tm-details, {{WRAPPER}} .lqd-tm-style-6 .lqd-tm-details' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pos_color',
			[
				'label' => __( 'Position Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tm-style-2 p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-tm-style-1 h6, {{WRAPPER}} .lqd-tm-style-3 h6, {{WRAPPER}} .lqd-tm-style-4 h6, {{WRAPPER}} .lqd-tm-style-5 h6, {{WRAPPER}} .lqd-tm-style-6 h6' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrow_color',
			[
				'label' => __( 'Arrow Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tm-details-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => ['lqd-tm-style-5', 'lqd-tm-style-6']
				]
			]
		);

		$this->add_control(
			'social_color',
			[
				'label' => __( 'Social Icon Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .social-icon a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'social_hcolor',
			[
				'label' => __( 'Social Icon Hover Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .social-icon a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'stop_color',
			[
				'label' => __( 'Stop Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tm-details svg stop:first-child' => 'stop-color: {{VALUE}}',
				],
				'condition' => [
					'template' => 'lqd-tm-style-2'
				]
			]
		);

		$this->add_control(
			'stop_color2',
			[
				'label' => __( 'Stop Color 2', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tm-details svg stop:last-child' => 'stop-color: {{VALUE}}',
				],
				'condition' => [
					'template' => 'lqd-tm-style-2'
				]
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
		$template = $settings['template'];
		$name = $settings['name'];
		$position = $settings['position']; 
		$image_url = esc_url($settings['image']['url']); 
		$image_id = $settings['image']['id']; 
		$gradient_id = 'grandient-' . $this->get_id();
		$member_link = esc_url($settings['link']['url']);

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'link', $settings['link'] );
			$this->add_render_attribute( 'link', 'class', 'lqd-overlay' );
		}

		$wrapper = [
			'class' => ['lqd-tm', 'pos-rel', $template ]
		];

		if ( $template === 'lqd-tm-style-1' ){
			$wrapper['data-inview'] = 'true';
		}
		if( $template === 'lqd-tm-style-3' || $template === 'lqd-tm-style-4' ){
			array_push( $wrapper['class'], 'border-radius-4', 'overflow-hidden', 'text-center' );
		}
		if ($template === 'lqd-tm-style-5'){
			array_push( $wrapper['class'], 'border-radius-4', 'overflow-hidden' );
		}
		if ($template === 'lqd-tm-style-6'){
			array_push( $wrapper['class'], 'overflow-hidden' );
		}

		$this->add_render_attribute( 'wrapper', $wrapper );

		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>

			<?php
			switch ($template){
				case 'lqd-tm-style-1':
				?>
					<div class="lqd-tm-img">
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $name ), 'class' => 'w-100' ] ); ?>
						</figure>
					</div>

					<div
						class="lqd-tm-details ps-6 pe-6 pt-4 pb-4"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "h3,h6", "duration": 1200, "delay": 120,  "startDelay": 350, "direction": "backward", "initValues": { "translateY": -30, "opacity": 0 }, "animations": { "translateY": 0, "opacity": 1 } }'
					>
						<div class="lqd-tm-bg lqd-overlay" data-reveal="true" data-reveal-options='{ "direction": "tb", "bgcolor": "#fff", "duration": 700, "coverArea": 100 }'></div>
						<h3 class="mt-0 mb-2"><?php echo $name; ?></h3>
						<h6 class="mt-0 mb-0 font-weight-normal"><?php echo $position; ?></h6>
						<?php if( !empty( $member_link ) ) : ?>
							<a <?php $this->print_render_attribute_string( 'link' ); ?>></a>
						<?php endif; ?>
					</div>
					<?php if( !empty( $member_link ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'link' ); ?>></a>
					<?php endif; ?>
				<?php
				break;
				case 'lqd-tm-style-2':
				?>
					<div class="lqd-tm-img">
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $name ), 'class' => 'w-100' ] ); ?>
						</figure>
					</div>

					<div
						class="lqd-tm-details pb-3 pos-rel"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "h3,p", "duration": 1200, "delay": 120,  "startDelay": 450, "initValues": { "translateY": 30, "opacity": 0 }, "animations": { "translateY": 0, "opacity": 1 } }'
					>

						<svg xmlns="http://www.w3.org/2000/svg" width="240.72" height="219.539" viewBox="0 0 240.72 219.539">
							<defs>
								<linearGradient id="<?php echo $gradient_id ?>" x1="0%" x2="100%" y1="6.867%" y2="100%">
									<stop offset="0%" />
									<stop offset="100%" />
								</linearGradient>
							</defs>
							<path fill="url(#<?php echo $gradient_id ?>)" d="M246.434,215.222c-34.945,52.734-119.407,86.81-177.044,55.4S1.026,143.131,42.221,94.4C117.052,5.887,306.8,124.134,246.434,215.222Z" transform="translate(-17.385 -63.129)"/>
						</svg>

						<h3 class="mt-0 mb-2"><?php echo $name; ?></h3>
						<p class="mt-0 mb-0"><?php echo $position; ?></p>

					</div>
					<?php if( !empty( $member_link ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'link' ); ?>></a>
					<?php endif; ?>
				<?php
				break;
				case 'lqd-tm-style-3':
				?>
					<div class="lqd-tm-img pos-rel">
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $name ), 'class' => 'w-100' ] ); ?>
						</figure>
						<div class="lqd-tm-socials lqd-overlay d-flex align-items-center justify-content-center">
							<?php if($settings['list']): ?> 
							<ul class="social-icon social-icon-vertical pos-rel z-index-3">
							<?php foreach (  $settings['list'] as $item ) : ?>
								<li <?php echo 'class="elementor-repeater-item-' . $item['_id'] . '"'; ?>>
									<a href="<?php echo esc_url($item['link']['url']);?>">
									<i class="<?php echo esc_attr( $item['icon']['value'] ); ?>"></i></a>
								</li>
							<?php endforeach; ?>
							</ul>
							<?php endif; ?>
						</div>
					</div>

					<div
						class="lqd-tm-details p-4 pos-rel"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "h3,h6", "duration": 1200, "delay": 120,  "startDelay": 500, "direction": "backward", "initValues": { "translateY": -30, "opacity": 0 }, "animations": { "translateY": 0, "opacity": 1 } }'
					>

						<div class="lqd-tm-bg lqd-overlay" data-reveal="true" data-reveal-options='{ "direction": "tb", "bgcolor": "rgba(0,0,0,0.1)", "duration": 400 }'></div>

						<h3 class="mt-0 mb-2"><?php echo $name; ?></h3>
						<h6 class="mt-0 mb-0"><?php echo $position; ?></h6>

					</div>
					<?php if( !empty( $member_link ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'link' ); ?>></a>
					<?php endif; ?>
				<?php
				break;
				case 'lqd-tm-style-4':
				?>
					<div class="lqd-tm-img pos-rel">
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $name ), 'class' => 'w-100' ] ); ?>
						</figure>
					</div>
						
					<div class="lqd-tm-details lqd-overlay d-flex flex-column align-items-center justify-content-end p-6">
						<?php if($settings['list']): ?> 
						<ul class="social-icon social-icon-vertical pos-rel z-index-3">
							<?php foreach (  $settings['list'] as $item ) : ?>
								<li <?php echo 'class="elementor-repeater-item-' . $item['_id'] . '"'; ?>>
									<a href="<?php echo esc_url($item['link']['url']);?>">
									<i class="<?php echo esc_attr( $item['icon']['value'] ); ?>"></i></a>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
						<div class="lqd-tm-details-inner">
							<h3 class="mt-0 mb-2"><?php echo $name; ?></h3>
							<h6 class="mt-0 mb-0"><?php echo $position; ?></h6>
						</div>
					</div>
					<?php if( !empty( $member_link ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'link' ); ?>></a>
					<?php endif; ?>
				<?php
				break;
				case 'lqd-tm-style-5':
				?>
					<div class="lqd-tm-img pos-rel">
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $name ), 'class' => 'w-100' ] ); ?>
						</figure>
					</div>
						
					<div class="lqd-tm-details lqd-overlay d-flex align-items-end">
						<div class="lqd-tm-details-inner d-flex align-items-center justify-content-between w-100 ps-6 pe-6 pt-5 pb-5">
							<div class="d-flex flex-column">
								<h3 class="mt-0 mb-2"><?php echo $name; ?></h3>
								<h6 class="mt-0 mb-0"><?php echo $position; ?></h6>
							</div>
							<div class="lqd-tm-details-icon ms-auto">
								<i class="lqd-icn-ess icon-md-arrow-forward"></i>
							</div>
						</div>
					</div>
					<?php if( !empty( $member_link ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'link' ); ?>></a>
					<?php endif; ?>
				<?php
				break;
				case 'lqd-tm-style-6':
				?>
					<div class="lqd-tm-img pos-rel">
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $name ), 'class' => 'w-100' ] ); ?>
						</figure>
					</div>
						
					<div class="lqd-tm-details d-flex lqd-overlay align-items-end">
						<div class="lqd-tm-details-inner d-flex align-items-end justify-content-between w-100 p-5">
							<div class="d-flex text-vertical align-items-center">
								<h3 class="mt-0 mb-2"><?php echo $name; ?></h3>
								<h6 class="mt-0 mb-0"><?php echo $position; ?></h6>
							</div>
							<div class="lqd-tm-details-icon ms-auto">
								<i class="lqd-icn-ess icon-md-arrow-forward"></i>
							</div>
						</div>
					</div>
					<?php if( !empty( $member_link ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'link' ); ?>></a>
					<?php endif; ?>
				<?php
				break;
			}
			?>

		</div>

		<?php
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Team_Member() );