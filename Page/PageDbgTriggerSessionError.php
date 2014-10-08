<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageDbgTriggerSessionError extends PageBase
{
	public function __construct() {
		$this->mPageUseRight = "diagnostic-badbehaviour";
        $this->mIsSpecialPage = true;
	}

	protected function runPage() 
    {        
		Session::appendError("PageDbgTriggerSessionError-test");
	}
}
