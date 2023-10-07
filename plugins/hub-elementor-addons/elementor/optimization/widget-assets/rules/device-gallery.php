<?php
 if (
   $element_name === 'ld_device_gallery_laptop' ||
   $element_name === 'ld_device_gallery_mobile'
  ) {

  $widget_utils['lqdsep-utils-w-100'] = array();
  $widget_utils['lqdsep-utils-h-100'] = array();
  $widget_utils['lqdsep-utils-pos-rel'] = array();
  $widget_utils['lqdsep-utils-pos-abs'] = array();
  $widget_utils['lqdsep-utils-overlay'] = array();
  $widget_utils['lqdsep-utils-overflow-hidden'] = array();
  $widget_utils['lqdsep-utils-objfit-cover'] = array();
  $widget_utils['lqdsep-utils-objfit-center'] = array();

}

if ( $element_name === 'ld_device_gallery_mobile' ) {

 $widget_utils['lqdsep-utils-zindex--1'] = array(
  'conditions' =>
    $element->get_settings('shadow_type') !== ''
 );
 $widget_utils['lqdsep-utils-zindex-2'] = array();
 $widget_utils['lqdsep-utils-zindex-3'] = array();
 $widget_utils['lqdsep-utils-pointer-events-none'] = array();

}