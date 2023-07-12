<?php
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
//class
class ask_portal
{
    //make constructor
    function __construct()
    {
        add_action("init",array($this,"custom_post_type"));
    }
    //enqueue scripts
    function register()
    {
        add_action("admin_enqueue_scripts",array($this,'enqueue'));
    }
    //plugin activate
    function activate()
    {
        $this->custom_post_type();
        flush_rewrite_rules();
    }
    //plugin deactivate
    function deactivate()
    {
        flush_rewrite_rules();
    }
    //create custom post type
    function custom_post_type()
    {
        register_post_type("Portal",['public'=>true,'label'=>"Portal"]);
    }
    //enqueue scripts
    function enqueue()
    {
        wp_enqueue_style("plugin_style",plugins_url("/assets/style.css",__FILE__));
    }
}
//create instance
if(class_exists("ask_portal"))
{
    $portal_info=new ask_portal();
    $portal_info->register();
}
//activate
register_activation_hook(__FILE__,array($portal_info,"activate"));
//deactivate
register_deactivation_hook(__FILE__,array($portal_info,"deactivate"));
