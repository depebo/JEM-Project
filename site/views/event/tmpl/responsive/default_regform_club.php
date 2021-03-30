<?php
/**
 * @version 2.1.5
 * @package JEM
 * @copyright (C) 2013-2015 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

//TODO: this is not working - the user list is not showing up in modal form

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidator');

?>

<form class="form-validate" id="JEM" action="<?php echo JRoute::_('index.php?option=com_jem&view=event&id=' . (int)$this->item->id); ?>"  name="adminForm" id="adminForm" method="post">
     <fieldset class="adminform">
        <ul class="adminformlist">
            <li><?php echo $this->form->getLabel('player'); ?> <?php echo $this->form->getInput('player'); ?></li>
            <?php if($this->item->use_tee_time) : ?>
            <li><?php echo $this->form->getLabel('tee_time'); ?> <?php echo $this->form->getInput('tee_time'); ?></li>
            <?php else :?>
            <li><?php echo $this->form->getLabel('preferred_start'); ?> <?php echo $this->form->getInput('preferred_start'); ?></li>
            <?php endif;?>
            <?php if($this->item->twos_fee_amt > 0) : ?>
            <li><?php echo $this->form->getLabel('twos'); ?> <?php echo $this->form->getInput('twos'); ?></li>   
            <?php endif;?>
            <li><?php echo $this->form->getLabel('buggy'); ?> <?php echo $this->form->getInput('buggy'); ?></li>
            <li><?php echo $this->form->getLabel('comment'); ?> <?php echo $this->form->getInput('comment'); ?></li>
            <li><?php echo $this->form->getLabel('guest'); ?> <?php echo $this->form->getInput('guest'); ?></li>
            <ul>
            <li><?php echo $this->form->renderField('guest_name'); ?></li>
            <li><?php echo $this->form->renderField('guest_hcp'); ?></li>
            </ul>
        </ul>
        <?php for($i = 2; $i <= 4; $i++) { ?>
        <a href="#sdm<?php echo($i);?>" data-toggle="collapse">Player <?php echo($i);?></a> 
        <div id="sdm<?php echo($i);?>" class="collapse">
        <ul class="adminformlist">
            <li><?php echo $this->form->getLabel('player'.$i); ?> <?php echo $this->form->getInput('player'.$i); ?></li>
            <?php if($this->item->use_tee_time) : ?>
            <li><?php echo $this->form->getLabel('tee_time'.$i); ?> <?php echo $this->form->getInput('tee_time'.$i); ?></li>
            <?php else :?>
            <li><?php echo $this->form->getLabel('preferred_start'.$i); ?> <?php echo $this->form->getInput('preferred_start'.$i); ?></li>
            <?php endif;?>
            <?php if($this->item->twos_fee_amt > 0) : ?>
            <li><?php echo $this->form->getLabel('twos'.$i); ?> <?php echo $this->form->getInput('twos'.$i); ?></li>
            <?php endif;?>
            <li><?php echo $this->form->getLabel('buggy'.$i); ?> <?php echo $this->form->getInput('buggy'.$i); ?></li>
            <li><?php echo $this->form->getLabel('comment'.$i); ?> <?php echo $this->form->getInput('comment'.$i); ?></li>
            <li><?php echo $this->form->getLabel('guest'.$i); ?> <?php echo $this->form->getInput('guest'.$i); ?></li>
            <ul>
            <li><?php echo $this->form->renderField('guest_name'.$i); ?></li>
            <li><?php echo $this->form->renderField('guest_hcp'.$i); ?></li>
            </ul>
        </ul>
        </div>
        <?php } ?>
    <p>
    <input class="validate btn" type="submit" id="jem_send_attend" name="jem_send_attend" value="<?php echo JText::_('COM_JEM_REGISTER'); ?>" />
    </p>
    <input type="hidden" name="rdid" value="<?php echo $this->item->did; ?>" />
    <input type="hidden" name="task" value="event.userregister" />
    <?php echo JHtml::_('form.token'); ?>
    </fieldset>
</form>
