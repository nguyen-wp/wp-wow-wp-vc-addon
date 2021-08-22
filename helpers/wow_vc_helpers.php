<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WOW_VC_Helpers extends WPBakeryShortCode {
	public function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	public function generateRandomNum($length = 10) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function wowHexToRGB ($hexColor, $animation=1)
	{
		if( preg_match( '/^#?([a-h0-9]{2})([a-h0-9]{2})([a-h0-9]{2})$/i', $hexColor, $matches ) )
		{
			return 'rgba('. hexdec( $matches[ 1 ] ).','. hexdec( $matches[ 2 ] ).','. hexdec( $matches[ 3 ] ).','.$animation.')';
		}
		else
		{
			return $hexColor;
		}
	}

	public function applyQueryTotal($query = null,$offset=0) {
		$total = 0;
		$size = -1;
		$order_by = 'ID';
		$order = 'DESC';
		$post_type = 'post';
		foreach ( explode("|",$query) as $key => $value ) {
			if ( preg_match( '/size/', $value ) ) {
				$eachpage = explode(":",$value)[1];
			}
			if ( preg_match( '/order_by/', $value ) ) {
				$order_by = explode(":",$value)[1];
			}
			if ( preg_match( '/order/', $value ) ) {
				$order = explode(":",$value)[1];
			}
			if ( preg_match( '/post_type/', $value ) ) {
				$post_type = explode(":",$value)[1];
			}
			if ( preg_match( '/ignore_sticky_posts/', $value ) ) {
				$ignore_sticky_posts = explode(":",$value)[1];
			}
			if ( preg_match( '/authors/', $value ) ) {
				$authors = explode(":",$value)[1];
			}
			if ( preg_match( '/categories/', $value ) ) {
				$categories = explode(":",$value)[1];
			}
			if ( preg_match( '/tags/', $value ) ) {
				$tags = explode(":",$value)[1];
			}
			if ( preg_match( '/tax_query/', $value ) ) {
				$tax_query = explode(":",$value)[1];
			}
		}
		$qu = (object) array(
			'post_type'=>  explode(',', $post_type),
			'orderby'    => $order_by,
			'post_status' => 'publish',
			'order'    => $order,
			'posts_per_page' => $size,
			// 'offset' => $offset,
			);
		if($ignore_sticky_posts) {
			$qu->ignore_sticky_posts = intval($ignore_sticky_posts);
		}
		if($categories) {
			$qu->author__in = explode(',', $authors);
		}
		if($categories) {
			$qu->category__in = explode(',', $categories);
		}
		if($categories) {
			$qu->tag__in = explode(',', $tags);
		}
		$total = new WP_Query($qu);
		if($total->posts) {
			$total = ceil(count($total->posts)/$eachpage);
		}
		return $total;
	}
	public function applyQuery($query = null,$offset=0, $paged=1) {
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		$size = -1;
		$order_by = 'ID';
		$order = 'DESC';
		$post_type = 'post';
		foreach ( explode("|",$query) as $key => $value ) {
			if ( preg_match( '/size/', $value ) ) {
				$size = explode(":",$value)[1];
			}
			if ( preg_match( '/order_by/', $value ) ) {
				$order_by = explode(":",$value)[1];
			}
			if ( preg_match( '/order/', $value ) ) {
				$order = explode(":",$value)[1];
			}
			if ( preg_match( '/post_type/', $value ) ) {
				$post_type = explode(":",$value)[1];
			}
			if ( preg_match( '/ignore_sticky_posts/', $value ) ) {
				$ignore_sticky_posts = explode(":",$value)[1];
			}
			if ( preg_match( '/authors/', $value ) ) {
				$authors = explode(":",$value)[1];
			}
			if ( preg_match( '/categories/', $value ) ) {
				$categories = explode(":",$value)[1];
			}
			if ( preg_match( '/tags/', $value ) ) {
				$tags = explode(":",$value)[1];
			}
			if ( preg_match( '/tax_query/', $value ) ) {
				$tax_query = explode(":",$value)[1];
			}
		}

		$qu = (object) array(
			'post_type'=>  explode(',', $post_type),
			'orderby'    => $order_by,
			'post_status' => 'publish',
			'order'    => $order,
			'posts_per_page' => intval($size),
			// 'offset' => $offset,
			'paged' => $paged,
			);
		if($ignore_sticky_posts) {
			$qu->ignore_sticky_posts = intval($ignore_sticky_posts);
		}
		if($categories) {
			$qu->author__in = explode(',', $authors);
		}
		if($categories) {
			$qu->category__in = explode(',', $categories);
		}
		if($categories) {
			$qu->tag__in = explode(',', $tags);
		}
		return $qu;
	}
	public function applyHeadingCustomPost($title = null,$tag = null,$url = false,$attr = null) {
		$styles = '';
		if($url) {
			$styles = '<'.$tag.' class="wow-vc-title"><a href="'.$url.'" class="wow-vc-title-link"'.($attr ? ' '.$attr : '').'>' .  $title . '</a></'.$tag.'>';
		} else {
			$styles = '<'.$tag.' class="wow-vc-title">' .  $title . '</'.$tag.'>';
		}
		return $styles;
	}
	public function applyHeadingMagic($title = null,$tag = null,$wrapTag = null,$icon = null) {
		$styles = '';
		if($wrapTag) {
			$styles = '<'.$tag.' class="wow-vc-title">'.$icon.'<'.$wrapTag.' class="wow-vc-title-wrap">' .  $title . '</'.$wrapTag.'></'.$tag.'>';
		} else {
			$styles = '<'.$tag.' class="wow-vc-title">' .  $title . '</'.$tag.'>';
		}
		return $styles;
	}
	public function applyHeading($font_container_data, $title = null, $link = null, $line_height= null, $font_size= null, $add_heading_click= null) {
		$styles = $initStyles = '';
		$tag = 'h2';
		foreach ( explode("|",$font_container_data) as $key => $value ) {
			if ( preg_match( '/tag/', $value ) ) {
				$tag = ''.explode(":",$value)[1];
			}
		}
		if($font_size) {
			$fontsize = ' '.$font_size.'';
		}
		if($add_heading_click) {
			$url = $this->extractLink($link,$title,false,false,false,$fontsize);
		} else {
			$url = $this->extractLink(null,$title,false,false,false,$fontsize);
		}
		if($url) {
			$styles = '<'.$tag.' class="wow-vc-title'.$fontsize.'">' . $url . '</'.$tag.'>';
		} else {
			$styles = '<'.$tag.' class="wow-vc-title"'.$fontsize.'>' .  $title . '</'.$tag.'>';
		}
		return $styles;
	}
	public function applyHeadingStyle($font_container_data, $line_height= null) {
		$styles = $lineheight = $color = '';
		foreach ( explode("|",$font_container_data) as $key => $value ) {
			if ( preg_match( '/color/', $value ) ) {
				$color = 'color:'.urldecode(explode(":",$value)[1]).'';
			}
		}
		if($line_height) {
			$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
			preg_match( $pattern, $line_height, $matches );
			$lineheight = isset( $matches[2] ) ? 'line-height:'.$matches[0].'' : 'line-height:'.$matches[0].'';	
		}
		$styles = ''.$color.''.$lineheight.'';
		return $styles;
	}
	public function applyDesc($desc_color = null, $desc_line_height = null) {
		$styles = '';
		if($desc_color) {
			$color = 'color:'.$desc_color.'';
		}
		if($desc_line_height) {
			$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
			preg_match( $pattern, $desc_line_height, $matches );
			$lineheight = isset( $matches[2] ) ? 'line-height:'.$matches[0].'' : 'line-height:'.$matches[0].'';	
		}
		if($color || $lineheight) {
			$styles = ''.$color.';'.$lineheight.'';
		}
		return $styles;
	}
	public function applyClass($class = null) {
		$styles = '';
		if($class) {
			$styles = ' '.$class.'';
		}
		return $styles;
	}
	public function applyGoogleFont($font = null) {
		$styles = '';
		if($font) {
			foreach ( explode("|",$font) as $key => $value ) {
				if ( preg_match( '/font_family/', $value ) ) {
					$font_family = urldecode(explode(":",$value)[1]);
				}
				if ( preg_match( '/font_style/', $value ) ) {
					$font_style = urldecode(explode(":",$value)[1]);
				}
			}
			wp_enqueue_style( 'wow_vc_font_family_' . vc_build_safe_css_class( $font_family ), 'https://fonts.googleapis.com/css?family=' . $font_family , [], WPB_VC_VERSION );
			$styles = ' '.$font.'';
		}
		return $styles;
	}
	public function getGoogleFont($font = null) {
		$styles = '';
		if($font) {
			foreach ( explode("|",$font) as $key => $value ) {
				if ( preg_match( '/font_family/', $value ) ) {
					$font_family = urldecode(explode(":",$value)[1]);
				}
				if ( preg_match( '/font_style/', $value ) ) {
					$font_style = urldecode(explode(":",$value)[1]);
				}
			}
			$newF = explode(":",$font_family);
			$newS = explode(":",$font_style);
			if($newF[0]) {
				$ff = 'font-family:'.$newF[0].';';
			}
			if($newS[1]) {
				$fw = 'font-weight:'.$newS[1].';';
			}
			if($newS[2]) {
				$fs = 'font-style:'.$newS[2].';';
			}
			
			if($ff || $fs || $fw) {
				$styles = ''.$ff.''.$fw.''.$fs.'';
			}
		}
		return $styles;
	}
	public function applyIcon($icon = null) {
		$styles = $doIcon = '';
		if($icon) {
			$styles = ' class="wow-vc-icon '.$icon.'"';
			$doIcon = '<i'.$styles.'></i>';
		}
		return $doIcon;
	}
	public function applyIconStyle($icon_size = null) {
		$fontsize = '';
		if($icon_size) {
			$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
			preg_match( $pattern, $icon_size, $matches );
			$fontsize = isset( $matches[2] ) ? 'font-size:'.$matches[0].'' : 'font-size:'.$matches[0].'px';
		}
		return $fontsize;
	}
	public function textAlign($font_container_data) {
		$align = '';
		foreach ( explode("|",$font_container_data) as $key => $value ) {
			if ( preg_match( '/text_align/', $value ) ) {
				$align = ' text-'.explode(":",$value)[1].'';
			}
		}
		return $align;
	}
	public function extractLink($link, $title, $settile = true,$removeTitle = false,$btn = false, $fontsize) {
		$URL = $returnURL = $target = $rel = '';
		foreach ( explode("|",$link) as $key => $value ) {
			if ( preg_match( '/url/', $value ) ) {
				$URL = urldecode(explode(":",$value)[1]);
			}
			if ( preg_match( '/title:/', $value ) && !$settile) {
				$title = urldecode(explode(":",$value)[1]);
			}
			if ( preg_match( '/target/', $value )) {
				$target = ' target="'. explode(":",$value)[1].'"';
			}
			if ( preg_match( '/rel/', $value )) {
				$rel = ' rel="'. explode(":",$value)[1].'"';
			}
		}
		$btn ? $btn = ' btn btn-light' : '';
		
		if($link) {
			if($removeTitle) {
				$returnURL = '<a class="wow-vc-title-link'.$fontsize.$btn.' hold-click" href="'.$URL.'"'.$target.''.$rel.'></a>';
			} else {
				$returnURL = '<a class="wow-vc-title-link'.$fontsize.$btn.'" href="'.$URL.'"'.$target.''.$rel.'>'.$title.'</a>';
			}
		} else {
			if($removeTitle) {
				$returnURL = '<a class="wow-vc-title-link'.$fontsize.$btn.' hold-click" href="'.$URL.'"'.$target.''.$rel.'></a>';
			} else {
				$returnURL = '<span>'.$title.'</span>';
			}
		}
		
		return $returnURL;
	}
	public function extractLinkCustomPost($link, $title,$enabletitle=true) {
		$returnURL = '';
		if($enabletitle) {
			$returnURL = '<a class="wow-vc-title-link" href="'.$link.'">'. $title .'</a>';
		} else {
			$returnURL = '<a class="wow-vc-title-link hold-click" href="'.$link.'"></a>';
		}
		return $returnURL;
	}

}
