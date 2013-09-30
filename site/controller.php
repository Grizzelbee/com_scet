<?php 
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : site/controller.php                                   //
// @implements  : Class SCETController                                  //
// @description : Main-Controller for SCET                              //
// Version      : 2.5.17                                                //
// *********************************************************************//
    defined( '_JEXEC' ) or die( 'Restricted access' ); 
    jimport('joomla.application.component.controller'); 
    
    class SCETController extends JControllerLegacy { 
    
        function display($cachable = false, $urlparams = false) { 
            parent::display(); 
        } 
    } 
?>