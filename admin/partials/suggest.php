<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://baonguyenyam.github.io/cv
 * @since      1.0.0
 *
 * @package    Best_Suggestion_Boxes
 * @subpackage Best_Suggestion_Boxes/admin/partials
 */

global $table_prefix, $wpdb;
$tblGroup = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest_group';
$tblSuggest = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest';

$resultsGroup = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$tblGroup}"));

if(isset($_GET['action']) && ($_GET['action'] === 'edit' || $_GET['action'] === 'delete')) {
	(!isset($_GET['id']) || $_GET['id'] == '' || $_GET['id'] == null) ? wp_redirect('./') : null;
	$resultsSuggest = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$tblSuggest} WHERE suggest_id = {$_GET['id']} LIMIT 1"))[0];
}

?>
<div class="wrap">
	<h1>Message</h1>

	<div class="form-wrap">
		<form action="<?php echo esc_attr( admin_url('admin-post.php') ); ?>" id="frm" method="post">
			<input type="hidden" name="action" value="submit_data" />
			<input type="hidden" name="type" value="<?=isset($_GET['action'])?$_GET['action']:''?>" />
			<input type="hidden" name="posttype" value="suggest" />
			<input type="hidden" name="id" value="<?=isset($resultsSuggest->suggest_id)?$resultsSuggest->suggest_id:''?>" />

			<?php if(isset($_GET['action']) && $_GET['action'] === 'delete') { ?>
				<div class="form-required term-name-wrap">
					<label for="groupName"><?=isset($resultsSuggest->suggest_content)?$resultsSuggest->suggest_content:''?></label>
				</div>
			<?php } else { ?>
				<div class="form-required term-name-wrap">
					<label for="groupTarget">Screen</label>
					<select name="groupTarget" id="groupTarget">
						<?php foreach ( $resultsGroup as $item ) { ?>
							<option value="<?=$item->group_id?>"<?php echo ($resultsSuggest->group_id === $item->group_id) ? ' selected' : ''?>><?=$item->group_content?></option>
						<?php } ?>
					</select>
					<p></p>
				</div>
				<div class="form-required term-name-wrap">
					<label for="idTarget">Click go to screen</label>
					<select name="idTarget" id="idTarget">
						<option value="0">None</option>
						<?php foreach ( $resultsGroup as $item ) { ?>
							<option value="<?=$item->group_id?>"<?php echo ($resultsSuggest->target_id === $item->group_id) ? ' selected' : ''?>><?=$item->group_content?></option>
						<?php } ?>
					</select>
					<p></p>
				</div>
				<div class="form-required term-name-wrap">
					<label for="groupName">Message</label>
					<?php
						$content   = isset($resultsSuggest->suggest_content)?$resultsSuggest->suggest_content:'';
						$editor_id = 'groupName';
						wp_editor( $content, $editor_id );
					?>
				</div>
			<?php } ?>

			<p class="submit"><button type="submit" class="button button-primary"><?=$_GET['action'] === 'delete' ? 'Delete' : 'Submit'?></button></p>


			<input type="hidden" name="submitted" id="submitted" value="true" />
		</form>
	</div>
</div>
