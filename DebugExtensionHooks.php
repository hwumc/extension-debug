<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class DebugExtensionHooks
{
	public static function buildPageSearchPaths($args)
	{
		$args[0][] = dirname(__FILE__) . "/Page/";
		return $args;
	}
}