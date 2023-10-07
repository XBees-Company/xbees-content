<?php
 // Fancy box utils
 if ( $element_name === 'hub_fancy_heading' ) {

    $widget_utils['lqdsep-utils-block-inline-d'] = array();
    $widget_utils['lqdsep-utils-block-d'] = array(
        'conditions' =>
            $element->get_settings('enable_txt_rotator') === 'yes' &&
            $element->get_settings('rotator_type') === 'list'
    );
    $widget_utils['lqdsep-utils-h-100'] = array(
        'conditions' =>
            $element->get_settings('enable_txt_rotator') === 'yes' &&
            $element->get_settings('rotator_type') === 'list'
    );
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-overlay'] = array(
        'conditions' =>
            $element->get_settings('enable_txt_rotator') === 'yes' &&
            $element->get_settings('rotator_type') === 'list'
    );
    $widget_utils['lqdsep-utils-text-ws-nowrap'] = array(
        'conditions' =>
            $element->get_settings('whitespace') === 'ws-nowrap'
    );

};