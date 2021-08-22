<?php

if (!defined('ABSPATH')) {
	die('Silly human what are you doing here');
}


if (!class_exists('wowVC_Addons_Popup')) {

	class wowVC_Addons_Popup extends WOW_VC_Helpers
	{

		public $name = 'popup';
		public $pNicename = 'WOW Popup';

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
						'type' => 'textfield',
						'holder' => 'h4',
						'class' => 'wow-vc-title',
						'heading' => __('Button text', 'js_composer'),
						'param_name' => 'popup_title',
						'value' => __('', 'js_composer'),
						'weight' => 0,
						'edit_field_class' => 'vc_col-sm-8 admin-wow-vc-col pt-0',
						'group' => $this->pNicename,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button Tag', 'js_composer' ),
						'param_name' => 'popup_tag',
						'value' => 'p',
						'save_always' => true,
						'not_empty' => true,
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'p',
							esc_html__( 'p', 'js_composer' ) => 'p',
							esc_html__( 'div', 'js_composer' ) => 'div',
						),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col pt-0',
						'group' => $this->pNicename,
					),
					array(
						'type' => 'textfield',
						'class' => 'wow-vc-title',
						'heading' => __('Heading', 'js_composer'),
						'param_name' => 'title',
						'value' => __('', 'js_composer'),
						'edit_field_class' => 'vc_col-sm-8 admin-wow-vc-col',
						'group' => $this->pNicename,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Heading Tag', 'js_composer' ),
						'param_name' => 'tag',
						'value' => 'h3',
						'admin_label' => false,
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
						'type' => 'textarea_html',
						'class' => 'wow-vc-content',
						'heading' => __('Description', 'js_composer'),
						'param_name' => 'content',
						'admin_label' => false,
						'value' => __('<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>', 'js_composer'),
						'description' => __('To add link highlight text or url and click the chain to apply hyperlink', 'js_composer'),
						'group' => $this->pNicename,
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Click to close', 'js_composer' ) . '?',
						'param_name' => 'click_to_close',
						'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col pt-0',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Disable animation', 'js_composer' ) . '?',
						'param_name' => 'add_animation',
						'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col pt-0',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Disable scrollable', 'js_composer' ),
						'param_name' => 'modal_touch',
						'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col pt-0',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Small Button', 'js_composer' ),
						'param_name' => 'small_button',
						'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col pt-0',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Content Padding', 'js_composer' ),
						'param_name' => 'content_padding',
						'value' => '',
						'description' => esc_html__( 'e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Content Margin', 'js_composer' ),
						'param_name' => 'content_margin',
						'value' => '',
						'description' => esc_html__( 'e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Max Width', 'js_composer' ),
						'param_name' => 'max_width',
						'value' => '',
						'description' => esc_html__( 'e.g: 80% or 600px', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
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
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button text', 'js_composer' ),
						'param_name' => 'btn_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col pt-0',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button text hover', 'js_composer' ),
						'param_name' => 'btn_hover_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col pt-0',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button background', 'js_composer' ),
						'param_name' => 'btn_bg',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col pt-0',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button hover background', 'js_composer' ),
						'param_name' => 'btn_hover_bg',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button border color', 'js_composer' ),
						'param_name' => 'btn_border_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button border hover', 'js_composer' ),
						'param_name' => 'btn_border_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button font size', 'js_composer' ),
						'param_name' => 'btn_font_size',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'Display 1', 'js_composer' ) => 'wow-vc-display-1',
							esc_html__( 'Display 2', 'js_composer' ) => 'wow-vc-display-2',
							esc_html__( 'Display 3', 'js_composer' ) => 'wow-vc-display-3',
							esc_html__( 'Display 4', 'js_composer' ) => 'wow-vc-display-4',
							esc_html__( 'Display 5', 'js_composer' ) => 'wow-vc-display-5',
							esc_html__( 'Display 6', 'js_composer' ) => 'wow-vc-display-6',
							esc_html__( 'Display 7 (fs-1)', 'js_composer' ) => 'wow-vc-font-1',
							esc_html__( 'Display 8 (fs-2)', 'js_composer' ) => 'wow-vc-font-2',
							esc_html__( 'Display 9 (fs-3)', 'js_composer' ) => 'wow-vc-font-3',
							esc_html__( 'Display 10 (fs-4)', 'js_composer' ) => 'wow-vc-font-4',
							esc_html__( 'Display 11 (fs-5)', 'js_composer' ) => 'wow-vc-font-5',
							esc_html__( 'Display 12 (fs-6)', 'js_composer' ) => 'wow-vc-font-6',
						),
						'description' => esc_html__( 'Select button font size.', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button line height', 'js_composer' ),
						'param_name' => 'btn_line_height',
						'description' => esc_html__( 'Enter button line height. e.g. 1.5 or 1.5rem', 'js_composer' ),
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button border', 'js_composer' ),
						'param_name' => 'btn_border',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( '0px', 'js_composer' ) => '0',
							esc_html__( '1px', 'js_composer' ) => '1px',
							esc_html__( '2px', 'js_composer' ) => '2px',
							esc_html__( '3px', 'js_composer' ) => '3px',
							esc_html__( '4px', 'js_composer' ) => '4px',
						),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button border style', 'js_composer' ),
						'param_name' => 'btn_border_style',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'all', 'js_composer' ) => 'all',
							esc_html__( 'top', 'js_composer' ) => 'top',
							esc_html__( 'left', 'js_composer' ) => 'left',
							esc_html__( 'right', 'js_composer' ) => 'right',
							esc_html__( 'bottom', 'js_composer' ) => 'bottom',
						),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button border radius', 'js_composer' ),
						'param_name' => 'btn_border_radius',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'rounded-0',
							esc_html__( 'pill', 'js_composer' ) => '50rem',
							esc_html__( 'rounded', 'js_composer' ) => '.25rem',
							esc_html__( '0px', 'js_composer' ) => '0px',
							esc_html__( '1px', 'js_composer' ) => '1px',
							esc_html__( '3px', 'js_composer' ) => '3px',
							esc_html__( '5px', 'js_composer' ) => '5px',
							esc_html__( '10px', 'js_composer' ) => '10px',
							esc_html__( '15px', 'js_composer' ) => '15px',
							esc_html__( '20px', 'js_composer' ) => '20px',
						),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button transparent', 'js_composer' ),
						'param_name' => 'btn_transparent',
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
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Text transparent', 'js_composer' ),
						'param_name' => 'btn_text_transparent',
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
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button transparent hover', 'js_composer' ),
						'param_name' => 'btn_transparent_hover',
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
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Text transparent hover', 'js_composer' ),
						'param_name' => 'btn_text_transparent_hover',
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
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Button Text decoration?', 'js_composer'),
						'param_name' => 'btn_decoration',
						'std' => 'yes',
						'save_always' => true,
						'not_empty' => true,
						'value' => array(
							esc_html__('No', 'js_composer') => 'no',
							esc_html__('Yes', 'js_composer') => 'yes',
						),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button Padding', 'js_composer' ),
						'param_name' => 'btn_padding',
						'value' => '',
						"description" => esc_html__("Enter value in your string. e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button Margin', 'js_composer' ),
						'param_name' => 'btn_margin',
						'value' => '',
						"description" => esc_html__("Enter value in your string. e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					

				),
			);
		}
		public function output($atts, $content = null)
		{

			$block_id = isset($atts['el_id']) ? ' id="'.$atts['el_id'].'"' : '';
			$attribute = isset($atts['el_attribute']) ? ' ' . $atts['el_attribute'] : '';
			$classname = isset($atts['el_class']) ? ' ' . $atts['el_class'] : '';
			$content_padding = isset($atts['content_padding']) ? $atts['content_padding'] : null;
			$content_margin = isset($atts['content_margin']) ? $atts['content_margin'] : null;
			$title = isset($atts['title']) ? $atts['title'] : null;
			$img_single = isset($atts['img_single']) ? $atts['img_single'] : null;
			$img_group = isset($atts['img_group']) ? $atts['img_group'] : null;
			$modal_touch = $atts['modal_touch'] ? true: false;
			$click_to_close = $atts['click_to_close'] ? true: false;
			$small_button = $atts['small_button'] ? true: false;
			$add_animation = $atts['add_animation'] ? true: false;
			$tag = isset($atts["tag"]) ? $atts["tag"] : 'h3';
			$popup_tag = isset($atts["popup_tag"]) ? $atts["popup_tag"] : 'h3';
			$popup_title = isset($atts["popup_title"]) ? $atts["popup_title"] : 'Popup';
			$max_width = isset($atts["max_width"]) ? $atts["max_width"] : null;
			// BUTTON 
			$btn_bg = isset($atts['btn_bg']) ? $atts['btn_bg'] : null;
			$btn_hover_bg = isset($atts['btn_hover_bg']) ? $atts['btn_hover_bg'] : null;
			$btn_color = isset($atts['btn_color']) ? $atts['btn_color'] : null;
			$btn_hover_color = isset($atts['btn_hover_color']) ? $atts['btn_hover_color'] : null;
			$btn_border = isset($atts['btn_border']) ? $atts['btn_border'] : null;
			$btn_border_style = isset($atts['btn_border_style']) ? $atts['btn_border_style'] : null;
			$btn_border_radius = isset($atts['btn_border_radius']) ? $atts['btn_border_radius'] : null;
			$btn_padding = isset($atts['btn_padding']) ? $atts['btn_padding'] : null;
			$btn_border_color = isset($atts['btn_border_color']) ? $atts['btn_border_color'] : null;
			$btn_border_hover = isset($atts['btn_border_hover']) ? $atts['btn_border_hover'] : null;
			$btn_text_transparent = isset($atts['btn_text_transparent']) ? $atts['btn_text_transparent'] : 1;
			$btn_transparent = isset($atts['btn_transparent']) ? $atts['btn_transparent'] : 1;
			$btn_text_transparent_hover = isset($atts['btn_text_transparent_hover']) ? $atts['btn_text_transparent_hover'] : 1;
			$btn_transparent_hover = isset($atts['btn_transparent_hover']) ? $atts['btn_transparent_hover'] : 1;
			$btn_decoration = isset($atts['btn_decoration']) ? $atts['btn_decoration'] : null;
			$btn_margin = isset($atts['btn_margin']) ? $atts['btn_margin'] : null;
			$btn_font_size = isset($atts['btn_font_size']) ? ' '. $atts['btn_font_size'] : null;
			$btn_line_height = isset($atts['btn_line_height']) ? $atts['btn_line_height'] : null;
			
			// Admin
			$settings = shortcode_atts(array(
				'el_attribute' => '',
				'el_id' => '',
				'el_class' => '',
			), $atts);
			extract($settings);
			
			// CSSBUILD 
			$randomNumClass = $atts['el_idgen'];
			$cssname_box = '.fancybox-container .fancybox-stage #modal'.$randomNumClass;
			$cssname = '.wow_vc_'.$randomNumClass;
			$css_build = '';
			$css_build .= $content_padding ? ''. $cssname_box.'{padding:'.$content_padding.'!important;}' : null;
			$css_build .= $content_margin ? ''. $cssname_box.'{margin:'.$content_margin.'!important;}' : null;
			$css_build .= $max_width ? ''. $cssname_box.'{max-width:'.$max_width.'!important;margin:0 auto!important}' : null;
			// BUTTON 
			$css_build .= $btn_color ? ''. $cssname.' .wow-vc-title-link{color:'.$this->wowHexToRGB($btn_color,$btn_text_transparent).'!important}' : null;
			$css_build .= $btn_bg ? ''. $cssname.' .wow-vc-title-link{background-color:'.$this->wowHexToRGB($btn_bg,$btn_transparent).'!important}' : null;
			$css_build .= $btn_border_color ? ''. $cssname.' .wow-vc-title-link{border-color:'.$this->wowHexToRGB($btn_border_color).'!important}' : null;
			$css_build .= $btn_border ? ''. $cssname.' .wow-vc-title-link{border-style:solid!important;border-width:'.$btn_border.'!important;}' : null;
			if($btn_border_style) {
				if($btn_border_style === 'top') {
					$css_build .= ''. $cssname.' .wow-vc-title-link{border-left-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($btn_border_style === 'bottom') {
					$css_build .= ''. $cssname.' .wow-vc-title-link{border-left-width:0!important;border-right-width:0!important;border-top-width:0!important}';
				} else if($btn_border_style === 'left') {
					$css_build .= ''. $cssname.' .wow-vc-title-link{border-top-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($btn_border_style === 'right') {
					$css_build .= ''. $cssname.' .wow-vc-title-link{border-top-width:0!important;border-left-width:0!important;border-bottom-width:0!important}';
				}
			}
			$css_build .= $btn_border_radius ? ''. $cssname.' .wow-vc-title-link{border-radius:'.$btn_border_radius.'!important;}' : null;
			$css_build .= $btn_padding ? ''. $cssname.' .wow-vc-title-link{padding:'.$btn_padding.'!important;}' : null;
			$css_build .= $btn_margin ? ''. $cssname.' .wow-vc-title-link{margin:'.$btn_margin.'!important;}' : null;
			$css_build .= ($btn_decoration && $btn_decoration === 'yes') ? ''. $cssname.' .wow-vc-title-link{text-decoration: none!important;}' : null;
			$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-title-link:hover{color:'.$this->wowHexToRGB($btn_hover_color,$btn_text_transparent_hover).'!important}' : null;
			$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-title-link:focus{color:'.$this->wowHexToRGB($btn_hover_color,$btn_text_transparent_hover).'!important}' : null;
			$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-title-link:active{color:'.$this->wowHexToRGB($btn_hover_color,$btn_text_transparent_hover).'!important}' : null;
			$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-title-link:hover{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
			$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-title-link:focus{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
			$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-title-link:active{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
			$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-title-link:hover{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
			$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-title-link:focus{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
			$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-title-link:active{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
			$css_build .= $btn_line_height ? ''. $cssname.' .wow-vc-title-link{line-height:'.$btn_line_height.'!important;}' : null;

			$modal_build = '';
			$modal_build .= $click_to_close ? ' data-modal="true"' : '';
			$modal_build .= $add_animation ? ' data-animation-duration="0"' : '';
			$modal_build .= $modal_touch ? ' data-touch="false"' : '';
			$modal_build .= $small_button ? ' data-options=\'{"smallBtn" : false}\'' : '';
			
			// FrontEnd
			$output = $css_build ? '<style>' .$css_build. '</style>' : '';
			$output .= '<section'. $block_id .' class="wow-vc-elements wow-vc-' . $this->name. $classname.' wow_vc_'.$randomNumClass.'"' . str_replace('``', '', $attribute) . '>';
			$output .= $popup_title ? $this->applyHeadingCustomPost($popup_title,$popup_tag,'javascript:;','data-fancybox data-src="#modal'.$randomNumClass.'"'.$modal_build.'') : null;

			$output .= '<div style="display: none;" id="modal'.$randomNumClass.'">';
			$output .=  $title ? $this->applyHeadingCustomPost($title,$tag) : null;
			$output .= $content ? '<div class="wow-vc-popup-content"><p>' . do_shortcode($content) . '</p></div>' : null;
			$output .= $click_to_close ? '<div class="wow-vc-click-to-close"><button data-fancybox-close class="fancybox-button fancybox-button--close" title="Close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 10.6L6.6 5.2 5.2 6.6l5.4 5.4-5.4 5.4 1.4 1.4 5.4-5.4 5.4 5.4 1.4-1.4-5.4-5.4 5.4-5.4-1.4-1.4-5.4 5.4z"></path></svg></button></div>' : null;
			$output .= '</div>';
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
new wowVC_Addons_Popup;
