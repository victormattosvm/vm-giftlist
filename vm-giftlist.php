<?php
/*
Plugin Name: VM Giftlist for Woocommerce
Description: Lista de presentes para Woocommerce
Plugin URI: https://tecnossauro.com.br
Author: Tecnossauro
Author URI: https://tecnossauro.com.br
Version: 1.0
License: GPL2
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('VM_Giftlist') ) :

class VM_Giftlist{

    /** @var string The plugin version number. */
    var $version = '1.0';
    
    /** @var object Instance of this class. */
    protected static $instance = null;
  
    function __construct() {}
    
    function initialize_instance() {

      register_activation_hook ( plugin_basename ( __FILE__ ), array ($this,'install' ) );
			
      
      $this->define( 'VM_GIFTLIST_FILE', __FILE__ );
      $this->define( 'VM_GIFTLIST_PATH', plugin_dir_path( __FILE__ ) );
      $this->define( 'VM_GIFTLIST_FOLDER', plugin_dir_url(__FILE__) );
      $this->define( 'VM_GIFTLIST_TEMPLATE', plugin_dir_path( __FILE__ ).'templates/' );
      $this->define( 'IMAGE_PATH_PLUGIN',plugin_dir_url( __FILE__ ) . 'assets/images/' );
      $this->define( 'VM_CURRENT_THEME', get_stylesheet_directory() );
      $this->define( 'VM_GIFTLIST_VERSION', $this->version );

           // Includes - setup
      include_once VM_GIFTLIST_PATH .  'includes/class-form.php';
      include_once VM_GIFTLIST_PATH .  'includes/admin/class-admin.php';
      include_once VM_GIFTLIST_PATH .  'includes/admin/class-metaboxes.php';
      include_once VM_GIFTLIST_PATH .  'includes/class-controller.php';


      add_action( 'init', array($this, 'setup'), 5 );
  
    }


  /**
   * setup
   *
   * Completes the setup process after initialize_instance.
   *
   * @date	09/04/20
   * @since	1.5.0
   *
   * @param	void
   * @return	void
   */
  function setup() {
    if( !did_action('plugins_loaded') ) {
      return;
    }
    
    //Actions
    add_action( 'wp_enqueue_scripts', array($this,'front_enqueue'), 20);
    if( is_admin() ) { add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue') ); }
    
    
    /**
     * Fires after plugin is completely "initialized".
     *
     * @date	09/04/20
     * @since	1.5.0
    *
    * @param	int $vm_giftlist_version The version of plugin.
    */
    do_action( 'vm_giftlist/init', VM_GIFTLIST_VERSION );
  }
  
  
  function front_enqueue() {
  
    $version = date("ymd-Gis", filemtime( VM_GIFTLIST_PATH . 'assets/css/allImports.css' ));
    //plugins
    wp_enqueue_script( 'jquery-mask', PLUGIN_URL . 'assets/js/plugins/jquery.mask.js', array(), '1.0', tru );
  
  
    //custom-css-js
    wp_enqueue_style( 'tecnossauro-css-front', PLUGIN_URL . 'assets/css/front.css',  false,   $version  );
    wp_enqueue_script( 'tecnossauro-js-front',PLUGIN_URL . 'assets/js/front.js', array('jquery'), '1.0',true );

  }

  /**
  * Registra os CSS e JS que devem aparecer no admin
  */
  function admin_enqueue() {
    //plugins
    wp_enqueue_style('jquery-ui-datepicker');
    wp_enqueue_script( 'field-date-js', 'ft.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), time(), true );

    //custom-css-js
    wp_enqueue_style( 'tecnossauro-css-admin', PLUGIN_URL . 'assets/css/admin.css', array(), false, 'all' );
    wp_enqueue_script( 'tecnossauro-js-admin', PLUGIN_URL . 'assets/js/admin.js', array('jquery'), '1.0',true );

  }


  /**
   * define
   *
   * Defines a constant if doesnt already exist.
   *
   * @date	09/04/2020
   * @since	1.0.0
   *
   * @param	string $name The constant name.
   * @param	mixed $value The constant value.
   * @return	void
   */
  function define( $name, $value = true ) {
    if( !defined($name) ) {
      define( $name, $value );
    }
  }


  /**
   * Return an instance of this class.
   *
   * @return object A single instance of this class.
   */
  public static function get_instance() {
    // If the single instance hasn't been set, set it now.
    if ( null == self::$instance ) {
      self::$instance = new self;
      self::$instance->initialize_instance();
      flush_rewrite_rules(true);
    }
    return self::$instance;
  }

  
    public function install() {
      global $wpdb;
      // get current version to check for upgrade
      $installed_version = get_option( 'tecnossauro_giftlist_version' );
      // install
      
      if ( ! $installed_version ) {
  
        $prefix = $wpdb->prefix;
  
  
        $query = "CREATE TABLE IF NOT EXISTS `{$prefix}giftlist_item` (
        `id` int(11) unsigned NOT NULL auto_increment,
        `giftlist_id` int(11)NOT NULL,
        `product_id` varchar(255) NULL,
        `qty` int(11) NOT NULL,
        `received_qty` int(11)  NULL,
        `received_order` TEXT NULL,
        `variation_id` int(11) NULL,
        `variation` varchar(255) NULL,
        `cart_item_data` text NULL,
        `add_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;";
        
        include_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta( $query );
  
      //	$this->create_pages();
        //update_option( 'clik_casamento_version', self::VERSION );
  
      }
  
    }
  
}

endif;
add_action( 'plugins_loaded', array( 'VM_Giftlist', 'get_instance' ) );