<?php
/**
 * Gutenverse Main class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package gutenverse
 */

namespace Gutenverse;

/**
 * Class Gutenverse
 *
 * @package gutenverse
 */
class Gutenverse {
	/**
	 * Instance of Gutenverse.
	 *
	 * @var Gutenverse
	 */
	private static $instance;

	/**
	 * Hold instance of Blocks
	 *
	 * @var Blocks
	 */
	public $blocks;

	/**
	 * Hold instance of form
	 *
	 * @var Form
	 */
	public $form;

	/**
	 * Hold instance of entries
	 *
	 * @var Entries
	 */
	public $entries;

	/**
	 * Hold instance of dashboard
	 *
	 * @var Dashboard
	 */
	public $dashboard;

	/**
	 * Hold frontend assets instance
	 *
	 * @var Frontend_Assets
	 */
	public $frontend_assets;

	/**
	 * Hold editor assets instance
	 *
	 * @var Editor_Assets
	 */
	public $editor_assets;

	/**
	 * Hold settings instance
	 *
	 * @var Settings
	 */
	public $settings;

	/**
	 * Hold theme list instance
	 *
	 * @var Theme_List
	 */
	public $theme_list;

	/**
	 * Hold Meta Option Instance.
	 *
	 * @var Meta_Option
	 */
	public $meta_option;

	/**
	 * Hold Library Instance.
	 *
	 * @var Library
	 */
	public $library;

	/**
	 * Hold Theme Helper Instance.
	 *
	 * @var Theme_Helper
	 */
	public $theme_helper;

	/**
	 * Hold Style Generator Instance.
	 *
	 * @var Style_Generator
	 */
	public $style_generator;

	/**
	 * Hold Frontend Toolbar Instance.
	 *
	 * @var Frontend_Toolbar
	 */
	public $frontend_toolbar;

	/**
	 * Hold Banner Instance.
	 *
	 * @var Banner
	 */
	public $banner;

	/**
	 * Hold Upgrader Instance.
	 *
	 * @var Upgrader
	 */
	public $upgrader;

	/**
	 * Hold Global Variable Instance.
	 *
	 * @var Global_Variable
	 */
	public $global_variable;

	/**
	 * Hold API Variable Instance.
	 *
	 * @var Api
	 */
	public $api;


	/**
	 * Singleton page for Gutenverse Class
	 *
	 * @return Gutenverse
	 */
	public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Init constructor.
	 */
	private function __construct() {
		$this->load_helper();
		$this->init_hook();
		$this->init_instance();
		$this->init_post_type();
	}

	/**
	 * Load Helper
	 */
	public function load_helper() {
		require_once GUTENVERSE_DIR . 'lib/helper.php';
	}

	/**
	 * Initialize Hook
	 */
	public function init_hook() {
		// actions.
		add_action( 'admin_notices', array( $this, 'notice_install_plugin' ) );
		add_action( 'rest_api_init', array( $this, 'init_api' ) );
		add_action( 'init', array( $this, 'register_menu_position' ) );
		add_action( 'init', array( $this, 'import_mechanism' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'activated_plugin', array( $this, 'set_transient_to_redirect_when_activated' ) );
		add_action( 'admin_init', array( $this, 'redirect_to_dashboard' ) );
		add_action( 'activated_plugin', array( $this, 'flush_rewrite_rules' ) );
		add_action( 'customize_register', '__return_true' );

		// filters.
		add_filter( 'after_setup_theme', array( $this, 'init_settings' ) );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_meta_links' ), 10, 2 );
	}

	/**
	 * Plugin Meta Link
	 *
	 * @param array  $links  Initial list of links.
	 * @param string $file   Basename of current plugin.
	 *
	 * @return array
	 */
	public function plugin_meta_links( $links, $file ) {
		if ( plugin_basename( GUTENVERSE_FILE ) === $file ) {
			$support_link = '<a target="_blank" href="https://wordpress.org/support/plugin/gutenverse/">' . esc_html__( 'Got Question?', 'gutenverse' ) . '</a>';
			$rate_link    = '<a target="_blank" href="https://wordpress.org/support/plugin/gutenverse/reviews/#new-post">' . esc_html__( 'Rate us ★★★★★', 'gutenverse' ) . '</a>';

			$links[] = $support_link;
			$links[] = $rate_link;
		}

		return $links;
	}

	/**
	 * Rewrite rules only once on activation
	 */
	public function flush_rewrite_rules() {
		if ( ! get_option( 'gutenverse_plugin_permalinks_flushed' ) ) {
			flush_rewrite_rules();
			update_option( 'gutenverse_plugin_permalinks_flushed', 1 );
		}
	}

	/**
	 * Load import mechanism
	 */
	public function import_mechanism() {
		new Import_Template();
	}

	/**
	 * Redirect page after plugin is actived
	 */
	public function set_transient_to_redirect_when_activated( $plugin ) {
		if ( GUTENVERSE_PATH === $plugin ) {
			set_transient( 'gutenverse_redirect', 1, 30 );
		}
	}

	/**
	 * Redirect page after plugin is actived
	 */
	public function redirect_to_dashboard() {
		if ( get_transient( 'gutenverse_redirect' ) ) {
			global $pagenow;
			if ( 'plugins.php' === $pagenow || 'plugin-install.php' === $pagenow ) {
				wp_safe_redirect( admin_url( 'admin.php?page=gutenverse' ) );
				delete_transient( 'gutenverse_redirect' );
				exit;
			} else {
				delete_transient( 'gutenverse_redirect' );
			}
		}
	}

	/**
	 * Load text domain
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'gutenverse', false, GUTENVERSE_LANG_DIR );
	}

	/**
	 * Register Menu Position.
	 */
	public function register_menu_position() {
		register_nav_menus(
			array(
				'primary' => __( 'Primary Navigation', 'gutenverse' ),
			)
		);
	}

	/**
	 * Init settings
	 */
	public function init_settings() {
		$settings_data = get_option( 'gutenverse-settings' );

		if ( isset( $settings_data['general'] ) ) {
			if ( isset( $settings_data['general']['enable_default_template'] ) && true === $settings_data['general']['enable_default_template'] ) {
				add_theme_support( 'block-templates' );
			}
		}
	}

	/**
	 * Initialize Form
	 */
	public function init_post_type() {
		$this->dashboard    = new Dashboard();
		$this->form         = new Form();
		$this->entries      = new Entries();
		$this->theme_helper = new Theme_Helper();
	}

	/**
	 * Initialize Instance
	 */
	public function init_instance() {
		$this->meta_option      = Meta_Option::instance();
		$this->blocks           = new Blocks();
		$this->frontend_assets  = new Frontend_Assets();
		$this->editor_assets    = new Editor_Assets();
		$this->style_generator  = new Style_Generator();
		$this->frontend_toolbar = new Frontend_Toolbar();
		$this->banner           = new Banner();
		$this->upgrader         = new Upgrader();
		$this->global_variable  = new Global_Variable();
		$this->library          = new Library();
	}

	/**
	 * Init Rest API
	 */
	public function init_api() {
		$this->api = Api::instance();
	}

	/**
	 * WP API URL
	 */
	public function wp_api_url() {
		return esc_url_raw( rest_url( 'wp/v2' ) );
	}

	/**
	 * Show notification to install Gutenverse Plugin.
	 */
	public function notice_install_plugin() {
		// skip if compatible.
		if ( is_gutenverse_compatible() ) {
			return;
		}

		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}

		if ( 'true' === get_user_meta( get_current_user_id(), 'gutenverse_install_notice', true ) ) {
			return;
		}
		?>
		<style>
			.install-gutenverse-plugin-notice {
				border: 1px solid #E6E6EF;
				border-radius: 5px;
				padding: 35px 40px;
				position: relative;
				overflow: hidden;
				background-position: right top;
				background-repeat: no-repeat;
			}

			.install-gutenverse-plugin-notice .notice-dismiss {
				top: 20px;
				right: 20px;
				padding: 0;
			}

			.install-gutenverse-plugin-notice .notice-dismiss:before {
				content: "\f335";
				font-size: 17px;
				width: 25px;
				height: 25px;
				line-height: 25px;
				border: 1px solid #E6E6EF;
				border-radius: 3px;
				color: #fff;
			}

			.install-gutenverse-plugin-notice h3 {
				margin-top: 5px;
				font-weight: 700;
				font-size: 18px;
			}

			.install-gutenverse-plugin-notice p {
				font-size: 14px;
				font-weight: 300;
			}

			.install-gutenverse-plugin-notice .gutenverse-bottom {
				display: flex;
				align-items: center;
				margin-top: 20px;
			}

			.install-gutenverse-plugin-notice a {
				text-decoration: none;
				margin-right: 20px;
			}

			.install-gutenverse-plugin-notice a.gutenverse-button {
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
				text-decoration: none;
				cursor: pointer;
				font-size: 12px;
				line-height: 18px;
				border-radius: 17px;
				background: #3B57F7;
				color: #fff;
				padding: 8px 30px;
				font-weight: 300;
			}
		</style>
		<script>
		jQuery( function( $ ) {
			$( 'div.notice.install-gutenverse-plugin-notice' ).on( 'click', 'button.notice-dismiss', function( event ) {
				event.preventDefault();

				$.post( ajaxurl, {
					action: 'gutenverse_set_admin_notice_viewed'
				} );
			} );
		} );
		</script>
		<div class="notice is-dismissible install-gutenverse-plugin-notice">
			<div class="gutenverse-notice-inner">
				<div class="gutenverse-notice-content">
					<h3><?php esc_html_e( 'WordPress 5.9 required for Gutenverse.', 'gutenverse-themes' ); ?></h3>
					<p><?php esc_html_e( 'You are currently using lower version of WordPress, we recommend to update to WordPress 5.9 or higher. Or if you want to keep using lower version of WordPress, please install the latest version of Gutenberg', 'gutenverse-themes' ); ?></p>					
				</div>
			</div>
		</div>
		<?php
	}
}
