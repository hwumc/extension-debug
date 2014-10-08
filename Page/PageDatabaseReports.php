<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageDatabaseReports extends PageBase
{

	public function __construct()
	{
		$this->mPageUseRight = "dbreports-view";
		$this->mMenuGroup = "reports";
		$this->mPageRegisteredRights = array( "dbreports-edit", "dbreports-create", "dbreports-delete" );
		
	}

	protected function runPage()
	{
        global $cAllowUserSqlQueries;
        
		$data = explode( "/", WebRequest::pathInfoExtension() );
		if( isset( $data[0] ) ) {
			switch( $data[0] ) {
				case "edit":
                    if( $cAllowSqlQueries || User::getLoggedIn()->isGod() ) 
                    {
					    $this->editMode( $data );
                    }
                    else
                    {
                        $this->mBasePage = "dbreports/disabled.tpl";
                    }
					return;
					break;
				case "execute":
					$this->executeMode( $data );
					return;
					break;
				case "delete":
                    if( $cAllowSqlQueries || User::getLoggedIn()->isGod() ) 
                    {
					    $this->deleteMode( $data );
                    }
                    else
                    {
                        $this->mBasePage = "dbreports/disabled.tpl";
                    }
					return;
					break;
				case "create":
					if( $cAllowSqlQueries || User::getLoggedIn()->isGod() ) 
                    {
					    $this->createMode( $data );
                    }
                    else
                    {
                        $this->mBasePage = "dbreports/disabled.tpl";
                    }
					return;
					break;
			}
	
		}
		
		// try to get more access than we may have.
		try	{
			self::checkAccess('dbreports-create');
			$this->mSmarty->assign("allowCreate", 'true');
		} catch(AccessDeniedException $ex) { 
			$this->mSmarty->assign("allowCreate", 'false');
		} 
		try {
			self::checkAccess('dbreports-delete');
			$this->mSmarty->assign("allowDelete", 'true');
		} catch(AccessDeniedException $ex) { 
			$this->mSmarty->assign("allowDelete", 'false');
		}
		try {
			self::checkAccess('dbreports-edit');
			$this->mSmarty->assign("allowEdit", 'true');
		} catch(AccessDeniedException $ex) { 
			$this->mSmarty->assign("allowEdit", 'false');
		}
		
        $this->mSmarty->assign( "pagelist", DbReport::getArray() );
		$this->mBasePage = "dbreports/reportlist.tpl";
	}
    
	private function editMode( $data ) {
		self::checkAccess('dbreports-edit');
        
		$g = DbReport::getById( $data[ 1 ] );
        
		if( WebRequest::wasPosted() ) {
            $g->setTitle ( WebRequest::post( "reporttitle" ) );
			$g->setAccessRight( WebRequest::post( "accessright" ) );
            $g->setQuery( WebRequest::post( "query" ) );
			$g->save();            
			
			global $cScriptPath;
			$this->mHeaders[] = ( "Location: " . $cScriptPath . "/DatabaseReports" );
            $this->mIsRedirecting = true;
		} else {
			$rightnames= array();
            foreach (Right::getAllRegisteredRights(true) as $v)
            {
                $rightnames[] = "\"" . $v . "\"";
            }  
            $this->mSmarty->assign( "jsrightslist", "[" . implode(",", $rightnames ) . "]" );
                      
			$this->mBasePage = "dbreports/create.tpl";
			$this->mSmarty->assign( "reporttitle", $g->getTitle() );
			$this->mSmarty->assign( "accessright", $g->getAccessRight() );
            $this->mSmarty->assign( "query", $g->getQuery() );
		}
	}
	
	private function deleteMode( $data ) {
		self::checkAccess( "dbreports-delete" );
        
		if( WebRequest::wasPosted() ) { 
			$g = DbReport::getById( $data[1] );
			if( $g !== false ) {
				if( WebRequest::post( "confirm" ) == "confirmed" ) {
					$g->delete();
					$this->mSmarty->assign("content", "deleted" );
				}
			}
			
			global $cScriptPath;
			$this->mHeaders[] =  "Location: " . $cScriptPath . "/DatabaseReports";
            $this->mIsRedirecting = true;
		} else {
			$this->mBasePage = "dbreports/delete.tpl";
		}
	}
	
	private function createMode( $data ) {
		self::checkAccess( "dbreports-create" );
        
		if( WebRequest::wasPosted() ) {
			$g = new DbReport();
			$g->setTitle( WebRequest::post( "reporttitle" ) );
            $g->setAccessRight( WebRequest::post( "accessright" ) );
            $g->setQuery( WebRequest::post( "query" ) );
			$g->save();
            
			global $cScriptPath;
			$this->mHeaders[] =  "Location: " . $cScriptPath . "/DatabaseReports";
            $this->mIsRedirecting = true;
		} else {
			$rightnames= array();
            foreach (Right::getAllRegisteredRights(true) as $v)
            {
                $rightnames[] = "\"" . $v . "\"";
            }  
            $this->mSmarty->assign( "jsrightslist", "[" . implode(",", $rightnames ) . "]" );
            
			$this->mBasePage = "dbreports/create.tpl";
			$this->mSmarty->assign( "reporttitle", "" );
            $this->mSmarty->assign( "accessright", "dbreports-view" );
            $this->mSmarty->assign( "query", "SELECT 1;");
		}
	}

    private function executeMode( $data ) {        
		$g = DbReport::getById( $data[1] );
		if( $g === false ) {
            return;
        }
        
        self::checkAccess( $g->getAccessRight() );
        
        global $gReadOnlyDatabase;
        
        $statement = $gReadOnlyDatabase->prepare( $g->getQuery() );
        $statement->execute();
        
        $resultset = $statement->fetchAll( PDO::FETCH_ASSOC );
        
        $colcount = $statement->columnCount();
        
        $columns = array();
        for( $i = 0; $i < $colcount; $i++ )
        {
            $columns[] = $statement->getColumnMeta($i);
        }
                
        $this->mSmarty->assign( "columns", $columns );
        $this->mSmarty->assign( "resultset", $resultset );
        $this->mSmarty->assign( "reporttitle", $g->getTitle() );
        
        $this->mBasePage = "dbreports/result.tpl";
    }
}
