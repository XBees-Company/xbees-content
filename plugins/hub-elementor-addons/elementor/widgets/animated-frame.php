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
 * @since 1.1
 */
class LD_Animated_Frame extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_animated_frame';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Animated Frame', 'hub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-frame-expand lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.1
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
	 * @since 1.1
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'frame', 'slider', 'animate' ];
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.1
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {

		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'wp-mediaelement', 'jquery-ytplayer' ];
		} else {
			return [''];
		}
		
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.1
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
			'enable_scrolable',
			[
				'label' => __( 'Scrollable', 'hub-elementor-addons' ),
				'description' => __( 'This option might not work well in the editor.', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'enable_autoplay',
			[
				'label' => __( 'Autoplay?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'autoplay_timeout',
			[
				'label' => __( 'Autoplay Delay (seconds)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'condition' => [
					'enable_autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'enable_counter',
			[
				'label' => __( 'Hide Navigation Counter?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-af-slidenum' => 'display: none;',
				],
			]
		);
		
		$this->add_control(
			'enable_arrows',
			[
				'label' => __( 'Hide Navigation Arrows?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-af-slidenav' => 'display: none;',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title' , 'hub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .lqd-af-slide__title',
			]
		);

		$repeater->add_control(
			'color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-af-slide__title' => 'color: {{VALUE}}'
				],
			]
		);

		$repeater->add_control(
			'content', [
				'label' => __( 'Content', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'List Content' , 'hub-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} p',
			]
		);

		$repeater->add_control(
			'txt_color',
			[
				'label' => __( 'Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} p' => 'color: {{VALUE}}'
				],
			]
		);

		$repeater->add_control(
			'media_type',
			[
				'label' => __( 'Media type', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'image'  => __( 'Image', 'hub-elementor-addons' ),
					'local_video'  => __( 'Video (Local)', 'hub-elementor-addons' ),
					'yt_video'  => __( 'Video (Youtube)', 'hub-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'mp4_local_video',
			[
				'label' => __( 'Local Video (mp4)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter url', 'hub-elementor-addons' ),
				'condition' => [
					'media_type' => 'local_video'
				],
			]
		);

		$repeater->add_control(
			'webm_local_video',
			[
				'label' => __( 'Local Video (webm)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter url', 'hub-elementor-addons' ),
				'condition' => [
					'media_type' => 'local_video'
				],
			]
		);

		$repeater->add_control(
			'yt_video_url',
			[
				'label' => __( 'YouTube link', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter url', 'hub-elementor-addons' ),
				'condition' => [
					'media_type' => 'yt_video'
				],
			]
		);
		
		$repeater->add_control(
			'yt_video_start',
			[
				'label' => __( 'Video Start Time', 'hub-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 8,
				'condition' => [
					'media_type' => 'yt_video'
				],
			]
		);
		
		$repeater->add_control(
			'yt_video_stop',
			[
				'label' => __( 'Video Stop Time', 'hub-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 17,
				'condition' => [
					'media_type' => 'yt_video'
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'hub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'media_type' => 'image'
				],
			]
		);

		$repeater->add_control(
			'btn_label', [
				'label' => __( 'Button Label', 'hub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'url',
			[
				'label' => __( 'URL (Link)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'hub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'label' => __( 'Button Typography', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .btn',
				'condition' => [
					'btn_label!' => ''
				],
			]
		);

		$repeater->add_control(
			'btn_color',
			[
				'label' => __( 'Button Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .btn' => 'color: {{VALUE}}'
				],
				'condition' => [
					'btn_label!' => ''
				],
			]
		);

		$repeater->add_control(
			'btn_h_color',
			[
				'label' => __( 'Button Hover Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .btn:hover' => 'color: {{VALUE}}'
				],
				'condition' => [
					'btn_label!' => ''
				],
			]
		);

		$repeater->add_control(
			'overlay_bg_heading',
			[
				'label' => __( 'Overlay Background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_bg',
				'label' => __( 'Overlay Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .lqd-af-slide__img .liquid-overlay-link',
				'fields_options' => [
					'background' => [
						//'default' => 'classic',
					],
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Items', 'hub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'Title #1', 'hub-elementor-addons' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'hub-elementor-addons' ),
					],
					[
						'list_title' => __( 'Title #2', 'hub-elementor-addons' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'hub-elementor-addons' ),
					],
				],
				'title_field' => '{{{ title }}}',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_tag',
			array(
				'label' => esc_html__( 'Title Element Tag', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
			)
		);

		$this->add_control(
			'use_inheritance',
			[
				'label' => __( 'Inherit font styles?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'tag_to_inherite',
			array(
				'label' => esc_html__( 'Element Tag', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p' => 'p',
				],
				'default' => 'h1',
				'condition' => array(
					'use_inheritance' => 'true',
				),

			)
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'frame_color',
			[
				'label' => __( 'Frame Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => __( 'Arrows Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-af-slidenav i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrows_hcolor',
			[
				'label' => __( 'Arrows Hover Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-af-slidenav:hover i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'slidenum_color',
			[
				'label' => __( 'Slide Num Color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-af-slidenum' => 'color: {{VALUE}}',
				],
				'condition' => [
					'enable_scrolable' => 'yes'
				],
			]
		);

		$this->end_controls_section();
	}

	protected function get_opts() {

		if ( !$this->get_settings_for_display( 'enable_scrolable' ) && !$this->get_settings_for_display( 'enable_autoplay' ) ){
			return;
		}

		$opts = array();
		
		if( $this->get_settings_for_display( 'enable_scrolable' ) ) {
			$opts['scrollable'] = true;
			$opts['forceDisablingWindowScroll'] = true;
		}
		if( $this->get_settings_for_display( 'enable_autoplay' ) ) {
			$autoplay_timeout = $this->get_settings_for_display( 'autoplay_timeout' )['size'];
			$opts['autoplay'] = true;
			$opts['autoplayTimeout'] = $autoplay_timeout ? (float) ($autoplay_timeout * 1000) : '4000';
		}

		echo ' data-af-options=\'' . wp_json_encode( $opts ) . '\'';
		
	}

	protected function af_get_image( $title, $media_type, $image_url, $mp4_local_video, $webm_local_video, $yt_video_url, $yt_video_duration ) {
		

		$img_src = $image = '';
		$alt  = $title;

		$image_url = isset($image_url['url']) ? $image_url['url'] : '';
		
		
		if( 'image' == $media_type ) {
		
			if( preg_match( '/^\d+$/', $image_url ) ) {
				$html = wp_get_attachment_image( $image_url, 'full', false, array( 'class' => 'w-100 h-100 objfit-cover objpos-center', 'alt' => esc_html( $alt ) ) );
			} 
			else {
				$img_src  = $image_url;
				$html = '<img class="w-100 h-100 objfit-cover objpos-center" src="' . esc_url( $img_src ) . '" alt="' . esc_html( $alt ) . '" />';
			}
	
			$image = sprintf( '<figure class="w-100 h-100 overflow-hidden will-change-transform">%s<span class="lqd-overlay"></span></figure>', $html );
			
		}
		elseif( 'local_video' == $media_type ) {
			
			$image = '<figure class="w-100 h-100 overflow-hidden will-change-transform">
						<div class="lqd-vbg-wrap">
							<div class="lqd-vbg-inner">
								<span class="lqd-vbg-loader"></span>
								<video class="lqd-vbg-video" autoplay loop muted playsinline>';
			if( !empty( $mp4_local_video ) ) {
				$image .= '<source data-src="' . esc_url( $mp4_local_video ) . '" type="video/mp4">';
			}
			if( !empty( $webm_local_video ) ) {
				$image .= '<source data-src="' . esc_url( $webm_local_video ) . '" type="video/webm">';
			}

			$image .=          '</video>
							</div>
						</div>
					</figure>';
		
		}
		elseif( 'yt_video' == $media_type ) {

			$yt_video_start = isset($yt_video_duration['startAt']) ? $yt_video_duration['startAt'] : "8";
			$yt_video_stop = isset($yt_video_duration['stopAt']) ? $yt_video_duration['stopAt'] : "17";
			
			$image = '<figure class="w-100 h-100 overflow-hidden will-change-transform">
						<div class="lqd-vbg-wrap">
							<div class="lqd-vbg-inner">
								<span class="lqd-vbg-loader"></span>
								<div
									class="lqd-vbg-video"
									data-video-bg="true"
									data-youtube-options=\'{
										"videoURL": "' . $yt_video_url . '",
										"startAt": ' . $yt_video_start . ',
										"stopAt": "' . $yt_video_stop . '"
									}\'
								></div>
							</div>
						</div>
					</figure>';
		}
		
		echo $image;
		
	}

	protected function af_get_button( $button_label, $button_url ) {

		if ( empty( $button_label ) ){
			return;
		}

		if( isset( $button_url['url'] ) ) { ?>
			<a href="<?php echo esc_url( $button_url['url'] ) ?>" class="btn btn-naked">
				<span>
					<span class="btn-txt"><?php echo esc_html($button_label) ?></span>
					<span class="btn-icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path fill="currentColor" d="M17.806 25.788l8.631-8.375c.375-.363.563-.857.563-1.4v-.025c0-.544-.188-1.038-.563-1.4l-8.63-8.375c-.75-.782-1.957-.782-2.7 0s-.745 2.043 0 2.825L20.293 14H6.919C5.856 14 5 14.894 5 16c0 1.125.856 2 1.912 2h13.375L15.1 22.963a2.067 2.067 0 0 0 0 2.824c.75.782 1.956.782 2.706 0z"></path></svg>
					</span>
				</span>
			</a>
		<?php }
	
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.1
	 * @access protected
	 */
	protected function render() {
		
		$settings = $this->get_settings_for_display();
			
		?>
		<div class="lqd-af w-100 h-vh-100 pos-rel overflow-hidden" data-liquid-animatedframes="true" <?php $this->get_opts(); ?>>
			<div class="lqd-af-slides lqd-overlay">

			<?php 
				if ( $settings['list'] ) {
					foreach (  $settings['list'] as $i => $item ) {

					$repeater_setting_key = $this->get_repeater_setting_key( 'title', 'list', $i );
					$this->add_render_attribute( $repeater_setting_key, [
						'class' => [ 
							'lqd-af-slide',
							'd-flex',
							'flex-column',
							'align-items-center',
							'justify-content-center',
							'lqd-overlay',
							'overflow-hidden',
							'elementor-repeater-item-' . $item['_id']
						],
					] );
			?>
				
				<div <?php $this->print_render_attribute_string( $repeater_setting_key ); ?>>
		
					<div class="lqd-af-slide__img lqd-overlay overflow-hidden will-change-transform">
						<div class="lqd-af-slide__img__inner w-100 h-100 overflow-hidden will-change-transform">
							<?php $this->af_get_image( $item['title'], $item['media_type'], $item['image'], $item['mp4_local_video'], $item['webm_local_video'], $item['yt_video_url'], array( 'startAt' => $item['yt_video_start'], 'stopAt' => $item['yt_video_stop'] ) ); ?>
							<span class="lqd-overlay liquid-overlay-link"></span>
						</div>
					</div>

					<div class="lqd-af-slide__content w-100 pos-rel z-index-5">
						<?php 
							if ( !empty( $item['title'] ) ){
							printf( '<%1$s class="lqd-af-slide__title d-flex flex-wrap pos-rel %2$s" data-split-text="true" data-split-options=\'{ "type": "lines" }\'>%3$s</%1$s>', $settings['title_tag'], $settings['use_inheritance'] === 'true' ? $settings['tag_to_inherite'] : '', $item['title'] );
							}
							
							if ( !empty( $item['content'] ) ){
							printf( '<p class="lqd-af-slide__desc pos-rel" data-split-text="true" data-split-options=\'{ "type": "lines" }\'>%s</p>', $item['content'] );
						}
						?>
						<div class="lqd-af-slide__link">
							<?php $this->af_get_button( $item['btn_label'], $item['url'] ); ?>
						</div>
						<!-- for custom cursor arrow -->
						<?php if ( ! empty( $item['url']['url'] ) ): ?>
							<a href="<?php echo esc_url( $item['url']['url'] ); ?>" class="lqd-overlay z-index-5"></a>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $item['url']['url'] ) ): ?>
						<a href="<?php echo esc_url( $item['url']['url'] ); ?>" class="lqd-overlay z-index-4"></a>
					<?php endif; ?>
					
				</div>
				
				<?php 
					}
				}
				?>
			</div>
			
			<nav class="lqd-af-slidenav d-inline-flex pos-abs z-index-5 text-center">
				<button class="lqd-af-slidenav__item lqd-af-slidenav__item--prev d-inline-flex align-items-center justify-content-center pos-rel">
					<svg xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewBox="0 0 21 32" style="width: 1em; height: 1em;"><path d="M10.5 18.375l7.938-7.938c.562-.562 1.562-.562 2.125 0s.562 1.563 0 2.126l-9 9c-.563.562-1.5.625-2.063.062L.437 12.562C.126 12.25 0 11.876 0 11.5s.125-.75.438-1.063c.562-.562 1.562-.562 2.124 0z" fill="currentColor"></path></svg>
				</button>
				<button class="lqd-af-slidenav__item lqd-af-slidenav__item--next d-inline-flex align-items-center justify-content-center pos-rel">
					<svg xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewBox="0 0 21 32" style="width: 1em; height: 1em;"><path d="M10.5 13.625l-7.938 7.938c-.562.562-1.562.562-2.124 0C.124 21.25 0 20.875 0 20.5s.125-.75.438-1.063L9.5 10.376c.563-.563 1.5-.5 2.063.063l9 9c.562.562.562 1.562 0 2.125s-1.563.562-2.125 0z" fill="currentColor"></path></svg>
				</button>
			</nav>

			<div class="lqd-af-slidenum pos-abs">
				<span class="lqd-af-slidenum__line lqd-af-slidenum__line--before d-inline-flex align-items-center"></span>
				<div class="lqd-af-slidenum__nums d-flex align-items-center">
					<span class="lqd-af-slidenum__current d-inline-flex align-items-center pos-rel overflow-hidden">
						<span class="pos-abs pos-tl">
							<?php 
								if ( $settings['list'] ) {
									for ( $i = 1; $i <= count($settings['list']); $i++ ) {
							?>
								<span class="d-flex align-items-center justify-content-center"><?php echo $i ?></span>
							<?php
									}
								}
							?>
						</span>
					</span>
					<span class="lqd-af-slidenum__total"><?php echo count($settings['list']) ?></span>
				</div>
				<span class="lqd-af-slidenum__line lqd-af-slidenum__line--after d-inline-flex align-items-center"></span>
			</div>

		</div>

		<?php
		
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Animated_Frame() );