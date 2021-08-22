<?php

if (!defined('ABSPATH')) {
	die('Silly human what are you doing here');
}


if (!class_exists('wowVC_Addons_Heading')) {

	class wowVC_Addons_Heading extends WOW_VC_Helpers
	{

		public $name = 'heading';
		public $pNicename = 'WOW Heading';

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
						'type' => 'textarea',
						'holder' => 'h2',
						'class' => 'wow-vc-title',
						'heading' => __('Heading', 'js_composer'),
						'param_name' => 'title',
						'value' => __('', 'js_composer'),
						'weight' => 0,
						'edit_field_class' => 'vc_col-sm-12 admin-wow-vc-col',
						"description" => esc_html__("Use <ins> tag to change to secondary color", "js_composer"),
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
							esc_html__( 'h1', 'js_composer' ) => 'h1',
							esc_html__( 'h2', 'js_composer' ) => 'h2',
							esc_html__( 'h3', 'js_composer' ) => 'h3',
							esc_html__( 'h4', 'js_composer' ) => 'h4',
							esc_html__( 'h5', 'js_composer' ) => 'h5',
							esc_html__( 'h6', 'js_composer' ) => 'h6',
							esc_html__( 'p', 'js_composer' ) => 'p',
							esc_html__( 'div', 'js_composer' ) => 'div',
							esc_html__( 'section', 'js_composer' ) => 'section',
							esc_html__( 'nav', 'js_composer' ) => 'nav',
						),
						'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col',
						'group' => $this->pNicename,
					),
					
					array(
							'type' => 'dropdown',
							'heading' => esc_html__( 'Heading Align', 'js_composer' ),
							'param_name' => 'align',
							'value' => 'center',
							'save_always' => true,
							'not_empty' => true,
							'value' => array(
								esc_html__( 'Default', 'js_composer' ) => 'wow-vc-text-center',
								esc_html__( 'left', 'js_composer' ) => 'wow-vc-text-left',
								esc_html__( 'center', 'js_composer' ) => 'wow-vc-text-center',
								esc_html__( 'right', 'js_composer' ) => 'wow-vc-text-right',
							),
							'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col',
							'group' => $this->pNicename,
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__( 'Heading Padding', 'js_composer' ),
							'param_name' => 'heading_padding',
							'value' => '',
							'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col',
							'group' => $this->pNicename,
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__( 'Heading Margin', 'js_composer' ),
							'param_name' => 'heading_margin',
							'value' => '',
							'edit_field_class' => 'vc_col-sm-3 admin-wow-vc-col',
							'group' => $this->pNicename,
						),
						array(
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Text color', 'js_composer' ),
							'param_name' => 'text_color',
							'value' => '',
							'edit_field_class' => 'vc_col-sm-4',
							'group' => $this->pNicename,
						),
						array(
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Text secondary color', 'js_composer' ),
							'param_name' => 'text_secondary_color',
							'value' => '',
							'edit_field_class' => 'vc_col-sm-4',
							'group' => $this->pNicename,
						),
						array(
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Text background', 'js_composer' ),
							'param_name' => 'text_background',
							'value' => '',
							'edit_field_class' => 'vc_col-sm-4',
							'group' => $this->pNicename,
						),
						array(
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Text secondary hover', 'js_composer' ),
							'param_name' => 'text_secondary_color_hover',
							'value' => '',
							'edit_field_class' => 'vc_col-sm-4',
							'group' => $this->pNicename,
						),
						array(
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Text color hover', 'js_composer' ),
							'param_name' => 'text_color_hover',
							'value' => '',
							'edit_field_class' => 'vc_col-sm-4',
							'group' => $this->pNicename,
						),
						
						
					
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Layout', 'js_composer' ),
						'param_name' => 'theme',
						'admin_label' => true,
						'save_always' => true,
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'default',
							esc_html__( 'Line bottom', 'js_composer' ) => 'liner',
							esc_html__( 'Line middle', 'js_composer' ) => 'middle',
							esc_html__( 'Line top', 'js_composer' ) => 'top',
						),
						'edit_field_class' => 'vc_col-sm-12 admin-wow-vc-col',
						'group' => __('Line & Icon', 'js_composer')
					),
					
					
					
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Liner Align', 'js_composer' ),
						'param_name' => 'line_align',
						'value' => 'center',
						'save_always' => true,
						'not_empty' => true,
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => 'center',
							esc_html__( 'left', 'js_composer' ) => 'left',
							esc_html__( 'center', 'js_composer' ) => 'center',
							esc_html__( 'right', 'js_composer' ) => 'right',
						),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						"dependency" => array('element' => "theme", 'value' => array('liner', 'middle', 'top', 'bottom')),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Liner height', 'js_composer' ),
						'param_name' => 'line_height',
						'value' => '1px',
						'save_always' => true,
						'not_empty' => true,
						'value' => array(
							esc_html__( 'Default', 'js_composer' ) => '1px',
							esc_html__( '2px', 'js_composer' ) => '2px',
							esc_html__( '3px', 'js_composer' ) => '3px',
							esc_html__( '4px', 'js_composer' ) => '4px',
							esc_html__( '5px', 'js_composer' ) => '5px',
							esc_html__( '6px', 'js_composer' ) => '6px',
							esc_html__( '7px', 'js_composer' ) => '7px',
							esc_html__( '8px', 'js_composer' ) => '8px',
							esc_html__( '9px', 'js_composer' ) => '9px',
							esc_html__( '10px', 'js_composer' ) => '10px',
						),
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						"dependency" => array('element' => "theme", 'value' => array('liner', 'middle', 'top', 'bottom')),
						'group' => __('Line & Icon', 'js_composer')
					),
					
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Liner Top', 'js_composer' ),
						'param_name' => 'line_top',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						"dependency" => array('element' => "theme", 'value' => array('liner', 'middle', 'top', 'bottom')),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Liner mobile width', 'js_composer' ),
						'param_name' => 'line_mobile_width',
						'value' => '50px',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						"dependency" => array('element' => "theme", 'value' => array('liner', 'middle', 'top', 'bottom')),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Liner tablet width', 'js_composer' ),
						'param_name' => 'line_tablet_width',
						'value' => '70px',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						"dependency" => array('element' => "theme", 'value' => array('liner', 'middle', 'top', 'bottom')),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Liner PC width', 'js_composer' ),
						'param_name' => 'line_desktop_width',
						'value' => '90px',
						'edit_field_class' => 'vc_col-sm-4 admin-wow-vc-col',
						"dependency" => array('element' => "theme", 'value' => array('liner', 'middle', 'top', 'bottom')),
						'group' => __('Line & Icon', 'js_composer')
					),
					
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Line color', 'js_composer' ),
						'param_name' => 'line_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						"dependency" => array('element' => "theme", 'value' => array('liner', 'middle', 'top', 'bottom')),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Line color hover', 'js_composer' ),
						'param_name' => 'line_color_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						"dependency" => array('element' => "theme", 'value' => array('liner', 'middle', 'top', 'bottom')),
						'group' => __('Line & Icon', 'js_composer')
						),
						array(
							"type" => "wow_vc_group_header",
							"class" => "",
							"heading" => esc_html__("Icons", "js_composer" ),
							"param_name" => "group_header_2",
							"edit_field_class" => "",
							"value" => '',
							'group' => __('Line & Icon', 'js_composer')
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
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", "js_composer"),
						"param_name" => "icon_fontawesome",
						"settings" => array("iconsPerPage" => 240),
						"dependency" => array('element' => "icon_family", 'emptyIcon' => false, 'value' => 'fontawesome'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Line & Icon', 'js_composer')
					),
					

					array(
						'type' => 'iconpicker',
						'heading' => __( 'Icon', 'js_composer' ),
						'param_name' => 'icon_openiconic',
						"settings" => array('type' => 'openiconic', 'emptyIcon' => false, "iconsPerPage" => 240),
						'dependency' => array('element' => 'icon_family','value' => 'openiconic'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'iconpicker',
						'heading' => __( 'Icon', 'js_composer' ),
						'param_name' => 'icon_typicons',
						"settings" => array('type' => 'typicons', 'emptyIcon' => false, "iconsPerPage" => 240),
						'dependency' => array('element' => 'icon_family','value' => 'typicons'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'iconpicker',
						'heading' => __( 'Icon', 'js_composer' ),
						'param_name' => 'icon_entypo',
						"settings" => array('type' => 'entypo', 'emptyIcon' => false, "iconsPerPage" => 240),
						'dependency' => array('element' => 'icon_family','value' => 'entypo'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'iconpicker',
						'heading' => __( 'Icon', 'js_composer' ),
						'param_name' => 'icon_monosocial',
						"settings" => array('type' => 'monosocial', 'emptyIcon' => false, "iconsPerPage" => 240),
						'dependency' => array('element' => 'icon_family','value' => 'monosocial'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'iconpicker',
						'heading' => __( 'Icon', 'js_composer' ),
						'param_name' => 'icon_material',
						"settings" => array('type' => 'material', 'emptyIcon' => false, "iconsPerPage" => 240),
						'dependency' => array('element' => 'icon_family','value' => 'material'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Line & Icon', 'js_composer')
					),

					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", "js_composer"),
						"param_name" => "icon_iconsmind",
						"settings" => array('type' => 'iconsmind', 'emptyIcon' => false, "iconsPerPage" => 240),
						"dependency" => array('element' => "icon_family", 'value' => 'iconsmind'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", "js_composer"),
						"param_name" => "icon_linea",
						"settings" => array('type' => 'linea', "emptyIcon" => false, "iconsPerPage" => 240),
						"dependency" => array('element' => "icon_family", 'value' => 'linea'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", "js_composer"),
						"param_name" => "icon_linecons",
						"settings" => array('type' => 'linecons', 'emptyIcon' => false, "iconsPerPage" => 240),
						"dependency" => array('element' => "icon_family", 'value' => 'linecons'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", "js_composer"),
						"param_name" => "icon_steadysets",
						"settings" => array('type' => 'steadysets', 'emptyIcon' => false, "iconsPerPage" => 240),
						"dependency" => array('element' => "icon_family", 'value' => 'steadysets'),
						"description" => esc_html__("Select icon from library.", "js_composer"),
						'group' => __('Line & Icon', 'js_composer')
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
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Icon Size", "js_composer"),
						"param_name" => "icon_size",
						"dependency" => array('element' => "icon_family", 'value' => array('fontawesome', 'iconsmind', 'linea', 'steadysets', 'linecons')),
						"description" => esc_html__("Don't include \"px\" in your string. e.g. 40", "js_composer"),
						'edit_field_class' => 'vc_col-sm-6 admin-wow-vc-col',
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Icon Padding', 'js_composer' ),
						'param_name' => 'icon_padding',
						'value' => '',
						'description' => esc_html__( 'Select box Icon Padding', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6 admin-wow-vc-col',
						"dependency" => array('element' => "icon_family", 'value' => array('fontawesome', 'iconsmind', 'linea', 'steadysets', 'linecons')),						
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Icon Margin', 'js_composer' ),
						'param_name' => 'icon_margin',
						'value' => '',
						'description' => esc_html__( 'Select box Icon Margin', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6 admin-wow-vc-col',
						"dependency" => array('element' => "icon_family", 'value' => array('fontawesome', 'iconsmind', 'linea', 'steadysets', 'linecons')),						
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Icon color', 'js_composer' ),
						'param_name' => 'icon_color',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						"dependency" => array('element' => "icon_family", 'value' => array('fontawesome', 'iconsmind', 'linea', 'steadysets', 'linecons')),						
						'group' => __('Line & Icon', 'js_composer')
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Icon color hover', 'js_composer' ),
						'param_name' => 'icon_color_hover',
						'value' => '',
						'edit_field_class' => 'vc_col-sm-6',
						"dependency" => array('element' => "icon_family", 'value' => array('fontawesome', 'iconsmind', 'linea', 'steadysets', 'linecons')),						
						'group' => __('Line & Icon', 'js_composer')
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
			$theme = isset($atts['theme']) ? ' wow-vc-theme-' . $atts['theme'] : '';
			$classname = isset($atts['el_class']) ? ' ' . $atts['el_class'] : '';
			$css_animation = isset($atts['css_animation']) ? ' wpb_animate_when_almost_visible wpb_' . $atts['css_animation'] . ' animate__animated animate__' . $atts['css_animation']. ' ' . $atts['css_animation'] : null;
			$content_padding = isset($atts['content_padding']) ? $atts['content_padding'] : null;
			$content_margin = isset($atts['content_margin']) ? $atts['content_margin'] : null;
			$title = isset($atts['title']) ? $atts['title'] : null;
			$tag = isset($atts["tag"]) ? $atts["tag"] : 'h2';
			$align = isset($atts["align"]) ? ' '.$atts["align"] : ' wow-vc-text-center';
			$line_align = isset($atts["line_align"]) ? ' liner-align-'.$atts["line_align"] : ' liner-align-center';
			$delay = isset($atts["delay"]) ? ' data-delay="'.$atts["delay"].'"' : null;
			$line_height = isset($atts["line_height"]) ? $atts["line_height"] : '1px';
			$line_mobile_width = isset($atts["line_mobile_width"]) ? $atts["line_mobile_width"] : '50px';
			$line_tablet_width = isset($atts["line_tablet_width"]) ? $atts["line_tablet_width"] : '70px';
			$line_desktop_width = isset($atts["line_desktop_width"]) ? $atts["line_desktop_width"] : '90px';
			$heading_padding = isset($atts["heading_padding"]) ? $atts["heading_padding"] : null;
			$heading_margin = isset($atts["heading_margin"]) ? $atts["heading_margin"] : null;
			$line_top = isset($atts["line_top"]) ? $atts["line_top"] : null;

			// ICON 
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
			$icon_color = isset($atts['icon_color']) ? $atts['icon_color'] : null;
			$icon_color_hover = isset($atts['icon_color_hover']) ? $atts['icon_color_hover'] : null;
			$line_color = isset($atts['line_color']) ? $atts['line_color'] : null;
			$line_color_hover = isset($atts['line_color_hover']) ? $atts['line_color_hover'] : null;
			$text_color = isset($atts['text_color']) ? $atts['text_color'] : null;
			$text_secondary_color = isset($atts['text_secondary_color']) ? $atts['text_secondary_color'] : null;
			$text_secondary_color_hover = isset($atts['text_secondary_color_hover']) ? $atts['text_secondary_color_hover'] : null;
			$text_color_hover = isset($atts['text_color_hover']) ? $atts['text_color_hover'] : null;
			$text_background = isset($atts['text_background']) ? $atts['text_background'] : null;
			$icon_size = isset($atts['icon_size']) ? $atts['icon_size'] : null;
			if ($icon_fontawesome || $icon_iconsmind || $icon_linea || $icon_linecons || $icon_steadysets || $icon_openiconic || $icon_typicons || $icon_entypo || $icon_monosocial || $icon_material) {
				$icon = $icon_fontawesome.$icon_iconsmind.$icon_linea.$icon_linecons.$icon_steadysets.$icon_openiconic.$icon_typicons.$icon_entypo.$icon_monosocial.$icon_material;
			}
			$icon_padding = isset($atts['icon_padding']) ? $atts['icon_padding'] : null;
			$icon_margin = isset($atts['icon_margin']) ? $atts['icon_margin'] : null;
			$applyIconStyle = $this->applyIconStyle($icon_size);


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
			$css_build .= $content_padding ? ''. $cssname.'{padding:'.$content_padding.'!important;}' : null;
			$css_build .= $content_margin ? ''. $cssname.'{margin:'.$content_margin.'!important;}' : null;
			$css_build .= $icon_padding ? ''. $cssname.' .wow-vc-icon {padding:'.$icon_padding.'!important;}' : null;
			$css_build .= $icon_margin ? ''. $cssname.' .wow-vc-icon {margin:'.$icon_margin.'!important;}' : null;
			$css_build .= $icon_color ? ''. $cssname.' .wow-vc-icon {color:'.$this->wowHexToRGB($icon_color).'!important}' : null;
			$css_build .= $icon_color_hover ? ''. $cssname.':hover .wow-vc-icon {color:'.$this->wowHexToRGB($icon_color_hover).'!important}' : null;
			$css_build .= $icon_color_hover ? ''. $cssname.':focus .wow-vc-icon {color:'.$this->wowHexToRGB($icon_color_hover).'!important}' : null;
			$css_build .= $icon_color_hover ? ''. $cssname.':active .wow-vc-icon {color:'.$this->wowHexToRGB($icon_color_hover).'!important}' : null;
			$css_build .= $text_color ? ''. $cssname.' .wow-vc-title {color:'.$this->wowHexToRGB($text_color).'!important}' : null;
			$css_build .= $text_secondary_color ? ''. $cssname.' .wow-vc-title ins {color:'.$this->wowHexToRGB($text_secondary_color).'!important}' : null;
			$css_build .= $text_color_hover ? ''. $cssname.':hover .wow-vc-title {color:'.$this->wowHexToRGB($text_color_hover).'!important}' : null;
			$css_build .= $text_color_hover ? ''. $cssname.':focus .wow-vc-title {color:'.$this->wowHexToRGB($text_color_hover).'!important}' : null;
			$css_build .= $text_color_hover ? ''. $cssname.':active .wow-vc-title {color:'.$this->wowHexToRGB($text_color_hover).'!important}' : null;
			$css_build .= $text_secondary_color_hover ? ''. $cssname.':hover .wow-vc-title ins{color:'.$this->wowHexToRGB($text_secondary_color_hover).'!important}' : null;
			$css_build .= $text_secondary_color_hover ? ''. $cssname.':focus .wow-vc-title ins{color:'.$this->wowHexToRGB($text_secondary_color_hover).'!important}' : null;
			$css_build .= $text_secondary_color_hover ? ''. $cssname.':active .wow-vc-title ins{color:'.$this->wowHexToRGB($text_secondary_color_hover).'!important}' : null;
			$css_build .= $icon_size ? $cssname.' .wow-vc-icon{'.$applyIconStyle.'!important}' : null;
			// LINER
			$css_build .= $text_background ? ''. $cssname.' .wow-vc-title > * {background-color:'.$this->wowHexToRGB($text_background).'!important}' : null;
			$css_build .= $heading_margin ? ''. $cssname.' .wow-vc-title > * {margin:'.$heading_margin.'!important}' : null;
			$css_build .= $heading_padding ? ''. $cssname.' .wow-vc-title > * {padding:'.$heading_padding.'!important}' : null;
			// STYLE1
			$css_build .= $line_height ? ''. $cssname.'.wow-vc-theme-liner:after {height:'.$line_height.'!important}' : null;
			$css_build .= $line_top ? ''. $cssname.'.wow-vc-theme-liner:after {bottom:'.$line_top.'!important}' : null;
			$css_build .= $line_mobile_width ? ''. $cssname.'.wow-vc-theme-liner:after {width:'.$line_mobile_width.'!important}' : null;
			if($line_tablet_width) {
				$css_build .= $line_tablet_width ? '@media only screen and (min-width: 767px) {'. $cssname.'.wow-vc-theme-liner:after {width:'.$line_tablet_width.'!important}}' : null;
			}
			if($line_desktop_width) {
				$css_build .= $line_desktop_width ? '@media only screen and (min-width: 999px) {'. $cssname.'.wow-vc-theme-liner:after {width:'.$line_desktop_width.'!important}}' : null;
			}
			$css_build .= $line_color ? ''. $cssname.'.wow-vc-theme-liner:after {background-color:'.$this->wowHexToRGB($line_color).'!important}' : null;
			$css_build .= $line_color_hover ? ''. $cssname.'.wow-vc-theme-liner:hover:after {background-color:'.$this->wowHexToRGB($line_color_hover).'!important}' : null;
			// STYLE2
			$css_build .= $line_height ? ''. $cssname.'.wow-vc-theme-top:after {height:'.$line_height.'!important}' : null;
			$css_build .= $line_top ? ''. $cssname.'.wow-vc-theme-top:after {top:'.$line_top.'!important}' : null;
			$css_build .= $line_mobile_width ? ''. $cssname.'.wow-vc-theme-top:after {width:'.$line_mobile_width.'!important}' : null;
			if($line_tablet_width) {
				$css_build .= $line_tablet_width ? '@media only screen and (min-width: 767px) {'. $cssname.'.wow-vc-theme-top:after {width:'.$line_tablet_width.'!important}}' : null;
			}
			if($line_desktop_width) {
				$css_build .= $line_desktop_width ? '@media only screen and (min-width: 999px) {'. $cssname.'.wow-vc-theme-top:after {width:'.$line_desktop_width.'!important}}' : null;
			}
			$css_build .= $line_color ? ''. $cssname.'.wow-vc-theme-top:after {background-color:'.$line_color.'!important}' : null;
			$css_build .= $line_color_hover ? ''. $cssname.'.wow-vc-theme-top:hover:after {background-color:'.$this->wowHexToRGB($line_color_hover).'!important}' : null;
			// STYLE3
			$css_build .= $line_height ? ''. $cssname.'.wow-vc-theme-middle .wow-vc-title span:after {height:'.$line_height.'!important}' : null;
			$css_build .= $line_top ? ''. $cssname.'.wow-vc-theme-middle .wow-vc-title span:after {bottom:'.$line_top.'!important}' : null;
			$css_build .= $line_mobile_width ? ''. $cssname.'.wow-vc-theme-middle .wow-vc-title span:after {width:'.$line_mobile_width.'!important}' : null;
			if($line_tablet_width) {
				$css_build .= $line_tablet_width ? '@media only screen and (min-width: 767px) {'. $cssname.'.wow-vc-theme-middle .wow-vc-title span:after {width:'.$line_tablet_width.'!important}}' : null;
			}
			if($line_desktop_width) {
				$css_build .= $line_desktop_width ? '@media only screen and (min-width: 999px) {'. $cssname.'.wow-vc-theme-middle .wow-vc-title span:after {width:'.$line_desktop_width.'!important}}' : null;
			}
			$css_build .= $line_color ? ''. $cssname.'.wow-vc-theme-middle .wow-vc-title span:after {background-color:'.$this->wowHexToRGB($line_color).'!important}' : null;
			$css_build .= $line_color_hover ? ''. $cssname.'.wow-vc-theme-middle:hover .wow-vc-title span:after {background-color:'.$this->wowHexToRGB($line_color_hover).'!important}' : null;

			// FrontEnd
			$output = ($css || $css_build) ? '<style>' . $css .$css_build. '</style>' : '';
			$output .= '<section'. $block_id .' class="wow-vc-elements wow-vc-' . $this->name . $css_class.$theme. $classname.$cssaddclass.$align.$css_animation.$line_align.'"' . str_replace('``', '', $attribute) . $delay.'>';
			$output .= $title ? $this->applyHeadingMagic($title,$tag,'span',$icon ? $this->applyIcon($icon) : null) : null;
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
new wowVC_Addons_Heading;
