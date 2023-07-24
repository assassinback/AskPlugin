<?php
/**
 * @package Ask_Portal
 */
namespace Inc\Base;

//Deactivate Plugin
class Deactivate
{
    public static function deactivate()
    {
        flush_rewrite_rules();
    }
    public function test()
    {
        echo "hi";
    }
}