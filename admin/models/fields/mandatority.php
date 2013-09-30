<?php
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/models/fields/mandatority.php                   //
// @implements  : Class JFormFieldMandatority                           //
// @description : Field to select the mandatority status in SCET        //
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
class JFormFieldMandatority extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Mandatority';
 
	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	public function getOptions()
	{
		$options = array('COM_SCET_NOT_MANDATORY', 'COM_SCET_MANDATORY');

		return $options;
	}
}