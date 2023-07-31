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
        $this->settings=new SettingsApi();
        $this->callbacks=new AdminCallbacks();
        $this->SetPages();
        $this->SetSubpages();
        $this->setSettings();
        $this->setSections();
        $this->setFields();
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
    public function setSettings()
    {
        $args=array(
            array(
                'option_group'=>'portal_options_group',
                'option_name'=>'show_leads',
                'callback'=>array($this->callbacks,'askOptionsGroup')
            )
        );
        $this->settings->addSettings($args);
    }
    public function setSections()
    {
        $args=array(
            array(
                'id'=>'portal_admin_index',
                'title'=>'Settings',
                'callback'=>array($this->callbacks,'askAdminSection'),
                'page'=>'Ask_Portal',
            )
        );
        $this->settings->addSection($args);
    }
    public function setFields()
    {
        $args=array(
            array(
                'id'=>'show_leads',
                'title'=>'Show Leads',
                'callback'=>array($this->callbacks,'askTextExample'),
                'page'=>'Ask_Portal',
                'section'=>'portal_admin_index',
                'args'=>array(
                    'label_for'=>'text_example',
                    'class'=>'example-class'
                    )
            )
        );
        $this->settings->addFields($args);
    }
}