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
    public function show_consultants()
    {
        require_once("$this->plugin_path/templates/show_consultants.php");
    }
    public function show_country()
    {
        require_once("$this->plugin_path/templates/show_country.php");
    }
    public function show_follow_up_actions()
    {
        require_once("$this->plugin_path/templates/show_follow_up_actions.php");
    }
    public function show_inquiry_location()
    {
        require_once("$this->plugin_path/templates/show_inquiry_location.php");
    }
    public function show_outcome()
    {
        require_once("$this->plugin_path/templates/show_outcome.php");
    }
    public function show_priority()
    {
        require_once("$this->plugin_path/templates/show_priority.php");
    }
    public function show_source()
    {
        require_once("$this->plugin_path/templates/show_source.php");
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