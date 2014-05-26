<?php 
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/views/event/tmpl/edit.php                       //
// @implements  :                                                       //
// @description : Template for the single event Edit-View               //
// Version      : 3.0.0                                                //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access'); 
JHtml::_('behavior.tooltip'); 
JHtml::_('behavior.keepalive'); 
$url = 'index.php?option=com_scet&layout=edit&id='; 
?> 
<form action="<?php echo JRoute::_($url.(int) $this->item->id); ?>"method="post" name="adminForm" id="adminForm">      
    <div class="span10 form-horizontal">
        <fieldset class="adminform">  
            <legend><?php echo JText::_('COM_SCET_DETAILS'); ?></legend>         
                <?php foreach($this->form->getFieldset() as $field): ?>             
                    <div class="control-label">
                        <?php echo $this->form->getLabel($field->fieldname); ?>
                    </div>
                    <div class="controls">
                        <?php echo $this->form->getInput($field->fieldname); ?>
                    </div>
                    <br />
                <?php endforeach; ?>         
        </fieldset>
    </div>
    <div>         
        <input type="hidden" name="task" value="scet.edit" />         
        <?php echo JHtml::_('form.token'); ?>     
    </div> 
</form>