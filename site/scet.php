<?php 
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : site/scet.php (Joomla-Entry-File)                     //
// @implements  :                                                       //
// @description : Main-Frontend-Entry-File for the SCET-Component       //
// Version      : 3.0.0                                                //
// *********************************************************************//

defined('_JEXEC') or die('Restricted access'); 
define('_SCET_VERSION','3.0.0');

// import joomla controller library
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by scet
$controller = JControllerLegacy::getInstance('scet');
 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();
?>
