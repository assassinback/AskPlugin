<?php
/**
 * @package Ask_Portal
 */

namespace Inc\Base;
use \Inc\Base\BaseController;
class Enqueue extends BaseController
{
    //Enqueue default style.css and script.js
    public function register()
    {
        add_action("admin_enqueue_scripts",array($this,'enqueue'));
    }
    public function enqueue()
    {
        wp_enqueue_style("plugin_style",$this->plugin_url."/assets/style.css");
        wp_enqueue_script("plugin_style",$this->plugin_url."/assets/script.js");
    }
}