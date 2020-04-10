<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>

<?php 
	if(isset($_GET['id'])) {
		$postID = $_GET['id'];
		require (plugin_dir_path(__FILE__ ) . 'edit-cpt-page.php');
	} else {
?>

	
<div class="ez_cpt_creator wrap">
	<h1><?php esc_attr_e( 'Add A Custom Post Type', 'wp_admin_style' ); ?></h1>
	
	<div class="name_error form-invalid"><?php esc_attr_e( 'You must enter a Name', 'wp_admin_style' ); ?></div>
	
	<div id="col-container">
		<form method="post" name="new_cpt_form" id="new_cpt_form" action="<?php echo get_admin_url(); ?>admin-post.php" >
			<div id="col-right">
				<div class="col-wrap">
					<h2><?php esc_attr_e( 'Options', 'wp_admin_style' ); ?></h2><br>
					<div class="inside">
						<label class="icon_label" for="select_icon">Admin Menu Icon:</label>
						<div class="input_wrap menu_icon">
							<input class="icon_text" type="text" size="36" name="select_icon" value="" />
							<input name="select_icon" class="button select_icon_button" type="button" value="Select Icon" /> or 
							<input name="upload_icon" class="button upload_icon_button" type="button" value="Upload Icon" /><br>
							<span>(Note: If uploading icon, size must not be larger than 16px x 16px)</span>
						</div><br>
						
						<div class="dashicon_picker_container">
							<ul class="dashicon_picker_list" /></ul>
						</div>
						
						<label for="description" class="single_line_label">Description:</label>
						<textarea name="description" value=""></textarea><br>
						
						<label for="supports[]" class="single_line_label">Supports:</label>
						<div class="input_wrap">
							<ul>
								<li><input name="supports[]" type="checkbox" value="title" />title</li>
								<li><input name="supports[]" type="checkbox" value="editor" />editor</li>
								<li><input name="supports[]" type="checkbox" value="author" />author</li>
								<li><input name="supports[]" type="checkbox" value="thumbnail" />thumbnail</li>
								<li><input name="supports[]" type="checkbox" value="excerpt" />excerpt</li>
								<li><input name="supports[]" type="checkbox" value="trackbacks" />trackbacks</li>
							</ul>
							<ul>
								<li><input name="supports[]" type="checkbox" value="customFields" />custom fields</li>
								<li><input name="supports[]" type="checkbox" value="comments" />comments</li>
								<li><input name="supports[]" type="checkbox" value="revisions" />revisions</li>
								<li><input name="supports[]" type="checkbox" value="pageAttributes"/>page attributes</li>
								<li><input name="supports[]" type="checkbox" value="postFormats" />post formats</li>
							</ul>
						</div><br>

						<label for="taxonomies" class="single_line_label">Taxonomies:</label>
						<input name="taxonomies" type="text" /><br>
						
						<div class="column">
							<label for="menu_position" class="single_line_label">Menu Position:</label>
							<select name="menu_position">
								<option value="5">5 - below Posts</option>
								<option value="10">10 - below Media</option>
								<option value="15">15 - below Links</option>
								<option value="20">20 - below Pages</option>
								<option value="25" selected="true">25 - below comments</option>
								<option value="60">60 - below first separator</option>
								<option value="65">65 - below Plugins</option>
								<option value="70">70 - below Users</option>
								<option value="75">75 - below Tools</option>
								<option value="80">80 - below Settings</option>
								<option value="100">100 - below second separator</option>
							</select><br>
							
							<label for="hierarchical" class="single_line_label">Hierarchical:</label>
							<select name="hierarchical">
								<option value="1" selected="selected">True</option>	
								<option value="0">False</option>
							</select><br>
							
							<label for="public" class="single_line_label">Public:</label>
							<select name="public">
								<option value="1" selected="selected">True</option>
								<option value="0">False</option>
							</select><br>
							
							<label for="show_ui" class="single_line_label">Show UI:</label>
							<select name="show_ui">
								<option value="1" selected="selected">True</option>
								<option value="0">False</option>
							</select><br>
							
							<label for="show_in_menu" class="single_line_label">Show In Menu:</label>
							<select name="show_in_menu">
								<option value="1" selected="selected">True</option>
								<option value="0">False</option>
							</select><br>
							
							<label for="show_in_nav_menus" class="single_line_label">Show In Nav Menus:</label>
							<select name="show_in_nav_menus">
								<option value="1" selected="selected">True</option>
								<option value="0">False</option>
							</select><br>
						</div>
						
						<div class="column">
							<label for="publicly_queryable" class="single_line_label">Publicly Queryable:</label>
							<select name="publicly_queryable">
								<option value="1" selected="selected">True</option>
								<option value="0">False</option>
							</select><br>
							
							<label for="exclude_from_search" class="single_line_label">Exclude From Search:</label>
							<select name="exclude_from_search">
								<option value="1">True</option>
								<option value="0" selected="selected">False</option>
							</select><br>
							
							<label for="has_archive" class="single_line_label">Has Archive:</label>
							<select name="has_archive">
								<option value="1" selected="selected">True</option>
								<option value="0">False</option>
							</select><br>
							
							<label for="query_var" class="single_line_label">Query Var:</label>
							<select name="query_var">
								<option value="1" selected="selected">True</option>
								<option value="0">False</option>
							</select><br>
							
							<label for="can_export" class="single_line_label">Can Export:</label>
							<select name="can_export">
								<option value="1" selected="selected">True</option>
								<option value="0">False</option>
							</select><br>
							
							<label for="capability_type" class="single_line_label">Capability Type:</label>
							<select name="capability_type">
								<option value="page">Page</option>
								<option value="post" selected="selected">Post</option>
							</select><br>
						</div>
						
					</div><!-- end 'inside' -->
				</div><!-- end 'col-wrap' -->
			</div><!-- end 'col-right' -->
			<div id="col-left">
				<div class="col-wrap">
					<h2><?php esc_attr_e( 'Labels', 'wp_admin_style' ); ?></h2><br>
					<div class="inside">
						<label for="post_type_name" class="single_line_label">Post Type Name:<sup>*</sup></label>
						<input name="post_type_name" class="required_name" type="text" value=""  /><br>
						
						<label for="singular_name" class="single_line_label">Singular name:<br><span>(default: Post Type Name)</span></label>
						<input name="singular_name" type="text" value=""/><br>
						
						<label for="menu_name" class="single_line_label">Menu Name:<br><span>(default: Post Type Name)</span></label>
						<input name="menu_name" type="text" value=""/><br>
						
						<label for="add_new" class="single_line_label">Add New:<br><span>(default: Add New)</span></label>
						<input name="add_new" type="text" value=""/><br>
						
						<label for="add_new_item" class="single_line_label">Add New Item:</label>
						<input name="add_new_item" type="text" value=""/><br>
						
						<label for="edit_item" class="single_line_label">Edit Item:</label>
						<input name="edit_item" type="text" value=""/><br>
						
						<label for="new_item" class="single_line_label">New Item:</label>
						<input name="new_item" type="text" value="" /><br>
						
						<label for="view_item" class="single_line_label">View Item:</label>
						<input name="view_item" type="text" value="" /><br>
						
						<label for="search_items" class="single_line_label">Search Items:</label>
						<input name="search_items" type="text" value="" /><br>
						
						<label for="not_found" class="single_line_label">Not Found:</label>
						<input name="not_found" type="text" /><br>
						
						<label for="not_found_in_trash" class="single_line_label">Not Found In Trash:</label>
						<input name="not_found_in_trash" type="text" value=""/><br>
						
						<label for="parent_item_colon" class="single_line_label">Parent Item Colon:</label>
						<input name="parent_item_colon" type="text" value=""/><br>
						
					</div><!-- end 'inside' -->
				</div><!-- end 'col-wrap' -->
			</div><!-- end 'col-left' -->
			<div class="button_wrap">
				<?php submit_button('Add New CPT', 'primary', 'add_new_cpt'); ?>
				<input type="hidden" name="action" value="add_new_cpt"/>
			</div>
		</form>
	</div><!-- end 'col-container' -->					
</div><!-- end 'wrap' -->

<?php } ?>
