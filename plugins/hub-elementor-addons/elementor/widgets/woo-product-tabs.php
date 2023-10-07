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
class LD_Woo_Product_Tabs extends Widget_Base {

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
		return 'ld_woo_product_tabs';
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
		return __( 'Liquid Product Tabs', 'hub-elementor-addons' );
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
		return 'eicon-product-tabs lqd-element';
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
		return [ 'hub-woo' ];
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
		return [ 'woocommerce', 'tabs', 'product' ];
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wc_tabs_typo',
				'label' => __( 'Tab Title Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} div.product .woocommerce-tabs ul.tabs li',
			]
		);

		$this->add_control(
			'wc_tabs_color',
			[
				'label' => esc_html__( 'Tab Title Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product .woocommerce-tabs ul.tabs li a' => 'color: {{VALUE}}',
					'{{WRAPPER}} div.product .woocommerce-tabs ul.wc-tabs' => 'border: none',
				],
			]
		);

		$this->add_control(
			'wc_tabs_active_color',
			[
				'label' => esc_html__( 'Tab Title Active Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product .woocommerce-tabs ul.tabs li a:hover, {{WRAPPER}} div.product .woocommerce-tabs ul.tabs li.active a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wc_tabs_heading_typo',
				'label' => __( 'Tab Heading Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} div.product .woocommerce-tabs .woocommerce-Tabs-panel h2, {{WRAPPER}} #reviews #comments h2',
			]
		);

		$this->add_control(
			'wc_tabs_heading_color',
			[
				'label' => esc_html__( 'Tab Heading Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product .woocommerce-tabs .woocommerce-Tabs-panel h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wc_tabs_content_typo',
				'label' => __( 'Tab Content Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} div.product .woocommerce-tabs .woocommerce-Tabs-panel--description p',
			]
		);

		$this->add_control(
			'wc_tabs_content_color',
			[
				'label' => esc_html__( 'Tab Content Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product .woocommerce-tabs .woocommerce-Tabs-panel--description p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wc_tabs_table_label_color',
			[
				'label' => esc_html__( 'Addional Information Table Label Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product .woocommerce-tabs .woocommerce-product-attributes-item__label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wc_tabs_table_value_color',
			[
				'label' => esc_html__( 'Addional Information Table Value Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product .woocommerce-tabs .woocommerce-product-attributes-item__value p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wc_tabs_table_bg',
			[
				'label' => esc_html__( 'Addional Information Table BG', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product .woocommerce-tabs table.shop_attributes th' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wc_tabs_table_bg2',
			[
				'label' => esc_html__( 'Addional Information Table BG 2', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product .woocommerce-tabs table.shop_attributes tr:nth-child(2n) th' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wc_tabs_table_bg3',
			[
				'label' => esc_html__( 'Addional Information Table BG 3', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product .woocommerce-tabs table.shop_attributes td' => 'background: {{VALUE}}!important',
				],
			]
		);

		// Reviews
		$this->add_control(
			'liquid_wc_single_product_reviews_heading',
			[
				'label' => esc_html__( 'Reviews', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_wc_single_product_reviews_form_typo',
				'label' => __( 'Form Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} #review_form form',
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_form_wrapper_bg',
			[
				'label' => esc_html__( 'Form Wrapper Bg', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form #respond' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_form_input_color',
			[
				'label' => esc_html__( 'Form Input Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form #respond .comment-form p' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'liquid_wc_single_product_reviews_form_input_color_hover',
			[
				'label' => esc_html__( 'Form Input Hover/Active Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form #respond .comment-form p.input-filled, {{WRAPPER}} #review_form #respond .comment-form p.input-focused' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'liquid_wc_single_product_reviews_form_input_border_color',
			[
				'label' => esc_html__( 'Form Input Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form #respond .comment-form p::before' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'liquid_wc_single_product_reviews_form_input_border_color_hover',
			[
				'label' => esc_html__( 'Form Input Border Active Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form #respond .comment-form p.input-filled::before, {{WRAPPER}} #review_form #respond .comment-form p.input-focused::before, {{WRAPPER}} #review_form #respond .comment-form p.input-filled::after, {{WRAPPER}} #review_form #respond .comment-form p.input-focused::after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_form_stars_color',
			[
				'label' => esc_html__( 'Stars Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form #respond .comment-form .stars, {{WRAPPER}} div.product .star-rating' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'liquid_wc_single_product_reviews_form_stars_border_color',
			[
				'label' => esc_html__( 'Stars Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form #respond .comment-form .comment-form-rating' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_review_bg',
			[
				'label' => esc_html__( 'Review Backgorund', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #reviews #comments ol.commentlist li' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_review_border_color',
			[
				'label' => esc_html__( 'Review Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #reviews #comments ol.commentlist li' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_review_text_color',
			[
				'label' => esc_html__( 'Review Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #reviews #comments ol.commentlist li' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_date_color',
			[
				'label' => esc_html__( 'Review Date Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #reviews #comments ol.commentlist li .comment-text .meta' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_single_product_reviews_author_color',
			[
				'label' => esc_html__( 'Review Author Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #reviews #comments ol.commentlist li .comment-text .woocommerce-review__author' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function get_woo_item() {
		$posts = get_posts(  array(
			'numberposts' => 1,
			'post_type'   => 'product'
		  ));
		  $postid;
		  foreach ( $posts as $post ) {
			$postid = $post->ID;
		  }
		  return $postid;
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
		
		// check
		if( !liquid_helper()->is_woocommerce_active() ) {
			return;
		}

		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ){
		global $product;
		$product = new \WC_Product( $this->get_woo_item() );
			?>
			<div class="woocommerce">
			<div class="product" style="padding:0">
			<div class="product product-layout-component lqd-product-tabs">
				<?php woocommerce_output_product_data_tabs(); ?>
			</div>
			</div>
			</div>
			<?php
		} else {
			?>
			<div class="product product-layout-component lqd-product-tabs">
				<?php woocommerce_output_product_data_tabs(); ?>
			</div>
			<?php
		}
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Woo_Product_Tabs() );