<?php
if($image_src) {
    $output .= '<figure class="img-with-aniamtion-wrap'.$dynamic_el_styles. $css_animation .$textAlign.'" '.$wrap_image_attrs_escaped.'>
    <img class="img-with-animation-wow skip-lazy '.esc_attr($img_class).'" '.$image_attrs_escaped.' />
    <figcaption></figcaption>
    </figure>';
}