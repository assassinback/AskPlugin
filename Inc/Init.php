<?php
/**
 * @package Ask_Portal
 */
namespace Inc;

final class Init
{
    //store and return all classes in an array
    public static function get_services()
    {
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class
        ];
    }
    //loop through classes and call register method if it exists
    public static function register_services()
    {
        foreach(self::get_services() as $class)
        {
            $service=self::instantiate($class);
            if(method_exists($service,"register"))
            {
                $service->register();
            }
        }
    }
    //initialize the class
    private static function instantiate($class)
    {
        // $service=new $class();
        return new $class();
    }
}
// use Inc\Base\Activate;
// use Inc\Base\Deactivate;
// use Inc\Admin\AdminPages;
// use Templates\show_leads;
// // new Deactivate().test();
// // echo __DIR__ . '/../..' . '/inc';
// // $vendorDir = dirname(__DIR__);
// // $baseDir = dirname($vendorDir);
// // echo $baseDir;
// //class
// if(!class_exists("ask_portal"))
// {
//     class ask_portal
//     {
//         public $plugin_name;
//         //make constructor
//         function __construct()
//         {
//             add_action("init",array($this,"custom_post_type"));
//             $this->plugin_name=plugin_basename(__FILE__);
//         }
//         //enqueue scripts
//         public function register()
//         {
//             add_action("admin_enqueue_scripts",array($this,'enqueue'));
//             add_action('admin_menu',array($this,'add_admin_pages'));
//             add_filter("plugin_action_links_$this->plugin_name",array($this,'settings_link'));
//         }
//         public function settings_link($links)
//         {
//             $settings_link="<a href='admin.php?page=Dashboard'>Settings</a>";
//             array_push($links,$settings_link);
//             return $links;
//         }
//         public function add_admin_pages()
//         {
//             add_menu_page("Dashboard","AskPortal",'manage_options',"Dashboard",array($this,'admin_dashboard'),'dashicons-table-row-after
//             ',2);
//         }
//         public function admin_dashboard()
//         {
//             // require_once plugin_dir_path(__FILE__)."templates/show_leads.php";
//             show_leads::heading();
//             // $leads=new show_leads();
//             // $leads.heading();
//         }
//         //create custom post type
//         public function custom_post_type()
//         {
//             register_post_type("Portal",['public'=>true,'label'=>"Portal"]);
//         }
//         //enqueue scripts
//         public function enqueue()
//         {
//             wp_enqueue_style("plugin_style",plugins_url("/assets/style.css",__FILE__));
//             wp_enqueue_script("plugin_style",plugins_url("/assets/script.js",__FILE__));
//         }
//     }
// }

// //create instance
// if(class_exists("ask_portal"))
// {
//     $portal_info=new ask_portal();
//     $portal_info->register();
// }
// //activate
// // require_once plugin_dir_path(__FILE__)."inc/Activate.php";
// register_activation_hook(__FILE__,array("Inc\Base\Activate","activate"));

// //deactivate
// // require_once plugin_dir_path(__FILE__)."inc/ask_portal_deactivate.php";
// register_deactivation_hook(__FILE__,array("Inc\Base\Deactivate","deactivate"));