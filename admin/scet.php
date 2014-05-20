<?php
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/scet.php (Joomla-Entry-File)                    //
// @implements  :                                                       //
// @description : Main-Backend-Entry-File for the SCET-Component        //
// Version      : 2.5.23                                                //
// *********************************************************************//
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
define('_SCET_VERSION','2.5.23');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
// for Joomla 3 Compatibility
if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}  
// Get an instance of the controller prefixed by Games
$controller = JControllerLegacy::getInstance('SCET');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();
?>