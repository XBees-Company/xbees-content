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
class LD_Woo_Order_Params extends Widget_Base {

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
		return 'ld_woo_order_params';
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
		return __( 'Liquid Woo Order Params', 'hub-elementor-addons' );
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
		return 'eicon-purchase-summary lqd-element';
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
		return [ 'woocommerce', 'cart', 'order', 'summary', 'purchase' ];
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
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'note',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'This widget is working with "Custom Thank You Page" only. Manage your custom page from: WooCommerce > Settings > Advanced > Custom thank you page', 'hub-elementor-addons' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'param',
			[
				'label' => esc_html__( 'Select Param', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'number',
				'options' => [
					'number'  => esc_html__( 'Order Number', 'hub-elementor-addons' ),
					'date' => esc_html__( 'Order Date', 'hub-elementor-addons' ),
					'total' => esc_html__( 'Order Total', 'hub-elementor-addons' ),
					'email' => esc_html__( 'Billing Email', 'hub-elementor-addons' ),
					'payment' => esc_html__( 'Payment Method', 'hub-elementor-addons' ),
					'thankyou' => esc_html__( 'Thank You Message', 'hub-elementor-addons' ),
					'detail_table' => esc_html__( 'Detail Table', 'hub-elementor-addons' ),
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

		$order = isset( $_GET['key'] ) ? new \WC_Order( wc_get_order_id_by_order_key( $_GET['key'] ) ) : '';


		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() || ( class_exists( 'WooCommerce' ) && ! is_checkout() ) ){

			$content = '<div class="woocommerce-order-received"><div class="woocommerce"><div class="woocommerce-order">';

			switch( $this->get_settings_for_display( 'param' ) ){
				
				case 'number':
					$content .= '123';
					break;
				case 'date':
					$content .= date(get_option('date_format'));
					break;
				case 'email':
					$content .= get_option('admin_email');
					break;
				case 'total':
					$content .= '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>18.00</span>';
					break;
				case 'payment':
					$content .= 'Pay with cash upon delivery.';
					break;
				case 'thankyou':
					$content .= apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'hub' ), null );
					break;
				case 'detail_table':
					$content .= '<section class="woocommerce-order-details"><h2 class="woocommerce-order-details__title">Order details</h2><table class="woocommerce-table woocommerce-table--order-details shop_table order_details"><thead><tr><th class="woocommerce-table__product-name product-name">Product</th><th class="woocommerce-table__product-table product-total">Total</th></tr></thead><tbody><tr class="woocommerce-table__line-item order_item"><td class="woocommerce-table__product-name product-name"><a href="#">T-Shirt with Logo</a><strong class="product-quantity">×&nbsp;1</strong></td><td class="woocommerce-table__product-total product-total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>18.00</bdi></span></td></tr></tbody><tfoot><tr><th scope="row">Subtotal:</th><td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>18.00</span></td></tr><tr><th scope="row">Payment method:</th><td>Cash on delivery</td></tr><tr><th scope="row">Total:</th><td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>18.00</span></td></tr></tfoot></table></section><section class="woocommerce-customer-details"><h2 class="woocommerce-column__title">Billing address</h2><address>John Doe<br>tow, CA 12312-3123<p class="woocommerce-customer-details--phone">11111111111</p><p class="woocommerce-customer-details--email">' . get_option('admin_email') . '</p></address></section>';
					break;
			}

			echo $content . '</div></div></div>';

		} else {

			if ( $order ){

				switch( $this->get_settings_for_display( 'param' ) ){
					
					case 'number':
						$content = $order->get_order_number();
						break;
					case 'date':
						$content = wc_format_datetime( $order->get_date_created() );
						break;
					case 'email':
						$content = $order->get_billing_email();
						break;
					case 'total':
						$content = $order->get_formatted_order_total();
						break;
					case 'payment':
						$content = $order->get_payment_method_title();
						break;
					case 'thankyou':
						$content = apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'hub' ), null );
						break;
					case 'detail_table':
						$content = woocommerce_order_details_table( $order->get_id() );
						break;
				}

				echo $content;

			}
			
		}
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Woo_Order_Params() );