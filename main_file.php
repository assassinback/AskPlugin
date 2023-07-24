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
//Check if exists
if(!defined("ABSPATH"))
{
    die;
}
if(!function_exists("add_action"))
{
    exit;
}
//Check if autoload Exists
if(file_exists(dirname(__FILE__)."/vendor/autoload.php"))
{
    require_once dirname(__FILE__)."/vendor/autoload.php";
}
//Activate Plugin
function activate()
{
    Inc\Base\Activate::activate();
}
register_activation_hook(__FILE__,"activate");
//Deactivate Plugin
function deactivate()
{
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__,"deactivate");
//Call Init Class
if(class_exists("Inc\\Init"))
{
    Inc\Init::register_services();
}
