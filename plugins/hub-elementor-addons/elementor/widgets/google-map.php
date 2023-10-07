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
use Elementor\Icons_Manager;

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
class LD_Google_Map extends Widget_Base {

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
		return 'ld_google_map';
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
		return __( 'Liquid Google Maps', 'elementor' );
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
		return 'eicon-google-maps lqd-element';
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
		return [ 'map', 'google' ];
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
			return [ 'google-maps-api', 'gsap' ];
		} else {
			return [ 'google-maps-api' ];
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

		$this->start_controls_section(
			'map_section',
			[
				'label' => __( 'Google Map', 'hub-elementor-addons' ),
			]
		);
		
		$this->add_control(
            'style',
            [
                'label' => __( 'Map Style', 'hub-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'wy',
                'options' => [
                    'assassinsCreedIV' => __( 'Assassins Creed IV', 'hub-elementor-addons' ),
                    'blueEssence' => __( 'Blue Essence', 'hub-elementor-addons' ),
                    'classic' => __( 'Classic', 'hub-elementor-addons' ),
                    'lightMonochrome' => __( 'Light Monochrome', 'hub-elementor-addons' ),
                    'unsaturatedBrowns' => __( 'Unsaturated Browns', 'hub-elementor-addons' ),
                    'wy' => __( 'WY', 'hub-elementor-addons' ),
                    'evenLighter' => __( 'Even Lighter', 'hub-elementor-addons' ),
                    'shadesOfGray' => __( 'Shades of Gray', 'hub-elementor-addons' ),
                ],
            ]
        );

        $this->add_control(
			'address',
			[
				'label' => __( 'Address', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 4,
				'default' => '7420 Shore Rd, Brooklyn, NY 11209, USA',
			]
		);

        $this->add_responsive_control(
			'map_height',
			[
				'label' => __( 'Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '550px',
				'selectors' => [
					'{{WRAPPER}} .ld-gmap-container' => 'height: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'map_marker',
			[
				'label' => __( 'Marker', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'separator' => 'before',
				'options' => [
					'default' => __( 'Default', 'hub-elementor-addons' ),
					'image' => __( 'Image', 'hub-elementor-addons' ),
					'html' => __( 'Animated Cricles', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'color_marker',
			[
				'label' => __( 'Marker Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .lqd-custom-map-marker, .lqd-custom-map-marker div' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'map_marker' => 'html',
				]
			]
		);

		$this->add_control(
			'custom_marker',
			[
				'label' => __( 'Custom Marker', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'map_marker' => 'image',
				]
			]
		);

		$this->add_control(
			'multiple_markers',
			[
				'label' => __( 'Multiple markers?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'hub-elementor-addons' ),
				'label_off' => __( 'No', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'lat',
			[
				'label' => __( 'Latitude', 'hub-elementor-addons' ),
				'description' => esc_html__( 'Marker Latitude', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'long',
			[
				'label' => __( 'Longitude', 'hub-elementor-addons' ),
				'description' => esc_html__( 'Marker Longitude', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
		);
		$this->add_control(
			'marker_coordinates',
			[
				'label' => __( 'Marker\'s coordinates', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'condition' => [
					'multiple_markers' => 'yes'
				]
			]
		);

		$this->add_control(
			'map_type',
			[
				'label'  => __( 'Map Type', 'hub-elementor-addons' ),
				'type'   => Controls_Manager::SELECT,
				'options' => [
					'roadmap'   => esc_html__( 'Roadmap', 'hub-elementor-addons' ),
					'satellite' => esc_html__( 'Satellite', 'hub-elementor-addons' ),
					'hybrid'    => esc_html__( 'Hybrid', 'hub-elementor-addons' ),
					'terrain'   => esc_Html__( 'Terrain', 'hub-elementor-addons' ),
				],
				'default' => 'roadmap',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'zoom',
			[
				'label' => __( 'Zoom', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 16,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'map_controls',
			[
				'label'  => __( 'Enable/Disable controls', 'hub-elementor-addons' ),
				'type'   => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => [
					'fullscreenControl' => __( 'Fullscreen', 'hub-elementor-addons' ),
					'panControl'        => __( 'Pan', 'hub-elementor-addons' ),
					'rotateControl'     => __( 'Rotate', 'hub-elementor-addons' ),
					'scaleControl'      => __( 'Scale', 'hub-elementor-addons' ),
					'scrollwheel'       => __( 'Scrollwheel', 'hub-elementor-addons' ),
					'streetViewControl' => __( 'Street View', 'hub-elementor-addons' ),
					'zoomControl'       => __( 'Zoom', 'hub-elementor-addons' ),
				],
				'default' => [
					'zoomControl'
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'map_info_box_section',
			[
				'label' => __( 'Info Box', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'show_info_box',
			[
				'label' => esc_html__( 'Show Info Box', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'hub-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'content_type',
			[
				'label' => __( 'Content type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tinymce',
				'label_block' => true,
				'options' => [
					'tinymce' => __( 'Repeater Items', 'hub-elementor-addons' ),
					'el_template' => __( 'Elementor Template', 'hub-elementor-addons' ),
				],
				'show_info_box' => 'yes'
			]
		);

		$this->add_control(
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
			'title',
			[
				'label' => esc_html__( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact us', 'hub-elementor-addons' ),
				'placeholder' => esc_html__( 'Type your title here', 'hub-elementor-addons' ),
				'condition' => [
					'show_info_box' => 'yes',
					'content_type' => 'tinymce'
				]
			]
		);

		$repeater2 = new Repeater();

		$repeater2->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'hub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater2->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'info_box_list',
			[
				'label' => esc_html__( 'Contact Info', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater2->get_controls(),
				'default' => [
					[
						'title' => esc_html__( '290 Maryam Springs 260, Courbevoie, Paris, France', 'hub-elementor-addons' ),
						'icon' => [
							'value' => 'fas fa-map-marker-alt',
							'library' => 'solid',
						],
					],
					[
						'title' => esc_html__( 'Phone:  +47 213 5941 295', 'hub-elementor-addons' ),
						'icon' => [
							'value' => 'fas fa-phone',
							'library' => 'solid',
						],
					],
				],
				'title_field' => '{{{ title }}}',
				'separator' => 'before',
				'condition' => [
					'show_info_box' => 'yes',
					'content_type' => 'tinymce'
				]
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'map_info_box_style_section',
			[
				'label' => __( 'Info Box Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_info_box' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'info_box_bg',
				'label' => __( 'Info box background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ld-gmap-contents',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'info_box_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .ld-gmap-contents',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-gmap-contents > h3' => 'color: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __( 'Title margin', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ld-gmap-contents > h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ld-gmap-contents > h3',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Contact info color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-gmap-contents .iconbox h3' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .ld-gmap-contents .iconbox h3',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-gmap-contents .iconbox .iconbox-icon-container' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'em',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .ld-gmap-contents .iconbox .iconbox-icon-container' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'iconbox_margin',
			[
				'label' => __( 'Info box margin', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iconbox' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		ld_el_btn($this, 'ib_', $condition = ['show_info_box' => 'yes']); // load button

	}

	protected function get_marker() {

		$map_marker = $this->get_settings_for_display('map_marker');

		if( empty( $map_marker ) || 'html' === $map_marker ) {
			return '';
		}

		if ( 'image' === $map_marker && isset( $this->get_settings_for_display('custom_marker')['url'] ) ) {
			return $this->get_settings_for_display('custom_marker')['url'];
		}

	}

	protected function get_coordinates() {

		$items = array();
		
		if( 'no' === $this->get_settings_for_display('multiple_markers') ) {
			return;
		}
		
		$items = is_array($this->get_settings_for_display('marker_coordinates')) ? array_filter( $this->get_settings_for_display('marker_coordinates') ) : null;
		
		if( empty( $items ) ) {
			return;
		}

		$data = array();

		foreach( $items as $item ) {
			$data[] = array( ''. esc_attr( $item['lat'] ) . '', '' . esc_attr( $item['long'] ) . '' );
		}

		return $data;

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
		extract($settings);

		if ( 0 === absint( $settings['zoom']['size'] ) ) {
			$settings['zoom']['size'] = 14;
		}
		
		$options = array(
			'style' => $settings['style'],
			'address' => $settings['address'],
			'marker_style' => $settings['map_marker'],
			'markers' => $this->get_coordinates(),
			'map'     => array(
				'zoom'      => $settings['zoom']['size'] ? intval( $settings['zoom']['size'] ) : 14,
				'mapTypeId' => $settings['map_type']
			)
		);

		if ( ! empty( $this->get_marker() ) ) {
			$options['marker'] = $this->get_marker();
		}

		// Map Controls
		$map_controls = $settings['map_controls'];
		
		if( $map_controls ) {
			$map = array();
			foreach( $map_controls as $control ) {
				$options['map'][ $control ] = true;
			}
		}
		
		?>

			<div class="ld-gmap-container pos-rel">
				<div class="ld-gmap h-100" data-plugin-map="true" data-plugin-options='<?php echo wp_json_encode( $options ) ?>'></div>

				<?php if ( 'yes' === $settings['show_info_box'] ) : ?>

				<div class="ld-gmap-contents">

					<?php if ( $settings['content_type'] === 'el_template' ){
						echo \Elementor\Plugin::instance()->frontend->get_builder_content( $settings['templates'], true ); 
					} else {
					?>

					<?php printf( '<h3>%s</h3>', esc_html( $settings['title'] ) ); ?>

					<?php if ( $settings['info_box_list'] ) : ?>
						<?php foreach (  $settings['info_box_list'] as $item ) : ?>
							<div class="iconbox iconbox-inline d-flex flex-wrap flex-grow-1 align-items-center elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
								<div class="iconbox-icon-wrap">
									<span class="iconbox-icon-container">
										<?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								</div>
								<?php printf( '<h3>%s</h3>', esc_html( $item['title'] ) ); ?>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>

				</div>

				<?php } ?>
				<?php endif; ?>

			</div>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Google_Map() );