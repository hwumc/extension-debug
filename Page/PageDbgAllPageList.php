<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageDbgAllPageList extends PageBase
{
	public function __construct() {
		$this->mPageUseRight = "diagnostic";
        $this->mIsSpecialPage = true;
	}

	protected function runPage() {
		$this->mSmarty->assign( "content", "<pre>" . print_r( PageBase::getAllPages(), true ) . "</pre>" );
	}
}
