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
