<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/baonguyenyam/wp-best-suggestion-boxes
 * @since      1.0.0
 *
 * @package    Best_Suggestion_Boxes
 * @subpackage Best_Suggestion_Boxes/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Best_Suggestion_Boxes
 * @subpackage Best_Suggestion_Boxes/public
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */

class Best_Suggestion_Boxes_Public {

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
	 * @param      string    $liftChat       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $liftChat ) {

		$this->liftChat = $liftChat;

		add_action('rest_api_init', function () {
			register_rest_route( 'best-suggestion-boxes/v1', '/all/', array(
			'methods' => 'GET',
			'callback' => array( $this, '__getSuggest' )
			) );
		});

		add_action( 'carbon_fields_fields_registered', array( $this, '__best_suggestion_boxes_init' ) );
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->liftChat['domain'], plugin_dir_url( __FILE__ ) . 'css/main.css', array(), $this->liftChat['version'], 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		if(carbon_get_theme_option('___best_suggestion_boxes_enable')) {
			// wp_enqueue_script( $this->liftChat['domain'].'-no-jquery', plugin_dir_url( __FILE__ ) . 'js/public-without-jquery.js', array( 'jquery' ), $this->liftChat['version'], false );
			wp_enqueue_script( $this->liftChat['domain'], plugin_dir_url( __FILE__ ) . 'js/main.js', array( 'jquery' ), $this->liftChat['version'], false );
		}

	}

	public function __best_suggestion_boxes_init() {
		if(carbon_get_theme_option('___best_suggestion_boxes_enable')) {
			if(carbon_get_theme_option('__best_suggestion_boxes_title')) {
				add_action('wp_footer', array( $this, '__bestSuggestionBoxesChangeTitle' ), 99999);
			}
			if(carbon_get_theme_option('__best_suggestion_boxes_logo')) {
				add_action('wp_head', array( $this, '__bestSuggestionBoxesChangeLogo' ), 99999);
			}
			if(carbon_get_theme_option('__best_suggestion_boxes_style')) {
				add_action('wp_head', array( $this, '__bestSuggestionBoxesChangeStyle' ), 99999);
			}
			if(carbon_get_theme_option('__best_suggestion_boxes_size')) {
				add_action('wp_head', array( $this, '__bestSuggestionBoxesChangeSize' ), 99999);
			}
			if(carbon_get_theme_option('__best_suggestion_boxes_title_size')) {
				add_action('wp_head', array( $this, '__bestSuggestionBoxesChangeTitleSize' ), 99999);
			}
			if(carbon_get_theme_option('__best_suggestion_boxes_content_size')) {
				add_action('wp_head', array( $this, '__bestSuggestionBoxesChangeContentSize' ), 99999);
			}

			if(carbon_get_theme_option('__best_suggestion_boxes_position')) {
				add_action('wp_head', array( $this, '__bestSuggestionBoxesChangePosition' ), 99999);
			}
		}
	}

	public function __bestSuggestionBoxesChangePosition() {
		if(carbon_get_theme_option('__best_suggestion_boxes_position') === 'bottomright') {
			echo "<style>html #best-suggestion-boxes.suggestion-js-boxes .suggestion-js-boxes__body, html #best-suggestion-boxes.suggestion-js-boxes .suggestion-js-boxes__icon {bottom: ".carbon_get_theme_option('__best_suggestion_boxes_padding_y')."!important; right: ".carbon_get_theme_option('__best_suggestion_boxes_padding_x')."!important; max-width: calc(100% - 3em - ".carbon_get_theme_option('__best_suggestion_boxes_padding_x').");max-height: calc(100% - 4em - ".carbon_get_theme_option('__best_suggestion_boxes_padding_y').");}</style>";
		}
		if(carbon_get_theme_option('__best_suggestion_boxes_position') === 'bottomleft') {
			echo "<style>html #best-suggestion-boxes.suggestion-js-boxes .suggestion-js-boxes__body, html #best-suggestion-boxes.suggestion-js-boxes .suggestion-js-boxes__icon {bottom: ".carbon_get_theme_option('__best_suggestion_boxes_padding_y')."!important; left: ".carbon_get_theme_option('__best_suggestion_boxes_padding_x')."!important; right: initial !important; max-width: calc(100% - 3em - ".carbon_get_theme_option('__best_suggestion_boxes_padding_x').");max-height: calc(100% - 4em - ".carbon_get_theme_option('__best_suggestion_boxes_padding_y').");}</style>";
		}
		if(carbon_get_theme_option('__best_suggestion_boxes_position') === 'topleft') {
			echo "<style>html #best-suggestion-boxes.suggestion-js-boxes .suggestion-js-boxes__body, html #best-suggestion-boxes.suggestion-js-boxes .suggestion-js-boxes__icon {top: ".carbon_get_theme_option('__best_suggestion_boxes_padding_y')."!important; left: ".carbon_get_theme_option('__best_suggestion_boxes_padding_x')."!important; right: initial !important; bottom: initial !important; max-width: calc(100% - 3em - ".carbon_get_theme_option('__best_suggestion_boxes_padding_x').");max-height: calc(100% - 4em - ".carbon_get_theme_option('__best_suggestion_boxes_padding_y').");}</style>";
		}
		if(carbon_get_theme_option('__best_suggestion_boxes_position') === 'topright') {
			echo "<style>html #best-suggestion-boxes.suggestion-js-boxes .suggestion-js-boxes__body, html #best-suggestion-boxes.suggestion-js-boxes .suggestion-js-boxes__icon {top: ".carbon_get_theme_option('__best_suggestion_boxes_padding_y')."!important; right: ".carbon_get_theme_option('__best_suggestion_boxes_padding_x')."!important; bottom: initial !important; max-width: calc(100% - 3em - ".carbon_get_theme_option('__best_suggestion_boxes_padding_x').");max-height: calc(100% - 4em - ".carbon_get_theme_option('__best_suggestion_boxes_padding_y').");}</style>";
		}
	}
	public function __bestSuggestionBoxesChangeTitleSize() {
		echo "<style>html #best-suggestion-boxes.suggestion-js-boxes .suggestion-js-boxes__body__header-title-chat {font-size: ".carbon_get_theme_option('__best_suggestion_boxes_title_size')." !important;}</style>";
	}
	public function __bestSuggestionBoxesChangeContentSize() {
		echo "<style>html #best-suggestion-boxes.suggestion-js-boxes .suggestion-js-boxes__body__display-chat-item-sms {font-size: ".carbon_get_theme_option('__best_suggestion_boxes_content_size')." !important;}</style>";
	}
	public function __bestSuggestionBoxesChangeSize() {
		echo "<style>#best-suggestion-boxes {font-size: ".carbon_get_theme_option('__best_suggestion_boxes_size')." !important;}</style>";
	}
	public function __bestSuggestionBoxesChangeStyle() {
		echo "<style>:root {--suggestion-boxes-color: ".carbon_get_theme_option('__best_suggestion_boxes_style')." !important;
			--suggestion-boxes-item-bg: ".carbon_get_theme_option('__best_suggestion_boxes_style')." !important;}@keyframes lift-pulse { 0% { box-shadow: 0 0 0 0 ".self::liftHexToRGB(carbon_get_theme_option('__best_suggestion_boxes_style'),'.5')."; } 100% { box-shadow: 0 0 0 14px rgba(255, 255, 255, 0); } }</style>";
	}
	public function __bestSuggestionBoxesChangeLogo() {
		echo "<style>html #best-suggestion-boxes.suggestion-js-boxes .suggestion-js-boxes__body__header-cta-icon-avatar {background-image: url(".carbon_get_theme_option('__best_suggestion_boxes_logo').") !important;}</style>";
	}
	public function __bestSuggestionBoxesChangeTitle() {
		echo "<script>window.addEventListener('DOMContentLoaded', function(){document.querySelector('#best-suggestion-boxes .suggestion-js-boxes__body__header-title-chat').innerHTML = '".carbon_get_theme_option('__best_suggestion_boxes_title')."';})</script>";
	}

	public function liftHexToRGB ($hexColor, $animation=1)
	{
		if( preg_match( '/^#?([a-h0-9]{2})([a-h0-9]{2})([a-h0-9]{2})$/i', $hexColor, $matches ) )
		{
			return 'rgba('. hexdec( $matches[ 1 ] ).','. hexdec( $matches[ 2 ] ).','. hexdec( $matches[ 3 ] ).','.$animation.')';
		}
		else
		{
			return $hexColor;
		}
	}

	public function __getSuggest() {
		global $table_prefix, $wpdb;
		$tblGroup = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest_group';
		$tblSuggest = $table_prefix . BEST_SUGGESTION_BOXES_PREFIX . '_suggest';
		$resultsGroup = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$tblGroup}"));
		$json_start = '{"data":[';
		$json_end = ']}';
		$json_body = '';
		$i = 1;
		if(carbon_get_theme_option('___best_suggestion_boxes_enable')) {
			foreach ( $resultsGroup as $groupItem ) {
				$comma = $i<count($resultsGroup) ? ',': '';
				$json_body .= '{"id": "best-suggestion-boxes-'.$groupItem->group_id.'","items": [';
					$m = 1;
					$resultsSuggest = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$tblSuggest} INNER JOIN {$tblGroup} ON {$tblGroup}.group_id = {$tblSuggest}.group_id AND {$tblGroup}.group_id = $groupItem->group_id"));
					foreach ( $resultsSuggest as $item ) {
						$commaS = $m<count($resultsSuggest) ? ',': '';
						$json_body .= '{"id": '.$item->suggest_id.', "content": '.json_encode($item->suggest_content, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE).',';
						if($item->target_id != '0') {
							$json_body .= '"target": "best-suggestion-boxes-'.$item->target_id.'"';
						} else {
							$json_body .= '"target": ""';
						}
						$json_body .= '}'.$commaS.'';
						$m++;
					}
				$json_body .= ']}'.$comma.'';
				$i++;
			}
			$json = $json_start.$json_body.$json_end;
			// echo($json);
			return json_decode($json);
		}
	}

}

