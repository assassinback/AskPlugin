<?php
/**
 * @package Ask_Portal
 */
/**
* Plugin Name: ASK Portal
* Plugin URI: https://www.blossomheaven.com/
* Description: ASK Consultants Portal.
* Version: 0.1
* Author: Blossom Heaven
* Author URI: https://www.blossomheaven.com/
**/

if(!defined("ABSPATH"))
{
    die;
}
if(!function_exists("add_action"))
{
    exit;
}
if(file_exists(dirname(__FILE__)."/vendor/autoload.php"))
{
    require_once dirname(__FILE__)."/vendor/autoload.php";
}

use Inc\Activate;
use Inc\Deactivate;
use Inc\Admin\AdminPages;
// new Deactivate().test();
// echo __DIR__ . '/../..' . '/inc';
// $vendorDir = dirname(__DIR__);
// $baseDir = dirname($vendorDir);
// echo $baseDir;
//class
if(!class_exists("ask_portal"))
{
    class ask_portal
    {
        public $plugin_name;
        //make constructor
        function __construct()
        {
            add_action("init",array($this,"custom_post_type"));
            $this->plugin_name=plugin_basename(__FILE__);
        }
        //enqueue scripts
        public function register()
        {
            add_action("admin_enqueue_scripts",array($this,'enqueue'));
            add_action('admin_menu',array($this,'add_admin_pages'));
            add_filter("plugin_action_links_$this->plugin_name",array($this,'settings_link'));
        }
        public function settings_link($links)
        {
            $settings_link="<a href='admin.php?page=Dashboard'>Settings</a>";
            array_push($links,$settings_link);
            return $links;
        }
        public function add_admin_pages()
        {
            add_menu_page("Dashboard","AskPortal",'manage_options',"Dashboard",array($this,'admin_dashboard'),'dashicons-table-row-after
            ',2);
        }
        public function admin_dashboard()
        {
            require_once plugin_dir_path(__FILE__)."templates/show_leads.php";
        }
        //plugin activate
        // public function activate()
        // {
        //     $this->custom_post_type();
        //     flush_rewrite_rules();
        // }
        // //plugin deactivate
        // public function deactivate()
        // {
        //     flush_rewrite_rules();
        // }
        //create custom post type
        public function custom_post_type()
        {
            register_post_type("Portal",['public'=>true,'label'=>"Portal"]);
        }
        //enqueue scripts
        public function enqueue()
        {
            wp_enqueue_style("plugin_style",plugins_url("/assets/style.css",__FILE__));
            wp_enqueue_script("plugin_style",plugins_url("/assets/script.js",__FILE__));
        }
    }
}

//create instance
if(class_exists("ask_portal"))
{
    $portal_info=new ask_portal();
    $portal_info->register();
}
//activate
// require_once plugin_dir_path(__FILE__)."inc/Activate.php";
register_activation_hook(__FILE__,array("Inc\Activate","activate"));

//deactivate
// require_once plugin_dir_path(__FILE__)."inc/ask_portal_deactivate.php";
register_deactivation_hook(__FILE__,array("Inc\Deactivate","deactivate"));
