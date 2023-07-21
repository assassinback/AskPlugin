<?php
namespace Inc;
/**
 * @package Ask_Portal
 */

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