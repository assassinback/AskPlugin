<?php
/**
 * @package Ask_Portal
 */

namespace Inc\Pages;
use Templates\show_leads;
use \Inc\Base\BaseController;
class Admin extends BaseController
{
    //Initialize Admin Dashboard and Page
    public function register()
    {
        add_action('admin_menu',array($this,'add_admin_pages'));
    }
    public function add_admin_pages()
    {
        add_menu_page("Dashboard","AskPortal",'manage_options',"Dashboard",array($this,'admin_dashboard'),'dashicons-table-row-after
        ',2);
    }
    public function admin_dashboard()
    {
        // require_once $this->plugin_url."/templates/show_leads.php";
        // echo $this->plugin_url."/templates/show_leads.php";
        show_leads::heading();
        // $leads=new show_leads();
        // $leads.heading();
    }
}