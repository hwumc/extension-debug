<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class DebugExtension extends Extension
{
	public function getExtensionInformation()
	{
		return array(
			"name" => "Debugging Tools",
			"gitviewer" => "https://gerrit.stwalkerster.co.uk/gitweb?p=siteframework/extensions/debug.git;a=tree;h=",
			"description" => "Debugging utilities for siteframework",
			"filepath" => dirname(__FILE__),
		);
	}
	
	protected function autoload( $class )
	{
		$files = array(
			"DebugExtensionHooks" => "DebugExtensionHooks.php",
		);
		
		return $files[$class];
	}
	
	protected function registerHooks()
	{
		Hooks::register( "BuildPageSearchPaths", array("DebugExtensionHooks","buildPageSearchPaths"));
	}
	

}