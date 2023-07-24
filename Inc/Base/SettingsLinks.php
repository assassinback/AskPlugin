<?php
/**
 * @package Ask_Portal
 */
namespace Inc\Base;
use \Inc\Base\BaseController;

class SettingsLinks extends BaseController
{
    //Create Settings Link on Plugins Page
    public function register()
    {
        add_filter("plugin_action_links_".$this->plugin,array($this,'settings_link'));
    }
    public function settings_link($links)
    {
        $settings_link="<a href='admin.php?page=Dashboard'>Settings</a>";
        array_push($links,$settings_link);
        return $links;
    }
}