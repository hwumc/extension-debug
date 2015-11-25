<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

/**
 * PageDbgResetPassword short summary.
 *
 * PageDbgResetPassword description.
 *
 * @version 1.0
 * @author stwalkerster
 */
class PageDbgResetPassword extends PageBase
{
    public function __construct() {
        $this->mPageUseRight = "diagnostic-resetpassword";
        $this->mIsSpecialPage = true;
    }

    protected function runPage() {
        if( WebRequest::wasPosted() ) {

            // Check current user password
            $currentUser = User::getLoggedIn();
            if( ! $currentUser->authenticate(WebRequest::post("yourpassword")) ) {
                global $cWebPath;

                Session::appendError("login-invalid");
                $this->mIsRedirecting = true;
                $this->mHeaders[] = "Location: " . $cWebPath . "/index.php/DbgResetPassword";
                
                return;
            }

            // Confirm the user knows what they're setting the password to
            if( WebRequest::post("password") != WebRequest::post("confpassword") ) {
                Session::appendError("Register-error-password-mismatch");
                
                $this->mIsRedirecting = true;
                $this->mHeaders[] = "Location: " . $cWebPath . "/index.php/DbgResetPassword";
                return;
            }

            // idiot check
            if( WebRequest::post( "password" ) == "" || WebRequest::post( "password" ) === false ) {
                Session::appendError("login-nopass");
                
                $this->mIsRedirecting = true;
                $this->mHeaders[] = "Location: " . $cWebPath . "/index.php/DbgResetPassword";
                return;
            }

            // OK, we're good. Current user is who they say they are.

            // Write new password
            $target = User::getByName(WebRequest::post("username"));

            // idiot check
            if( $target === false ) {
                Session::appendError("user-not-found");
                
                $this->mIsRedirecting = true;
                $this->mHeaders[] = "Location: " . $cWebPath . "/index.php/DbgResetPassword";
                return;
            }

            $target->setPassword(WebRequest::post("password"));
            
            // Force the user to change their password on login
            $target->setPasswordReset(1);

            $target->save();

            Session::appendSuccess("resetpass-completed");
            
            $this->mIsRedirecting = true;
            $this->mHeaders[] = "Location: " . $cWebPath . "/index.php/DbgResetPassword";
            return;
            
        } else {
            $this->mBasePage = "webmaster/resetpw.tpl";

            $usernames = array();
            foreach (User::getArray() as $k => $v)
            {
                $usernames[] = "\"" . htmlentities($v->getUsername()) . "\"";
            }  
            
            $this->mSmarty->assign("jsuserlist", "[" . implode(",", $usernames ) . "]" );

        }
    }
}
