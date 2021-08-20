<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/baonguyenyam/wp-best-suggestion-boxes
 * @since      1.0.0
 *
 * @package    Best_Suggestion_Boxes
 * @subpackage Best_Suggestion_Boxes/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Best_Suggestion_Boxes
 * @subpackage Best_Suggestion_Boxes/includes
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */
class Best_Suggestion_Boxes_Activator {

	public static function activate() {
		self::iniDB_Create();
	}

	private function iniDB_Create() {
		
		// WP Globals
		global $table_prefix, $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$tblGroup = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest_group';
		$tblSuggest = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest';
		if( $wpdb->get_var( "show tables like '$tblGroup'" ) != $tblGroup ) {

			// Query - Create Table

			$sql = "CREATE TABLE $tblGroup (
				group_id int(11) NOT NULL AUTO_INCREMENT,
				group_content text NOT NULL,
				PRIMARY KEY (group_id)
			) $charset_collate;";

			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			self::iniDB_InsertGroup($tblGroup);

		}	
		if( $wpdb->get_var( "show tables like '$tblSuggest'" ) != $tblSuggest ) {

			// Query - Create Table

			$sql = "CREATE TABLE $tblSuggest (
				suggest_id int(11) NOT NULL AUTO_INCREMENT,
				suggest_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				suggest_content text NOT NULL,
				group_id int(11) NOT NULL,
				target_id int(11) NOT NULL,
				PRIMARY KEY (suggest_id)
			) $charset_collate;";

			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			self::iniDB_InsertSuggest($tblSuggest);

		}	

	}

	private function iniDB_InsertGroup($tblGroup) {
		global $wpdb;
		$wpdb->insert( 
			$tblGroup, 
			array( 
				'group_id' => 1, 
				'group_content' => 'Screen 1', 
			) 
		);
		$wpdb->insert( 
			$tblGroup, 
			array( 
				'group_id' => 2, 
				'group_content' => 'Screen 2', 
			) 
		);
	}
	private function iniDB_InsertSuggest($tblSuggest) {
		global $wpdb;
		$wpdb->insert( 
			$tblSuggest, 
			array( 
				'suggest_id' => 1, 
				'suggest_time' => current_time( 'mysql' ), 
				'suggest_content' => 'Hello', 
				'group_id' => 1,
				'target_id' => 2
			),
		);
		$wpdb->insert( 
			$tblSuggest, 
			array( 
				'suggest_id' => 2, 
				'suggest_time' => current_time( 'mysql' ), 
				'suggest_content' => 'Hello 2', 
				'group_id' => 1,
				'target_id' => 2
			),
		);
		$wpdb->insert( 
			$tblSuggest, 
			array( 
				'suggest_id' => 3, 
				'suggest_time' => current_time( 'mysql' ), 
				'suggest_content' => 'Hello 3', 
				'group_id' => 2,
				'target_id' => 0
			),
		);
		$wpdb->insert( 
			$tblSuggest, 
			array( 
				'suggest_id' => 4, 
				'suggest_time' => current_time( 'mysql' ), 
				'suggest_content' => 'Hello 4', 
				'group_id' => 2,
				'target_id' => 0
			),
		);
	}

}
