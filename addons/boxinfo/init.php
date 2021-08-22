<?php

/**
 * the WPBakery Visual Composer plugin by Nguyen Pham
 */

if (!defined('ABSPATH')) {
	die('Silly human what are you doing here');
}


if (!class_exists('wowVC_Addons_BoxInfo')) {

	class wowVC_Addons_BoxInfo extends WOW_VC_Helpers
	{

		public $name = 'boxinfo';
		public $pNicename = 'WOW Magic Box';

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
			$taxonomies[esc_html__('Other', 'js_composer')] = 'other';

			return array(
				'name'        => esc_html__($this->pNicename, 'js_composer'),
				'description' => esc_html__('Add new ' . $this->pNicename, 'js_composer'),
				'base'        => 'wow_vc_' . $this->name,
				'category' => __('WOW Addons', 'js_composer'),
				"controls" => "full",
				'icon' => 'icon-wow-vc-adminicon icon-wow-vc-' . $this->name,
				'show_settings_on_create' => true,
				//'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
            	//'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
				'params'      => array(
					array(
						'type' => 'textfield',
						'holder' => 'h2',
						'class' => 'wow-vc-title',
						'heading' => __('Heading', 'js_composer'),
						'param_name' => 'title',
						'value' => __('', 'js_composer'),
						'weight' => 0,
						'group' => $this->pNicename,
					),
					array(
						'type' => 'textarea_html',
						'holder' => 'div',
						'class' => 'wow-vc-content',
						'heading' => __('Description', 'js_composer'),
						'param_name' => 'content',
						'value' => __('<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>', 'js_composer'),
						'description' => __('To add link highlight text or url and click the chain to apply hyperlink', 'js_composer'),
						'group' => $this->pNicename,
					),
					array(
						'type' => 'vc_link',
						'heading' => esc_html__('URL (Link)', 'js_composer'),
						'param_name' => 'link',
						'description' => esc_html__('Add link to custom heading.', 'js_composer'),
						'group' => $this->pNicename,
					),
					array(
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Options", "js_composer" ),
						"param_name" => "group_header_4",
						"edit_field_class" => "",
						"value" => '',
						'group' => $this->pNicename,
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Add heading click', 'js_composer' ) . '?',
						'description' => esc_html__( 'Add heading click into box.', 'js_composer' ),
						'param_name' => 'add_heading_click',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => $this->pNicename,
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Add button', 'js_composer' ) . '?',
						'description' => esc_html__( 'Add button into box.', 'js_composer' ),
						'param_name' => 'add_button',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => $this->pNicename,
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Add box click', 'js_composer' ) . '?',
						'description' => esc_html__( 'Add box click.', 'js_composer' ),
						'param_name' => 'add_box_button',
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
							esc_html__( 'Image left', 'js_composer' ) => 'style-2',
							esc_html__( 'Image right', 'js_composer' ) => 'style-3',
							// esc_html__( 'Box hover', 'js_composer' ) => 'style-4',
							// esc_html__( 'Flip X', 'js_composer' ) => 'style-5',
							// esc_html__( 'Flip Y', 'js_composer' ) => 'style-6',
						),
						'description' => esc_html__( 'Select box layout.', 'js_composer' ),
						'group' => __('Format', 'js_composer')
					),
					array(
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Heading format", "js_composer" ),
						"param_name" => "group_header_5",
						"edit_field_class" => "",
						"value" => '',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'font_container',
						'param_name' => 'font_container',
						'value' => 'tag:h2|text_align:left',
						'settings' => array(
							'fields' => array(
								'tag' => 'h2',
								'text_align',
								'color',
								// 'font_size',
								// 'line_height',
								'tag_description' => esc_html__('Select element tag.', 'js_composer'),
								'text_align_description' => esc_html__('Select text alignment.', 'js_composer'),
								'font_size_description' => esc_html__('Enter heading font size.', 'js_composer'),
								'line_height_heading' => esc_html__('Heading line height', 'js_composer'),
								'line_height_description' => esc_html__('Enter heading line height.', 'js_composer'),
								'color_description' => esc_html__('Select heading color.', 'js_composer'),
							),
						),
						'edit_field_class' => 'vc_col-xs-12 wow-vc-childcol-3',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Text color hover', 'js_composer' ),
						'param_name' => 'text_color_hover',
						'description' => esc_html__( 'Select text color hover.', 'js_composer' ),
						'value' => '',
						'edit_field_class' => 'vc_col-sm-12',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Heading Padding', 'js_composer' ),
						'param_name' => 'text_padding',
						'value' => '',
						"description" => esc_html__("Enter value in your string. e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Heading Margin', 'js_composer' ),
						'param_name' => 'text_margin',
						'value' => '',
						"description" => esc_html__("Enter value in your string. e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Heading font size', 'js_composer' ),
						'param_name' => 'font_size',
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
						'description' => esc_html__( 'Select heading font size', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Heading line height', 'js_composer' ),
						'param_name' => 'line_height',
						'description' => esc_html__( 'Enter heading line height. e.g. 1.5 or 1.5rem', 'js_composer' ),
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Heading transition hover', 'js_composer' ),
						'param_name' => 'transition_hover',
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
						'description' => esc_html__( 'Select heading transition hover', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Description format", "js_composer" ),
						"param_name" => "group_header_1",
						"edit_field_class" => "",
						"value" => '',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Description color', 'js_composer' ),
						'param_name' => 'desc_color',
						'description' => esc_html__( 'Select description color.', 'js_composer' ),
						'value' => '',
						'edit_field_class' => 'vc_col-sm-12',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Description color hover', 'js_composer' ),
						'param_name' => 'desc_color_hover',
						'description' => esc_html__( 'Select description color hover.', 'js_composer' ),
						'value' => '',
						'edit_field_class' => 'vc_col-sm-12',
						'group' => __('Format', 'js_composer')
					),

					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Description Padding', 'js_composer' ),
						'param_name' => 'desc_padding',
						'value' => '',
						"description" => esc_html__("Enter value in your string. e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Description Margin', 'js_composer' ),
						'param_name' => 'desc_margin',
						'value' => '',
						"description" => esc_html__("Enter value in your string. e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Description font size', 'js_composer' ),
						'param_name' => 'desc_font_size',
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
						'description' => esc_html__( 'Select description font size.', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Line height', 'js_composer' ),
						'param_name' => 'desc_line_height',
						'description' => esc_html__( 'Enter description line height. e.g. 1.5 or 1.5rem', 'js_composer' ),
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Transition hover', 'js_composer' ),
						'param_name' => 'desc_transition_hover',
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
						'description' => esc_html__( 'Select Description transition hover', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Button format", "js_composer" ),
						"param_name" => "group_header_3",
						"edit_field_class" => "",
						"value" => '',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button text', 'js_composer' ),
						'param_name' => 'btn_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button text hover', 'js_composer' ),
						'param_name' => 'btn_hover_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Button background', 'js_composer' ),
						'param_name' => 'btn_bg',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
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
							esc_html__( '0px', 'js_composer' ) => '0px',
							esc_html__( '1px', 'js_composer' ) => '1px',
							esc_html__( '2px', 'js_composer' ) => '2px',
							esc_html__( '3px', 'js_composer' ) => '3px',
							esc_html__( '4px', 'js_composer' ) => '4px',
						),
						'description' => esc_html__( 'Select Button border', 'js_composer' ),
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
						'description' => esc_html__( 'Select Button border style', 'js_composer' ),
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
						'description' => esc_html__( 'Select Button border radius', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button transparent', 'js_composer' ),
						'param_name' => 'btn_transparent',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => '1',
							esc_html__( '1', 'js_composer' ) => '1',
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
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Button transparent hover', 'js_composer' ),
						'param_name' => 'btn_transparent_hover',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => '1',
							esc_html__( '1', 'js_composer' ) => '1',
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
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Font format", "js_composer" ),
						"param_name" => "group_header_1",
						"edit_field_class" => "",
						"value" => '',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('Use theme default font family?', 'js_composer'),
						'param_name' => 'use_theme_fonts',
						'save_always' => true,
						'not_empty' => true,
						'std' => 'yes',
						'value' => array(esc_html__('Yes', 'js_composer') => 'yes'),
						'description' => esc_html__('Use font family from the theme.', 'js_composer'),
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'google_fonts',
						'param_name' => 'google_fonts',
						'value' => '',
						'settings' => array(
							'fields' => array(
								'font_family_description' => esc_html__('Select font family.', 'js_composer'),
								'font_style_description' => esc_html__('Select font styling.', 'js_composer'),
							),
						),
						'save_always' => true,
						'dependency' => array(
							'element' => 'use_theme_fonts',
							'value_not_equal_to' => 'yes',
						),
						'group' => __('Format', 'js_composer')
					),
					array(
						'type'       => 'attach_image',
						'holder' => 'img',
						'heading' => __('Image', 'js_composer'),
						'param_name' => 'bgimg',
						'class' => 'wow-vc-bgimg',
						'weight' => 0,
						'edit_field_class' => 'vc_col-sm-6 admin-wow-vc-col pt-0',
						'group' => __('Images & Icons', 'js_composer')
					),
					
					array(
						'type' => 'dropdown',
						'heading' => __('Icon library', 'js_composer'),
						'value' => array(
							esc_html__('None', 'js_composer') => 'none',
							esc_html__('Font Awesome', 'js_composer') => 'fontawesome',
							esc_html__('Iconsmind', 'js_composer') => 'iconsmind',
							esc_html__('Linea', 'js_composer') => 'linea',
							esc_html__('Steadysets', 'js_composer') => 'steadysets',
							esc_html__('Linecons', 'js_composer') => 'linecons',

							esc_html__( 'Open Iconic', 'js_composer' ) => 'openiconic',
							esc_html__( 'Typicons', 'js_composer' ) => 'typicons',
							esc_html__( 'Entypo', 'js_composer' ) => 'entypo',
							esc_html__( 'Mono Social', 'js_composer' ) => 'monosocial',
							esc_html__( 'Material', 'js_composer' ) => 'material',

						),
						'save_always' => true,
						'param_name' => 'icon_family',
						'description' => __('Select icon library.', 'js_composer'),
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", "js_composer"),
						"param_name" => "icon_fontawesome",
						"settings" => array("iconsPerPage" => 240),
						"dependency" => array('element' => "icon_family", 'emptyIcon' => false, 'value' => 'fontawesome'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Images & Icons', 'js_composer')
					),


					array(
						'type' => 'iconpicker',
						'heading' => __( 'Icon', 'js_composer' ),
						'param_name' => 'icon_openiconic',
						"settings" => array('type' => 'openiconic', 'emptyIcon' => false, "iconsPerPage" => 240),
						'dependency' => array('element' => 'icon_family','value' => 'openiconic'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						'type' => 'iconpicker',
						'heading' => __( 'Icon', 'js_composer' ),
						'param_name' => 'icon_typicons',
						"settings" => array('type' => 'typicons', 'emptyIcon' => false, "iconsPerPage" => 240),
						'dependency' => array('element' => 'icon_family','value' => 'typicons'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						'type' => 'iconpicker',
						'heading' => __( 'Icon', 'js_composer' ),
						'param_name' => 'icon_entypo',
						"settings" => array('type' => 'entypo', 'emptyIcon' => false, "iconsPerPage" => 240),
						'dependency' => array('element' => 'icon_family','value' => 'entypo'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						'type' => 'iconpicker',
						'heading' => __( 'Icon', 'js_composer' ),
						'param_name' => 'icon_monosocial',
						"settings" => array('type' => 'monosocial', 'emptyIcon' => false, "iconsPerPage" => 240),
						'dependency' => array('element' => 'icon_family','value' => 'monosocial'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						'type' => 'iconpicker',
						'heading' => __( 'Icon', 'js_composer' ),
						'param_name' => 'icon_material',
						"settings" => array('type' => 'material', 'emptyIcon' => false, "iconsPerPage" => 240),
						'dependency' => array('element' => 'icon_family','value' => 'material'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Images & Icons', 'js_composer')
					),

					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", "js_composer"),
						"param_name" => "icon_iconsmind",
						"settings" => array('type' => 'iconsmind', 'emptyIcon' => false, "iconsPerPage" => 240),
						"dependency" => array('element' => "icon_family", 'value' => 'iconsmind'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", "js_composer"),
						"param_name" => "icon_linea",
						"settings" => array('type' => 'linea', "emptyIcon" => false, "iconsPerPage" => 240),
						"dependency" => array('element' => "icon_family", 'value' => 'linea'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", "js_composer"),
						"param_name" => "icon_linecons",
						"settings" => array('type' => 'linecons', 'emptyIcon' => false, "iconsPerPage" => 240),
						"dependency" => array('element' => "icon_family", 'value' => 'linecons'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", "js_composer"),
						"param_name" => "icon_steadysets",
						"settings" => array('type' => 'steadysets', 'emptyIcon' => false, "iconsPerPage" => 240),
						"dependency" => array('element' => "icon_family", 'value' => 'steadysets'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Icon Position', 'js_composer' ),
						'param_name' => 'icon_position',
						'value' => array(
							esc_html__( 'None', 'js_composer' ) => 'none',
							esc_html__( 'Above heading', 'js_composer' ) => 'style-1',
							esc_html__( 'Below heading', 'js_composer' ) => 'style-2',
						),
						'description' => esc_html__( 'Select icon position.', 'js_composer' ),
						"dependency" => array('element' => "icon_family", 'value' => array('fontawesome', 'iconsmind', 'linea', 'steadysets', 'linecons')),
						'edit_field_class' => 'vc_col-sm-6 admin-wow-vc-col',
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Icon Size", "js_composer"),
						"param_name" => "icon_size",
						"dependency" => array('element' => "icon_family", 'value' => array('fontawesome', 'iconsmind', 'linea', 'steadysets', 'linecons')),
						"description" => esc_html__("Don't include \"px\" in your string. e.g. 40", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6 admin-wow-vc-col',
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Icon color', 'js_composer' ),
						'param_name' => 'icon_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Images & Icons', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Icon color hover', 'js_composer' ),
						'param_name' => 'icon_color_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Images & Icons', 'js_composer')
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
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Image size', 'js_composer' ),
						'param_name' => 'img_size',
						'value' => $taxonomies,
						'description' => esc_html__( 'Image size posts', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6 admin-wow-vc-col',
						'group' => __('General', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Image size', 'js_composer'),
						'param_name' => 'img_size_list',
						'value' => '',
						'description' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'js_composer'),
						"dependency" => array('element' => "img_size", 'value' => array('other')),
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
						'type' => 'css_editor',
						'heading' => esc_html__('CSS box', 'js_composer'),
						'value' => '',
						'param_name' => 'css',
						'group' => esc_html__('Design Options', 'js_composer'),
					),
					// array(
					// 	"type" => "wow_vc_group_header",
					// 	"class" => "",
					// 	"heading" => esc_html__("Box option", "js_composer" ),
					// 	"param_name" => "group_header_2",
					// 	"edit_field_class" => "",
					// 	"value" => '',
					// 	'group' => esc_html__('Design Options', 'js_composer'),
					// ),
					// array(
					// 	'type'       => 'attach_image',
					// 	'holder' => 'img_back',
					// 	'heading' => __('Box Image hover', 'js_composer'),
					// 	'param_name' => 'box_img_hover',
					// 	'class' => 'wow-vc-bgimg',
					// 	'weight' => 0,
					// 	'group' => esc_html__('Design Options', 'js_composer'),
					// ),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Content Padding', 'js_composer' ),
						'param_name' => 'content_padding',
						'value' => '',
						'description' => esc_html__( 'e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => esc_html__('Box option', 'js_composer'),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Content Margin', 'js_composer' ),
						'param_name' => 'content_margin',
						'value' => '',
						'description' => esc_html__( 'e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col pt-0',
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
						'description' => esc_html__( 'Select radius hover', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col pt-0',
						'group' => esc_html__('Box option', 'js_composer'),
					),
					
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Box background', 'js_composer' ),
						'param_name' => 'box_bg',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => esc_html__('Box option', 'js_composer'),
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Box hover background', 'js_composer' ),
						'param_name' => 'box_hover_bg',
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
						'group' => esc_html__('Box option', 'js_composer'),
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
						'group' => esc_html__('Box option', 'js_composer'),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('Box overflow content', 'js_composer'),
						'param_name' => 'box_overflow',
						'save_always' => true,
						'not_empty' => true,
						'std' => 'yes',
						'value' => array(esc_html__('Yes', 'js_composer') => 'yes'),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => esc_html__('Box option', 'js_composer'),
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Box transition hover', 'js_composer' ),
						'param_name' => 'box_transition_hover',
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
						'description' => esc_html__( 'Select transition hover', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						'group' => esc_html__('Box option', 'js_composer'),
					),

					array(
						'type' => 'animation_style',
						'heading' => esc_html__( 'Initial loading animation', 'js_composer' ),
						'param_name' => 'initial_loading_animation',
						'value' => '',
						"admin_label" => true,
						'description' => esc_html__( 'Select initial loading animation for grid element.', 'js_composer' ),
						'group' => esc_html__('Box option', 'js_composer'),
					),


					
				

				),
			);
		}

		public function output($atts, $content = null)
		{

			// INIT
			$has_dimension_data = false;
			$image_srcset = null;
			$image_width  = '100';
			$image_height = '100';
			$img_class = '';
			$img_size = isset($atts['img_size']) ? $atts['img_size'] : null;
			$img_size_list = isset($atts['img_size_list']) ? $atts['img_size_list'] : null;
			$img_size_set = ($img_size && $img_size === 'other') ? $img_size_list : $img_size;

			$image_src = wp_get_attachment_image_src($atts['bgimg'], $img_size_set)[0];
			// $image_hover_src = wp_get_attachment_image_src($atts['bgimg_hover'], $img_size_set)[0];
			$box_img_hover_src = wp_get_attachment_image_src($atts['box_img_hover'], $atts['box_img_hover'])[0];
			$image_meta = wp_get_attachment_metadata($atts['bgimg']);
			$image_loading = isset($atts['image_loading']) ? $atts['image_loading'] : null;
			$parsed_animation = str_replace(" ","-",$atts['css_animation']);
			$theme = isset($atts["theme"]) ? ' wow-vc-theme-'. $atts["theme"] : null;
			$classname = isset($atts['el_class']) ? ' ' . $atts['el_class'] : null;
			$css = isset($atts["css"]) ? $atts["css"] : null;
			$delay = isset($atts['delay']) ? $atts['delay'] : null;
			$title = isset($atts['title']) ? $atts['title'] : null;
			$link = isset($atts['link']) ? $atts['link'] : null;
			$desc_color = isset($atts['desc_color']) ? $atts['desc_color'] : null;
			$desc_font_size = isset($atts['desc_font_size']) ? $atts['desc_font_size'] : null;
			$font_size = isset($atts['font_size']) ? $atts['font_size'] : null;
			$desc_line_height = isset($atts['desc_line_height']) ? $atts['desc_line_height'] : null;
			$line_height = isset($atts['line_height']) ? $atts['line_height'] : null;
			$add_button = isset($atts['add_button']) ? true : false;
			$add_box_button = isset($atts['add_box_button']) ? true : false;
			$attribute = isset($atts['el_attribute']) ? ' ' . $atts['el_attribute'] : null;
			$font_container_data = isset($atts['font_container']) ? $atts['font_container'] : null;
			$google_fonts_data = isset($atts['google_fonts']) ? $atts['google_fonts'] : null;
			$icon_fontawesome = isset($atts['icon_fontawesome']) ? $atts['icon_fontawesome'] : null;
			$icon_iconsmind = isset($atts['icon_iconsmind']) ? $atts['icon_iconsmind'] : null;
			$icon_linea = isset($atts['icon_linea']) ? $atts['icon_linea'] : null;
			$icon_linecons = isset($atts['icon_linecons']) ? $atts['icon_linecons'] : null;
			$icon_openiconic = isset($atts['icon_openiconic']) ? $atts['icon_openiconic'] : null;
			$icon_typicons = isset($atts['icon_typicons']) ? $atts['icon_typicons'] : null;
			$icon_entypo = isset($atts['icon_entypo']) ? $atts['icon_entypo'] : null;
			$icon_monosocial = isset($atts['icon_monosocial']) ? $atts['icon_monosocial'] : null;
			$icon_material = isset($atts['icon_material']) ? $atts['icon_material'] : null;
			$icon_steadysets = isset($atts['icon_steadysets']) ? $atts['icon_steadysets'] : null;
			$icon_position = isset($atts['icon_position']) ? $atts['icon_position'] : null;
			$content_padding = isset($atts['content_padding']) ? $atts['content_padding'] : null;
			$content_margin = isset($atts['content_margin']) ? $atts['content_margin'] : null;
			$add_heading_click = isset($atts['add_heading_click']) ? $atts['add_heading_click'] : null;
			$icon_color = isset($atts['icon_color']) ? $atts['icon_color'] : null;
			$icon_color_hover = isset($atts['icon_color_hover']) ? $atts['icon_color_hover'] : null;

			$initial_loading_animation = isset($atts['initial_loading_animation']) ? ' wpb_animate_when_almost_visible wpb_' . $atts['initial_loading_animation']. ' animate__animated animate__' . $atts['initial_loading_animation']. ' ' . $atts['initial_loading_animation'] : null;
			$icon_size = isset($atts['icon_size']) ? $atts['icon_size'] : null;
			// SET VALUE
			$css_animation = isset($atts['css_animation']) ? ' wpb_animate_when_almost_visible wpb_' . $atts['css_animation'] . ' animate__animated animate__' . $atts['css_animation']. ' ' . $atts['css_animation'] : null;
			
			$cssname = vc_shortcode_custom_css_class($css, '.');
			$block_id = isset($atts['el_id']) ? ' id="'. $atts['el_id'].'"' : null;
			$csscontent = '';
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), $this->settings['base'], $atts);
			$applyHeading = $this->applyHeading($font_container_data,$title,$link,$line_height,$font_size,$add_heading_click);
			$applyHeadingStyle = $this->applyHeadingStyle($font_container_data,$desc_line_height);
			$applyIconStyle = $this->applyIconStyle($icon_size);
			$applyDesc = $this->applyDesc($desc_color,$desc_line_height);
			$applyClass = $this->applyClass($desc_font_size);
			$applyGoogleFont = $this->applyGoogleFont($google_fonts_data);
			$getGoogleFont = $this->getGoogleFont($google_fonts_data);
			$textAlign = $this->textAlign($font_container_data);
			if ($icon_fontawesome || $icon_iconsmind || $icon_linea || $icon_linecons || $icon_steadysets || $icon_openiconic || $icon_typicons || $icon_entypo || $icon_monosocial || $icon_material) {
				$icon = $icon_fontawesome.$icon_iconsmind.$icon_linea.$icon_linecons.$icon_steadysets.$icon_openiconic.$icon_typicons.$icon_entypo.$icon_monosocial.$icon_material;
			}
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
			$text_color_hover = isset($atts['text_color_hover']) ? $atts['text_color_hover'] : null;
			$desc_color_hover = isset($atts['desc_color_hover']) ? $atts['desc_color_hover'] : null;
			$box_img_hover = isset($atts['box_img_hover']) ? $atts['box_img_hover'] : null;
			$box_radius_hover = isset($atts['box_radius_hover']) ? $atts['box_radius_hover'] : null;
			$box_bg = isset($atts['box_bg']) ? $atts['box_bg'] : null;
			$box_hover_bg = isset($atts['box_hover_bg']) ? $atts['box_hover_bg'] : null;
			$box_border_hover = isset($atts['box_border_hover']) ? $atts['box_border_hover'] : null;
			$box_transition_hover = isset($atts['box_transition_hover']) ? $atts['box_transition_hover'] : null;
			$desc_transition_hover = isset($atts['desc_transition_hover']) ? $atts['desc_transition_hover'] : null;
			$transition_hover = isset($atts['transition_hover']) ? $atts['transition_hover'] : null;
			$box_justify_content = isset($atts['box_justify_content']) ? $atts['box_justify_content'] : null;
			$box_align_item = isset($atts['box_align_item']) ? $atts['box_align_item'] : null;
			$text_padding = isset($atts['text_padding']) ? $atts['text_padding'] : null;
			$text_margin = isset($atts['text_margin']) ? $atts['text_margin'] : null;
			$desc_padding = isset($atts['desc_padding']) ? $atts['desc_padding'] : null;
			$desc_margin = isset($atts['desc_margin']) ? $atts['desc_margin'] : null;
			$btn_font_size = isset($atts['btn_font_size']) ? ' '. $atts['btn_font_size'] : null;
			$btn_line_height = isset($atts['btn_line_height']) ? $atts['btn_line_height'] : null;
			$gen = isset($atts['gen']) ? $atts['gen'] : 'Create';
			$box_overflow = $atts['box_overflow'] ? true : false;
			// CSS_NAME
			$randomNumClass = $atts['el_idgen'];
			$cssname = $atts['css'] ? vc_shortcode_custom_css_class($css, '.') : '.wow_vc_'.$randomNumClass;
			$cssaddclass = $atts['css'] ? '' : ' wow_vc_'.$randomNumClass;
			$css_build = '';

			$css_build .= $desc_color ? $cssname.' .wow-vc-ctn .wow-vc-content{color:'.$this->wowHexToRGB($desc_color).'!important}' : null;
			$css_build .= $applyDesc ? $cssname.' .wow-vc-ctn .wow-vc-content{'.$applyDesc.'!important}' : null;
			$css_build .= $applyHeadingStyle ? $cssname.' .wow-vc-ctn .wow-vc-title{'.$applyHeadingStyle.'!important}' : null;
			$css_build .= $applyHeadingStyle ? $cssname.' .wow-vc-ctn .wow-vc-title .wow-vc-title-link{'.$applyHeadingStyle.'!important}' : null;
			$css_build .= $getGoogleFont ? $cssname.' {'.$getGoogleFont.'!important}' : null;
			$css_build .= $getGoogleFont ? $cssname.' .wow-vc-ctn .wow-vc-title{'.$getGoogleFont.'!important}' : null;
			$css_build .= $getGoogleFont ? $cssname.' .wow-vc-ctn .wow-vc-title{'.$getGoogleFont.'!important}' : null;
			$css_build .= $icon_size ? $cssname.' .wow-vc-ctn .wow-vc-icon{'.$applyIconStyle.'!important}' : null;
			// BUTTON 
			$css_build .= $btn_color ? ''. $cssname.' .wow-vc-button >*{color:'.$this->wowHexToRGB($btn_color).'!important}' : null;
			$css_build .= $btn_bg ? ''. $cssname.' .wow-vc-button >*{background-color:'.$this->wowHexToRGB($btn_bg,$btn_transparent).'!important}' : null;
			$css_build .= $btn_border_color ? ''. $cssname.' .wow-vc-button >*{border-color:'.$this->wowHexToRGB($btn_border_color).'!important}' : null;
			$css_build .= $btn_border ? ''. $cssname.' .wow-vc-button >*{border-style:solid!important;border-width:'.$btn_border.'!important;}' : null;
			if($btn_border_style) {
				if($btn_border_style === 'top') {
					$css_build .= ''. $cssname.' .wow-vc-button >*{border-left-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($btn_border_style === 'bottom') {
					$css_build .= ''. $cssname.' .wow-vc-button >*{border-left-width:0!important;border-right-width:0!important;border-top-width:0!important}';
				} else if($btn_border_style === 'left') {
					$css_build .= ''. $cssname.' .wow-vc-button >*{border-top-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($btn_border_style === 'right') {
					$css_build .= ''. $cssname.' .wow-vc-button >*{border-top-width:0!important;border-left-width:0!important;border-bottom-width:0!important}';
				}
			}
			$css_build .= $btn_border_radius ? ''. $cssname.' .wow-vc-button >*{border-radius:'.$btn_border_radius.'!important;}' : null;
			$css_build .= $btn_padding ? ''. $cssname.' .wow-vc-button >*{padding:'.$btn_padding.'!important;}' : null;
			$css_build .= $btn_margin ? ''. $cssname.' .wow-vc-button >*{margin:'.$btn_margin.'!important;}' : null;
			$css_build .= ($btn_decoration && $btn_decoration === 'yes') ? ''. $cssname.' .wow-vc-button >*{text-decoration: none!important;}' : null;
			$css_build .= $icon_color ? ''. $cssname.' .wow-vc-icon {color:'.$this->wowHexToRGB($icon_color).'!important}' : null;

			if($add_box_button){
				$css_build .= $btn_hover_color ? ''. $cssname.':hover .wow-vc-button >*{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_color ? ''. $cssname.':focus .wow-vc-button >*{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_color ? ''. $cssname.':active .wow-vc-button >*{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.':hover .wow-vc-button >*{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.':focus .wow-vc-button >*{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.':active .wow-vc-button >*{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.':hover .wow-vc-button >*{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.':focus .wow-vc-button >*{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.':active .wow-vc-button >*{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
				$css_build .= $icon_color_hover ? ''. $cssname.':hover .wow-vc-icon {color:'.$this->wowHexToRGB($icon_color_hover).'!important}' : null;
				$css_build .= $icon_color_hover ? ''. $cssname.':focus .wow-vc-icon {color:'.$this->wowHexToRGB($icon_color_hover).'!important}' : null;
				$css_build .= $icon_color_hover ? ''. $cssname.':active .wow-vc-icon {color:'.$this->wowHexToRGB($icon_color_hover).'!important}' : null;
			} else {
				$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-button >*:hover{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-button >*:focus{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_color ? ''. $cssname.' .wow-vc-button >*:active{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-button >*:hover{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-button >*:focus{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_hover_bg ? ''. $cssname.' .wow-vc-button >*:active{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-button >*:hover{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-button >*:focus{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
				$css_build .= $btn_border_hover ? ''. $cssname.' .wow-vc-button >*:active{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
				$css_build .= $icon_color_hover ? ''. $cssname.' .wow-vc-icon:hover {color:'.$this->wowHexToRGB($icon_color_hover).'!important}' : null;
				$css_build .= $icon_color_hover ? ''. $cssname.' .wow-vc-icon:focus {color:'.$this->wowHexToRGB($icon_color_hover).'!important}' : null;
				$css_build .= $icon_color_hover ? ''. $cssname.' .wow-vc-icon:active {color:'.$this->wowHexToRGB($icon_color_hover).'!important}' : null;
			}

			$css_build .= $text_color_hover ? ''. $cssname.':hover .wow-vc-ctn .wow-vc-title{color:'.$this->wowHexToRGB($text_color_hover).'!important;}' : null;
			$css_build .= $text_color_hover ? ''. $cssname.':hover .wow-vc-ctn .wow-vc-title .wow-vc-title-link{color:'.$this->wowHexToRGB($text_color_hover).'!important;}' : null;
			$css_build .= $desc_color_hover ? ''. $cssname.':hover .wow-vc-ctn .wow-vc-content{color:'.$this->wowHexToRGB($desc_color_hover).'!important;}' : null;
			$css_build .= $content_padding ? ''. $cssname.'{padding:'.$content_padding.'!important;}' : null;
			$css_build .= $content_margin ? ''. $cssname.'{margin:'.$content_margin.'!important;}' : null;

			$css_build .= $box_radius_hover ? ''. $cssname.':hover {border-radius:'.$box_radius_hover.'!important;}' : null;
			$css_build .= $box_bg ? ''. $cssname.' .box-bg {background-color:'.$this->wowHexToRGB($box_bg).'!important;}' : null;
			$css_build .= $box_hover_bg ? ''. $cssname.':hover .box-bg {background-color:'.$this->wowHexToRGB($box_hover_bg).'!important;}' : null;
			$css_build .= $box_border_hover ? ''. $cssname.':hover {border-color:'.$this->wowHexToRGB($box_border_hover).'!important;}' : null;
			$css_build .= $box_img_hover ? ''. $cssname.':hover {background-image:url('.$box_img_hover_src.')!important;}' : null;
			$css_build .= $box_transition_hover ? ''. $cssname.' {transition:all ease-in-out '.$box_transition_hover.'!important;}' : null;
			$css_build .= $desc_transition_hover ? ''. $cssname.' .wow-vc-ctn .wow-vc-content{transition:all ease-in-out '.$desc_transition_hover.'!important;}' : null;
			$css_build .= $transition_hover ? ''. $cssname.' .wow-vc-ctn .wow-vc-title{transition:all ease-in-out '.$transition_hover.'!important;}' : null;
			$css_build .= $transition_hover ? ''. $cssname.' .wow-vc-ctn .wow-vc-title .wow-vc-title-link{transition:all ease-in-out '.$transition_hover.'!important;}' : null;
			$css_build .= ($box_overflow) ? ''. $cssname.' {overflow:hidden!important;}' : null;
			$css_build .= $box_justify_content ? ''. $cssname.' {justify-content:'.$box_justify_content.'!important;display:flex}' : null;
			$css_build .= $box_align_item ? ''. $cssname.' {align-items:'.$box_align_item.'!important;display:flex}' : null;

			$css_build .= $text_padding ? ''. $cssname.' .wow-vc-ctn .wow-vc-title{padding:'.$text_padding.'!important;}' : null;
			$css_build .= $text_margin ? ''. $cssname.' .wow-vc-ctn .wow-vc-title{margin:'.$text_margin.'!important;}' : null;
			$css_build .= $desc_padding ? ''. $cssname.' .wow-vc-ctn .wow-vc-content{padding:'.$desc_padding.'!important;}' : null;
			$css_build .= $desc_margin ? ''. $cssname.' .wow-vc-ctn .wow-vc-content{margin:'.$desc_margin.'!important;}' : null;
			$css_build .= $btn_line_height ? ''. $cssname.' .wow-vc-ctn .wow-vc-button .wow-vc-title-link{line-height:'.$btn_line_height.'!important;}' : null;


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
			if (function_exists('wp_get_attachment_image_srcset')) {

				$image_srcset_values = wp_get_attachment_image_srcset($atts['bgimg'], $img_size_set);
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
			$wp_img_alt_tag = get_post_meta($atts['bgimg'], '_wp_attachment_image_alt', true);
			if (!empty($wp_img_alt_tag)) {
				$alt_tag = $wp_img_alt_tag;
			}
			$image_url = (isset($image_src)) ? $image_src : '';
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
			$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

			// FrontEnd
			$output = ($css || $css_build) ? '<style>' . $css . $css_build . '</style>' : '';
			
			if($atts["theme"] === 'style-1') {
				include 'layout/style-1.php';
			} 
			else if($atts["theme"] === 'style-2') {
				include 'layout/style-2.php';
			} 
			else if($atts["theme"] === 'style-3') {
				include 'layout/style-3.php';
			} 
			else {
				include 'layout/default.php';
			}


			return apply_filters(
				'wow_vc_' . $this->name . '_output',
				$output,
				$content,
				$settings
			);
		}
	}
}
new wowVC_Addons_BoxInfo;
