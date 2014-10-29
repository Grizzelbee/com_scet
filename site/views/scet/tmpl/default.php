<?php
// *********************************************************************//
// Project      : SCET for Joomla                                       //
// @package     : com_scet                                              //
// @file        : site/views/scet/tmpl/default.php (Default SCET-View)  //
// @implements  : Class SCET-Controller                                 //
// @description : Default View for the SCET-Component                   //
// Version      : 3.0.4                                                //
// *********************************************************************//
//Aufruf nur durch Joomla! zulassen
defined('_JEXEC')or die('Restricted access');
JHtml::_('behavior.tooltip');
// get document to add scripts or StyleSheets
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_scet/assets/css/scet.css');
$active = $this->menu->getActive();
?>
<div class="componentheading"><b><?php echo $active->title; ?></b></div>
<div style="float: left; width:100%; vertical-align:middle; padding:0.3em;">
    <?php
    if ( $this->params->get('show_logo') == 1)
    {
    ?>
        <img style="float:right;" src="<?php echo $this->params->get('logo_image'); ?>" alt="" title=""/>
    <?php
    }
    ?>
</div>
<div align="center" style = "clear:both;">
<?php
    $user = JFactory::getUser();
    // Ist der Seitenbetrachter ein Gast, oder ein angemeldeter Benutzer?
   $gast     = $user->guest;
    $language = $user->getParam('language', 'de-DE');
   $now = date('Y-m-d', time() );
    $visits = null;
    // Nur Besuche von registrierten Usern merken - von Gästen ergibt das keinen Sinn
    if (!$gast){
        // letzten Besuch der Seite ermitteln
        $visits = $this->model->getLastUserVisitDate($user->id);
        if (isset($visits[0]->id)) {
            // User war schon mal hier
            $user_lastvisit = $visits[0]->lastvisitdate;
            $visits[0]->lastvisitdate = $now;
            $this->model->setLastUserVisitDate(false, $visits[0]);
        }else {
            // User war noch nie hier
            $user_lastvisit = $now;
            $visits = (object) array("id"=>null, "juserid"=>$user->id, "lastVisitDate"=>$now);
            $this->model->setLastUserVisitDate(True, $visits);
        };
    };

    foreach($this->categories as $category) { // loop through all Categories
        if ( !$gast or $category->publiccategory ) { // skip non-public categories if viewer is a guest ?>
            <?php if ($category->preamble !== '') echo $category->preamble . "<br>"; // Print Category Preamble, if exists?>
            <table class="eventtable">
                <thead>
                    <tr colspan="7">
                        <caption><h1><?php echo $category->category; ?><h1></caption>
                    </tr>
                    <tr>
                        <th style="width: 50%;"><?php echo JText::_('COM_SCET_EVENT'); ?></th>
                        <th style="width: 20%;"><?php echo JText::_('COM_SCET_RULE'); ?></th>
                        <th style="width:  8%;"><?php echo JText::_('COM_SCET_DATE'); ?></th>
                        <th style="width:  8%;"><?php echo JText::_('COM_SCET_TIME'); ?></th>
                        <th style="width: 10%;"><?php echo JText::_('COM_SCET_LOCATION'); ?></th>
                        <?php if (!$gast) { // print columns only, for registered users ?>
                            <th style="width: 5%;"><?php echo JText::_('COM_SCET_MANDATORY'); ?></th>
                        <?php } // End-If !Gast?>
                        <th style="width:  8%;"><?php echo JText::_('COM_SCET_ICAL_FILE'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!empty($this->events)){
                            foreach($this->events as $event) {             // loop through all Events
                                if ( $event->fk_category == $category->id) { // Check if event is in actual Category
                                    if ( !$gast or $event->publicevent )   { // skip non-public events if viewer is a guest ?>
                                        <tr <?php if ( $event->datum < $now ) echo 'class="HighliteMe_past"'; else if ( $event->datum == $now ) echo 'class="Highlite_today"'; else echo 'class="HighliteMe_future"'; ?> >
                                            <?php
                                            if ( (!$gast) and ($user_lastvisit <= $event->inserted) )
                                            {
                                                $image=$this->baseurl . '/components/com_scet/assets/images/'.$language.'/new.png';
                                                $padding='48px';
                                            } else {
                                                if ( (!$gast) and ($user_lastvisit <= $event->updated) )
                                                {
                                                    $image=$this->baseurl . '/components/com_scet/assets/images/'.$language.'/update.png';
                                                    $padding='48px';
                                                } else {
                                                    $image="";
                                                    $padding='2px';
                                                }
                                            }
                                            $link_ical      = JRoute::_( 'index.php?option=com_scet&task=scet.getICalFile&format=raw&id='.$event->id);
                                            $dl_image       = '<img style=" width:32px; height: 32px;" src="media/com_scet/images/calendar32.png" alt="'.JTEXT::_('COM_SCET_ADD_TO_CALENDAR').'" title="'.JTEXT::_('COM_SCET_ADD_TO_CALENDAR').'"/>';
                                            $ical_imageLink = '<a class="jgrid" href="'.$link_ical.'")" title="'.JText::_('COM_SCET_ADD_TO_CALENDAR').'">'.$dl_image. '</a>';
                                            ?>
                                            <td  class="td_left" style="background-image:url(<?php echo $image;?>);  background-repeat:no-repeat;">
                                                 <span style="padding-left:<?php echo $padding; ?>;"><?php echo sprintf($event->event, $event->iteration); ?></span>
                                            </td>
                                            <td class="td_center"><?php echo $event->rule; ?></td>
                                            <td class="td_center"><?php if ($event->datum) echo JHTML::_('date', $event->datum,  JText::_('COM_SCET_DATE_FORMAT_SCET1'), 'UTC'); ?></td>
                                            <td class="td_center"><?php if ($event->uhrzeit) echo JHTML::_('date', $event->uhrzeit, JText::_('COM_SCET_TIME_FORMAT_SCET1'), 'UTC'); ?></td>
                                            <td class="td_center"><?php echo $event->location; ?></td>
                                                <?php if (!$gast) { // print columns only, if registered user?>
                                                    <td class="td_center"><b><?php if ( 1 == $event->mandatory ) echo "X"; else echo "-"; ?></b></td>
                                                <?php } // End-If !Gast?>
                                            <td class="td_center"><?php echo $ical_imageLink; ?></td>
                                        </tr>
                                <?php
                                    } // End-if Gast-Abfrage
                                } // end-If ($event->FK_Category == $category->id)
                            } //end foreach-Events
                        }?>
                </tbody>
            </table>
            <br><br>    <!-- 2 Extra-Linefeeds to separate the Categories from each other -->
    <?php } // end if-gast for Categories
    } //end foreach-Categories ?>
<br><br>
<center>SCET (Small Community Event Table for Joomla) v<?php echo _SCET_VERSION; ?></center>
<center>Copyright &copy; 2011-<?php echo date('Y', time() )?> by Hanjo Hingsen, Webmaster of  <a href="http://www.treu-zu-kaarst.de">http://www.treu-zu-kaarst.de</a>, All Rights reserved</center>
</div>