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
class LD_Header_Image extends Widget_Base {

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
		return 'ld_header_image';
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
		return __( 'Liquid Site Logo', 'hub-elementor-addons' );
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
		return 'eicon-site-logo lqd-element';
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
		return [ 'header', 'logo', 'image' ];
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
				'label' => __( 'Logo', 'hub-elementor-addons' ),
			)
		);

		$this->add_control(
			'logo_redirect_info',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( 'Go to the <strong><u>Elementor Site Settings > Site Identity</u></strong> to add your logo.', 'hub-elementor-addons' ) ),
				'separator' => 'after',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'uselogo',
			[
				'label' => __( 'Use logo from site settings?', 'hub-elementor-addons' ),
				'description' => __( 'Use logo set in elementor site settings panel', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose image', 'hub-elementor-addons' ),
				'description' => __( 'Add image from gallery or upload new', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'retina_image',
			[
				'label' => __( 'Retina image', 'hub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'hover_image',
			[
				'label' => __( 'Hover image', 'hub-elementor-addons' ),
				'description' => __( 'Add image from gallery or upload new', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'retina_hover_image',
			[
				'label' => __( 'Retina hover image', 'hub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'light_image',
			[
				'label' => __( 'Light image', 'hub-elementor-addons' ),
				'description' => __( 'Add image from gallery or upload new', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'retina_light_image',
			[
				'label' => __( 'Retina light image', 'hub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'dark_image',
			[
				'label' => __( 'Dark image', 'hub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'retina_dark_image',
			[
				'label' => __( 'Retina dark image', 'hub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);
		
		$this->add_control(
			'linkhome',
			[
				'label' => __( 'Link to homepage?', 'hub-elementor-addons' ),
				'description' => __( 'Link the logo to homepage', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'hub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => array(
					'linkhome' => ''
				)
			]
		);

		$this->add_control(
			'sticky_show_onsticky',
			[
				'label' => __( 'Show only on sticky?', 'hub-elementor-addons' ),
				'description' => __( 'Enable if you want the logo to show when header is sticky.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'usestickylogo',
			[
				'label' => __( 'Use sticky logo from site settings?', 'hub-elementor-addons' ),
				'description' => __( 'Use sticky logo set in site settings panel', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sticky_image',
			[
				'label' => __( 'Sticky image', 'hub-elementor-addons' ),
				'description' => __( 'Add image from gallery or upload new', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'usestickylogo' => ''
				)
			]
		);

		$this->add_control(
			'retina_sticky_image',
			[
				'label' => __( 'Retina sticky image', 'hub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'usestickylogo' => ''
				)
			]
		);

		$this->add_control(
			'useshapelogo',
			[
				'label' => __( 'Use shape for logo?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'navbar-brand-solid',
				'default' => '',
			]
		);
		
		$this->add_control(
			'shape_logo_style',
			[
				'label' => __( 'Shape logo style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'navbar-brand-round' => __( 'Round', 'hub-elementor-addons' ),
					'navbar-brand-circle' => __( 'Circle', 'hub-elementor-addons' ),
				],
				'condition' => array(
					'useshapelogo' => 'navbar-brand-solid'
				)
			]
		);

		$this->add_control(
			'shape_color',
			[
				'label' => __( 'Shape color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .navbar-brand-inner' => 'background: {{VALUE}}',
				],
				'condition' => array(
					'useshapelogo' => 'navbar-brand-solid'
				)
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => __( 'Logo padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .module-logo' => 'padding-top: {{TOP}}{{UNIT}};padding-inline-end:{{RIGHT}}{{UNIT}};padding-bottom:{{BOTTOM}}{{UNIT}};padding-inline-start:{{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '30',
					'right' => '0',
					'bottom' => '30',
					'left' => '0',
					'isLinked' => false,
					'unit' => 'px'
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'sticky_padding',
			[
				'label' => __( 'Sticky logo padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.is-stuck {{WRAPPER}} .module-logo' => 'padding-top: {{TOP}}{{UNIT}};padding-inline-end:{{RIGHT}}{{UNIT}};padding-bottom:{{BOTTOM}}{{UNIT}};padding-inline-start:{{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '30',
					'right' => '0',
					'bottom' => '30',
					'left' => '0',
					'isLinked' => false,
					'unit' => 'px'
				],
				'separator' => 'before',
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

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => [
					'module-logo',
					'd-flex',
					$settings['sticky_show_onsticky'],
					$settings['shape_logo_style'],
					$this->get_shape()
				],
				'id' => 'size-logo',
				'itemscope' => 'itemscope',
				'itemtype' => 'https://schema.org/Brand',
			]
		);
	
		?>
		
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php $this->get_logo(); ?>
		</div>

		<?php
	}

	protected function get_shape() {
		
		$settings = $this->get_settings_for_display();

		$classname = 'navbar-brand-plain';

		if ( 'navbar-brand-solid' === $settings['useshapelogo'] ) {
			$classname = 'navbar-brand-solid';
		}

		return $classname;

	}

	protected function get_logo() {

		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();
		
		$image        = $this->get_image();
		$hover_image	= $this->get_hover_image();
		$sticky_image = $this->get_sticky_image();
		
		$light_image  = $this->get_light_image();
		$dark_image   = $this->get_dark_image();

		if( empty( $image ) ) {
			return;
		}
		
		if( !empty( $mobile_logo ) ) {
			$image = $mobile_logo . $image;
		}
		
		$href = esc_url( home_url( '/' ) );
		
		if( isset( $this->get_settings_for_display('link')['url'] ) && !$this->get_settings_for_display('linkhome') ) {
			$href = $this->get_settings_for_display('link')['url'];	
		}
		
		printf( '<a class="navbar-brand d-flex p-0 pos-rel" href="%s" rel="home" itemprop="url"><span class="navbar-brand-inner post-rel">%s %s %s %s %s</span></a>', $href, $light_image, $dark_image, $hover_image, $sticky_image, $image ) ;
		
	}

	protected function get_image() {

		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();

		$settings = $this->get_settings_for_display();
		
		$src         = get_template_directory_uri() . '/assets/img/logo/logo-1.svg';
		$retina_src  = $scrset = '';
		
		$logo = $settings['image'];
		$retina_logo = $settings['retina_image'];
		
		if( $settings['uselogo'] ) {
			$img_array    = $global_settings['header_logo'];
			$retina_array = $global_settings['header_logo_retina'];
			
			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
			
			if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
				$retina_src = esc_url( $retina_array['url'] );
			}
			else {
				$retina_src = '';
			}
		}
		else {
			if( $logo ) {
				$src = $logo['url'];
			}
			if( $retina_logo ) {
				$retina_src = $retina_logo['url'];
			}
		}
		
		$alt = get_bloginfo( 'title' );
		$image_opts = array(
			'class' => 'logo-default',
			'alt' => esc_attr( $alt ),
		);

		if( !empty( $retina_src ) ) {
			$scrset = 'srcset="' . $retina_src . ' 2x"';
		}

		$image = sprintf( '<img class="logo-default" src="%s" alt="%s" itemprop="url" %s />', $src, $alt, $scrset );
		
		return $image;

	}

	protected function get_sticky_image() {

		$settings = $this->get_settings_for_display();
		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();
	
		$src = $retina_src  = $scrset = $image = '';
		
		$logo = $settings['sticky_image'];
		$retina_logo = $settings['retina_sticky_image'];

		if( $settings['usestickylogo'] ) {
			$img_array    = $global_settings['header_sticky_logo'];
			$retina_array = $global_settings['header_sticky_logo_retina'];
			
			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
			
			if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
				$retina_src = esc_url( $retina_array['url'] );
			}
			else {
				$retina_src = '';
			}
		}
		else {
			if( $logo ) {
				$src = $logo['url'];
			}
			if( $retina_logo ) {
				$retina_src = $retina_logo['url'];
			}
		}
		
		$alt = get_bloginfo( 'title' );
		$image_opts = array(
			'class' => 'logo-sticky',
			'alt' => esc_attr( $alt ),
		);

		if( !empty( $retina_src ) ) {
			$scrset = 'srcset="' . $retina_src . ' 2x"';
		}

		if( !empty( $src ) ) {
			$image = sprintf( '<img class="logo-sticky" src="%s" alt="%s" itemprop="url" %s />', $src, $alt, $scrset );	
		}
		
		return $image;
		
	}
	
	protected function get_hover_image() {
		
		$settings = $this->get_settings_for_display();
		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();
	
		$src = $retina_src  = $scrset = $image = '';
		
		$logo = $settings['hover_image'];
		$retina_logo = $settings['retina_hover_image'];

		if( $settings['uselogo'] ) {
			$img_array    = $global_settings['hover_header_logo'];
			$retina_array = $global_settings['hover_header_logo_retina'];
			
			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
			
			if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
				$retina_src = esc_url( $retina_array['url'] );
			}
			else {
				$retina_src = '';
			}
		}
		else {
			if( $logo ) {
				$src = $logo['url'];
			}
			if( $retina_logo ) {
				$retina_src = $retina_logo['url'];
			}
		}
		
		$alt = get_bloginfo( 'title' );
		$image_opts = array(
			'class' => 'logo-sticky',
			'alt' => esc_attr( $alt ),
		);

		if( !empty( $retina_src ) ) {
			$scrset = 'srcset="' . $retina_src . ' 2x"';
		}
		
		if( !empty( $src ) ) {
			$image = sprintf( '<span class="navbar-brand-hover d-inline-flex align-items-center justify-content-center lqd-overlay"><img class="logo-default flex-grow-1" src="%s" alt="%s" itemprop="url" %s /></span>', $src, $alt, $scrset );	
		}
		
		return $image;

	}

	protected function get_light_image() {

		$settings = $this->get_settings_for_display();
		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();
	
		$src = $retina_src  = $scrset = $image = '';
		
		$logo = $settings['light_image'];
		$retina_logo = $settings['retina_light_image'];

		if( $settings['uselogo'] ) {
			$img_array    = $global_settings['header_light_logo'];
			$retina_array = $global_settings['header_light_logo_retina'];
			
			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
			
			if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
				$retina_src = esc_url( $retina_array['url'] );
			}
			else {
				$retina_src = '';
			}
		}
		else {
			if( $logo ) {
				$src = $logo['url'];
			}
			if( $retina_logo ) {
				$retina_src = $retina_logo['url'];
			}
		}
		
		$alt = get_bloginfo( 'title' );
		$image_opts = array(
			'class' => 'logo-sticky',
			'alt' => esc_attr( $alt ),
		);

		if( !empty( $retina_src ) ) {
			$scrset = 'srcset="' . $retina_src . ' 2x"';
		}

		if( !empty( $src ) ) {
			$image = sprintf( '<img class="logo-light pos-abs" src="%s" alt="%s" itemprop="url" %s />', $src, $alt, $scrset );	
		}
		
		return $image;
		
	}
	
	protected function get_dark_image() {

		$settings = $this->get_settings_for_display();
		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();
	
		$src = $retina_src  = $scrset = $image = '';
		
		$logo = $settings['dark_image'];
		$retina_logo = $settings['retina_dark_image'];

		if( $settings['uselogo'] ) {
			$img_array    = $global_settings['header_dark_logo'];
			$retina_array = $global_settings['header_dark_logo_retina'];
			
			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
			
			if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
				$retina_src = esc_url( $retina_array['url'] );
			}
			else {
				$retina_src = '';
			}
		}
		else {
			if( $logo ) {
				$src = $logo['url'];
			}
			if( $retina_logo ) {
				$retina_src = $retina_logo['url'];
			}
		}
		
		$alt = get_bloginfo( 'title' );
		$image_opts = array(
			'class' => 'logo-sticky',
			'alt' => esc_attr( $alt ),
		);

		if( !empty( $retina_src ) ) {
			$scrset = 'srcset="' . $retina_src . ' 2x"';
		}

		if( !empty( $src ) ) {
			$image = sprintf( '<img class="logo-dark pos-abs" src="%s" alt="%s" itemprop="url" %s />', $src, $alt, $scrset );	
		}
		
		return $image;
		
	}

	

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Header_Image() );