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
    public function add_leads()
    {
        require_once("$this->plugin_path/templates/add_leads.php");
    }
    public function update_leads()
    {
        require_once("$this->plugin_path/templates/update_leads.php");
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