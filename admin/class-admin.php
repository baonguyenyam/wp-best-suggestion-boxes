<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/wp-best-suggestion-boxes
 * @since      1.0.0
 *
 * @package    Best_Suggestion_Boxes
 * @subpackage Best_Suggestion_Boxes/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Best_Suggestion_Boxes
 * @subpackage Best_Suggestion_Boxes/admin
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */

class Best_Suggestion_Boxes_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $liftChat    The ID of this plugin.
	 */
	private $liftChat;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $liftChat       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $liftChat ) {

		$this->liftChat = $liftChat;
		add_action( 'carbon_fields_register_fields', array( $this, '___app_option_attach_theme_options' ));
		add_action( 'after_setup_theme', array( $this, '__settingUP' ));

		add_action('admin_menu', array( $this, '___addPluginAdminMenu' ));   
		add_action( 'admin_post_submit_data', array( $this, '__submitData') );
		add_filter( 'plugin_action_links',  array( $this, '__suggestion_boxesadd_setting_link_chat') , 10, 2 );
	}

	// ADD SETTING LINK 

	public function __suggestion_boxesadd_setting_link_chat( $links, $file ) {
		if( $file === 'wp-best-suggestion-boxes/nguyen-app.php' ){
			$link = '<a href="'.admin_url('admin.php?page=crb_carbon_fields_container_best_suggestion_boxes_settings.php').'">'.esc_html_e('Settings', BEST_SUGGESTION_BOXES_DOMAIN ).'</a>';
			array_unshift( $links, $link ); 
		}
		return $links;
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Best_Suggestion_Boxes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Best_Suggestion_Boxes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->liftChat['domain'], plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->liftChat['version'], 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Best_Suggestion_Boxes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Best_Suggestion_Boxes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->liftChat['domain'], plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->liftChat['version'], false );

	}

	public function __submitData() {
		global $table_prefix, $wpdb;
		$tblGroup = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest_group';
		$tblSuggest = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest';

		$id = stripslashes_deep($_POST['id']);
		$type = stripslashes_deep($_POST['type']);
		$posttype = stripslashes_deep($_POST['posttype']);
		$inputValue = stripslashes_deep($_POST['groupName']);
		$groupTarget = stripslashes_deep($_POST['groupTarget']);
		$idTarget = stripslashes_deep($_POST['idTarget']);

		if($posttype === 'suggest') {
			if(isset($type) && $type != '' && $type != null) {
				if($type === 'edit') {
					$wpdb->update(
						$tblSuggest,
						array(
							'suggest_content'=> $inputValue,
							'group_id' => $groupTarget,
							'target_id' => $idTarget,
						),
						array('suggest_id'=>$id),
					);
				}
				if($type === 'delete') {
					$wpdb->delete(
						$tblSuggest,
						array(
							'suggest_id'=> $id
						),
						array('%d'),
					);
				}
			} else {
				$wpdb->insert(
					$tblSuggest,
					array( 
						'suggest_content' => $inputValue,
						'group_id' => $groupTarget,
						'target_id' => $idTarget,
					),
					array( '%s' ),
				);
			}
		}

		if($posttype === 'screen') {
			if(isset($type) && $type != '' && $type != null) {
				if($type === 'edit') {
					$wpdb->update(
						$tblGroup,
						array(
							'group_content'=> $inputValue
						),
						array('group_id'=>$id),
					);
				}
				if($type === 'delete') {
					$wpdb->delete(
						$tblGroup,
						array(
							'group_id'=> $id
						),
						array('%d'),
					);
				}
			} else {
				$wpdb->insert(
					$tblGroup,
					array( 
						'group_content' => $inputValue
					),
					array( '%s' ),
				);
			}
		}
	
		wp_redirect('admin.php?page=best-suggestion-boxes');
		// wp_redirect($_SERVER["HTTP_REFERER"]);
	}


	public function ___addPluginAdminMenu() {
		//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page(  $this->liftChat['nicename'], esc_html_e('Suggestion', BEST_SUGGESTION_BOXES_DOMAIN ), 'administrator', $this->liftChat['domain'], array( $this, '___displayPluginAdminDashboard' ), 'dashicons-admin-comments', 30 );
		
		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page( null, esc_html_e('Add New Screen', BEST_SUGGESTION_BOXES_DOMAIN ), esc_html_e('Add New Screen', BEST_SUGGESTION_BOXES_DOMAIN ), 'administrator', $this->liftChat['domain'].'-screen', array( $this, '___displayPluginAdminAddNewScreen' ));
		add_submenu_page( null, esc_html_e('Add New Suggest', BEST_SUGGESTION_BOXES_DOMAIN ), esc_html_e('Add New Suggest', BEST_SUGGESTION_BOXES_DOMAIN ), 'administrator', $this->liftChat['domain'].'-suggest', array( $this, '___displayPluginAdminAddNewSuggest' ));

	}
	public function ___displayPluginAdminDashboard() {
		require_once 'partials/admin-display.php';
	}
	public function ___displayPluginAdminAddNewScreen() {
		require_once 'partials/screen.php';
	}
	public function ___displayPluginAdminAddNewSuggest() {
		require_once 'partials/suggest.php';
	}

	public function ___app_option_attach_theme_options() {
		$basic_options_container =  Container::make( 'theme_options', esc_html_e( 'Settings', BEST_SUGGESTION_BOXES_DOMAIN ) )
		->set_page_parent(  $this->liftChat['domain'] )
			// ->set_page_menu_title( 'App Settings' )
			// ->set_page_menu_position(2)
			// ->set_icon( 'dashicons-admin-generic' )
			->add_tab( esc_html_e( 'Settings', BEST_SUGGESTION_BOXES_DOMAIN ), self::__chatApp() )
			->add_tab( esc_html_e( 'Copyright', BEST_SUGGESTION_BOXES_DOMAIN ), self::__copyright() )
			;
	}
	
	public function __settingUP() {
		require_once plugin_dir_path( __DIR__  ) .'vendor/autoload.php';
		\Carbon_Fields\Carbon_Fields::boot();
	}

	public function __chatApp() {
		$data = array();
		$data = array(
			Field::make(
			'checkbox', 
			'___best_suggestion_boxes_enable',
			esc_html_e('Enable', BEST_SUGGESTION_BOXES_DOMAIN)
			)->set_option_value( 'yes' ),
			Field::make( 'text', '__best_suggestion_boxes_title', esc_html_e( 'Title', BEST_SUGGESTION_BOXES_DOMAIN ) )
			->set_default_value(esc_html_e('Chat with us!', BEST_SUGGESTION_BOXES_DOMAIN ))
			->set_classes( 'lift-cabon-width-class' )
			->set_width(100),
			Field::make( 'image', '__best_suggestion_boxes_logo', esc_html_e( 'Logo', BEST_SUGGESTION_BOXES_DOMAIN ) )
			->set_value_type( 'url' )
            ->set_visible_in_rest_api( $visible = true )
			->set_width(100),
			Field::make( 'color', '__best_suggestion_boxes_style', esc_html_e( 'Style color', BEST_SUGGESTION_BOXES_DOMAIN ) )
			->set_alpha_enabled( true )
			->set_width(100),	
			Field::make( 'text', '__best_suggestion_boxes_size', esc_html_e( 'Icon Size', BEST_SUGGESTION_BOXES_DOMAIN ) )
			->set_default_value('16px')
			->set_width(12.5),
			Field::make( 'text', '__best_suggestion_boxes_title_size', esc_html_e( 'Title Size', BEST_SUGGESTION_BOXES_DOMAIN ) )
			->set_default_value('24px')
			->set_width(12.5),
			Field::make( 'text', '__best_suggestion_boxes_content_size', esc_html_e( 'Font Size', BEST_SUGGESTION_BOXES_DOMAIN ) )
			->set_default_value('16px')
			->set_width(12.5),
			Field::make( 'select', '__best_suggestion_boxes_position', esc_html_e( 'Position', BEST_SUGGESTION_BOXES_DOMAIN ) )
			->add_options( array(
				'bottomright' => esc_html_e( 'Bottom Right', BEST_SUGGESTION_BOXES_DOMAIN ),
				'bottomleft' => esc_html_e( 'Bottom Left', BEST_SUGGESTION_BOXES_DOMAIN ),
				'topright' => esc_html_e( 'Top Right', BEST_SUGGESTION_BOXES_DOMAIN ),
				'topleft' => esc_html_e( 'Top Left', BEST_SUGGESTION_BOXES_DOMAIN ),
			) )
			->set_default_value('bottomright')
			->set_width(12.5),
			Field::make( 'text', '__best_suggestion_boxes_padding_x', esc_html_e( 'Padding X', BEST_SUGGESTION_BOXES_DOMAIN ) )
			->set_default_value('2em')
			->set_width(12.5),
			Field::make( 'text', '__best_suggestion_boxes_padding_y', esc_html_e( 'Padding Y', BEST_SUGGESTION_BOXES_DOMAIN ) )
			->set_default_value('2em')
			->set_width(12.5),
		);
		return $data;
	}

	public function __copyright() {
		$data = array();
		$data = array(
	
			Field::make( 'html', 'crb_html_2', esc_html_e( 'Section Description', BEST_SUGGESTION_BOXES_DOMAIN ) )
					->set_html('
					
					<h1>'.esc_html_e('Best Suggestion Boxes', BEST_SUGGESTION_BOXES_DOMAIN ).'</h1>
					<p>'.esc_html_e('A Better Way to Connect With Customers. You don\'t have time to talk with some online customers? This plugin will help you connect with them.', BEST_SUGGESTION_BOXES_DOMAIN ).'</p>
					
					'),
					Field::make( 'separator', 'crb_separator_1', esc_html_e( 'Copyright', BEST_SUGGESTION_BOXES_DOMAIN ) ),

			Field::make( 'html', 'crb_html_1', esc_html_e( 'Section Description', BEST_SUGGESTION_BOXES_DOMAIN ) )
					->set_html('
					
					<p style="margin-top:0;margin-bottom:0"><strong>'.esc_html_e( 'Author', BEST_SUGGESTION_BOXES_DOMAIN ).':</strong> <a href="https://baonguyenyam.github.io/" target="_blank">Nguyen Pham</a></p>
					
					'),
	
		);
		return $data;
	}
	

}


