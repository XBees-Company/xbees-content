<?php
// Blog utils
if ( $element_name === 'ld_blog' ) {

    $element_template = $element->get_settings('style');

    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-inline-d'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style07' ||
            $element_template === 'style09' ||
            $element_template === 'style11' ||
            $element_template === 'style12' ||
            $element_template === 'style14'
    );
    $widget_utils['lqdsep-utils-block-d'] = array(
        'conditions' =>
            $element->get_settings( 'pagination' ) === 'ajax'
    );
    $widget_utils['lqdsep-utils-block-inline-d'] = array(
        'conditions' =>
            $element->get_settings( 'pagination' ) === 'ajax' ||
            $element->get_settings( 'style' ) === 'style16' ||
            $element->get_settings( 'style' ) === 'style17' ||
            $element->get_settings( 'style' ) === 'style21' ||
            $element->get_settings( 'style' ) === 'style21-alt'
    );
    $widget_utils['lqdsep-utils-flex-column'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style02-alt' ||
            $element_template === 'style14' ||
            $element_template === 'style17' ||
            $element_template === 'style18' ||
            $element_template === 'style19'
    );
    $widget_utils['lqdsep-utils-flex-wrap'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
        'conditions' =>
            $element_template !== 'style10' &&
            $element_template !== 'style11' &&
            $element_template !== 'style15' &&
            $element_template !== 'style16' &&
            $element_template !== 'style17' &&
            $element_template !== 'style20'
    );
    $widget_utils['lqdsep-utils-flex-align-items-end'] = array(
        'conditions' =>
            $element_template === 'style19'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style09' ||
            $element_template === 'style21' ||
            $element_template === 'style21-alt'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-between'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style02-alt' ||
            $element_template === 'style10' ||
            $element_template === 'style11'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-end'] = array(
        'conditions' =>
            $element_template === 'style14' ||
            $element_template === 'style17' ||
            $element_template === 'style19'
    );
    $widget_utils['lqdsep-utils-w-80'] = array(
        'conditions' =>
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-w-100'] = array();
    $widget_utils['lqdsep-utils-h-100'] = array(
        'conditions' =>
            $element_template === 'style02-alt' ||
            $element_template === 'style10' ||
            $element_template === 'style11' ||
            $element_template === 'style19'
    );
    $widget_utils['lqdsep-utils-h-pt-60'] = array(
        'conditions' =>
            $element_template === 'style14'
    );
    $widget_utils['lqdsep-utils-h-pt-80'] = array(
        'conditions' =>
            $element_template === 'style10'
    );
    $widget_utils['lqdsep-utils-h-pt-90'] = array(
        'conditions' =>
            $element_template === 'style11'
    );
    $widget_utils['lqdsep-utils-p-0'] = array(
        'conditions' =>
            $element_template === 'style13' ||
            $element_template === 'style14' ||
            $element_template === 'style18' ||
            $element_template === 'style19'
    );
    $widget_utils['lqdsep-utils-p-4'] = array(
        'conditions' =>
            $element_template === 'style10' ||
            $element_template === 'style11' ||
            $element_template === 'style14'
    );
    $widget_utils['lqdsep-utils-p-5'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style02-alt' ||
            $element_template === 'style06' ||
            $element_template === 'style06-alt'
    );
    $widget_utils['lqdsep-utils-pt-1'] = array(
        'conditions' =>
            $element_template === 'style14' ||
            $element_template === 'style16' ||
            $element_template === 'style17'
    );
    $widget_utils['lqdsep-utils-pt-2'] = array(
        'conditions' =>
            $element_template === 'style06-alt' ||
            $element_template === 'style13'
    );
    $widget_utils['lqdsep-utils-pt-3'] = array(
        'conditions' =>
            $element_template === 'style21' ||
            $element_template === 'style21-alt'
    );
    $widget_utils['lqdsep-utils-pt-4'] = array(
        'conditions' =>
            $element_template === 'style06-alt'
    );
    $widget_utils['lqdsep-utils-pt-6'] = array(
        'conditions' =>
            $element_template === 'style17'
    );
    $widget_utils['lqdsep-utils-pb-1'] = array(
        'conditions' =>
            $element_template === 'style14'
    );
    $widget_utils['lqdsep-utils-pb-2'] = array(
        'conditions' =>
            $element_template === 'style13'
    );
    $widget_utils['lqdsep-utils-pb-4'] = array(
        'conditions' =>
            $element_template === 'style06-alt'
    );
    $widget_utils['lqdsep-utils-pb-6'] = array(
        'conditions' =>
            $element_template === 'style17'
    );
    $widget_utils['lqdsep-utils-ps-2'] = array(
        'conditions' =>
            $element_template === 'style14'
    );
    $widget_utils['lqdsep-utils-ps-3'] = array(
        'conditions' =>
            $element_template === 'style04' ||
            $element_template === 'style06-alt' ||
            $element_template === 'style13'
    );
    $widget_utils['lqdsep-utils-ps-4'] = array(
        'conditions' =>
            $element_template === 'style17' ||
            $element_template === 'style19'
    );
    $widget_utils['lqdsep-utils-pe-2'] = array(
        'conditions' =>
            $element_template === 'style14'
    );
    $widget_utils['lqdsep-utils-pe-3'] = array(
        'conditions' =>
            $element_template === 'style04' ||
            $element_template === 'style06-alt' ||
            $element_template === 'style13'
    );
    $widget_utils['lqdsep-utils-pe-4'] = array(
        'conditions' =>
            $element_template === 'style17' ||
            $element_template === 'style19'
    );
    $widget_utils['lqdsep-utils-m-0'] = array(
        'conditions' =>
            $element_template === 'style13' ||
            $element_template === 'style16' ||
            $element_template === 'style18' ||
            $element_template === 'style19' ||
            $element_template === 'style20'
    );
    $widget_utils['lqdsep-utils-mt-0'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style02-alt' ||
            $element_template === 'style05' ||
            $element_template === 'style06' ||
            $element_template === 'style06-alt' ||
            $element_template === 'style07' ||
            $element_template === 'style08' ||
            $element_template === 'style11' ||
            $element_template === 'style14' ||
            $element_template === 'style22' ||
            $element_template === 'style22-alt' ||
            $element_template === 'style23'
    );
    $widget_utils['lqdsep-utils-mt-1'] = array(
        'conditions' =>
            $element_template === 'style21' ||
            $element_template === 'style21-alt' ||
            $element->get_settings( 'pagination' ) === 'ajax'
    );
    $widget_utils['lqdsep-utils-mt-2'] = array(
        'conditions' =>
            $element_template === 'style04' ||
            $element_template === 'style06-alt' ||
            $element_template === 'style10' ||
            $element_template === 'style17' ||
            $element_template === 'style22' ||
            $element_template === 'style22-alt' ||
            $element_template === 'style23'
    );
    $widget_utils['lqdsep-utils-mt-3'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style03' ||
            $element_template === 'style05' ||
            $element_template === 'style06' ||
            $element_template === 'style06-alt' ||
            $element_template === 'style07' ||
            $element_template === 'style08' ||
            $element_template === 'style09' ||
            $element_template === 'style12' ||
            $element_template === 'style13' ||
            $element_template === 'style15' ||
            $element_template === 'style22' ||
            $element_template === 'style22-alt'
    );
    $widget_utils['lqdsep-utils-mt-4'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style02-alt' ||
            $element_template === 'style05' ||
            $element_template === 'style14' ||
            $element_template === 'style22' ||
            $element_template === 'style22-alt'
    );
    $widget_utils['lqdsep-utils-mt-5'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style02-alt' ||
            $element_template === 'style08'
    );
    $widget_utils['lqdsep-utils-mb-0'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style02-alt' ||
            $element_template === 'style04' ||
            $element_template === 'style05' ||
            $element_template === 'style06' ||
            $element_template === 'style06-alt' ||
            $element_template === 'style07' ||
            $element_template === 'style10' ||
            $element_template === 'style17' ||
            $element_template === 'style22' ||
            $element_template === 'style22-alt' ||
            $element_template === 'style23'
    );
    $widget_utils['lqdsep-utils-mb-1'] = array(
        'conditions' =>
            $element_template === 'style11' ||
            $element_template === 'style12' ||
            $element_template === 'style14'
    );
    $widget_utils['lqdsep-utils-mb-2'] = array(
        'conditions' =>
            $element_template === 'style08' ||
            $element_template === 'style13' ||
            $element_template === 'style14' ||
            $element_template === 'style17' ||
            $element_template === 'style19' ||
            $element_template === 'style20'
    );
    $widget_utils['lqdsep-utils-mb-3'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style03' ||
            $element_template === 'style05' ||
            $element_template === 'style08' ||
            $element_template === 'style09' ||
            $element_template === 'style12' ||
            $element_template === 'style16' ||
            $element_template === 'style19' ||
            $element_template === 'style20' ||
            $element_template === 'style21' ||
            $element_template === 'style21-alt' ||
            $element_template === 'style22' ||
            $element_template === 'style22-alt'
    );
    $widget_utils['lqdsep-utils-mb-4'] = array(
        'conditions' =>
            $element_template === 'style05' ||
            $element_template === 'style07' ||
            $element_template === 'style13' ||
            $element_template === 'style15' ||
            $element_template === 'style18' ||
            $element_template === 'style19' ||
            $element_template === 'style21' ||
            $element_template === 'style21-alt' ||
            $element_template === 'style23'
    );
    $widget_utils['lqdsep-utils-mb-5'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style02-alt' ||
            $element_template === 'style03' ||
            $element_template === 'style05' ||
            $element_template === 'style07' ||
            $element_template === 'style13' ||
            $element_template === 'style16' ||
            $element_template === 'style18' ||
            $element_template === 'style22' ||
            $element_template === 'style22-alt'
    );
    $widget_utils['lqdsep-utils-mb-6'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style07'
    );
    $widget_utils['lqdsep-utils-ms-3'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style02-alt' ||
            $element_template === 'style05' ||
            $element_template === 'style06-alt' ||
            $element_template === 'style07' ||
            $element_template === 'style11'
    );
    $widget_utils['lqdsep-utils-ms-4'] = array(
        'conditions' =>
            $element_template === 'style05' ||
            $element_template === 'style08'
    );
    $widget_utils['lqdsep-utils-border-radius-2'] = array(
        'conditions' =>
            $element_template === 'style01'
    );
    $widget_utils['lqdsep-utils-border-radius-4'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style02-alt' ||
            $element_template === 'style06' ||
            $element_template === 'style06-alt' ||
            $element_template === 'style08' ||
            $element_template === 'style10' ||
            $element_template === 'style11' ||
            $element_template === 'style14' ||
            $element_template === 'style16' ||
            $element_template === 'style17'
    );
    $widget_utils['lqdsep-utils-border-radius-6'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style04' ||
            $element_template === 'style05' ||
            $element_template === 'style07' ||
            $element_template === 'style22' ||
            $element_template === 'style22-alt'
    );
    $widget_utils['lqdsep-utils-border-radius-8'] = array(
        'conditions' =>
            $element_template === 'style09'
    );
    $widget_utils['lqdsep-utils-border-radius-circle'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style02' ||
            $element_template === 'style02-alt' ||
            $element_template === 'style05' ||
            $element_template === 'style06' ||
            $element_template === 'style06-alt' ||
            $element_template === 'style07' ||
            $element_template === 'style08' ||
            $element_template === 'style09' ||
            $element_template === 'style11' ||
            $element_template === 'style12' ||
            $element_template === 'style14' ||
            $element_template === 'style15' ||
            $element_template === 'style23'
    );
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-pos-abs'] = array(
        'conditions' =>
            $element_template === 'style13' ||
            $element_template === 'style19' ||
            $element->get_settings( 'pagination' ) === 'ajax'
    );
    $widget_utils['lqdsep-utils-pos-bl'] = array(
        'conditions' =>
            $element_template === 'style13' ||
            $element_template === 'style19'
    );
    $widget_utils['lqdsep-utils-overlay'] = array();
    $widget_utils['lqdsep-utils-overflow-hidden'] = array(
        'conditions' =>
            $element_template !== 'style03' &&
            $element_template !== 'style04' &&
            $element_template !== 'style12' &&
            $element_template !== 'style13' &&
            $element_template !== 'style15'
    );
    $widget_utils['lqdsep-utils-zindex-2'] = array();
    $widget_utils['lqdsep-utils-zindex-3'] = array();
    $widget_utils['lqdsep-utils-reset-ul'] = array();
    $widget_utils['lqdsep-utils-inline-ul'] = array();
    $widget_utils['lqdsep-utils-text-weight-medium'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style02-alt'
    );
    $widget_utils['lqdsep-utils-text-weight-bold'] = array();
    $widget_utils['lqdsep-utils-text-uppercase'] = array();
    $widget_utils['lqdsep-utils-text-ltrsp-1'] = array();
    $widget_utils['lqdsep-utils-text-start'] = array();
    $widget_utils['lqdsep-utils-text-center'] = array(
        'conditions' =>
            $element->get_settings( 'pagination' ) === 'ajax'
    );
    $widget_utils['lqdsep-utils-text-ws-nowrap'] = array(
        'conditions' =>
            $element->get_settings( 'pagination' ) === 'ajax'
    );
    $widget_utils['lqdsep-utils-objfit-cover'] = array(
        'conditions' =>
            $element_template === 'style10' ||
            $element_template === 'style11'
    );
    $widget_utils['lqdsep-utils-objfit-center'] = array(
        'conditions' =>
            $element_template === 'style10' ||
            $element_template === 'style11'
    );

}