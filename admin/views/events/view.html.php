<?php
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/views/events/view.html.php                      //
// @implements  : Class ScetViewEvents                                  //
// @description : Main-entry for the event-Listview                     //
// Version      : 3.0.0                                                //
// *********************************************************************//

// no direct access to this file
defined('_JEXEC') or die( 'Restricted Access' );
jimport('joomla.application.component.view');

class SCETViewEvents extends JViewLegacy
{
    function display($tpl = null)
    {
        // Get data from the model
        $this->pagination = $this->get( 'Pagination' );
        $this->items	  = $this->get( 'Items' );
        $this->state      = $this->get( 'State' );

        // Get order state
        $this->listOrder = $this->escape($this->state->get( 'list.ordering'  ));
        $this->listDirn  = $this->escape($this->state->get( 'list.direction' ));
        $this->saveorder = $this->listOrder == 'ordering';

        // include custom fields
        require_once JPATH_COMPONENT .'/models/fields/categories.php';
        require_once JPATH_COMPONENT .'/models/fields/publicity.php';
        require_once JPATH_COMPONENT .'/models/fields/mandatority.php';

        // Add Toolbar to View
        scetHelper::addSubmenu('events');
        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();

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

        JHtmlSidebar::setAction('index.php?option=com_scet');

        // category
        JHtmlSidebar::addFilter(
        JText::_('COM_SCET_CHOOSE_CATEGORY'),
        'filter_category',
        JHtml::_('select.options', JFormFieldCategories::getOptions(), 'value', 'text', $this->state->get('filter.category'), true)
        );
        // state
        JHtmlSidebar::addFilter(
        JText::_('JOPTION_SELECT_PUBLISHED'),
        'filter_state',
        JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
        );
        // publicity
        JHtmlSidebar::addFilter(
        JText::_('COM_SCET_SELECT_PUBLICITY'),
        'filter_publicity',
        JHtml::_('select.options', JFormFieldPublicity::getOptions(), 'value', 'text', $this->state->get('filter.publicity'), true)
        );
        // mandatority
        JHtmlSidebar::addFilter(
        JText::_('COM_SCET_SELECT_MANDATORITY'),
        'filter_mandatority',
        JHtml::_('select.options', JFormFieldMandatority::getOptions(), 'value', 'text', $this->state->get('filter.mandatority'), true)
        );

    }

    protected function getSortFields()
    {
     	return array(
       			'ordering' => JText::_('JGRID_HEADING_ORDERING'),
       			'published' => JText::_('JSTATUS'),
       			'id' => JText::_('JGRID_HEADING_ID')
       	);
    }

}
?>