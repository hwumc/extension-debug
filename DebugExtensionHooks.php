<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class DebugExtensionHooks
{
	public static function buildPageSearchPaths($args)
	{
        $paths = $args[0];
        $paths[] = dirname(__FILE__) . "/Page/";
		return $paths;
	}
}