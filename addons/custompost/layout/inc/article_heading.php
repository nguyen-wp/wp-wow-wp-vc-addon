<?php 
$output .= $value->post_title ? $this->applyHeadingCustomPost(get_the_title($value->ID),$tag,get_permalink($value->ID)) : null;
