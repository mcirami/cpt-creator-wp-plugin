<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>
<div class="display_ez_cpt_page">
	<h1>
		<?php esc_attr_e( 'Custom Post Types', 'wp_admin_style' ); ?>
		<a class="button-primary add_new_button" href="<?php echo admin_url('admin.php?page=add-new-custom-post-type'); ?>">Add New</a>
	</h1>
	
	<?php if (isset( $_GET['msg'] )) : ?>
		<?php if ($_GET['msg'] == 'del_cpt') : ?>
			<div class="message updated">
				<p>Post Type Has Been Deleted</p>
			</div>
		<?php elseif ($_GET['msg'] == 'update_cpt') :  ?>
			<div class="message updated">
				<p>Post Type Has Been Updated</p>
			</div>
		<?php elseif ($_GET['msg'] == 'add_new') :  ?>
			<div class="message updated">
				<p>Post Type Has Been Added</p>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	
	<h2>Generated by EZ Custom Post Type Creator:</h2>
	
	<table class="widefat">
		<thead>
			<tr>
				<th class="row-title"><?php esc_attr_e( 'Post Type', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
			</tr>
		</thead>
		<tbody>
		
			<?php 
				$current_cpt = unserialize(get_option(CPT_CREATOR_OPTION_GROUP));
				$count = 0;
				if ($current_cpt) {
					foreach($current_cpt as $cpt) :
					
					$del_url = admin_url( 'admin.php?page=ez-custom-post-type-creator/ez-custom-post-types.php' ) . '&action=del_cpt&key=' . $cpt->unique_id;
				?>
						<tr class="<?php if ($count % 2 == 0) { echo 'alternate'; } ?>">
							<td class="row-title">
								<label for="tablecell">
									<?php esc_attr_e($cpt->post_type_name, 'wp_admin_style'); ?>
									<input type="hidden" name="edit_cpt" value="<?php $cpt->unique_id; ?>"/>
								</label><br>
								<div class="edit_wrap">
									<a href="<?php echo admin_url('admin.php?page=add-new-custom-post-type&id='. $cpt->unique_id); ?>">Edit</a><div class="line_break">|</div>
									<a href="<?php echo $del_url; ?>" title="<?php _e('Move this item to the Trash'); ?>"><?php _e('Delete', 'EZ_CPT_Creator'); ?></a>
								</div>
							</td>
							<td class="row-title">
								<?php esc_attr_e( $cpt->menu_name, 'wp_admin_style' ); ?>
							</td>
						</tr>
					<?php $count++; ?>
					<?php endforeach; ?>
				<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th class="row-title"><?php esc_attr_e( 'Post Type', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
			</tr>
		</tfoot>
	</table>
	<h2>Post Types Built Into WordPress:</h2>
	<table class="widefat">
		<thead>
			<tr>
				<th class="row-title"><?php esc_attr_e( 'Post Type', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
			</tr>
		</thead>
		<tbody>

			<?php 
				$builtin_cpts = get_post_types( array(
					'_builtin' => true,
					), 'object'
				);
				$count = 0;
				if ($builtin_cpts) {
					foreach($builtin_cpts as $builtin) :
				?>
						<tr class="<?php if ($count % 2 == 0) { echo 'alternate'; } ?>">
							<td class="row-title">
								<label for="tablecell">
									<?php esc_attr_e($builtin->name, 'wp_admin_style'); ?>

								</label><br>
							</td>
							<td class="row-title">
								<?php esc_attr_e( $builtin->label, 'wp_admin_style' ); ?>
							</td>
						</tr>
					<?php $count++; ?>
					<?php endforeach; ?>
				<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th class="row-title"><?php esc_attr_e( 'Post Type', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
			</tr>
		</tfoot>
	</table>
</div>
