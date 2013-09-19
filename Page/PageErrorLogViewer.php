<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageErrorLogViewer extends PageBase
{
	public function __construct() {
		$this->mPageUseRight = "diagnostic-errorlog";
		$this->mMenuGroup = "Diagnostics";
	}

	protected function runPage() 
    {
        global $cFilePath, $cScriptPath;

        if(WebRequest::wasPosted()) 
        {
            $keys = WebRequest::getPostKeys();
            foreach( $keys as $k )
            {
                $fa = explode("_", $k);
                $f = $fa[0] . "." . $fa[1] . "_" . $fa[2];
                
                $file = $cFilePath . "/errorlog/" . str_replace("/", "", $f);
                
                if( file_exists( $file ) )
                {
                    unlink( $file );
                }
            }
            
            $this->mHeaders[] = "Location: " . $cScriptPath . "/ErrorLogViewer";
            return;
        }
        
        $files = array();
        if ($handle = opendir($cFilePath . "/errorlog")) {
            while (false !== ($entry = readdir($handle))) {
                
                if($entry == ".") continue;
                if($entry == "..") continue;
                if($entry == "index.php") continue;
                
                $files[] = $entry;
            }
            closedir($handle);
        }
        
        $exlist = array(); 
        foreach ($files as $f)
        {
            $contents = file_get_contents( $cFilePath . "/errorlog/" . $f );
            $ex = unserialize( $contents );
            list($ts, $session) = explode("_", $f, 2);
            list($date, $mt) = explode(".", $ts, 2);
            
            $exlist[ $f ] = array(
                'date' => date("Y-m-d H:i:s", $date),
                'session' => $session,
                'exception' => $ex,
                'type' => get_class($ex)
                );
        }
        
		$this->mSmarty->assign( "exceptionlist", $exlist );
        $this->mBasePage = "diagnostics/errorlog.tpl";
	}
}
