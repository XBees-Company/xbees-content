<?php 

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

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

defined( 'ABSPATH' ) || die();

function ld_el_advanced_text( $prefix, $condition = '' ){

    $prefix->add_control(
        'advanced_text_enable',
        [
            'label' => esc_html__( 'Enable the advanced text?', 'hub-elementor-addons' ),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'On', 'hub-elementor-addons' ),
            'label_off' => esc_html__( 'Off', 'hub-elementor-addons' ),
            'return_value' => 'yes',
            'default' => '',
        ]
    );
    
    $repeater_advanced_text = new Repeater();
    
    $repeater_advanced_text->add_control(
        'text', [
            'label' => esc_html__( 'Title', 'hub-elementor-addons' ),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__( 'Title' , 'hub-elementor-addons' ),
            'label_block' => true,
        ]
    );

    $repeater_advanced_text->add_control(
        'image',
        [
            'label' => esc_html__( 'Choose Image', 'hub-elementor-addons' ),
            'type' => Controls_Manager::MEDIA,
        ]
    );

    $repeater_advanced_text->add_responsive_control(
        'img_width',
        [
            'label' => esc_html__( 'Width', 'hub-elementor-addons' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vw' ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 1000,
                ],
                'vw' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'image[url]!' => '' 
            ]
        ]
    );

    $repeater_advanced_text->add_control(
        'image_align',
        [
            'label' => esc_html__( 'Image placement', 'hub-elementor-addons' ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => esc_html__( 'Left', 'hub-elementor-addons' ),
                    'icon' => 'eicon-h-align-left',
                ],
                'right' => [
                    'title' => esc_html__( 'Right', 'hub-elementor-addons' ),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => 'left',
            'toggle' => false,
            'condition' => [
                'image[url]!' => '' 
            ]
        ]
    );

    $repeater_advanced_text->add_control(
        'image_v_align',
        [
            'label' => esc_html__( 'Vertical align', 'hub-elementor-addons' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'baseline' => 'Baseline',
                'sub' => 'Subscript',
                'sup' => 'Superscript',
                'top' => 'Top',
                'text-top' => 'Text top',
                'middle' => 'Middle',
                'bottom' => 'Bottom',
                'text-bottom' => 'Text bottom',
            ],
            'default' => 'bottom',
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} figure' => 'vertical-align: {{VALUE}};',
            ],
            'condition' => [
                'image[url]!' => '' 
            ]
        ]
    );


    $repeater_advanced_text->add_responsive_control(
        'border',
        [
            'label' => esc_html__( 'Border', 'hub-elementor-addons' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};border-style: solid;',
            ],
            'condition' => [
                'image[url]!' => '' 
            ]
        ]
    );

    $repeater_advanced_text->add_responsive_control(
        'border_radius',
        [
            'label' => esc_html__( 'Border Radius', 'hub-elementor-addons' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} img, {{WRAPPER}} {{CURRENT_ITEM}} figure' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'image[url]!' => '' 
            ]
        ]
    );

    $repeater_advanced_text->add_control(
        'border_color',
        [
            'label' => esc_html__( 'Border Color', 'textdomain' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                'image[url]!' => '' 
            ]
        ]
    );

    $repeater_advanced_text->add_responsive_control(
        'margin',
        [
            'label' => esc_html__( 'Margin', 'hub-elementor-addons' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'image[url]!' => '' 
            ]
        ]
    );


    $repeater_advanced_text->add_responsive_control(
        'item_z_index',
        [
            'label' => esc_html__( 'Z-Index', 'elementor' ),
            'type' => Controls_Manager::NUMBER,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'position: relative; z-index: {{VALUE}};',
            ],
            'condition' => [
                'image[url]!' => '' 
            ]
        ]
    );

    $repeater_advanced_text->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => 'advanced_text_typography',
            'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
        ]
    );

    $repeater_advanced_text->add_control(
        'advanced_text_color',
        [
            'label' => esc_html__( 'Color', 'hub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
            ],
        ]
    );
    
    $prefix->add_control(
        'advanced_text_content',
        [
            'label' => esc_html__( 'Items', 'hub-elementor-addons' ),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater_advanced_text->get_controls(),
            'default' => [
                [
                    'text' => esc_html__( 'Title #1', 'hub-elementor-addons' ),
                ],
                [
                    'text' => esc_html__( 'Title #2', 'hub-elementor-addons' ),
                ],
            ],
            'title_field' => '{{{ text }}}',
            'condition' => [
                'advanced_text_enable' => 'yes'
            ]
        ]
    );

}

function ld_el_get_advanced_text( $widget ){

    $items = $widget->get_settings_for_display('advanced_text_content');
    $content = '';

    if ( $items ){
        foreach( $items as $item ){

            $content .= sprintf( '<span class="lqd-adv-txt-item elementor-repeater-item-%s">', $item['_id'] );

            if ( !empty($item['image']['url']) ){
                $img_html = '<figure class="lqd-adv-txt-fig pos-rel d-inline-flex">' . wp_get_attachment_image( $item['image']['id'], 'full', false ) . '</figure>';
                $content = $item['image_align'] === 'left' ? $content . $img_html . $item['text'] : $content . $item['text'] . $img_html; 
            } else {
                $content .= $item['text'];
            }

            $content .= "</span>";

        }
    }

    return $content;

}