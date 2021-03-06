<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageDbgThrowException extends PageBase
{
	public function __construct() {
		$this->mPageUseRight = "diagnostic-badbehaviour";
        $this->mIsSpecialPage = true;
		$this->mBasePage = "blank.tpl";
	}

	protected function runPage() {
		throw new WeirdWonderfulException();
	}
}
