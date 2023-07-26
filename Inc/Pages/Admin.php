<?php
/**
 * @package Ask_Portal
 */

namespace Inc\Pages;
use Templates\show_leads;
use \Inc\Api\SettingsApi;
use \Inc\Api\Callbacks\AdminCallbacks;
class Admin
{
    public $settings;
    public $pages=array();  
    public $subpages=array();
    public $callbacks;
    //Initialize Admin Dashboard and Page
    public function register()
    {
        // add_action('admin_menu',array($this,'add_admin_pages'));
        $this->settings=new SettingsApi();
        $this->callbacks=new AdminCallbacks();
        $this->SetPages();
        $this->SetSubpages();
        $this->settings->AddPages($this->pages)->withSubPage('Dashboard')->addSubPages($this->subpages)->register();
        
    }
    public function SetPages()
    {
        $this->pages=array
        (
            array
            (
            'page_title'=>'Dashboard',
            'menu_title'=>'Ask Portal',
            'capability'=>'manage_options',
            'menu_slug'=>'Ask_Portal',
            'callback'=>array($this->callbacks,'admin_dashboard'),
            'icon_url'=>'dashicons-table-row-after',
            'position'=>11,
            )
        );
    }
    public function SetSubpages()
    {
        $this->subpages=array
        (
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Show Leads',
            'menu_title'=>'Show Leads',
            'capability'=>'manage_options',
            'menu_slug'=>'show_leads',
            'callback'=>array($this->callbacks,'show_leads'),
            'position'=>1
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Add Leads',
            'menu_title'=>'Add Leads',
            'capability'=>'manage_options',
            'menu_slug'=>'add_leads',
            'callback'=>array($this->callbacks,'add_leads'),
            'position'=>2
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Update Leads',
            'menu_title'=>'Update Leads',
            'capability'=>'manage_options',
            'menu_slug'=>'Update_leads',
            'callback'=>array($this->callbacks,'update_leads'),
            'position'=>3
            ),
        );
    }
    // public function add_admin_pages()
    // {
    //     add_menu_page("Dashboard","AskPortal",'manage_options',"Dashboard",array($this,'admin_dashboard'),'dashicons-table-row-after
    //     ',2);
    // }
    // public function admin_dashboard()
    // {
    //     // require_once $this->plugin_url."/templates/show_leads.php";
    //     // echo $this->plugin_url."/templates/show_leads.php";
    //     show_leads::heading();
    //     // $leads=new show_leads();
    //     // $leads.heading();
    // }
}