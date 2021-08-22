<?php
$output .= '<figure class="img-with-aniamtion-wrap'.$dynamic_el_styles. $css_animation.'" '.$wrap_image_attrs_escaped.'>
<a href="'.$image_src_full.'" data-fancybox="gallery_'.trim($cssaddclass).'" data-caption="'.wp_get_attachment_caption($img_single).'"><img class="img-with-animation-wow skip-lazy '.esc_attr($img_class).'" '.$image_attrs_escaped.' />
<figcaption></figcaption>
</a></figure>';

$arImgG = explode(",",$img_group);
$output .= '<ul class="wow-vc-img-group" style="display:none">';
foreach ($arImgG as $key => $value) {
    $output .= '</li><a href="'.wp_get_attachment_image_src($value,'full')[0].'" data-fancybox="gallery_'.trim($cssaddclass).'" data-caption="'.wp_get_attachment_caption($value).'"><img src="'.wp_get_attachment_image_src($value, $img_size_list)[0].'"></a></li>';
}
$output .= '</ul>';

$output .= '<script>function ligtGA'.trim($cssaddclass).'() { jQuery( document ).ready(function() {
jQuery(\'[data-fancybox="gallery_'.trim($cssaddclass).'"]\').fancybox({
    buttons : [ 
      // \'slideShow\',
      // \'share\',
      // \'zoom\',
      // \'fullScreen\',
      // \'close\'
    ],
    thumbs : {
      // autoStart : true
    }
  });
})};setTimeout(function(){ ligtGA'.trim($cssaddclass).'(); }, 1000);</script>';