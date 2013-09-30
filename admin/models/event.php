<?php 
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/models/event.php                                //
// @implements  : Class ScetModelEvent                                  //
// @description : Model for the DB-Manipulation of single               //
//                SCET-Events; not for the list                         //
// Version      : 2.5.19                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport( 'joomla.application.component.modeladmin' );

class SCETModelEvent extends JModelAdmin
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
    public function getTable($type = 'Event', $prefix = 'SCETTable', $config = array())
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
                'com_scet.event', 
                'event', 
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
        $data = JFactory::getApplication()->getUserState('com_scet.edit.event.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
            // set INSERTED and UPDATED date
            $data->updated = date( 'Y-m-d H:n', time() ); // Updated = Now!
            if ($data->id == 0) // is new record
            {
                $data->inserted = $data->updated;
            }
        }
        return $data;	
    }
    
    
	function getCategories()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_categories ))
		{
			$query             = 'SELECT id, category from #__scet_categories where published = 1';
			$this->_categories = $this->_getList( $query );
		}
		return $this->_categories;
	}
    
    public function isInstalled($component)
    {
        $db	=    JFactory::getDBO();
        $query = $db->getQuery(true);
        
        $query->select('extension_id');
		$query->from('#__extensions');
		$query->where('element = \''. $component.'\';');
		$db->setQuery( $query );
        $result = $db->loadObject();
       
        return !empty($result);
    }
    
    public function getMailReceipients()
    {
        $db	=& JFactory::getDBO();
        $query = $db->getQuery(true);
        
        $query->select('email_priv, vorname');
		$query->from('#__jschuetze_mitglieder');
		$query->where('scet_mail_notification = 1');
		$db->setQuery( $query );

        return $db->loadObjectList();
    }
    
    public function sendMailNotification($data)
    {
        $mailer      = JFactory::getMailer();
        $config      = JFactory::getConfig();
        $sender      = array( $config->get( 'config.mailfrom' ), $config->get( 'config.fromname' ) );
        $receipients = $this->getMailReceipients();
        $params      = JComponentHelper::getParams('com_scet');
        $mailer->setSender($sender);
        $textmarken = array("[Termin]", "[Datum]", "[Uhrzeit]", "[Ort]", "[Pflicht]", "%s", "%d.", "%d");
        $daten      = array($data['event'], date('d.m.Y', strtotime($data['datum'])), $data['uhrzeit'], $data['location']==''?JText::_('COM_SCET_NA'):$data['location'], ($data['mandatory']==0?JText::_('JNO'):JText::_('JYES')), "", "", "");

        if ($data['id'] == 0){
            $mailer->setSubject($params->get('new_subject'));
            $body = str_replace( $textmarken, $daten, $params->get('new_mailbody') ) ;
        } else {
            $mailer->setSubject($params->get('changed_subject'));
            $body = str_replace( $textmarken, $daten, $params->get('changed_mailbody') ) ;
        }
        
        $successful = 0;
        foreach($receipients as $receipient):
            $mailer->ClearAllRecipients();
            $mailer->addRecipient( $receipient->email_priv );

            $mailbody = str_replace('[Vorname]', $receipient->vorname, $body);
            $mailer->setBody($mailbody);
     
            $send = $mailer->Send();
            if ( $send )
            {
                $successful++;
            }
        endforeach;
        if ( $successful == 1 ) {
            JFactory::getApplication()->enqueueMessage( JText::_('COM_SCET_SINGLE_MAIL_SENT') );
        } else {
            JFactory::getApplication()->enqueueMessage(sprintf(JText::_('COM_SCET_MAIL_SENT'), $successful ) );
        }
        
    }
    
    
    public function save($array)
    {
        if ($this->isInstalled('com_jschuetze')) {
            $this->sendMailNotification($array);
        }
        
        return parent::save($array);
    }
    
    public function setDBField($fieldname, $state, $cids)
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        
        $query->update('#__scet_events');
        $query->set($fieldname .' = '.$state);
        $query->where('id in ('.implode($cids, ',').')');
        
        $db->setQuery($query);
        $db->query();
        
        return $db->getAffectedRows();
    }
    
}
?>