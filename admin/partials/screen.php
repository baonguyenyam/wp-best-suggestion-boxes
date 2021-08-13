<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/wp-best-suggestion-boxes
 * @since      1.0.0
 *
 * @package    Best_Suggestion_Boxes
 * @subpackage Best_Suggestion_Boxes/admin/partials
 */

global $table_prefix, $wpdb;
$tblGroup = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest_group';
$tblSuggest = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest';


if(isset($_GET['action']) && ($_GET['action'] === 'edit' || $_GET['action'] === 'delete')) {
	(!isset($_GET['id']) || $_GET['id'] == '' || $_GET['id'] == null) ? wp_redirect('./') : null;
	$resultsGroup = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$tblGroup} WHERE group_id = {$_GET['id']} LIMIT 1"))[0];
}

?>
<div class="wrap">
	<h1><?=esc_html__('Screen\'s name', BEST_SUGGESTION_BOXES_DOMAIN )?></h1>

	<div class="form-wrap">
		<form action="<?php echo esc_attr( admin_url('admin-post.php') ); ?>" id="frm" method="post">
			<input type="hidden" name="action" value="submit_data" />
			<input type="hidden" name="type" value="<?=isset($_GET['action'])?$_GET['action']:''?>" />
			<input type="hidden" name="posttype" value="screen" />
			<input type="hidden" name="id" value="<?=isset($resultsGroup->group_id)?$resultsGroup->group_id:''?>" />

			<?php if(isset($_GET['action']) && $_GET['action'] === 'delete') { ?>
				<div class="form-required term-name-wrap">
					<label for="groupName"><?=isset($resultsGroup->group_content)?$resultsGroup->group_content:''?></label>
				</div>
			<?php } else { ?>
				<div class="form-required term-name-wrap">
					<label for="groupName"><?=esc_html__('Name', BEST_SUGGESTION_BOXES_DOMAIN )?></label>
					<input name="groupName" id="groupName" type="text" value="<?=isset($resultsGroup->group_content)?$resultsGroup->group_content:''?>" size="40" aria-required="true">
				</div>
			<?php } ?>

			<p class="submit"><button type="submit" class="button button-primary"><?=$_GET['action'] === 'delete' ? esc_html__('Delete', BEST_SUGGESTION_BOXES_DOMAIN ) : esc_html__('Submit', BEST_SUGGESTION_BOXES_DOMAIN )?></button></p>


			<input type="hidden" name="submitted" id="submitted" value="true" />
		</form>
	</div>
</div>