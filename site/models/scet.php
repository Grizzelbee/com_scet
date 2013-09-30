<?php 
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : site/models/scet.ph  p                                //
// @implements  : Class ScetModelSCET                                   //
// @description : Model for the DB-Manipulation of the                  //
//                SCET-Event-List                                       //
// Version      : 2.5.19                                                //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport( 'joomla.application.component.model' ); 

class SCETModelSCET extends JModelLegacy 
{ 
    function getCategories() 
    { 
        $db = JFactory::getDBO(); 
        $query = 'select * from #__scet_categories as Categories where published = 1 order by ordering'; 
        $db->setQuery( $query ); 
        $rows = $db->loadObjectList(); 
        return $rows; 
    } 

    function getEvents() 
    { 
        $db = JFactory::getDBO(); 
        $query= "SELECT event,
                        CASE
                            WHEN anniversary = 1 THEN DATE(CONCAT(YEAR(CURRENT_DATE), '-', MONTH(datum), '-', DAY(datum)) )
                            ELSE datum
                        END AS datum,
                        rule,
                        uhrzeit,
                        location,
                        mandatory,
                        inserted,
                        updated,
                        publicevent,
                        anniversary,
                        fk_category,
                        CASE
                            WHEN anniversary = 1 then YEAR(CURRENT_DATE) - YEAR(datum) 
                            ELSE 0
                        END AS iteration
                FROM    #__scet_events
                WHERE   published = 1
                ORDER BY fk_category, datum ASC, uhrzeit ASC";
        $db->setQuery( $query ); 
        $rows = $db->loadObjectList(); 
        return $rows; 
    } 

    function getLastUserVisitDate( $userid ) 
    { 
        $db = JFactory::getDBO(); 
        $query = "select * from #__scet_visits as visits where juserid = $userid"; 
        $db->setQuery( $query ); 
        $rows = $db->loadObjectList(); 
        return $rows; 
    } 
        
    function setLastUserVisitDate($isNewUser, $lastVisit) 
    { 
        $db = JFactory::getDBO(); 
        if ($isNewUser) {
            $db->insertObject('#__scet_visits', $lastVisit, 'id');
        } else {
            $db->updateObject('#__scet_visits', $lastVisit, 'id');
        };
    } 
        
} 
?>