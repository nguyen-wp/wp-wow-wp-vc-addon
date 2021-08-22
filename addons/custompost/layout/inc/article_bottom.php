<?php 
$output .= $add_button ? '<p class="wow-vc-button'.$btn_font_size.'">' . $this->extractLinkCustomPost(get_permalink($value->ID),$button_text) . '</p>' : null;
$output .= $add_box_button ? '' . $this->extractLinkCustomPost(get_permalink($value->ID),get_the_title($value->ID),false) . '' : null;
$output .= '</div>';
$output .= '</article>';