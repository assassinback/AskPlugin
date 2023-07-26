<?php
/**
 * @package Ask_Portal
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;
class AdminCallbacks extends BaseController
{
    public function admin_dashboard()
    {
        require_once("$this->plugin_path/templates/dashboard.php");
    }
    public function show_leads()
    {
        require_once("$this->plugin_path/templates/show_leads.php");
    }
    public function add_leads()
    {
        require_once("$this->plugin_path/templates/add_leads.php");
    }
    public function update_leads()
    {
        require_once("$this->plugin_path/templates/update_leads.php");
    }
}