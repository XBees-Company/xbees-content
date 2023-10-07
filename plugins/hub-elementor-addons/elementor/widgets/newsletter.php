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
class LD_Newsletter extends Widget_Base {

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
		return 'ld_newsletter';
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
		return __( 'Liquid Newsletter', 'hub-elementor-addons' );
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
		return 'eicon-mail lqd-element';
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
		return [ 'newsletter', 'form' ];
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
			return [ 'liquid-mailchimp-form' ];
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
			'list_id',
			[
				'label' => __( 'List ID', 'hub-elementor-addons' ),
				'description' => __( 'Select the list from mailchimp to add emails. The API Key of the Mailchimp should be added in Theme Options', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $this->get_mailchimp_lists(),
			]
		);

		$this->add_control(
			'tags',
			[
				'label' => esc_html__( 'Tags', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( '', 'hub-elementor-addons' ),
				'placeholder' => esc_html__( 'Newsletter,Footer', 'hub-elementor-addons' ),
				'description' => esc_html__( 'Tags are labels you create to help organize your contacts. You can define multiple tags with comma(,)', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'use_opt_in',
			[
				'label' => __( 'Use Opt-in?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'enable_name_field',
			[
				'label' => __( 'Name field?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'ld-sf--has-name',
				'default' => '',
			]
		);

		$this->add_control(
			'show_inline',
			[
				'label' => __( 'Inline?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'ld-sf--inputs-inline',
				'default' => '',
				'condition' => [
					'enable_name_field' => 'ld-sf--has-name'
				]
 			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ld-sf--input-bordered',
				'options' => [
					'ld-sf--input-underlined' => __( 'Underlined', 'hub-elementor-addons' ),
					'ld-sf--input-solid' => __( 'Solid', 'hub-elementor-addons' ),
					'ld-sf--input-bordered' => __( 'Bordered', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'placeholder_text',
			[
				'label' => __( 'Placehoder Email', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Your email to start', 'hub-elementor-addons' ),
				'placeholder' => __( 'placeholder text for email field', 'hub-elementor-addons' ),
			]
		);

		$this->add_control(
			'placeholder_nametext',
			[
				'label' => __( 'Placehoder Name', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'placeholder text for name field', 'hub-elementor-addons' ),
				'condition' => [
					'enable_name_field' => 'ld-sf--has-name'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'label' => __( 'Input Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .ld-sf input',
			]
		);

		$this->add_control(
			'inputs_size',
			[
				'label' => __( 'Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ld-sf--size-md',
				'options' => [
					'ld-sf--size-md' => __( 'Default', 'hub-elementor-addons' ),
					'ld-sf--size-xs' => __( 'xSmall', 'hub-elementor-addons' ),
					'ld-sf--size-sm' => __( 'Small', 'hub-elementor-addons' ),
					'ld-sf--size-md' => __( 'Medium', 'hub-elementor-addons' ),
					'ld-sf--size-lg' => __( 'Large', 'hub-elementor-addons' ),
					'ld-sf--size-xl' => __( 'xLarge', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'inputs_radius',
			[
				'label' => __( 'Border radius', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ld-sf--sharp',
				'options' => [
					'ld-sf--sharp' => __( 'Sharp', 'hub-elementor-addons' ),
					'ld-sf--semi-round' => __( 'Semi Round', 'hub-elementor-addons' ),
					'ld-sf--round' => __( 'Round', 'hub-elementor-addons' ),
					'ld-sf--circle' => __( 'Circle', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'inputs_border',
			[
				'label' => __( 'Border thickness', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ld-sf--border-thin',
				'options' => [
					'ld-sf--border-thin' => __( 'Thin', 'hub-elementor-addons' ),
					'ld-sf--border-thick' => __( 'Thick', 'hub-elementor-addons' ),
					'ld-sf--border-thicker' => __( 'Thicker', 'hub-elementor-addons' ),
					'ld-sf--border-none' => __( 'None', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'inputs_shadow',
			[
				'label' => __( 'Other', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'ld-sf--input-shadow' => __( 'Shadow', 'hub-elementor-addons' ),
					'ld-sf--input-inner-shadow' => __( 'Inner Shadow', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_responsive_control(
			'inputs_margin',
			[
				'label' => __( 'Inputs spacing', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 20,
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} .ld-sf p' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();


		// Button Section
		$this->start_controls_section(
			'button_section',
			[
				'label' => __( 'Submit Button', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'btn_style',
			[
				'label' => __( 'Submit Button Style', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ld-sf--button-solid',
				'options' => [
					'ld-sf--button-solid' => __( 'Solid', 'hub-elementor-addons' ),
					'ld-sf--button-bordered' => __( 'Bordered', 'hub-elementor-addons' ),
					'ld-sf--button-underlined' => __( 'Underlined', 'hub-elementor-addons' ),
					'ld-sf--button-naked' => __( 'Plain', 'hub-elementor-addons' ),
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Button Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .ld-sf .ld_sf_submit',
			]
		);

		$this->add_control(
			'btn_state',
			[
				'label' => __( 'Button State', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ld-sf--button-show',
				'options' => [
					'ld-sf--button-show' => __( 'Display', 'hub-elementor-addons' ),
					'ld-sf--button-hidden' => __( 'Hidden', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'btn_display',
			[
				'label' => __( 'Button Display', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'label',
				'options' => [
					'label' => __( 'Button label', 'hub-elementor-addons' ),
					'icon' => __( 'Icon', 'hub-elementor-addons' ),
					'label_icon' => __( 'Button label and icon', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'btn_label',
			[
				'label' => __( 'Button label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __('Subscribe', 'hub-elementor-addons'),
				'placeholder' => __( 'Type your text here', 'hub-elementor-addons' ),
				'condition' => [
					'btn_display' => [
						'label', 'label_icon'
					]
				]
			]
		);

		$this->add_control(
			'btn_position',
			[
				'label' => __( 'Button Position', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'ld-sf--button-inside' => __( 'In input', 'hub-elementor-addons' ),
					'ld-sf--button-inline' => __( 'Near input', 'hub-elementor-addons' ),
					'ld-sf--button-block' => __( 'Under input', 'hub-elementor-addons' ),
				],
				'condition' => [
					'btn_state!' => [
						'subscribe-minimal'
					]
				]
			]
		);

		$this->add_control(
			'btn_eql',
			[
				'label' => __( 'Button Equal Width and Height', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'ld-sf--button-eql',
				'default' => '',
				'condition' => [
					'btn_style' => [
						'ld-sf--button-solid',
						'ld-sf--button-bordered'
					]
				]
			]
		);

		$this->add_control(
			'btn_padding',
			[
				'label' => __( 'Button padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'ex. 20px', 'hub-elementor-addons' ),
				'condition' => [
					'btn_position' => [
						'ld-sf--button-inline'
					]
				]
			]
		);

		$this->add_control(
			'btn_shrink',
			[
				'label' => __( 'Button Shrink', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'No', 'hub-elementor-addons' ),
					'button-shrinked' => __( 'Yes', 'hub-elementor-addons' ),
				],
				'condition' => [
					'btn_position' => [
						'ld-sf--button-inside'
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_shadow',
				'label' => __( 'Button Shadow', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} [type=submit]',
			]
		);

		$this->add_control(
			'i_add_icon',
			[
				'label' => __( 'Add Icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'true',
				'default' => 'false',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'hub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => [
					'i_add_icon' => 'true',
				],
			]
		);

		$this->add_control(
			'i_size',
			[
				'label' => __( 'Icon Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors' => [
					'{{WRAPPER}} .submit-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'i_add_icon' => 'true',
				],
			]
		);
		$this->end_controls_section();
		
		// Inputs Section
		$this->start_controls_section(
			'input_style_section',
			[
				'label' => __( 'Inputs', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'txt_color',
			[
				'label' => __( 'Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld_sf_response h4' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ld-sf input[type="email"], .ld-sf input[type="text"]' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sf input[type="email"], {{WRAPPER}} .ld-sf input[type="text"]' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'brd_color',
			[
				'label' => __( 'Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sf input[type="email"], .ld-sf input[type="text"]' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Inputs Focus Section
		$this->start_controls_section(
			'input_focus_style_section',
			[
				'label' => __( 'Inputs Focus', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'txt_f_color',
			[
				'label' => __( 'Text Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sf input[type="email"]:focus, .ld-sf input[type="text"]:focus' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'bg_f_color',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sf input[type="email"]:focus, .ld-sf input[type="text"]:focus' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'brd_f_color',
			[
				'label' => __( 'Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sf input[type="email"]:focus, .ld-sf input[type="text"]:focus' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Submit Section
		$this->start_controls_section(
			'submit_style_section',
			[
				'label' => __( 'Submit Button', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'btn_txt_color',
			[
				'label' => __( 'Label Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sf button.ld_sf_submit' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_bg_color',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sf button.ld_sf_submit' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_brd_color',
			[
				'label' => __( 'Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sf button.ld_sf_submit' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Hover Submit Section
		$this->start_controls_section(
			'hover_submit_style_section',
			[
				'label' => __( 'Hover Submit Button', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_btn_txt_color',
			[
				'label' => __( 'Label Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sf button.ld_sf_submit:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'hover_btn_bg_color',
			[
				'label' => __( 'Background Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sf button.ld_sf_submit:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'hover_btn_brd_color',
			[
				'label' => __( 'Border Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sf button.ld_sf_submit:hover' => 'border-color: {{VALUE}}',
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

		$this->add_render_attribute(
			'wrapper',
			[
				'id' => 'lqd-newsletter-' . $this->get_id(),
				'class' => [
					'ld-sf',
					'pos-rel',
					$settings['style'],
					$settings['btn_style'], 
					$settings['btn_eql'], 
					$settings['show_inline'],
					$settings['inputs_size'], 
					$settings['inputs_radius'], 
					$settings['inputs_border'] !== 'ld-sf--border-none' ? 'ld-sf--inputs-has-border' : '', 
					$settings['inputs_border'], 
					$settings['inputs_shadow'], 
					$settings['btn_state'], 
					$settings['btn_position'],
					$settings['btn_shrink'],
					$settings['enable_name_field'], 
				],
			]
		);

		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<form class="ld_subscribe_form ld_sf_form pos-rel" method="post" action="<?php echo the_permalink() ?>">
				<p class="ld_sf_paragraph pos-rel">
					<?php if( $settings['enable_name_field'] ) { ?>
						<input type="text" class="ld_sf_text ld_sf_name d-block w-100 border-radius-2" name="fname" placeholder="<?php echo esc_attr( $settings['placeholder_nametext'] ) ?>" />
					<?php } ?>
					<input type="email" class="ld_sf_text ld_sf_email d-block w-100 border-radius-2" name="email" placeholder="<?php echo esc_attr( $settings['placeholder_text'] ) ?>" />
				</p>
				<?php $this->get_submit_button(); ?>
				<input type="hidden" name="use_opt_in" value="<?php echo esc_attr( $settings['use_opt_in'] ); ?>">
				<input type="hidden" class="ld_sf_list_id" name="list_id" value="<?php echo $settings['list_id'] ?>">
				<?php if ( !empty( $settings['tags'] ) ) : ?>
				<input type="hidden" class="ld_sf_list_tags" name="tags" value="<?php echo esc_attr( $settings['tags'] ); ?>">
				<?php endif; ?>
				<?php wp_nonce_field( 'ld-mailchimp-form' ); ?>
			</form>
			<div class="ld_sf_response"></div>
		</div>	

		<?php
		
	}

	protected function get_submit_button(){
		
		$settings = $this->get_settings_for_display();

		$icon = isset($settings['icon']['value']) ? $settings['icon']['value'] : '';

		$submit_txt_class = 'submit-text';
		$icon = !empty ( $icon ) && 'true' === $settings['i_add_icon'] ? $icon : 'fa fa-long-arrow-right';
		$icon_html  = ' <span class="submit-icon"><i class="' . $icon . '"></i></span>';
		
		$btn_display = $settings['btn_display'];
		if( 'label' === $btn_display ) {
			$icon_html = '';	
		}
		elseif( 'icon' === $btn_display ) {
			$submit_txt_class .= ' visible-xs';	
			$icon_html  = '<span class="submit-icon"><i class="' . $icon . '"></i></span>';
		}
		
		$label = !empty( $settings['btn_label'] ) ? '<span class="' . esc_attr( $submit_txt_class ) . '">' . esc_html( $settings['btn_label'] ) . '</span>' : '';
		
		$label_html = $label . $icon_html;

		printf( '<button type="submit" class="ld_sf_submit d-inline-flex align-items-center justify-content-center m-0 border-radius-2 pos-rel">%s <span class="ld-sf-spinner border-radius-circle pos-abs overflow-hidden"><span class="d-block lqd-overlay border-radius-circle">Sending </span></span></button>', $label_html );
		
	}

	/**
	 * Get MailChimp Lists IDs
	 * @return array
	 */
	public function get_mailchimp_lists() {
		
		if( !class_exists( 'liquid_MailChimp' ) ) {
			return array();
		}
		$api_key = liquid_helper()->get_theme_option( 'mailchimp-api-key' );
		if( empty( $api_key ) || strpos( $api_key, '-' ) === false ) {
			return array();
		}

		$MailChimp = new \liquid_MailChimp( $api_key );
		
		$lists = $MailChimp->get( 'lists' );
		$items = array( '0' => 'Select List' );
		if ( is_array( $lists ) && !is_wp_error( $lists ) ) {
			foreach ( $lists as $list ) {
				if( is_array( $list ) ) {
					foreach( $list as $l ) {
						if( isset( $l['name'] ) && isset( $l['id'] ) ) {
							$items[ strval($l['id']) ] = $l['name'];	
						}
					}
				} 
			}
		}

		return $items;
	}


}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Newsletter() );