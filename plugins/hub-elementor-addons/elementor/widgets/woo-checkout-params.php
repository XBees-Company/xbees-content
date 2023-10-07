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
class LD_Woo_Checkout_Params extends Widget_Base {

	public function __construct($data = [], $args = null) {

		parent::__construct($data, $args);
		
		

		
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
		return 'ld_woo_checkout_params';
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
		return __( 'Liquid Woo Checkout Params', 'hub-elementor-addons' );
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
		return [ 'woocommerce', 'cart', 'checkout' ];
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
				'raw' => esc_html__( 'This widget is working with "Checkout page" only. Manage your custom page from: WooCommerce > Settings > Advanced > Checkout page', 'hub-elementor-addons' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'param',
			[
				'label' => esc_html__( 'Select Param', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'woocommerce_checkout_billing',
				'options' => [
					'woocommerce_checkout_billing'  => esc_html__( 'Billing Form', 'hub-elementor-addons' ),
					'woocommerce_checkout_shipping' => esc_html__( 'Addional Information', 'hub-elementor-addons' ),
					'woocommerce_checkout_order_review' => esc_html__( 'Order Review', 'hub-elementor-addons' ),
					'woocommerce_checkout_payment' => esc_html__( 'Order Payment', 'hub-elementor-addons' ),
					'woocommerce_checkout_before_order_review' => esc_html__( 'Before Order Review [Hook]', 'hub-elementor-addons' ),
					'woocommerce_checkout_after_order_review' => esc_html__( 'After Order Review [Hook]', 'hub-elementor-addons' ),
					'woocommerce_checkout_after_customer_details' => esc_html__( 'After Customer Details [Hook]', 'hub-elementor-addons' ),
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

		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() || ( class_exists( 'WooCommerce' ) && ! is_checkout() ) ){

			echo '<div class="woocommerce"><form name="checkout" method="post" class="clearfix checkout woocommerce-checkout" action="#" enctype="multipart/form-data" novalidate="novalidate">';

			switch( $this->get_settings_for_display( 'param' ) ){
				case 'woocommerce_checkout_billing':
					$content = '<div class="woocommerce-billing-fields"> <h3>Billing details</h3> <div class="woocommerce-billing-fields__field-wrapper"> <p class="form-row form-row-first validate-required" id="billing_first_name_field" data-priority="10"><label for="billing_first_name">First name&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="text" class="input-text" name="billing_first_name" id="billing_first_name" autocomplete="given-name" /></span></p><p class="form-row form-row-last validate-required" id="billing_last_name_field" data-priority="20"><label for="billing_last_name">Last name&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="billing_last_name" id="billing_last_name" autocomplete="family-name" /></span></p><p class="form-row form-row-wide" id="billing_company_field" data-priority="30"><label for="billing_company">Company name&nbsp;<span class="optional">(optional)</span></label><span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="billing_company" id="billing_company" autocomplete="organization" /></span></p><p class="form-row form-row-wide address-field update_totals_on_change validate-required" id="billing_country_field" data-priority="40"><label for="billing_country">Country / Region&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><select name="billing_country" id="billing_country" class="country_to_state country_select " autocomplete="country" data-placeholder="Select a country / region&hellip;" data-label="Country / Region"><option value="">Select a country / region&hellip;</option><option value="AF" >Afghanistan</option><option value="AX" >Åland Islands</option><option value="AL" >Albania</option><option value="DZ" >Algeria</option><option value="AS" >American Samoa</option><option value="AD" >Andorra</option><option value="AO" >Angola</option><option value="AI" >Anguilla</option><option value="AQ" >Antarctica</option><option value="AG" >Antigua and Barbuda</option><option value="AR" >Argentina</option><option value="AM" >Armenia</option><option value="AW" >Aruba</option><option value="AU" >Australia</option><option value="AT" >Austria</option><option value="AZ" >Azerbaijan</option><option value="BS" >Bahamas</option><option value="BH" >Bahrain</option><option value="BD" >Bangladesh</option><option value="BB" >Barbados</option><option value="BY" >Belarus</option><option value="PW" >Belau</option><option value="BE" >Belgium</option><option value="BZ" >Belize</option><option value="BJ" >Benin</option><option value="BM" >Bermuda</option><option value="BT" >Bhutan</option><option value="BO" >Bolivia</option><option value="BQ" >Bonaire, Saint Eustatius and Saba</option><option value="BA" >Bosnia and Herzegovina</option><option value="BW" >Botswana</option><option value="BV" >Bouvet Island</option><option value="BR" >Brazil</option><option value="IO" >British Indian Ocean Territory</option><option value="BN" >Brunei</option><option value="BG" >Bulgaria</option><option value="BF" >Burkina Faso</option><option value="BI" >Burundi</option><option value="KH" >Cambodia</option><option value="CM" >Cameroon</option><option value="CA" >Canada</option><option value="CV" >Cape Verde</option><option value="KY" >Cayman Islands</option><option value="CF" >Central African Republic</option><option value="TD" >Chad</option><option value="CL" >Chile</option><option value="CN" >China</option><option value="CX" >Christmas Island</option><option value="CC" >Cocos (Keeling) Islands</option><option value="CO" >Colombia</option><option value="KM" >Comoros</option><option value="CG" >Congo (Brazzaville)</option><option value="CD" >Congo (Kinshasa)</option><option value="CK" >Cook Islands</option><option value="CR" >Costa Rica</option><option value="HR" >Croatia</option><option value="CU" >Cuba</option><option value="CW" >Cura&ccedil;ao</option><option value="CY" >Cyprus</option><option value="CZ" >Czech Republic</option><option value="DK" >Denmark</option><option value="DJ" >Djibouti</option><option value="DM" >Dominica</option><option value="DO" >Dominican Republic</option><option value="EC" >Ecuador</option><option value="EG" >Egypt</option><option value="SV" >El Salvador</option><option value="GQ" >Equatorial Guinea</option><option value="ER" >Eritrea</option><option value="EE" >Estonia</option><option value="SZ" >Eswatini</option><option value="ET" >Ethiopia</option><option value="FK" >Falkland Islands</option><option value="FO" >Faroe Islands</option><option value="FJ" >Fiji</option><option value="FI" >Finland</option><option value="FR" >France</option><option value="GF" >French Guiana</option><option value="PF" >French Polynesia</option><option value="TF" >French Southern Territories</option><option value="GA" >Gabon</option><option value="GM" >Gambia</option><option value="GE" >Georgia</option><option value="DE" >Germany</option><option value="GH" >Ghana</option><option value="GI" >Gibraltar</option><option value="GR" >Greece</option><option value="GL" >Greenland</option><option value="GD" >Grenada</option><option value="GP" >Guadeloupe</option><option value="GU" >Guam</option><option value="GT" >Guatemala</option><option value="GG" >Guernsey</option><option value="GN" >Guinea</option><option value="GW" >Guinea-Bissau</option><option value="GY" >Guyana</option><option value="HT" >Haiti</option><option value="HM" >Heard Island and McDonald Islands</option><option value="HN" >Honduras</option><option value="HK" >Hong Kong</option><option value="HU" >Hungary</option><option value="IS" >Iceland</option><option value="IN" >India</option><option value="ID" >Indonesia</option><option value="IR" >Iran</option><option value="IQ" >Iraq</option><option value="IE" >Ireland</option><option value="IM" >Isle of Man</option><option value="IL" >Israel</option><option value="IT" >Italy</option><option value="CI" >Ivory Coast</option><option value="JM" >Jamaica</option><option value="JP" >Japan</option><option value="JE" >Jersey</option><option value="JO" >Jordan</option><option value="KZ" >Kazakhstan</option><option value="KE" >Kenya</option><option value="KI" >Kiribati</option><option value="KW" >Kuwait</option><option value="KG" >Kyrgyzstan</option><option value="LA" >Laos</option><option value="LV" >Latvia</option><option value="LB" >Lebanon</option><option value="LS" >Lesotho</option><option value="LR" >Liberia</option><option value="LY" >Libya</option><option value="LI" >Liechtenstein</option><option value="LT" >Lithuania</option><option value="LU" >Luxembourg</option><option value="MO" >Macao</option><option value="MG" >Madagascar</option><option value="MW" >Malawi</option><option value="MY" >Malaysia</option><option value="MV" >Maldives</option><option value="ML" >Mali</option><option value="MT" >Malta</option><option value="MH" >Marshall Islands</option><option value="MQ" >Martinique</option><option value="MR" >Mauritania</option><option value="MU" >Mauritius</option><option value="YT" >Mayotte</option><option value="MX" >Mexico</option><option value="FM" >Micronesia</option><option value="MD" >Moldova</option><option value="MC" >Monaco</option><option value="MN" >Mongolia</option><option value="ME" >Montenegro</option><option value="MS" >Montserrat</option><option value="MA" >Morocco</option><option value="MZ" >Mozambique</option><option value="MM" >Myanmar</option><option value="NA" >Namibia</option><option value="NR" >Nauru</option><option value="NP" >Nepal</option><option value="NL" >Netherlands</option><option value="NC" >New Caledonia</option><option value="NZ" >New Zealand</option><option value="NI" >Nicaragua</option><option value="NE" >Niger</option><option value="NG" >Nigeria</option><option value="NU" >Niue</option><option value="NF" >Norfolk Island</option><option value="KP" >North Korea</option><option value="MK" >North Macedonia</option><option value="MP" >Northern Mariana Islands</option><option value="NO" >Norway</option><option value="OM" >Oman</option><option value="PK" >Pakistan</option><option value="PS" >Palestinian Territory</option><option value="PA" >Panama</option><option value="PG" >Papua New Guinea</option><option value="PY" >Paraguay</option><option value="PE" >Peru</option><option value="PH" >Philippines</option><option value="PN" >Pitcairn</option><option value="PL" >Poland</option><option value="PT" >Portugal</option><option value="PR" >Puerto Rico</option><option value="QA" >Qatar</option><option value="RE" >Reunion</option><option value="RO" >Romania</option><option value="RU" >Russia</option><option value="RW" >Rwanda</option><option value="BL" >Saint Barth&eacute;lemy</option><option value="SH" >Saint Helena</option><option value="KN" >Saint Kitts and Nevis</option><option value="LC" >Saint Lucia</option><option value="SX" >Saint Martin (Dutch part)</option><option value="MF" >Saint Martin (French part)</option><option value="PM" >Saint Pierre and Miquelon</option><option value="VC" >Saint Vincent and the Grenadines</option><option value="WS" >Samoa</option><option value="SM" >San Marino</option><option value="ST" >S&atilde;o Tom&eacute; and Pr&iacute;ncipe</option><option value="SA" >Saudi Arabia</option><option value="SN" >Senegal</option><option value="RS" >Serbia</option><option value="SC" >Seychelles</option><option value="SL" >Sierra Leone</option><option value="SG" >Singapore</option><option value="SK" >Slovakia</option><option value="SI" >Slovenia</option><option value="SB" >Solomon Islands</option><option value="SO" >Somalia</option><option value="ZA" >South Africa</option><option value="GS" >South Georgia/Sandwich Islands</option><option value="KR" >South Korea</option><option value="SS" >South Sudan</option><option value="ES" >Spain</option><option value="LK" >Sri Lanka</option><option value="SD" >Sudan</option><option value="SR" >Suriname</option><option value="SJ" >Svalbard and Jan Mayen</option><option value="SE" >Sweden</option><option value="CH" >Switzerland</option><option value="SY" >Syria</option><option value="TW" >Taiwan</option><option value="TJ" >Tajikistan</option><option value="TZ" >Tanzania</option><option value="TH" >Thailand</option><option value="TL" >Timor-Leste</option><option value="TG" >Togo</option><option value="TK" >Tokelau</option><option value="TO" >Tonga</option><option value="TT" >Trinidad and Tobago</option><option value="TN" >Tunisia</option><option value="TR" >Turkey</option><option value="TM" >Turkmenistan</option><option value="TC" >Turks and Caicos Islands</option><option value="TV" >Tuvalu</option><option value="UG" >Uganda</option><option value="UA" >Ukraine</option><option value="AE" >United Arab Emirates</option><option value="GB" >United Kingdom (UK)</option><option value="US"  selected="selected">United States (US)</option><option value="UM" >United States (US) Minor Outlying Islands</option><option value="UY" >Uruguay</option><option value="UZ" >Uzbekistan</option><option value="VU" >Vanuatu</option><option value="VA" >Vatican</option><option value="VE" >Venezuela</option><option value="VN" >Vietnam</option><option value="VG" >Virgin Islands (British)</option><option value="VI" >Virgin Islands (US)</option><option value="WF" >Wallis and Futuna</option><option value="EH" >Western Sahara</option><option value="YE" >Yemen</option><option value="ZM" >Zambia</option><option value="ZW" >Zimbabwe</option></select><noscript><button type="submit" name="woocommerce_checkout_update_totals" value="Update country / region">Update country / region</button></noscript></span></p><p class="form-row form-row-wide address-field validate-required" id="billing_address_1_field" data-priority="50"><label for="billing_address_1">Street address&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="billing_address_1" id="billing_address_1" placeholder="House number and street name"  autocomplete="address-line1" /></span></p><p class="form-row form-row-wide address-field" id="billing_address_2_field" data-priority="60"><label for="billing_address_2" class="screen-reader-text">Apartment, suite, unit, etc.&nbsp;<span class="optional">(optional)</span></label><span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit, etc. (optional)"  autocomplete="address-line2" /></span></p><p class="form-row form-row-wide address-field validate-required" id="billing_city_field" data-priority="70"><label for="billing_city">Town / City&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="billing_city" id="billing_city" autocomplete="address-level2" /></span></p><p class="form-row form-row-wide address-field validate-required validate-state" id="billing_state_field" data-priority="80"><label for="billing_state">State&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><select name="billing_state" id="billing_state" class="state_select " autocomplete="address-level1" data-placeholder="Select an option&hellip;"  data-input-classes="" data-label="State"> <option value="">Select an option&hellip;</option><option value="AL" >Alabama</option><option value="AK" >Alaska</option><option value="AZ" >Arizona</option><option value="AR" >Arkansas</option><option value="CA" >California</option><option value="CO" >Colorado</option><option value="CT" >Connecticut</option><option value="DE" >Delaware</option><option value="DC" >District Of Columbia</option><option value="FL" >Florida</option><option value="GA" >Georgia</option><option value="HI" >Hawaii</option><option value="ID" >Idaho</option><option value="IL" >Illinois</option><option value="IN" >Indiana</option><option value="IA" >Iowa</option><option value="KS" >Kansas</option><option value="KY" >Kentucky</option><option value="LA" >Louisiana</option><option value="ME" >Maine</option><option value="MD" >Maryland</option><option value="MA" >Massachusetts</option><option value="MI" >Michigan</option><option value="MN" >Minnesota</option><option value="MS" >Mississippi</option><option value="MO" >Missouri</option><option value="MT" >Montana</option><option value="NE" >Nebraska</option><option value="NV" >Nevada</option><option value="NH" >New Hampshire</option><option value="NJ" >New Jersey</option><option value="NM" >New Mexico</option><option value="NY" selected="selected">New York</option><option value="NC" >North Carolina</option><option value="ND" >North Dakota</option><option value="OH" >Ohio</option><option value="OK" >Oklahoma</option><option value="OR" >Oregon</option><option value="PA" >Pennsylvania</option><option value="RI" >Rhode Island</option><option value="SC" >South Carolina</option><option value="SD" >South Dakota</option><option value="TN" >Tennessee</option><option value="TX" >Texas</option><option value="UT" >Utah</option><option value="VT" >Vermont</option><option value="VA" >Virginia</option><option value="WA" >Washington</option><option value="WV" >West Virginia</option><option value="WI" >Wisconsin</option><option value="WY" >Wyoming</option><option value="AA" >Armed Forces (AA)</option><option value="AE" >Armed Forces (AE)</option><option value="AP" >Armed Forces (AP)</option></select></span></p><p class="form-row form-row-wide address-field validate-required validate-postcode" id="billing_postcode_field" data-priority="90"><label for="billing_postcode">ZIP Code&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="billing_postcode" id="billing_postcode" autocomplete="postal-code" /></span></p><p class="form-row form-row-wide validate-required validate-phone" id="billing_phone_field" data-priority="100"><label for="billing_phone">Phone&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="tel" class="input-text " name="billing_phone" id="billing_phone" autocomplete="tel" /></span></p><p class="form-row form-row-wide validate-required validate-email" id="billing_email_field" data-priority="110"><label for="billing_email">Email address&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="email" class="input-text " name="billing_email" id="billing_email" value="dev-email@flywheel.local" autocomplete="email username" /></span></p>	</div></div>';
					break;
				case 'woocommerce_checkout_shipping':
					$content = '<div class="woocommerce-additional-fields"><h3>Additional information</h3><div class="woocommerce-additional-fields__field-wrapper"><p class="form-row notes" id="order_comments_field" data-priority=""><label for="order_comments">Order notes&nbsp;<span class="optional">(optional)</span></label><span class="woocommerce-input-wrapper"><textarea name="order_comments" class="input-text" id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea></span></p></div></div>';
					break;
				case 'woocommerce_checkout_order_review':
					$content = '<div><h3 class="order_review_heading">Your order</h3><div id="order_review" class="woocommerce-checkout-review-order"><table class="shop_table woocommerce-checkout-review-order-table"><tbody><tr class="cart_item"><td class="product-name"><div class="product-info">Album&nbsp;<strong class="product-quantity">× 1</strong></div></td><td class="product-total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>15.00</bdi></span></td></tr><tr class="cart_item"><td class="product-name"><div class="product-info">Belt&nbsp;<strong class="product-quantity">× 1</strong></div></td><td class="product-total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>55.00</bdi></span></td></tr><tr class="cart_item"><td class="product-name"><div class="product-info">Hoodie with Logo&nbsp;<strong class="product-quantity">× 1</strong></div></td><td class="product-total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>45.00</bdi></span></td></tr></tbody><tfoot><tr class="cart-subtotal"><th>Subtotal</th><td><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>115.00</bdi></span></td></tr><tr class="order-total"><th>Total</th><td><strong><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>115.00</bdi></span></strong></td></tr></tfoot></table></div></div>';
					break;
				case 'woocommerce_checkout_payment':
					$content = '<div id="order_review" class="woocommerce-checkout-review-order"><h3 class="order_review_heading">Payment</h3><div id="payment" class="woocommerce-checkout-payment"><ul class="wc_payment_methods payment_methods methods"><li class="wc_payment_method payment_method_cod"><input id="payment_method_cod" type="radio" class="input-radio" name="payment_method" value="cod" checked="checked" data-order_button_text="" style="display:none"><label for="payment_method_cod">Cash on delivery</label><div class="payment_box payment_method_cod"><p>Pay with cash upon delivery.</p></div></li></ul><div class="form-row place-order"><noscript>Since your browser does not support JavaScript, or it is disabled, please ensure you click the &lt;em&gt;Update Totals&lt;/em&gt; button before placing your order. You may be charged more than the amount stated above if you fail to do so.<br><input type="submit" class="button alt wp-element-button" name="woocommerce_checkout_update_totals" value="Update totals"></noscript><div class="woocommerce-terms-and-conditions-wrapper"><div class="woocommerce-privacy-policy-text"><p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our<a href="#" class="woocommerce-privacy-policy-link" target="_blank">privacy policy</a>.</p></div></div><button type="submit" class="button alt wp-element-button" name="woocommerce_checkout_place_order" id="place_order" value="Place order" data-value="Place order">Place order</button><input type="hidden" id="woocommerce-process-checkout-nonce" name="woocommerce-process-checkout-nonce" value=""><input type="hidden" name="_wp_http_referer" value=""></div></div></div>';
					break;
				case 'woocommerce_checkout_before_order_review':
					$content = 'Before Order Review [Hook]';
					break;
				case 'woocommerce_checkout_after_order_review':
					$content = 'After Order Review [Hook]';
					break;
				case 'woocommerce_checkout_after_customer_details':
					$content = 'After Customer Details [Hook]';
					break;
			}

			echo $content;

			echo '</form></div>';

		} else {

			switch( $this->get_settings_for_display( 'param' ) ){
				case 'woocommerce_checkout_billing':
					do_action( 'woocommerce_checkout_billing' );
					break;
				case 'woocommerce_checkout_shipping':
					do_action( 'woocommerce_checkout_shipping' );
					break;
				case 'woocommerce_checkout_order_review':
					echo '<div id="order_review" class="woocommerce-checkout-review-order">';
					printf( '<h3 class="order_review_heading">%s</h3>', esc_html( 'Your order', 'woocommerce' ) );
					woocommerce_order_review();
					echo '</div>';
					break;
				case 'woocommerce_checkout_payment':
					echo '<div id="order_review" class="woocommerce-checkout-review-order">';
					printf( '<h3 class="order_review_heading">%s</h3>', esc_html( 'Payment', 'woocommerce' ) );
					woocommerce_checkout_payment();
					echo '</div>';
					break;
				case 'woocommerce_checkout_before_order_review':
					do_action( 'woocommerce_checkout_before_order_review' );
					break;
				case 'woocommerce_checkout_after_order_review':
					do_action( 'woocommerce_checkout_after_order_review' );
					break;
				case 'woocommerce_checkout_after_customer_details':
					do_action( 'woocommerce_checkout_after_customer_details' );
					break;
			}

		}

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Woo_Checkout_Params() );