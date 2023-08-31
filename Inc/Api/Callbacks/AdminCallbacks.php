<?php
/**
 * @package Ask_Portal
 */
namespace Inc\Api\Callbacks;
use Templates\show_leads;
use Inc\Base\BaseController;
class AdminCallbacks extends BaseController
{
    public function admin_dashboard()
    {
        require_once("$this->plugin_path/templates/dashboard.php");
    }
    public function show_leads()
    {
        // require_once("$this->plugin_path/templates/show_leads.php");
        $leads=new show_leads();
        $leads->create_page();
    }
    public function show_extra_data()
    {
        // require_once("$this->plugin_path/templates/show_leads.php");
        require_once("$this->plugin_path/templates/show_extra_data.php");
    }
    public function show_inprocess()
    {
        require_once("$this->plugin_path/templates/show_inprocess.php");
    }
    public function show_completed()
    {
        require_once("$this->plugin_path/templates/show_completed.php");
    }
    public function add_leads()
    {
        require_once("$this->plugin_path/templates/add_leads.php");
    }
    public function add_inprocess()
    {
        require_once("$this->plugin_path/templates/add_inprocess.php");
    }
    public function add_completed()
    {
        require_once("$this->plugin_path/templates/add_completed.php");
    }
    public function add_admins()
    {
        require_once("$this->plugin_path/templates/add_admins.php");
    }
    public function add_extra_data()
    {
        require_once("$this->plugin_path/templates/add_extra_data.php");
    }
    public function show_admins()
    {
        require_once("$this->plugin_path/templates/show_admins.php");
    }
    public function follow_up_leads()
    {
        require_once("$this->plugin_path/templates/follow_up_leads.php");
    }
    public function follow_up_inprocess()
    {
        require_once("$this->plugin_path/templates/follow_up_inprocess.php");
    }
    public function askOptionsGroup($input)
    {
        return $input;
    }
    public function askAdminSection()
    {
        echo "Check this beutiful section";
    }
    
    public function askTextExample()
    {
        $value=esc_attr(get_option('show_leads'));
        echo "<input type='text' class='regular-text' name='show_leads' value='$value' placeholder='Text  '>";
    }
}