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
class LD_Table extends Widget_Base {

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
		return 'ld_table';
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
		return __( 'Liquid Table', 'elementor' );
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
		return 'eicon-table lqd-element';
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
		return [ 'table', 'cells', 'content' ];
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
			'table_settings',
			[
				'label' => __( 'Table', 'hub-elementor-addons' ),
			]
		);

			$this->add_control(
				'column',
				[
					'label' => esc_html__( 'Columns', 'hub-elementor-addons' ),
					'description' => esc_html__( 'Set how many columns your table will have', 'hub-elementor-addons' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 20,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 3,
					],
				]
			);

			$this->add_control(
				'thead',
				[
					'label' => esc_html__( 'Enable table header', 'hub-elementor-addons' ),
					'description' => esc_html__( 'Groups the header content in a table', 'hub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'hub-elementor-addons' ),
					'label_off' => esc_html__( 'No', 'hub-elementor-addons' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$this->add_control(
				'tfoot',
				[
					'label' => esc_html__( 'Enable table footer', 'hub-elementor-addons' ),
					'description' => esc_html__( 'Groups the footer content in a table', 'hub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'hub-elementor-addons' ),
					'label_off' => esc_html__( 'No', 'hub-elementor-addons' ),
					'return_value' => 'yes',
					'default' => '',
					'separator' => 'after',
				]
			);

			$repeater = new Repeater();
			$repeater->add_control(
				'text', [
					'label' => esc_html__( 'Text', 'hub-elementor-addons' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
				]
			);

			$this->add_control(
				'items',
				[
					'label' => esc_html__( 'Table heading items', 'hub-elementor-addons' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[ 'text' => esc_html__( 'Heading #1', 'hub-elementor-addons' ) ],
						[ 'text' => esc_html__( 'Heading #2', 'hub-elementor-addons' ) ],
						[ 'text' => esc_html__( 'Heading #3', 'hub-elementor-addons' ) ],
						[ 'text' => esc_html__( 'Content #1', 'hub-elementor-addons' ) ],
						[ 'text' => esc_html__( 'Content #2', 'hub-elementor-addons' ) ],
						[ 'text' => esc_html__( 'Content #3', 'hub-elementor-addons' ) ],
						[ 'text' => esc_html__( 'Content #4', 'hub-elementor-addons' ) ],
						[ 'text' => esc_html__( 'Content #5', 'hub-elementor-addons' ) ],
						[ 'text' => esc_html__( 'Content #6', 'hub-elementor-addons' ) ],
					],
					'title_field' => '{{{ text }}}',
				]
			);

		$this->end_controls_section(); // table settings

		$this->start_controls_section(
			'table_styles',
			[
				'label' => __( 'Style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'table_typography',
				'selector' => '{{WRAPPER}} table',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'table_head_style',
			[
				'label' => __( 'Head style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'thead' => 'yes'
				]
			]
		);

		$this->add_control(
			'thead_color',
			[
				'label' => esc_html__( 'Text color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} thead th' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'thead_typography',
				'selector' => '{{WRAPPER}} thead th',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_thead_bg',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} table thead',
			]
		);

		$this->add_responsive_control(
			'thead_padding',
			[
				'label' => __( 'Cells padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'thead_rows_border_heading',
			[
				'label' => esc_html__( 'Rows border', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'thead_tr_border',
				'label' => __( 'Rows border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} thead tr',
			]
		);

		$this->add_control(
			'thead_cells_border_heading',
			[
				'label' => esc_html__( 'Cells border', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'thead_th_border',
				'label' => __( 'Cells border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} thead th',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'table_body_style',
			[
				'label' => __( 'Body style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tbody_typography',
				'selector' => '{{WRAPPER}} tbody td',
			]
		);

		$this->add_control(
			'tbody_bg_heading',
			[
				'label' => esc_html__( 'Background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_tbody_bg',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} table tbody tr',
			]
		);

		$this->add_control(
			'tbody_bg_even_heading',
			[
				'label' => esc_html__( 'Even rows background', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_tbody_bg_even',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} table tbody tr:nth-child(even)',
			]
		);

		$this->add_control(
			'tbody_color',
			[
				'label' => esc_html__( 'Text color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tbody td' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'tbody_padding',
			[
				'label' => __( 'Cells padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} tbody td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'tbody_rows_border_heading',
			[
				'label' => esc_html__( 'Rows border', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tbody_tr_border',
				'label' => __( 'Rows border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} tbody tr',
			]
		);

		$this->add_control(
			'tbody_cells_border_heading',
			[
				'label' => esc_html__( 'Cells border', 'hub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tbody_td_border',
				'label' => __( 'Cells border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} tbody td',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'table_foot_style',
			[
				'label' => __( 'Foot style', 'hub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'tfoot' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_tfoot_bg',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} table tfoot',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_bg_even',
				'label' => __( 'Background', 'hub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} table tr:nth-child(even)',
			]
		);

		$this->add_control(
			'tfoot_color',
			[
				'label' => esc_html__( 'Text color', 'hub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tfoot td' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tfoot_typography',
				'selector' => '{{WRAPPER}} tfoot td',
			]
		);

		$this->add_responsive_control(
			'tfoot_padding',
			[
				'label' => __( 'Cells padding', 'hub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} tfoot td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tfoot_tr_border',
				'label' => __( 'Rows border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} tfoot tr',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tfoot_td_border',
				'label' => __( 'Cells border', 'hub-elementor-addons' ),
				'selector' => '{{WRAPPER}} tfoot td',
			]
		);

		$this->end_controls_section(); // table options

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

		
		if ( $settings['items'] ) {

			$row_count = ceil(count( $settings['items']) / $settings['column']['size'] );
			$row_counter = 1;
			$table = '<table>';
			$counter = 1;
			$thead = $settings['thead'] ? false : true;
			$tfoot = $settings['tfoot'] ? false : true;
			foreach ( $settings['items'] as $item ) {

				// row start
				if ( $counter == 1 ){
					if ( !$thead )
						$table .= '<thead>';
					if ( !$tfoot && $row_counter == $row_count )
						$table .= '<tfoot>';

					$table .= '<tr>';
				}

				// cell item
				$table .= sprintf( '<%1$s class="%2$s">%3$s</%1$s>', 
					$thead ? 'td' : 'th',
					esc_attr( 'elementor-repeater-item-' . $item['_id'] ),
					$item['text']
				);

				// row end
				if ( $counter == $settings['column']['size'] ){
					if ( !$thead ){
						$table .= '</thead>';
						$thead = true;
					}
					if ( !$tfoot && $row_counter == $row_count ){
						$table .= '</tfoot>';
						$tfoot = true;
					}
					$table .= '</tr>';
					$row_counter++;
					$counter = 0;
				}

				$counter++;

			}

			echo $table . '</table>';

		}

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Table() );