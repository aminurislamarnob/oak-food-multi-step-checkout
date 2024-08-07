<?php

namespace PluginizeLab\OakFoodMultiStepCheckout;

/**
 * OakFoodMultiStepCheckout class
 *
 * @class OakFoodMultiStepCheckout The class that holds the entire OakFoodMultiStepCheckout plugin
 */
final class OakFoodMultiStepCheckout {

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	public $version = '0.0.1';

	/**
	 * Instance of self
	 *
	 * @var OakFoodMultiStepCheckout
	 */
	private static $instance = null;

	/**
	 * Holds various class instances
	 *
	 * @since 2.6.10
	 *
	 * @var array
	 */
	private $container = array();

	/**
	 * Plugin dependencies
	 *
	 * @since 2.6.10
	 *
	 * @var array
	 */
	private const OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES = array(
		'plugins'   => array(
			// 'woocommerce/woocommerce.php',
			// 'dokan-lite/dokan.php',
			// 'dokan-pro/dokan-pro.php'
		),
		'classes'   => array(
			// 'Woocommerce',
			// 'WeDevs_Dokan',
			// 'Dokan_Pro'
		),
		'functions' => array(
			// 'dokan_admin_menu_position'
		),
	);

	/**
	 * Constructor for the OakFoodMultiStepCheckout class
	 *
	 * Sets up all the appropriate hooks and actions
	 * within our plugin.
	 */
	private function __construct() {
		$this->define_constants();

		register_activation_hook( OAK_FOOD_MULTI_STEP_CHECKOUT_FILE, array( $this, 'activate' ) );
		register_deactivation_hook( OAK_FOOD_MULTI_STEP_CHECKOUT_FILE, array( $this, 'deactivate' ) );

		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
		add_action( 'woocommerce_flush_rewrite_rules', array( $this, 'flush_rewrite_rules' ) );
	}

	/**
	 * Initializes the OakFoodMultiStepCheckout() class
	 *
	 * Checks for an existing OakFoodMultiStepCheckout instance
	 * and if it doesn't find one then create a new one.
	 *
	 * @return OakFoodMultiStepCheckout
	 */
	public static function init() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Magic getter to bypass referencing objects
	 *
	 * @since 2.6.10
	 *
	 * @param string $prop
	 *
	 * @return Class Instance
	 */
	public function __get( $prop ) {
		if ( array_key_exists( $prop, $this->container ) ) {
			return $this->container[ $prop ];
		}
	}

	/**
	 * Placeholder for activation function
	 *
	 * Nothing is being called here yet.
	 */
	public function activate() {
		// Check oak_food_multi_step_checkout dependency plugins
		if ( ! $this->check_dependencies() ) {
			wp_die( $this->get_dependency_message() );
		}

		// Rewrite rules during oak_food_multi_step_checkout activation
		if ( $this->has_woocommerce() ) {
			$this->flush_rewrite_rules();
		}
	}

	/**
	 * Flush rewrite rules after oak_food_multi_step_checkout is activated or woocommerce is activated
	 *
	 * @since 3.2.8
	 */
	public function flush_rewrite_rules() {
		// fix rewrite rules
		flush_rewrite_rules();
	}

	/**
	 * Placeholder for deactivation function
	 *
	 * Nothing being called here yet.
	 */
	public function deactivate() {     }

	/**
	 * Define all constants
	 *
	 * @return void
	 */
	public function define_constants() {
		$this->define( 'OAK_FOOD_MULTI_STEP_CHECKOUT_PLUGIN_VERSION', $this->version );
		$this->define( 'OAK_FOOD_MULTI_STEP_CHECKOUT_DIR', dirname( OAK_FOOD_MULTI_STEP_CHECKOUT_FILE ) );
		$this->define( 'OAK_FOOD_MULTI_STEP_CHECKOUT_INC_DIR', OAK_FOOD_MULTI_STEP_CHECKOUT_DIR . '/includes' );
		$this->define( 'OAK_FOOD_MULTI_STEP_CHECKOUT_TEMPLATE_DIR', OAK_FOOD_MULTI_STEP_CHECKOUT_DIR . '/templates' );
		$this->define( 'OAK_FOOD_MULTI_STEP_CHECKOUT_PLUGIN_ASSET', plugins_url( 'assets', OAK_FOOD_MULTI_STEP_CHECKOUT_FILE ) );

		// give a way to turn off loading styles and scripts from parent theme
		$this->define( 'OAK_FOOD_MULTI_STEP_CHECKOUT_LOAD_STYLE', true );
		$this->define( 'OAK_FOOD_MULTI_STEP_CHECKOUT_LOAD_SCRIPTS', true );
	}

	/**
	 * Define constant if not already defined
	 *
	 * @param string      $name
	 * @param string|bool $value
	 *
	 * @return void
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Load the plugin after WP User Frontend is loaded
	 *
	 * @return void
	 */
	public function init_plugin() {
		// Check oak_food_multi_step_checkout dependency plugins
		if ( ! $this->check_dependencies() ) {
			add_action( 'admin_notices', array( $this, 'admin_error_notice_for_dependency_missing' ) );
			return;
		}

		$this->includes();
		$this->init_hooks();

		do_action( 'oak_food_multi_step_checkout_loaded' );
	}

	/**
	 * Initialize the actions
	 *
	 * @return void
	 */
	public function init_hooks() {
		// initialize the classes
		add_action( 'init', array( $this, 'init_classes' ), 4 );
		add_action( 'plugins_loaded', array( $this, 'after_plugins_loaded' ) );
	}

	/**
	 * Include all the required files
	 *
	 * @return void
	 */
	public function includes() {
		// include_once STUB_PLUGIN_DIR . '/functions.php';
	}

	/**
	 * Init all the classes
	 *
	 * @return void
	 */
	public function init_classes() {
		$this->container['scripts']               = new Assets();
		$this->container['helpers']               = new Helpers();
		$this->container['create_customer']       = new CreateCustomer();
		$this->container['checkout']              = new Checkout();
		$this->container['handle_order_meta']     = new HandleOrderMeta();
		$this->container['login_ajax_validation'] = new LoginAjaxValidation();
	}

	/**
	 * Executed after all plugins are loaded
	 *
	 * At this point oak_food_multi_step_checkout Pro is loaded
	 *
	 * @since 2.8.7
	 *
	 * @return void
	 */
	public function after_plugins_loaded() {
		// Initiate background processes and other tasks
	}

	/**
	 * Check whether woocommerce is installed and active
	 *
	 * @since 2.9.16
	 *
	 * @return bool
	 */
	public function has_woocommerce() {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Check whether woocommerce is installed
	 *
	 * @since 3.2.8
	 *
	 * @return bool
	 */
	public function is_woocommerce_installed() {
		return in_array( 'woocommerce/woocommerce.php', array_keys( get_plugins() ), true );
	}

	/**
	 * Check plugin dependencies
	 *
	 * @return boolean
	 */
	public function check_dependencies() {
		if ( array_key_exists( 'plugins', self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES ) && ! empty( self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES['plugins'] ) ) {
			for ( $plugin_counter = 0; $plugin_counter < count( self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES['plugins'] ); $plugin_counter++ ) {
				if ( ! is_plugin_active( self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES['plugins'][ $plugin_counter ] ) ) {
					return false;
				}
			}
		} elseif ( array_key_exists( 'classes', self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES ) && ! empty( self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES['classes'] ) ) {
			for ( $class_counter = 0; $class_counter < count( self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES['classes'] ); $class_counter++ ) {
				if ( ! class_exists( self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES['classes'][ $class_counter ] ) ) {
					return false;
				}
			}
		} elseif ( array_key_exists( 'functions', self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES ) && ! empty( self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES['functions'] ) ) {
			for ( $func_counter = 0; $func_counter < count( self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES['functions'] ); $func_counter++ ) {
				if ( ! function_exists( self::OAK_FOOD_MULTI_STEP_CHECKOUT_DEPENEDENCIES['functions'][ $func_counter ] ) ) {
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Dependency error message
	 *
	 * @return void
	 */
	protected function get_dependency_message() {
		return __( 'Oak Food Multi Step Checkout plugin is enabled but not effective. It requires dependency plugins to work.', 'oak-food-multi-step-checkout' );
	}

	/**
	 * Admin error notice for missing dependency plugins
	 *
	 * @return void
	 */
	public function admin_error_notice_for_dependency_missing() {
		$class = 'notice notice-error';
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $this->get_dependency_message() ) );
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', OAK_FOOD_MULTI_STEP_CHECKOUT_FILE ) );
	}

	/**
	 * Get the template file path to require or include.
	 *
	 * @param string $name
	 * @return string
	 */
	public function get_template( $name ) {
		$template = untrailingslashit( OAK_FOOD_MULTI_STEP_CHECKOUT_TEMPLATE_DIR ) . '/' . untrailingslashit( $name );

		return apply_filters( 'oak-food-multi-step-checkout_template', $template, $name );
	}

	/**
	 * Get the assets file like image
	 *
	 * @param string $name
	 * @return string
	 */
	public function get_asset( $name ) {
		$template = untrailingslashit( OAK_FOOD_MULTI_STEP_CHECKOUT_PLUGIN_ASSET ) . '/' . untrailingslashit( $name );

		return apply_filters( 'oak-food-multi-step-checkout_asset', $template, $name );
	}
}
