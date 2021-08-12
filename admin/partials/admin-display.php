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
?>
<div class="wrap">
    <div id="wp-content-editor-tools" class="wp-heading">
        <div class="alignleft">
            <h2><?=BEST_SUGGESTION_BOXES_NICENAME?></h2>
        </div>
        <div class="alignright">
            <a href="admin.php?page=best-suggestion-boxes-screen" class="button button-primary">Add New Screen</a>
            <a href="admin.php?page=best-suggestion-boxes-suggest" class="button button-primary">Add New Suggest</a>
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
            <h2><?php echo $groupItem->group_content; ?></h2>
        </div>
        <div class="alignright">
            <a href="admin.php?page=best-suggestion-boxes-screen&id=<?php echo $groupItem->group_id?>&action=edit">Edit</a>
            <a href="admin.php?page=best-suggestion-boxes-screen&id=<?php echo $groupItem->group_id?>&action=delete">Delete</a>
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
        <td>Suggest</td>
        <td width="200">Go to</td>
        <td width="20">Edit</td>
        <td width="20">Delete</td>
        </tr>
        </thead>';
            foreach ( $resultsSuggest as $item ) {
                $screenName = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$tblGroup} WHERE {$tblGroup}.group_id = $item->target_id LIMIT 1"));
            ?>
                <tr><td><?php echo $item->suggest_content; ?></td><td><?php echo $screenName[0]->group_content ? $screenName[0]->group_content : 'N/A'; ?></td><td><a href="admin.php?page=best-suggestion-boxes-suggest&id=<?php echo $item->suggest_id?>&action=edit">Edit</a></td><td><a href="admin.php?page=best-suggestion-boxes-suggest&id=<?php echo $item->suggest_id?>&action=delete">Delete</a></td></tr>
            <?php
            }
        echo '</table>';
    }
}

?>
</div>