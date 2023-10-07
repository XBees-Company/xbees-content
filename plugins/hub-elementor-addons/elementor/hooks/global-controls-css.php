<?php

use Elementor\Core\Base\Module;
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Element_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Settings\Manager;
use Elementor\Plugin;

defined( 'ABSPATH' ) || exit;

class LD_Global_Controls_Media_CSS {

	public function __construct() {

		add_action( 'wp_enqueue_scripts', [ $this, 'add_missing_media_queries' ], 20 );
 
	}

	function get_page_option( $option, $post_id = '' ){

		if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
			$post_id = !empty( $post_id ) ? $post_id : get_the_ID();
 			$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
			$page_settings_model = $page_settings_manager->get_model( $post_id );
			//return var_dump($page_settings_model->get_settings(  ));
			return $page_settings_model->get_settings( $option );
		}
	}

	function add_missing_media_queries() {

		$css = '';
		$options = [
			'title_bar_padding' => [
				'type' => 'padding',
				'selector' => 'body.elementor-page-' .get_the_ID() . ' .titlebar-inner',
			],
			'title_bar_subheading_typography_font_size' => [
				'type' => 'font',
				'selector' => 'body.elementor-page-' .get_the_ID() . ' .titlebar-inner p',
			],
			'title_bar_heading_typography_font_size' => [
				'type' => 'font',
				'selector' => 'body.elementor-page-' .get_the_ID() . ' .titlebar-inner h1',
			],
			'title_bar_bg' => [
				'type' => 'bg_image',
				'selector' => 'body.elementor-page-' .get_the_ID() . ' .titlebar',
			]
		];

		$active_breakpoints = Plugin::$instance->breakpoints->get_active_breakpoints();

		$devices = Plugin::$instance->breakpoints->get_active_devices_list( [
			'reverse' => true,
			'desktop_first' => true,
		] );

		array_shift($devices); // remove desktop

		$breakpoints = [
			'viewport_mobile' => 767,
			'viewport_mobile_extra' => 880,
			'viewport_tablet' => 1024,
			'viewport_tablet_extra' => 1200,
			'viewport_laptop' => 1366,
			'viewport_widescreen' => 2400,
		];

		$a = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display( 'viewport_tablet' );

		foreach( $devices as $name ){
			$value = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display( 'viewport_' . $name );
			if ( empty($value) ){ // if return empty, get data from $defaults array.
				$viewport = $breakpoints['viewport_' . $name];
			} else {
				$viewport = $value;
			}

			$css .= "@media (max-width: {$viewport}px){";
			foreach( $options as $option_key => $option ) {
				if ( $this->get_css_option($option_key.'_'.$name, $option['type']) ) {
					$css .= $option['selector'] . "{" . $this->get_css_option($option_key.'_'.$name, $option['type']) . "}";
				}
			}
			$css .= "}";

		}

		wp_add_inline_style( 'elementor-frontend', $css );

	}

	function get_css_option( $option, $type ) {

		
		if ( $type === 'padding' ){
			if ( $values = $this->get_page_option( $option ) ) {
				$values = "padding: $values[top]$values[unit] $values[right]$values[unit] $values[bottom]$values[unit] $values[left]$values[unit]";
				return $values;
			}
		}

		if ( $type === 'font' ) {
			if ( $values = $this->get_page_option( $option ) ) {
				$values = "font-size: $values[size]$values[unit]";
				return $values;
			}
		}

		if ( $type === 'bg_image' ) {
			$o_bg = str_replace('title_bar_bg', 'title_bar_bg_image', $option);
			$o_size = str_replace('title_bar_bg', 'title_bar_bg_size', $option);
			$o_position = str_replace('title_bar_bg', 'title_bar_bg_position', $option);
			$o_position_x = str_replace('title_bar_bg', 'title_bar_bg_xpos', $option);
			$o_position_y = str_replace('title_bar_bg', 'title_bar_bg_ypos', $option);
			$o_attachment = str_replace('title_bar_bg', 'title_bar_bg_attachment', $option);
			if ( $values = $this->get_page_option( $o_bg ) ) {
				$bg = '';
				if ( $url = $values['url'] ){
					$bg .= sprintf( 'background-image: url("%s");', $url );
				}
				if ( $size = $this->get_page_option( $o_size ) ){
					$bg .= sprintf( 'background-size: %s;', $size );
				}
				if ( $position = $this->get_page_option( $o_position ) ){
					if ( $position === 'initial' ) {
						$o_position_x = $this->get_page_option( $o_position_x );
						$o_position_y = $this->get_page_option( $o_position_y );

						if ( $o_position_x && $o_position_y ){
							$bg .= sprintf( 'background-position: %s %s;', $o_position_x['size'].$o_position_x['unit'], $o_position_y['size'].$o_position_y['unit'] );
						}
						
					} else {
						$bg .= sprintf( 'background-position: %s;', $position );
					}
				}
				if ( $attachment = $this->get_page_option( $o_attachment ) ){
					$bg .= sprintf( 'background-repeat: %s;', $attachment );
				}
	
				return $bg;
				
			}
		}
	}

    
}

new LD_Global_Controls_Media_CSS();
