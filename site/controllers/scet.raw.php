<?php
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : site/controllers/scet.raw.php                         //
// @implements  : scetControllerScet                                    //
// @description : Special-Frontend-Controller-File for raw-file d/l     //
//                for the SCET-Component                                //
// Version      : 3.0.4                                                 //
// *********************************************************************//
// No direct access.
defined('_JEXEC') or die( 'Restricted Access' );
// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');
 
class scetControllerScet extends JControllerForm
{
 
    public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, array('ignore_request' => false));
    }
        
    public function getICalFile()
    {
        echo 'function getICalFile()';
        return;
    
       $this->getModel()->getICalFile('event.ics', JRequest::getVar('id'));
    }
 

}
?>