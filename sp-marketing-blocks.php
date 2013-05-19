<?php
/*
Plugin Name: SmallPress Marketing Blocks
Plugin URI: http://www.bluetentmarketing.com/
Description: A plugin that provides a content type, view, and configuration for homepage marketing blocks
Version: 1.0
Author: EthanHinson
Author URI: http://www.bluetentmarketing.com/
Author Email: ethan@bluetent.com
License:

  Copyright 2013 Blue Tent Marketing (ethan@bluetent.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

// TODO: rename this class to a proper name for your plugin
class SPMarketingBlocks {

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
            
            // Load plugin text domain
            add_action( 'init', array( $this, 'plugin_textdomain' ) );
            
            //Register post types
            add_action( 'init', array( $this, 'register_post_types' ) );
            
            //Add META boxes
            add_action( 'add_meta_boxes', array( $this, 'add_boxes' ) );
            add_action( 'save_post', array( $this, 'save_meta_data' ) );
            
            // Register admin styles and scripts
            add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

            // Register site styles and scripts
            add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );

            /**
             * Implement Shortcode
             */
            add_shortcode( 'sp_marketing_blocks', array( $this, 'display_blocks' ) );

	} // end constructor


	/**
	 * Loads the plugin text domain for translation
	 */
	public function plugin_textdomain() {

            $domain = 'sp-marketing-blocks';
            $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
            load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
            load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

	} // end plugin_textdomain
        
        /**
         * Register Custom Post Types
         */
        
        public function register_post_types() {
            //Require Extra files
            require_once( 'includes/post-types.php' );
            //Loops the $post_types var and register
            foreach($post_types as $type_slug => $args) {
                register_post_type($type_slug, $args);
            }
        } // End register post_types
        
        /**
         * Add META boxes
         */
        
        public function add_boxes() {
            //Require extra files
            require( 'includes/metaboxes.php' );
            //Loops $meta_boxes and adds
            foreach( $meta_boxes as $box ) {
                add_meta_box( $box['id'], $box['title'], $box['callback'], $box['post_type'], $box['context'], $box['priority'], $box['callback_args'] );
            }
        }
        
        public function render_box($post, $meta_box) {
            if( is_array($meta_box['args']) ) {
                $meta_box['args']['variables']['post'] = $post;
                $this->theme( $meta_box['args']['path'], $meta_box['args']['variables']  );
            } else {
                wp_die( 'You must pass $path and $variables via the add_meta_box() callback arguments. ' );
            }
        }
        
        /**
         * Save Meta Data
         */
        
        public function save_meta_data( $post_id ) {
            //print '<pre>';
            //die( print_r($_POST['sp_marketing_blocks_data']) );
            if( wp_verify_nonce( $_POST['sp_marketing_blocks_data'], 'save_data' ) &&  current_user_can( 'edit_post', $post_id ) ) {
                if( is_array( $_POST['fields'] ) ) {
                    foreach( $_POST['fields'] as $field => $value ) {
                        update_post_meta( $post_id, $field, wp_kses( $value, array() ) );
                    }
                }
            }
        }

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

            wp_enqueue_style( 'plugin-name-admin-styles', plugins_url( 'sp-marketing-blocks/css/admin.css' ) );

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

            wp_enqueue_script( 'plugin-name-admin-script', plugins_url( 'sp-marketing-blocks/js/admin.js' ), array('jquery') );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {

            wp_enqueue_style( 'plugin-name-plugin-styles', plugins_url( 'sp-marketing-blocks/css/display.css' ) );

	} // end register_plugin_styles

	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {

            wp_enqueue_script( 'plugin-name-plugin-script', plugins_url( 'sp-marketing-blocks/js/display.js' ), array('jquery') );

	} // end register_plugin_scripts
        
        /**
         * Function which fetches an HTML template
         * @param string $path The path to the HTML template which will be used
         * @param array  $variables The data which will be themed
         */
        
        public function theme( $path, $variables ) {
            include($path);  
        } // End theme
        
        /**
         * Function which fetches blocks from the database
         * @param int $posts_per_page - the number of blocks to fetch
         * @return $posts object
         */
        
        public function get_blocks($posts_per_page) {
            $query = new WP_Query(
                        array(
                            'post_type' => 'sp_marketing_blocks',
                            'post_status' => 'publish',
                            'posts_per_page' => $posts_per_page,
                            'orderby' => 'meta_value_num',
                            'meta_key' => 'sp_marketing_block_weight'
                        )
                    );
            
            return $query->posts;
        } //End get_blocks
        
	public function display_blocks($atts) {
            //Init vars
            $content = '';
            $number = $atts['number'];
            $layout = $atts['layout'];
            //Fetch blocks 
            $blocks = $this->get_blocks($number);
            //Create HTML content with our vars
            foreach($blocks as $block) {
               $content .= $this->theme('views/display.php', $block);
            }
            return $content;
	} // end display_blocks

} // end class

// Fire Away
$sp_marketing_blocks = new SPMarketingBlocks();
