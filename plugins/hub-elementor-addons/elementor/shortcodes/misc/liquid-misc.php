<?php

/**
 * Shortcode Title: Inline Video
 * Shortcode: ld_inline_video
 */
add_shortcode( 'ld_inline_video', 'ld_inline_video' );
function ld_inline_video( $atts ) {

	// override default attributes with user attributes
	extract( shortcode_atts( array(
			'mp4'      => '',
			'style'    => null,
			'controls' => false,
			'height' => '',
			'width'  => '',
	), $atts ));

	// build output
	if( !empty( $width ) ) {
		$width = 'width="' . $width . '"';
	}
	if( !empty( $height ) ) {
		$height = 'height="' . $height . '"';
	}
	if( 'on' == liquid_helper()->get_option( 'enable-lazy-load' ) ) {
		$src = 'data-src="' . esc_url( $mp4 ) . '"';
	}
	else {
		$src = 'src="' . esc_url( $mp4 ) . '"';
	}
	$o = '';
	$o .= '<div class="lqd-inline-video"><video ' . $width . ' ' . $height . ' autoplay loop muted playsinline ';
	if ( $controls ) $o .= 'controls ';
	if( 'on' == liquid_helper()->get_option( 'enable-lazy-load' ) ) {
		$o .= 'class="ld-lazyload"';
	}	
	if ( !empty( $style ) ) 
		$o .= 'style="' . $style . '" ';
	$o .= '><source ' . $src . ' type="video/mp4" />';
	$o .= '<p>Your browser does not support the video element.</p></video></div>';

	// return output
	return $o;
}

/**
 * Shortcode Title: Icon
 * Shortcode: ld_icon
 */
add_shortcode( 'ld_icon', 'ld_sc_icon' );
function ld_sc_icon( $atts, $content = null ) {

	extract( shortcode_atts(array(
		'icon'      => false,
		'container' => false,
		'span'      => false,
		'container_class' => 'icon-container'
    ), $atts ));

	if ( ! $icon ) {
		return '';
	}

	if ( $container ) {
		return sprintf( '<span class="%2$s"><i class="%1$s"></i></span>', ld_helper()->sanitize_html_classes( $icon ), $container_class );
	}

	if ( $span ) {
		return sprintf( '<span class="%1$s"></span>', ld_helper()->sanitize_html_classes( $icon ) );
	} else {
		return sprintf( '<i class="%1$s"></i>', ld_helper()->sanitize_html_classes( $icon ) );
	}

}

/**
 * Shortcode Title: Icon
 * Shortcode: ld_icon
 */
add_shortcode( 'ld_get_cart_total', 'ld_sc_get_cart_total' );
function ld_sc_get_cart_total( $atts, $content = null ) {
	
	$total = '';
	
	if( class_exists( 'WooCommerce' ) ) {
		$total = WC()->cart->get_cart_subtotal();	
	}

	echo $total;
	
}

/**
 * Shortcode Title: Link
 * Shortcode: ld_link
 */
add_shortcode( 'ld_link', 'ld_sc_link' );
function ld_sc_link( $atts, $content = null ) {

	extract( shortcode_atts(array(
		'href'   => '#',
		'class'  => false,
		'target' => false,

    ), $atts ));
	
	if( ! empty( $class ) ) {
		$class = 'class="'. $class .'"';
	}

	if( ! empty( $target ) ) {
		$target = 'target="'. $target .'"';
	}

	return '<a '. $class .' href="'. esc_url( $href ) .'" '. $target .'  >' . do_shortcode( $content ) . '</a>';
}

/**
 * Shortcode Title: Category Title
 * Shortcode: ld_category_title
 */
add_shortcode( 'ld_category_title', 'ld_sc_category_title' );
function ld_sc_category_title( $atts, $content = null ) {
	return single_cat_title( '', false );
}

/**
 * Shortcode Title: Tag Title
 * Shortcode: ld_tag_title
 */
add_shortcode( 'ld_tag_title', 'ld_sc_tag_title' );
function ld_sc_tag_title( $atts, $content = null ) {
	return single_tag_title( '', false );
}

/**
 * Shortcode Title: Author
 * Shortcode: ld_author
 */
add_shortcode( 'ld_author', 'ld_sc_author' );
function ld_sc_author( $atts, $content = null ) {
	return get_the_author();
}

/**
 * Shortcode Title: Share post links
 * Shortcode: ld_share_links
 */
add_shortcode( 'ld_share_links', 'ld_sc_share_links' );
function ld_sc_share_links( $atts, $content = null ) {
	return liquid_portfolio_share( get_post_type(), array(), false );
}

/**
 * Shortcode Title: Typed
 * Shortcode: ld_typed
 */

add_shortcode( 'ld_typed', 'ld_sc_typed' );
function ld_sc_typed( $atts, $content = null ) {

	extract( shortcode_atts(array(

		'words' => false,

	), $atts ));
	
	if ( empty( $words ) ) {
		return;
	}

	$out = '';
	$words = explode( '|', $words );
	
	$out .= '<span class="typed-keywords">';
	$i = 1;
	foreach ( $words as $word ) {
		$active = ( $i == 1 ) ? ' active' : '';
		$out .= '<span class="keyword' . $active . '">' . $word . '</span>';
		$i++;
	}
	$out .= '</span>';
	
	return $out;
	
}

/**
 * Shortcode Title: Typed String
 * Shortcode: ld_string
 */
add_shortcode( 'ld_string', 'ld_sc_string' );
function ld_sc_string( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		
		'words' => false,
		
	), $atts ));

	if ( empty( $words ) ) {
		return;
	}
	
	$out = '';
	$words = explode( '|', $words );
	
	$out .= '<span class="typed-strings">';
	foreach ( $words as $word ) {
		$out .= '<span>' . $word . '</span>';
	}
	$out .= '</span>';

	return $out;	

}


/**
 * Shortcode Title: DropCap
 * Shortcode: ld_dropcap
 */
add_shortcode( 'ld_dropcap', 'ld_sc_dropcap' );
function ld_sc_dropcap( $atts, $content = null ) {

	return '<span class="dropcap">' . esc_html( $content ) . '</span>';
}

/**
 * Shortcode Title: Highlight
 * Shortcode: ld_highlight
 */
add_shortcode( 'ld_highlight', 'ld_sc_highlight' );
function ld_sc_highlight( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'color'          => '',
		'font_size'      => '',
		'letter_spacing' => '',
		'margin'         => '',
		'padding'        => '',
	), $atts ) );
	
	
	$style = '';
	$style_atts = array();
	
	if( !empty( $color ) || !empty( $font_size ) || !empty( $letter_spacing ) || !empty( $margin ) || !empty( $padding ) ) {
		
		$style_atts[] = !empty( $color ) ? 'color:' . $color .';': '';
		$style_atts[] = !empty( $font_size ) ? 'font-size:' . $font_size .';' : '';	
		$style_atts[] = !empty( $letter_spacing ) ? 'letter-spacing:' . $letter_spacing .';' : '';
		$style_atts[] = !empty( $margin ) ? 'margin:' . $margin .';' : '';
		$style_atts[] = !empty( $padding ) ? 'padding:' . $padding .';' : '';
		
		$style = 'style="' . implode( ' ', $style_atts ) . '"';
	}

	return '<mark class="lqd-highlight"><span class="lqd-highlight-txt" ' . $style . ' >' . esc_html( $content ) . '</span><span class="lqd-highlight-inner">' . get_underline_svg() . '</span></mark>';

}


/**
 * Shortcode Title: Span
 * Shortcode: ld_span
 */
add_shortcode( 'ld_span', 'ld_sc_span' );
function ld_sc_span( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'color' => '',
		'opacity' => '',
		'font_size' => '',
		'font_weight' => '',
		'text_decoration' => '',
	), $atts ) );
	
		
	$style = '';
	$style_atts = array();
	
	if( !empty( $color ) || !empty( $text_decoration ) || !empty( $opacity ) || !empty( $font_size ) || !empty( $font_weight ) ) {
		
		$style_atts[] = !empty( $color ) ? 'color:' . $color .';': '';
		$style_atts[] = !empty( $opacity ) ? 'opacity:' . $opacity .';': '';
		$style_atts[] = !empty( $font_size ) ? 'font-size:' . $font_size .';' : '';	
		$style_atts[] = !empty( $font_weight ) ? 'font-weight:' . $font_weight .';' : '';	
		$style_atts[] = !empty( $text_decoration ) ? 'text-decoration:' . $text_decoration .';' : '';	
		
		$style = 'style="' . implode( ' ', $style_atts ) . '"';
	}

	return '<span ' . $style . '>' . esc_html( $content ) . '</span>';
}
/**
 * Shortcode Title: Strong
 * Shortcode: ld_strong
 */
add_shortcode( 'ld_strong', 'ld_sc_strong' );
function ld_sc_strong( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'color' => '',
		'opacity' => '',
		'font_size' => '',
		'font_weight' => '',
		'text_decoration' => '',
	), $atts ) );
	
		
	$style = '';
	$style_atts = array();
	
	if( !empty( $color ) || !empty( $text_decoration ) || !empty( $opacity ) ) {
		
		$style_atts[] = !empty( $color ) ? 'color:' . $color .';': '';
		$style_atts[] = !empty( $opacity ) ? 'opacity:' . $opacity .';': '';
		$style_atts[] = !empty( $font_size ) ? 'font-size:' . $font_size .';' : '';	
		$style_atts[] = !empty( $font_weight ) ? 'font-weight:' . $font_weight .';' : '';	
		$style_atts[] = !empty( $text_decoration ) ? 'text-decoration:' . $text_decoration .';' : '';	
		
		$style = 'style="' . implode( ' ', $style_atts ) . '"';
	}

	return '<strong ' . $style . '>' . esc_html( $content ) . '</strong>';
}

/**
 * Shortcode Title: Span
 * Shortcode: ld_span
 */
add_shortcode( 'ld_small', 'ld_sc_small' );
function ld_sc_small( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'color' => '',
		'opacity' => '',
		'font_size' => '',
		'font_weight' => '',
		'text_decoration' => '',
	), $atts ) );
	
	
	if( ! empty( $color ) ) {
		
		return '<small style="color:' . esc_attr( $color ) . '">' . esc_html( $content ) . '</small>';
	}
	
	return '<small>' . esc_html( $content ) . '</small>';
}

/**
 * Shortcode Title: Break
 * Shortcode: ld_br
 */
add_shortcode( 'ld_br', 'ld_sc_break' );
function ld_sc_break( $atts, $content = null ) {

	return '<br />';
}

//Header Row Shortcode 
add_shortcode( 'ld_header_row', 'ld_header_row_shortcode' );
//add_shortcode( 'ld_header_row_inner', 'ld_header_row_shortcode' );
function ld_header_row_shortcode( $atts, $content ) {

	extract( shortcode_atts( array(

		'header_full_width'   => '',
		'hide_on_sticky'      => '',
		'show_on_sticky'      => '',
		'sticky_bar'          => '',
		'stickybar_placement' => '',
		'fullscreen_nav'      => '',
		'fn_bg'               => '',
		'fn_border_color'     => '',
		'css'                 => '',
		'bg_position'         => '',
		'responsive_css'      => '',
		'row_box_shadow'      => '',
		'custom_border_radius' => '',
		'gradient_bg'         => '',
		'el_id'               => '',
		'el_class'            => '',

	), $atts ) );

	$output = $shadow_box_id = $trigger = $responsive_id = $shadow_css = $responsive_style = $border_radius_style = '';
	$container = 'container';
	
	$wrapper_attributes = array();
	
	if( $header_full_width ) {
		$container = 'container-fluid';
	}
	
	$row_box_shadow = vc_param_group_parse_atts( $row_box_shadow );
	if( !empty( $row_box_shadow ) ) {
		$shadow_box_id = uniqid('liquid-header-shadowbox-');
		$shadow_css    = liquid_get_shadow_css( $row_box_shadow, $shadow_box_id );
	}

	$the_id = $bg_styles = $fn_bg_styles = $fn_border_styles = '';
	if ( ! empty( $el_id ) ) {
		$the_id = 'id="' . esc_attr( $el_id ) . '"';
	}
	
	if( !empty( $fn_bg ) ) {
		$fn_bg_styles = '.navbar-fullscreen .lqd-fsh-bg-side-container span, .navbar-fullscreen .lqd-fsh-bg-col span { background: ' . $fn_bg . ' !important; }';
	}
	if( !empty( $fn_border_color ) ) {
		$fn_border_styles = '.navbar-fullscreen .lqd-fsh-bg-side-container:before, .navbar-fullscreen .lqd-fsh-bg-col:before { background: ' . $fn_border_color . ' !important; }';
	}
	

	if( 'custom' != $bg_position && ! empty( $bg_position ) ) {
		$bg_styles = ' background-position:' . esc_attr( $bg_position ) . ' !important;';
	} 
	elseif( 'custom' === $bg_position ) {
		$bg_styles = ' background-position:' . esc_attr( $bg_pos_h ) . ' ' . esc_attr( $bg_pos_v ) . ' !important; ';
	}

	if( !empty( $gradient_bg ) ) {
		$bg_styles = ' background:' . esc_attr( $gradient_bg ) . '; ';
	}

	if( !empty( $custom_border_radius ) ) {
		$border_radius_style = 'border-radius:' . esc_attr( $custom_border_radius ) . ';';
	}
	
	$wrapper_attributes[] = 'style="' . esc_attr( trim( $bg_styles . $border_radius_style  ) ) . '"';
	
	if( $sticky_bar ) {
		$classes = array(

			'lqd-stickybar-wrap', 
			$stickybar_placement,

			$hide_on_sticky,
			$show_on_sticky,

			$el_class,
			vc_shortcode_custom_css_class( $css ),
			$shadow_box_id
		);
	}
	else {
		$classes = array(
			'lqd-head-sec-wrap', 
			'pos-rel',
			$hide_on_sticky,
			$show_on_sticky,
			$el_class,
			vc_shortcode_custom_css_class( $css ),
			$shadow_box_id
		);
	}
	
	if( !empty( $responsive_css ) ) {
		$responsive_id = uniqid( 'liquid-row-responsive-' );
		$responsive_style = Liquid_Responsive_Css_Editor::generate_css( $responsive_css, $responsive_id );
		$classes[] = $responsive_id;
	}
	
	if( !liquid_helper()->str_contains( 'ld_header_image', $content ) ) {
		
		$src = $retina_src = $retina_logo = $logo = $scrset = '';
		
		$img_array    = liquid_helper()->get_option( 'menu-logo' );
		if( empty( $img_array['url'] ) ) {
			$img_array = liquid_helper()->get_option( 'header-logo' ); 
		}
		$retina_array = liquid_helper()->get_option( 'menu-logo-retina' );
		$src = esc_url( $img_array['url'] );
		
		if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
			$retina_src = esc_url( $retina_array['url'] );
		}
		else {
			$retina_src = '';
		}
		
		if( empty( $src ) ) {
			$src = get_template_directory_uri() . '/assets/img/logo/logo-1.svg';
		}
		
		if( !empty( $retina_src ) ) {
			$scrset	= 'srcset="' . $retina_src . ' 2x"';	
		}
		
		$alt = get_bloginfo( 'title' );
		$image = sprintf( '<img class="mobile-logo-default" src="%s" alt="%s" %s />', $src, $alt, $scrset );
		
	}
	
	if ( !empty( $shadow_css ) || !empty( $responsive_style ) || !empty( $fn_bg_styles ) || !empty( $fn_border_styles ) ) {
		$output .= '<style>' . $shadow_css . ' ' . $responsive_style .' ' . $fn_bg_styles . ' ' . $fn_border_styles . '</style>';
	}
	
	if( $sticky_bar ) {

		$output .= '<div ' . $the_id . ' class="' . join( ' ', $classes ) . '">
						<div class="lqd-stickybar">';
		$output .=					do_shortcode( $content );		
		$output .= '	</div>';
		$output .= '</div>';

		
	}
	elseif( $fullscreen_nav ) {
	
		$output .= '<div class="navbar-fullscreen" id="' . ( !empty( $el_id ) ? $el_id : 'main-header-collapse' ) . '">
						<div class="lqd-fsh-bg">
							<div class="lqd-fsh-bg-side-container lqd-fsh-bg-before-container">
								<span></span>
							</div>
							<div class="container lqd-fsh-bg-container px-0">
								<div class="row lqd-fsh-bg-row mx-0">
									<div class="col-md-3 px-0 lqd-fsh-bg-col">
										<span></span>
									</div>
									<div class="col-md-3 px-0 lqd-fsh-bg-col">
										<span></span>
									</div>
									<div class="col-md-3 px-0 lqd-fsh-bg-col">
										<span></span>
									</div>
									<div class="col-md-3 px-0 lqd-fsh-bg-col">
										<span></span>
									</div>
								</div>
							</div>
							<div class="lqd-fsh-bg-side-container lqd-fsh-bg-after-container">
								<span></span>
							</div>
						</div>
					
						<div class="header-modules-container">
							<div class="container">
								<div class="row">';
			$output .=				do_shortcode( $content );		
			$output .= '		</div>
							</div>
						</div>
					</div>';
				
	
		
	}
	else {
	
		$output .= '<div ' . $the_id . ' class="' . join( ' ', $classes ) . '" ' . implode( ' ', $wrapper_attributes ) . '>
						<div class="' . $container . ' lqd-head-container d-flex flex-wrap align-items-stretch">
							<div class="lqd-head-sec d-flex flex-column w-100">
								<div class="row lqd-head-row d-flex align-items-stretch">';
		$output .=					do_shortcode( $content );
		$output .= '			</div>';
		$output .= '		</div>';
		$output .= '	</div>';
		$output .= '</div>';

	
	}
	
	return $output;
	
}

//Header Columns Shortcode
add_shortcode( 'ld_header_column', 'ld_header_column_shortcode' );
//add_shortcode( 'ld_header_column_inner', 'ld_header_column_shortcode' );
function ld_header_column_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'align'            => '',
		'responsive_align' => '',
		'header_col_width' => 'col',
		'bg_position'      => '',
		'css'              => '',
		'el_id'            => '',
		'el_class'         => '',
	), $atts ) );
	
	$classes = array(
		$header_col_width,
		'lqd-head-col',
		vc_shortcode_custom_css_class( $css ),
		$el_class
	);
	
	$wrapper_attributes = array();
	$the_id = $bg_styles = '';
	if ( ! empty( $el_id ) ) {
		$the_id = 'id="' . esc_attr( $el_id ) . '"';
	}
	
	if( !empty( $align ) ) {
		$classes[] = $align;
	}
	if( !empty( $responsive_align ) ) {
		$classes[] = $responsive_align;
	}
	
	if( 'custom' != $bg_position && ! empty( $bg_position ) ) {
		$bg_styles = ' background-position:' . esc_attr( $bg_position ) . ' !important;';
	} 
	elseif( 'custom' === $bg_position ) {
		$bg_styles = ' background-position:' . esc_attr( $bg_pos_h ) . ' ' . esc_attr( $bg_pos_v ) . ' !important; ';
	}
	
	if( !empty( $bg_styles ) ) {
		$wrapper_attributes[] = 'style="' . esc_attr( trim( $bg_styles  ) ) . '"';
	}
	
	$output = '';
	
	$output .= '<div ' . $the_id . ' class="' . implode( ' ', $classes ) . '" ' . implode( ' ', $wrapper_attributes ) . '>';
	$output .=	do_shortcode( $content );		
	$output .= '</div>';
	
	return $output;
	
}

//Megamenu Columns Shortcode
add_shortcode( 'ld_megamenu_column', 'ld_megamenu_column_shortcode' );
function ld_megamenu_column_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'align'            => '',
		'responsive_align' => '',
		'offset'           => '',
		'width'            => '',
		'css'              => ''
	), $atts ) );

	$width = wpb_translateColumnWidthToSpan( $width );
	$width = vc_column_offset_class_merge( $offset, $width );

	$classes = array(
		'megamenu-column',
		$width,
		vc_shortcode_custom_css_class( $css ),
	);
	
	if( !empty( $align ) ) {
		$classes[] = $align;
	}
	if( !empty( $responsive_align ) ) {
		$classes[] = $responsive_align;
	}
	
	$output = '';
	
	$output .= '<div class="' . implode( ' ', $classes ) . '">';
	$output .=	do_shortcode( $content );		
	$output .= '</div>';
	
	return $output;
	
}

//Megamenu Columns Shortcode
add_shortcode( 'ld_megamenu_row', 'ld_megamenu_row_shortcode' );
function ld_megamenu_row_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'css'              => ''
	), $atts ) );

	$classes = array(
		'vc_row',
		'megamenu-inner-row',
		vc_shortcode_custom_css_class( $css ),
	);
	
	if( !empty( $align ) ) {
		$classes[] = $align;
	}
	if( !empty( $responsive_align ) ) {
		$classes[] = $responsive_align;
	}
	
	$output = '';
	
	$output .= '<div class="' . implode( ' ', $classes ) . '">';
	$output .=	do_shortcode( $content );		
	$output .= '</div>';
	
	return $output;
	
}
function get_underline_svg() {
	return '<svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-1" xmlns="http://www.w3.org/2000/svg" width="235.509" height="13.504" viewBox="0 0 235.509 13.504" aria-hidden="true" preserveAspectRatio="none"><path d="M163,.383a13.044,13.044,0,0,1,1.517-.072,3.528,3.528,0,0,1,1.237-.134q.618.044,1.237.044a.249.249,0,0,1-.1.178.337.337,0,0,0-.1.266q3.092.088,6.184-.044T178.953.4l-.206-.088a12,12,0,0,0,4.123,0,13.467,13.467,0,0,1,5.772,0q1.443-.178,2.68-.266A5.978,5.978,0,0,1,193.8.4,16.707,16.707,0,0,1,198.01.045q2.164.088,4.844.088-.618.088-.824.134L201.412.4a3.893,3.893,0,0,0,2.061,0,5.413,5.413,0,0,1,1.649-.356q.618.088,1.134.178a9.762,9.762,0,0,0,1.544.09,17,17,0,0,1,3.092-.266q1.649,0,3.5.178,2.886.088,5.875.044t5.875-.222q0,.088.206.088h.412a21.975,21.975,0,0,0,2.577.889A12.458,12.458,0,0,1,232.12,2.18a3.962,3.962,0,0,1,1.031.622A3.349,3.349,0,0,1,234.8,3.825a5.079,5.079,0,0,1,.618,1.111q.412.534-1.031.98-1.031.444-.618.98a2.09,2.09,0,0,1,.206.889q0,.444.825.889.618.8-.206,1.245l-1.237.534q-1.443-.088-2.68-.134a17.255,17.255,0,0,1-2.267-.222,3.128,3.128,0,0,0-.928-.044,3.129,3.129,0,0,1-.928-.044q-2.267-.178-4.432-.266T217.7,9.476q-1.649-.088-2.886-.088a17.343,17.343,0,0,1-2.474-.178q-3.916,0-7.73-.088t-7.73-.266l-12.471-.178q-6.287-.088-12.883-.088h-1.958q-.928,0-1.958.088h-2.061q-1.031,0-2.061-.088-2.68-.088-5.256-.134t-5.256.044h-5.462q-2.577,0-5.462.088-4.535.088-8.76.178t-8.554.088q-2.886.088-5.875.088t-5.875.088q-1.443.088-2.886.134t-3.092.044q-4.741.178-9.791.312t-9.791.312q-2.267.088-4.329.088T78.77,10.1q-4.329.266-8.863.49t-9.276.49q-1.237.088-2.68.134a24.356,24.356,0,0,0-2.683.224q-2.68.178-5.462.312t-5.668.4q-2.474.266-4.741.312t-4.741.044q-1.031-.088-1.958-.134a9.684,9.684,0,0,1-1.958-.312,12.5,12.5,0,0,0-1.443-.312q-.825-.134-1.856-.31-2.886.356-6.39.666t-6.8.845a26.709,26.709,0,0,1-2.886.356,20.758,20.758,0,0,1-9.482-.889Q.232,11.962.026,11.25T1.263,9.917q0-.266.825-.266a13.039,13.039,0,0,0,2.886-.444A17.187,17.187,0,0,1,7.86,8.672q3.092-.266,6.184-.8,1.649-.178,3.3-.312t3.5-.312q4.123-.354,8.039-.712t8.039-.622q9.478-.8,18.758-1.338,2.68-.178,5.153-.356t4.741-.356q2.474-.178,5.05-.356T75.88,3.24h1.34a4.829,4.829,0,0,0,1.34-.178q2.267-.178,4.329-.222t4.329-.134a7.256,7.256,0,0,1,2.267,0,3.459,3.459,0,0,0,1.031-.088,6.009,6.009,0,0,1,2.37-.266,14.745,14.745,0,0,0,2.783-.088q1.649,0,2.474.088a1.308,1.308,0,0,1,.185.011,1.226,1.226,0,0,1,.33-.1,3.656,3.656,0,0,0,.515-.088,4.433,4.433,0,0,1,2.886.266q.412-.088,1.031-.178l1.237-.178q.412,0,1.031.044a5.761,5.761,0,0,0,1.237-.044q2.886-.088,5.772-.044a53.829,53.829,0,0,0,5.772-.222,9.505,9.505,0,0,1,1.34-.088h1.34a4.428,4.428,0,0,1,.821-.258l.825-.178a15.178,15.178,0,0,1,1.855.444,3.028,3.028,0,0,1,1.031-.534,4.039,4.039,0,0,1,1.443-.178,6.158,6.158,0,0,1,1.649.178,5.05,5.05,0,0,0,2.267.268q1.855-.088,3.813-.134T138.13,1.2q1.031,0,2.164-.044t2.37-.044q-.206-.088.412-.534h3.092q.412,0,.309.266t.928,0a5.845,5.845,0,0,1,1.443,0,31.833,31.833,0,0,0,5.359.088,21.471,21.471,0,0,1,6.8.178,5.236,5.236,0,0,0,1.031-.4q.412-.222.825-.4a.694.694,0,0,1,.137.07Z" transform="translate(0 0.002)"/></svg><svg class="lqd-highlight-pen" width="51" height="51" viewBox="0 0 51 51" xmlns="http://www.w3.org/2000/svg"><path d="M36.204 1.044C32.02 2.814 5.66 31.155 4.514 35.116c-.632 2.182-1.75 5.516-2.483 7.409-3.024 7.805-1.54 9.29 6.265 6.265 1.893-.733 5.227-1.848 7.41-2.477 3.834-1.105 4.473-1.647 19.175-16.27 0 0 10.63-10.546 15.21-15.125C53 8.997 42.021-1.418 36.203 1.044Zm7.263 5.369c3.56 3.28 4.114 4.749 2.643 6.995l-1.115 1.7-4.586-4.543-4.585-4.544 1.42-1.157C39.311 3.18 40.2 3.4 43.467 6.413ZM37.863 13.3l4.266 4.304-11.547 11.561-11.547 11.561-4.48-4.446-4.481-4.447 11.404-11.418c6.273-6.28 11.566-11.42 11.762-11.42.197 0 2.277 1.938 4.623 4.305ZM12.016 39.03l3.54 3.584-3.562 1.098-5.316 1.641c-1.665.516-1.727.455-1.211-1.21l1.614-5.226c1.289-4.177.685-4.191 4.935.113Z"/></svg><svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-2" width="233" height="13" viewBox="0 0 233 13" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="none"><path d="m.624 9.414-.312-2.48C0 4.454.001 4.454.002 4.454l.035-.005.102-.013.398-.047c.351-.042.872-.102 1.557-.179 1.37-.152 3.401-.368 6.05-.622C13.44 3.081 21.212 2.42 31.13 1.804 50.966.572 79.394-.48 113.797.24c34.387.717 63.927 2.663 84.874 4.429a1048.61 1048.61 0 0 1 24.513 2.34 641.605 641.605 0 0 1 8.243.944l.432.054.149.02-.318 2.479-.319 2.48-.137-.018c-.094-.012-.234-.03-.421-.052a634.593 634.593 0 0 0-8.167-.936 1043.26 1043.26 0 0 0-24.395-2.329c-20.864-1.76-50.296-3.697-84.558-4.413-34.246-.714-62.535.332-82.253 1.556-9.859.612-17.574 1.269-22.82 1.772-2.622.251-4.627.464-5.973.614a213.493 213.493 0 0 0-1.901.22l-.094.01-.028.004Z"/></svg><svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-3" aria-hidden="true" preserveAspectRatio="none" width="198" height="73" viewBox="0 0 198 73" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M2.01552 34.4474C2.47578 34.6889 2.50693 34.5903 2.16023 34.1233C1.43556 33.1192 0.0859359 27.4895 0.559288 27.3889C0.774448 27.3431 0.83309 27.0373 0.700676 26.679C0.568262 26.3208 0.771476 26.0506 1.1747 26.0528C1.57327 26.0764 1.82588 25.8366 1.75995 25.5266C1.69401 25.2165 1.47155 25.0165 1.25248 25.0631C1.0334 25.1097 0.834346 24.9475 0.775482 24.6708C0.716618 24.394 1.10706 24.1678 1.6498 24.1291C2.63867 24.0731 3.05732 22.7635 2.17693 22.4836C1.9012 22.4032 2.06656 22.229 2.5556 22.0964C3.11954 21.9458 3.42557 22.1158 3.39771 22.5664C3.36736 23.0053 3.65609 23.2526 4.12825 23.1992C5.29377 23.075 5.61444 23.5782 4.906 24.424C4.65184 24.7544 4.34369 25.0394 3.99456 25.267C3.82555 25.3183 3.74367 25.5677 3.77733 25.8846C3.7977 26.3381 3.734 26.7915 3.58945 27.2218C3.42894 27.8231 3.39405 28.4509 3.48696 29.0663C3.58253 29.63 3.48825 30.2095 3.21892 30.7139C2.9406 31.0971 2.94306 31.2673 3.24428 31.2032C3.70688 31.1048 4.72117 32.9132 4.80429 33.9913C4.82912 34.3724 5.00368 34.6645 5.16505 34.6302C5.32642 34.5958 5.7821 34.9937 6.1968 35.5689C6.62228 36.1276 6.74531 36.4561 6.50306 36.3216C6.2608 36.187 6.25164 36.5141 6.48173 37.0672C6.71182 37.6204 7.07155 37.8843 7.30909 37.6794C7.54663 37.4745 8.00577 37.6243 8.37519 38.0394C8.7446 38.4546 8.90305 38.7767 8.72016 38.8156C8.55879 38.8499 8.88485 39.1669 9.42779 39.4992C9.9588 39.8151 10.37 40.2982 10.597 40.8728C10.6664 41.0876 10.8047 41.2735 10.9906 41.4017C11.1764 41.5298 11.3994 41.593 11.6248 41.5814C11.9474 41.6377 12.2542 41.7625 12.5244 41.9475C12.7946 42.1326 13.0219 42.3734 13.191 42.6539C13.5597 43.2246 13.9597 43.5719 14.0402 43.3688C14.1348 43.179 14.9022 43.5095 15.7511 44.1171C16.9235 45.0576 18.2163 45.8374 19.5951 46.4358C20.3026 46.7484 20.8941 47.2564 20.9139 47.5609C20.9306 47.8507 21.6753 48.2331 22.5899 48.4096C23.6677 48.6128 24.2941 49.0204 24.4166 49.5964C24.5863 50.3944 24.5433 50.4036 24.0652 49.7948C23.5733 49.1737 23.5264 49.1836 23.6961 49.9817C23.9193 51.0311 24.3702 51.0895 24.8044 50.117C24.9078 49.9458 25.0668 49.8152 25.255 49.7471C25.4431 49.679 25.6489 49.6775 25.838 49.7429C26.531 49.9348 26.5361 50.0115 25.8602 50.5876C25.4219 50.9589 25.2635 51.4301 25.4904 51.7325C25.7644 52.1219 25.9195 52.0583 26.086 51.4668C26.2694 50.887 26.4001 50.8285 26.6297 51.2734C26.8764 51.7464 27.0593 51.7075 27.5656 51.0744C27.9725 50.5554 28.3213 50.4506 28.5763 50.7511C28.8312 51.0297 29.176 51.2096 29.5503 51.2595C30.3668 51.482 31.147 51.8207 31.867 52.2654C32.4737 52.6661 33.1345 52.9782 33.8295 53.1922C35.8327 53.7636 37.7963 54.4657 39.7076 55.294C40.0627 55.4539 40.4483 55.5351 40.8377 55.532C41.5926 55.6364 42.3308 55.8378 43.0342 56.1311C46.6557 57.3817 50.3413 58.4388 54.0752 59.2979C54.2796 59.2544 54.7311 59.4978 55.1775 59.8812C55.624 60.2647 56.0582 60.3737 56.2249 60.1532C56.3917 59.9327 56.8596 60.0183 57.2878 60.3443C57.7159 60.6703 58.1392 60.8583 58.259 60.7868C58.6639 60.7479 59.0724 60.8038 59.4519 60.9502C59.9257 61.1043 60.4246 61.1658 60.9216 61.1314C61.6531 60.9758 63.7635 61.9632 63.5808 62.3731C63.4862 62.5629 63.7368 62.525 64.1249 62.2881C64.967 61.7532 67.7859 62.2659 67.937 62.9759C67.9967 63.2566 68.2276 63.2852 68.4126 63.0445C68.6525 62.7307 68.7594 62.8777 68.721 63.49C68.692 64.2526 68.7769 64.2816 69.2401 63.6576C69.6699 63.0878 70.4171 63.0056 72.5246 63.3455C74.0148 63.5847 75.2012 63.9815 75.1437 64.24C75.1329 64.2982 75.1361 64.3581 75.153 64.4147C75.1699 64.4714 75.2001 64.5232 75.2411 64.5659C75.282 64.6085 75.3326 64.6408 75.3885 64.66C75.4444 64.6792 75.5041 64.6848 75.5626 64.6764C75.8409 64.6632 76.5085 64.6296 77.0577 64.6211C77.6068 64.6127 78.3066 64.5722 78.6356 64.5329C79.2789 64.524 79.9212 64.5841 80.5516 64.7122C81.4985 64.8819 81.8566 65.1911 81.8242 65.8318C81.7854 66.4421 81.889 66.5591 82.1444 66.2268C82.6475 65.579 85.959 64.9371 86.3656 65.4067C86.4511 65.5152 86.5584 65.6046 86.6806 65.6691C86.8027 65.7336 86.9371 65.7718 87.0749 65.7813C87.2995 65.7795 88.1796 65.7937 89.0563 65.7922C89.9727 65.823 90.8557 66.1434 91.5786 66.7074C92.5226 67.6035 93.1018 67.789 92.5291 67C92.3234 66.7197 92.6558 66.4323 93.3443 66.2859C93.9898 66.1486 94.5534 66.2608 94.6131 66.5415C94.6697 66.8075 95.2086 66.9096 95.7723 66.758C97.0616 66.4225 101.054 66.793 101.151 67.2497C101.195 67.457 102.013 67.4987 103.012 67.3477C104.01 67.1967 104.966 67.2867 105.158 67.5555C105.336 67.8111 106.016 67.8844 106.665 67.7135C107.258 67.5487 107.887 67.5713 108.467 67.7781C108.909 67.9854 109.397 68.0782 109.885 68.0479C112.431 67.6694 115.008 67.5507 117.578 67.6935C118.601 67.8213 119.632 67.8601 120.662 67.8096C121.483 67.7586 122.81 67.7084 123.566 67.7174C125.899 67.7465 133.92 67.4462 136.632 67.2406C138.042 67.145 139.624 67.0366 140.173 67.0281C140.723 67.0197 142.563 66.8439 144.276 66.6503C145.989 66.4567 148.72 66.1837 150.331 66.0423C152.472 65.8364 154.601 65.5229 156.71 65.1028C158.02 64.7423 159.384 64.6198 160.737 64.7411C160.898 64.8286 161.086 64.8501 161.263 64.8012C161.439 64.7522 161.589 64.6366 161.682 64.4788C161.873 64.1601 164.294 63.3825 167.074 62.7606C168.909 62.433 170.706 61.9213 172.439 61.2332C172.616 61.0104 172.834 61.2421 172.944 61.7595C173.123 62.6015 173.166 62.5924 173.43 61.7175C173.642 61.0232 174.531 60.4949 176.437 59.8891C177.459 59.6281 178.446 59.2466 179.378 58.7526C180.024 58.3283 180.724 57.9924 181.459 57.7538C182.508 57.3607 183.504 56.8374 184.422 56.1964C185.283 55.535 185.702 55.4458 186.242 55.8707C186.815 56.2896 186.884 56.2453 186.58 55.6599C186.147 54.8411 187.679 53.586 188.529 54.04C188.797 54.1876 188.852 54.0796 188.654 53.7814C188.338 53.3538 189.823 52.0342 190.545 52.0974C190.716 52.1071 190.785 51.9072 190.72 51.5972C190.704 51.5274 190.703 51.4552 190.716 51.385C190.729 51.3148 190.757 51.2481 190.797 51.1889C190.837 51.1297 190.889 51.0793 190.949 51.0409C191.009 51.0025 191.077 50.9768 191.147 50.9654C191.825 50.8213 193.319 47.4297 193.648 45.2744C194.298 41.1199 191.318 36.5943 184.205 30.9084C183.488 30.3353 182.994 29.6522 183.105 29.3812C183.223 29.0932 183.182 29.058 182.982 29.2836C182.809 29.4748 180.918 28.6718 178.837 27.5073C177.591 26.9064 176.421 26.1602 175.351 25.2843C175.546 25.2427 174.36 24.6455 172.691 23.9343C171.411 23.4152 170.17 22.8068 168.975 22.1137C168.651 21.8497 168.256 21.685 167.84 21.6396C167.398 21.6959 166.95 21.6014 166.569 21.3714C166.187 21.1415 165.894 20.7895 165.738 20.3725C165.625 19.8404 165.339 19.7157 164.882 19.9983C164.674 20.1102 164.435 20.1493 164.202 20.1093C163.97 20.0693 163.757 19.9525 163.598 19.7776C163.263 19.4165 162.887 19.3156 162.704 19.5355C162.52 19.7554 162.007 19.5907 161.467 19.1648C160.926 18.739 160.564 18.5687 160.608 18.776C160.65 18.9716 160.222 18.9193 159.696 18.6633C159.161 18.4214 158.56 18.2916 158.402 18.3977C158.245 18.5037 157.921 18.1443 157.691 17.5911C157.437 16.9806 157.084 16.747 156.796 16.978C156.226 17.4703 152.17 16.5869 152.032 15.9365C151.978 15.6852 151.665 15.536 151.321 15.6093C150.686 15.7443 145.726 14.5748 143.393 13.7574C142.191 13.382 140.965 13.0906 139.722 12.8852C138.15 12.6327 137.289 12.2292 137.179 11.7119C137.054 11.1251 136.882 11.0593 136.496 11.5176C135.922 12.1806 125.958 10.3446 124.792 9.35764C124.009 8.69001 123.626 8.6786 124.102 9.33486C124.307 9.61514 124.176 9.73617 123.794 9.63237C123.412 9.52856 123.181 9.23721 123.239 8.97864C123.289 8.73583 123.026 8.71727 122.666 8.93069C122.068 9.28997 118.527 8.97692 116.534 8.38166C116.135 8.26348 115.721 8.20578 115.305 8.21049C112.808 8.30931 99.8959 6.49821 99.4183 5.99767C99.0798 5.62193 98.7673 5.58005 98.7055 5.87123C98.5979 6.32652 96.1061 6.28505 86.0379 5.63053C84.7716 5.54513 73.6532 5.50444 65.8819 5.5462C65.2189 5.54818 63.1165 5.65592 61.1525 5.77923C59.1884 5.90254 57.2121 5.96815 56.718 5.91886C54.6288 6.04988 52.5476 6.28778 50.4827 6.63164C47.5472 7.05152 44.7804 7.36599 44.3334 7.32613C42.6128 7.16663 25.8045 11.1431 21.4751 12.7284C17.1146 14.3355 16.9521 14.3548 16.565 13.4333C16.2509 12.6966 15.9689 12.5869 15.2898 12.9889C15.1696 13.0774 15.0325 13.14 14.8869 13.1728C14.7414 13.2057 14.5906 13.208 14.4441 13.1798C14.2976 13.1515 14.1585 13.0932 14.0357 13.0085C13.9128 12.9238 13.8088 12.8147 13.7302 12.6878C13.1443 11.9947 13.1347 11.9497 13.7167 12.4127C14.274 12.8656 14.4722 12.7927 14.8686 12.0133C15.8626 10.0252 27.7222 5.72632 35.0839 4.68607C35.3453 4.64583 35.7251 5.16304 35.8796 5.78341C36.1539 6.91494 36.1647 6.91265 36.1848 5.57948C36.2104 4.43116 36.2654 4.37244 36.5225 5.24493C36.7851 6.16226 36.8152 6.14052 36.8037 4.98069C36.7979 4.26635 36.9261 3.81178 37.0821 3.96363C39.3031 3.87683 41.5125 3.59814 43.6855 3.13067C51.0682 1.83856 50.1603 1.95804 55.2788 1.54516C64.3348 0.824345 67.6766 0.622705 68.271 0.774321C69.3049 0.830904 70.3419 0.781627 71.3658 0.627257C72.3124 0.457587 73.2785 0.424245 74.2346 0.528242C74.8495 0.681042 75.4868 0.723424 76.1165 0.653413C76.8783 0.599373 77.6427 0.591449 78.4054 0.629692C78.864 0.67118 80.3191 0.639758 81.6972 0.563382C82.764 0.419993 83.8496 0.578682 84.8307 1.02142C85.1644 1.32152 85.5938 1.38455 85.7295 1.12364C85.8652 0.862742 88.0846 0.777115 90.6421 0.958983C93.1867 1.13336 97.0388 1.37518 99.1675 1.49696C104.25 1.7603 116.16 3.1986 117.539 3.70681C118.165 3.93644 118.826 4.05696 119.493 4.06311C121.269 4.00934 125.365 4.86887 125.462 5.32657C125.522 5.60726 125.678 5.65185 125.844 5.43038C126.144 5.04256 130.388 5.69987 130.845 6.20694C131.06 6.39529 131.333 6.5057 131.62 6.5205C135.384 6.77084 136.141 6.94911 137.095 7.75017C137.682 8.23859 138.068 8.36098 137.999 8.03628C137.93 7.71158 138.115 7.57911 138.43 7.74001C138.739 7.90538 139.078 8.00708 139.427 8.0391C142.822 8.63915 146.171 9.47525 149.45 10.5413C149.618 10.6652 149.81 10.7534 150.013 10.8005C150.216 10.8476 150.427 10.8526 150.633 10.8152C151.265 10.8411 151.864 11.1057 152.308 11.5557C152.84 12.0448 153.237 12.2229 153.181 11.9569C153.124 11.6909 153.791 11.8118 154.637 12.2493C155.331 12.5278 155.924 13.0106 156.337 13.6337C156.419 14.018 156.523 13.9805 156.626 13.5109C156.756 12.9579 157.229 12.981 158.762 13.6128C159.589 13.975 160.445 14.2682 161.321 14.4895C161.485 14.5127 161.643 14.5695 161.785 14.6564C161.926 14.7432 162.048 14.8582 162.144 14.9942C162.225 15.123 162.344 15.2236 162.484 15.2823C162.625 15.341 162.78 15.3548 162.929 15.322C163.23 15.2579 163.428 15.4479 163.374 15.7221C163.312 16.0133 163.578 16.0497 163.97 15.8274C164.361 15.6052 164.73 15.6503 164.793 15.9457C164.856 16.241 165.15 16.3022 165.42 16.0904C165.687 15.864 165.984 15.9398 166.05 16.2499C166.119 16.5746 165.989 16.8648 165.774 16.9106C165.559 16.9563 165.52 17.1966 165.715 17.4792C165.91 17.7618 166.282 17.7133 166.611 17.3663C166.752 17.2127 166.926 17.0923 167.119 17.0137C167.312 16.9351 167.521 16.9003 167.729 16.9119C168.105 16.9864 168.046 17.2922 167.564 17.8272C167.153 18.275 166.888 18.8377 166.805 19.4401C166.79 20.0567 166.895 20.023 167.232 19.2257C167.982 17.5214 169.644 17.2447 171.053 18.5827C171.532 19.0369 172.096 19.2564 172.247 19.0698C172.417 18.864 172.607 18.9627 172.673 19.2727C172.739 19.5827 172.939 19.6791 173.121 19.4555C173.29 19.2497 173.488 19.3314 173.554 19.6414C173.62 19.9515 173.802 20.0671 173.942 19.8828C174.086 19.7132 174.644 19.9033 175.135 20.309C176.869 21.7322 178.975 22.8748 179.599 22.7421C179.806 22.729 180.012 22.7806 180.188 22.8896C180.365 22.9986 180.503 23.1597 180.583 23.3506C180.79 23.7391 181.095 23.9062 181.254 23.7027C181.432 23.4799 181.737 23.7543 182.001 24.3615C182.252 24.9574 182.561 25.2464 182.738 25.0227C182.896 24.8041 184.546 25.7504 186.386 27.109C189.931 29.7531 192.963 33.0231 195.332 36.7578C196.413 38.7216 197.581 42.3658 197.258 42.8045C197.147 43.3124 197.208 43.8429 197.433 44.312C197.981 45.831 196.722 50.8582 195.754 51.0641C195.558 51.1232 195.391 51.2541 195.287 51.4309C195.182 51.6077 195.149 51.8173 195.192 52.0178C195.194 52.3304 195.129 52.6399 195.002 52.9254C194.875 53.211 194.688 53.466 194.454 53.6734C193.941 54.17 193.501 54.7367 193.148 55.3568C193.079 55.5519 192.948 55.7194 192.776 55.834C192.603 55.9486 192.399 56.0042 192.192 55.9924C191.895 55.9166 191.663 56.0436 191.71 56.2646C191.908 57.1957 186.504 60.8629 184.002 61.4726C183.438 61.6232 183.099 61.8813 183.243 62.0817C183.387 62.2822 182.909 62.57 182.177 62.7256C181.445 62.8811 180.752 62.8437 180.608 62.6423C180.477 62.4532 180.491 62.6212 180.634 62.9761C180.841 63.4727 180.607 63.6461 179.72 63.6499C179.046 63.6542 178.573 63.8631 178.627 64.1144C178.677 64.3511 177.863 64.6479 176.776 64.7707C175.689 64.8936 174.77 65.2279 174.698 65.5195C174.625 65.811 172.575 66.4821 170.135 67.0151C167.696 67.5482 164.58 68.2274 163.217 68.5326C160.09 69.2129 147.087 71.3138 144.715 71.5251C143.754 71.6058 141.962 71.6935 140.769 71.7153C139.584 71.7504 138.236 71.8216 137.813 71.8808C135.225 72.2461 131.702 72.1765 131.617 71.7775C131.61 71.7182 131.592 71.661 131.562 71.6092C131.532 71.5574 131.492 71.5121 131.445 71.476C131.397 71.4399 131.343 71.4138 131.285 71.3992C131.227 71.3846 131.167 71.3819 131.108 71.3911C130.893 71.4369 130.885 71.7166 131.101 71.9946C131.352 72.3277 131.202 72.468 130.712 72.3841C128.928 72.2122 127.133 72.1908 125.346 72.3201C123.371 72.513 121.386 72.574 119.403 72.5026C118 72.3744 116.592 72.318 115.184 72.3337C113.631 72.3574 112.079 72.2693 110.54 72.0701C109.719 71.785 108.853 71.6549 107.984 71.6865C106.732 71.6134 106.408 71.3573 106.184 70.3079C106.039 69.6233 105.778 69.1892 105.627 69.3768C105.557 69.6038 105.533 69.8424 105.557 70.0787C105.58 70.315 105.65 70.5443 105.762 70.7535C106.255 71.9622 105.716 72.2312 104.797 71.2369C104.642 71.0569 104.447 70.915 104.229 70.8222C104.01 70.7294 103.773 70.6881 103.536 70.7016C103.069 70.8316 103.126 70.9431 103.769 71.1631C104.759 71.4933 104.118 71.8452 103.055 71.5623C102.504 71.4015 102.428 71.201 102.672 70.5009C102.917 69.8008 102.824 69.7734 102.105 70.374C101.534 70.819 100.846 71.0889 100.124 71.1512C99.4919 71.1926 98.5118 71.2896 97.8929 71.3936C96.9335 71.5353 96.7807 71.3981 96.6925 70.2434C96.6447 69.538 96.4688 69.0857 96.325 69.2553C96.1625 69.5675 96.1193 69.928 96.2033 70.2697C96.2851 70.6541 95.9696 70.9685 95.459 70.9994C94.9913 71.0212 94.3486 71.0659 94.0873 71.1061C93.8121 71.134 93.5775 70.9825 93.5659 70.7693C93.4503 69.697 93.163 69.4034 92.99 70.1762C92.8271 70.8907 92.7088 70.9158 91.9522 70.3192C91.645 70.113 91.2937 69.9815 90.9266 69.9353C90.5594 69.8892 90.1866 69.9296 89.8379 70.0534C88.9093 70.2705 87.9397 70.2368 87.0284 69.9557C86.5318 69.7631 86.0131 69.633 85.4843 69.5686C85.5315 69.7906 82.311 69.6107 81.4559 69.3438C80.986 69.1964 79.4771 68.8692 78.1084 68.6195C76.9935 68.4719 75.9244 68.0825 74.9758 67.4784C74.6297 67.1196 74.3862 67.0324 74.4459 67.3131C74.6032 68.0524 71.088 68.0732 69.3771 67.3249C68.6343 67.0045 67.9836 66.9057 67.8853 67.1311C67.7908 67.3209 67.641 67.1984 67.5755 66.8903C67.5031 66.5499 67.027 66.3732 66.4891 66.4876C65.2734 66.7461 59.976 65.6637 59.6604 65.098C59.5455 64.8751 58.9776 64.7955 58.3644 64.9259C57.7512 65.0563 57.1394 64.982 56.9685 64.7598C56.556 64.4569 56.0609 64.2872 55.5494 64.2734C54.7385 64.183 53.937 64.0228 53.1537 63.7944C52.5841 63.6127 52.0019 63.4731 51.4119 63.3767C50.4041 63.1392 49.4105 62.845 48.4358 62.4957C47.0694 62.0452 44.321 61.1771 42.4093 60.5952C40.49 60.0302 38.8518 59.3595 38.8015 59.1228C38.7543 58.9008 38.4553 58.764 38.1434 58.8304C38.0032 58.8645 37.8552 58.8441 37.7295 58.7733C37.6038 58.7025 37.5097 58.5865 37.4663 58.449C37.4066 58.1683 37.1586 58.1126 36.8812 58.3413C36.3478 58.7942 34.0011 57.5943 34.1413 56.9317C34.1857 56.7178 33.8571 56.6528 33.4038 56.7952C32.5514 57.0695 28.3664 55.5798 27.9772 54.8601C27.8484 54.6248 27.6607 54.588 27.5123 54.7893C27.3792 54.9566 27.224 54.5439 27.1668 53.9049C27.1096 53.2659 27.0257 52.9771 26.9843 53.311C26.8668 54.2008 24.7161 53.8547 24.4934 52.9136C24.3992 52.4705 23.9928 52.3045 23.5146 52.488C22.9633 52.6982 22.6302 52.5064 22.4768 51.8909C22.322 51.3217 22.217 51.251 22.1898 51.7046C22.1647 52.221 21.7035 52.1146 20.5844 51.3662C20.0155 50.9235 19.3702 50.5888 18.6806 50.3788C18.4977 50.4177 17.7986 49.9326 17.1914 49.3513C16.5843 48.77 15.9211 48.4009 15.7849 48.5536C15.6487 48.7062 14.8855 48.1315 14.1222 47.2389C13.363 46.3658 12.5382 45.6601 12.2984 45.6957C11.6207 45.8399 9.5306 44.2604 9.36732 43.4927C9.33933 43.3219 9.24905 43.1675 9.11391 43.0594C8.97877 42.9512 8.80837 42.897 8.63559 42.9072C8.28822 42.9657 8.00778 42.5459 7.91701 41.8548C7.80054 40.937 7.61992 40.7751 7.03751 41.084C6.64 41.2769 6.35291 41.2296 6.417 40.9686C6.48188 40.6921 6.01007 40.1126 5.35729 39.634C4.27596 38.8755 3.55542 37.8235 4.43209 38.2974C4.62174 38.3961 4.73138 38.1714 4.65296 37.8027C4.64231 37.7179 4.61364 37.6363 4.56887 37.5634C4.5241 37.4906 4.46428 37.4281 4.39341 37.3803C4.32254 37.3324 4.24225 37.3003 4.15794 37.286C4.07363 37.2717 3.98724 37.2756 3.90456 37.2974C3.56654 37.4 3.22542 37.1178 3.12495 36.6454C2.93378 36.0218 2.60824 35.4476 2.17123 34.9633C1.5425 34.2853 1.5097 34.184 2.01552 34.4474ZM125.821 7.86924C125.713 7.89212 125.599 8.14845 125.536 8.48593C125.469 8.80678 125.582 9.01701 125.818 8.96668C126.055 8.91634 126.169 8.66002 126.106 8.36466C126.04 8.05464 125.929 7.84636 125.821 7.86924ZM157.795 15.2342C156.991 14.8184 156.969 14.8385 157.415 15.6706C157.625 16.0738 157.949 16.2217 158.112 15.9856C158.309 15.7271 158.2 15.4568 157.795 15.2342ZM158.43 14.0954C158.204 14.1434 158.072 14.2644 158.104 14.4121C158.207 14.6215 158.382 14.7871 158.596 14.8787C158.849 15.01 158.989 14.873 158.923 14.562C158.856 14.251 158.643 14.05 158.428 14.0958L158.43 14.0954ZM160.296 15.6601C160.212 15.7807 160.155 15.9176 160.127 16.0619C160.1 16.2061 160.103 16.3546 160.137 16.4975C160.199 16.7909 160.37 16.959 160.563 16.9178C160.757 16.8767 160.825 16.5066 160.737 16.0929C160.649 15.6792 160.442 15.4748 160.29 15.6614L160.296 15.6601ZM177.025 22.5749C176.328 21.7808 175.984 21.5912 176.082 22.0499C176.305 22.368 176.596 22.6332 176.933 22.8267C177.663 23.3347 177.668 23.3031 177.019 22.5764L177.025 22.5749ZM107.077 70.755C107.34 70.884 107.484 70.7461 107.418 70.4351C107.348 70.1094 107.137 69.9081 106.907 69.957C106.677 70.0058 106.553 70.1407 106.581 70.2737C106.679 70.4896 106.853 70.6616 107.07 70.7565L107.077 70.755ZM74.7299 66.1732C74.8445 66.2437 74.9798 66.2728 75.1133 66.2556C75.2468 66.2383 75.3703 66.1759 75.4632 66.0786C75.7407 65.8499 75.6294 65.7498 75.1713 65.8166C74.7719 65.8709 74.5604 66.0395 74.7241 66.1744L74.7299 66.1732ZM35.5765 57.5853C36.0094 58.4051 36.4087 57.9031 36.3754 56.5353C36.3589 55.6116 36.2689 55.5541 35.7971 56.1952C35.6433 56.3881 35.5421 56.6175 35.5034 56.8612C35.4648 57.1048 35.4899 57.3543 35.5765 57.5853V57.5853ZM17.3373 46.2689C17.7043 45.7738 17.6284 45.6815 16.937 45.8286C16.4744 45.927 16.1267 46.2483 16.1864 46.529C16.3237 47.1601 16.7432 47.0709 17.3373 46.2689ZM12.3394 44.9224C12.4999 45.0426 12.6554 44.7162 12.6714 44.1567C12.713 43.3914 12.6522 43.3266 12.3857 43.924C12.1946 44.347 12.175 44.7836 12.3386 44.9185L12.3394 44.9224ZM1.48174 28.2895C1.61974 28.238 1.74129 28.1502 1.83362 28.0354C1.92595 27.9206 1.98565 27.783 2.00643 27.6372C2.07321 27.453 2.18575 27.2889 2.33345 27.1602C2.48115 27.0315 2.65917 26.9425 2.85074 26.9015C3.34561 26.7963 3.45664 26.5253 3.17921 26.0139C2.67944 25.0386 2.41866 25.1871 1.71094 26.8823C1.35902 27.7125 1.26658 28.3353 1.48174 28.2895ZM14.9726 14.5304C14.9067 14.2204 13.0512 14.5373 11.6191 15.1046C11.3488 15.2081 11.2308 15.682 11.3563 16.195C11.5633 17.0628 11.5848 17.0583 11.7696 16.0765C11.9276 15.2864 12.1162 15.1686 12.6331 15.5371C13.1534 15.9212 13.2576 15.8827 13.1445 15.3506C13.0344 14.8333 13.126 14.7831 13.542 15.1577C14.0991 15.6577 15.1172 15.2101 14.9724 14.5295L14.9726 14.5304ZM10.0679 17.1642C9.83777 16.611 9.58648 16.1697 9.50042 16.188C9.41435 16.2063 9.45048 16.6934 9.57299 17.2694C9.6955 17.8455 9.94367 18.2721 10.1373 18.2309C10.331 18.1897 10.3028 17.7163 10.0679 17.1642V17.1642ZM90.653 70.387C90.7562 70.5965 90.9311 70.762 91.1458 70.8536C91.3986 70.9849 91.5382 70.8479 91.472 70.5369C91.4059 70.2259 91.1944 70.0245 90.9792 70.0703C90.764 70.116 90.6234 70.243 90.6538 70.3858L90.653 70.387Z"/> </svg><svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-4" aria-hidden="true" preserveAspectRatio="none" width="136" height="16" viewBox="0 0 136 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M36.937 3.319C37.8108 3.27525 38.6865 3.35706 39.5371 3.56198C40.3102 3.74109 40.9877 4.20428 41.4352 4.85965C41.8828 5.51502 42.0676 6.31472 41.9531 7.10001C41.8869 7.83996 41.7186 8.5672 41.4531 9.26102C41.2001 9.91102 41.439 10.016 42.028 9.94901C44.594 9.65601 47.1281 9.19202 49.6721 8.74002C60.1611 6.87302 70.715 5.464 81.29 4.189C93.69 2.689 106.155 1.81201 118.596 0.71701C123.274 0.30501 127.959 0.0339836 132.656 0.00198364C133.231 0.00198364 133.807 0.0539822 134.383 0.0879822C134.76 0.110982 135.136 0.197999 135.154 0.654999C135.171 1.065 134.813 1.17902 134.487 1.26102C132.487 1.76102 130.459 2.09401 128.428 2.42001C121.567 3.52001 114.645 4.10298 107.745 4.87698C100.078 5.73765 92.4117 6.58869 84.7451 7.43002C76.6701 8.33002 68.6071 9.32999 60.5681 10.507C55.4091 11.264 50.2611 12.097 45.1061 12.884C43.7246 13.1186 42.3224 13.2104 40.9221 13.158C40.4991 13.1938 40.074 13.123 39.6855 12.9521C39.297 12.7811 38.9574 12.5154 38.6982 12.1793C38.4389 11.8432 38.2681 11.4475 38.2014 11.0284C38.1346 10.6092 38.1741 10.18 38.3161 9.78C38.4911 8.948 38.644 8.108 38.882 7.293C39.12 6.478 38.7271 6.26602 38.0331 6.21902C36.5228 6.14716 35.0092 6.26201 33.527 6.561C24.1073 8.16425 14.8703 10.6997 5.95209 14.13C4.73009 14.613 3.5521 15.206 2.3581 15.762C1.9581 15.948 1.57112 16.081 1.23212 15.7C1.08506 15.5325 1.00071 15.3192 0.993593 15.0965C0.986479 14.8737 1.05698 14.6555 1.19306 14.479C1.54614 13.9517 2.0137 13.5111 2.56098 13.19C5.02189 11.6317 7.67039 10.3915 10.4431 9.49899C18.455 6.70599 26.7164 4.68875 35.114 3.47501C35.743 3.38201 36.377 3.366 36.937 3.319Z"/> </svg><svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-5" aria-hidden="true" preserveAspectRatio="none" width="102" height="11" viewBox="0 0 102 11" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M38.449 3.99298C39.7937 3.40715 41.2115 3.00645 42.6639 2.80194C46.4444 2.35238 50.2637 2.332 54.0489 2.74102C62.1929 3.42202 70.2009 5.00203 78.2239 6.47003C84.3759 7.59603 90.505 8.84394 96.647 10.0259C97.7084 10.2479 98.7895 10.3603 99.8738 10.361C100.182 10.3521 100.49 10.3216 100.794 10.27C101.069 10.227 101.32 10.1009 101.361 9.79693C101.407 9.45493 101.061 9.53194 100.894 9.45294C98.5 8.47686 96.0235 7.71756 93.494 7.18402C86.604 5.25302 79.533 4.21597 72.512 2.93097C67.533 2.01997 62.543 1.15894 57.512 0.608945C52.7749 -0.0377262 47.98 -0.149748 43.2178 0.27496C40.4234 0.479879 37.7365 1.43634 35.441 3.04303C35.3299 3.1135 35.2049 3.15894 35.0745 3.17621C34.9441 3.19347 34.8114 3.18213 34.6859 3.143C28.2142 2.15437 21.669 1.72974 15.1238 1.87396C10.9846 1.95518 6.87755 2.61973 2.92389 3.84796C2.08151 4.11969 1.27843 4.50066 0.534978 4.98101C0.215978 5.19001 -0.139946 5.42504 0.0630542 5.88104C0.266054 6.33704 0.69899 6.32296 1.09699 6.19696C3.03281 5.57759 5.00733 5.08686 7.00788 4.72796C12.0709 3.87671 17.2154 3.61326 22.3389 3.94293C25.9819 4.14293 29.615 4.44296 33.233 4.92596C33.825 5.00496 34.212 5.105 34.223 5.862C34.2578 6.25207 34.3855 6.62811 34.5955 6.95868C34.8055 7.28924 35.0917 7.56473 35.43 7.76202C36.7813 8.75095 38.4314 9.24515 40.1038 9.16192C40.4951 9.18625 40.8845 9.09155 41.2208 8.89019C41.5571 8.68884 41.8245 8.39033 41.9879 8.03399C42.1247 7.66786 42.1526 7.26994 42.0679 6.88836C41.9833 6.50679 41.7899 6.1579 41.5111 5.88397C40.9197 5.22115 40.1802 4.70723 39.3528 4.38397C39.1078 4.27197 38.868 4.17198 38.449 3.99298ZM39.5699 6.95099C38.422 6.93626 37.3262 6.46903 36.5208 5.65094C37.636 5.79826 38.6898 6.24786 39.5679 6.95099H39.5699Z"/> </svg>';
}