<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>
	
<div class="ez_cpt_creator wrap">
	<h1><?php esc_attr_e( 'Update Custom Post Type', 'wp_admin_style' ); ?></h1>
	<div class="name_error form-invalid"><?php esc_attr_e( 'You must enter a Name', 'wp_admin_style' ); ?></div>
	<div id="col-container">
		<form method="post" name="new_cpt_form" id="update_cpt_form" action="<?php echo get_admin_url(); ?>admin-post.php" >
			<div id="col-right">
				<div class="col-wrap">
					<h2><?php esc_attr_e( 'Options', 'wp_admin_style' ); ?></h2><br>
					<div class="inside">
					
					<?php			
						$current_cpt = unserialize(get_option(CPT_CREATOR_OPTION_GROUP));
					
						foreach($current_cpt as $cpt_object) :
						
							if ($cpt_object->unique_id == $_GET['id']) :
					?>
								<label class="icon_label" for="select_icon">Admin Menu Icon:</label>
								<div class="input_wrap menu_icon">
									<input class="icon_text" type="text" size="36" name="select_icon" value="<?php echo $cpt_object->menu_icon ?>" />
									<input name="select_icon" class="button select_icon_button" type="button" value="Select Icon" /> or 
									<input name="upload_icon" class="button upload_icon_button" type="button" value="Upload Icon" /><br>
									<span>(Note: If uploading icon, size must not be larger than 16px x 16px)</span>
								</div><br>
								
								<div class="dashicon_picker_container">
									<ul class="dashicon_picker_list" /></ul>
								</div>
	
								<label for="description" class="single_line_label">Description:</label>
			                    <textarea name="description" value="<?php echo $cpt_object->description; ?>"><?php echo $cpt_object->description; ?></textarea><br>
	
			                    <label for="supports[]" class="single_line_label">Supports:</label>
								<div class="input_wrap">
			                    
			                    	<?php if(!empty($cpt_object->supports)) : ?>
			                    		<?php $array = $cpt_object->supports; ?>
			                    		<ul>
					                    	<li><input name="supports[]" type="checkbox" value="title" <?php if(in_array("title", $array) ) { echo 'checked'; } ?> />title</li>
											<li><input name="supports[]" type="checkbox" value="editor" <?php if(in_array("editor", $array) ) { echo 'checked'; } ?> />editor</li>
											<li><input name="supports[]" type="checkbox" value="author" <?php if(in_array("author", $array) ) { echo 'checked'; } ?> />author</li>
											<li><input name="supports[]" type="checkbox" value="thumbnail" <?php if(in_array("thumbnail", $array) ) { echo 'checked'; } ?> />thumbnail</li>
											<li><input name="supports[]" type="checkbox" value="excerpt" <?php if(in_array("excerpt", $array) ) { echo 'checked'; } ?> />excerpt
											<li><input name="supports[]" type="checkbox" value="trackbacks" <?php if(in_array("trackbacks", $array) ) { echo 'checked'; } ?> />trackbacks</li>
										</ul>
										<ul>
											<li><input name="supports[]" type="checkbox" value="customFields" <?php if(in_array("customFields", $array) ) { echo 'checked'; } ?> />custom fields</li>
											<li><input name="supports[]" type="checkbox" value="comments" <?php if(in_array("comments", $array) ) { echo 'checked'; } ?> />comments</li>
											<li><input name="supports[]" type="checkbox" value="revisions" <?php if(in_array("revisions", $array) ) { echo 'checked'; } ?> />revisions</li>
											<li><input name="supports[]" type="checkbox" value="pageAttributes" <?php if(in_array("pageAttributes", $array) ) { echo 'checked'; } ?> />page attributes</li>
											<li><input name="supports[]" type="checkbox" value="postFormats" <?php if(in_array("postFormats", $array) ) { echo 'checked'; } ?> />post formats</li>
										</ul>
									<?php else : ?>
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
									<?php endif; ?>
								</div><br>

			                    <label for="taxonomies" class="single_line_label">Taxonomies:</label>
			                    <input name="taxonomies" type="text" value="<?php if($cpt_object->taxonomies) { echo $cpt_object->taxonomies; } ?>"/><br>
			                    
			                    <div class="column">
				                    <label for="menu_position" class="single_line_label">Menu Position:</label>
									<select name="menu_position">
										<option value="5" <?php if($cpt_object->menu_position == 5) { echo 'selected';} ?>>5 - below Posts</option>
										<option value="10" <?php if($cpt_object->menu_position == 10) { echo 'selected';} ?>>10 - below Media</option>
										<option value="15" <?php if($cpt_object->menu_position == 15) { echo 'selected';} ?>>15 - below Links</option>
										<option value="20" <?php if($cpt_object->menu_position == 20) { echo 'selected';} ?>>20 - below Pages</option>
										<option value="25" <?php if($cpt_object->menu_position == 25) { echo 'selected';} ?>>25 - below comments</option>
										<option value="60" <?php if($cpt_object->menu_position == 60) { echo 'selected';} ?>>60 - below first separator</option>
										<option value="65" <?php if($cpt_object->menu_position == 65) { echo 'selected';} ?>>65 - below Plugins</option>
										<option value="70" <?php if($cpt_object->menu_position == 70) { echo 'selected';} ?>>70 - below Users</option>
										<option value="75" <?php if($cpt_object->menu_position == 75) { echo 'selected';} ?>>75 - below Tools</option>
										<option value="80" <?php if($cpt_object->menu_position == 80) { echo 'selected';} ?>>80 - below Settings</option>
										<option value="100" <?php if($cpt_object->menu_position == 100) { echo 'selected';} ?>>100 - below second separator</option>
									</select><br>
				                    
				                    <label for="hierarchical" class="single_line_label">Hierarchical:</label>
									<select name="hierarchical">
				                      <option value="1" <?php if($cpt_object->hierarchical == true) { echo 'selected'; } ?>>True</option> 
				                      <option value="0" <?php if($cpt_object->hierarchical == false) { echo 'selected'; } ?>>False</option>
				                    </select><br>
				                    
				                    <label for="public" class="single_line_label">Public:</label>
				                    <select name="public">
				                      <option value="1" <?php if($cpt_object->public_option == true) { echo 'selected'; } ?>>True</option>
				                      <option value="0" <?php if($cpt_object->public_option == false) { echo 'selected'; } ?>>False</option>
				                    </select><br>
				                    
				                    <label for="show_ui" class="single_line_label">Show UI:</label>
				                    <select name="show_ui">
				                      <option value="1" <?php if($cpt_object->show_ui == true) { echo 'selected';} ?>>True</option>
				                      <option value="0" <?php if($cpt_object->show_ui == false) { echo 'selected';} ?>>False</option>
				                    </select><br>
				                    
				                    <label for="show_in_menu" class="single_line_label">Show In Menu:</label>
				                    <select name="show_in_menu">
				                      <option value="1" <?php if($cpt_object->show_in_menu == true) { echo 'selected';} ?>>True</option>
				                      <option value="0" <?php if($cpt_object->show_in_menu == false) { echo 'selected';} ?>>False</option>
				                    </select><br>
				                    
				                    <label for="show_in_nav_menus" class="single_line_label">Show In Nav Menus:</label>
				                    <select name="show_in_nav_menus">
				                      <option value="1" <?php if($cpt_object->show_in_nav_menus == true) { echo 'selected';} ?>>True</option>
				                      <option value="0" <?php if($cpt_object->show_in_nav_menus == false) { echo 'selected';} ?>>False</option>
				                    </select><br>
			                    </div>
			                    
			                    <div class="column">
				                    <label for="publicly_queryable" class="single_line_label">Publicly Queryable:</label>
				                    <select name="publicly_queryable">
				                      <option value="1" <?php if($cpt_object->publicly_queryable == true) { echo 'selected';} ?>>True</option>
				                      <option value="0" <?php if($cpt_object->publicly_queryable == false) { echo 'selected';} ?>>False</option>
				                    </select><br>
				                    
				                    <label for="exclude_from_search" class="single_line_label">Exclude From Search:</label>
				                    <select name="exclude_from_search">
				                      <option value="1" <?php if($cpt_object->exclude_from_search == true) { echo 'selected';} ?>>True</option>
				                      <option value="0" <?php if($cpt_object->exclude_from_search == false) { echo 'selected';} ?>>False</option>
				                    </select><br>
				                    
				                    <label for="has_archive" class="single_line_label">Has Archive:</label>
				                    <select name="has_archive">
				                      <option value="1" <?php if($cpt_object->has_archive == true) { echo 'selected';} ?>>True</option>
				                      <option value="0" <?php if($cpt_object->has_archive == false) { echo 'selected';} ?>>False</option>
				                    </select><br>
				                    
				                    <label for="query_var" class="single_line_label">Query Var:</label>
				                    <select name="query_var">
				                      <option value="1" <?php if($cpt_object->query_var == true) { echo 'selected';} ?>>True</option>
				                      <option value="0" <?php if($cpt_object->query_var == false) { echo 'selected';} ?>>False</option>
				                    </select><br>
				                    
				                    <label for="can_export" class="single_line_label">Can Export:</label>
				                    <select name="can_export">
				                      <option value="1" <?php if($cpt_object->can_export == true) { echo 'selected';} ?>>True</option>
				                      <option value="0" <?php if($cpt_object->can_export == false) { echo 'selected';} ?>>False</option>
				                    </select><br>
				                    
				                    <label for="capability_type" class="single_line_label">Capability Type:</label>
				                    <select name="capability_type">
				                      <option value="page" <?php if($cpt_object->capability_type == "page") { echo 'selected';} ?>>Page</option>
				                      <option value="post" <?php if($cpt_object->capability_type == "post") { echo 'selected';} ?>>Post</option>
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
			                    <input name="post_type_name" class="required_name" type="text" value="<?php echo $cpt_object->post_type_name; ?>"  /><br>
			                    
			                    <label for="singular_name" class="single_line_label">Singular name:</label>
			                    <input name="singular_name" type="text" value="<?php echo $cpt_object->singular_name; ?>"/><br>
			                    
			                    <label for="menu_name" class="single_line_label">Menu Name:</label>
			                    <input name="menu_name" type="text" value="<?php echo $cpt_object->menu_name; ?>"/><br>
			                    
			                    <label for="add_new" class="single_line_label">Add New:</label>
			                    <input name="add_new" type="text" value="<?php echo $cpt_object->add_new; ?>"/><br>
			                    
			                    <label for="add_new_item" class="single_line_label">Add New Item:</label>
			                    <input name="add_new_item" type="text" value="<?php echo $cpt_object->add_new_item; ?>"/><br>
			                    
			                    <label for="edit_item" class="single_line_label">Edit Item:</label>
			                    <input name="edit_item" type="text" value="<?php echo $cpt_object->edit_item;?>"/><br>
			                    
			                    <label for="new_item" class="single_line_label">New Item:</label>
			                    <input name="new_item" type="text" value="<?php echo $cpt_object->new_item;?>" /><br>
			                    
			                    <label for="view_item" class="single_line_label">View Item:</label>
			                    <input name="view_item" type="text" value="<?php echo $cpt_object->view_item;?>" /><br>
			                    
			                    <label for="search_items" class="single_line_label">Search Items:</label>
			                    <input name="search_items" type="text" value="<?php echo $cpt_object->search_items;?>" /><br>
			                    
			                    <label for="not_found" class="single_line_label">Not Found:</label>
			                    <input name="not_found" type="text" value="<?php echo $cpt_object->not_found;?>" /><br>
			                    
			                    <label for="not_found_in_trash" class="single_line_label">Not Found In Trash:</label>
			                    <input name="not_found_in_trash" type="text" value="<?php echo $cpt_object->not_found_in_trash;?>"/><br>
			                    
			                    <label for="parent_item_colon" class="single_line_label">Parent Item Colon:</label>
			                    <input name="parent_item_colon" type="text" value="<?php echo $cpt_object->parent_item_colon;?>"/><br>

		                    <?php endif; ?>
						<?php endforeach; ?>
					
						</div><!-- end 'inside' -->
					</div><!-- end 'col-wrap' -->
				</div><!-- end 'col-left' -->
			<div class="button_wrap">
				<?php submit_button('Update', 'primary', 'update_cpt'); ?>
				<input type="hidden" name="action" value="update_cpt"/>
			</div>
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
		</form>
	</div><!-- end 'col-container' -->					
</div><!-- end 'wrap' -->
