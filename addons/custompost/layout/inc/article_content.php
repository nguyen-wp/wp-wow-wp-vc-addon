<?php 
if(strlen(wp_trim_words(get_the_excerpt($value->ID),$number_words,''))>0) {
    $output .= get_the_excerpt($value->ID) ? '<div class="wow-vc-content"><p>' . wp_trim_words(get_the_excerpt($value->ID),$number_words,str_replace('}', ']',str_replace('{', '[',str_replace('`', '', $trim_words)))) . '</p></div>' : null;
}
