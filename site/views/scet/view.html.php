<?php 
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_SCET                                              //
// @file        : site/views/scet/view.html.php                         //
// @implements  : Class SCETViewSCET                                    //
// @description : Entry-File for the SCET-Standard-View                 //
// Version      : 2.5.17                                                //
// *********************************************************************//

defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view'); 

class SCETViewSCET extends JViewLegacy { 

    function display($tpl = null) { 
        $app              = JFactory::getApplication();
        // Get the parameters
		$this->params     = $app->getParams();
        $this->model      = $this->getModel(); 
        $this->categories = $this->model->getCategories();     
        $this->events     = $this->model->getEvents();
        $this->menu       = $app->getMenu();        
        
        parent::display($tpl); 
    } 

} 

?>