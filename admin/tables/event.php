<?php
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/tables/event.php                                //
// @implements  : Class SCETTableEvent                                  //
// @description : Table-Structure-Class of the Event-Table              //
// Version      : 2.5.8                                                 //
// *********************************************************************//

// no direct access to this file
defined('_JEXEC') or die('Restricted access');

class SCETTableEvent extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(& $_db) {
		parent::__construct('#__scet_events', 'id', $_db);
	}
}

?>
   