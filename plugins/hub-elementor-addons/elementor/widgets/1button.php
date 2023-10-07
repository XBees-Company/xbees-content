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
class LD_Button extends Widget_Base {

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
		return 'ld_button';
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
		return __( 'Liquid Button', 'elementor' );
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
		return 'eicon-button lqd-element';
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
		return [ 'button', 'title', 'text' ];
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

		ld_el_btn($this, ''); // load button

		// Rotate
        $this->start_controls_section(
			'rotate_section',
			array(
				'label' => __( 'Rotate', 'hub-elementor-addons' ),
			)
		);

        $this->add_control(
			'rotate_x',
			[
				'label' => __( 'Button Rotate', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);

        $this->add_control(
			'rotate_x_icon',
			[
				'label' => __( 'Icon Rotate', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn-icon i' => 'transform: rotate({{SIZE}}deg);',
					'{{WRAPPER}} .btn-icon svg' => 'transform: rotate({{SIZE}}deg);',
				],
				'condition' => [
					'i_add_icon' => 'true',
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

		$this->add_inline_editing_attributes( 'title', 'basic' );
		$button = new \LQD_Elementor_Render_Button;
		$button->get_button( $this );

	}

	protected function content_template() {
		?>

			<#

				function getIcon() {

					const iconHTML = elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i' , 'object' );
					const migrated = elementor.helpers.isIconMigrated( settings, 'icon' );

					if ( settings.icon ) {
						if ( settings.icon.library !== 'svg' ) {
							if ( ( migrated || ! settings.icon ) && iconHTML.rendered ) { #>
							{{{ iconHTML.value }}}
							<# } else { #>
								<i class="{{ settings.icon.value }}" aria-hidden="true"></i>
							<# }
						} else if ( settings.icon.library === 'svg' && iconHTML.rendered ) { #>
							{{{ iconHTML.value }}}
						<# }
					}

				};

				const classnames = [
					'btn',
					'elementor-button',
					'ws-nowrap',
					settings.style,
					settings.i_separator,
					settings.hover_txt_effect,
					settings.size,
					settings.style !== 'btn-plain' && settings.style !== 'btn-underlined' ? settings.width : '',

					settings.link_type === 'lightbox' ? 'fresco' : '',

					//Icon classnames
					settings.i_position,
					settings.i_shape,
					settings.i_add_icon === 'true' && settings.i_shape !== '' && settings.i_shape_style !== '' ? settings.i_shape_size : '',
					settings.i_add_icon === 'true' && settings.i_shape !== '' && settings.i_shape_style !== '' ? 'btn-icon-shaped' : '',
					settings.i_shape_style,
					settings.i_shape_bw,
					settings.i_ripple,
					settings.border_w,
					settings.i_add_icon === 'true' && (settings.i_position === 'btn-icon-left' || settings.i_position === 'btn-icon-right') ? settings.i_hover_reveal : '',
					settings.title != '' ? 'btn-has-label' : 'btn-no-label',
				].filter(classname => classname !== '');

				const {link_type} = settings;
				let link = settings?.link?.url ? settings.link.url : '#';
				let linkAttrs = ``;
				let anchorId = settings.anchor_id === '' ? '#' : settings.anchor_id;
				let dataText = settings.title;

				if ( link_type === 'modal_window' || link_type === 'local_scroll' ) {
					link = anchorId;
				}
				if ( link_type === 'local_scroll' || link_type === 'scroll_to_section' ) {
					linkAttrs += ` data-localscroll="true"`;
				}

				if ( link_type === 'modal_window' ) {
					linkAttrs += ` data-lity="${anchorId}"`;
				} else if ( link_type === 'local_scroll' )  {
					linkAttrs += ` data-localscroll="true"`;
					if ( settings.scroll_speed !== '' ) {
						linkAttrs += ` data-localscroll-options='{"scrollSpeed": ${settings.scroll_speed}}'`
					}
				} else if ( link_type === 'scroll_to_section' ) {
					linkAttrs += ` data-localscroll-options='{"scrollBelowSection": true}'`
				}

				const {hover_txt_effect} = settings;
				let hoverEffectAttrs = ``;

				switch( hover_txt_effect ) {
					case 'btn-hover-txt-liquid-x':
						hoverEffectAttrs += `data-split-text="true" data-split-options='{"type": "chars, words"}'`;
					break;

					case 'btn-hover-txt-liquid-x-alt':
						hoverEffectAttrs += `data-split-text="true" data-split-options='{"type": "chars, words"}'`;
					break;

					case 'btn-hover-txt-liquid-y':
						hoverEffectAttrs += `data-split-text="true" data-split-options='{"type": "chars, words"}'`;
					break;

					case 'btn-hover-txt-liquid-y-alt':
						hoverEffectAttrs += `data-split-text="true" data-split-options='{"type": "chars, words"}'`;
					break;

					case 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y':
						if (settings.title_secondary !== '') dataText = settings.title_secondary;
					break;

					default:
						'';
					break;
				}

				const btn_txt_Attrs = {
					'class': [ 'btn-txt', 'elementor-inline-editing'],
					'data-elementor-setting-key': 'title',
					'data-elementor-inline-editing-toolbar': 'basic'
				};
				view.addRenderAttribute( 'btn_txt_Attrsibutes', btn_txt_Attrs);

			#>

			<a
			href="{{ link.trim() }}"
			class="{{ classnames.join(' ') }}"
			data-fresco-caption="{{settings.image_caption}}"
			{{{linkAttrs}}}
			{{{hoverEffectAttrs}}}
			>
				<span {{{ view.getRenderAttributeString('btn_txt_Attrsibutes') }}} data-text="{{{dataText}}}">{{{settings.title}}}</span>
				<# if ( settings.i_add_icon === 'true' ) { #>
					<span class="btn-icon">
						<# getIcon(); #>
					</span>
					<# if ( settings.i_hover_reveal === 'btn-hover-swp' ) { #>
					<span class="btn-icon">
						<# getIcon(); #>
					</span>
					<# } #>
				<# } #>
			</a>

		<?php
	}

	protected function get_width() {

		$style = $this->get_settings_for_display('style');

		if( 'btn-naked' === $style || 'btn-underlined' === $style ) {
			return;
		}

		$width = $this->get_settings_for_display('width');

		return "$width";
	}

	protected function get_hover_text_opts() {

		$effect = $this->get_settings_for_display('hover_txt_effect');
		if( empty( $effect ) ) {
			return;
		}

		$start_delay = 0;
		$out = '';

		switch( $effect ) {

			case 'btn-hover-txt-liquid-x':
			default:

				$out = 'data-split-text="true"
					    data-split-options=\'{"type": "chars, words"}\'';
			break;

			case 'btn-hover-txt-liquid-x-alt':

				$out = 'data-split-text="true"
					    data-split-options=\'{"type": "chars, words"}\'';

			break;

			case 'btn-hover-txt-liquid-y':

				$out = 'data-split-text="true"
					    data-split-options=\'{"type": "chars, words"}\'';
			break;

			case 'btn-hover-txt-liquid-y-alt':

				$out = 'data-split-text="true"
				        data-split-options=\'{"type": "chars, words"}\'';
			break;

		}

		echo $out;

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Button() );