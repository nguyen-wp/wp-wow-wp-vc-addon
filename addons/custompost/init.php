<?php

if (!defined('ABSPATH')) {
	die('Silly human what are you doing here');
}


if (!class_exists('wowVC_Addons_CustomPost')) {

	class wowVC_Addons_CustomPost extends WOW_VC_Helpers
	{

		public $name = 'custompost';
		public $pNicename = 'WOW Magic Posts';

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
				'category' => __('WOW Addons', 'js_composer'),
				'icon' => 'icon-wow-vc-adminicon icon-wow-vc-' . $this->name,
				'show_settings_on_create' => true,
				'params'      => array(
					array(
						"type" => "loop",
						"holder" => "div",
						"class" => "",
						"heading" => __( "Field Label", "js_composer" ),
						"param_name" => "field_name",
						"value" => __( "", "js_composer" ),
						"description" => __( "Select post types to populate posts from. Note: If no post type is selected, WordPress will use default Post value.", "js_composer" ),
						'admin_label' => true,
						'group' => $this->pNicename,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Columns', 'js_composer' ),
						'param_name' => 'column_layout',
						'save_always' => true,
						'not_empty' => true,
						'std' => '4-column',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => '4-column',
							esc_html__( '1 column', 'js_composer' ) => '1-column',
							esc_html__( '2 column', 'js_composer' ) => '2-column',
							esc_html__( '3 column', 'js_composer' ) => '3-column',
							esc_html__( '4 column', 'js_composer' ) => '4-column',
							esc_html__( '5 column', 'js_composer' ) => '5-column',
							esc_html__( '6 column', 'js_composer' ) => '6-column',
						),
						'edit_field_class' => 'vc_col-sm-4',
						'group' => $this->pNicename,
					),
					
					
					// array(
					// 	'type' => 'dropdown',
					// 	'heading' => esc_html__( 'Offset', 'js_composer' ),
					// 	'param_name' => 'offset',
					// 	'value' => array(
					// 		esc_html__( 'Default', 'js_composer' ) => '0',
					// 		esc_html__( 'Offset 1', 'js_composer' ) => '1',
					// 		esc_html__( 'Offset 2', 'js_composer' ) => '2',
					// 		esc_html__( 'Offset 3', 'js_composer' ) => '3',
					// 		esc_html__( 'Offset 4', 'js_composer' ) => '4',
					// 		esc_html__( 'Offset 5', 'js_composer' ) => '5',
					// 		esc_html__( 'Offset 6', 'js_composer' ) => '6',
					// 		esc_html__( 'Offset 7', 'js_composer' ) => '7',
					// 		esc_html__( 'Offset 8', 'js_composer' ) => '8',
					// 		esc_html__( 'Offset 9', 'js_composer' ) => '9',
					// 		esc_html__( 'Offset 10', 'js_composer' ) => '10',
					// 		esc_html__( 'Offset 11', 'js_composer' ) => '11',
					// 		esc_html__( 'Offset 12', 'js_composer' ) => '12',
					// 		esc_html__( 'Offset 13', 'js_composer' ) => '13',
					// 		esc_html__( 'Offset 14', 'js_composer' ) => '14',
					// 		esc_html__( 'Offset 15', 'js_composer' ) => '15',
					// 		esc_html__( 'Offset 16', 'js_composer' ) => '16',
					// 		esc_html__( 'Offset 17', 'js_composer' ) => '17',
					// 		esc_html__( 'Offset 18', 'js_composer' ) => '18',
					// 		esc_html__( 'Offset 19', 'js_composer' ) => '19',
					// 		esc_html__( 'Offset 20', 'js_composer' ) => '20',
					// 	),
					// 	'description' => esc_html__( 'Offset posts', 'js_composer' ),
					// 	'edit_field_class' => 'vc_col-sm-4',
					// 	'group' => $this->pNicename,
					// ),
					
					
					
					

					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Masonry layout', 'js_composer' ),
						'param_name' => 'masonry',
						'save_always' => true,
						'value' => array(esc_html__('Yes', 'js_composer') => true),
						'edit_field_class' => 'vc_col-sm-4',
						'group' => $this->pNicename,
					),
					
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Full height', 'js_composer' ),
						'param_name' => 'full_height',
						'value' => array(esc_html__('Yes', 'js_composer') => true),
						'edit_field_class' => 'vc_col-sm-4',
						'group' => $this->pNicename,
					),
					
					
					
					
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Box layout', 'js_composer' ),
						'param_name' => 'theme',
						'admin_label' => true,
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'Image bottom', 'js_composer' ) => 'style-1',
						),
						'description' => esc_html__( 'Select box layout.', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col pt-0',
						'group' => __('Items Format', 'js_composer')
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
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col pt-0',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Image size', 'js_composer' ),
						'param_name' => 'img_size_list',
						'value' => $taxonomies,
						'description' => esc_html__( 'Image size posts', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col pt-0',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Number of words', 'js_composer' ),
						'param_name' => 'number_words',
						'save_always' => true,
						'not_empty' => true,
						'value' => '100',
						'edit_field_class' => 'vc_col-sm-3',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Trim words', 'js_composer' ),
						'param_name' => 'trim_words',
						'value' => '[...]',
						'not_empty' => true,
						'save_always' => true,
						'edit_field_class' => 'vc_col-sm-3',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Content Padding', 'js_composer' ),
						'param_name' => 'box_padding',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-3',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Content Gutters', 'js_composer' ),
						'param_name' => 'box_margin',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => '0',
							esc_html__( '.5rem', 'js_composer' ) => '.5rem',
							esc_html__( '1rem', 'js_composer' ) => '1rem',
							esc_html__( '1.5rem', 'js_composer' ) => '1.5rem',
							esc_html__( '2rem', 'js_composer' ) => '2rem',
							esc_html__( '2.5rem', 'js_composer' ) => '2.5rem',
							esc_html__( '3rem', 'js_composer' ) => '3rem',
							esc_html__( '3.5rem', 'js_composer' ) => '3.5rem',
							esc_html__( '4rem', 'js_composer' ) => '4rem',
						),
						'edit_field_class' => 'vc_col-sm-3',
						'group' => __('Items Format', 'js_composer')
					),
					
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Enable Author', 'js_composer' ),
						'param_name' => 'post_author',
						'value' => array(esc_html__('Yes', 'js_composer') => true),
						'edit_field_class' => 'vc_col-sm-3',
						'group' => __('Items Format', 'js_composer'),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Enable Date', 'js_composer' ),
						'param_name' => 'post_date',
						'value' => array(esc_html__('Yes', 'js_composer') => true),
						'edit_field_class' => 'vc_col-sm-3',
						'group' => __('Items Format', 'js_composer'),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Enable Category', 'js_composer' ),
						'param_name' => 'post_category',
						'value' => array(esc_html__('Yes', 'js_composer') => true),
						'edit_field_class' => 'vc_col-sm-3',
						'group' => __('Items Format', 'js_composer'),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Display 1 Category', 'js_composer' ),
						'param_name' => 'post_category_one',
						'value' => array(esc_html__('Yes', 'js_composer') => true),
						'edit_field_class' => 'vc_col-sm-3',
						'group' => __('Items Format', 'js_composer'),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Enable Thumbnail', 'js_composer' ),
						'param_name' => 'post_img',
						'value' => array(esc_html__('Yes', 'js_composer') => true),
						'edit_field_class' => 'vc_col-sm-3',
						'group' => __('Items Format', 'js_composer'),
					),
					
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Add button', 'js_composer' ) . '?',
						'edit_field_class' => 'vc_col-sm-3',
						'param_name' => 'add_button',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Add box click', 'js_composer' ) . '?',
						'edit_field_class' => 'vc_col-sm-3',
						'param_name' => 'add_box_button',
						'group' => __('Items Format', 'js_composer')
					),

					array(
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Readmore button format", "js_composer" ),
						"param_name" => "group_header_3",
						"edit_field_class" => "",
						"value" => '',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button text', 'js_composer' ),
						'param_name' => 'btn_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button text hover', 'js_composer' ),
						'param_name' => 'btn_hover_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button background', 'js_composer' ),
						'param_name' => 'btn_bg',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button hover background', 'js_composer' ),
						'param_name' => 'btn_hover_bg',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button border color', 'js_composer' ),
						'param_name' => 'btn_border_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button border hover', 'js_composer' ),
						'param_name' => 'btn_border_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Items Format', 'js_composer')
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
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button line height', 'js_composer' ),
						'param_name' => 'btn_line_height',
						'description' => esc_html__( 'Enter button line height. e.g. 1.5 or 1.5rem', 'js_composer' ),
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Items Format', 'js_composer')
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
						'description' => esc_html__( 'Select Button border', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Items Format', 'js_composer')
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
						'description' => esc_html__( 'Select Button border style', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Items Format', 'js_composer')
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
						'description' => esc_html__( 'Select Button border radius', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Items Format', 'js_composer')
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
						'description' => esc_html__( 'Select Button transparent', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button Text transparent', 'js_composer' ),
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
						'description' => esc_html__( 'Select Button transparent hover', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button Padding', 'js_composer' ),
						'param_name' => 'btn_padding',
						'value' => '',
						"description" => esc_html__("Enter value in your string. e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Items Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button Margin', 'js_composer' ),
						'param_name' => 'btn_margin',
						'value' => '',
						"description" => esc_html__("Enter value in your string. e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Items Format', 'js_composer')
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
						'group' => __('Items Format', 'js_composer')
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Box border', 'js_composer' ),
						'param_name' => 'box_border_size',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( '0', 'js_composer' ) => '0',
							esc_html__( '1px', 'js_composer' ) => '1px',
							esc_html__( '2px', 'js_composer' ) => '2px',
							esc_html__( '3px', 'js_composer' ) => '3px',
							esc_html__( '4px', 'js_composer' ) => '4px',
							esc_html__( '5px', 'js_composer' ) => '5px',
							esc_html__( '10px', 'js_composer' ) => '10px',
							esc_html__( '15px', 'js_composer' ) => '15px',
							esc_html__( '20px', 'js_composer' ) => '20px',
							esc_html__( '25px', 'js_composer' ) => '25px',
							esc_html__( '30px', 'js_composer' ) => '30px',
							esc_html__( '35px', 'js_composer' ) => '35px',
						),
						'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col pt-0',
						'group' => esc_html__('Box option', 'js_composer'),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Box radius', 'js_composer' ),
						'param_name' => 'box_radius',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( '0', 'js_composer' ) => '0',
							esc_html__( '1px', 'js_composer' ) => '1px',
							esc_html__( '2px', 'js_composer' ) => '2px',
							esc_html__( '3px', 'js_composer' ) => '3px',
							esc_html__( '4px', 'js_composer' ) => '4px',
							esc_html__( '5px', 'js_composer' ) => '5px',
							esc_html__( '10px', 'js_composer' ) => '10px',
							esc_html__( '15px', 'js_composer' ) => '15px',
							esc_html__( '20px', 'js_composer' ) => '20px',
							esc_html__( '25px', 'js_composer' ) => '25px',
							esc_html__( '30px', 'js_composer' ) => '30px',
							esc_html__( '35px', 'js_composer' ) => '35px',
						),
						'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col pt-0',
						'group' => esc_html__('Box option', 'js_composer'),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Box radius hover', 'js_composer' ),
						'param_name' => 'box_radius_hover',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( '0', 'js_composer' ) => '0',
							esc_html__( '1px', 'js_composer' ) => '1px',
							esc_html__( '2px', 'js_composer' ) => '2px',
							esc_html__( '3px', 'js_composer' ) => '3px',
							esc_html__( '4px', 'js_composer' ) => '4px',
							esc_html__( '5px', 'js_composer' ) => '5px',
							esc_html__( '10px', 'js_composer' ) => '10px',
							esc_html__( '15px', 'js_composer' ) => '15px',
							esc_html__( '20px', 'js_composer' ) => '20px',
							esc_html__( '25px', 'js_composer' ) => '25px',
							esc_html__( '30px', 'js_composer' ) => '30px',
							esc_html__( '35px', 'js_composer' ) => '35px',
						),
						'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col pt-0',
						'group' => esc_html__('Box option', 'js_composer'),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Transition', 'js_composer' ),
						'param_name' => 'box_transition',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( '.15s', 'js_composer' ) => '.15s',
							esc_html__( '.25s', 'js_composer' ) => '.25s',
							esc_html__( '.35s', 'js_composer' ) => '.35s',
							esc_html__( '.45s', 'js_composer' ) => '.45s',
							esc_html__( '.55s', 'js_composer' ) => '.55s',
							esc_html__( '.65s', 'js_composer' ) => '.65s',
							esc_html__( '.75s', 'js_composer' ) => '.75s',
							esc_html__( '.85s', 'js_composer' ) => '.85s',
							esc_html__( '.95s', 'js_composer' ) => '.95s',
							esc_html__( '1s', 'js_composer' ) => '1s',
							esc_html__( '2s', 'js_composer' ) => '2s',
							esc_html__( '3s', 'js_composer' ) => '3s',
							esc_html__( '4s', 'js_composer' ) => '4s',
						),
						'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col pt-0',
						'group' => esc_html__('Box option', 'js_composer'),
					),

					array(
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Color format", "js_composer" ),
						"param_name" => "group_header_5",
						"edit_field_class" => "",
						"value" => '',
						'group' => esc_html__('Box option', 'js_composer'),
					),
					
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Box border', 'js_composer' ),
						'param_name' => 'box_border',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => esc_html__('Box option', 'js_composer'),
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Box border hover', 'js_composer' ),
						'param_name' => 'box_border_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => esc_html__('Box option', 'js_composer'),
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Box background', 'js_composer' ),
						'param_name' => 'box_background',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => esc_html__('Box option', 'js_composer'),
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Box hover background', 'js_composer' ),
						'param_name' => 'box_background_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => esc_html__('Box option', 'js_composer'),
					),
					

					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Enable Previous/Next', 'js_composer' ) . '?',
						'param_name' => 'prev_next',
						'save_always' => true,
						'not_empty' => true,
						'std' => true,
						'value' => array(esc_html__('Yes', 'js_composer') => true),
						'edit_field_class' => 'vc_col-sm-12',
						'group' => __('Paged', 'js_composer')
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Paginated layout', 'js_composer' ),
						'param_name' => 'links_layout',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'center', 'js_composer' ) => 'wow-vc-text-center',
							esc_html__( 'right', 'js_composer' ) => 'wow-vc-text-right',
						),
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Paged', 'js_composer')
					),

					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Previous text', 'js_composer' ),
						'param_name' => 'prev_text',
						'value' => '« Previous',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Next text', 'js_composer' ),
						'param_name' => 'next_text',
						'value' => 'Next »',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Paged', 'js_composer')
					),
					array(
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Navigation format", "js_composer" ),
						"param_name" => "group_header_4",
						"edit_field_class" => "",
						"value" => '',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button text', 'js_composer' ),
						'param_name' => 'page_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button text hover', 'js_composer' ),
						'param_name' => 'page_hover_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button background', 'js_composer' ),
						'param_name' => 'page_bg',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button hover background', 'js_composer' ),
						'param_name' => 'page_hover_bg',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button border color', 'js_composer' ),
						'param_name' => 'page_border_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button border hover', 'js_composer' ),
						'param_name' => 'page_border_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button font size', 'js_composer' ),
						'param_name' => 'page_font_size',
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
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button line height', 'js_composer' ),
						'param_name' => 'page_line_height',
						'description' => esc_html__( 'Enter button line height. e.g. 1.5 or 1.5rem', 'js_composer' ),
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button border', 'js_composer' ),
						'param_name' => 'page_border',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( '0px', 'js_composer' ) => '0px',
							esc_html__( '1px', 'js_composer' ) => '1px',
							esc_html__( '2px', 'js_composer' ) => '2px',
							esc_html__( '3px', 'js_composer' ) => '3px',
							esc_html__( '4px', 'js_composer' ) => '4px',
						),
						'description' => esc_html__( 'Select Button border', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Paged', 'js_composer')
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button border style', 'js_composer' ),
						'param_name' => 'page_border_style',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'all', 'js_composer' ) => 'all',
							esc_html__( 'top', 'js_composer' ) => 'top',
							esc_html__( 'left', 'js_composer' ) => 'left',
							esc_html__( 'right', 'js_composer' ) => 'right',
							esc_html__( 'bottom', 'js_composer' ) => 'bottom',
						),
						'description' => esc_html__( 'Select Button border style', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Paged', 'js_composer')
					),
					

					
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button border radius', 'js_composer' ),
						'param_name' => 'page_border_radius',
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
						'description' => esc_html__( 'Select Button border radius', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button transparent', 'js_composer' ),
						'param_name' => 'page_transparent',
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
						'description' => esc_html__( 'Select Button transparent', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button transparent hover', 'js_composer' ),
						'param_name' => 'page_transparent_hover',
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
						'description' => esc_html__( 'Select Button transparent hover', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button Padding', 'js_composer' ),
						'param_name' => 'page_padding',
						'value' => '',
						"description" => esc_html__("Enter value in your string. e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button Margin', 'js_composer' ),
						'param_name' => 'page_margin',
						'value' => '',
						"description" => esc_html__("Enter value in your string. e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Paged', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Button Text decoration?', 'js_composer'),
						'param_name' => 'page_decoration',
						'std' => 'yes',
						'save_always' => true,
						'not_empty' => true,
						'value' => array(
							esc_html__('No', 'js_composer') => 'no',
							esc_html__('Yes', 'js_composer') => 'yes',
						),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Paged', 'js_composer')
					),
					array(
						"type" => "dropdown",
						"class" => "",
						'save_always' => true,
						"heading" => esc_html__("Image Loading", "salient-core"),
						"param_name" => "image_loading",
						"value" => array(
							"Default" => "default",
							"Lazy Load" => "lazy-load",
						),
						"description" => esc_html__("Determine whether to load the image on page load or to use a lazy load method for higher performance.", "salient-core"),
						'std' => 'default',
						'group' => __('General', 'js_composer')
					),
					// array(
					// 	'type' => 'textfield',
					// 	'heading' => esc_html__('Image size', 'js_composer'),
					// 	'param_name' => 'img_size',
					// 	'value' => 'full',
					// 	'description' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'js_composer'),
					// 	'group' => __('General', 'js_composer')
					// ),
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
			$theme = isset($atts['theme']) ? ' wow-vc-' . $atts['theme'] : '';
			$css = isset($atts["css"]) ? $atts["css"] : '';
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), $this->settings['base'], $atts);
			$classname = isset($atts['el_class']) ? ' ' . $atts['el_class'] : '';
			$tag = isset($atts["tag"]) ? $atts["tag"] : 'h2';
			$add_box_button = $atts["add_box_button"] ? true: false;
			$post_img = $atts["post_img"] ? true: false;
			$post_author = $atts["post_author"] ? true: false;
			$post_date = $atts["post_date"] ? true: false;
			$full_height = $atts["full_height"] ? ' wow-vc-full-height': '';
			$post_category = $atts["post_category"] ? true: false;
			$post_category_one = $atts["post_category_one"] ? true: false;
			$img_size_list = $atts["img_size_list"] ? $atts["img_size_list"] : 'post-thumbnail';
			$css_animation = isset($atts['css_animation']) ? ' wpb_animate_when_almost_visible wpb_' . $atts['css_animation'] . ' animate__animated animate__' . $atts['css_animation']. ' ' . $atts['css_animation'] : null;
			$add_button = $atts["add_button"] ? $atts["add_button"] : null;
			$number_words = $atts["number_words"] ? $atts["number_words"] : 0;
			$trim_words = $atts["trim_words"] ? $atts["trim_words"] : null;
			$prev_text = $atts["prev_text"] ? $atts["prev_text"] : '« Previous';
			$next_text = $atts["next_text"] ? $atts["next_text"] : 'Next »';
			$prev_next = $atts["prev_next"] ? $atts["prev_next"] : false;
			$masonry = $atts["masonry"] ? $atts["masonry"] : false;
			$links_layout = $atts["links_layout"] ? ' '. $atts["links_layout"] : ' wow-vc-text-left';
			$column_layout = $atts["column_layout"] ? ' wow-vc-'. $atts["column_layout"] : ' wow-vc-1-column';
			$masonry_layout = $masonry ? ' wow-vc-masonry-layout' : '';
			$button_text = $atts["button_text"] ? $atts["button_text"] : 'Read more';
			$content_padding = isset($atts['content_padding']) ? $atts['content_padding'] : null;
			$content_margin = isset($atts['content_margin']) ? $atts['content_margin'] : null;
			$box_padding = isset($atts['box_padding']) ? $atts['box_padding'] : null;
			$box_margin = isset($atts['box_margin']) ? $atts['box_margin'] : null;

			$box_border_size = isset($atts['box_border_size']) ? $atts['box_border_size'] : null;
			$box_radius = isset($atts['box_radius']) ? $atts['box_radius'] : null;
			$box_radius_hover = isset($atts['box_radius_hover']) ? $atts['box_radius_hover'] : null;
			$box_transition = isset($atts['box_transition']) ? $atts['box_transition'] : null;
			$box_border = isset($atts['box_border']) ? $atts['box_border'] : null;
			$box_border_hover = isset($atts['box_border_hover']) ? $atts['box_border_hover'] : null;
			$box_background = isset($atts['box_background']) ? $atts['box_background'] : null;
			$box_background_hover = isset($atts['box_background_hover']) ? $atts['box_background_hover'] : null;

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
			$btn_transparent_hover = isset($atts['btn_transparent_hover']) ? $atts['btn_transparent_hover'] : 1;
			$btn_transparent = isset($atts['btn_transparent']) ? $atts['btn_transparent'] : 1;
			$btn_decoration = isset($atts['btn_decoration']) ? $atts['btn_decoration'] : null;
			$btn_margin = isset($atts['btn_margin']) ? $atts['btn_margin'] : null;
			$btn_font_size = isset($atts['btn_font_size']) ? ' '. $atts['btn_font_size'] : null;
			$btn_line_height = isset($atts['btn_line_height']) ? $atts['btn_line_height'] : null;
			// PAGED 
			$page_bg = isset($atts['page_bg']) ? $atts['page_bg'] : null;
			$page_hover_bg = isset($atts['page_hover_bg']) ? $atts['page_hover_bg'] : null;
			$page_color = isset($atts['page_color']) ? $atts['page_color'] : null;
			$page_hover_color = isset($atts['page_hover_color']) ? $atts['page_hover_color'] : null;
			$page_border = isset($atts['page_border']) ? $atts['page_border'] : null;
			$page_border_style = isset($atts['page_border_style']) ? $atts['page_border_style'] : null;
			$page_border_radius = isset($atts['page_border_radius']) ? $atts['page_border_radius'] : null;
			$page_padding = isset($atts['page_padding']) ? $atts['page_padding'] : null;
			$page_border_color = isset($atts['page_border_color']) ? $atts['page_border_color'] : null;
			$page_border_hover = isset($atts['page_border_hover']) ? $atts['page_border_hover'] : null;
			$page_transparent_hover = isset($atts['page_transparent_hover']) ? $atts['page_transparent_hover'] : 1;
			$page_transparent = isset($atts['page_transparent']) ? $atts['page_transparent'] : 1;
			$page_decoration = isset($atts['page_decoration']) ? $atts['page_decoration'] : null;
			$page_margin = isset($atts['page_margin']) ? $atts['page_margin'] : null;
			$page_font_size = isset($atts['page_font_size']) ? ' '. $atts['page_font_size'] : null;
			$page_line_height = isset($atts['page_line_height']) ? $atts['page_line_height'] : null;

			// CSSBUILD 
			$randomNumClass = $atts['el_idgen'];
			$cssname = $atts['css'] ? vc_shortcode_custom_css_class($css, '.') : '.wow_vc_'.$randomNumClass;
			$cssaddclass = $atts['css'] ? '' : ' wow_vc_'.$randomNumClass;
			$css_build = '';
			$css_build .= $content_padding ? ''. $cssname.'{padding:'.$content_padding.'!important;}' : null;
			$css_build .= $content_margin ? ''. $cssname.'{margin:'.$content_margin.'!important;}' : null;
			$css_build .= $box_padding ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-box{padding:'.$box_padding.'!important;}' : null;

			if($masonry) {
				$css_build .= $box_margin ? ''. $cssname.' .wow-vc-layout-posts {-webkit-column-gap: '.$box_margin.'!important; -moz-column-gap: '.$box_margin.'!important; column-gap: '.$box_margin.'!important;}' : null;
				$css_build .= $box_margin ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn{margin-bottom: '.$box_margin.'!important;}' : null;
				// BOX
				$css_build .= $box_radius ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn{border-radius:'.$box_radius.'!important;}' : null;
				$css_build .= $box_radius_hover ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn:hover{border-radius:'.$box_radius_hover.'!important;}' : null;
				$css_build .= $box_border_size ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn{border-style:solid!important;border-width:'.$box_border_size.'!important;}' : null;
				$css_build .= $box_transition ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn{transition:all ease-in-out '.$box_transition.'!important;}' : null;
				$css_build .= $box_border ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn {border-color:'.$this->wowHexToRGB($box_border).'!important;}' : null;
				$css_build .= $box_border_hover ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn:hover {border-color:'.$this->wowHexToRGB($box_border_hover).'!important;}' : null;
				$css_build .= $box_background ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn{background-color:'.$this->wowHexToRGB($box_background).'!important;}' : null;
				$css_build .= $box_background_hover ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn:hover{background-color:'.$this->wowHexToRGB($box_background_hover).'!important;}' : null;
			} else {
				$css_build .= $box_margin ? ''. $cssname.' .wow-vc-layout-posts {margin-left:-'.$box_margin.'!important;margin-right:-'.$box_margin.'!important;}' : null;
				$css_build .= $box_margin ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn{padding-left:'.$box_margin.'!important;padding-right:'.$box_margin.'!important;margin-bottom: '.$box_margin.'!important;}' : null;
				// BOX
				$css_build .= $box_radius ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn .wow-vc-box{border-radius:'.$box_radius.'!important;}' : null;
				$css_build .= $box_radius_hover ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn .wow-vc-box:hover{border-radius:'.$box_radius_hover.'!important;}' : null;
				$css_build .= $box_border_size ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn .wow-vc-box{border-style:solid!important;border-width:'.$box_border_size.'!important;}' : null;
				$css_build .= $box_transition ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn .wow-vc-box{transition:all ease-in-out '.$box_transition.'!important;}' : null;
				$css_build .= $box_border ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn .wow-vc-box {border-color:'.$this->wowHexToRGB($box_border).'!important;}' : null;
				$css_build .= $box_border_hover ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn .wow-vc-box:hover {border-color:'.$this->wowHexToRGB($box_border_hover).'!important;}' : null;
				$css_build .= $box_background ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn .wow-vc-box{background-color:'.$this->wowHexToRGB($box_background).'!important;}' : null;
				$css_build .= $box_background_hover ? ''. $cssname.' .wow-vc-layout-posts .wow-vc-ctn .wow-vc-box:hover{background-color:'.$this->wowHexToRGB($box_background_hover).'!important;}' : null;
			}


			// BUTTON 
			$css_build .= $btn_color ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{color:'.$this->wowHexToRGB($btn_color).'!important}' : null;
			$css_build .= $btn_bg ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{background-color:'.$this->wowHexToRGB($btn_bg,$btn_transparent).'!important}' : null;
			$css_build .= $btn_border_color ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{border-color:'.$this->wowHexToRGB($btn_border_color).'!important}' : null;
			$css_build .= $btn_border ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{border-style:solid!important;border-width:'.$btn_border.'!important;}' : null;
			if($btn_border_style) {
				if($btn_border_style === 'top') {
					$css_build .= ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{border-left-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($btn_border_style === 'bottom') {
					$css_build .= ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{border-left-width:0!important;border-right-width:0!important;border-top-width:0!important}';
				} else if($btn_border_style === 'left') {
					$css_build .= ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{border-top-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($btn_border_style === 'right') {
					$css_build .= ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{border-top-width:0!important;border-left-width:0!important;border-bottom-width:0!important}';
				}
			}
			$css_build .= $btn_border_radius ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{border-radius:'.$btn_border_radius.'!important;}' : null;
			$css_build .= $btn_padding ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{padding:'.$btn_padding.'!important;}' : null;
			$css_build .= $btn_margin ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{margin:'.$btn_margin.'!important;}' : null;
			$css_build .= ($btn_decoration && $btn_decoration === 'yes') ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*{text-decoration: none!important;}' : null;

			if($add_box_button){
				$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-ctn:hover .wow-vc-button >*{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-ctn:focus .wow-vc-button >*{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-ctn:active .wow-vc-button >*{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-ctn:hover .wow-vc-button >*{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-ctn:focus .wow-vc-button >*{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-ctn:active .wow-vc-button >*{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-ctn:hover .wow-vc-button >*{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-ctn:focus .wow-vc-button >*{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-ctn:active .wow-vc-button >*{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
			} else {
				$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*:hover{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*:focus{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*:active{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*:hover{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*:focus{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*:active{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*:hover{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*:focus{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-ctn .wow-vc-button >*:active{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
			}
			$css_build .= $btn_line_height ? ''. $cssname.' .wow-vc-ctn .wow-vc-button .wow-vc-title-link{line-height:'.$btn_line_height.'!important;}' : null;
			// PAGED 
			$css_build .= $page_color ? ''. $cssname.' .wow-vc-paging >*{color:'.$this->wowHexToRGB($page_color).'!important}' : null;
			$css_build .= $page_bg ? ''. $cssname.' .wow-vc-paging >*{background-color:'.$this->wowHexToRGB($page_bg,$page_transparent).'!important}' : null;
			$css_build .= $page_border_color ? ''. $cssname.' .wow-vc-paging >*{border-color:'.$this->wowHexToRGB($page_border_color).'!important}' : null;
			$css_build .= $page_border ? ''. $cssname.' .wow-vc-paging >*{border-style:solid!important;border-width:'.$page_border.'!important;}' : null;
			if($page_border_style) {
				if($page_border_style === 'top') {
					$css_build .= ''. $cssname.' .wow-vc-paging >*{border-left-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($page_border_style === 'bottom') {
					$css_build .= ''. $cssname.' .wow-vc-paging >*{border-left-width:0!important;border-right-width:0!important;border-top-width:0!important}';
				} else if($page_border_style === 'left') {
					$css_build .= ''. $cssname.' .wow-vc-paging >*{border-top-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($page_border_style === 'right') {
					$css_build .= ''. $cssname.' .wow-vc-paging >*{border-top-width:0!important;border-left-width:0!important;border-bottom-width:0!important}';
				}
			}
			$css_build .= $page_border_radius ? ''. $cssname.' .wow-vc-paging >*{border-radius:'.$page_border_radius.'!important;}' : null;
			$css_build .= $page_padding ? ''. $cssname.' .wow-vc-paging >*{padding:'.$page_padding.'!important;}' : null;
			$css_build .= $page_margin ? ''. $cssname.' .wow-vc-paging >*{margin:'.$page_margin.'!important;}' : null;
			$css_build .= ($page_decoration && $page_decoration === 'yes') ? ''. $cssname.' .wow-vc-paging >*{text-decoration: none!important;}' : null;
            $css_build .= $page_hover_color ? ''. $cssname.' .wow-vc-paging >*:hover{color:'.$this->wowHexToRGB($page_hover_color).'!important}' : null;
            $css_build .= $page_hover_color ? ''. $cssname.' .wow-vc-paging >*:focus{color:'.$this->wowHexToRGB($page_hover_color).'!important}' : null;
            $css_build .= $page_hover_color ? ''. $cssname.' .wow-vc-paging >*:active{color:'.$this->wowHexToRGB($page_hover_color).'!important}' : null;
            $css_build .= $page_hover_bg ? ''. $cssname.' .wow-vc-paging >*:hover{background-color:'.$this->wowHexToRGB($page_hover_bg,$page_transparent_hover).'!important}' : null;
            $css_build .= $page_hover_bg ? ''. $cssname.' .wow-vc-paging >*:focus{background-color:'.$this->wowHexToRGB($page_hover_bg,$page_transparent_hover).'!important}' : null;
            $css_build .= $page_hover_bg ? ''. $cssname.' .wow-vc-paging >*:active{background-color:'.$this->wowHexToRGB($page_hover_bg,$page_transparent_hover).'!important}' : null;
            $css_build .= $page_border_hover ? ''. $cssname.' .wow-vc-paging >*:hover{border-color:'.$this->wowHexToRGB($page_border_hover).'!important}' : null;
            $css_build .= $page_border_hover ? ''. $cssname.' .wow-vc-paging >*:focus{border-color:'.$this->wowHexToRGB($page_border_hover).'!important}' : null;
            $css_build .= $page_border_hover ? ''. $cssname.' .wow-vc-paging >*:active{border-color:'.$this->wowHexToRGB($page_border_hover).'!important}' : null;
			$css_build .= $page_line_height ? ''. $cssname.' .wow-vc-paging {line-height:'.$page_line_height.'!important;}' : null;



			$field_name = isset($atts['field_name']) ? ' ' . $atts['field_name'] : '';
			$offset = isset($atts['offset']) ? $atts['offset'] : 0;
			$total = $this->applyQueryTotal($field_name,$offset);
			$result = new WP_Query($this->applyQuery($field_name,$offset,get_query_var( 'paged' )));

			// Admin
			$settings = shortcode_atts(array(
				'el_attribute' => '',
				'el_id' => '',
				'el_class' => '',
			), $atts);
			extract($settings);
			// FrontEnd
			$output = ($css || $css_build) ? '<style>' . $css .$css_build . '</style>' : '';
			$output .= '<section'. $block_id .' class="wow-vc-elements wow-vc-' . $this->name . $css_class. $theme.$classname.$column_layout.$masonry_layout.$cssaddclass.$css_animation.$full_height.'"' . str_replace('``', '', $attribute) . '>';

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

			$output .= '<div class="wow-vc-layout-posts clearfix">';
			
			foreach ($result->posts as &$value) {
				
				$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($value->ID), $img_size_list)[0];
				$image_meta = wp_get_attachment_metadata(get_post_thumbnail_id($value->ID));
				
				if (function_exists('wp_get_attachment_image_srcset')) {
					$image_srcset_values = wp_get_attachment_image_srcset(get_post_thumbnail_id($value->ID), $img_size_list);
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
				$wp_img_alt_tag = get_post_meta(get_post_thumbnail_id($value->ID), '_wp_attachment_image_alt', true);
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

				if($atts["theme"] === 'style-1') {
					include 'layout/style-1.php';
				} 
				else {
					include 'layout/default.php';
				}

			}

			$output .= '</div>';

			// PAGING 
			wp_reset_query();
			$pageding =  paginate_links( array(
				'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'total'        => $total,
				'current'      => max( 1, get_query_var( 'paged' ) ),
				'format'       => '?paged=%#%',
				// 'show_all'     => false,
				'type'         => 'plain',
				'end_size'     => 2,
				'mid_size'     => 1,
				'prev_next'    => $prev_next,
				'prev_text'    => sprintf( '%1$s', __( $prev_text, 'text-domain' ) ),
				'next_text'    => sprintf( '%1$s', __( $next_text, 'text-domain' ) ),
				'add_args'     => true,
				'add_fragment' => '',
			) );

			$output .= '<nav class="wow-vc-paging'.$links_layout.''.$page_font_size.'">'.$pageding.'</nav>';
			$output .= '</section><!-- .wow-vc-' . $this->name . ' -->';

			return apply_filters(
				'wow_vc_' . $this->name . '_output',
				$output,
				$content,
				$settings
			);
		}
	}
}
new wowVC_Addons_CustomPost;
