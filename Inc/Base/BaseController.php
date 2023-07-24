<?php
/**
 * @package Ask_Portal
 */

namespace Inc\Base;
class BaseController
{
    //Create Default path variables
    public $plugin_path;
    public $plugin_url;
    public $plugin;
    public function __construct()
    {
        $this->plugin_path=plugin_dir_path(dirname(__FILE__,2));
        $this->plugin_url=plugin_dir_url(dirname(__FILE__,2));
        $this->plugin=plugin_basename(dirname(__FILE__,3))."/main_file.php";
    }
}