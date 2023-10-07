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
class LD_Price_Table extends Widget_Base {

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
		return 'ld_price_table';
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
		return __( 'Liquid Price Table', 'hub-elementor-addons' );
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
		return 'eicon-price-table lqd-element';
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
		return [ 'price', 'table' ];
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
				'default' => 'style01',
				'options' => [
					'style01' => __( 'Style 1', 'hub-elementor-addons' ),
					'style02' => __( 'Style 2', 'hub-elementor-addons' ),
					'style03' => __( 'Style 3', 'hub-elementor-addons' ),
					'style03b' => __( 'Style 3B', 'hub-elementor-addons' ),
					'style04' => __( 'Style 4', 'hub-elementor-addons' ),
					'style05' => __( 'Style 5', 'hub-elementor-addons' ),
					'style06' => __( 'Style 6', 'hub-elementor-addons' ),
					'style07' => __( 'Style 7', 'hub-elementor-addons' ),
					'style08' => __( 'Style 8', 'hub-elementor-addons' ),
					'style09' => __( 'Style 9', 'hub-elementor-addons' ),
					'style10' => __( 'Style 10', 'hub-elementor-addons' ),
					'style11' => __( 'Style 11', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'hub-elementor-addons' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-pt-title',
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => __( 'Subtitle', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Subtitle', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'hub-elementor-addons' ),
				'condition' => [
					'template' => 'style11'
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Subtitle', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your text here', 'hub-elementor-addons' ),
				'condition' => [
					'template' => [ 'style03', 'style03b', 'style04', 'style07', 'style09', 'style11' ]
				],
			]
		);

		$this->add_control(
			'price',
			[
				'label' => __( 'Price', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '$12', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your price here', 'hub-elementor-addons' ),
				'condition' => [
					'template!' => [ 'style01' ]
				],
			]
		);

		$this->add_control(
			'featured_tag',
			[
				'label' => __( 'Show tag?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'featured_label',
			[
				'label' => __( 'Tag label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Featured', 'hub-elementor-addons' ),
				'placeholder' => __( 'Type your label here', 'hub-elementor-addons' ),
				'condition' => [
					'featured_tag' => 'yes' 
				],
			]
		);

		$this->add_control(
			'pt_scale_bg',
			[
				'label' => __( 'Scale up background?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Features', 'hub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '<ul><li>Free One Year Domain</li><li>10+ Pages Design</li><li>Full Organized Layered</li><li>Unlimited Revision</li><li>50% Discount Off</li><li>Free Logo Design</li><li>Free Stationary Design</li></ul>',
				'placeholder' => __( 'Type your text here', 'hub-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-pt-body',
			]
		);

		$this->add_control(
			'footer_text',
			[
				'label' => __( 'Footer Text', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Type your text here', 'hub-elementor-addons' ),
				'condition' => [
					'template' => [ 'style04', 'style09' ]
				],
			]
		);
		$this->end_controls_section();

		// Colors
		$this->start_controls_section(
			'color_section',
			[
				'label' => __( 'Colors', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pt_title_color',
			[
				'label' => __( 'Title Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pt_subtitle_color',
			[
				'label' => __( 'Subtitle Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt-head p' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => [ 'style03', 'style03b', 'style04', 'style07', 'style09', 'style11' ]
				]
			]
		);

		$this->add_control(
			'pt_price_color',
			[
				'label' => __( 'Price Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt-price' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template!' => [ 'style01' ]
				]
			]
		);

		$this->add_control(
			'pt_text_color',
			[
				'label' => __( 'Body Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pt_bg_heading',
			[
				'label' => __( 'Background color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'pt_bg',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-pt-bg',
			]
		);

		$this->add_control(
			'pt_title_bg_heading',
			[
				'label' => __( 'Title Background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'template' => [ 'style01', 'style09' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'pt_title_bg',
				'label' => __( 'Title Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-pt-head',
				'condition' => [
					'template' => [ 'style01' ]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'pt_title_bg_style09',
				'label' => __( 'Title Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-pt-title',
				'condition' => [
					'template' => [ 'style09' ]
				]
			]
		);

		$this->add_control(
			'pt_border_color',
			[
				'label' => __( 'Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt, {{WRAPPER}} .lqd-pt-foot, {{WRAPPER}} .lqd-pt-body, {{WRAPPER}} .lqd-pt-head p, {{WRAPPER}} .lqd-pt .lqd-pt-head, {{WRAPPER}} .lqd-pt .lqd-pt-head p, {{WRAPPER}} .lqd-pt figure' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'template!' => [ 'style03', 'style06' ]
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'pt_tag_color',
			[
				'label' => __( 'Tag Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt-label' => 'color: {{VALUE}}',
				],
				'condition' => [
					'featured_tag' => 'yes' 
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'pt_tag_bg_heading',
			[
				'label' => __( 'Tag Background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'featured_tag' => 'yes' 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'pt_tag_bg',
				'label' => __( 'Tag Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-pt-label',
				'condition' => [
					'featured_tag' => 'yes' 
				],
			]
		);
		
		$this->end_controls_section();

		ld_el_btn($this, 'ib_'); // load button

	}

	protected function ld_get_title( $classes = '' ) {

		$settings = $this->get_settings_for_display();

		// check
		if( empty( $settings['title'] ) ) {
			return '';
		}
		
		if( !empty( $classes ) ) {
			$class = 'class="lqd-pt-title ' . $classes . '"';
		}
		else {
			$class = 'class="lqd-pt-title"';
		}

		$title = wp_kses_post( $settings['title'] );
		
		// Default
		$title = sprintf( '<h4 %s> %s</h4>', $class, $title );

		echo $title;

	}
	
	protected function ld_get_description() {

		$settings = $this->get_settings_for_display();

		if( !$settings['description'] ) {
			return;
		}

		$style = $settings['template'];
		
		if( 'style03' === $style ) {
			echo '<p class="lqd-pt-description-lg mb-0">' . wp_kses_post( $settings['description'] ) . '</p>';			
		} 
		elseif( 'style03b' === $style ) {
			echo '<p class="lqd-pt-description-md mb-0">' . wp_kses_post( $settings['description'] ) . '</p>';	
		}
		elseif( 'style04' === $style ) {
			echo '<p class="lqd-pt-description text-uppercase ltr-sp-1 mb-1">' . wp_kses_post( $settings['description'] ) . '</p>';	
		}
		elseif( 'style11' === $style ) {
			echo '<p class="lqd-pt-description mb-1">' . wp_kses_post( $settings['description'] ) . '</p>';	
		}
		else {
			echo '<p class="lqd-pt-description mb-0">' . wp_kses_post( $settings['description'] ) . '</p>';
		}
		
		
	}
	
	protected function ld_get_featured_tag() {

		$settings = $this->get_settings_for_display();
		
		if( !$settings['featured_tag'] ) {
			return;
		}
		$featured_label = '';
		if( !empty( $settings['featured_label'] ) ) {
			$featured_label = $settings['featured_label'];
		}
		
		if( 'style03b' === $settings['template'] ) {
			printf( '<span class="lqd-pt-label font-weight-bold border-radius-circle">%s</span>', $featured_label );
		}
		elseif( 'style10' === $settings['template'] ) {
			printf( '<span class="lqd-pt-label text-uppercase ltr-sp-1 font-weight-semibold border-radius-4">%s</span>', $featured_label );
		}
		elseif( 'style11' === $settings['template'] ) {
			printf( '<span class="lqd-pt-label text-uppercase ltr-sp-1 font-weight-semibold">%s</span>', $featured_label );
		}
		else {
			printf( '<span class="lqd-pt-label text-uppercase ltr-sp-1 font-weight-semibold border-radius-4">%s</span>', $featured_label );
		}
		
	}

	protected function ld_get_price() {

		$settings = $this->get_settings_for_display();

		// check
		if( empty( $settings['price'] ) ) {
			return '';
		}

		$out = '';

		$price = wp_kses_post( do_shortcode( $settings['price'] ) );
		
		if( 'style02' ===  $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price font-weight-medium mt-0 mb-4">%s</span>', $price );
		}
		elseif( 'style03' ===  $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price font-weight-semibold mt-5 mb-3">%s</span>', $price );
		}
		elseif( 'style03b' ===  $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price font-weight-semibold mt-3 mb-2">%s</span>', $price );
		}
		elseif( 'style04' ===  $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price mb-1">%s</span>', $price );
		}
		elseif( 'style06' ===  $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price font-weight-medium">%s</span>', $price );
		}
		elseif( 'style07' === $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price mb-5 mt-5">%s</span>', $price );
		}
		elseif( 'style08' === $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price font-weight-bold mb-3">%s</span>', $price );
		}
		elseif( 'style09' === $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price font-weight-semibold mb-2">%s</span>', $price );
		}
		elseif( 'style10' === $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price font-weight-medium">%s</span>', $price );
		}
		elseif( 'style11' === $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price mb-4">%s</span>', $price );
		}
		else {
			$out .= sprintf( '<span class="lqd-pt-price">%s</span>', $price );	
		}

		echo $out;
	}
	
	protected function ld_get_features() {

		$settings = $this->get_settings_for_display();

		// check
		if( empty( $settings['content'] ) ) {
			return '';
		}

		$content = ld_helper()->do_the_content( $settings['content'] );

		echo wp_kses_post( $content );
	}

	protected function ld_get_footer_text() {

		$settings = $this->get_settings_for_display();
		
		// check
		if( empty( $settings['footer_text'] ) ) {
			return '';
		}

		$content = ld_helper()->do_the_content( $this->atts['footer_text'] );

		echo '<div class="lqd-pt-footer-extra mt-2">' . wp_kses_post( $content ) . '</div>';
		
	}

	protected function ld_get_class( $style ) {

		$hash = array(
			'style01'  => 'lqd-pt-style-1 pos-rel border-radius-4',
			'style02'  => 'lqd-pt-style-2 pos-rel border-radius-4',
			'style03'  => 'lqd-pt-style-3 pos-rel',
			'style03b' => 'lqd-pt lqd-pt-style-3 lqd-pt-style-3b pos-rel',
			'style04'  => 'lqd-pt-style-4 pos-rel text-center',
			'style05'  => 'lqd-pt-style-5 pos-rel border-radius-4 text-center',
			'style06'  => 'lqd-pt-style-6 pos-rel border-radius-10',
			'style07'  => 'lqd-pt-style-7 pos-rel border-radius-4',
			'style08'  => 'lqd-pt-style-8 pos-rel border-radius-4',
			'style09'  => 'lqd-pt-style-9 pos-rel border-radius-8',
			'style10'  => 'lqd-pt-style-10 pos-rel border-radius-6',
			'style11'  => 'lqd-pt-style-11 pos-rel text-center',

		);

		return $hash[ $style ];
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

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => [ 'lqd-pt', $settings['pt_scale_bg'] === 'yes' ? 'lqd-pt-scale-bg' : '', $this->ld_get_class( $template ) ],
			]
		);

		?><div <?php $this->print_render_attribute_string( 'wrapper' ); ?>><?php
		switch ($template){
			case 'style01':
			?>

				<div class="lqd-pt-inner">

					<div class="lqd-pt-bg lqd-overlay"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel text-center ps-2 pe-2 pt-4 pb-4">
						<?php $this->ld_get_title( 'font-weight-semibold' ); ?>
					</div>

					<div class="lqd-pt-body font-weight-medium pos-rel ps-5 pe-5 pt-3 pb-3">
						<?php $this->ld_get_features() ?>
					</div>

					<?php  if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel ps-5 pe-5 pb-5">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
					</div>
					<?php endif; ?>

				</div>

			<?php
			break;
			
			case 'style02':
			?>

				<div class="lqd-pt-inner ps-5 pe-5 pt-4 pb-4">

					<div class="lqd-pt-bg lqd-overlay"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel">

						<?php $this->ld_get_title( 'font-weight-normal mb-3' ); ?>
						<?php $this->ld_get_price(); ?>

					</div>

					<div class="lqd-pt-body pos-rel">
						<?php $this->ld_get_features() ?>
					</div>

					<?php  if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel mt-4">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
					</div>
					<?php endif; ?>


				</div>

			<?php
			break;
			
			case 'style03':
			?>
				<div class="lqd-pt-inner pt-6 pb-6 ps-5 pe-5">

					<div class="lqd-pt-bg lqd-overlay"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel pt-2">

						<?php $this->ld_get_title( 'font-weight-semibold text-uppercase ltr-sp-2 mb-0 mt-0' ); ?>
						<?php $this->ld_get_price(); ?>
						<?php $this->ld_get_description(); ?>

					</div>

					<div class="lqd-pt-body pos-rel pt-4 pb-4">
						<?php $this->ld_get_features() ?>
					</div>

					<?php  if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel pt-4 pb-2">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
					</div>
					<?php endif; ?>

				</div>
			<?php
			break;
			
			case 'style03b':
			?>

				<div class="lqd-pt-inner pt-6">

					<div class="lqd-pt-bg lqd-overlay"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel pt-3 ps-5 pe-5">

						<?php $this->ld_get_title( 'font-weight-semibold text-uppercase ltr-sp-2 mb-0 mt-0' ); ?>
						<?php $this->ld_get_price(); ?>
						<?php $this->ld_get_description(); ?>

					</div>

					<div class="lqd-pt-body pos-rel pt-4 pb-5 ps-5 pe-5 mb-5">
						<?php $this->ld_get_features() ?>
					</div>

					<?php  if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel pt-3 pb-3 text-center">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
					</div>
					<?php endif; ?>
					

				</div>

			<?php
			break;
			
			case 'style04':
			?>

				<div class="lqd-pt-inner pt-6 pb-6">

					<div class="lqd-pt-bg lqd-overlay"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel ps-3 pe-3 pb-5">

						<?php $this->ld_get_title( 'font-weight-semibold text-uppercase ltr-sp-2 mt-0 mb-3' ); ?>
						<?php $this->ld_get_price(); ?>
						<?php $this->ld_get_description(); ?>

					</div>

					<div class="lqd-pt-body pos-rel ps-3 pe-3 pt-3 pb-3">
						<?php $this->ld_get_features() ?>
					</div>
					
					<div class="lqd-pt-foot pos-rel ps-3 pe-3 pt-5">
						<?php
							$button = new \LQD_Elementor_Render_Button;
							$button->get_button( $this, 'ib_' ); 
						?>
						<?php $this->ld_get_footer_text(); ?>

					</div>

				</div>

			<?php
			break;
			
			case 'style05':
			?>

				<div class="lqd-pt-inner pt-5 pb-4">

					<div class="lqd-pt-bg lqd-overlay border-radius-4"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel ps-3 pe-3 pt-5 pb-5">
						<?php $this->ld_get_title( 'font-weight-medium text-uppercase ltr-sp-2 mt-0 mb-4' ); ?>
						<?php $this->ld_get_price(); ?>
					</div>
					<div class="lqd-pt-body pos-rel ps-3 pe-3 pt-2 pb-2">
						<?php $this->ld_get_features() ?>
					</div>

					<?php if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel ps-3 pe-3 pt-3 pb-3">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
					</div>
					<?php endif; ?>

				</div>

			<?php
			break;
			
			case 'style06':
			?>

				<div class="lqd-pt-inner pt-5 pb-5 ps-4 pe-4">

					<div class="lqd-pt-bg lqd-overlay border-radius-10"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel text-center">
						<?php $this->ld_get_title( 'font-weight-medium text-uppercase ltr-sp-2 mt-0 mb-5' ); ?>
						<br>
						<?php $this->ld_get_price(); ?>
					</div>

					<div class="lqd-pt-body pos-rel pt-6 pb-6">
						<?php $this->ld_get_features() ?>
					</div>

					<?php if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel text-center pt-1 pb-5">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
					</div>
					<?php endif; ?>

				</div>

			<?php
			break;
			
			case 'style07':
			?>

				<div class="lqd-pt-inner p-5 text-center">

					<div class="lqd-pt-bg lqd-overlay border-radius-4"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel">
						<?php $this->ld_get_title(); ?>
						<?php $this->ld_get_price(); ?>
						<?php $this->ld_get_description(); ?>
					</div>
					<div class="lqd-pt-body pos-rel mt-4 pt-3 pb-3">
						<?php $this->ld_get_features() ?>
					</div>

					<?php if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel pb-2">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
					</div>
					<?php endif; ?>

				</div>

			<?php
			break;
			
			case 'style08':
			?>

				<div class="lqd-pt-inner pt-6 pb-5">

					<div class="lqd-pt-bg lqd-overlay border-radius-4"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel ps-5 pe-5 pb-4 text-center">
						<?php $this->ld_get_price(); ?>
						<?php $this->ld_get_title( 'font-weight-medium mb-1' ); ?>
					</div>

					<div class="lqd-pt-body pos-rel pt-3 ps-5 pe-5">
						<?php $this->ld_get_features() ?>
					</div>

					<?php if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel pt-3 text-center">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
					</div>
					<?php endif; ?>

				</div>

			<?php
			break;
			
			case 'style09':
			?>

				<div class="lqd-pt-inner ps-5 pe-5 pt-4 pb-4">

					<div class="lqd-pt-bg lqd-overlay border-radius-8"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<?php if( !empty( $title ) ) { ?>
					<h4 class="lqd-pt-title text-uppercase ltr-sp-1 font-weight-semibold border-radius-4"><?php echo $title; ?></h4>
					<?php } ?>

					<div class="lqd-pt-head pos-rel pt-3 pb-3">
						<?php $this->ld_get_price(); ?>
						<?php $this->ld_get_description(); ?>
					</div>

					<div class="lqd-pt-body pos-rel">
						<?php $this->ld_get_features() ?>
					</div>
					<?php if( !empty( $footer_text ) ) { ?>
					<div class="lqd-pt-foot pos-rel pt-4 pb-4">
						<?php echo wp_kses_post( $footer_text ); ?>
					</div>
					<?php } ?>
					<?php if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pt-4">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
					</div>
					<?php endif; ?>

				</div>

			<?php
			break;
			
			case 'style10':
			?>

				<div class="lqd-pt-inner text-center pt-6 pb-6">

					<div class="lqd-pt-bg lqd-overlay border-radius-6"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel ps-5 pe-5 pb-6">
						<?php $this->ld_get_price(); ?>
					</div>

					<div class="lqd-pt-body pos-rel pt-5 pb-3 ps-5 pe-5">
						<?php $this->ld_get_features() ?>
					</div>

					<?php if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel ps-5 pe-5">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
					</div>
					<?php endif; ?>

				</div>

			<?php
			break;
			
			case 'style11':
			?>

				<?php $this->ld_get_featured_tag(); ?>
				
				<div class="lqd-pt-inner pb-6">

					<div class="lqd-pt-bg lqd-overlay"></div>

					<div class="lqd-pt-head pos-rel">

						<?php if( !empty( $title ) ) { ?>
						<h4 class="lqd-pt-title mt-0 mb-0"><?php echo $title; ?></h4>
						<?php } ?>
						
						<?php if( !empty( $subtitle ) ) { ?>
						<p><?php echo $subtitle; ?></p>
						<?php } ?>

						<?php $this->ld_get_price(); ?>
						<?php $this->ld_get_description(); ?>

					</div>

					<div class="lqd-pt-body pos-rel ps-3 pe-3 pt-3 pb-3">
						<?php $this->ld_get_features() ?>
					</div>

					<?php if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel p-3">
					<?php
						$button = new \LQD_Elementor_Render_Button;
						$button->get_button( $this, 'ib_' ); 
					?>
					</div>
					<?php endif; ?>

				</div>

			<?php
			break;
		}
		?></div><?php
		
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Price_Table() );