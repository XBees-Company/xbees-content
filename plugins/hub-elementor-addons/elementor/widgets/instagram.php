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
class LD_Instagram extends Widget_Base {

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
		return 'ld_instagram';
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
		return __( 'Liquid Instagram Feed', 'hub-elementor-addons' );
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
		return 'eicon-instagram-gallery lqd-element';
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
		return [ 'instagram', 'photo' ];
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
			'important_note',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( 'Manage settings from plugin page<br>Go to the <a href="%s" target="_blank">plugin page</a>.', 'hub-elementor-addons' ), admin_url( 'admin.php?page=sbi-feed-builder' ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->end_controls_section();

		ld_el_btn($this, 'ib_'); // load button
	}
	
	protected function get_images() {

		if( !class_exists( 'SB_Instagram_Display_Elements' ) ) {
			return wp_kses_post( _e( '<div class="alert alert-danger">This element has been deprecated. Please use <a href="https://wordpress.org/plugins/instagram-feed/" target="_blank">Instagram Feed</a> plugin and its <a href="https://wordpress.org/plugins/instagram-feed/#installation" target="_blank">shortcode</a> to add the feed to your page.</div>', 'hub-elementor-addons' ) );
		}
				
		$instagram_feed = display_instagram();
		
		echo $instagram_feed;

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
		
		?>

		<div class="lqd-ig-feed">
			<?php $this->get_images(); ?>
			<?php
				$button = new \LQD_Elementor_Render_Button;
				$button->get_button( $this, 'ib_' ); 
			?>
		</div>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Instagram() );