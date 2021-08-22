<?php 
if($post_author || $post_date || $post_category) {
$output .= '<div class="wow-vc-meta">';
if($post_author) {
    $output .= '<div class="wow-vc-author"><a href="'.get_author_posts_url($value->post_author).'">'.get_the_author_meta('display_name',$value->post_author).'</a></div>';
}
if($post_date) {
    $output .= '<time datetime="'.$value->post_date.'" class="wow-vc-date">'.get_the_date(get_option('date_format'),$value->ID).'</time>';
}
if($post_category && get_the_category($value->ID)) {
    $category_detail=get_the_category($value->ID);//$post->ID
    $output .= '<ul class="wow-vc-category">';
    if($post_category_one) {
        $output .= '<li class="wow-vc-category-item"><a href="/'.$category_detail[0]->taxonomy.'/'.$category_detail[0]->slug.'">'.$category_detail[0]->cat_name.'</a></li>';
    } else {
        foreach($category_detail as $cd){
            $output .= '<li class="wow-vc-category-item"><a href="/'.$cd->taxonomy.'/'.$cd->slug.'">'.$cd->cat_name.'</a></li>';
        }
    }
    $output .= '</ul>';
}
$output .= '</div>';
}