<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageDbgSudo extends PageBase
{
	public function __construct() {
		$this->mPageUseRight = "diagnostic-sudo";
        $this->mIsSpecialPage = true;
	}

	protected function runPage() {
        if( WebRequest::wasPosted() ) {
            Session::destroy();
            Session::start();
            
            Session::setLoggedInUser( User::getByName( WebRequest::postString( "username" ) )->getId() );
            
            // grant the user we switched to this right.
            Session::addSessionRight( "diagnostic-sudo" );
            
            global $cScriptPath;
            $this->mHeaders[] = "Location: " . $cScriptPath;
            $this->mIsRedirecting = true;
        } else {
            $this->mBasePage = "webmaster/sudo.tpl";
            
            $usernames = array();
            foreach (User::getArray() as $k => $v)
            {
                $usernames[] = "\"" . htmlentities($v->getUsername()) . "\"";
            }  
            
            $this->mSmarty->assign("jsuserlist", "[" . implode(",", $usernames ) . "]" );
        }
	}
}
