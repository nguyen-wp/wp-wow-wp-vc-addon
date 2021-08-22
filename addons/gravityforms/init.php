<?php

if (!defined('ABSPATH')) {
	die('Silly human what are you doing here');
}


if (!class_exists('wowVC_Addons_GravityForms')) {

	class wowVC_Addons_GravityForms extends WOW_VC_Helpers
	{

		public $name = 'gravityforms';
		public $pNicename = 'WOW Gravity Forms';

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
			global $wpdb;
			$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}gf_form WHERE is_active = 1", OBJECT );

			$taxonomies = array();
			foreach ($results as &$value) {
				$taxonomies[esc_html__($value->title, 'js_composer')] = $value->id;
			}
			$arrapList = array(
				'param_name'    => 'content',
				'heading'       => __('Gravity Forms', 'js_composer'),
				'description' => esc_html__('Error! You need install Gravity Forms first', 'js_composer'),
				'group' => $this->pNicename,
			);

			if($taxonomies) {
				$arrapList = array(
					'param_name'    => 'content',
					'type'          => 'dropdown',
					'value' =>  $taxonomies,
					'admin_label' => true,
					'heading'       => __('Gravity Forms', 'js_composer'),
					'description' => esc_html__('Add Gravity Forms', 'js_composer'),
					'group' => $this->pNicename,
				);
			}

			return array(
				'name'        => esc_html__($this->pNicename, 'js_composer'),
				'description' => esc_html__('Add new ' . $this->pNicename, 'js_composer'),
				'base'        => 'wow_vc_' . $this->name,
				'category' => __('WOW Addons', 'js_composer'),
				'icon' => 'icon-wow-vc-adminicon icon-wow-vc-' . $this->name,
				'show_settings_on_create' => true,
				'params'      => array(
					$arrapList,
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Display Form Title', 'js_composer' ),
						'param_name' => 'title',
						'value' => array(
							esc_html__( 'No', 'js_composer' ) => 'false',
							esc_html__( 'Yes', 'js_composer' ) => 'true',
						),
						'save_always' => true,
						'description' => esc_html__( 'Would you like to display the forms title?', 'js_composer' ),
						'group' => $this->pNicename,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Display Form Description', 'js_composer' ),
						'param_name' => 'description',
						'value' => array(
							esc_html__( 'No', 'js_composer' ) => 'false',
							esc_html__( 'Yes', 'js_composer' ) => 'true',
						),
						'save_always' => true,
						'description' => esc_html__( 'Would you like to display the forms description?', 'js_composer' ),
						'group' => $this->pNicename,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Enable AJAX?', 'js_composer' ),
						'param_name' => 'ajax',
						'value' => array(
							esc_html__( 'No', 'js_composer' ) => 'false',
							esc_html__( 'Yes', 'js_composer' ) => 'true',
						),
						'save_always' => true,
						'description' => esc_html__( 'Enable AJAX submission?', 'js_composer' ),
						'group' => $this->pNicename,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Tab Index', 'js_composer' ),
						'param_name' => 'tabindex',
						'description' => esc_html__( '(Optional) Specify the starting tab index for the fields of this form. Leave blank if you\'re not sure what this is.', 'js_composer' ),
						'group' => $this->pNicename,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Form layout', 'js_composer' ),
						'param_name' => 'theme',
						'admin_label' => true,
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'Style 1', 'js_composer' ) => 'style-1',
							esc_html__( 'Style 2', 'js_composer' ) => 'style-2',
							esc_html__( 'Style 3', 'js_composer' ) => 'style-3',
						),
						'save_always' => true,
						'not_empty' => true,
						'description' => esc_html__( 'Select form layout.', 'js_composer' ),
						'group' => __('Format', 'js_composer')
					),
					array(
						"type" => "wow_vc_hidden_frm",
						'param_name' => 'prevoew_0',
						"heading" => __( "Default", "js_composer" ),
						"description" => __( "<a href='".plugin_dir_url(__FILE__) .'img/0.png'."' target='_blank'><img src='".plugin_dir_url(__FILE__) .'img/0.png'."' style='max-width: 300px; border: 1px solid #acadb0; border-radius: 3px;'></a>", "js_composer" ),
						'save_always' => true,
						'dependency' => array(
							'element' => 'theme',
							'value' =>'default'
						),
						'group' => __('Format', 'js_composer')
					),
					array(
						"type" => "wow_vc_hidden_frm",
						'param_name' => 'prevoew_1',
						"heading" => __( "Style 1", "js_composer" ),
						"description" => __( "<a href='".plugin_dir_url(__FILE__) .'img/1.png'."' target='_blank'><img src='".plugin_dir_url(__FILE__) .'img/1.png'."' style='max-width: 300px; border: 1px solid #acadb0; border-radius: 3px;'></a>", "js_composer" ),
						'save_always' => true,
						'dependency' => array(
							'element' => 'theme',
							'value' =>'style-1'
						),
						'group' => __('Format', 'js_composer')
					),
					array(
						"type" => "wow_vc_hidden_frm",
						'param_name' => 'prevoew_2',
						"heading" => __( "Style 2", "js_composer" ),
						"description" => __( "<a href='".plugin_dir_url(__FILE__) .'img/2.png'."' target='_blank'><img src='".plugin_dir_url(__FILE__) .'img/2.png'."' style='max-width: 300px ;border: 1px solid #acadb0; border-radius: 3px;'></a>", "js_composer" ),
						'save_always' => true,
						'dependency' => array(
							'element' => 'theme',
							'value' =>'style-2'
						),
						'group' => __('Format', 'js_composer')
					),
					array(
						"type" => "wow_vc_hidden_frm",
						'param_name' => 'prevoew_3',
						"heading" => __( "Style 3", "js_composer" ),
						"description" => __( "<a href='".plugin_dir_url(__FILE__) .'img/3.png'."' target='_blank'><img src='".plugin_dir_url(__FILE__) .'img/3.png'."' style='max-width: 300px ;border: 1px solid #acadb0; border-radius: 3px;'></a>", "js_composer" ),
						'save_always' => true,
						'dependency' => array(
							'element' => 'theme',
							'value' =>'style-3'
						),
						'group' => __('Format', 'js_composer')
					),
					array(
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Text format", "js_composer" ),
						"param_name" => "group_header_2",
						"edit_field_class" => "",
						"value" => '',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Text color', 'js_composer' ),
						'param_name' => 'text_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Link color', 'js_composer' ),
						'param_name' => 'link_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Link hover color', 'js_composer' ),
						'param_name' => 'link_hover_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						"type" => "wow_vc_group_header",
						"class" => "",
						"heading" => esc_html__("Input format", "js_composer" ),
						"param_name" => "group_header_4",
						"edit_field_class" => "",
						"value" => '',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Input text', 'js_composer' ),
						'param_name' => 'input_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Input text hover', 'js_composer' ),
						'param_name' => 'input_hover_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Input background', 'js_composer' ),
						'param_name' => 'input_bg',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Input hover background', 'js_composer' ),
						'param_name' => 'input_hover_bg',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Input border color', 'js_composer' ),
						'param_name' => 'input_border_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Input border hover', 'js_composer' ),
						'param_name' => 'input_border_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Input border', 'js_composer' ),
						'param_name' => 'input_border',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( '0px', 'js_composer' ) => '0',
							esc_html__( '1px', 'js_composer' ) => '1px',
							esc_html__( '2px', 'js_composer' ) => '2px',
							esc_html__( '3px', 'js_composer' ) => '3px',
							esc_html__( '4px', 'js_composer' ) => '4px',
						),
						'description' => esc_html__( 'Select Input border', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Input border style', 'js_composer' ),
						'param_name' => 'input_border_style',
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'all', 'js_composer' ) => 'all',
							esc_html__( 'top', 'js_composer' ) => 'top',
							esc_html__( 'left', 'js_composer' ) => 'left',
							esc_html__( 'right', 'js_composer' ) => 'right',
							esc_html__( 'bottom', 'js_composer' ) => 'bottom',
						),
						'description' => esc_html__( 'Select Input border style', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Input border radius', 'js_composer' ),
						'param_name' => 'input_border_radius',
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
						'description' => esc_html__( 'Select Input border radius', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Input transparent', 'js_composer' ),
						'param_name' => 'input_transparent',
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
						'description' => esc_html__( 'Select Input transparent', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Input transparent hover', 'js_composer' ),
						'param_name' => 'input_transparent_hover',
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
						'description' => esc_html__( 'Select Input transparent hover', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6',
						'group' => __('Format', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Input Padding', 'js_composer' ),
						'param_name' => 'input_padding',
						'value' => '',
						"description" => esc_html__("Enter value in your string. e.g. 40px 20px or 1rem or 1rem 2rem .5rem 10px", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6',
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
						'param_name' => 'css',
						'group' => esc_html__('Design Options', 'js_composer'),
					),
				),
			);
		}

		public function output($atts, $content = null)
		{

			$ranNum = '.vc_custom_'.$this->generateRandomNum(10).'{display:block}';
			$block_id = isset($atts['el_id']) ? ' id="'.$atts['el_id'].'"' : '';
			$attribute = isset($atts['el_attribute']) ? ' ' . $atts['el_attribute'] : '';
			$theme = isset($atts['theme']) ? ' wow-vc-' . $atts['theme'] : '';
			$classname = isset($atts['el_class']) ? ' ' . $atts['el_class'] : '';
			$css = isset($atts["css"]) ? $atts["css"] : $ranNum;
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), $this->settings['base'], $atts);
			$gen = isset($atts['gen']) ? $atts['gen'] : 'Create';

			// SETTINGS
			$title = isset($atts['title']) ? $atts['title'] : 'false';
			$description = isset($atts['description']) ? $atts['description'] : 'false';
			$ajax = isset($atts['ajax']) ? $atts['ajax'] : 'false';
			$tabindex = isset($atts['tabindex']) ? $atts['tabindex'] : '0';
			// VALUE 
			$text_color = isset($atts['text_color']) ? $atts['text_color'] : null;
			$link_color = isset($atts['link_color']) ? $atts['link_color'] : null;
			$link_hover_color = isset($atts['link_hover_color']) ? $atts['link_hover_color'] : null;
			// INPUT 
			$input_color = isset($atts['input_color']) ? $atts['input_color'] : null;
			$input_hover_color = isset($atts['input_hover_color']) ? $atts['input_hover_color'] : null;
			$input_bg = isset($atts['input_bg']) ? $atts['input_bg'] : null;
			$input_hover_bg = isset($atts['input_hover_bg']) ? $atts['input_hover_bg'] : null;
			$input_border_color = isset($atts['input_border_color']) ? $atts['input_border_color'] : null;
			$input_border_hover = isset($atts['input_border_hover']) ? $atts['input_border_hover'] : null;
			$input_border = isset($atts['input_border']) ? $atts['input_border'] : null;
			$input_border_style = isset($atts['input_border_style']) ? $atts['input_border_style'] : null;
			$input_border_radius = isset($atts['input_border_radius']) ? $atts['input_border_radius'] : null;
			$input_padding = isset($atts['input_padding']) ? $atts['input_padding'] : null;
			$input_transparent_hover = isset($atts['input_transparent_hover']) ? $atts['input_transparent_hover'] : null;
			$input_transparent = isset($atts['input_transparent']) ? $atts['input_transparent'] : null;
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
			$btn_transparent_hover = isset($atts['btn_transparent_hover']) ? $atts['btn_transparent_hover'] : null;
			$btn_transparent = isset($atts['btn_transparent']) ? $atts['btn_transparent'] : null;
			// CSS_NAME
			$randomNumClass = $atts['el_idgen'];
			$cssname = $atts['css'] ? vc_shortcode_custom_css_class($css, '.') : '.wow_vc_'.$randomNumClass;
			$cssaddclass = $atts['css'] ? vc_shortcode_custom_css_class($css, ' ') : ' wow_vc_'.$randomNumClass;
			
			$css_build = '';
			$css_build .= $text_color ? $cssname.' .gform_wrapper{color:'.$this->wowHexToRGB($text_color).'!important}' : null;
			$css_build .= $link_color ? $cssname.' .gform_wrapper a{color:'.$this->wowHexToRGB($link_color).'!important}' : null;
			$css_build .= $link_hover_color ? $cssname.' .gform_wrapper a:hover{color:'.$this->wowHexToRGB($link_hover_color).'!important}' : null;
			$css_build .= $input_color ? ''. $cssname.' .gform_wrapper input, '. $cssname.' .gform_wrapper select, '. $cssname.' .gform_wrapper textarea{color:'.$this->wowHexToRGB($input_color).'!important}' : null;
			$css_build .= $input_hover_color ? ''. $cssname.' .gform_wrapper input:hover, '. $cssname.' .gform_wrapper select:hover, '. $cssname.' .gform_wrapper textarea:hover{color:'.$this->wowHexToRGB($input_hover_color).'!important}' : null;
			$css_build .= $input_hover_color ? ''. $cssname.' .gform_wrapper input:focus, '. $cssname.' .gform_wrapper select:focus, '. $cssname.' .gform_wrapper textarea:focus{color:'.$this->wowHexToRGB($input_hover_color).'!important}' : null;
			$css_build .= $input_hover_color ? ''. $cssname.' .gform_wrapper input:active, '. $cssname.' .gform_wrapper select:active, '. $cssname.' .gform_wrapper textarea:active{color:'.$this->wowHexToRGB($input_hover_color).'!important}' : null;
			$css_build .= $input_bg ? ''. $cssname.' .gform_wrapper input, '. $cssname.' .gform_wrapper select, '. $cssname.' .gform_wrapper textarea{background-color:'.$this->wowHexToRGB($input_bg,$input_transparent).'!important}' : null;
			$css_build .= $input_hover_bg ? ''. $cssname.' .gform_wrapper input:hover, '. $cssname.' .gform_wrapper select:hover, '. $cssname.' .gform_wrapper textarea:hover{background-color:'.$this->wowHexToRGB($input_hover_bg,$input_transparent_hover).'!important}' : null;
			$css_build .= $input_hover_bg ? ''. $cssname.' .gform_wrapper input:focus, '. $cssname.' .gform_wrapper select:focus, '. $cssname.' .gform_wrapper textarea:focus{background-color:'.$this->wowHexToRGB($input_hover_bg,$input_transparent_hover).'!important}' : null;
			$css_build .= $input_hover_bg ? ''. $cssname.' .gform_wrapper input:active, '. $cssname.' .gform_wrapper select:active, '. $cssname.' .gform_wrapper textarea:active{background-color:'.$this->wowHexToRGB($input_hover_bg,$input_transparent_hover).'!important}' : null;
			$css_build .= $input_border_color ? ''. $cssname.' .gform_wrapper input, '. $cssname.' .gform_wrapper select, '. $cssname.' .gform_wrapper textarea{border-color:'.$this->wowHexToRGB($input_border_color).'!important}' : null;
			$css_build .= $input_border_hover ? ''. $cssname.' .gform_wrapper input:hover, '. $cssname.' .gform_wrapper select:hover, '. $cssname.' .gform_wrapper textarea:hover{border-color:'.$this->wowHexToRGB($input_border_hover).'!important}' : null;
			$css_build .= $input_border_hover ? ''. $cssname.' .gform_wrapper input:focus, '. $cssname.' .gform_wrapper select:focus, '. $cssname.' .gform_wrapper textarea:focus{border-color:'.$this->wowHexToRGB($input_border_hover).'!important}' : null;
			$css_build .= $input_border_hover ? ''. $cssname.' .gform_wrapper input:active, '. $cssname.' .gform_wrapper select:active, '. $cssname.' .gform_wrapper textarea:active{border-color:'.$this->wowHexToRGB($input_border_hover).'!important}' : null;
			$css_build .= $input_border ? ''. $cssname.' .gform_wrapper input, '. $cssname.' .gform_wrapper select, '. $cssname.' .gform_wrapper textarea{border-style:solid;border-width:'.$input_border.'!important;}' : null;
			if($input_border_style) {
				if($input_border_style === 'top') {
					$css_build .= ''. $cssname.' .gform_wrapper input, '. $cssname.' .gform_wrapper select, '. $cssname.' .gform_wrapper textarea{border-left-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($input_border_style === 'bottom') {
					$css_build .= ''. $cssname.' .gform_wrapper input, '. $cssname.' .gform_wrapper select, '. $cssname.' .gform_wrapper textarea{border-left-width:0!important;border-right-width:0!important;border-top-width:0!important}';
				} else if($input_border_style === 'left') {
					$css_build .= ''. $cssname.' .gform_wrapper input, '. $cssname.' .gform_wrapper select, '. $cssname.' .gform_wrapper textarea{border-top-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($input_border_style === 'right') {
					$css_build .= ''. $cssname.' .gform_wrapper input, '. $cssname.' .gform_wrapper select, '. $cssname.' .gform_wrapper textarea{border-top-width:0!important;border-left-width:0!important;border-bottom-width:0!important}';
				}
			}
			$css_build .= $input_border_radius ? ''. $cssname.' .gform_wrapper input, '. $cssname.' .gform_wrapper select, '. $cssname.' .gform_wrapper textarea{border-radius:'.$input_border_radius.'!important;}' : null;
			$css_build .= $input_padding ? ''. $cssname.' .gform_wrapper input, '. $cssname.' .gform_wrapper select, '. $cssname.' .gform_wrapper textarea{padding:'.$input_padding.'!important;}' : null;

			$css_build .= $btn_color ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]{color:'.$this->wowHexToRGB($btn_color).'!important;}' : null;
			$css_build .= $btn_hover_color ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]:hover{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
			$css_build .= $btn_hover_color ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]:focus{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
			$css_build .= $btn_hover_color ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]:active{color:'.$this->wowHexToRGB($btn_hover_color).'!important}' : null;
			$css_build .= $btn_bg ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]{background-color:'.$this->wowHexToRGB($btn_bg,$btn_transparent).'!important}' : null;
			$css_build .= $btn_border_color ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]{border-color:'.$this->wowHexToRGB($btn_border_color).'!important}' : null;
			$css_build .= $btn_border_hover ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]:hover{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
			$css_build .= $btn_border_hover ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]:focus{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
			$css_build .= $btn_border_hover ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]:active{border-color:'.$this->wowHexToRGB($btn_border_hover).'!important}' : null;
			$css_build .= $btn_border ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]{border-style:solid!important;border-width:'.$btn_border.'!important;}' : null;
			if($btn_border_style) {
				if($btn_border_style === 'top') {
					$css_build .= ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]{border-left-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($btn_border_style === 'bottom') {
					$css_build .= ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]{border-left-width:0!important;border-right-width:0!important;border-top-width:0!important}';
				} else if($btn_border_style === 'left') {
					$css_build .= ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]{border-top-width:0!important;border-right-width:0!important;border-bottom-width:0!important}';
				} else if($btn_border_style === 'right') {
					$css_build .= ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]{border-top-width:0!important;border-left-width:0!important;border-bottom-width:0!important}';
				}
			}
			$css_build .= $btn_border_radius ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]{border-radius:'.$btn_border_radius.'!important;}' : null;
			$css_build .= $btn_padding ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]{padding:'.$btn_padding.'!important;}' : null;
			$css_build .= $btn_hover_bg ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]:hover{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
			$css_build .= $btn_hover_bg ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]:focus{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;
			$css_build .= $btn_hover_bg ? ''. $cssname.' .gform_wrapper .gform_footer input[type="submit"]:active{background-color:'.$this->wowHexToRGB($btn_hover_bg,$btn_transparent_hover).'!important}' : null;

			$cssaddclass = $atts['css'] ? vc_shortcode_custom_css_class($css, ' ') : ' wow_vc_'.$randomNumClass;
			// Admin
			$settings = shortcode_atts(array(
				'el_attribute' => '',
				'el_id' => '',
				'el_class' => '',
			), $atts);
			extract($settings);
			// FrontEnd
			$output = ($css || $css_build) ? '<style>' . $css . $css_build. '</style>' : '';
			$output .= '<section'. $block_id .' class="wow-vc-elements wow-vc-' . $this->name . $css_class. $theme.$classname.$cssaddclass.'"' . str_replace('``', '', $attribute) . '>';
			$output .= $content ?  do_shortcode('[gravityform id="'.$content.'" title="'.$title.'" description="'.$description.'" ajax="'.$ajax.'" tabindex="'.$tabindex.'"]') : null;
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
new wowVC_Addons_GravityForms;
