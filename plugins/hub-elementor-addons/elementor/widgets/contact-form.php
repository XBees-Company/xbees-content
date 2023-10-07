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
class LD_Contact_Form_ extends Widget_Base {

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
		return 'ld_cf722';
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
		return __( 'Liquid Contact Form 7', 'elementor' );
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
		return 'eicon-form-horizontal lqd-element';
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
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'from', 'input', 'contact' ];
	}

    
    public function ld_contact_forms(){
        $formlist = array();
        $forms_args = array( 'posts_per_page' => -1, 'post_type'=> 'wpcf7_contact_form' );
        $forms = get_posts( $forms_args );
        if( $forms ){
            foreach ( $forms as $form ){
                $formlist[$form->ID] = $form->post_title;
            }
        }else{
            $formlist['0'] = __('Form not found', 'hub-elementor-addons');
        }
        return $formlist;
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

        // Contact Form Sectio
		$this->start_controls_section(
			'contactform_section',
			array(
				'label' => __( 'Contact From', 'hub-elementor-addons' ),
			)
		);

        $this->add_control(
			'form_id',
			[
				'label' => __( 'Select contact form', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => array_keys($this->ld_contact_forms())[0],
				'options' => $this->ld_contact_forms(),
			]
		);
		$this->end_controls_section();

        // Contact Form Sectio
		$this->start_controls_section(
			'input_section',
			array(
				'label' => __( 'Inputs', 'hub-elementor-addons' ),
			)
		);

        $this->add_control(
			'shape',
			[
				'label' => __( 'Input Shape', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'lqd-contact-form-inputs-underlined' => __( 'Underlined', 'hub-elementor-addons' ),
					'lqd-contact-form-inputs-filled' => __( 'Filled', 'hub-elementor-addons' ),
				],
			]
		);

        $this->add_control(
			'size',
			[
				'label' => __( 'Input Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'lqd-contact-form-inputs-sm' => __( 'Small', 'hub-elementor-addons' ),
					'lqd-contact-form-inputs-md' => __( 'Medium', 'hub-elementor-addons' ),
					'lqd-contact-form-inputs-lg' => __( 'Large', 'hub-elementor-addons' ),
				],
			]
		);

        $this->add_control(
			'roundness',
			[
				'label' => __( 'Input Roundness', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'lqd-contact-form-inputs-round' => __( 'Round', 'hub-elementor-addons' ),
					'lqd-contact-form-inputs-circle' => __( 'Circle', 'hub-elementor-addons' ),
				],
			]
		);

        $this->add_control(
			'thickness',
			[
				'label' => __( 'Input Border Thickness', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'lqd-contact-form-inputs-border-thick' => __( 'Thick - 2px', 'hub-elementor-addons' ),
					'lqd-contact-form-inputs-border-thicker' => __( 'Thicker - 3px', 'hub-elementor-addons' ),
					'lqd-contact-form-inputs-border-none' => __( 'None - 0px', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_responsive_control(
			'input_margin',
			[
				'label' => __( 'Margin', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-contact-form' => '--inputs-margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; --input-margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

        // Submit Button Section
		$this->start_controls_section(
			'submit_button_section',
			array(
				'label' => __( 'Submit Button', 'hub-elementor-addons' ),
			)
		);
        
        $this->add_control(
			'btn_shape',
			[
				'label' => __( 'Button Shape', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'lqd-contact-form-button-underlined' => __( 'Underlined', 'hub-elementor-addons' ),
					'lqd-contact-form-button-filled' => __( 'Filled', 'hub-elementor-addons' ),
				],
			]
		);

        $this->add_control(
			'btn_size',
			[
				'label' => __( 'Button Size', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'lqd-contact-form-button-sm' => __( 'Small', 'hub-elementor-addons' ),
					'lqd-contact-form-button-md' => __( 'Medium', 'hub-elementor-addons' ),
					'lqd-contact-form-button-lg' => __( 'Large', 'hub-elementor-addons' ),
				],
			]
		);

        $this->add_control(
			'btn_width',
			[
				'label' => __( 'Button Width', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'lqd-contact-form-button-block' => __( 'Fullwidth', 'hub-elementor-addons' ),
				],
			]
		);

        $this->add_control(
			'btn_roundness',
			[
				'label' => __( 'Button Roundness', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'lqd-contact-form-button-round' => __( 'Round', 'hub-elementor-addons' ),
					'lqd-contact-form-button-circle' => __( 'Circle', 'hub-elementor-addons' ),
				],
			]
		);

        $this->add_control(
			'btn_thickness',
			[
				'label' => __( 'Button Border Thickness', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'hub-elementor-addons' ),
					'lqd-contact-form-button-border-thick' => __( 'Thick - 2px', 'hub-elementor-addons' ),
					'lqd-contact-form-button-border-thicker' => __( 'Thicker - 3px', 'hub-elementor-addons' ),
					'lqd-contact-form-button-border-none' => __( 'None - 0px', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_responsive_control(
			'btn_margin',
			[
				'label' => __( 'Margin', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-contact-form [type=submit]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
			'info_section',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'label' => __( 'Input Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} input:not([type=submit]),{{WRAPPER}} textarea,{{WRAPPER}} .lqd-contact-form select,{{WRAPPER}} .ui-button.ui-selectmenu-button',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Button', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .wpcf7-submit',
			]
		);

            $this->add_control(
                'style_color_heading',
                [
                    'label' => __( 'Colors', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->start_controls_tabs(
                'style_tabs'
            );

            // Normal State
            $this->start_controls_tab(
                'style_normal_tab',
                [
                    'label' => __( 'Normal', 'hub-elementor-addons' ),
                ]
            );

            $this->add_control(
                'lqd_bg_color',
                [
                    'label' => __( 'Background Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input:not([type=submit]), {{WRAPPER}} textarea, {{WRAPPER}} .lqd-contact-form select, {{WRAPPER}} .ui-button.ui-selectmenu-button' => 'background: {{VALUE}}!important',
                    ],
                ]
            );

            $this->add_control(
                'color',
                [
                    'label' => __( 'Text Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input:not([type=submit]), {{WRAPPER}} textarea, {{WRAPPER}} .lqd-contact-form select, {{WRAPPER}} .ui-button.ui-selectmenu-button, {{WRAPPER}} .wpcf7-radio' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'border_color',
                [
                    'label' => __( 'Border Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input:not([type=submit]), {{WRAPPER}} textarea, {{WRAPPER}} .lqd-contact-form select, {{WRAPPER}} .ui-button.ui-selectmenu-button' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'submit_bg_color',
                [
                    'label' => __( 'Button Background Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input[type=submit]' => 'background: {{VALUE}}',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'submit_color',
                [
                    'label' => __( 'Button Label Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input[type=submit]' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'submit_border_color',
                [
                    'label' => __( 'Button Border Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input[type=submit]' => 'border-color: {{VALUE}}',
                    ],
                ]
            );


            $this->end_controls_tab();

            // Hover State
            $this->start_controls_tab(
                'style_hover_tab',
                [
                    'label' => __( 'Hover', 'hub-elementor-addons' ),
                ]
            );

            $this->add_control(
                'hbg_color',
                [
                    'label' => __( 'Focus Background Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input:not([type=submit]):focus, textarea:focus, .lqd-contact-form select:focus, .ui-button.ui-selectmenu-button:focus' => 'background: {{VALUE}}!important',
                    ],
                ]
            );

            $this->add_control(
                'h_color',
                [
                    'label' => __( 'Focus Text Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input:not([type=submit]):focus, textarea:focus, .lqd-contact-form select:focus, .ui-button.ui-selectmenu-button:focus' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'hover_border_color',
                [
                    'label' => __( 'Focus Border Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input:not([type=submit]):focus, textarea:focus, .lqd-contact-form select:focus, .ui-button.ui-selectmenu-button:focus' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'submit_hbg_color',
                [
                    'label' => __( 'Button Hover Background Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input[type=submit]:hover' => 'background: {{VALUE}}',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'submit_h_color',
                [
                    'label' => __( 'Button Hover Label Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input[type=submit]:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'submit_hover_border_color',
                [
                    'label' => __( 'Button Hover Border Color', 'hub-elementor-addons' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} input[type=submit]:hover' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->end_controls_tab();
            $this->end_controls_tabs();     

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

		$id = $settings['form_id'];

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => [ 
					'lqd-contact-form',
					$settings['shape'],
					$settings['thickness'],
					$settings['roundness'],
					$settings['btn_width'],
					$settings['btn_shape'], 
					$settings['btn_size'], 
					$settings['btn_roundness'],
					$settings['btn_thickness'],
					$settings['size']
				],
			]
		);

	?>

	<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
		<?php
			if( $id ==! 0 ){
				echo do_shortcode( '[contact-form-7 id="'. $id .'"]' );
			} else {
				echo sprintf( __( '<strong>There are no contact forms in your site.</strong><br>Go to the <a href="%s" target="_blank">Contact Form</a> to create one.', 'hub-elementor-addons' ), admin_url( '?page=wpcf7' ) );
			}
		?>
	</div>

	<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Contact_Form_() );