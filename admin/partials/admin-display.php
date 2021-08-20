<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/baonguyenyam/wp-best-suggestion-boxes
 * @since      1.0.0
 *
 * @package    Best_Suggestion_Boxes
 * @subpackage Best_Suggestion_Boxes/admin/partials
 */
?>
<div class="wrap">
    <div id="wp-content-editor-tools" class="wp-heading">
        <div class="alignleft">
            <h2><?php echo esc_html__('Screens and Suggestions', BEST_SUGGESTION_BOXES_DOMAIN )?></h2>
        </div>
        <div class="alignright">
            <a href="admin.php?page=best-suggestion-boxes-screen" class="button button-primary"><?php echo esc_html__('Add New Screen', BEST_SUGGESTION_BOXES_DOMAIN );?></a>
            <a href="admin.php?page=best-suggestion-boxes-suggest" class="button button-primary"><?php echo esc_html__('Add New Suggest', BEST_SUGGESTION_BOXES_DOMAIN );?></a>
        </div>
        <div class="clear"></div>
    </div>
<?php

global $table_prefix, $wpdb;
$tblGroup = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest_group';
$tblSuggest = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest';

$resultsGroup = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$tblGroup}"));

foreach ( $resultsGroup as $groupItem ) {
    ?>

    <div class="form-wrap">

    <div class="form-field">
        <div class="alignleft">
            <h2><?php echo esc_attr($groupItem->group_content); ?></h2>
        </div>
        <div class="alignright">
            <a href="admin.php?page=best-suggestion-boxes-screen&id=<?php echo esc_attr($groupItem->group_id)?>&action=edit"><?php echo esc_html__('Edit', BEST_SUGGESTION_BOXES_DOMAIN )?></a>
            <a href="admin.php?page=best-suggestion-boxes-screen&id=<?php echo esc_attr($groupItem->group_id)?>&action=delete"><?php echo esc_html__('Delete', BEST_SUGGESTION_BOXES_DOMAIN )?></a>
        </div>
        <div class="clear"></div>
    </div>

    </div>

    <?php

    $resultsSuggest = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$tblSuggest} INNER JOIN {$tblGroup} ON {$tblGroup}.group_id = {$tblSuggest}.group_id AND {$tblGroup}.group_id = $groupItem->group_id"));

    if($resultsSuggest) {

        echo '<table class="nguyenapp-table">';
        echo '<thead>
        <tr>
        <td>'.esc_html__('Suggestions', BEST_SUGGESTION_BOXES_DOMAIN ).'</td>
        <td width="200">'.esc_html__('Go to', BEST_SUGGESTION_BOXES_DOMAIN ).'</td>
        <td width="20">'.esc_html__('Edit', BEST_SUGGESTION_BOXES_DOMAIN ).'</td>
        <td width="20">'.esc_html__('Delete', BEST_SUGGESTION_BOXES_DOMAIN ).'</td>
        </tr>
        </thead>';
            foreach ( $resultsSuggest as $item ) {
                $screenName = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$tblGroup} WHERE {$tblGroup}.group_id = $item->target_id LIMIT 1"));
            ?>
                <tr><td><?php echo esc_attr($item->suggest_content); ?></td><td><?php echo esc_attr($screenName[0]->group_content) ? esc_attr($screenName[0]->group_content) : 'N/A'; ?></td><td><a href="admin.php?page=best-suggestion-boxes-suggest&id=<?php echo esc_attr($item->suggest_id)?>&action=edit"><?php echo esc_html__('Edit', BEST_SUGGESTION_BOXES_DOMAIN )?></a></td><td><a href="admin.php?page=best-suggestion-boxes-suggest&id=<?php echo esc_attr($item->suggest_id)?>&action=delete"><?php echo esc_html__('Delete', BEST_SUGGESTION_BOXES_DOMAIN )?></a></td></tr>
            <?php
            }
        echo '</table>';
    }
}

?>
</div>