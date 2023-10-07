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
class LD_Modal_Window extends Widget_Base {

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
		return 'ld_modal_window';
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
		return __( 'Liquid Modal Box', 'hub-elementor-addons' );
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
		return 'eicon-header lqd-element';
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
		return [ 'gdpr', 'alert', 'cookie'  ];
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
			return [ 'lity' ];
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

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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

		$this->add_control(
			'modal_type',
			[
				'label' => __( 'Modal Type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'hub-elementor-addons' ),
					'fullscreen' => __( 'Fullscreen', 'hub-elementor-addons' ),
					'box' => __( 'Box', 'hub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'modal',
			[
				'label' => __( 'Select Modal', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $this->get_block_posts(),
				'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Elementor Templates</a> to manage your elements.', 'hub-elementor-addons' ), admin_url( 'edit.php?post_type=elementor_library&tabs_group=library' ) ),
			]
		);
		$this->end_controls_section();

	}

	protected function get_block_posts() {
		$posts = get_posts( array(
			'post_type' => 'elementor_library',
			'posts_per_page' => -1,
			'meta_query'  => array(
                array(
                    'key' => '_elementor_template_type',
                    'value' => 'kit',
                    'compare' => '!=',
                ),
            ),
		) );
	
		$options = [ '0' => 'Select Modal' ];
	
		foreach ( $posts as $post ) {
		  $options[ $post->ID ] = $post->post_title;
		}
	
		return $options;
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
				'id' => 'modal-' . $settings['modal'],
				'class' => [ 'lqd-modal', 'lity-hide' ],
				'data-modal-type' => $settings['modal_type'],
			]
		);
		
		?>		

		<?php if ($settings['modal'] != 0 && \Elementor\Plugin::$instance->editor->is_edit_mode()){ ?>
			<span class="lqd-modal-id">
				<?php echo esc_html( 'Available Modal ID: #modal-'.$settings['modal'] ); ?>
			</span>
		<?php } ?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>

			<div class="lqd-modal-inner">
				
				<div class="lqd-modal-head">
					<h2><?php echo esc_html( $settings['title'] );?></h2>
				</div>
				<div class="lqd-modal-content">
					<?php echo \Elementor\Plugin::instance()->frontend->get_builder_content( $settings['modal'], true ); ?>
				</div>

				<div class="lqd-modal-foot"></div>

			</div>
		</div>

		<?php
		
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Modal_Window() );