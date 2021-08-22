<?php 
if($image_src && $post_img) {
    if(get_permalink($value->ID)) {
        $output .= '<a href="'.get_permalink($value->ID).'"><figure class="img-with-aniamtion-wrap'.$dynamic_el_styles. $css_animation.'" '.$wrap_image_attrs_escaped.'>
        <img class="img-with-animation-wow skip-lazy '.esc_attr($img_class).'" '.$image_attrs_escaped.' />
        <figcaption></figcaption>
        </figure></a>';
    } else {
        $output .= '<figure class="img-with-aniamtion-wrap'.$dynamic_el_styles. $css_animation.'" '.$wrap_image_attrs_escaped.'>
        <img class="img-with-animation-wow skip-lazy '.esc_attr($img_class).'" '.$image_attrs_escaped.' />
        <figcaption></figcaption>
        </figure>';
    }
}