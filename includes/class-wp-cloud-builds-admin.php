<?php
/**
 * WP Cloud Builds Admin
 * @since       0.1.0
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'WP_Cloud_Builds_Admin' ) ) {

    /**
     * WP_Cloud_Builds_Admin class
     *
     * @since       0.1.0
     */
    class WP_Cloud_Builds_Admin {

        /**
         * @var         WP_Cloud_Builds_Admin $instance The one true WP_Cloud_Builds_Admin
         * @since       0.1.0
         */
        private static $instance;
        public static $errorpath = '../php-error-log.php';
        public static $active = array();
        // sample: error_log("meta: " . $meta . "\r\n",3,self::$errorpath);

        /**
         * Get active instance
         *
         * @access      public
         * @since       0.1.0
         * @return      object self::$instance The one true WP_Cloud_Builds_Admin
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new WP_Cloud_Builds_Admin();
                self::$instance->hooks();
            }

            return self::$instance;
        }


        /**
         * Include necessary files
         *
         * @access      private
         * @since       0.1.0
         * @return      void
         */
        private function hooks() {

            add_action( 'admin_menu', array( $this, 'settings_page' ) );
            add_action( 'save_post', array( $this, 'maybe_send_webhook' ), 10, 3 );

        }

        /**
         * Add settings menu item
         *
         * @access      public
         * @since       0.1
         */
        public function settings_page() {

            add_options_page(
                'WP Cloud Builds',
                'WP Cloud Builds',
                'manage_options',
                'wp_cloud_builds',
                array(
                    $this,
                    'render_settings'
                )
            );
            
        }

        /**
         * Settings page output
         *
         * @access      public
         * @since       0.1.0
         */
        public function render_settings() {

            if( isset( $_POST['wpnd_webhook'] ) ) {
                update_option( 'wpnd_webhook', sanitize_text_field( $_POST['wpnd_webhook'] ) );
            }

            ?>
            <div class="wrap">          

            <h2><?php _e('Settings', 'wp-cloud-builds'); ?></h2>

            <?php 
                if( get_option('wp_cloud_builds_error') ) {
                    echo '<p style="color:red">' . get_option('wp_cloud_builds_error') . '</p>';
            } ?>

            <form method="post">

                <h3><?php _e('Webhook url', 'wp-cloud-builds'); ?></h3>
                
                <input id="wpnd_webhook" name="wpnd_webhook" value="<?php echo esc_html( get_option( 'wpnd_webhook' ) ); ?>" placeholder="Webhook url" type="text" size="50" /><br/>

            <?php submit_button(); ?>

            </form>

            </div>
            <?php
            
        }

        /**
         * If conditions are met, trigger deployment
         *
         * @access      public
         * @since       0.1
         */
        public function maybe_send_webhook( $post_id, $post, $update ) {

            if( $post->post_type != 'post' )
                return;

            $url = get_option('wpnd_webhook');
            if( $url) {
                $response = wp_remote_post( $url );
            }

            if ( is_wp_error( $response ) ) {
                $error_message = $response->get_error_message();
                update_option('wp_cloud_builds_error', "Something went wrong with your deployment: $error_message" );
            }
        }

    }

    $WP_Cloud_Builds_Admin = new WP_Cloud_Builds_Admin();
    $WP_Cloud_Builds_Admin->instance();

} // end class_exists check