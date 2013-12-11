<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageDbgAccessDenied extends PageBase
{
	public function __construct() {
		$this->mPageUseRight = "diagnostic-badbehaviour";
		$this->mBasePage = "blank.tpl";
        $this->mIsSpecialPage = true;
	}

	protected function runPage() {
		self::checkAccess("x-denyall");
	}
}
