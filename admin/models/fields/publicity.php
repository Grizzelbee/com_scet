<?php
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/models/fields/publicity.php                     //
// @implements  : Class JFormFieldPublicity                             //
// @description : Field to select the publicity status in SCET          //
// Version      : 2.5.8                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
 
JFormHelper::loadFieldClass('list');
 
/**
 * categories Field
 *
 * @since		1.6
 */
class JFormFieldPublicity extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Publicity';
 
	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	public function getOptions()
	{
		$options = array('COM_SCET_UNPUBLIC', 'COM_SCET_PUBLIC');

		return $options;
	}
}
?>