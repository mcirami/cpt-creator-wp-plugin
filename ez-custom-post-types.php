<?php
	/**
	* Plugin Name: EZ Custom Post Type Creator
	* Plugin URI: http://red8interactive.com
	* Description: Add a custom post type instantly
	* Version: 1.0
	* Author: Red8 Interactive
	* Author URI: http://red8interactive.com
	* License: GPL2
	*/
 
	/*
		Copyright 2015 MSC Web Services  (email : matteo@mscwebservices.net)
	
		This program is free software; you can redistribute it and/or
		modify it under the terms of the GNU General Public License
		as published by the Free Software Foundation; either version 2
		of the License, or (at your option) any later version.
		
		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.
		
		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
	*/

	if ( ! defined( 'ABSPATH' ) ) { 
    	die; // Exit if accessed directly
	}
	
	if( !class_exists('EZ_CPT_Creator') ) {
		
		class EZ_CPT_Creator {
		
			function __construct() {
				self::define_constants();
				self::load_hooks();
			}
			
			/**
			* Defines plugin constants
			*/
			public static function define_constants() {
				define('CPT_CREATOR_PATH', plugins_url( ' ', __FILE__ ) ); 
				define('CPT_CREATOR_BASENAME', plugin_basename( __FILE__ ));
				define('CPT_CREATOR_OPTION_GROUP', 'cpt_creator_options');
				define('CPT_INCREMENT', 'cpt_increment');
				define('CPT_TAX_OPTION_GROUP', 'tax_options');
				define('TAX_INCREMENT', 'tax_increment');
				define('VERSION', '1.0.0');

				define('CPT_CREATOR_SETTING', 'cpt_creator_setting' );
			}
			
			public function enqueue_styles() {
			
				wp_enqueue_style( 'dashicons' );
				wp_enqueue_style(
					'cpt-creator-admin',
					plugins_url('ez-custom-post-type-creator/assets/css/admin.css'),
					array(), $version
				);
			}
			
			public function enqueue_scripts() {
				wp_enqueue_media();
				wp_enqueue_script(
					'cpt-creator-admin',
					plugins_url('ez-custom-post-type-creator/assets/js/admin.js'),
					array('jquery'), $version
				);
			}
			
			public static function load_hooks() {
				add_action('admin_menu', array(__CLASS__, 'cpt_creator_create_menu'));
				add_action('admin_init', array(__CLASS__, 'cpt_creator_settings'));
				add_action( 'admin_enqueue_scripts', array(__CLASS__, 'enqueue_styles') );
				add_action( 'admin_enqueue_scripts', array(__CLASS__, 'enqueue_scripts') );
				add_action('admin_init', array(__CLASS__, 'cpt_creator_actions'));
				//add_action('wp_ajax_delete_tax', array(__CLASS__, 'delete_tax_ajax') );

				add_action('init', array(__CLASS__, 'register_cpt_custom') );
				add_action('init', array(__CLASS__, 'register_tax') );
			}

			/*************************************************
			 * Admin Area
			**************************************************/
			
			public static function cpt_creator_create_menu() {
				$cpt_menu = add_menu_page("EZ Custom Post Type Creator", "EZ Custom Post Types", 'administrator', __FILE__, array(__CLASS__, 'display_cpt_page'), '');
				add_submenu_page($cpt_menu, "Add New Custom Post Type", "Add Post Type", 'administrator', 'add-new-custom-post-type', array(__CLASS__, 'add_new_cpt_page'));
				$tax_menu = add_submenu_page(__FILE__, "Taxonomies", "EZ Taxonomies", 'administrator', "taxonomies", array(__CLASS__, 'display_tax_page'), '');
				add_submenu_page($tax_menu, "Add New Taxonomy", "Add Taxonomy", 'administrator', 'add-new-taxonomy', array(__CLASS__, 'add_new_taxonomy_page'));
				
				//add_action('admin_init', array(__CLASS__, 'register_cpt_creator_settings'));
			}
			
			public static function add_new_cpt_page() {
				require (plugin_dir_path(__FILE__ ) . 'templates/add-new-cpt-page.php');
			}
			
			public static function display_cpt_page() {
				require (plugin_dir_path(__FILE__ ) . 'templates/display-cpt-page.php');
			}
			
			public static function display_tax_page() {
				require (plugin_dir_path(__FILE__ ) . 'templates/display-taxonomy-page.php');
			}
			
			public static function add_new_taxonomy_page() {
				require (plugin_dir_path(__FILE__ ) . 'templates/add-new-taxonomy-page.php');
			}
			
			
			public static function cpt_creator_settings() {
				add_action('admin_post_add_new_cpt', array(__CLASS__, 'add_new_cpt'));
				add_action('admin_post_update_cpt', array(__CLASS__, 'update_cpt'));
				add_action('admin_post_delete_cpt', array(__CLASS__, 'delete_cpt'));
				add_action('admin_post_add_new_tax', array(__CLASS__, 'add_new_tax'));
				add_action('admin_post_update_tax', array(__CLASS__, 'update_tax'));
				add_action('admin_post_delete_tax', array(__CLASS__, 'delete_tax'));
			}
			
			/*
			public static function delete_tax_ajax() {
				
				$post_options = unserialize(get_option(CPT_TAX_OPTION_GROUP));
					$id = $_POST['taxID'];
					$i = 0;
	
					if($post_options) {
				
						foreach($post_options as $options) {
			
							if($options->unique_id == $id) {
								break;
							}
							$i++;
						}
						
						if (count($post_options) > 1) {
							unset($post_options[$i]);
							update_option( CPT_TAX_OPTION_GROUP, serialize($post_options) );
							wp_redirect( 'admin.php?page=taxonomies' );
							
						} else {
							delete_option( CPT_TAX_OPTION_GROUP, serialize($post_options) );
							delete_option( TAX_INCREMENT );
							wp_redirect( 'admin.php?page=taxonomies' );
						}
					}
			}*/
			
			public static function register_cpt_custom() {
				$post_options = unserialize(get_option(CPT_CREATOR_OPTION_GROUP));
				
				if ($post_options) {
				
					foreach($post_options as $object) {
											
						//labels
						$cpt_labels = array(
							'name' 				=> ( $object->post_type_name ),
							'singular_name' 	=> ( $object->singular_name ),
							'add_new' 			=> ( $object->add_new ),
							'add_new_item' 		=> ( $object->add_new_item ),
							'edit_item' 		=> ( $object->edit_item ),
							'new_item' 			=> ( $object->new_item ),
							'view_item' 		=> ( $object->view_item ),
							'search_items' 		=> ( $object->search_items ),
							'not_found' 		=> ( $object->not_found ),
							'not_found_in_trash'=> ( $object->not_found_in_trash ),
							'parent_item_colon' => ( $object->parent_item_colon ),
							'menu_name' 		=> ( $object->menu_name ),
						);
						
						
						// $args
						$args = array(
							'labels'				=> $cpt_labels,
							'hierarchical'			=> filter_var($object->hierarchical, FILTER_VALIDATE_BOOLEAN),
							'description'			=> esc_html($object->description ),
							'supports'				=> $object->supports,
							'taxonomies'			=> array($object->taxonomies),
							'public'				=> filter_var($object->public_option, FILTER_VALIDATE_BOOLEAN),
							'show_ui'				=> filter_var($object->show_ui, FILTER_VALIDATE_BOOLEAN),
							'show_in_menu'			=> filter_var($object->show_in_menu, FILTER_VALIDATE_BOOLEAN),
							'show_in_nav_menus'		=> filter_var($object->show_in_nav_menus, FILTER_VALIDATE_BOOLEAN),
							'menu_position'			=> intval($object->menu_position),
							'publicly_queryable'	=> filter_var($object->publicly_queryable, FILTER_VALIDATE_BOOLEAN),
							'exclude_from_search'	=> filter_var($object->exclude_from_search, FILTER_VALIDATE_BOOLEAN),
							'has_archive'			=> filter_var($object->has_archive, FILTER_VALIDATE_BOOLEAN),
							'query_var'				=> filter_var($object->query_var, FILTER_VALIDATE_BOOLEAN),
							'can_export'			=> filter_var($object->can_export, FILTER_VALIDATE_BOOLEAN),
							'capability_type'		=> $object->capability_type,
							'menu_icon'				=> $object->menu_icon
						);
						
						$post_type_name = str_replace(" ", "", strtolower($object->post_type_name));
						
						register_post_type( $post_type_name, $args );
					}
				}
			}

			
			public static function add_new_cpt() {
			
				$post_options = unserialize(get_option(CPT_CREATOR_OPTION_GROUP));
				$id = 1;
				
				if (get_option(CPT_INCREMENT)) {
					$id = intval(get_option(CPT_INCREMENT)) + 1;
				}
				update_option(CPT_INCREMENT, $id);
				
				$cpt_object = new CPT_Creator();
				
				$cpt_object->unique_id = $id;
				$cpt_object->menu_icon = $_POST['select_icon'] ? sanitize_text_field($_POST['select_icon']) : 'dashicons-admin-post';
				$cpt_object->hierarchical = $_POST['hierarchical'];
				$cpt_object->description = sanitize_text_field($_POST['description']);
				$cpt_object->supports = $_POST['supports'];
				$cpt_object->taxonomies = $_POST['taxonomies'];
				$cpt_object->public_option = $_POST['public'];
				$cpt_object->show_ui = $_POST['show_ui'];
				$cpt_object->show_in_menu = $_POST['show_in_menu'];
				$cpt_object->menu_position = $_POST['menu_position'];
				$cpt_object->show_in_nav_menus = $_POST['show_in_nav_menus'];
				$cpt_object->publicly_queryable = $_POST['publicly_queryable'];
				$cpt_object->exclude_from_search =$_POST['exclude_from_search'];
				$cpt_object->has_archive = $_POST['has_archive'];
				$cpt_object->query_var = $_POST['query_var'];
				$cpt_object->can_export = $_POST['can_export'];
				$cpt_object->capability_type = $_POST['capability_type'];

				//Labels
				$cpt_object->post_type_name = sanitize_text_field($_POST['post_type_name']);
				$cpt_object->singular_name = $_POST['post_type_name'] ? sanitize_text_field($_POST['post_type_name']) : $cpt_object->post_type_name;
				$cpt_object->add_new = $_POST['add_new'] ? sanitize_text_field($_POST['add_new']) : "Add New";
				$cpt_object->add_new_item = $_POST['add_new_item'] ? sanitize_text_field($_POST['add_new_item']) : __('Add New Post');
				$cpt_object->edit_item = $_POST['edit_item'] ? sanitize_text_field($_POST['edit_item']) : __('Edit Post');
				$cpt_object->new_item = $_POST['new_item'] ? sanitize_text_field($_POST['new_item']) : __('New Post');
				$cpt_object->view_item = $_POST['view_item'] ? sanitize_text_field($_POST['view_item']) : __('View Post');
				$cpt_object->search_items = $_POST['search_items'] ? sanitize_text_field($_POST['search_items']) : __('Search Posts');
				$cpt_object->not_found = $_POST['not_found'] ? sanitize_text_field($_POST['not_found']) : __('No posts found.');
				$cpt_object->not_found_in_trash = $_POST['not_found_in_trash'] ? sanitize_text_field($_POST['not_found_in_trash']) : __('No posts found in Trash.');
				$cpt_object->parent_item_colon = $_POST['parent_item_colon'] ? sanitize_text_field($_POST['parent_item_colon']) : __('Parent Page');
				$cpt_object->menu_name = $_POST['menu_name'] ? sanitize_text_field($_POST['menu_name']) : $cpt_object->post_type_name;
				
				$post_options[] = $cpt_object;
				update_option(CPT_CREATOR_OPTION_GROUP, serialize($post_options));

				wp_redirect( get_admin_url() . 'admin.php?page=ez-custom-post-type-creator/ez-custom-post-types.php&msg=add_new' );
				exit();
				
			}//end add_new_Cpt function
			
			public static function update_cpt() {
				$post_options = unserialize(get_option(CPT_CREATOR_OPTION_GROUP));
				$current_cpt = NULL;
				$unique_id = $_POST['id'];
				$i = 0;
				
				if($post_options) {
					
					foreach($post_options as $options) {

						if($options->unique_id == $unique_id) {
							$current_cpt = $options;
							break;
						}
						$i++;
					}
				}

				if ($current_cpt) {
					$current_cpt->unique_id = $unique_id;
					$current_cpt->menu_icon = $_POST['select_icon'] ? sanitize_text_field($_POST['select_icon']) : 'dashicons-admin-post';
					$current_cpt->hierarchical = $_POST['hierarchical'];
					$current_cpt->description = sanitize_text_field($_POST['description']);
					$current_cpt->supports = $_POST['supports'];
					$current_cpt->taxonomies = $_POST['taxonomies'];
					$current_cpt->public_option = $_POST['public'];
					$current_cpt->show_ui = $_POST['show_ui'];
					$current_cpt->show_in_menu = $_POST['show_in_menu'];
					$current_cpt->menu_position = $_POST['menu_position'];
					$current_cpt->show_in_nav_menus = $_POST['show_in_nav_menus'];
					$current_cpt->publicly_queryable = $_POST['publicly_queryable'];
					$current_cpt->exclude_from_search =$_POST['exclude_from_search'];
					$current_cpt->has_archive = $_POST['has_archive'];
					$current_cpt->query_var = $_POST['query_var'];
					$current_cpt->can_export = $_POST['can_export'];
					$current_cpt->capability_type = $_POST['capability_type'];

					//Labels
					$current_cpt->post_type_name = sanitize_text_field($_POST['post_type_name']);
					$current_cpt->singular_name = $_POST['post_type_name'] ? sanitize_text_field($_POST['post_type_name']) : $current_cpt->post_type_name;
					$current_cpt->add_new = $_POST['add_new'] ? sanitize_text_field($_POST['add_new']) : "Add New";
					$current_cpt->add_new_item = $_POST['add_new_item'] ? sanitize_text_field($_POST['add_new_item']) : __('Add New Post');
					$current_cpt->edit_item = $_POST['edit_item'] ? sanitize_text_field($_POST['edit_item']) : __('Edit Post');
					$current_cpt->new_item = $_POST['new_item'] ? sanitize_text_field($_POST['new_item']) : __('New Post');
					$current_cpt->view_item = $_POST['view_item'] ? sanitize_text_field($_POST['view_item']) : __('View Post');
					$current_cpt->search_items = $_POST['search_items'] ? sanitize_text_field($_POST['search_items']) : __('Search Posts');
					$current_cpt->not_found = $_POST['not_found'] ? sanitize_text_field($_POST['not_found']) : __('No posts found.');
					$current_cpt->not_found_in_trash = $_POST['not_found_in_trash'] ? sanitize_text_field($_POST['not_found_in_trash']) : __('No posts found in Trash.');
					$current_cpt->parent_item_colon = $_POST['parent_item_colon'] ? sanitize_text_field($_POST['parent_item_colon']) : __('Parent Page');
					$current_cpt->menu_name = $_POST['menu_name'] ? sanitize_text_field($_POST['menu_name']) : $cpt_object->post_type_name;
					
					$post_options[$i] = $current_cpt;
					update_option(CPT_CREATOR_OPTION_GROUP, serialize($post_options));
				}
				
				wp_redirect( get_admin_url() . 'admin.php?page=ez-custom-post-type-creator/ez-custom-post-types.php&msg=update_cpt' );
				exit();
			}
			
			public static function delete_cpt() {

				$post_options = unserialize(get_option(CPT_CREATOR_OPTION_GROUP));
				$id = $_GET['key'];
				$i = 0;

				if($post_options) {
			
					foreach($post_options as $options) {

						if($options->unique_id == $id) {
							break;
						}
						$i++;
					}
					
					if (count($post_options) > 1) {
						unset($post_options[$i]);
						update_option( CPT_CREATOR_OPTION_GROUP, serialize($post_options) );
						wp_redirect( get_admin_url() . 'admin.php?page=ez-custom-post-type-creator%2Fez-custom-post-types.php&msg=del_cpt' );
					} else {
						unset($post_options[$i]);
						delete_option( CPT_CREATOR_OPTION_GROUP, serialize($post_options) );
						delete_option(CPT_INCREMENT);
						wp_redirect( get_admin_url() . 'admin.php?page=ez-custom-post-type-creator%2Fez-custom-post-types.php&msg=del_cpt' );
					}
				}
			}
			
			public static function register_tax() {
				$tax_options = unserialize(get_option(CPT_TAX_OPTION_GROUP));
				
				if ($tax_options) {
				
					foreach($tax_options as $object) {
											
						//labels
						$tax_labels = array(
							'name' 				=> ( $object->tax_name ),
							'singular_name' 	=> ( $object->singular_name ),
							'menu_name' 		=> ( $object->menu_name ),
							'all_items'			=> ( $object->all_items ),
							'edit_item' 		=> ( $object->edit_item ),
							'view_item' 		=> ( $object->view_item ),
							'update_item'		=> ( $object->update_item),
							'add_new_item' 		=> ( $object->add_new_item ),
							'new_item_name'		=> ( $object->new_item ),
							'parent_item'		=> ( $object->parent_item ), // hierarchical only
							'parent_item_colon' => ( $object->parent_item_colon ),
							'search_items' 		=> ( $object->search_items ),
							'popular_items'		=> ( $object->popular_items ), // non-hierarchical only
							'separate_items_with_commas' => ( $object->separate_with_commas ), // non-hierarchical only
							'add_or_remove_items' 		=> ( $object->add_or_remove ), // non-hierarchical only
							'choose_from_most_used' 	=> ( $object->most_used ) , // non-hierarchical only
							'not_found' 		=> ( $object->not_found )
						);
						
						
						// $args
						$args = array(
							'labels'				=> $tax_labels,
							'public'				=> filter_var($object->public_option, FILTER_VALIDATE_BOOLEAN),
							'show_ui'				=> filter_var($object->show_ui, FILTER_VALIDATE_BOOLEAN),
							'show_in_nav_menus'		=> filter_var($object->show_in_nav_menus, FILTER_VALIDATE_BOOLEAN),
							'show_tagcloud'			=> filter_var($object->show_tagcloud, FILTER_VALIDATE_BOOLEAN),
							'show_in_quick_edit'	=> filter_var($object->quick_edit, FILTER_VALIDATE_BOOLEAN),
							'meta_box_cb'			=> $object->meta_box,
							'show_admin_column'		=> filter_var($object->admin_column, FILTER_VALIDATE_BOOLEAN),
							'hierarchical'			=> filter_var($object->hierarchical, FILTER_VALIDATE_BOOLEAN),
							'update_count_callback' => $object->count_callback,
							'query_var'				=> $object->query_var,
							'rewrite'				=> array($object->rewrite),
							'capabilities'			=> array($object->capabilities),
							'sort'					=> filter_var($object->sort, FILTER_VALIDATE_BOOLEAN),
							'_builtin'				=> filter_var($object->builtin, FILTER_VALIDATE_BOOLEAN)
						);
						
						$tax_name = str_replace(" ", "", strtolower($object->tax_name));
						
						register_taxonomy( $tax_name, $object->post_types, $args );
					}
				}
			} // end register_tax
			
			public static function add_new_tax() {
			
				$tax_options = unserialize(get_option(CPT_TAX_OPTION_GROUP));
				$id = 1;
				
				if (get_option(TAX_INCREMENT)) {
					$id = intval(get_option(TAX_INCREMENT)) + 1;
				}
				update_option(TAX_INCREMENT, $id);
				
				$tax_object = new CPT_Tax_Creator();

				$tax_object->unique_id = $id;
				$tax_object->hierarchical = $_POST['hierarchical'];
				$tax_object->public_option = $_POST['public'];
				$tax_object->show_ui = $_POST['show_ui'];
				$tax_object->show_in_nav_menus = $_POST['show_in_nav_menus'];
				$tax_object->show_tagcloud = $_POST['show_tagcloud'];
				$tax_object->quick_edit =$_POST['quick_edit'];
				$tax_object->meta_box = $_POST['meta_box'] ? sanitize_text_field($_POST['meta_box']) : NULL;
				$tax_object->query_var = $_POST['query_var'];
				$tax_object->admin_column = $_POST['admin_column'];
				$tax_object->count_callback = $_POST['count_callback'] ? sanitize_text_field($_POST['count_callback']) : '';
				$tax_object->rewrite = $_POST['rewrite'] ? sanitize_text_field($_POST['rewrite']) : true;
				$tax_object->capabilities = $_POST['capabilities'] ? sanitize_text_field($_POST['capabilities']) : 'None';
				$tax_object->sort = $_POST['sort'];
				$tax_object->builtin = $_POST['builtin'];

				//Labels
				$tax_object->post_types = $_POST['post_types'];
				$tax_object->tax_name = sanitize_text_field($_POST['tax_name']);
				$tax_object->singular_name = $_POST['singular_name'] ? sanitize_text_field($_POST['singular_name']) : $tax_object->tax_name;
				$tax_object->menu_name = $_POST['menu_name'] ? sanitize_text_field($_POST['menu_name']) : $tax_object->tax_name;
				$tax_object->all_items = $_POST['all_items'] ? sanitize_text_field($_POST['all_items']) : __( 'All Tags' );
				$tax_object->edit_item = $_POST['edit_item'] ? sanitize_text_field($_POST['edit_item']) : __( 'Edit Tag' ) ;
				$tax_object->view_item = $_POST['view_item'] ? sanitize_text_field($_POST['view_item']) : __( 'View Tag' ) ;
				$tax_object->update_item = $_POST['update_item'] ? sanitize_text_field($_POST['update_item']) : __( 'Update Tag' );
				$tax_object->add_new_item = $_POST['add_new_item'] ? sanitize_text_field($_POST['add_new_item']) : __( 'Add New Tag' );
				$tax_object->new_item = $_POST['new_item_name'] ? sanitize_text_field($_POST['new_item_name']) : __( 'New Tag Name' );
				$tax_object->parent_item = $_POST['parent_item'] ? sanitize_text_field($_POST['parent_item']) : null;
				$tax_object->parent_item_colon = $_POST['parent_item_colon'] ? sanitize_text_field($_POST['parent_item_colon']) : null;
				$tax_object->search_items = $_POST['search_items'] ? sanitize_text_field($_POST['search_items']) : __( 'Search Tags' );
				$tax_object->popular_items = $_POST['popular_items'] ? sanitize_text_field($_POST['popular_items']) : null;
				$tax_object->separate_items_with_commas = $_POST['separate_items_with_commas'] ? sanitize_text_field($_POST['separate_items_with_commas']) : null;
				$tax_object->add_or_remove = $_POST['add_or_remove_items'] ? sanitize_text_field($_POST['add_or_remove_items']) : null;
				$tax_object->most_used = $_POST['choose_from_most_used'] ? sanitize_text_field($_POST['choose_from_most_used']) : null;
				$tax_object->not_found = $_POST['not_found'] ? sanitize_text_field($_POST['not_found']) : __( 'No tags found.' );
				
				$tax_options[] = $tax_object;
				update_option(CPT_TAX_OPTION_GROUP, serialize($tax_options));
							
				wp_redirect( get_admin_url() . 'admin.php?page=taxonomies&msg=add_new' );
				exit();
				
			}//end add_new_tax function
			
			public static function update_tax() {
				$tax_options = unserialize(get_option(CPT_TAX_OPTION_GROUP));
				$tax_object = NULL;
				$unique_id = $_POST['id'];
				$i = 0;
				
				if($tax_options) {
					
					foreach($tax_options as $options) {

						if($options->unique_id == $unique_id) {
							$tax_object = $options;
							break;
						}
						$i++;
					}
				}

				if ($tax_object) {
					$tax_object->unique_id = $id;
					$tax_object->hierarchical = $_POST['hierarchical'];
					$tax_object->public_option = $_POST['public'];
					$tax_object->show_ui = $_POST['show_ui'];
					$tax_object->show_in_nav_menus = $_POST['show_in_nav_menus'];
					$tax_object->show_tagcloud = $_POST['show_tagcloud'];
					$tax_object->quick_edit =$_POST['quick_edit'];
					$tax_object->meta_box = $_POST['meta_box'] ? sanitize_text_field($_POST['meta_box']) : NULL;
					$tax_object->query_var = $_POST['query_var'];
					$tax_object->admin_column = $_POST['admin_column'];
					$tax_object->count_callback = $_POST['count_callback'] ? sanitize_text_field($_POST['count_callback']) : '';
					$tax_object->rewrite = $_POST['rewrite'] ? sanitize_text_field($_POST['rewrite']) : true;
					$tax_object->capabilities = $_POST['capabilities'] ? sanitize_text_field($_POST['capabilities']) : 'None';
					$tax_object->sort = $_POST['sort'];
					$tax_object->builtin = $_POST['builtin'];
					
					//Labels
					$tax_object->post_types = $_POST['post_types'];
					$tax_object->tax_name = sanitize_text_field($_POST['tax_name']);
					$tax_object->singular_name = $_POST['singular_name'] ? sanitize_text_field($_POST['singular_name']) : $tax_object->tax_name;
					$tax_object->menu_name = $_POST['menu_name'] ? sanitize_text_field($_POST['menu_name']) : $tax_object->tax_name;
					$tax_object->all_items = $_POST['all_items'] ? sanitize_text_field($_POST['all_items']) : __( 'All Tags' );
					$tax_object->edit_item = $_POST['edit_item'] ? sanitize_text_field($_POST['edit_item']) : __( 'Edit Tag' ) ;
					$tax_object->view_item = $_POST['view_item'] ? sanitize_text_field($_POST['view_item']) : __( 'View Tag' ) ;
					$tax_object->update_item = $_POST['update_item'] ? sanitize_text_field($_POST['update_item']) : __( 'Update Tag' );
					$tax_object->add_new_item = $_POST['add_new_item'] ? sanitize_text_field($_POST['add_new_item']) : __( 'Add New Tag' );
					$tax_object->new_item = $_POST['new_item_name'] ? sanitize_text_field($_POST['new_item_name']) : __( 'New Tag Name' );
					$tax_object->parent_item = $_POST['parent_item'] ? sanitize_text_field($_POST['parent_item']) : null;
					$tax_object->parent_item_colon = $_POST['parent_item_colon'] ? sanitize_text_field($_POST['parent_item_colon']) : null;
					$tax_object->search_items = $_POST['search_items'] ? sanitize_text_field($_POST['search_items']) : __( 'Search Tags' );
					$tax_object->popular_items = $_POST['popular_items'] ? sanitize_text_field($_POST['popular_items']) : null;
					$tax_object->separate_items_with_commas = $_POST['separate_items_with_commas'] ? sanitize_text_field($_POST['separate_items_with_commas']) : null;
					$tax_object->add_or_remove = $_POST['add_or_remove_items'] ? sanitize_text_field($_POST['add_or_remove_items']) : null;
					$tax_object->most_used = $_POST['choose_from_most_used'] ? sanitize_text_field($_POST['choose_from_most_used']) : null;
					$tax_object->not_found = $_POST['not_found'] ? sanitize_text_field($_POST['not_found']) : __( 'No tags found.' );
					
					$tax_options[$i] = $tax_object;
					update_option(CPT_TAX_OPTION_GROUP, serialize($tax_options));
				}
				
				wp_redirect( get_admin_url() . 'admin.php?page=taxonomies&msg=update_tax' );
				exit();
				
			} // end class update tax
			
			public static function delete_tax() {
				$tax_options = unserialize(get_option(CPT_TAX_OPTION_GROUP));
				$id = $_GET['key'];
				$i = 0;

				if($tax_options) {
			
					foreach($tax_options as $options) {
		
						if($options->unique_id == $id) {
							break;
						}
						$i++;
					}
					
					if (count($tax_options) > 1) {
						unset($tax_options[$i]);
						update_option( CPT_TAX_OPTION_GROUP, serialize($tax_options) );
						wp_redirect( get_admin_url() . 'admin.php?page=taxonomies&msg=del_tax' );
					} else {
						unset($tax_options[$i]);
						delete_option( CPT_TAX_OPTION_GROUP, serialize($tax_options) );
						delete_option( TAX_INCREMENT );
						wp_redirect( get_admin_url() . 'admin.php?page=taxonomies&msg=del_tax' );
					}
				}
			} // end delete tax
			
			public static function cpt_creator_actions(){
				
				if ( isset( $_GET['action'] ) && $_GET['action'] == 'del_tax' ) {
					self::delete_tax();
				}
				
				if ( isset( $_GET['action'] ) && $_GET['action'] == 'del_cpt' ) {
					self::delete_cpt();
				}
			}
			
		} //end class EZ_CPT_Creator
		
		 $class['EZ_CPT_Creator'] = new EZ_CPT_Creator();
		
	} // end 'if class exists'
	

	if (!class_exists('CPT_Creator')) {
	
		class CPT_Creator {
			
			//options
			public $unique_id;
			public $hierarchical;
			public $description;
			public $supports;
			public $taxonomies;
			public $public_option;
			public $show_ui;
			public $show_in_menu;
			public $menu_position;
			public $show_in_nav_menus;
			public $publicly_queryable;
			public $exclude_from_search;
			public $has_archive;
			public $query_var;
			public $can_export;
			public $capability_type;
			public $menu_icon;
			
			//labels
			public $post_type_name;
			public $singular_name;
			public $add_new;
			public $add_new_item;
			public $edit_item;
			public $new_item;
			public $view_item;
			public $search_items;
			public $not_found;
			public $not_found_in_trash;
			public $parent_item_colon;
			public $menu_name;
		
			function __construct() {
				
			}
		}  //end of cpt_creator class
	} //end of 'if' cpt_creator class exists
	
	if (!class_exists('CPT_Tax_Creator')) {
		
		class CPT_Tax_Creator {
		
			//labels
			public $post_types;
			public $tax_name;
			public $singular_name;
			public $menu_name;
			public $all_items;
			public $edit_item;
			public $view_item;
			public $update_item;
			public $add_new_item;
			public $new_item;
			public $parent_item;
			public $parent_item_colon;
			public $search_items;
			public $popular_items;
			public $separate_items_with_commas;
			public $add_or_remove;
			public $most_used;
			public $not_found;
			
			//options
			public $unique_id;
			public $hierarchical;
			public $public_option;
			public $show_ui;
			public $show_in_nav_menus;
			public $show_tagcloud;
			public $quick_edit;
			public $meta_box;
			public $query_var;
			public $admin_column;
			public $count_callback;
			public $rewrite;
			public $capabilities;
			public $sort;
			public $builtin;
		
			function __construct() {
				
			}
		} //end of cpt_tax_creator class
	} //end of 'if' cpt_tax_creator class exists
	
	
