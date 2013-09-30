<?php
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/views/event/view.html.php                       //
// @implements  : Class SCETViewEvent                                   //
// @description : Main-entry for the single event-View                  //
// Version      : 2.5.19                                                //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted Access!');
jimport( 'joomla.application.component.view' );

class SCETViewEvent extends JViewLegacy
{
	/**
	 * display method of Hello view
	 * @return void
	 **/
	function display($tpl = null)
	{
		$this->form    = $this->get( 'Form' );
        $this->item    = $this->get( 'Item' );
		$isNew	        = ($this->item->id == 0);

        $this->AddToolBar($isNew);
        
		parent::display($tpl);
	}
    
    protected function AddToolBar($isNew)
    {
		$text = $isNew ? JText::_( 'COM_SCET_NEW' ) : JText::_( 'COM_SCET_EDIT' );
        JHtml::stylesheet('com_scet/views.css', array(), true, false, false);
		JToolBarHelper::title( JText::_( 'COM_SCET_HEAD_SCET_EVENTS_MANAGER' ).': <small>[ ' . $text.' ]</small>', 'kalender' );
        JToolBarHelper::apply('event.apply');
        JToolBarHelper::save2new('event.save2new');
		JToolBarHelper::save('event.save');
		JToolBarHelper::cancel('event.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
    }
    
    
}
