<?php
/**
 * Plugin Name:     WP Cloud Builds
 * Plugin URI:      https://github.com/sarahg/wp-cloud-builds
 * Description:     Trigger a build on a webhook-friendly CI/CD service, like Gatsby Cloud or Netlify, when WordPress posts or pages are created or updated.
 * Version:         0.1.0
 * Author:          Scott Bolinger, Sarah German
 * Text Domain:     wp-cloud-builds
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'WP_Cloud_Builds' ) ) {

    /**
     * Main WP_Cloud_Builds class
     *
     * @since       0.1.0
     */
    class WP_Cloud_Builds {

        /**
         * @var         WP_Cloud_Builds $instance The one true WP_Cloud_Builds
         * @since       0.1.0
         */
        private static $instance;


        /**
         * Get active instance
         *
         * @access      public
         * @since       0.1.0
         * @return      self The one true WP_Cloud_Builds
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new WP_Cloud_Builds();
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->load_textdomain();
            }

            return self::$instance;
        }


        /**
         * Setup plugin constants
         *
         * @access      private
         * @since       0.1.0
         * @return      void
         */
        private function setup_constants() {
            // Plugin version
            define( 'WP_Cloud_Builds_VER', '0.1.0' );

            // Plugin path
            define( 'WP_Cloud_Builds_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'WP_Cloud_Builds_URL', plugin_dir_url( __FILE__ ) );

        }


        /**
         * Include necessary files
         *
         * @access      private
         * @since       0.1.0
         * @return      void
         */
        private function includes() {

            if( is_admin() )
                require_once WP_Cloud_Builds_DIR . 'includes/class-wp-cloud-builds-admin.php';
            
        }


        /**
         * Internationalization
         *
         * @access      public
         * @since       0.1.0
         * @return      void
         */
        public function load_textdomain() {

            load_plugin_textdomain( 'wp-cloud-builds' );
            
        }

    }
} // End if class_exists check


/**
 * The main function responsible for returning the one true
 * instance to functions everywhere
 *
 * @since       0.1.0
 * @return      \WP_Cloud_Builds The one true WP_Cloud_Builds
 *
 */
function WP_Cloud_Builds_load() {
    return WP_Cloud_Builds::instance();
}
add_action( 'plugins_loaded', 'WP_Cloud_Builds_load' );


/**
 * The activation hook is called outside of the singleton because WordPress doesn't
 * register the call from within the class, since we are preferring the plugins_loaded
 * hook for compatibility, we also can't reference a function inside the plugin class
 * for the activation function. If you need an activation function, put it here.
 *
 * @since       0.1.0
 * @return      void
 */
function WP_Cloud_Builds_activation() {
    /* Activation functions here */
}
// register_activation_hook( __FILE__, 'WP_Cloud_Builds_activation' );