<?php
$testimonial = array(
    'lqdsep-testimonial-base' => 'elements/testimonial/testimonial-base.css',
    'lqdsep-testimonial-bordered' => 'elements/testimonial/testimonial-bordered.css',
    'lqdsep-testimonial-bubble-all' => 'elements/testimonial/testimonial-bubble-all.css',
    'lqdsep-testimonial-bubble-alt' => 'elements/testimonial/testimonial-bubble-alt.css',
    'lqdsep-testimonial-bubble' => 'elements/testimonial/testimonial-bubble.css',
    'lqdsep-testimonial-card' => 'elements/testimonial/testimonial-card.css',
    'lqdsep-testimonial-card-nospace' => 'elements/testimonial/testimonial-card-nospace.css',
    'lqdsep-testimonial-details-inline' => 'elements/testimonial/testimonial-details-inline.css',
    'lqdsep-testimonial-icon-flip' => 'elements/testimonial/testimonial-icon-flip.css',
    'lqdsep-testimonial-quote-gradient' => 'elements/testimonial/testimonial-quote-gradient.css',
    'lqdsep-testimonial-quote-icon' => 'elements/testimonial/testimonial-quote-icon.css',
    'lqdsep-testimonial-social-icon' => 'elements/testimonial/testimonial-social-icon.css',
    'lqdsep-testimonial-star-rating' => 'elements/testimonial/testimonial-star-rating.css',
    'lqdsep-testimonial-time' => 'elements/testimonial/testimonial-time.css',
);
foreach ( array('48', '60', '65', '68', '72', '85', '90') as $avatar_size) {
    $testimonial['lqdsep-testimonial-avatar-' . $avatar_size] = 'elements/testimonial/testimonial-avatar-' . $avatar_size . '.css';
}
foreach ( array('same', 'sm', 'lg', 'xl') as $details_size) {
    $testimonial['lqdsep-testimonial-details-' . $details_size] = 'elements/testimonial/testimonial-details-' . $details_size . '.css';
}
foreach ( array('16', '18', '21', '22', '25', '27') as $quote_size) {
    $testimonial['lqdsep-testimonial-quote-' . $quote_size] = 'elements/testimonial/testimonial-quote-' . $quote_size . '.css';
}
foreach ( array('none', 'xs', 'sm', 'sm2', 'lg', 'xl', 'xxl') as $shadow_size) {
    $testimonial['lqdsep-testimonial-shadow-' . $shadow_size] = 'elements/testimonial/testimonial-shadow-' . $shadow_size . '.css';
}
foreach ( array('9', '16', '18', '19') as $testi_style) {
    $testimonial['lqdsep-testimonial-style-' . $testi_style] = 'elements/testimonial/testimonial-style-' . $testi_style . '.css';
}