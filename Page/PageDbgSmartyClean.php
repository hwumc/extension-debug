<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageDbgSmartyClean extends PageBase
{
	public function __construct() {
		$this->mPageUseRight = "diagnostic";
        $this->mIsSpecialPage = true;
	}

	protected function runPage() 
    {
        global $cFilePath, $cScriptPath;

        $files = array();
        if ($handle = opendir($cFilePath . "/templates_c")) {
            while (false !== ($entry = readdir($handle))) {
                
                if($entry == ".") continue;
                if($entry == "..") continue;
                
                $files[] = $entry;
            }
            closedir($handle);
        }
        
        if(WebRequest::wasPosted()) 
        {
            foreach( $files as $k )
            {
                
                $file = $cFilePath . "/templates_c/" . $k;
                
                if( file_exists( $file ) )
                {
                    unlink( $file );
                }
            }
            
            $this->mHeaders[] = "Location: " . $cScriptPath . "/DbgSmartyClean";
            $this->mIsRedirecting = true;
            return;
        }

        $this->mSmarty->assign("files", $files);
        $this->mBasePage = "diagnostics/smartyclean.tpl";
	}
}
