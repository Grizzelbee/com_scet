<?php 
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/views/events/view.html.php                      //
// @implements  : Class ScetViewEvents                                  //
// @description : Main-entry for the event-Listview                     //
// Version      : 2.5.18                                                //
// *********************************************************************//

// no direct access to this file
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view'); 

class SCETViewEvents extends JViewLegacy
{ 
    function display($tpl = null) 
    {
        // Add Toolbat to View
        $this-> addToolbar();
        
        // Get data from the model
        $this->pagination = $this->get( 'Pagination' );
        $this->items	  = $this->get( 'Items' );
        $this->state      = $this->get( 'State' );

        // Get order state
        $this->listOrder = $this->escape($this->state->get( 'list.ordering'  ));
        $this->listDirn  = $this->escape($this->state->get( 'list.direction' ));
        
        // include custom fields
        require_once JPATH_COMPONENT .'/models/fields/categories.php';
        require_once JPATH_COMPONENT .'/models/fields/publicity.php';
        require_once JPATH_COMPONENT .'/models/fields/mandatority.php';
        
        parent::display($tpl); 
    } 

    function addToolbar()
    {
        // Set Headline
        JHtml::stylesheet('com_scet/views.css', array(), true, false, false);
        JToolBarHelper::title( JText::_('COM_SCET_HEAD_SCET_EVENTS_MANAGER'), 'kalender' );
        // Toolbar-Buttons
        JToolBarHelper::addNew('event.add');
        JToolBarHelper::editList('event.edit');
        JToolBarHelper::deleteList('COM_SCET_DELETE_QUESTION', 'events.delete');
        JToolBarHelper::divider();
        JToolBarHelper::publishList('events.publish');
        JToolBarHelper::unpublishList('events.unpublish');
        JToolBarHelper::divider();
        JToolBarHelper::preferences('com_scet');
    }

} 
?>