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
class LD_Header_Dropdown extends Widget_Base {

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
		return 'ld_header_dropdown';
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
		return __( 'Liquid Header Dropdown', 'hub-elementor-addons' );
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
		return 'eicon-menu-toggle lqd-element';
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
		return [ 'hub-header' ];
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
		return [ 'icon', 'box', 'header' ];
	}

	private function get_available_menus() {
		$menus = wp_get_nav_menus();
		$options = [];
		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}
		return $options;
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
				'label' => __( 'Header Dropdown', 'hub-elementor-addons' ),
			)
		);

		$this->add_control(
			'i_type',
			[
				'label' => __( 'Icon Library', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fontawesome',
				'options' => [
					'fontawesome'  => __( 'Icon Library', 'hub-elementor-addons' ),
					'image' => __( 'Image', 'hub-elementor-addons' ),
				],
			]
		);

        $this->add_control(
			'i_icon_fontawesome',
			[
				'label' => __( 'Icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-chevron-down',
					'library' => 'solid',
				],
                'condition' => array(
                    'i_type' => 'fontawesome',
                ),
			]
		);

		$this->add_control(
			'i_icon_image',
			[
				'label' => __( 'Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
                    'i_type' => 'image',
                ),
			]
		);
		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'em',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .ld-module-trigger-txt i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'i_type' => 'fontawesome',
				),
			]
		);

		$this->add_control(
			'trigger_label',
			[
				'label' => __( 'Trigger Label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Add trigger label to dropdown', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label' => __( 'Data Source', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wp_menus',
				'options' => [
					'wp_menus' => __( 'WP Menus', 'hub-elementor-addons' ),
					'custom' => __( 'Custom', 'hub-elementor-addons' ),
				],
			]
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu_slug',
				[
					'label' => __( 'Menu', 'hub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'save_default' => true,
					'separator' => 'after',
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'hub-elementor-addons' ), admin_url( 'nav-menus.php' ) ),
					'condition' => array(
						'source' => 'wp_menus'
					)
				]
			);
		} else {
			$this->add_control(
				'menu_slug',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'hub-elementor-addons' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition' => array(
						'source' => 'wp_menus'
					)
				]
			);
		}

		$repeater = new Repeater();

		$repeater->add_control(
			'label', [
				'label' => __( 'Label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Menu' , 'hub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'hub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => ''
				],
			]
		);


		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'label' => __( 'Menu #1', 'hub-elementor-addons' ),
						'link' => '#',
					],
					[
						'label' => __( 'Menu #2', 'hub-elementor-addons' ),
						'link' => '#',
					],
				],
				'title_field' => '{{{ label }}}',
				'condition' => [
					'source' => 'custom'
				]
			]
		);


		$this->add_control(
			'hover_style',
			[
				'label' => __( 'Hover Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'ld-dropdown-menu-underlined' => __( 'Underlined', 'hub-elementor-addons' ),
				],
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
					'name' => 'label_typography',
					'label' => __( 'Label Typography', 'hub-elementor-addons' ),
					'selector' => '{{WRAPPER}} .ld-module-trigger-txt',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'dropdown_typography',
					'label' => __( 'Dropdown Typography', 'hub-elementor-addons' ),
					'selector' => '{{WRAPPER}} .ld-dropdown-menu-content',
				]
			);

			$this->add_control(
				'trigger_color',
				[
					'label' => __( 'Label Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ld-module-trigger-txt' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'color',
				[
					'label' => __( 'Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ld-dropdown-menu li > a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'hcolor',
				[
					'label' => __( 'Hover Color', 'hub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ld-dropdown-menu li > a:hover' => 'color: {{VALUE}}',
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

		$trigger_label = $settings['trigger_label'];
		$source = $settings['source'];
		$menu_slug = isset($settings['menu_slug']) ? $settings['menu_slug'] : '';
		$dropdown_id = 'dropdown-' . $this->get_id();

		$this->add_render_attribute(
			'wrapper',
			[
				'id' => 'lqd-dropdown-' . $this->get_id(),
				'class' => [ 'ld-dropdown-menu', 'd-flex', 'pos-rel', $settings['hover_style'] ],
			]
		);

		$this->add_render_attribute(
			'trigger',
			[
				'class' => [ 'ld-module-trigger' ],
				'role' => 'button',
				'data-ld-toggle' => 'true',
				'data-toggle' => 'collapse',
				'data-target' => '#' . $dropdown_id,
				'aria-controls' => $dropdown_id,
				'aria-expanded' => 'false',
				'data-toggle-options' => '{ "type": "hoverFade" }',
			]
		);

		?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>

				<span <?php $this->print_render_attribute_string( 'trigger' ); ?>>
					<span class="ld-module-trigger-txt"><?php if( !empty( $trigger_label ) ) { ?><?php echo esc_html( $trigger_label ); ?><?php }; ?> <?php $this->get_the_icon(); ?></span>
				</span>

				<div class="ld-module-dropdown left collapse pos-abs" id="<?php echo $dropdown_id ?>">
					<div class="ld-dropdown-menu-content">
					<?php if( 'wp_menus' === $source ) : ?>
					<?php

						if( is_nav_menu( $menu_slug ) ) {
							wp_nav_menu( array(
								'menu'           => $menu_slug,
								'container'      => 'ul',
								'menu_id'        => false,
								'before'         => false,
								'after'          => false,
								'link_before'    => '',
								'link_after'     => '',
								'menu_class'     => false,
								'depth'          => 1,
								'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new \Liquid_Mega_Menu_Walker : '',
							) );
						}
						else {
							wp_nav_menu( array(
								'container'      => 'ul',
								'container_id'   => false,
								'before'         => false,
								'after'          => false,
								'link_before'    => '',
								'link_after'     => '',
								'menu_class'     => false,
								'depth'          => 1,
								'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new \Liquid_Mega_Menu_Walker : '',
							));

						};
					?>
					<?php else: ?>
						<ul>
						<?php
							foreach ( $settings['items'] as $item ) {
								if ( $item['link']['url'] ){
									$this->add_link_attributes( 'link' . $item['_id'], $item['link'] );
								}
								$attr = $this->get_render_attribute_string( 'link' . $item['_id'] );
								printf( '<li><a %s>%s</a></li>', $attr, esc_html( $item['label'] ) );
							}
						?>
						</ul>
					<?php endif; ?>
					</div>
				</div>

			</div>

		<?php

	}

	protected function get_the_icon() {

		$settings = $this->get_settings_for_display();



		if( ! empty( $settings['i_type'] ) ) {
			if( 'image' === $settings['i_type'] || 'animated' === $settings['i_type'] ) {
				$filetype = wp_check_filetype( $settings['i_icon_image']['url'] );
				if( 'svg' === $filetype['ext'] ) {
					$request  = wp_remote_get( $settings['i_icon_image']['url'] );
					$response = wp_remote_retrieve_body( $request );
					$svg_icon = $response;

					echo $svg_icon;
				}
				else {
					printf( '<img src="%s" class="lqd-image-icon" />', esc_url( $settings['i_icon_image']['url'] ) );
				}
			}
			else {
				printf( '<i class="%s"></i>', $settings['i_icon_fontawesome']['value'] );
			}
		}
		else {
			echo '<i class="lqd-icn-ess icon-ion-ios-arrow-down"></i>';
		}

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Header_Dropdown() );