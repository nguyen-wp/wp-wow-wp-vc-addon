<?php

if (!defined('ABSPATH')) {
	die('Silly human what are you doing here');
}


if (!class_exists('wowVC_Addons_ImageGroup')) {

	class wowVC_Addons_ImageGroup extends WOW_VC_Helpers
	{

		public $name = 'imagegroup';
		public $pNicename = 'WOW Magic Image';

		public function __construct()
		{

			add_action('wp_enqueue_scripts', array($this, 'load_scripts'));
			add_shortcode('wow-vc-' . $this->name . '-shortcode', array($this, 'output'));

			// Map shortcode to Visual Composer
			if (function_exists('vc_lean_map')) {
				vc_lean_map('wow-vc-' . $this->name . '-shortcode', array($this, 'functionLoader'));

			}
		}

		public function load_scripts()
		{
			wp_enqueue_script(
				'wow-vc-' . $this->name,
				plugin_dir_url(__FILE__) . 'js/dist/main.prod.js',
				array('jquery'),
				WOW_VC_VERSION
			);
			wp_enqueue_style(
				'wow-vc-' . $this->name,
				plugin_dir_url(__FILE__) . 'css/dist/main.min.css',
				array(),
				WOW_VC_VERSION
			);
		}

		public function functionLoader()
		{

			$randomIDGen = $this->generateRandomString(10);
			global $_wp_additional_image_sizes;
			$taxonomies = array();

			foreach ($_wp_additional_image_sizes as $key => $value) {
				$taxonomies[esc_html__($key . ' ('.$value['width'].'x'.$value['height'].')', 'js_composer')] = $key;
			}

			return array(
				'name'        => esc_html__($this->pNicename, 'js_composer'),
				'description' => esc_html__('Add new ' . $this->pNicename, 'js_composer'),
				'base'        => 'wow_vc_' . $this->name,
				// 'is_container' => true,
				'category' => __('WOW Addons', 'js_composer'),
				'icon' => 'icon-wow-vc-adminicon icon-wow-vc-' . $this->name,
				'show_settings_on_create' => true,
				'params'      => array(
					
					array(
						'type' => 'attach_image',
						'holder' => 'img',
						'class' => 'wow-vc-img-single',
						'heading' => __('Image', 'js_composer'),
						'param_name' => 'img_single',
						'edit_field_class' => 'vc_col-sm-12 admin-wow-vc-col',
						'group' => $this->pNicename,
					),
					array(
						'type' => 'attach_images',
						'heading' => __('Image Group', 'js_composer'),
						'param_name' => 'img_group',
						'admin_label' => false,
						'edit_field_class' => 'vc_col-sm-12 admin-wow-vc-col',
						'group' => $this->pNicename,
					),
					array(
						'type' => 'textfield',
						'holder' => 'h2',
						'class' => 'wow-vc-title',
						'heading' => __('Heading', 'js_composer'),
						'param_name' => 'title',
						'value' => __('', 'js_composer'),
						'weight' => 0,
						'edit_field_class' => 'vc_col-sm-8 admin-wow-vc-col',
						'group' => $this->pNicename,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Heading Tag', 'js_composer' ),
						'param_name' => 'tag',
						'value' => 'h3',
						'save_always' => true,
						'not_empty' => true,
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'h3',
							esc_html__( 'h2', 'js_composer' ) => 'h2',
							esc_html__( 'h3', 'js_composer' ) => 'h3',
							esc_html__( 'h4', 'js_composer' ) => 'h4',
							esc_html__( 'h5', 'js_composer' ) => 'h5',
							esc_html__( 'h6', 'js_composer' ) => 'h6',
							esc_html__( 'p', 'js_composer' ) => 'p',
							esc_html__( 'div', 'js_composer' ) => 'div',
						),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => $this->pNicename,
					),
					array(
						'type' => 'textarea',
						'holder' => 'div',
						'class' => 'wow-vc-content',
						'heading' => __('Description', 'js_composer'),
						'param_name' => 'content',
						'value' => __('', 'js_composer'),
						'admin_label' => false,
						'description' => __('To add link highlight text or url and click the chain to apply hyperlink', 'js_composer'),
						'group' => $this->pNicename,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Image size', 'js_composer' ),
						'param_name' => 'img_size_list',
						'value' => $taxonomies,
						'description' => esc_html__( 'Image size posts', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6 admin-wow-vc-col pt-0',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Box layout', 'js_composer' ),
						'param_name' => 'theme',
						'admin_label' => true,
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'Image bottom', 'js_composer' ) => 'style-1',
							esc_html__( 'Hover', 'js_composer' ) => 'style-2',
						),
						'description' => esc_html__( 'Select box layout.', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6 admin-wow-vc-col pt-0',
						'group' => __('General', 'js_composer')
					),
					
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Text Align', 'js_composer' ),
						'param_name' => 'box_text_align',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'left', 'js_composer' ) => 'left',
							esc_html__( 'right', 'js_composer' ) => 'right',
							esc_html__( 'center', 'js_composer' ) => 'center',
							esc_html__( 'justify', 'js_composer' ) => 'justify',
						),
						'description' => esc_html__( 'Select box text align', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Box Justify content', 'js_composer' ),
						'param_name' => 'box_justify_content',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'start', 'js_composer' ) => 'flex-start',
							esc_html__( 'end', 'js_composer' ) => 'flex-end',
							esc_html__( 'center', 'js_composer' ) => 'center',
							esc_html__( 'between', 'js_composer' ) => 'space-between',
							esc_html__( 'around', 'js_composer' ) => 'space-around',
						),
						'description' => esc_html__( 'Select box justify content', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => __('General', 'js_composer')
					),
					
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Box Align items', 'js_composer' ),
						'param_name' => 'box_align_item',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'start', 'js_composer' ) => 'flex-start',
							esc_html__( 'end', 'js_composer' ) => 'flex-end',
							esc_html__( 'center', 'js_composer' ) => 'center',
							esc_html__( 'baseline', 'js_composer' ) => 'baseline',
							esc_html__( 'stretch', 'js_composer' ) => 'stretch',
						),
						'description' => esc_html__( 'Select box align items', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Add box click', 'js_composer' ) . '?',
						'param_name' => 'add_box_button',
						'edit_field_class' => 'vc_col-sm-12 admin-wow-vc-col',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'animation_style',
						'heading' => __( 'Animation Style', 'text-domain' ),
						'param_name' => 'css_animation',
						'description' => __( 'Choose your animation style', 'text-domain' ),
						'admin_label' => false,
						'weight' => 0,
						'group' => __('General', 'js_composer')
					),
					
					array(
						"type" => "textfield",
						"heading" => esc_html__("Animation Delay", "salient-core"),
						"param_name" => "delay",
						"admin_label" => false,
						"description" => esc_html__("Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in \"one by one\" effect.", "salient-core"),
						'group' => __('General', 'js_composer')
					),
					array(
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Colors", "js_composer" ),
						"param_name" => "group_header_2",
						"edit_field_class" => "",
						"value" => '',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Heading color', 'js_composer' ),
						'param_name' => 'title_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Heading color hover', 'js_composer' ),
						'param_name' => 'title_color_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Text color', 'js_composer' ),
						'param_name' => 'desc_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Text color hover', 'js_composer' ),
						'param_name' => 'desc_color_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Box background hover', 'js_composer' ),
						'param_name' => 'box_bg_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Box background transparent', 'js_composer' ),
						'param_name' => 'box_transparent',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => '1',
							esc_html__( '0', 'js_composer' ) => '0',
							esc_html__( '0.1', 'js_composer' ) => '0.1',
							esc_html__( '0.2', 'js_composer' ) => '0.2',
							esc_html__( '0.3', 'js_composer' ) => '0.3',
							esc_html__( '0.4', 'js_composer' ) => '0.4',
							esc_html__( '0.5', 'js_composer' ) => '0.5',
							esc_html__( '0.6', 'js_composer' ) => '0.6',
							esc_html__( '0.7', 'js_composer' ) => '0.7',
							esc_html__( '0.8', 'js_composer' ) => '0.8',
							esc_html__( '0.9', 'js_composer' ) => '0.9',
							esc_html__( '1', 'js_composer' ) => '1',
						),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('General', 'js_composer')
					),

					array(
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Element", "js_composer" ),
						"param_name" => "group_header_1",
						"edit_field_class" => "",
						"value" => '',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'el_id',
						'heading' => esc_html__('Element ID', 'js_composer'),
						'param_name' => 'el_id',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Extra class name', 'js_composer'),
						'param_name' => 'el_class',
						'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer'),
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__('HTML Attribute', 'js_composer'),
						'param_name' => 'el_attribute',
						'description' => esc_html__('Enter html attr (Example: "data-bg").', 'js_composer'),
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'wow_vc_disable_frm_id_gen',
						'value' => $randomIDGen,
						'heading' => esc_html__('ID Random', 'js_composer'),
						'param_name' => 'el_idgen',
						'edit_field_class' => 'vc_col-sm-12 admin-wow-vc-col wow_vc_admin_autogen_id',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Content Padding', 'js_composer' ),
						'param_name' => 'content_padding',
						'value' => '',
						'description' => esc_html__( 'e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6 pt-0 admin-wow-vc-col',
						'group' => __('Design Options', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Content Margin', 'js_composer' ),
						'param_name' => 'content_margin',
						'value' => '',
						'description' => esc_html__( 'e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6 pt-0 admin-wow-vc-col',
						'group' => __('Design Options', 'js_composer')
					),
					array(
						'type' => 'css_editor',
						'heading' => esc_html__('CSS box', 'js_composer'),
						'param_name' => 'css',
						'group' => esc_html__('Design Options', 'js_composer'),
					),
				),
			);
		}
		public function output($atts, $content = null)
		{

			$gen = isset($atts['gen']) ? $atts['gen'] : 'Create';
			$block_id = isset($atts['el_id']) ? ' id="'.$atts['el_id'].'"' : '';
			$attribute = isset($atts['el_attribute']) ? ' ' . $atts['el_attribute'] : '';
			$css = isset($atts["css"]) ? $atts["css"] : '';
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), $this->settings['base'], $atts);
			$theme = isset($atts['theme']) ? ' wow-vc-' . $atts['theme'] : '';
			$classname = isset($atts['el_class']) ? ' ' . $atts['el_class'] : '';
			$css_animation = isset($atts['css_animation']) ? ' wpb_animate_when_almost_visible wpb_' . $atts['css_animation'] . ' animate__animated animate__' . $atts['css_animation']. ' ' . $atts['css_animation'] : null;
			$content_padding = isset($atts['content_padding']) ? $atts['content_padding'] : null;
			$content_margin = isset($atts['content_margin']) ? $atts['content_margin'] : null;
			$title = isset($atts['title']) ? $atts['title'] : null;
			$img_single = isset($atts['img_single']) ? $atts['img_single'] : '';
			$img_group = isset($atts['img_group']) ? $atts['img_group'] : null;
			$delay = $atts['delay'] ? $atts['delay']: 0;
			$add_box_button = $atts['add_box_button'] ? true: false;
			$tag = isset($atts["tag"]) ? $atts["tag"] : 'h2';
			$img_size_list = $atts["img_size_list"] ? $atts["img_size_list"] : 'post-thumbnail';
			$box_justify_content = isset($atts['box_justify_content']) ? $atts['box_justify_content'] : null;
			$box_text_align = isset($atts['box_text_align']) ? $atts['box_text_align'] : null;
			$box_align_item = isset($atts['box_align_item']) ? $atts['box_align_item'] : null;
			$title_color = isset($atts['title_color']) ? $atts['title_color'] : null;
			$title_color_hover = isset($atts['title_color_hover']) ? $atts['title_color_hover'] : null;
			$desc_color = isset($atts['desc_color']) ? $atts['desc_color'] : null;
			$desc_color_hover = isset($atts['desc_color_hover']) ? $atts['desc_color_hover'] : null;
			$box_bg_hover = isset($atts['box_bg_hover']) ? $atts['box_bg_hover'] : null;
			$box_transparent = isset($atts['box_transparent']) ? $atts['box_transparent'] : 1;

			// INIT
			$has_dimension_data = false;
			$image_srcset = null;
			$image_width  = '100';
			$image_height = '100';
			$image_loading = isset($atts['image_loading']) ? $atts['image_loading'] : null;
			$parsed_animation = str_replace(" ","-",$atts['css_animation']);
			// Attributes applied to img.
			$margin_style_attr = '';
			$wrap_image_attrs_escaped  = 'data-max-width="100%" ';
			$wrap_image_attrs_escaped .= 'data-max-width-mobile="100%" ';
			$wrap_image_attrs_escaped .= 'data-animation="'.esc_attr(strtolower($parsed_animation)).'" ';
			$wrap_image_attrs_escaped .= $margin_style_attr;
			if( function_exists('nectar_el_dynamic_classnames') ) {
				$dynamic_el_styles = nectar_el_dynamic_classnames('image_with_animation', $atts);
			} else {
				$dynamic_el_styles = '';
			}

			$image_src_full = wp_get_attachment_image_src($img_single,'full')[0];
			$image_src = wp_get_attachment_image_src($img_single, $img_size_list)[0];
			$image_meta = wp_get_attachment_metadata($img_single);
			
			if (function_exists('wp_get_attachment_image_srcset')) {
				$image_srcset_values = wp_get_attachment_image_srcset($img_single, $img_size_list);
				if ($image_srcset_values) {

					if( 'lazy-load' === $image_loading ) {
						$image_srcset = 'data-nectar-img-srcset="';
					} else {
						$image_srcset = 'srcset="';
					}
					$image_srcset .= $image_srcset_values;
					$image_srcset .= '" sizes="(min-width: 1450px) 75vw, (min-width: 1000px) 85vw, 100vw"';
				}
			}
			if (isset($image_meta['width']) && !empty($image_meta['width'])) {
				$image_width = $image_meta['width'];
			}
			if (isset($image_meta['height']) && !empty($image_meta['height'])) {
				$image_height = $image_meta['height'];
			}
			$wp_img_alt_tag = get_post_meta($img_single, '_wp_attachment_image_alt', true);
			if (!empty($wp_img_alt_tag)) {
				$alt_tag = $wp_img_alt_tag;
			}
			if (!empty($image_meta['width']) && !empty($image_meta['height'])) {
				$has_dimension_data = true;
			}
			$image_attrs_escaped = 'data-delay="' . esc_attr($delay) . '" ';
			$image_attrs_escaped .= 'height="' . esc_attr($image_height) . '" ';
			$image_attrs_escaped .= 'width="' . esc_attr($image_width) . '" ';
			$image_attrs_escaped .= 'data-animation="' . esc_attr(strtolower($parsed_animation)) . '" ';
			if( 'lazy-load' === $image_loading && true === $has_dimension_data ) {
				$img_class .= ' nectar-lazy';
				$image_attrs_escaped .= 'data-nectar-img-src="' . esc_url($image_src) . '" ';
			} else {
				$image_attrs_escaped .= 'src="' . esc_url($image_src) . '" ';
			}
			$image_attrs_escaped .= 'alt="' . esc_attr($alt_tag) . '" ';
			$image_attrs_escaped .= $image_srcset;

			// Admin
			$settings = shortcode_atts(array(
				'el_attribute' => '',
				'el_id' => '',
				'el_class' => '',
			), $atts);
			extract($settings);
			
			// CSSBUILD 
			$randomNumClass = $atts['el_idgen'];
			$cssname = $atts['css'] ? vc_shortcode_custom_css_class($css, '.') : '.wow_vc_'.$randomNumClass;
			$cssaddclass = $atts['css'] ? '' : ' wow_vc_'.$randomNumClass;
			$css_build = '';
			$css_build .= $content_padding ? ''. $cssname.'{padding:'.$content_padding.';}' : null;
			$css_build .= $content_margin ? ''. $cssname.'{margin:'.$content_margin.';}' : null;
			$css_build .= $box_justify_content ? ''. $cssname.' .wow-vc-ctn .wow-vc-action{justify-content:'.$box_justify_content.'!important;display:flex!important}' : null;
			$css_build .= $box_align_item ? ''. $cssname.' .wow-vc-ctn .wow-vc-action{align-items:'.$box_align_item.'!important;display:flex!important}' : null;
			$css_build .= $box_text_align ? ''. $cssname.' .wow-vc-ctn .wow-vc-title{text-align:'.$box_text_align.'!important}' : null;
			$css_build .= $box_text_align ? ''. $cssname.' .wow-vc-ctn .wow-vc-content{text-align:'.$box_text_align.'!important}' : null;
			$css_build .= $title_color ? ''. $cssname.' .wow-vc-ctn .wow-vc-title{color:'.$title_color.'!important}' : null;
			$css_build .= $desc_color ? ''. $cssname.' .wow-vc-ctn .wow-vc-content{color:'.$desc_color.'!important}' : null;
			$css_build .= $box_bg_hover ? ''. $cssname.'.wow-vc-imagegroup.wow-vc-style-2 article .wow-vc-action{background-color:'.$this->wowHexToRGB($box_bg_hover,$box_transparent).'!important}' : null;
			
			if($add_box_button){
				$css_build .= $title_color_hover ? ''. $cssname.':hover .wow-vc-ctn .wow-vc-title{color:'.$title_color_hover.'!important}' : null;
				$css_build .= $title_color_hover ? ''. $cssname.':hover .wow-vc-ctn .wow-vc-title .wow-vc-title-link{color:'.$title_color_hover.'!important}' : null;
				$css_build .= $desc_color_hover ? ''. $cssname.':hover .wow-vc-ctn .wow-vc-content{color:'.$desc_color_hover.'!important}' : null;
				$css_build .= $desc_color_hover ? ''. $cssname.':hover .wow-vc-ctn .wow-vc-content .wow-vc-title-link{color:'.$desc_color_hover.'!important}' : null;
			} else {
				$css_build .= $title_color_hover ? ''. $cssname.' .wow-vc-ctn .wow-vc-title:hover{color:'.$title_color_hover.'!important}' : null;
				$css_build .= $title_color_hover ? ''. $cssname.' .wow-vc-ctn .wow-vc-title .wow-vc-title-link:hover{color:'.$title_color_hover.'!important}' : null;
				$css_build .= $desc_color_hover ? ''. $cssname.' .wow-vc-ctn .wow-vc-content:hover{color:'.$desc_color_hover.'!important}' : null;
				$css_build .= $desc_color_hover ? ''. $cssname.' .wow-vc-ctn .wow-vc-content .wow-vc-title-link:hover{color:'.$desc_color_hover.'!important}' : null;
			}

			// FrontEnd
			$output = ($css || $css_build) ? '<style>' . $css .$css_build. '</style>' : '';
			$output .= '<section'. $block_id .' class="wow-vc-elements wow-vc-' . $this->name . $css_class.$theme. $classname.$cssaddclass.'"' . str_replace('``', '', $attribute) . '>';
			$output .= '<article class="wow-vc-ctn'.($add_box_button ? ' wow-vc-hold-click' : '').'">';
			if($atts["theme"] === 'style-1') {
				include 'layout/style-1.php';
			} else if($atts["theme"] === 'style-2') {
				include 'layout/style-2.php';
			} 
			else {
				include 'layout/default.php';
			}
			$output .= $add_box_button ? '<a href="'.$image_src_full.'" data-fancybox="gallery_'.trim($cssaddclass).'" data-caption="'.wp_get_attachment_caption($img_single).'" class="wow-vc-title-link hold-click"></a>' : null;
			$output .= '</article>';
			$output .= '</section>';
			$output .= '<!-- .wow-vc-' . $this->name . ' -->';

			return apply_filters(
				'wow_vc_' . $this->name . '_output',
				$output,
				$content,
				$settings
			);
		}

	}
}
new wowVC_Addons_ImageGroup;
