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
        $this->settings->AddPages($this->pages)->withSubPage('Show Leads')->addSubPages($this->subpages)->register();
        
    }
    public function SetPages()
    {
        $this->pages=array
        (
            array
            (
            'page_title'=>'Show Leads',
            'menu_title'=>'Ask Portal',
            'capability'=>'manage_options',
            'menu_slug'=>'Ask_Portal',
            'callback'=>array($this->callbacks,'show_leads'),
            'icon_url'=>'dashicons-table-row-after',
            'position'=>3,
            )
        );
    }
    public function SetSubpages()
    {
        $this->subpages=array
        (
            // array
            // (
            // 'parent_slug'=>'Ask_Portal',
            // 'page_title'=>'Show Leads',
            // 'menu_title'=>'Show Leads',
            // 'capability'=>'manage_options',
            // 'menu_slug'=>'Ask_Portal',
            // 'callback'=>array($this->callbacks,'show_leads'),
            // 'position'=>1
            // ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Show Inprocess',
            'menu_title'=>'Show Inprocess',
            'capability'=>'manage_options',
            'menu_slug'=>'Show_Inprocess',
            'callback'=>array($this->callbacks,'show_inprocess'),
            'position'=>1
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Show Completed',
            'menu_title'=>'Show Completed',
            'capability'=>'manage_options',
            'menu_slug'=>'Show_Completed',
            'callback'=>array($this->callbacks,'show_completed'),
            'position'=>2
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Add Leads',
            'menu_title'=>'Add Leads',
            'capability'=>'manage_options',
            'menu_slug'=>'add_leads',
            'callback'=>array($this->callbacks,'add_leads'),
            'position'=>3
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Add Inprocess',
            'menu_title'=>'Add Inprocess',
            'capability'=>'manage_options',
            'menu_slug'=>'Add_Inprocess',
            'callback'=>array($this->callbacks,'add_inprocess'),
            'position'=>4
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Add Completed',
            'menu_title'=>'Add Completed',
            'capability'=>'manage_options',
            'menu_slug'=>'Add_Completed',
            'callback'=>array($this->callbacks,'add_completed'),
            'position'=>5
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Add Admins',
            'menu_title'=>'Add Admins',
            'capability'=>'manage_options',
            'menu_slug'=>'Add_Admins',
            'callback'=>array($this->callbacks,'add_admins'),
            'position'=>6
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Add Extra Data',
            'menu_title'=>'Add Extra Data',
            'capability'=>'manage_options',
            'menu_slug'=>'Add_Extra_Data',
            'callback'=>array($this->callbacks,'add_extra_data'),
            'position'=>7
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Show Extra Data',
            'menu_title'=>'Show Extra Data',
            'capability'=>'manage_options',
            'menu_slug'=>'Show_Extra_Data',
            'callback'=>array($this->callbacks,'show_extra_data'),
            'position'=>8
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Show Admins',
            'menu_title'=>'Show Admins',
            'capability'=>'manage_options',
            'menu_slug'=>'Show_Admins',
            'callback'=>array($this->callbacks,'show_admins'),
            'position'=>9
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Follow Up Leads',
            'menu_title'=>'Follow Up Leads',
            'capability'=>'manage_options',
            'menu_slug'=>'Follow_Up_Leads',
            'callback'=>array($this->callbacks,'follow_up_leads'),
            'position'=>10
            ),
            array
            (
            'parent_slug'=>'Ask_Portal',
            'page_title'=>'Follow Up InProcess',
            'menu_title'=>'Follow Up InProcess',
            'capability'=>'manage_options',
            'menu_slug'=>'Follow_Up_InProcess',
            'callback'=>array($this->callbacks,'follow_up_inprocess'),
            'position'=>11
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