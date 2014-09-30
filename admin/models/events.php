<?php
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/models/events.php                               //
// @implements  : Class ScetModelEvents                                 //
// @description : Model for the DB-Manipulation of the                  //
//                SCET-Event-List                                       //
// Version      : 3.0.2                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted Access' );
jimport( 'joomla.application.component.modellist' );

class SCETModelEvents extends JModelList
{
    /**
     * Constructor.
     *
     * @param array	An optional associative array of configuration settings.
     * @see		JController
     * @since	1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array('id', 'event', 'category', 'public', 'publicity', 'published', 'mandatory', 'datum', 'uhrzeit' );
        }
        parent::__construct($config);
    }


	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	protected function getListQuery()
	{
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);

        // Select some fields
        $query->select('event.id, event, rule, category, datum, uhrzeit, publicevent, event.published, fk_category, location, mandatory, inserted, updated, category.ordering');
        // From the SCET table
        $query->from('#__scet_events as event');
        $query->join('LEFT', '#__scet_categories AS category ON ( event.fk_category = category.id ) ');

        //Search
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $search = $db->Quote('%'.$db->escape($search, true).'%', false);
            $query->where('(event LIKE '.$search.' OR category LIKE '.$search.' OR location LIKE '.$search.')');
        }

        // Filter by published state
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('event.published = '.(int) $published);
        }

        // Filter by Category
        $category = $this->getState('filter.category');
        if (is_numeric($category)) {
            $query->where('fk_category = '.(int) $category);
        }

        // Filter by Publicity
        $publicity = $this->getState('filter.publicity');
        if (is_numeric($publicity)) {
            $query->where('event.publicevent = '.(int)$publicity);
        }

        // Filter by Mandatority
        $mandatority = $this->getState('filter.mandatority');
        if (is_numeric($mandatority)) {
            $query->where('event.mandatory = '.(int)$mandatority);
        }

        //Add the list ordering clause.
        $orderCol  = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if (empty($orderCol)){
            $orderCol  = 'category.ordering, category, event.datum, event.uhrzeit';
            $orderDirn = 'ASC';
        }
        $query->order($db->escape($orderCol.' '.$orderDirn));

        return $query;
	}


    protected function populateState($ordering = null, $direction = null)
    {
        $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
        $this->setState('filter.state', $state);

        $category = $this->getUserStateFromRequest($this->context.'.filter.category', 'filter_category', '');
        $this->setState('filter.category', $category);

        $publicity = $this->getUserStateFromRequest($this->context.'.filter.publicity', 'filter_publicity', '');
        $this->setState('filter.publicity', $publicity);

        $mandatority = $this->getUserStateFromRequest($this->context.'.filter.mandatority', 'filter_mandatority', '');
        $this->setState('filter.mandatority', $mandatority);

        // List state information.
        parent::populateState('category.ordering, category, datum, uhrzeit', 'ASC');
    }


}
?>