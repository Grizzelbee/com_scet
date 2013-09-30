<?php 
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/views/navigation.inc.php                        //
// @implements  :                                                       //
// @description : Code-Snippet for the Menu-Toolbar which is used in    //
//                in the List-Views                                     //
// Version      : 2.5.12                                                //
// *********************************************************************//
// get document to add scripts or StyleSheets
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'media/com_scet/css/views.css');
$viewName = $this->getName();
?>
<div id="navcontainer">
    <ul id="navlist">
        <li<?php if ($viewName == 'categories') echo ' id="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_scet&view=categories'); ?>"><?php echo JText::_( 'COM_SCET_EDIT_CATEGORIES' ); ?></a></li>
        <li<?php if ($viewName == 'events') echo ' id="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_scet&view=events'); ?>"><?php echo JText::_( 'COM_SCET_EDIT_EVENTS' ); ?></a></li>
    </ul>
</div>