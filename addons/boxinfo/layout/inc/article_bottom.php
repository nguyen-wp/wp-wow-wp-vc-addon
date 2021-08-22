<?php
$output .= $content ? '<div class="wow-vc-content'.$applyClass.'">' . do_shortcode($content) . '</div>' : null;
$output .= $add_button ? '<p class="wow-vc-button">' . $this->extractLink($link, $title,false,false,true,$btn_font_size) . '</p>' : null;
$output .= '</article>';
if($box_bg) {
    $output .= '<div class="box-bg"></div>';
}