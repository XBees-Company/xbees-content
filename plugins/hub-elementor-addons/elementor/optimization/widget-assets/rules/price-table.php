<?php
 // Pricing table utils
 if ( $element_name === 'ld_price_table' ) {

    $element_template = $element->get_settings('template');

    $widget_utils['lqdsep-utils-p-3'] = array(
        'conditions' =>
            $element->get_settings('show_button') === 'yes' &&
            $element_template === 'style11'
    );
    $widget_utils['lqdsep-utils-p-5'] = array(
        'conditions' =>
            $element_template === 'style07'
    );
    $widget_utils['lqdsep-utils-pt-1'] = array(
        'conditions' =>
            $element->get_settings('show_button') === 'yes' &&
            $element_template === 'style06'
    );
    $widget_utils['lqdsep-utils-pt-2'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-pt-3'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style03b' ||
            $element_template === 'style04' ||
            $element_template === 'style07' ||
            $element_template === 'style08' ||
            $element_template === 'style09' ||
            $element_template === 'style11' ||
            (
                $element->get_settings('show_button') === 'yes' &&
                $element_template === 'style05'
            )
    );
    $widget_utils['lqdsep-utils-pt-4'] = array(
        'conditions' =>
        $element_template === 'style01' ||
        $element_template === 'style02' ||
        $element_template === 'style03' ||
        $element_template === 'style03b' ||
        $element_template === 'style09'
    );
    $widget_utils['lqdsep-utils-pt-5'] = array(
        'conditions' =>
            $element_template === 'style04' ||
            $element_template === 'style05' ||
            $element_template === 'style06' ||
            $element_template === 'style10'
    );
    $widget_utils['lqdsep-utils-pt-6'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style03b' ||
            $element_template === 'style04' ||
            $element_template === 'style06' ||
            $element_template === 'style08' ||
            $element_template === 'style10'
    );
    $widget_utils['lqdsep-utils-pb-2'] = array(
        'conditions' =>
            $element_template === 'style05' ||
            (
                $element->get_settings('show_button') === 'yes' &&
                (
                    $element_template === 'style03' ||
                    $element_template === 'style07'
                )
            )
    );
    $widget_utils['lqdsep-utils-pb-3'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style04' ||
            $element_template === 'style07' ||
            $element_template === 'style09' ||
            $element_template === 'style10' ||
            $element_template === 'style11' ||
            (
                $element->get_settings('show_button') === 'yes' &&
                (
                    $element_template === 'style03b' ||
                    $element_template === 'style05'
                )
            )
    );
    $widget_utils['lqdsep-utils-pb-4'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style02' ||
            $element_template === 'style03' ||
            $element_template === 'style05' ||
            $element_template === 'style08' ||
            $element_template === 'style09'
    );
    $widget_utils['lqdsep-utils-pb-5'] = array(
        'conditions' =>
            $element_template === 'style03b' ||
            $element_template === 'style04' ||
            $element_template === 'style05' ||
            $element_template === 'style06' ||
            $element_template === 'style08' ||
            (
                $element->get_settings('show_button') === 'yes' &&
                $element_template === 'style01'
            )
    );
    $widget_utils['lqdsep-utils-pb-6'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style04' ||
            $element_template === 'style06' ||
            $element_template === 'style11'
    );
    $widget_utils['lqdsep-utils-ps-2'] = array(
        'conditions' =>
            $element_template === 'style01'
    );
    $widget_utils['lqdsep-utils-ps-3'] = array(
        'conditions' =>
            $element_template === 'style04' ||
            $element_template === 'style05' ||
            $element_template === 'style11'
    );
    $widget_utils['lqdsep-utils-ps-4'] = array(
        'conditions' =>
            $element_template === 'style06'
    );
    $widget_utils['lqdsep-utils-ps-5'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style02' ||
            $element_template === 'style03' ||
            $element_template === 'style03b' ||
            $element_template === 'style08' ||
            $element_template === 'style09' ||
            $element_template === 'style10'
    );
    $widget_utils['lqdsep-utils-pe-2'] = array(
        'conditions' =>
            $element_template === 'style01'
    );
    $widget_utils['lqdsep-utils-pe-3'] = array(
        'conditions' =>
            $element_template === 'style04' ||
            $element_template === 'style05' ||
            $element_template === 'style11'
    );
    $widget_utils['lqdsep-utils-pe-4'] = array(
        'conditions' =>
            $element_template === 'style06'
    );
    $widget_utils['lqdsep-utils-pe-5'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style02' ||
            $element_template === 'style03' ||
            $element_template === 'style03b' ||
            $element_template === 'style08' ||
            $element_template === 'style09' ||
            $element_template === 'style10'
    );
    $widget_utils['lqdsep-utils-mt-0'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style03b' ||
            $element_template === 'style04' ||
            $element_template === 'style05' ||
            $element_template === 'style06' ||
            $element_template === 'style11'
    );
    $widget_utils['lqdsep-utils-mt-4'] = array(
        'conditions' =>
            $element_template === 'style07' ||
            (
                $element->get_settings('show_button') === 'yes' &&
                $element_template === 'style02'
            )
    );
    $widget_utils['lqdsep-utils-mb-0'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style03b' ||
            $element_template === 'style11' ||
            (
                ! empty( $element->get_settings('description') ) &&
                $element_template !== 'style04' ||
                $element_template !== 'style11'
            )
    );
    $widget_utils['lqdsep-utils-mb-1'] = array(
        'conditions' =>
            $element_template === 'style08' ||
            (
                ! empty( $element->get_settings('description') ) &&
                (
                    $element_template === 'style04' ||
                    $element_template === 'style11'
                )
            )
    );
    $widget_utils['lqdsep-utils-mb-3'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-mb-4'] = array(
        'conditions' =>
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-mb-5'] = array(
        'conditions' =>
            $element_template === 'style03b' ||
            $element_template === 'style06'
    );
    $widget_utils['lqdsep-utils-border-radius-4'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style02' ||
            $element_template === 'style05' ||
            $element_template === 'style07' ||
            $element_template === 'style08' ||
            $element_template === 'style09' ||
            (
                $element->get_settings('featured_tag') === 'yes' &&
                ! empty( $element->get_settings('featured_label') ) &&
                $element_template !== 'style03b' &&
                $element_template !== 'style11'
            )
    );
    $widget_utils['lqdsep-utils-border-radius-8'] = array(
        'conditions' =>
            $element_template === 'style09'
    );
    $widget_utils['lqdsep-utils-border-radius-10'] = array(
        'conditions' =>
            $element_template === 'style06' ||
            $element_template === 'style10'
    );
    $widget_utils['lqdsep-utils-border-radius-circle'] = array(
        'conditions' =>
            $element->get_settings('featured_tag') === 'yes' &&
            ! empty( $element->get_settings('featured_label') ) &&
            $element_template === 'style03b'
    );

    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-overlay'] = array();
    $widget_utils['lqdsep-utils-text-uppercase'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style03b' ||
            $element_template === 'style04' ||
            $element_template === 'style05' ||
            $element_template === 'style06' ||
            $element_template === 'style09' ||
            (
                $element->get_settings('featured_tag') === 'yes' &&
                ! empty( $element->get_settings('featured_label') )
            )
    );
    $widget_utils['lqdsep-utils-text-weight-normal'] = array(
        'conditions' =>
            $element_template === 'style02'
    );
    $widget_utils['lqdsep-utils-text-weight-medium'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style05' ||
            $element_template === 'style06' ||
            $element_template === 'style08'
    );
    $widget_utils['lqdsep-utils-text-weight-semibold'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style03' ||
            $element_template === 'style03b' ||
            $element_template === 'style04' ||
            $element_template === 'style09' ||
            (
                $element->get_settings('featured_tag') === 'yes' &&
                ! empty( $element->get_settings('featured_label') ) &&
                $element_template !== 'style03b'
            )
    );
    $widget_utils['lqdsep-utils-text-weight-bold'] = array(
        'conditions' =>
            $element->get_settings('featured_tag') === 'yes' &&
            ! empty( $element->get_settings('featured_label') ) &&
            $element_template === 'style03b'
    );
    $widget_utils['lqdsep-utils-text-ltrsp-1'] = array(
        'conditions' =>
            $element_template === 'style09' ||
            (
                ! empty( $element->get_settings('description') ) &&
                $element_template === 'style04'
            ) ||
            (
                $element->get_settings('featured_tag') === 'yes' &&
                ! empty( $element->get_settings('featured_label') )
            )
    );
    $widget_utils['lqdsep-utils-text-ltrsp-2'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style03b' ||
            $element_template === 'style04' ||
            $element_template === 'style05' ||
            $element_template === 'style06'
    );
    $widget_utils['lqdsep-utils-text-center'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style05' ||
            $element_template === 'style06' ||
            $element_template === 'style07' ||
            $element_template === 'style08' ||
            $element_template === 'style11' ||
            (
                $element->get_settings('show_button') === 'yes' &&
                $element_template === 'style03b'
            )
    );

}