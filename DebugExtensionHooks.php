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
    
    public static function smartySetup($args)
    {
        $smarty = $args[0];
        
        $smarty->addTemplateDir(dirname(__FILE__) . "/Templates/");
        
        return $smarty;
    }
    
    public static function addNavBarMenuItems( $menu ) {
        global $cScriptPath;
        
        $currentUser = User::getLoggedIn();
        
		$menu = $menu[0];
		
        if( !isset($menu['debugging']) &&
                (
                    $currentUser->isAllowed("diagnostic")
                    || $currentUser->isAllowed("diagnostic-sudo")
                    || $currentUser->isAllowed("diagnostic-badbehaviour")
                    || $currentUser->isAllowed("diagnostic-errorlog")
                )
            )
        {
            $menu['debugging'] = array();
        }
        
        if( $currentUser->isAllowed("diagnostic-sudo") )
        {   
            if( !isset($menu['debugging']['sudo']) )
            {
                $menu['debugging']['sudo'] = array();
            }
            
            $menu['debugging']['sudo']['sudo'] = array(
                "displayname" => "page-dbgsudo",
                "link" => $cScriptPath . "/DbgSudo",
                "icon" => "icon-warning-sign"
                );
        }
        
        if( $currentUser->isAllowed("diagnostic-badbehaviour") )
        {
            if( !isset($menu['debugging']['badbehaviour']) )
            {
                $menu['debugging']['badbehaviour'] = array();
            }
            
            $menu['debugging']['badbehaviour']['exception'] = array(
                "displayname" => "page-dbgthrowexception",
                "link" => $cScriptPath . "/DbgThrowException",
                "icon" => "icon-fire"
                );
            
            $menu['debugging']['badbehaviour']['accessdenied'] = array(
                "displayname" => "page-dbgaccessdenied",
                "link" => $cScriptPath . "/DbgAccessDenied",
                "icon" => "icon-fire"
                );
        }
        
        if( $currentUser->isAllowed("diagnostic") )
        {
            if( !isset($menu['debugging']['page']) )
            {
                $menu['debugging']['page'] = array();
            }
            
            if( !isset($menu['debugging']['user']) )
            {
                $menu['debugging']['user'] = array();
            }
            
            if( !isset($menu['debugging']['smarty']) )
            {
                $menu['debugging']['smarty'] = array();
            }
            
            if( !isset($menu['debugging']['info']) )
            {
                $menu['debugging']['info'] = array();
            }
            
            $menu['debugging']['page']['allpages'] = array(
                "displayname" => "page-dbgallpagelist",
                "link" => $cScriptPath . "/DbgAllPageList",
                "icon" => "icon-file"
                );
            
            $menu['debugging']['page']['page'] = array(
                "displayname" => "page-dbgpagelist",
                "link" => $cScriptPath . "/DbgPageList",
                "icon" => "icon-file"
                );
            
            $menu['debugging']['user']['allright'] = array(
                "displayname" => "page-dbgallrightlist",
                "link" => $cScriptPath . "/DbgAllRightList",
                "icon" => "icon-check"
                );
            
            $menu['debugging']['user']['rightlist'] = array(
                "displayname" => "page-dbgrightlist",
                "link" => $cScriptPath . "/DbgRightList",
                "icon" => "icon-check"
                );
            
            $menu['debugging']['user']['group'] = array(
                "displayname" => "page-dbggrouplist",
                "link" => $cScriptPath . "/DbgGroupList",
                "icon" => "icon-user"
                );
            
            $menu['debugging']['smarty']['templates'] = array(
                "displayname" => "page-dbgsmartytemplates",
                "link" => $cScriptPath . "/DbgSmartyTemplates",
                "icon" => "icon-folder-open"
                );
            
            $menu['debugging']['smarty']['clean'] = array(
                "displayname" => "page-dbgsmartyclean",
                "link" => $cScriptPath . "/DbgSmartyClean",
                "icon" => "icon-folder-open"
                );
            
            $menu['debugging']['info']['phpinfo'] = array(
                "displayname" => "page-phpinfo",
                "link" => $cScriptPath . "/PhpInfo",
                "icon" => "icon-certificate"
                );
        }
        
        if( $currentUser->isAllowed("diagnostic-errorlog") )
        {
            if( !isset($menu['debugging']['info']) )
            {
                $menu['debugging']['info'] = array();
            }

            $menu['debugging']['info']['errorlog'] = array(
                "displayname" => "page-errorlogviewer",
                "link" => $cScriptPath . "/ErrorLogViewer",
                "icon" => "icon-exclamation-sign"
                );
        }

        
        return $menu;
	}
}