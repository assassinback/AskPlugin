<?php
/**
 * @package Ask_Portal
 */
namespace Inc;
//Activate Plugin
class Activate
{
    public static function activate()
    {
        flush_rewrite_rules();
    }
}