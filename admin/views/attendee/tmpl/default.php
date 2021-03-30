<?php

/**
 * @version 2.1.7
 * @package JEM
 * @copyright (C) 2013-2016 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

JHtml::_('behavior.modal', 'a.usermodal');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

$selectuser_link = JRoute::_('index.php?option=com_jem&task=attendee.selectuser&tmpl=component');
?>

<script type="text/javascript">
	function modalSelectUser(id, username) {
		$('uid').value = id;
		$('username').value = username;
		window.parent.SqueezeBox.close();
	}

	Joomla.submitbutton = function(task) {
		if (task == 'attendee.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			if (task == 'attendee.cancel' || document.getElementById('adminForm').uid.value != 0) {
				Joomla.submitform(task, document.getElementById('adminForm'));
			} else {
				alert("<?php echo JText::_('COM_JEM_SELECT_AN_USER', true); ?>");
				return false;
			}
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_jem&view=attendee'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="width-100 fltlft">
		<div class="width-100">
			<div class="current">
				<dd class="tabs" style="display: block;">
					<fieldset>
						<legend><?php echo JText::_('COM_JEM_DETAILS'); ?></legend>
						<?php if (!empty($this->row->id)) : ?>
							<p>
								<?php echo JText::_('COM_JEM_EDITATTENDEE_NOTICE'); ?>
							</p>
						<?php endif; ?>

						<ul class="adminformlist">
							<li>
								<label for="eventtitle" <?php echo JemOutput::tooltip(JText::_('COM_JEM_EVENT'), JText::_('COM_JEM_EVENT_DESC')); ?>>
									<?php echo JText::_('COM_JEM_EVENT'); ?>
								</label>
								<input type="text" name="eventtitle" id="eventtitle" readonly="readonly" value="<?php echo !empty($this->row->eventtitle) ? $this->row->eventtitle : '?'; ?>" />
							</li>
							<li>
								<label for="username" <?php echo JemOutput::tooltip(JText::_('COM_JEM_USER'), JText::_('COM_JEM_USER_DESC')); ?>>
									<?php echo JText::_('COM_JEM_USER'); ?>
								</label>
								<input type="text" name="username" id="username" readonly="readonly" value="<?php echo $this->row->username; ?>" />
								<input type="hidden" name="uid" id="uid" value="<?php echo $this->row->uid; ?>" />
								<a class="usermodal" href="<?php echo $selectuser_link; ?>" rel="{handler: 'iframe', size: {x: 800, y: 500}}">
									<span><?php echo JText::_('COM_JEM_SELECT_USER') ?></span>
								</a>
							</li>
							<li>
								<label for="status" <?php echo JemOutput::tooltip(JText::_('COM_JEM_STATUS'), JText::_('COM_JEM_STATUS_DESC')); ?>>
									<?php echo JText::_('COM_JEM_STATUS'); ?>
								</label>
								<?php
								if (empty($this->row->status)) { $this->row->status = 1; }
								$options = array(
									JHtml::_('select.option',  0, JText::_('COM_JEM_ATTENDEES_INVITED')),
									JHtml::_('select.option', -1, JText::_('COM_JEM_ATTENDEES_NOT_ATTENDING')),
									JHtml::_('select.option',  1, JText::_('COM_JEM_ATTENDEES_ATTENDING')),
									JHtml::_('select.option',  2, JText::_('COM_JEM_ATTENDEES_ON_WAITINGLIST'), array('disable' => empty($this->row->waitinglist)))
								);
								echo JHtml::_('select.genericlist', $options, 'status', array('id' => 'reg_status', 'list.select' => $this->row->status));
								?>
							</li>
							<?php if (!empty($this->jemsettings->regallowcomments)) : ?>
								<li>
									<label for="comment" <?php echo JemOutput::tooltip(JText::_('COM_JEM_COMMENT'), JText::_('COM_JEM_COMMENT_DESC')); ?>>
										<?php echo JText::_('COM_JEM_COMMENT'); ?>
									</label>
									<textarea name="comment" id="reg_comment" rows="3" cols="30" maxlength="255"><?php if (!empty($this->row->comment)) {echo $this->row->comment;}?></textarea>
								</li>
							<?php endif; ?>
							<?php
							try {
								echo $this->loadTemplate('clubfields');
							} catch (Exception $e) { }
							?>
							<?php if (1/*!$this->row->id*/) : ?>
								<li>
									<label for="sendemail" <?php echo JemOutput::tooltip(JText::_('COM_JEM_SEND_REGISTRATION_NOTIFICATION_EMAIL'), JText::_('COM_JEM_SEND_REGISTRATION_NOTIFICATION_EMAIL_DESC')); ?>>
										<?php echo JText::_('COM_JEM_SEND_REGISTRATION_NOTIFICATION_EMAIL'); ?>
									</label>
									<input type="checkbox" name="sendemail" value="1" checked="checked" />
								</li>
							<?php endif; ?>
						</ul>
					</fieldset>
				</dd>
			</div>
		</div>
	</div>
	<?php echo JHtml::_('form.token'); ?>
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="event" value="<?php echo ($this->row->event ? $this->row->event : $this->event); ?>" />
	<input type="hidden" name="task" value="" />
</form>