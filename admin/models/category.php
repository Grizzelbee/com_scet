<?php 
// *********************************************************************//
// Project      : scet for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/models/category.php                             //
// @implements  : Class scetModelCategory                               //
// @description : Model for the DB-Manipulation of a single             //
//                scet-Category; not for the list                       //
// Version      : 2.5.19                                                //
// *********************************************************************//
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport( 'joomla.application.component.modeladmin' );

class scetModelCategory extends JModelAdmin
{
   	var $_categories = null;

    
    /**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
    public function getTable($type = 'Category', $prefix = 'scetTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
    
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
        $form = $this->loadForm(
                'com_scet.category', 
                'category', 
                 array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }
     
        return $form;
	}	
     
    /**
     * Method to get the data that should be injected in the form.
     *
     * @return      mixed   The data for the form.
     * @since       1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_scet.edit.category.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
            if ($data->ordering == 0)
            {
                $data->ordering = $this->getNextOderingNr();
            }
        }
        return $data;	
    }
    
    
	function getCategories()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_categories ))
		{
			$query             = 'SELECT id, name, published, ordering FROM #__scet_categories';
			$this->_categories = $this->_getList( $query );
		}
		return $this->_categories;
	}
    
    function getNextOderingNr()
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('max(ordering)');
        $query->from('#__scet_categories');
		$db->setQuery( $query );
		$maxOrdering = $db->loadResult();

		return ($maxOrdering + 1)  ;
	}
    
    
    public function setDBField($fieldname, $state, $cids)
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        
        $query->update('#__scet_categories');
        $query->set($fieldname .' = '.$state);
        $query->where('id in ('.implode($cids, ',').')');
        
        $db->setQuery($query);
        $db->query();
        
        return $db->getAffectedRows();
    }    
    
    
}
?>