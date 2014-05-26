<?php
// *********************************************************************//
// Project      : scet for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/helpers/scet.php (General-Helper-Class)         //
// @implements  : Class scetHelper                                      //
// @description : General HelperClass for the scet-Component            //
// Version      : 3.0.0                                                //
// *********************************************************************//
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

class scetHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string	The name of the active view.
	 *
	 * @return  void
	 * @since   1.6
	 */
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_SCET_SUBMENU_CATEGORIES'),
			'index.php?option=com_scet&view=categories',
			$vName == 'categories'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_SCET_SUBMENU_EVENTS'),
			'index.php?option=com_scet&view=events',
			$vName == 'events'
		);
	}
}