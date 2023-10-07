<?php 

defined( 'ABSPATH' ) || die();

class LD_Testimonial_Template_Handler {

    function ld_testi_get_classes( $style ) {

        $hash = array(
            'style01' => 'lqd-testi-style-1 d-flex flex-column-reverse lqd-testi-card lqd-testi-shadow-xs lqd-testi-details-lg lqd-testi-quote-18 lqd-testi-avatar-72',
            'style02' => 'lqd-testi-style-2 d-flex flex-column lqd-testi-card lqd-testi-shadow-none lqd-testi-details-sm lqd-testi-quote-18 lqd-testi-avatar-60 lqd-testi-bubble-all',
            'style03' => 'lqd-testi-style-3 d-flex flex-column lqd-testi-card lqd-testi-shadow-xs lqd-testi-quote-21 lqd-testi-avatar-60',
            'style04' => 'lqd-testi-style-4 d-flex flex-row-reverse lqd-testi-card lqd-testi-shadow-xxl lqd-testi-quote-15 lqd-testi-avatar-65',
            'style05' => 'lqd-testi-style-5 d-flex flex-column lqd-testi-card lqd-testi-details-sm lqd-testi-quote-22 lqd-testi-avatar-48',
            'style06' => 'lqd-testi-style-6 d-flex flex-column lqd-testi-card lqd-testi-details-sm lqd-testi-quote-21 lqd-testi-avatar-48 pt-6 pb-6 text-center',
            'style07' => 'lqd-testi-style-7 d-flex flex-wrap lqd-testi-card lqd-testi-card-nospace lqd-testi-shadow-lg lqd-testi-quote-21',
            'style08' => 'lqd-testi-style-8 d-flex flex-column-reverse lqd-testi-card lqd-testi-shadow-none lqd-testi-details-sm lqd-testi-quote-16 lqd-testi-avatar-48',
            'style09' => 'lqd-testi-style-9 d-flex flex-column-reverse lqd-testi-brd border-radius-4 lqd-testi-details-sm lqd-testi-quote-16 lqd-testi-avatar-48',
            'style10' => 'lqd-testi-style-10 d-flex flex-column lqd-testi-card lqd-testi-shadow-none lqd-testi-details-sm lqd-testi-quote-18 lqd-testi-avatar-65 text-center',
            'style11' => 'lqd-testi-style-11 d-flex flex-column lqd-testi-card lqd-testi-shadow-sm lqd-testi-details-sm lqd-testi-quote-18 lqd-testi-avatar-48 text-center',
            'style12' => 'lqd-testi-style-12 lqd-testi-quote-18 lqd-testi-avatar-65',
            'style13' => 'lqd-testi-style-13 d-flex flex-wrap lqd-testi-details-sm lqd-testi-quote-25 lqd-testi-avatar-72',
            'style14' => 'lqd-testi-style-14 d-flex flex-column-reverse lqd-testi-details-xl lqd-testi-quote-22 lqd-testi-avatar-90',
            'style15' => 'lqd-testi-style-15 d-flex flex-wrap lqd-testi-bubble border-radius-4 lqd-testi-details-lg lqd-testi-quote-25',
            'style16' => 'lqd-testi-style-16 d-flex flex-wrap lqd-testi-card lqd-testi-card-nospace lqd-testi-shadow-xl lqd-testi-quote-27',
            'style17' => 'lqd-testi-style-17 lqd-testi-avatar-85 lqd-testi-details-sm lqd-testi-quote-16 text-center lqd-testi-bubble-alt',
            'style18' => 'lqd-testi-style-18 pt-6 pb-4 lqd-testi-shadow-sm2 lqd-testi-details-sm lqd-testi-quote-18 lqd-testi-avatar-68 text-center',
            'style19' => 'lqd-testi-style-19 d-flex flex-column lqd-testi-card lqd-testi-shadow-sm lqd-testi-details-same lqd-testi-details-inline lqd-testi-quote-18 lqd-testi-avatar-60',
        );

        return isset( $hash[ $style ] ) ? $hash[ $style ] : 'testimonial';
    }

    function ld_testi_get_quote( $quote ) {

        // check
        if( empty( $quote ) ) {
            return '';
        }
        $content = ld_helper()->do_the_content( $quote );

        // Default
        $content = sprintf( '<blockquote>%s</blockquote>', $content );

        echo $content;

    }

    function ld_testi_get_avatar( $classnames, $style, $avatar, $title ) {

        // check
        if( empty( $avatar['url'] ) ) {
            return '';
        }

        $alt = $title;
        $out = '';


        if( preg_match( '/^\d+$/', $avatar['url'] ) ){
            
            if( 'style07' === $style || 'style16' === $style ) {
                $out = wp_get_attachment_image( $avatar['id'], 'full', false, array( 'alt' => esc_html( $alt ), 'class' => 'w-100 h-100 flex-grow-1 objfit-cover objpos-center' ) );	
            }
            else {
                $out = wp_get_attachment_image( $avatar['id'], 'full', false, array( 'alt' => esc_html( $alt ) ) );	
            }
            // check
            if( ! $out ) {
                return;
            }
        } else {
            $out = esc_url( $avatar['url'] );
            if( 'style07' === $style || 'style16' === $style ) {
                $out = sprintf( '<img class="w-100 h-100 flex-grow-1 objfit-cover objpos-center" src="%s" alt="%s" />', $out, esc_html( $alt ) );
            }
            else {
                // Default
                $out = sprintf( '<img class="border-radius-circle" src="%s" alt="%s" />', $out, esc_html( $alt ) );
            }
        }

        if( 'style07' === $style || 'style16' === $style ) {
            $out = sprintf( '<figure class="lqd-testi-avatar d-flex w-100 m-0">%s</figure>', $out );
        }
        else {
            // Default
            $out = sprintf( '<figure class="lqd-testi-avatar %s">%s</figure>', $classnames, $out );
        }


        echo $out;
    }

    function ld_testi_get_name( $tag = 'h3', $classes = null, $title = '' ) {

        $name = $title;
        if( empty( $name ) ) {
            return;
        }
        $classnames = '';
        if( !empty( $classes ) ) {
            $classnames = 'class="' . $classes . '"';
        }

        printf( '<%1$s %3$s>%2$s</%1$s>', $tag, esc_html( $name ), $classnames );
    }

    function ld_testi_get_position( $tag = 'h4', $classes = null, $position = '' ) {

        if( empty( $position ) ) {
            return;
        }

        if( !empty( $classes ) ) {
            $classes = 'class="' . $classes . '"';
        }		

        printf( '<%1$s %3$s>%2$s</%1$s>', $tag, esc_html( $position ), $classes );

    }

    function ld_testi_get_social_icon( $network ) {

        // check
        if( empty( $network ) ) {
            return '';
        }		
        $net = $this->ld_testi_get_network_class( $network );

        printf( '<div class="lqd-testi-social-icon">%s</div>', $net['icon'] );

    }

    function ld_testi_get_network_class( $network ) {

        $hash = array(	
            'fa-amazon' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M257.2 162.7c-48.7 1.8-169.5 15.5-169.5 117.5 0 109.5 138.3 114 183.5 43.2 6.5 10.2 35.4 37.5 45.3 46.8l56.8-56S341 288.9 341 261.4V114.3C341 89 316.5 32 228.7 32 140.7 32 94 87 94 136.3l73.5 6.8c16.3-49.5 54.2-49.5 54.2-49.5 40.7-.1 35.5 29.8 35.5 69.1zm0 86.8c0 80-84.2 68-84.2 17.2 0-47.2 50.5-56.7 84.2-57.8v40.6zm136 163.5c-7.7 10-70 67-174.5 67S34.2 408.5 9.7 379c-6.8-7.7 1-11.3 5.5-8.3C88.5 415.2 203 488.5 387.7 401c7.5-3.7 13.3 2 5.5 12zm39.8 2.2c-6.5 15.8-16 26.8-21.2 31-5.5 4.5-9.5 2.7-6.5-3.8s19.3-46.5 12.7-55c-6.5-8.3-37-4.3-48-3.2-10.8 1-13 2-14-.3-2.3-5.7 21.7-15.5 37.5-17.5 15.7-1.8 41-.8 46 5.7 3.7 5.1 0 27.1-6.5 43.1z"/></svg>',
                'text' => 'Amazon'
            ),
            'fa-facebook' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg>',
                'text' => 'Facebook'
            ),
            'fa-twitter' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>',
                'text' => 'Twitter'
            ),
            'fa-youtube' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/></svg>',
                'text' => 'Youtube Play'
            ),
            'fa-instagram' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>',
                'text' => 'Instagram'
            ),
            'fa-vimeo' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M447.8 153.6c-2 43.6-32.4 103.3-91.4 179.1-60.9 79.2-112.4 118.8-154.6 118.8-26.1 0-48.2-24.1-66.3-72.3C100.3 250 85.3 174.3 56.2 174.3c-3.4 0-15.1 7.1-35.2 21.1L0 168.2c51.6-45.3 100.9-95.7 131.8-98.5 34.9-3.4 56.3 20.5 64.4 71.5 28.7 181.5 41.4 208.9 93.6 126.7 18.7-29.6 28.8-52.1 30.2-67.6 4.8-45.9-35.8-42.8-63.3-31 22-72.1 64.1-107.1 126.2-105.1 45.8 1.2 67.5 31.1 64.9 89.4z"/></svg>',
                'text' => 'Vimeo'
            ),
            'fa-linkedin' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg>',
                'text' => 'Linkedin'
            ),
            'fa-github' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"/></svg>',
                'text' => 'Github'
            ),
            'fa-dribbble' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M256 8C119.252 8 8 119.252 8 256s111.252 248 248 248 248-111.252 248-248S392.748 8 256 8zm163.97 114.366c29.503 36.046 47.369 81.957 47.835 131.955-6.984-1.477-77.018-15.682-147.502-6.818-5.752-14.041-11.181-26.393-18.617-41.614 78.321-31.977 113.818-77.482 118.284-83.523zM396.421 97.87c-3.81 5.427-35.697 48.286-111.021 76.519-34.712-63.776-73.185-116.168-79.04-124.008 67.176-16.193 137.966 1.27 190.061 47.489zm-230.48-33.25c5.585 7.659 43.438 60.116 78.537 122.509-99.087 26.313-186.36 25.934-195.834 25.809C62.38 147.205 106.678 92.573 165.941 64.62zM44.17 256.323c0-2.166.043-4.322.108-6.473 9.268.19 111.92 1.513 217.706-30.146 6.064 11.868 11.857 23.915 17.174 35.949-76.599 21.575-146.194 83.527-180.531 142.306C64.794 360.405 44.17 310.73 44.17 256.323zm81.807 167.113c22.127-45.233 82.178-103.622 167.579-132.756 29.74 77.283 42.039 142.053 45.189 160.638-68.112 29.013-150.015 21.053-212.768-27.882zm248.38 8.489c-2.171-12.886-13.446-74.897-41.152-151.033 66.38-10.626 124.7 6.768 131.947 9.055-9.442 58.941-43.273 109.844-90.795 141.978z"/></svg>',
                'text' => 'Dribbble'
            ),
            'fa-skype' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M424.7 299.8c2.9-14 4.7-28.9 4.7-43.8 0-113.5-91.9-205.3-205.3-205.3-14.9 0-29.7 1.7-43.8 4.7C161.3 40.7 137.7 32 112 32 50.2 32 0 82.2 0 144c0 25.7 8.7 49.3 23.3 68.2-2.9 14-4.7 28.9-4.7 43.8 0 113.5 91.9 205.3 205.3 205.3 14.9 0 29.7-1.7 43.8-4.7 19 14.6 42.6 23.3 68.2 23.3 61.8 0 112-50.2 112-112 .1-25.6-8.6-49.2-23.2-68.1zm-194.6 91.5c-65.6 0-120.5-29.2-120.5-65 0-16 9-30.6 29.5-30.6 31.2 0 34.1 44.9 88.1 44.9 25.7 0 42.3-11.4 42.3-26.3 0-18.7-16-21.6-42-28-62.5-15.4-117.8-22-117.8-87.2 0-59.2 58.6-81.1 109.1-81.1 55.1 0 110.8 21.9 110.8 55.4 0 16.9-11.4 31.8-30.3 31.8-28.3 0-29.2-33.5-75-33.5-25.7 0-42 7-42 22.5 0 19.8 20.8 21.8 69.1 33 41.4 9.3 90.7 26.8 90.7 77.6 0 59.1-57.1 86.5-112 86.5z"/></svg>',
                'text' => 'Skype'
            ),
            'fa-medium' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M71.5 142.3c.6-5.9-1.7-11.8-6.1-15.8L20.3 72.1V64h140.2l108.4 237.7L364.2 64h133.7v8.1l-38.6 37c-3.3 2.5-5 6.7-4.3 10.8v272c-.7 4.1 1 8.3 4.3 10.8l37.7 37v8.1H307.3v-8.1l39.1-37.9c3.8-3.8 3.8-5 3.8-10.8V171.2L241.5 447.1h-14.7L100.4 171.2v184.9c-1.1 7.8 1.5 15.6 7 21.2l50.8 61.6v8.1h-144v-8L65 377.3c5.4-5.6 7.9-13.5 6.5-21.2V142.3z"/></svg>',
                'text' => 'Medium'
            ),
            'fa-reddit' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M440.3 203.5c-15 0-28.2 6.2-37.9 15.9-35.7-24.7-83.8-40.6-137.1-42.3L293 52.3l88.2 19.8c0 21.6 17.6 39.2 39.2 39.2 22 0 39.7-18.1 39.7-39.7s-17.6-39.7-39.7-39.7c-15.4 0-28.7 9.3-35.3 22l-97.4-21.6c-4.9-1.3-9.7 2.2-11 7.1L246.3 177c-52.9 2.2-100.5 18.1-136.3 42.8-9.7-10.1-23.4-16.3-38.4-16.3-55.6 0-73.8 74.6-22.9 100.1-1.8 7.9-2.6 16.3-2.6 24.7 0 83.8 94.4 151.7 210.3 151.7 116.4 0 210.8-67.9 210.8-151.7 0-8.4-.9-17.2-3.1-25.1 49.9-25.6 31.5-99.7-23.8-99.7zM129.4 308.9c0-22 17.6-39.7 39.7-39.7 21.6 0 39.2 17.6 39.2 39.7 0 21.6-17.6 39.2-39.2 39.2-22 .1-39.7-17.6-39.7-39.2zm214.3 93.5c-36.4 36.4-139.1 36.4-175.5 0-4-3.5-4-9.7 0-13.7 3.5-3.5 9.7-3.5 13.2 0 27.8 28.5 120 29 149 0 3.5-3.5 9.7-3.5 13.2 0 4.1 4 4.1 10.2.1 13.7zm-.8-54.2c-21.6 0-39.2-17.6-39.2-39.2 0-22 17.6-39.7 39.2-39.7 22 0 39.7 17.6 39.7 39.7-.1 21.5-17.7 39.2-39.7 39.2z"/></svg>',
                'text' => 'Reddit'
            ),
            'fa-slack' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M94.12 315.1c0 25.9-21.16 47.06-47.06 47.06S0 341 0 315.1c0-25.9 21.16-47.06 47.06-47.06h47.06v47.06zm23.72 0c0-25.9 21.16-47.06 47.06-47.06s47.06 21.16 47.06 47.06v117.84c0 25.9-21.16 47.06-47.06 47.06s-47.06-21.16-47.06-47.06V315.1zm47.06-188.98c-25.9 0-47.06-21.16-47.06-47.06S139 32 164.9 32s47.06 21.16 47.06 47.06v47.06H164.9zm0 23.72c25.9 0 47.06 21.16 47.06 47.06s-21.16 47.06-47.06 47.06H47.06C21.16 243.96 0 222.8 0 196.9s21.16-47.06 47.06-47.06H164.9zm188.98 47.06c0-25.9 21.16-47.06 47.06-47.06 25.9 0 47.06 21.16 47.06 47.06s-21.16 47.06-47.06 47.06h-47.06V196.9zm-23.72 0c0 25.9-21.16 47.06-47.06 47.06-25.9 0-47.06-21.16-47.06-47.06V79.06c0-25.9 21.16-47.06 47.06-47.06 25.9 0 47.06 21.16 47.06 47.06V196.9zM283.1 385.88c25.9 0 47.06 21.16 47.06 47.06 0 25.9-21.16 47.06-47.06 47.06-25.9 0-47.06-21.16-47.06-47.06v-47.06h47.06zm0-23.72c-25.9 0-47.06-21.16-47.06-47.06 0-25.9 21.16-47.06 47.06-47.06h117.84c25.9 0 47.06 21.16 47.06 47.06 0 25.9-21.16 47.06-47.06 47.06H283.1z"/></svg>',
                'text' => 'Slack'
            ),
            'fa-stack-overflow' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M290.7 311L95 269.7 86.8 309l195.7 41zm51-87L188.2 95.7l-25.5 30.8 153.5 128.3zm-31.2 39.7L129.2 179l-16.7 36.5L293.7 300zM262 32l-32 24 119.3 160.3 32-24zm20.5 328h-200v39.7h200zm39.7 80H42.7V320h-40v160h359.5V320h-40z"/></svg>',
                'text' => 'Stack Overflow'
            ),
            'fa-telegram' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M446.7 98.6l-67.6 318.8c-5.1 22.5-18.4 28.1-37.3 17.5l-103-75.9-49.7 47.8c-5.5 5.5-10.1 10.1-20.7 10.1l7.4-104.9 190.9-172.5c8.3-7.4-1.8-11.5-12.9-4.1L117.8 284 16.2 252.2c-22.1-6.9-22.5-22.1 4.6-32.7L418.2 66.4c18.4-6.9 34.5 4.1 28.5 32.2z"/></svg>',
                'text' => 'Telegram'
            ),
            'fa-tiktok' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/></svg>',
                'text' => 'TikTok'
            ),
            'fa-whatsapp' => array(
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>',
                'text' => 'Whatsapp'
            ),
            
        );

        return $hash[ $network ];
    }

    function ld_testi_get_rating( $class = null, $rating = array() ) {

        $out = '';
        $rating = $rating['size'];
        if( empty( $rating ) ) {
            return;
        }

        $active = '';

        $out .= '<ul class="lqd-star-rating ' . $class . '">';
        for( $i = 1; $i <= 5; $i++ ) {
            if( $i <= $rating ) {
                $active = ' active';
            }
            else {
                $active = '';
            }
            $out .= '<li><svg class="' . $active . '" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg></li> ';
        }
        $out .= '</ul>';

        echo $out;
    }

    function ld_testi_get_time( $class = null, $time = null ) {	

        if( empty( $time ) ) {
            return;
        }

        if( ! empty( $class ) ) {
            $class = 'class="lqd-testi-time ' . $class . '"';
        }
        else {
            $class = 'class="lqd-testi-time"';
        }

        printf( '<span %1$s>%2$s</span>', $class,  esc_html( $time ) );

    }

    function ld_testi_get_image( $classnames, $image, $title ) {

        // check
        if( empty( $image ) ) {
            return '';
        }

        $out = '';

        $alt = $title;

        if( preg_match( '/^\d+$/', $image['url'] ) ){

            $out = wp_get_attachment_image( $image['id'], 'full', false, array( 'alt' => esc_html( $alt ) ) );
            // check

            if( ! $out ) {
                return;
            }
        } else {
            $out = sprintf( '<img src="%s" alt="%s" />', esc_url( $image['url'] ), esc_html( $alt ) );
        }

        // Default
        $out = sprintf( '<figure>%s</figure>', $out );

        echo $out;
    }

    function testimonials_template( $style, $quote, $avatar, $title, $position, $rating, $network, $time, $image ){

        $classes = array( 
            'lqd-testi',
            'pos-rel',
            $this->ld_testi_get_classes( $style ), 
        );

        switch ($style){
            case 'style01':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-quote mb-1">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info d-flex flex-wrap justify-content-between mb-3">

                        <div class="lqd-testi-details d-flex align-items-center">
                            <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden', $style, $avatar, $title) ?>
                            <div class="lqd-testi-np ps-4">
                                <?php $this->ld_testi_get_name( 'h3', null, $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', 'font-weight-light', $position ) ?>
                            </div>

                        </div>

                    </div>

                </div>
            <?php
            break;

            case 'style02':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-quote mb-4">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info d-flex flex-column flex-wrap justify-content-between">
                        <?php $this->ld_testi_get_rating( 'mb-5', $rating ) ?>

                        <div class="lqd-testi-details d-flex align-items-center">
                            <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden', $style, $avatar, $title) ?>
                            <div class="lqd-testi-np ps-4">
                                <?php $this->ld_testi_get_name( 'h3', null, $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', null, $position ) ?>
                            </div>

                        </div>

                    </div>

                </div>
            <?php
            break;
            
            case 'style03':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-quote mb-6 pb-6">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info d-flex flex-wrap align-items-center justify-content-between">

                        <div class="lqd-testi-details d-flex align-items-center">
                            <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                            <div class="lqd-testi-np ps-4">
                                <?php $this->ld_testi_get_name( 'h3', null, $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', null, $position ) ?>
                            </div>

                        </div>

                        <?php $this->ld_testi_get_social_icon( $network ); ?>

                    </div>

                </div>
            <?php
            break;
            
            case 'style04':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="d-flex flex-column flex-grow-1 ps-4">

                        <div class="lqd-testi-info d-flex flex-wrap align-items-center justify-content-between mb-2">
                            <div class="lqd-testi-np">
                                <?php $this->ld_testi_get_name( 'h3', 'font-weight-medium', $title ) ?>
                            </div>
                            <?php $this->ld_testi_get_social_icon( $network ); ?>	
                        </div>

                        <div class="lqd-testi-quote mb-1">
                            <?php $this->ld_testi_get_quote( $quote ); ?>
                        </div>

                        <div class="lqd-testi-details d-flex align-items-center">
                            <?php $this->ld_testi_get_time( 'font-weight-medium', $time ); ?>
                            <?php $this->ld_testi_get_rating( 'mt-2', $rating ); ?>
                        </div>

                    </div>

                    <div class="lqd-testi-details d-flex align-items-center">
                        <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                    </div>

                </div>
            <?php
            break;
            
            case 'style05':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-extra mb-3">
                        <?php $this->ld_testi_get_image( null, $image, $title ) ?>
                    </div>

                    <div class="lqd-testi-quote mb-4">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info d-flex flex-column flex-wrap justify-content-between">

                        <?php $this->ld_testi_get_rating( 'mb-6', $rating ) ?>
                        <div class="lqd-testi-details d-flex align-items-center">
                            <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                            <div class="lqd-testi-np ps-4">
                                <?php $this->ld_testi_get_name( 'h3', $classes = null, $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', $classes = null, $position ) ?>
                            </div>

                        </div>

                    </div>

                </div>
            <?php
            break;
            
            case 'style06':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-quote w-80 mx-auto mb-6 pt-3 pb-2">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info d-flex flex-wrap justify-content-center pb-3">
                        <div class="lqd-testi-details d-flex align-items-center">
                            <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                            <div class="lqd-testi-np ps-4">
                                <?php $this->ld_testi_get_name( 'h3', null, $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', null, $position ) ?>
                            </div>
                        </div>
                    </div>

                </div>
            <?php
            break;
            
            case 'style07':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                <div class="lqd-testi-details d-flex w-40">
                    <?php $this->ld_testi_get_avatar( null, $style, $avatar, $title ); ?>
                </div>

                <div class="d-flex flex-column justify-content-center w-60 pt-5 pb-5 ps-6 pe-6">

                    <div class="lqd-testi-quote mb-5">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info d-flex flex-wrap align-items-center justify-content-between">

                        <div class="lqd-testi-details d-flex align-items-center">

                            <div class="lqd-testi-np">
                                <?php $this->ld_testi_get_name( 'h3', null, $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', null, $position ) ?>
                            </div>

                        </div>

                        <?php $this->ld_testi_get_social_icon( $network ); ?>

                    </div>

                </div>

                </div>
            <?php
            break;
            
            case 'style08':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-quote mb-1">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info d-flex flex-wrap align-items-center justify-content-between mb-4">

                        <div class="lqd-testi-details d-flex align-items-center">
                            <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                            <div class="lqd-testi-np ps-4">
                                <?php $this->ld_testi_get_name( 'h3', 'font-weight-medium', $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', null, $position ) ?>
                            </div>
                        </div>

                        <?php $this->ld_testi_get_social_icon( $network ); ?>

                    </div>

                </div>
            <?php
            break;
            
            case 'style09':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-quote mb-1 p-4">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                        <?php $this->ld_testi_get_rating( 'mt-4', $rating ) ?>
                    </div>

                    <div class="lqd-testi-info d-flex flex-wrap ps-4 pe-4 pt-3 pb-3">

                        <div class="lqd-testi-details d-flex flex-wrap flex-row-reverse align-items-center justify-content-between w-100">
                            <?php $this->ld_testi_get_avatar( 'ms-0 me-0 border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                            <div class="lqd-testi-np">
                                <?php $this->ld_testi_get_name( 'h3', 'font-weight-medium', $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', null, $position ) ?>
                            </div>

                        </div>

                    </div>

                </div>
            <?php
            break;
            
            case 'style10':
            ?>

                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-extra mt-2 mb-4">

                        <svg class="lqd-testi-quote-icon lqd-testi-quote-icon-flip" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="24"/>
                            <path d="M33.6506355,22.4458786 C34.1870129,24.3649793 34.1999448,26.4569702 33.6852534,28.1856729 C33.115054,30.1017893 31.9414302,31.3977692 30.3804449,31.8340732 C29.9875127,31.9440942 29.5828423,32 29.177575,32 C27.1880449,32 25.4239286,30.6602504 24.8875513,28.7425424 C24.2258336,26.3757974 25.612536,23.9115654 27.9796789,23.2492508 C29.0289571,22.9569888 30.1876594,23.0682036 31.158948,23.5488741 C31.1277124,23.417963 31.0952831,23.2924236 31.0610632,23.1696696 C30.1958165,20.0761493 28.4985484,18.684274 27.5698357,18.684274 L27.5288514,18.6850698 C27.3503906,18.6932269 27.1786941,18.5728603 27.1289559,18.3947974 L26.6134686,16.5509009 C26.5830288,16.4426704 26.5999398,16.3268798 26.6598247,16.2315813 C26.7199085,16.1368797 26.8169976,16.0716231 26.9280133,16.0521257 C27.1237831,16.0175079 27.3247256,16 27.5258671,16 C30.0300887,16 32.6063312,18.7111327 33.6506355,22.4458786 Z M17.2027923,16.0003979 C19.7076107,16.0003979 22.2834553,18.7111327 23.3283565,22.4454807 C23.8649328,24.3647803 23.8776658,26.4569702 23.3631733,28.1856729 C22.792775,30.1017893 21.6191512,31.3977692 20.0583649,31.8340732 C19.6652337,31.9440942 19.2605633,32 18.855296,32 C16.8657659,32 15.1016496,30.6602504 14.5652723,28.7425424 C13.9031566,26.3757974 15.290257,23.9115654 17.657002,23.2492508 C18.7062802,22.9569888 19.8645846,23.0682036 20.8362711,23.5488741 C20.8052345,23.4187588 20.7728051,23.2932194 20.7383862,23.1696696 C19.8731396,20.0761493 18.1756725,18.684274 17.2469599,18.684274 L17.2063735,18.6850698 C17.0247294,18.6932269 16.8562162,18.5728603 16.8064779,18.3947974 L16.2907917,16.5509009 C16.2605509,16.4426704 16.2774619,16.3268798 16.3373467,16.2315813 C16.3972316,16.1368797 16.4945196,16.0712252 16.6053364,16.0521257 C16.8009072,16.0175079 17.0020487,16.0003979 17.2027923,16.0003979 Z"/>
                        </svg>

                    </div>

                    <div class="lqd-testi-quote mb-6">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info mb-1">

                        <div class="lqd-testi-details d-flex flex-column align-items-center">
                            <?php $this->ld_testi_get_avatar( 'ms-0 me-0 border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                            <div class="lqd-testi-np mt-2">
                                <?php $this->ld_testi_get_name( 'h3', 'font-weight-medium', $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', null, $position ) ?>
                            </div>

                        </div>

                    </div>

                </div>

            <?php
            break;
            
            case 'style11':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-extra mt-3 mb-5">
                        <?php $this->ld_testi_get_rating( null, $rating ) ?>
                    </div>

                    <div class="lqd-testi-quote mb-6 pb-2">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info mb-1">

                        <div class="lqd-testi-details d-flex flex-column align-items-center">
                            <?php $this->ld_testi_get_avatar( 'ms-0 me-0 border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                            <div class="lqd-testi-np mt-2">
                                <?php $this->ld_testi_get_name( 'h3', 'font-weight-medium', $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', null, $position ) ?>
                            </div>

                        </div>

                    </div>

                </div>
            <?php
            break;
            
            case 'style12':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="d-flex flex-wrap">

                        <div class="lqd-testi-left-sec w-10">
                        
                            <div class="lqd-testi-extra mt-2">
                                <svg class="lqd-testi-quote-icon" xmlns="http://www.w3.org/2000/svg" width="38" height="29" viewBox="0 0 38 29">
                                    <path fill="#348EF5" d="M54.5068359,11.9578125 C49.6617596,14.3406369 47.2392578,17.1404136 47.2392578,20.3572266 C49.3043723,20.595509 51.0120375,21.4394133 52.3623047,22.8889648 C53.7125719,24.3385164 54.3876953,26.0163967 54.3876953,27.9226563 C54.3876953,29.948057 53.7324284,31.6557222 52.421875,33.0457031 C51.1113216,34.435684 49.4632261,35.1306641 47.4775391,35.1306641 C45.2535696,35.1306641 43.3274821,34.22719 41.6992188,32.4202148 C40.0709554,30.6132397 39.2568359,28.4190884 39.2568359,25.8376953 C39.2568359,18.093516 43.5855687,12.0372614 52.2431641,7.66875 L54.5068359,11.9578125 Z M32.7041016,11.9578125 C27.8193115,14.3406369 25.3769531,17.1404136 25.3769531,20.3572266 C27.4817814,20.595509 29.2093031,21.4394133 30.5595703,22.8889648 C31.9098375,24.3385164 32.5849609,26.0163967 32.5849609,27.9226563 C32.5849609,29.948057 31.9197658,31.6557222 30.5893555,33.0457031 C29.2589452,34.435684 27.6009214,35.1306641 25.6152344,35.1306641 C23.3912649,35.1306641 21.4751057,34.22719 19.8666992,32.4202148 C18.2582927,30.6132397 17.4541016,28.4190884 17.4541016,25.8376953 C17.4541016,18.093516 21.7629777,12.0372614 30.3808594,7.66875 L32.7041016,11.9578125 Z" transform="translate(-17 -7)"/>
                                </svg>
                            </div>

                        </div>

                        <div class="lqd-testi-right-sec w-90 ps-5 pe-5">

                            <div class="d-flex flex-column flex-grow-1">
                        
                                <div class="lqd-testi-quote mb-5">
                                    <?php $this->ld_testi_get_quote( $quote ); ?>
                                </div>
                        
                            </div>
                        
                            <div class="lqd-testi-details d-flex align-items-center">
                                <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                                <div class="lqd-testi-np ps-4">
                                    <?php $this->ld_testi_get_name( 'h3', null, $title ) ?>
                                    <?php $this->ld_testi_get_position( 'h4', null, $position ) ?>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            <?php
            break;
            
            case 'style13':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-quote mb-4">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info w-100">

                        <div class="lqd-testi-details d-flex align-items-center">
                            <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                            <div class="lqd-testi-np ps-4">
                                <?php $this->ld_testi_get_name( 'h3','font-weight-medium', $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4','font-weight-light', $position ) ?>
                            </div>

                        </div>

                    </div>

                </div>
            <?php
            break;
            
            case 'style14':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-quote mb-0">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info mb-5">

                        <div class="lqd-testi-details d-flex align-items-center">
                            <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                            <div class="lqd-testi-np ps-4">
                                <?php $this->ld_testi_get_name( 'h3', 'font-weight-medium', $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', 'font-weight-light', $position) ?>
                            </div>

                        </div>

                    </div>

                </div>
            <?php
            break;
            
            case 'style15':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-inner p-6">

                        <div class="lqd-testi-quote mb-4">
                            <?php $this->ld_testi_get_quote( $quote ); ?>
                        </div>

                        <div class="lqd-testi-info">

                            <div class="lqd-testi-details d-flex align-items-center">

                                <div class="lqd-testi-np">
                                    <?php $this->ld_testi_get_name( 'h3', 'font-weight-medium', $title) ?>
                                    <?php $this->ld_testi_get_position( 'h4', 'font-weight-light', $position ) ?>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            <?php
            break;
            
            case 'style16':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-side lqd-testi-left lqd-testi-details d-flex w-100">
                        <?php $this->ld_testi_get_avatar( null, $style, $avatar, $title ); ?>
                    </div>

                    <div class="lqd-testi-side lqd-testi-right d-flex flex-column justify-content-center w-100 p-5">

                        <div class="lqd-testi-extra mb-2">
                            <svg class="lqd-testi-quote-icon-gradient" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="150" height="131" viewBox="0 0 281.155 245.956">
                                <defs>
                                    <linearGradient id="testi-icon-gradient" x1="0.5" x2="0.5" y2="1" gradientUnits="objectBoundingBox">
                                        <stop offset="0" stop-color="#e5e9f2" stop-opacity="0.243" />
                                        <stop offset="1" stop-color="#737579" stop-opacity="0" />
                                    </linearGradient>
                                </defs>
                                <path d="M0-37.9v-70.289q0-57.659,26.358-95.549,27.457-38.988,80.173-53.266a12.548,12.548,0,0,1,11.257,2.2,12.28,12.28,0,0,1,5.217,10.433v18.67a12.849,12.849,0,0,1-2.471,7.413,11.344,11.344,0,0,1-6.315,4.668Q57.11-192.758,57.11-134.55H96.647a25.419,25.419,0,0,1,18.67,7.688,25.419,25.419,0,0,1,7.688,18.67V-37.9a25.419,25.419,0,0,1-7.688,18.67,25.419,25.419,0,0,1-18.67,7.688H26.358a25.419,25.419,0,0,1-18.67-7.688A25.419,25.419,0,0,1,0-37.9ZM184.508-11.545H254.8a25.419,25.419,0,0,0,18.67-7.688,25.419,25.419,0,0,0,7.688-18.67v-70.289a25.419,25.419,0,0,0-7.688-18.67,25.419,25.419,0,0,0-18.67-7.688H215.259q0-58.208,57.11-79.075a11.344,11.344,0,0,0,6.315-4.668,12.849,12.849,0,0,0,2.471-7.413v-18.67a12.28,12.28,0,0,0-5.217-10.433,12.548,12.548,0,0,0-11.257-2.2q-52.717,14.277-80.173,53.266-26.358,37.89-26.358,95.549V-37.9a25.419,25.419,0,0,0,7.688,18.67A25.419,25.419,0,0,0,184.508-11.545Z" transform="translate(0 257.5)" fill="url(#testi-icon-gradient)" />
                            </svg>
                        </div>

                        <div class="lqd-testi-quote mb-3">
                            <?php $this->ld_testi_get_quote( $quote ); ?>
                        </div>
                        
                        <div class="lqd-testi-info mb-5">
                            <div class="lqd-testi-details d-flex align-items-center">
                                <div class="lqd-testi-np">
                                    <?php $this->ld_testi_get_name( 'h3', 'font-weight-medium', $title) ?>
                                    <?php $this->ld_testi_get_position( 'h4', 'font-weight-regular', $position ) ?>
                                </div>
                            </div>
                        </div>

                        <div class="lqd-testi-extra">
                            <?php $this->ld_testi_get_image( null, $image, $title ); ?>
                        </div>
                        
                    </div>

                </div>
            <?php
            break;
            
            case 'style17':
            ?>
                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-quote pos-rel p-6">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-details d-flex flex-column align-items-center mt-6">

                        <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden ms-0 me-0', $style, $avatar, $title ); ?>
                        <div class="lqd-testi-np mt-2">
                            <?php $this->ld_testi_get_name( 'h3', 'font-weight-bold', $title ) ?>
                            <?php $this->ld_testi_get_position( 'h4', 'font-weight-bold text-uppercase ltr-sp-1', $position ) ?>
                        </div>

                    </div>

                </div>
            <?php
            break;

            case 'style18':
            ?>

                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="d-flex justify-content-center mb-4">
                        <?php $this->ld_testi_get_rating( 'lqd-star-rating-shaped lqd-star-rating-outline', $rating ) ?>
                    </div>

                    <div class="lqd-testi-quote mb-4 ps-3 pe-3">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="lqd-testi-info d-flex flex-column flex-wrap justify-content-between">

                        <div class="lqd-testi-details d-flex align-items-center justify-content-center">
                            <?php $this->ld_testi_get_avatar( 'border-radius-circle overflow-hidden', $style, $avatar, $title ) ?>
                            <div class="lqd-testi-np text-start ps-4">
                                <?php $this->ld_testi_get_name( 'h3', 'text-uppercase ltr-sp-1 font-weight-bold', $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4', null, $position ) ?>
                            </div>

                        </div>

                    </div>

                    <div class="lqd-testi-extra pt-4 mt-4">
                        <?php $this->ld_testi_get_image( null, $image, $title ) ?>
                    </div>

                </div>

            <?php
            break;
            
            case 'style19':
            ?>

                <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

                    <div class="lqd-testi-extra mb-4">
                        <?php $this->ld_testi_get_image( null, $image, $title ) ?>
                    </div>

                    <div class="lqd-testi-quote mb-4">
                        <?php $this->ld_testi_get_quote( $quote ); ?>
                    </div>

                    <div class="d-flex mb-2">
                        <?php $this->ld_testi_get_rating( 'lqd-star-rating-shaped lqd-star-rating-fill', $rating ) ?>
                    </div>

                    <div class="lqd-testi-info d-flex flex-column flex-wrap justify-content-between">

                        <div class="lqd-testi-details d-flex align-items-center">
                            <div class="lqd-testi-np d-flex align-items-center">
                                <?php $this->ld_testi_get_name( 'h3 m-0', null, $title ) ?>
                                <?php $this->ld_testi_get_position( 'h4 m-0', null, $position ) ?>
                            </div>

                        </div>

                    </div>

                </div>

            <?php
            break;
        }
    }
}