<?php
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/controller.php (General-Controller-File)        //
// @implements  : Class SCET-Controller                                 //
// @description : General (Main-)Controller for the SCET-Component      //
// Version      : 2.5.17                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

// import Joomla controller library
jimport( 'joomla.application.component.controller' );

class SCETController extends JControllerLegacy
{
	function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'Events'));
 
		// call parent behavior
		parent::display($cachable);	}

}
