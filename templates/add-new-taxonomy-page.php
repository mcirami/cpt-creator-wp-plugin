<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>

<?php 
	if(isset($_GET['id'])) {
		$postID = $_GET['id'];
		require (plugin_dir_path(__FILE__ ) . 'edit-tax-page.php');
	} else {
?>


<div class="ez_cpt_creator wrap">
	<h1><?php esc_attr_e( 'Add A Taxonomy', 'wp_admin_style' ); ?></h1>
	
	<div class="name_error form-invalid"><?php esc_attr_e( 'You must enter a Name', 'wp_admin_style' ); ?></div>
	<div class="checkbox_error form-invalid"><?php esc_attr_e( 'You must select a Post Type', 'wp_admin_style' ); ?></div>
	
	<div id="col-container">
		<form method="post" name="new_tax_form" id="new_tax_form" action="<?php echo get_admin_url(); ?>admin-post.php" >
			<div id="col-right">
				<div class="col-wrap">
					<h2><?php esc_attr_e( 'Options', 'wp_admin_style' ); ?></h2><br>
					<div class="inside">
						
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
						
						<label for="show_in_nav_menus" class="single_line_label">Show In Nav Menus:</label>
						<select name="show_in_nav_menus">
							<option value="1" selected="selected">True</option>
							<option value="0">False</option>
						</select><br>
						
						<label for="show_tagcloud" class="single_line_label">Show TagCloud:</label>
						<select name="show_tagcloud">
							<option value="1" selected="selected">True</option>
							<option value="0">False</option>
						</select><br>
						
						<label for="quick_edit" class="single_line_label">Show In Quick Edit:</label>
						<select name="quick_edit">
							<option value="1">True</option>
							<option value="0" selected="selected">False</option>
						</select><br>
						
						<label for="meta_box" class="single_line_label">Meta Box Call Back:</label>
						<input name="meta_box" type="text" value=""/><br>
						
						<label for="query_var" class="single_line_label">Query Var:</label>
						<select name="query_var">
							<option value="1" selected="selected">True</option>
							<option value="0">False</option>
						</select><br>
						
						<label for="admin_column" class="single_line_label">Show Admin Column:</label>
						<select name="admin_column">
							<option value="1" selected="selected">True</option>
							<option value="0">False</option>
						</select><br>
						
						<label for="count_callback" class="single_line_label">Update Count Callback:</label>
						<input name="count_callback" type="text" value=""/><br>
						
						<label for="rewrite" class="single_line_label">Rewrite:</label>
						<input name="rewrite" type="text" value=""/><br>
						
						<label for="capabilities" class="single_line_label">Capabilities:</label>
						<input name="capabilities" type="text" value=""/><br>
						
						<label for="sort" class="single_line_label">Sort:</label>
						<select name="sort">
							<option value="1" selected="selected">True</option>
							<option value="0">False</option>
						</select><br>
						
						<label for="builtin" class="single_line_label">Builtin:</label>
						<select name="builtin">
							<option value="1">True</option>
							<option value="0" selected="selected">False</option>
						</select><br>

					</div><!-- end 'inside' -->
				</div><!-- end 'col-wrap' -->
			</div><!-- end 'col-right' -->
			<div id="col-left">
				<div class="col-wrap">
					<h2><?php esc_attr_e( 'Labels', 'wp_admin_style' ); ?></h2><br>
					<div class="inside">
						<?php $cpt_objects = unserialize(get_option(CPT_CREATOR_OPTION_GROUP)); ?>

						<label for="post_types[]" class="single_line_label">Attach Post Type(s):<sup>*</sup></label>
						<div class="input_wrap taxonomy">	
							<?php if ($cpt_objects) : ?>
								<ul>
								<?php foreach($cpt_objects as $cpt_object) : ?>
									<li><input name="post_types[]" type="checkbox" value="<?php echo strtolower($cpt_object->post_type_name); ?>" /><?php echo $cpt_object->post_type_name; ?></li>
								<?php endforeach; ?>
								</ul>
							<?php else : ?>
								<p>There are no Post Types</p>
							<?php endif; ?>
						</div><br>

						<label for="tax_name" class="single_line_label">Taxonomy Name:<sup>*</sup></label>
						<input name="tax_name" type="text" class="required_name" value=""  /><br>
						
						<label for="singular_name" class="single_line_label">Singular name:<br><span>(default: Taxonomy Name)</span></label>
						<input name="singular_name" type="text" value=""/><br>
						
						<label for="menu_name" class="single_line_label">Menu Name:<br><span>(default: Taxonomy Name)</span></label>
						<input name="menu_name" type="text" value=""/><br>
						
						<label for="all_items" class="single_line_label">All Items:</label>
						<input name="all_items" type="text" value=""/><br>
						
						<label for="edit_item" class="single_line_label">Edit Item:</label>
						<input name="edit_item" type="text" value=""/><br>
						
						<label for="view_item" class="single_line_label">View Item:</label>
						<input name="view_item" type="text" value="" /><br>
						
						<label for="update_item" class="single_line_label">Update Item:</label>
						<input name="update_item" type="text" value="" /><br>
						
						<label for="add_new_item" class="single_line_label">Add New Item:</label>
						<input name="add_new_item" type="text" value=""/><br>
						
						<label for="new_item_name" class="single_line_label">New Item Name:</label>
						<input name="new_item_name" type="text" value="" /><br>
						
						<label for="parent_item" class="single_line_label">Parent Item:</label>
						<input name="parent_item" type="text" value=""/><br>
						
						<label for="parent_item_colon" class="single_line_label">Parent Item Colon:</label>
						<input name="parent_item_colon" type="text" value=""/><br>
						
						<label for="search_items" class="single_line_label">Search Items:</label>
						<input name="search_items" type="text" value="" /><br>
						
						<label for="popular_items" class="single_line_label">Popular Items:</label>
						<input name="popular_items" type="text" value="" /><br>
						
						<label for="separate_items_with_commas" class="single_line_label">Separate Items With Commas:</label>
						<input name="separate_items_with_commas" type="text" value=""/><br>
						
						<label for="add_or_remove_items" class="single_line_label">Add or Remove Items:</label>
						<input name="add_or_remove_items" type="text" value=""/><br>
						
						<label for="choose_from_most_used" class="single_line_label">Choose From Most Used:</label>
						<input name="choose_from_most_used" type="text" value=""/><br>
						
						<label for="not_found" class="single_line_label">Not Found:</label>
						<input name="not_found" type="text" /><br>

					</div><!-- end 'inside' -->
				</div><!-- end 'col-wrap' -->
			</div><!-- end 'col-left' -->
			<div class="button_wrap">
				<?php submit_button('Add New Taxonomy', 'primary', 'add_new_tax'); ?>
				<input type="hidden" name="action" value="add_new_tax"/>
			</div>
		</form>
	</div><!-- end 'col-container' -->					
</div><!-- end 'wrap' -->

<?php } ?>
